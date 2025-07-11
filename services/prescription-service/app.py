from flask import Flask, request, jsonify, make_response
import psycopg2
from rabbitmq_sender import send_prescription_message

app = Flask(__name__)
app.config['JSON_AS_ASCII'] = False

conn = psycopg2.connect(
    dbname="prescription_db",
    user="postgres",
    password="123",
    host="localhost",
    port="5432"
)

@app.route("/api/prescriptions", methods=["POST"])
def add_prescription():
    data = request.get_json()
    cur = conn.cursor()

    cur.execute("""
        INSERT INTO prescriptions (patient_id, status)
        VALUES (%s, %s) RETURNING id
    """, (data['patient_id'], data.get('status', 'chưa lấy')))
    prescription_id = cur.fetchone()[0]

    for med in data['medicines']:
        cur.execute("""
            INSERT INTO prescription_details (prescription_id, medicine_name, dosage, instructions)
            VALUES (%s, %s, %s, %s)
        """, (prescription_id, med['medicine_name'], med['dosage'], med['instructions']))

    conn.commit()
    cur.close()
    # Chuẩn bị dữ liệu gửi RabbitMQ
    message = {
     "patient_id": data['patient_id'],
      "prescription_id": prescription_id,
      "status": data.get('status', 'chưa lấy'),
     "message": "Đơn thuốc mới đã được tạo"
    }
    send_prescription_message(message)

    return jsonify({"message": "Prescription created", "prescription_id": prescription_id})


@app.route("/api/prescriptions", methods=["GET"])
def get_all_prescriptions():
    cur = conn.cursor()

    cur.execute("""
        SELECT p.id, p.patient_id, p.status, p.created_at,
               d.medicine_name, d.dosage, d.instructions
        FROM prescriptions p
        JOIN prescription_details d ON p.id = d.prescription_id
        ORDER BY p.id
    """)
    rows = cur.fetchall()
    cur.close()

    prescriptions = {}
    for row in rows:
        pid = row[0]
        if pid not in prescriptions:
            prescriptions[pid] = {
                "prescription_id": pid,
                "patient_id": row[1],
                "status": row[2],
                "created_at": row[3],
                "medicines": []
            }
        prescriptions[pid]["medicines"].append({
            "medicine_name": row[4],
            "dosage": row[5],
            "instructions": row[6]
        })

    return jsonify(list(prescriptions.values()))


@app.route("/api/prescriptions/<int:id>", methods=["GET"])
def get_prescription_by_id(id):
    cur = conn.cursor()

    cur.execute("""
        SELECT p.id, p.patient_id, pa.name, p.status, p.created_at
        FROM prescriptions p
        JOIN patients pa ON p.patient_id = pa.id
        WHERE p.id = %s
    """, (id,))
    prescription_row = cur.fetchone()

    if not prescription_row:
        return jsonify({"error": "Prescription not found"}), 404

    cur.execute("""
        SELECT medicine_name, dosage, instructions
        FROM prescription_details
        WHERE prescription_id = %s
    """, (id,))
    medicine_rows = cur.fetchall()
    cur.close()

    result = {
        "prescription_id": prescription_row[0],
        "patient_id": prescription_row[1],
        "patient_name": prescription_row[2],
        "status": prescription_row[3],
        "created_at": prescription_row[4],
        "medicines": [
            {
                "medicine_name": m[0],
                "dosage": m[1],
                "instructions": m[2]
            }
            for m in medicine_rows
        ]
    }

    return jsonify(result)

@app.route("/api/prescriptions/patient/<int:patient_id>", methods=["GET"])
def get_prescriptions_by_patient_id(patient_id):
    cur = conn.cursor()

    # Lấy tất cả đơn thuốc của bệnh nhân
    cur.execute("""
        SELECT p.id, p.patient_id, p.status, p.created_at,
               d.medicine_name, d.dosage, d.instructions
        FROM prescriptions p
        LEFT JOIN prescription_details d ON p.id = d.prescription_id
        WHERE p.patient_id = %s
        ORDER BY p.id
    """, (patient_id,))
    rows = cur.fetchall()
    cur.close()

    if not rows:
        return jsonify({"error": "No prescriptions found for this patient"}), 404

    prescriptions = {}
    for row in rows:
        pid = row[0]
        if pid not in prescriptions:
            prescriptions[pid] = {
                "prescription_id": pid,
                "patient_id": row[1],
                "status": row[2],
                "created_at": row[3],
                "medicines": []
            }
        if row[4]:
            prescriptions[pid]["medicines"].append({
                "medicine_name": row[4],
                "dosage": row[5],
                "instructions": row[6]
            })

    return jsonify(list(prescriptions.values()))


@app.route("/api/prescriptions/<int:id>", methods=["PUT"])
def update_prescription(id):
    data = request.get_json()
    cur = conn.cursor()

    cur.execute("""
        UPDATE prescriptions
        SET patient_id = %s,
            status = %s
        WHERE id = %s
    """, (data['patient_id'], data['status'], id))

    cur.execute("""
        DELETE FROM prescription_details
        WHERE prescription_id = %s
    """, (id,))

    for med in data['medicines']:
        cur.execute("""
            INSERT INTO prescription_details (prescription_id, medicine_name, dosage, instructions)
            VALUES (%s, %s, %s, %s)
        """, (id, med['medicine_name'], med['dosage'], med['instructions']))

    conn.commit()
    cur.close()
    return jsonify({"message": "Prescription updated successfully."})


@app.route("/api/prescriptions/<int:id>", methods=["DELETE"])
def delete_prescription(id):
    cur = conn.cursor()
    cur.execute("DELETE FROM prescriptions WHERE id = %s", (id,))
    conn.commit()
    cur.close()
    return jsonify({"message": "Prescription deleted."})

if __name__ == "__main__":
    app.run(debug=True)
