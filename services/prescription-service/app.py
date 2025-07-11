from flask import Flask, request, jsonify
import psycopg2

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
        INSERT INTO prescriptions (appointment_id, status)
        VALUES (%s, %s) RETURNING id
    """, (data['appointment_id'], data.get('status', 'chưa lấy')))
    prescription_id = cur.fetchone()[0]

    for med in data['medicines']:
        cur.execute("""
            INSERT INTO prescription_details (prescription_id, medicine_name, dosage, instructions)
            VALUES (%s, %s, %s, %s)
        """, (prescription_id, med['medicine_name'], med['dosage'], med['instructions']))

    conn.commit()
    cur.close()
    return jsonify({"message": "Prescription created", "prescription_id": prescription_id})


@app.route("/api/prescriptions", methods=["GET"])
def get_all_prescriptions():
    cur = conn.cursor()

    cur.execute("""
        SELECT p.id, p.appointment_id, p.status, p.created_at,
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
                "appointment_id": row[1],
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
        SELECT p.id, p.appointment_id, a.patient_id, p.status, p.created_at
        FROM prescriptions p
        JOIN appointments a ON p.appointment_id = a.id
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
        "appointment_id": prescription_row[1],
        "patient_id": prescription_row[2],
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


@app.route("/api/prescriptions/appointment/<int:appointment_id>", methods=["GET"])
def get_prescriptions_by_appointment_id(appointment_id):
    cur = conn.cursor()

    cur.execute("""
        SELECT p.id, p.appointment_id, p.status, p.created_at,
               d.medicine_name, d.dosage, d.instructions
        FROM prescriptions p
        LEFT JOIN prescription_details d ON p.id = d.prescription_id
        WHERE p.appointment_id = %s
        ORDER BY p.id
    """, (appointment_id,))
    rows = cur.fetchall()
    cur.close()

    if not rows:
        return jsonify({"error": "No prescriptions found for this appointment"}), 404

    prescriptions = {}
    for row in rows:
        pid = row[0]
        if pid not in prescriptions:
            prescriptions[pid] = {
                "prescription_id": pid,
                "appointment_id": row[1],
                "status": row[2],
                "created_at": row[3],
                "medicines": []
            }
        if row[4]:  # Nếu có thuốc
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
        SET appointment_id = %s,
            status = %s
        WHERE id = %s
    """, (data['appointment_id'], data['status'], id))

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
    app.run(port=5000, debug=True)
