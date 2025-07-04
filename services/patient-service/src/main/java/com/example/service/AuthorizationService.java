package com.example.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.client.RestTemplate;

@Service
public class AuthorizationService {

    @Autowired
    private RestTemplate restTemplate;

    public boolean isStaffOrDoctor(String email) {
        try {
            // Check if user is staff
            ResponseEntity<Void> staffResponse = restTemplate.getForEntity(
                "http://localhost:8082/api/staff/check-email/" + email, Void.class);
            
            if (staffResponse.getStatusCode().is2xxSuccessful()) {
                return true;
            }
        } catch (Exception e) {
        }

        try {
            // Check if user is doctor
            ResponseEntity<Void> doctorResponse = restTemplate.getForEntity(
                "http://localhost:8082/api/doctors/check-email/" + email, Void.class);
            
            return doctorResponse.getStatusCode().is2xxSuccessful();
        } catch (Exception e) {
            return false;
        }
    }
}
