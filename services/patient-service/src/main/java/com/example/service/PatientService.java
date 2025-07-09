package com.example.service;

// package: com.example.patientservice.service

import java.time.LocalDateTime;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import com.example.DTO.PatientProfile;
import com.example.DTO.RegisterRequest;
import com.example.model.Patient;
import com.example.repository.PatientRepository;


@Service
public class PatientService {

    @Autowired
    private PatientRepository patientRepository;

    @Autowired
    private PasswordEncoder passwordEncoder;

    public Patient register(RegisterRequest request) {
        if (patientRepository.findByEmail(request.email).isPresent()) {
            throw new RuntimeException("Email already registered");
        }

        Patient p = new Patient();
        p.setEmail(request.email);
        p.setPasswordHash(passwordEncoder.encode(request.password));
        p.setFullName(request.fullName);
        p.setPhone(request.phone);
        p.setDateOfBirth(request.dateOfBirth);
        p.setGender(request.gender);
        p.setAddress(request.address);
        
        // Set medical information fields (optional during registration)
        p.setBloodType(request.bloodType);
        p.setChronicDiseases(request.chronicDiseases);
        p.setAllergies(request.allergies);
        p.setMedications(request.medications);
        p.setEmergencyContactName(request.emergencyContactName);
        p.setEmergencyContactPhone(request.emergencyContactPhone);
        p.setInsuranceNumber(request.insuranceNumber);
        p.setOccupation(request.occupation);
        
        p.setCreatedAt(LocalDateTime.now());
        p.setUpdatedAt(LocalDateTime.now());
        return patientRepository.save(p);
    }

    public Patient authenticate(String email, String rawPassword) {
        Patient p = patientRepository.findByEmail(email)
                .orElseThrow(() -> new RuntimeException("User not found"));
        if (!passwordEncoder.matches(rawPassword, p.getPasswordHash())) {
            throw new RuntimeException("Invalid password");
        }
        return p;
    }

    public Patient getPatientById(Long id) {
        return patientRepository.findById(id).orElseThrow();
    }

    public List<Patient> getAllPatients() {
        return patientRepository.findAll();
    }

    public Patient updateProfile(Long id, PatientProfile profile) {
        Patient p = getPatientById(id);
        p.setFullName(profile.fullName);
        p.setPhone(profile.phone);
        p.setGender(profile.gender);
        p.setDateOfBirth(profile.dateOfBirth);
        p.setAddress(profile.address);
        
        // Update medical information fields
        p.setBloodType(profile.bloodType);
        p.setChronicDiseases(profile.chronicDiseases);
        p.setAllergies(profile.allergies);
        p.setMedications(profile.medications);
        p.setEmergencyContactName(profile.emergencyContactName);
        p.setEmergencyContactPhone(profile.emergencyContactPhone);
        p.setInsuranceNumber(profile.insuranceNumber);
        p.setOccupation(profile.occupation);
        
        p.setUpdatedAt(LocalDateTime.now());
        return patientRepository.save(p);
    }
}

