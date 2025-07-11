package com.example.appointment_service.DTO;

import com.example.appointment_service.model.Doctor;

public class DoctorLoginResponse {
    private String token;
    private Doctor user;
    
    public DoctorLoginResponse() {}
    
    public DoctorLoginResponse(String token, Doctor user) {
        this.token = token;
        this.user = user;
    }
    
    public String getToken() {
        return token;
    }
    
    public void setToken(String token) {
        this.token = token;
    }
    
    public Doctor getUser() {
        return user;
    }
    
    public void setUser(Doctor user) {
        this.user = user;
    }
}
