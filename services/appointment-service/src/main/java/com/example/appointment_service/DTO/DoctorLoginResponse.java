package com.example.appointment_service.DTO;

import com.example.appointment_service.model.Doctor;

public class DoctorLoginResponse {
    private String token;
    private Doctor doctor;
    
    public DoctorLoginResponse() {}
    
    public DoctorLoginResponse(String token, Doctor doctor) {
        this.token = token;
        this.doctor = doctor;
    }
    
    public String getToken() {
        return token;
    }
    
    public void setToken(String token) {
        this.token = token;
    }
    
    public Doctor getDoctor() {
        return doctor;
    }
    
    public void setDoctor(Doctor doctor) {
        this.doctor = doctor;
    }
}
