package com.example.appointment_service.DTO;

import java.time.LocalDateTime;

import lombok.Data;

@Data
public class AppointmentRequest {
    private Long patientId;
    private Long doctorId;
    private LocalDateTime appointmentTime;
    private Long serviceId;
    private String reason;
}