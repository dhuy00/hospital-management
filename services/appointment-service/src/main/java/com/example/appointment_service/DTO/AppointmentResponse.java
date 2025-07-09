package com.example.appointment_service.DTO;

import java.time.LocalDateTime;
import java.util.List;

import com.example.appointment_service.model.AppointmentStatus;

import lombok.Data;

@Data
public class AppointmentResponse {
    private Long id;
    private Long patientId;
    private Long doctorId;
    private LocalDateTime appointmentTime;
    private List<Long> serviceIds; // Changed to support multiple services
    private List<String> serviceNames; // Service names for better UX
    private AppointmentStatus status;
    private String reason;
    private LocalDateTime createdAt;
    private LocalDateTime updatedAt;
    
    // Optional: include related entity names for better UX
    private String doctorName;
}
