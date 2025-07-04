package com.example.auth_service.controller;

import com.example.auth_service.dto.AuthResponseDto;
import com.example.auth_service.dto.LoginRequestDto;
import com.example.auth_service.dto.RegisterRequestDto;
import com.example.auth_service.dto.UserInfoDto;
import com.example.auth_service.service.AuthService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import jakarta.validation.Valid;
import java.util.Map;

@RestController
@RequestMapping("/api/auth")
@CrossOrigin(origins = "*", maxAge = 3600)
public class AuthController {
    
    @Autowired
    private AuthService authService;
    
    @PostMapping("/login")
    public ResponseEntity<?> login(@Valid @RequestBody LoginRequestDto loginRequest) {
        try {
            AuthResponseDto response = authService.login(loginRequest);
            return ResponseEntity.ok(response);
        } catch (Exception e) {
            return ResponseEntity.badRequest()
                    .body(Map.of("error", "Invalid credentials", "message", e.getMessage()));
        }
    }
    
    @PostMapping("/register")
    public ResponseEntity<?> register(@Valid @RequestBody RegisterRequestDto registerRequest) {
        try {
            AuthResponseDto response = authService.register(registerRequest);
            return ResponseEntity.ok(response);
        } catch (Exception e) {
            return ResponseEntity.badRequest()
                    .body(Map.of("error", "Registration failed", "message", e.getMessage()));
        }
    }
    
    @PostMapping("/refresh")
    public ResponseEntity<?> refreshToken(@RequestBody Map<String, String> request) {
        try {
            String refreshToken = request.get("refreshToken");
            AuthResponseDto response = authService.refreshToken(refreshToken);
            return ResponseEntity.ok(response);
        } catch (Exception e) {
            return ResponseEntity.badRequest()
                    .body(Map.of("error", "Token refresh failed", "message", e.getMessage()));
        }
    }
    
    @GetMapping("/user")
    public ResponseEntity<?> getUserInfo(@RequestHeader("Authorization") String token) {
        try {
            // Remove "Bearer " prefix
            if (token.startsWith("Bearer ")) {
                token = token.substring(7);
            }
            UserInfoDto userInfo = authService.getUserInfo(token);
            return ResponseEntity.ok(userInfo);
        } catch (Exception e) {
            return ResponseEntity.badRequest()
                    .body(Map.of("error", "Failed to get user info", "message", e.getMessage()));
        }
    }
}
