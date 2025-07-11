package com.example.appointment_service.service;

import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import com.example.appointment_service.DTO.DoctorLoginResponse;
import com.example.appointment_service.DTO.LoginRequest;
import com.example.appointment_service.DTO.StaffLoginResponse;
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

    public DoctorLoginResponse authenticateDoctor(LoginRequest request) {
        Optional<Doctor> doctorOpt = doctorRepository.findByEmail(request.email);
        
        if (doctorOpt.isEmpty()) {
            throw new RuntimeException("Doctor not found");
        }
        
        Doctor doctor = doctorOpt.get();
        if (!passwordEncoder.matches(request.password, doctor.getPasswordHash())) {
            throw new RuntimeException("Invalid password");
        }
        
        String token = jwtUtil.generateToken(doctor.getEmail());
        
        // Clear password hash before returning
        Doctor doctorResponse = new Doctor();
        doctorResponse.setId(doctor.getId());
        doctorResponse.setEmail(doctor.getEmail());
        doctorResponse.setFullName(doctor.getFullName());
        doctorResponse.setPhone(doctor.getPhone());
        doctorResponse.setDepartment(doctor.getDepartment());
        doctorResponse.setDateOfBirth(doctor.getDateOfBirth());
        doctorResponse.setGender(doctor.getGender());
        doctorResponse.setAddress(doctor.getAddress());
        doctorResponse.setCreatedAt(doctor.getCreatedAt());
        doctorResponse.setUpdatedAt(doctor.getUpdatedAt());
        // passwordHash is intentionally not set for security
        
        return new DoctorLoginResponse(token, doctorResponse);
    }

    public StaffLoginResponse authenticateStaff(LoginRequest request) {
        Optional<Staff> staffOpt = staffRepository.findByEmail(request.email);
        
        if (staffOpt.isEmpty()) {
            throw new RuntimeException("Staff not found");
        }
        
        Staff staff = staffOpt.get();
        if (!passwordEncoder.matches(request.password, staff.getPasswordHash())) {
            throw new RuntimeException("Invalid password");
        }
        
        String token = jwtUtil.generateToken(staff.getEmail());
        
        // Clear password hash before returning
        Staff staffResponse = new Staff();
        staffResponse.setId(staff.getId());
        staffResponse.setEmail(staff.getEmail());
        staffResponse.setFullName(staff.getFullName());
        staffResponse.setPhone(staff.getPhone());
        staffResponse.setPosition(staff.getPosition());
        staffResponse.setDateOfBirth(staff.getDateOfBirth());
        staffResponse.setGender(staff.getGender());
        staffResponse.setAddress(staff.getAddress());
        staffResponse.setCreatedAt(staff.getCreatedAt());
        staffResponse.setUpdatedAt(staff.getUpdatedAt());
        // passwordHash is intentionally not set for security
        
        return new StaffLoginResponse(token, staffResponse);
    }
}
