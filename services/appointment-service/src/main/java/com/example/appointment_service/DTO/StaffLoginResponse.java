package com.example.appointment_service.DTO;

import com.example.appointment_service.model.Staff;

public class StaffLoginResponse {
    private String token;
    private Staff staff;
    
    public StaffLoginResponse() {}
    
    public StaffLoginResponse(String token, Staff staff) {
        this.token = token;
        this.staff = staff;
    }
    
    public String getToken() {
        return token;
    }
    
    public void setToken(String token) {
        this.token = token;
    }
    
    public Staff getStaff() {
        return staff;
    }
    
    public void setStaff(Staff staff) {
        this.staff = staff;
    }
}
