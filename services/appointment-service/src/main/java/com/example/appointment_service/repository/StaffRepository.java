package com.example.appointment_service.repository;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.example.appointment_service.model.Staff;

@Repository
public interface StaffRepository extends JpaRepository<Staff, Long> {
    
    Optional<Staff> findByEmail(String email);
    
    List<Staff> findByPosition(String position);
    
    List<Staff> findByFullNameContainingIgnoreCase(String name);
}
