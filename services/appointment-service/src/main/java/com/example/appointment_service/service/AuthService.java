package com.example.appointment_service.service;

import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import com.example.appointment_service.DTO.LoginRequest;
import com.example.appointment_service.model.Doctor;
import com.example.appointment_service.model.Staff;
import com.example.appointment_service.repository.DoctorRepository;
import com.example.appointment_service.repository.StaffRepository;
import com.example.appointment_service.security.JwtUtil;

@Service
public class AuthService {

    @Autowired
    private DoctorRepository doctorRepository;

    @Autowired
    private StaffRepository staffRepository;

    @Autowired
    private PasswordEncoder passwordEncoder;

    @Autowired
    private JwtUtil jwtUtil;

    public String authenticateDoctor(LoginRequest request) {
        Optional<Doctor> doctorOpt = doctorRepository.findByEmail(request.email);
        
        if (doctorOpt.isEmpty()) {
            throw new RuntimeException("Doctor not found");
        }
        
        Doctor doctor = doctorOpt.get();
        if (!passwordEncoder.matches(request.password, doctor.getPasswordHash())) {
            throw new RuntimeException("Invalid password");
        }
        
        return jwtUtil.generateToken(doctor.getEmail());
    }

    public String authenticateStaff(LoginRequest request) {
        Optional<Staff> staffOpt = staffRepository.findByEmail(request.email);
        
        if (staffOpt.isEmpty()) {
            throw new RuntimeException("Staff not found");
        }
        
        Staff staff = staffOpt.get();
        if (!passwordEncoder.matches(request.password, staff.getPasswordHash())) {
            throw new RuntimeException("Invalid password");
        }
        
        return jwtUtil.generateToken(staff.getEmail());
    }
}
