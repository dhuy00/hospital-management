package com.example.appointment_service.DTO;
import java.io.Serializable;

public class AppointmentMessage implements Serializable {
    private Long patientId;
    private String time;
    private String note;

    public AppointmentMessage() {}

    public AppointmentMessage(Long patientId, String time, String note) {
        this.patientId = patientId;
        this.time = time;
        this.note = note;
    }

    // Getters and Setters

    @Override
    public String toString() {
        return "AppointmentMessage{" +
                "patientId=" + patientId +
                ", time='" + time + '\'' +
                ", note='" + note + '\'' +
                '}';
    }
}
