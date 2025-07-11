package com.example.appointment_service.DTO;

import com.example.appointment_service.model.Staff;

public class StaffLoginResponse {
    private String token;
    private Staff user;
    
    public StaffLoginResponse() {}
    
    public StaffLoginResponse(String token, Staff user) {
        this.token = token;
        this.user = user;
    }
    
    public String getToken() {
        return token;
    }
    
    public void setToken(String token) {
        this.token = token;
    }
    
    public Staff getUser() {
        return user;
    }
    
    public void setUser(Staff user) {
        this.user = user;
    }
}
