from flask import Flask, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app) 

@app.route('/api/patients', methods=['GET'])
def get_patients():
    return jsonify([
        {"id": 1, "name": "Nguyễn Văn A", "phone": "0909123456"},
        {"id": 2, "name": "Trần Thị B", "phone": "0911123456"},
        {"id": 3, "name": "Lê Văn C", "phone": "0932123456"}
    ])

if __name__ == '__main__':
    app.run(port=8001, debug=True)
