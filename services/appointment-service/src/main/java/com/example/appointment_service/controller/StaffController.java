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
import com.example.appointment_service.DTO.StaffLoginResponse;
import com.example.appointment_service.model.Staff;
import com.example.appointment_service.repository.StaffRepository;
import com.example.appointment_service.service.AuthService;

@RestController
@RequestMapping("/api/staff")
public class StaffController {

    @Autowired
    private StaffRepository staffRepository;

    @Autowired
    private AuthService authService;

    @PostMapping("/login")
    public ResponseEntity<?> login(@RequestBody LoginRequest request) {
        try {
            StaffLoginResponse response = authService.authenticateStaff(request);
            return ResponseEntity.ok(response);
        } catch (RuntimeException e) {
            return ResponseEntity.status(401).body("Invalid credentials");
        }
    }

    @GetMapping
    public List<Staff> getAllStaff() {
        return staffRepository.findAll();
    }

    @GetMapping("/{id}")
    public Staff getStaffById(@PathVariable Long id) {
        return staffRepository.findById(id).orElseThrow();
    }

    @GetMapping("/position/{position}")
    public List<Staff> getStaffByPosition(@PathVariable String position) {
        return staffRepository.findByPosition(position);
    }

    @GetMapping("/search")
    public List<Staff> searchStaff(@RequestParam String name) {
        return staffRepository.findByFullNameContainingIgnoreCase(name);
    }

    @GetMapping("/check-email/{email}")
    public ResponseEntity<Void> checkEmailExists(@PathVariable String email) {
        return staffRepository.findByEmail(email).isPresent() 
            ? ResponseEntity.ok().build() 
            : ResponseEntity.notFound().build();
    }

    @PostMapping
    public Staff createStaff(@RequestBody Staff staff) {
        return staffRepository.save(staff);
    }

    @PutMapping("/{id}")
    public Staff updateStaff(@PathVariable Long id, @RequestBody Staff staff) {
        staff.setId(id);
        return staffRepository.save(staff);
    }

    @DeleteMapping("/{id}")
    public void deleteStaff(@PathVariable Long id) {
        staffRepository.deleteById(id);
    }
}
