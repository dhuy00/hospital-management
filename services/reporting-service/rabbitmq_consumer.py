import pika
import json

def callback(ch, method, properties, body):
    data = json.loads(body)
    print(f"📥 [REPORTING] Nhận message từ {method.routing_key}:")
    print(json.dumps(data, indent=2))
    
    # có thể insert vào PostgreSQL nếu muốn

def start_listening():
    connection = pika.BlockingConnection(pika.ConnectionParameters("localhost"))
    channel = connection.channel()

    # Khai báo exchange
    channel.exchange_declare(exchange="hospital.direct", exchange_type="direct")

    # Đăng ký queue + routing key
    queues = {
        "appointment.notification": "appointment.notify",
        "prescription.notification": "prescription.notify"
    }

    for queue_name, routing_key in queues.items():
        channel.queue_declare(queue=queue_name, durable=True)
        channel.queue_bind(exchange="hospital.direct", queue=queue_name, routing_key=routing_key)
        channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)

    print("🟢 [REPORTING] Đang lắng nghe RabbitMQ...")
    channel.start_consuming()
