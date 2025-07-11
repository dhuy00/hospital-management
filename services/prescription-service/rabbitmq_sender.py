import pika
import json

def send_prescription_message(data):
    connection = pika.BlockingConnection(pika.ConnectionParameters('localhost'))
    channel = connection.channel()

    channel.exchange_declare(exchange='hospital.direct', exchange_type='direct')

    channel.basic_publish(
        exchange='hospital.direct',
        routing_key='prescription.notify',
        body=json.dumps(data)
    )

    print("📤 Sent prescription message:", data)
    connection.close()
