package com.example.controller;

// package: com.example.patientservice.controller

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestHeader;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.example.DTO.LoginRequest;
import com.example.DTO.PatientProfile;
import com.example.DTO.RegisterRequest;
import com.example.model.Patient;
import com.example.security.JwtUtil;
import com.example.service.AuthorizationService;
import com.example.service.PatientService;


@RestController
@RequestMapping("/api/patients")
public class PatientController {

    @Autowired
    private PatientService service;

	@Autowired
	private JwtUtil jwtUtil;

	@Autowired
	private AuthorizationService authorizationService;

    @PostMapping("/register")
    public ResponseEntity<?> register(@RequestBody RegisterRequest request) {
        try {
            System.out.println("Received registration request: " + request.email);
			Patient p = service.register(request);
			String token = jwtUtil.generateToken(p.getEmail());
			return ResponseEntity.ok(token);
		} catch (RuntimeException e) {
			return ResponseEntity.status(400).body(e.getMessage());
		}
    }

	@PostMapping("/login")
	public ResponseEntity<?> login(@RequestBody LoginRequest request) {
		try {
			Patient p = service.authenticate(request.email, request.password);
			String token = jwtUtil.generateToken(p.getEmail());
			return ResponseEntity.ok(token);
		} catch (RuntimeException e) {
			return ResponseEntity.status(401).body("Invalid credentials");
		}
	}


    @GetMapping("/{id}")
    public ResponseEntity<?> getProfile(@PathVariable Long id, @RequestHeader("Authorization") String token) {
        try {

            String jwtToken = token.replace("Bearer ", "");
            String email = jwtUtil.getEmailFromToken(jwtToken);
            

            Patient patient = service.getPatientById(id);
            
            boolean isStaffOrDoctor = authorizationService.isStaffOrDoctor(email);
            boolean isOwnProfile = patient.getEmail().equals(email);
            
            if (!isStaffOrDoctor && !isOwnProfile) {
                return ResponseEntity.status(403).body("Access denied. You can only view your own profile.");
            }
            
            return ResponseEntity.ok(patient);
        } catch (RuntimeException e) {
            return ResponseEntity.status(404).body("Patient not found");
        } catch (Exception e) {
            return ResponseEntity.status(500).body("Error retrieving patient: " + e.getMessage());
        }
    }

	@GetMapping("/")
	public ResponseEntity<?> getAllPatients(@RequestHeader("Authorization") String token) {
		try {
			String jwtToken = token.replace("Bearer ", "");
			String email = jwtUtil.getEmailFromToken(jwtToken);
			
			if (!authorizationService.isStaffOrDoctor(email)) {
				return ResponseEntity.status(403).body("Access denied. Only staff and doctors can access all patient information.");
			}
			
			return ResponseEntity.ok(service.getAllPatients());
		} catch (Exception e) {
			return ResponseEntity.status(500).body("Error retrieving patients: " + e.getMessage());
		}
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Long id, @RequestBody PatientProfile profile, @RequestHeader("Authorization") String token) {
        try {
            String jwtToken = token.replace("Bearer ", "");
            String email = jwtUtil.getEmailFromToken(jwtToken);
            
            Patient existingPatient = service.getPatientById(id);
            
            boolean isStaffOrDoctor = authorizationService.isStaffOrDoctor(email);
            boolean isOwnProfile = existingPatient.getEmail().equals(email);
            
            if (!isStaffOrDoctor && !isOwnProfile) {
                return ResponseEntity.status(403).body("Access denied. You can only update your own profile.");
            }
            
            Patient updatedPatient = service.updateProfile(id, profile);
            return ResponseEntity.ok(updatedPatient);
        } catch (RuntimeException e) {
            return ResponseEntity.status(400).body("Error updating patient: " + e.getMessage());
        } catch (Exception e) {
            return ResponseEntity.status(500).body("Error updating patient: " + e.getMessage());
        }
    }


}

