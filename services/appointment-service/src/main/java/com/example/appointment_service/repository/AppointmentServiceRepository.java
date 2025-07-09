package com.example.appointment_service.repository;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import com.example.appointment_service.model.AppointmentService;

@Repository
public interface AppointmentServiceRepository extends JpaRepository<AppointmentService, Long> {
    
    List<AppointmentService> findByAppointmentId(Long appointmentId);
    
    List<AppointmentService> findByServiceId(Long serviceId);
    
    @Query("SELECT asvc FROM AppointmentService asvc WHERE asvc.appointmentId = :appointmentId AND asvc.serviceId = :serviceId")
    AppointmentService findByAppointmentIdAndServiceId(@Param("appointmentId") Long appointmentId, @Param("serviceId") Long serviceId);
    
    void deleteByAppointmentId(Long appointmentId);
    
    void deleteByAppointmentIdAndServiceId(Long appointmentId, Long serviceId);
}
