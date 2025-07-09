package com.example.DTO;

import java.time.LocalDate;

import com.example.model.BloodType;
import com.example.model.Gender;

public class RegisterRequest {
    public String email;
    public String password;
    public String fullName;
    public String phone;
    public LocalDate dateOfBirth;
    public Gender gender;
    public String address;
    
    // Medical information fields (optional during registration)
    public BloodType bloodType;
    public String chronicDiseases;
    public String allergies;
    public String medications;
    public String emergencyContactName;
    public String emergencyContactPhone;
    public String insuranceNumber;
    public String occupation;
}
