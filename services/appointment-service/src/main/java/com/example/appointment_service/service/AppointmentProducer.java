package com.example.appointment_service.service;

import com.example.appointment_service.config.RabbitMQConfig;
import com.example.appointment_service.DTO.AppointmentMessage;
import org.springframework.amqp.rabbit.core.RabbitTemplate;
import org.springframework.stereotype.Service;

@Service
public class AppointmentProducer {

    private final RabbitTemplate rabbitTemplate;

    public AppointmentProducer(RabbitTemplate rabbitTemplate) {
        this.rabbitTemplate = rabbitTemplate;
    }

    public void send(AppointmentMessage message) {
        rabbitTemplate.convertAndSend(
                RabbitMQConfig.EXCHANGE,
                RabbitMQConfig.ROUTING_KEY,
                message
        );
        System.out.println("📤 Sent message to RabbitMQ: " + message);
    }
}
