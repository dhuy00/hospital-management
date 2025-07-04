package com.example.appointment_service.repository;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.example.appointment_service.model.Service;

@Repository
public interface ServiceRepository extends JpaRepository<Service, Long> {
    
    List<Service> findByNameContainingIgnoreCase(String name);
}