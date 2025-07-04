package com.example.auth_service.service;

import com.example.auth_service.dto.AuthResponseDto;
import com.example.auth_service.dto.LoginRequestDto;
import com.example.auth_service.dto.RegisterRequestDto;
import com.example.auth_service.dto.UserInfoDto;
import com.example.auth_service.entity.User;
import com.example.auth_service.repository.UserRepository;
import com.example.auth_service.util.JwtTokenUtil;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service
@Transactional
public class AuthService {
    
    @Autowired
    private AuthenticationManager authenticationManager;
    
    @Autowired
    private UserRepository userRepository;
    
    @Autowired
    private PasswordEncoder passwordEncoder;
    
    @Autowired
    private JwtTokenUtil jwtTokenUtil;
    
    public AuthResponseDto login(LoginRequestDto loginRequest) {
        Authentication authentication = authenticationManager.authenticate(
                new UsernamePasswordAuthenticationToken(
                        loginRequest.getEmail(),
                        loginRequest.getPassword()
                )
        );
        
        SecurityContextHolder.getContext().setAuthentication(authentication);
        User user = (User) authentication.getPrincipal();
        
        // Generate tokens
        String jwt = jwtTokenUtil.generateToken(user);
        String refreshToken = jwtTokenUtil.generateRefreshToken(user);
        
        return AuthResponseDto.builder()
                .token(jwt)
                .refreshToken(refreshToken)
                .userId(user.getId())
                .email(user.getEmail())
                .role(user.getRole().name())
                .build();
    }
    
    public AuthResponseDto register(RegisterRequestDto registerRequest) {
        // Check if user already exists
        if (userRepository.existsByEmail(registerRequest.getEmail())) {
            throw new RuntimeException("Email is already in use!");
        }
        
        // Validate role
        User.Role role;
        try {
            role = User.Role.valueOf(registerRequest.getRole().toUpperCase());
        } catch (IllegalArgumentException e) {
            throw new RuntimeException("Invalid role: " + registerRequest.getRole());
        }
        
        // Create new user
        User user = User.builder()
                .email(registerRequest.getEmail())
                .password(passwordEncoder.encode(registerRequest.getPassword()))
                .role(role)
                .build();
        
        user = userRepository.save(user);
        
        // Generate tokens
        String jwt = jwtTokenUtil.generateToken(user);
        String refreshToken = jwtTokenUtil.generateRefreshToken(user);
        
        return AuthResponseDto.builder()
                .token(jwt)
                .refreshToken(refreshToken)
                .userId(user.getId())
                .email(user.getEmail())
                .role(user.getRole().name())
                .build();
    }
    
    public AuthResponseDto refreshToken(String refreshToken) {
        if (!jwtTokenUtil.validateToken(refreshToken) || !jwtTokenUtil.isRefreshToken(refreshToken)) {
            throw new RuntimeException("Invalid refresh token");
        }
        
        String email = jwtTokenUtil.getEmailFromToken(refreshToken);
        User user = userRepository.findByEmail(email)
                .orElseThrow(() -> new RuntimeException("User not found"));
        
        // Generate new tokens
        String newJwt = jwtTokenUtil.generateToken(user);
        String newRefreshToken = jwtTokenUtil.generateRefreshToken(user);
        
        return AuthResponseDto.builder()
                .token(newJwt)
                .refreshToken(newRefreshToken)
                .userId(user.getId())
                .email(user.getEmail())
                .role(user.getRole().name())
                .build();
    }
    
    public UserInfoDto getUserInfo(String token) {
        if (!jwtTokenUtil.validateToken(token)) {
            throw new RuntimeException("Invalid token");
        }
        
        String email = jwtTokenUtil.getEmailFromToken(token);
        User user = userRepository.findByEmail(email)
                .orElseThrow(() -> new RuntimeException("User not found"));
        
        return UserInfoDto.builder()
                .userId(user.getId())
                .email(user.getEmail())
                .role(user.getRole().name())
                .build();
    }
    
    public UserInfoDto getUserInfoByEmail(String email) {
        User user = userRepository.findByEmail(email)
                .orElseThrow(() -> new RuntimeException("User not found"));
        
        return UserInfoDto.builder()
                .userId(user.getId())
                .email(user.getEmail())
                .role(user.getRole().name())
                .build();
    }
}
