package com.example.appointment_service.repository;

import java.time.LocalDateTime;
import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import com.example.appointment_service.model.Appointment;
import com.example.appointment_service.model.AppointmentStatus;

public interface AppointmentRepository extends JpaRepository<Appointment, Long> {
    
    List<Appointment> findByPatientId(Long patientId);
    
    List<Appointment> findByDoctorId(Long doctorId);
    
    List<Appointment> findByServiceId(Long serviceId);
    
    List<Appointment> findByStatus(AppointmentStatus status);
    
    List<Appointment> findByDoctorIdAndStatus(Long doctorId, AppointmentStatus status);
    
    List<Appointment> findByPatientIdAndStatus(Long patientId, AppointmentStatus status);
    
    @Query("SELECT a FROM Appointment a WHERE a.doctorId = :doctorId AND a.appointmentTime BETWEEN :startTime AND :endTime")
    List<Appointment> findByDoctorIdAndAppointmentTimeBetween(@Param("doctorId") Long doctorId, 
                                                             @Param("startTime") LocalDateTime startTime, 
                                                             @Param("endTime") LocalDateTime endTime);
    
    @Query("SELECT a FROM Appointment a WHERE a.appointmentTime >= :startTime AND a.appointmentTime <= :endTime")
    List<Appointment> findByAppointmentTimeBetween(@Param("startTime") LocalDateTime startTime, 
                                                  @Param("endTime") LocalDateTime endTime);
}
