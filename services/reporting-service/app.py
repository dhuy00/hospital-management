from flask import Flask, request, jsonify
import psycopg2
from threading import Thread
from rabbitmq_consumer import start_listening


app = Flask(__name__)

conn = psycopg2.connect(
    dbname="hospital_db",
    user="postgres",
    password="postgres",
    host="localhost",
    port="5432"
)

@app.route("/api/reports", methods=["GET"])
def get_report():
    cur = conn.cursor()
    cur.execute("SELECT * FROM prescription_reports ORDER BY report_date DESC")
    rows = cur.fetchall()
    cur.close()

    results = [
        {
            "report_id": row[0],
            "report_date": row[1],
            "total_prescriptions": row[2]
        }
        for row in rows
    ]
    return jsonify(results)


@app.route("/api/reports", methods=["POST"])
def create_report():
    cur = conn.cursor()
    cur.execute("""
        INSERT INTO prescription_reports (report_date, total_prescriptions)
        SELECT CURRENT_TIMESTAMP,
               COUNT(*)
        FROM prescriptions
        WHERE created_at::date = CURRENT_DATE;
    """)
    conn.commit()
    cur.close()
    return jsonify({"message": "Report created successfully."})

@app.route("/api/reports/<int:id>", methods=["GET"])
def get_report_by_id(id):
    cur = conn.cursor()
    cur.execute("SELECT * FROM prescription_reports WHERE id = %s", (id,))
    row = cur.fetchone()
    cur.close()

    if row:
        result = {
            "report_id": row[0],
            "report_date": row[1],
            "total_prescriptions": row[2]
        }
        return jsonify(result)
    else:
        return jsonify({"error": "Report not found"}), 404

@app.route("/api/reports/<int:id>", methods=["DELETE"])
def delete_report(id):
    cur = conn.cursor()
    cur.execute("DELETE FROM prescription_reports WHERE id = %s", (id,))
    conn.commit()
    cur.close()
    return jsonify({"message": "Report deleted."})

@app.route("/api/reports/patient/<string:patient_name>", methods=["GET"])
def get_prescriptions_by_patient(patient_name):
    cur = conn.cursor()
    cur.execute("""
        SELECT p.id, p.patient_id, pa.name, p.status, p.created_at
        FROM prescriptions p
        JOIN patients pa ON p.patient_id = pa.id
        WHERE pa.name ILIKE %s
    """, (f"%{patient_name}%",))
    results = cur.fetchall()
    cur.close()

    response = [
        {
            "prescription_id": row[0],
            "patient_id": row[1],
            "patient_name": row[2],
            "status": row[3],
            "created_at": row[4]
        }
        for row in results
    ]
    return jsonify(response)

@app.route("/api/reports/patients-per-month", methods=["GET"])
def get_patients_per_month():
    cur = conn.cursor()
    cur.execute("""
        SELECT 
            TO_CHAR(DATE_TRUNC('month', created_at), 'YYYY-MM') AS month,
            COUNT(DISTINCT id) AS total_patients
        FROM patients
        GROUP BY month
        ORDER BY month DESC
    """)
    results = cur.fetchall()
    cur.close()

    response = [
        {
            "month": row[0],
            "total_patients": row[1]
        }
        for row in results
    ]
    return jsonify(response)

if __name__ == "__main__":
    # Chạy RabbitMQ consumer song song với Flask
    t = Thread(target=start_listening)
    t.daemon = True
    t.start()

    app.run(port=5001, debug=True)
