package com.example.appointment_service.DTO;

import java.time.LocalDateTime;
import java.util.List;

import lombok.Data;

@Data
public class AppointmentRequest {
    private Long patientId;
    private Long doctorId;
    private LocalDateTime appointmentTime;
    private List<Long> serviceIds; // Changed to support multiple services
    private String reason;
}