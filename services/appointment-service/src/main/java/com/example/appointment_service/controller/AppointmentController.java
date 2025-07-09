package com.example.appointment_service.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.example.appointment_service.DTO.AppointmentRequest;
import com.example.appointment_service.DTO.AppointmentResponse;
import com.example.appointment_service.service.AppointmentService;

@RestController
@RequestMapping("/api/appointments")
public class AppointmentController {

    @Autowired
    private AppointmentService service;

    @GetMapping
    public List<AppointmentResponse> getAllAppointments() {
        return service.getAllAppointments();
    }

    @GetMapping("/{id}")
    public AppointmentResponse getAppointmentById(@PathVariable Long id) {
        return service.getAppointmentById(id);
    }

    @PostMapping
    public AppointmentResponse book(@RequestBody AppointmentRequest request) {
        return service.book(request);
    }

    @GetMapping("/patient/{patientId}")
    public List<AppointmentResponse> getAppointmentsByPatient(@PathVariable Long patientId) {
        return service.getAppointmentsByPatient(patientId);
    }

    @GetMapping("/doctor/{doctorId}")
    public List<AppointmentResponse> getAppointmentsByDoctor(@PathVariable Long doctorId) {
        return service.getAppointmentsByDoctor(doctorId);
    }

    @GetMapping("/service/{serviceId}")
    public List<AppointmentResponse> getAppointmentsByService(@PathVariable Long serviceId) {
        return service.getAppointmentsByService(serviceId);
    }

    @PutMapping("/{id}/cancel")
    public AppointmentResponse cancel(@PathVariable Long id) {
        return service.cancel(id);
    }

    @PutMapping("/{id}/complete")
    public AppointmentResponse complete(@PathVariable Long id) {
        return service.complete(id);
    }
}
