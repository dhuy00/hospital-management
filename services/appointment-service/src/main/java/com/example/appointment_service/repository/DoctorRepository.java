package com.example.appointment_service.repository;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.example.appointment_service.model.Doctor;

@Repository
public interface DoctorRepository extends JpaRepository<Doctor, Long> {
    
    Optional<Doctor> findByEmail(String email);
    
    List<Doctor> findByDepartment(String department);
    
    List<Doctor> findByFullNameContainingIgnoreCase(String name);
}