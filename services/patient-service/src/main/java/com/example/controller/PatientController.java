package com.example.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import com.example.DTO.LoginRequest;
import com.example.DTO.PatientProfile;
import com.example.DTO.RegisterRequest;
import com.example.model.Patient;
import com.example.service.PatientService;

@RestController
@RequestMapping("/api/patients")
public class PatientController {

    @Autowired
    private PatientService service;

    @PostMapping("/register")
    public ResponseEntity<?> register(@RequestBody RegisterRequest request) {
        try {
            System.out.println("Received registration request: " + request.email);
            Patient p = service.register(request);
            return ResponseEntity.ok(p);
        } catch (RuntimeException e) {
            return ResponseEntity.status(400).body(e.getMessage());
        }
    }

    @PostMapping("/login")
    public ResponseEntity<?> login(@RequestBody LoginRequest request) {
        try {
            Patient p = service.authenticate(request.email, request.password);
            return ResponseEntity.ok(p);
        } catch (RuntimeException e) {
            return ResponseEntity.status(401).body("Invalid credentials");
        }
    }

    @GetMapping("/{id}")
    public ResponseEntity<?> getProfile(@PathVariable Long id) {
        try {
            Patient patient = service.getPatientById(id);
            return ResponseEntity.ok(patient);
        } catch (RuntimeException e) {
            return ResponseEntity.status(404).body("Patient not found");
        } catch (Exception e) {
            return ResponseEntity.status(500).body("Error retrieving patient: " + e.getMessage());
        }
    }

    @GetMapping("/")
    public ResponseEntity<?> getAllPatients() {
        try {
            return ResponseEntity.ok(service.getAllPatients());
        } catch (Exception e) {
            return ResponseEntity.status(500).body("Error retrieving patients: " + e.getMessage());
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Long id, @RequestBody PatientProfile profile) {
        try {
            Patient updatedPatient = service.updateProfile(id, profile);
            return ResponseEntity.ok(updatedPatient);
        } catch (RuntimeException e) {
            return ResponseEntity.status(400).body("Error updating patient: " + e.getMessage());
        } catch (Exception e) {
            return ResponseEntity.status(500).body("Error updating patient: " + e.getMessage());
        }
    }

}
