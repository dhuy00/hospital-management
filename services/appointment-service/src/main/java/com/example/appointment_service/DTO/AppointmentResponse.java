package com.example.appointment_service.DTO;

import java.time.LocalDateTime;

import com.example.appointment_service.model.AppointmentStatus;

import lombok.Data;

@Data
public class AppointmentResponse {
    private Long id;
    private Long patientId;
    private Long doctorId;
    private LocalDateTime appointmentTime;
    private Long serviceId;
    private AppointmentStatus status;
    private String reason;
    private LocalDateTime createdAt;
    private LocalDateTime updatedAt;
    
    // Optional: include related entity names for better UX
    private String doctorName;
    private String serviceName;
}
