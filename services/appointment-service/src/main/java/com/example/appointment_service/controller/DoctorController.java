package com.example.appointment_service.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.example.appointment_service.DTO.LoginRequest;
import com.example.appointment_service.model.Doctor;
import com.example.appointment_service.repository.DoctorRepository;
import com.example.appointment_service.service.AuthService;

@RestController
@RequestMapping("/api/doctors")
public class DoctorController {

    @Autowired
    private DoctorRepository doctorRepository;

    @Autowired
    private AuthService authService;

    @PostMapping("/login")
    public ResponseEntity<?> login(@RequestBody LoginRequest request) {
        try {
            String token = authService.authenticateDoctor(request);
            return ResponseEntity.ok(token);
        } catch (RuntimeException e) {
            return ResponseEntity.status(401).body("Invalid credentials");
        }
    }

    @GetMapping
    public List<Doctor> getAllDoctors() {
        return doctorRepository.findAll();
    }

    @GetMapping("/{id}")
    public Doctor getDoctorById(@PathVariable Long id) {
        return doctorRepository.findById(id).orElseThrow();
    }

    @GetMapping("/department/{department}")
    public List<Doctor> getDoctorsByDepartment(@PathVariable String department) {
        return doctorRepository.findByDepartment(department);
    }

    @GetMapping("/search")
    public List<Doctor> searchDoctors(@RequestParam String name) {
        return doctorRepository.findByFullNameContainingIgnoreCase(name);
    }

    @GetMapping("/check-email/{email}")
    public ResponseEntity<Void> checkEmailExists(@PathVariable String email) {
        return doctorRepository.findByEmail(email).isPresent() 
            ? ResponseEntity.ok().build() 
            : ResponseEntity.notFound().build();
    }

    @PostMapping
    public Doctor createDoctor(@RequestBody Doctor doctor) {
        return doctorRepository.save(doctor);
    }

    @PutMapping("/{id}")
    public Doctor updateDoctor(@PathVariable Long id, @RequestBody Doctor doctor) {
        doctor.setId(id);
        return doctorRepository.save(doctor);
    }

    @DeleteMapping("/{id}")
    public void deleteDoctor(@PathVariable Long id) {
        doctorRepository.deleteById(id);
    }
}
