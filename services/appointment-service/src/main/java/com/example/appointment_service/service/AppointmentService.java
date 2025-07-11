package com.example.appointment_service.service;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestTemplate;

import com.example.appointment_service.DTO.AppointmentRequest;
import com.example.appointment_service.DTO.AppointmentResponse;
import com.example.appointment_service.model.Appointment;
import com.example.appointment_service.model.AppointmentStatus;
import com.example.appointment_service.model.Doctor;
import com.example.appointment_service.repository.AppointmentRepository;
import com.example.appointment_service.repository.AppointmentServiceRepository;
import com.example.appointment_service.repository.DoctorRepository;
import com.example.appointment_service.repository.ServiceRepository;

import jakarta.transaction.Transactional;

@Service
public class AppointmentService {

    @Autowired
    private AppointmentRepository appointmentRepository;

    @Autowired
    private AppointmentServiceRepository appointmentServiceRepository;

    @Autowired
    private DoctorRepository doctorRepository;

    @Autowired
    private ServiceRepository serviceRepository;

	@Autowired
	private RestTemplate restTemplate;

	public boolean checkPatientExists(Long patientId) {
		try {
			ResponseEntity<Void> response = restTemplate.getForEntity(
				"http://localhost:8081/api/patients/" + patientId, Void.class);
			return response.getStatusCode().is2xxSuccessful();
		} catch (HttpClientErrorException.NotFound e) {
			return false;
		}
	}

    @Transactional
    public AppointmentResponse book(AppointmentRequest request) {
        // Validate patient exists
        if (!checkPatientExists(request.getPatientId())) {
        	throw new RuntimeException("Patient not found");
    	}
    	
    	// Validate doctor exists
    	if (!doctorRepository.existsById(request.getDoctorId())) {
    	    throw new RuntimeException("Doctor not found");
    	}
    	
    	// Validate all services exist (if provided)
    	if (request.getServiceIds() != null && !request.getServiceIds().isEmpty()) {
    	    for (Long serviceId : request.getServiceIds()) {
    	        if (!serviceRepository.existsById(serviceId)) {
    	            throw new RuntimeException("Service with ID " + serviceId + " not found");
    	        }
    	    }
    	}
		
		// Create appointment
		Appointment a = new Appointment();
        a.setPatientId(request.getPatientId());
        a.setDoctorId(request.getDoctorId());
        a.setAppointmentTime(request.getAppointmentTime());
        a.setReason(request.getReason());
        a.setStatus(AppointmentStatus.SCHEDULED);
        a.setCreatedAt(LocalDateTime.now());
        a.setUpdatedAt(LocalDateTime.now());

        a = appointmentRepository.save(a);
        
        // Create appointment-service relationships
        if (request.getServiceIds() != null && !request.getServiceIds().isEmpty()) {
            for (Long serviceId : request.getServiceIds()) {
                com.example.appointment_service.model.AppointmentService appointmentService = 
                    new com.example.appointment_service.model.AppointmentService();
                appointmentService.setAppointmentId(a.getId());
                appointmentService.setServiceId(serviceId);
                appointmentService.setCreatedAt(LocalDateTime.now());
                appointmentServiceRepository.save(appointmentService);
            }
        }

        return toResponse(a);
    }

    public List<AppointmentResponse> getAppointmentsByPatient(Long patientId) {
        return appointmentRepository.findByPatientId(patientId)
                .stream().map(this::toResponse).toList();
    }

    public List<AppointmentResponse> getAppointmentsByDoctor(Long doctorId) {
        return appointmentRepository.findByDoctorId(doctorId)
                .stream().map(this::toResponse).toList();
    }

    public List<AppointmentResponse> getAppointmentsByService(Long serviceId) {
        List<com.example.appointment_service.model.AppointmentService> appointmentServices = 
            appointmentServiceRepository.findByServiceId(serviceId);
        
        return appointmentServices.stream()
            .map(as -> appointmentRepository.findById(as.getAppointmentId()))
            .filter(Optional::isPresent)
            .map(Optional::get)
            .map(this::toResponse)
            .collect(Collectors.toList());
    }

    @Transactional
    public AppointmentResponse cancel(Long appointmentId) {
        Appointment a = appointmentRepository.findById(appointmentId).orElseThrow();
        a.setStatus(AppointmentStatus.CANCELLED);
        a.setUpdatedAt(LocalDateTime.now());
        return toResponse(appointmentRepository.save(a));
    }

    @Transactional
    public AppointmentResponse complete(Long appointmentId) {
        Appointment a = appointmentRepository.findById(appointmentId).orElseThrow();
        a.setStatus(AppointmentStatus.COMPLETED);
        a.setUpdatedAt(LocalDateTime.now());
        return toResponse(appointmentRepository.save(a));
    }

    @Transactional
    public AppointmentResponse updateAppointment(Long id, AppointmentRequest request) {
        Appointment a = appointmentRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Appointment not found"));
        
        // Validate doctor exists
        if (!doctorRepository.existsById(request.getDoctorId())) {
            throw new RuntimeException("Doctor not found");
        }
        
        // Validate all services exist (if provided)
        if (request.getServiceIds() != null && !request.getServiceIds().isEmpty()) {
            for (Long serviceId : request.getServiceIds()) {
                if (!serviceRepository.existsById(serviceId)) {
                    throw new RuntimeException("Service with ID " + serviceId + " not found");
                }
            }
        }
        
        // Update appointment
        a.setDoctorId(request.getDoctorId());
        a.setAppointmentTime(request.getAppointmentTime());
        a.setReason(request.getReason());
        a.setUpdatedAt(LocalDateTime.now());
        
        a = appointmentRepository.save(a);
        
        // Delete existing appointment-service relationships
        List<com.example.appointment_service.model.AppointmentService> existingServices = 
            appointmentServiceRepository.findByAppointmentId(id);
        for (com.example.appointment_service.model.AppointmentService existingService : existingServices) {
            appointmentServiceRepository.delete(existingService);
        }
        
        // Create new appointment-service relationships
        if (request.getServiceIds() != null && !request.getServiceIds().isEmpty()) {
            for (Long serviceId : request.getServiceIds()) {
                com.example.appointment_service.model.AppointmentService appointmentService = 
                    new com.example.appointment_service.model.AppointmentService();
                appointmentService.setAppointmentId(a.getId());
                appointmentService.setServiceId(serviceId);
                appointmentService.setCreatedAt(LocalDateTime.now());
                appointmentServiceRepository.save(appointmentService);
            }
        }
        
        return toResponse(a);
    }

    public AppointmentResponse getAppointmentById(Long id) {
        Appointment appointment = appointmentRepository.findById(id)
            .orElseThrow(() -> new RuntimeException("Appointment not found"));
        return toResponse(appointment);
    }

    public List<AppointmentResponse> getAllAppointments() {
        return appointmentRepository.findAll().stream().map(this::toResponse).toList();
    }

    private AppointmentResponse toResponse(Appointment a) {
        AppointmentResponse res = new AppointmentResponse();
        res.setId(a.getId());
        res.setPatientId(a.getPatientId());
        res.setDoctorId(a.getDoctorId());
        res.setAppointmentTime(a.getAppointmentTime());
        res.setStatus(a.getStatus());
        res.setReason(a.getReason());
        res.setCreatedAt(a.getCreatedAt());
        res.setUpdatedAt(a.getUpdatedAt());
        
        // Populate doctor name and department
        Optional<Doctor> doctor = doctorRepository.findById(a.getDoctorId());
        if (doctor.isPresent()) {
            res.setDoctorName(doctor.get().getFullName());
            res.setDoctorDepartment(doctor.get().getDepartment());
        }
        
        // Populate service IDs and names
        List<com.example.appointment_service.model.AppointmentService> appointmentServices = 
            appointmentServiceRepository.findByAppointmentId(a.getId());
        
        List<Long> serviceIds = new ArrayList<>();
        List<String> serviceNames = new ArrayList<>();
        StringBuilder allServiceNames = new StringBuilder();
        
        for (com.example.appointment_service.model.AppointmentService as : appointmentServices) {
            serviceIds.add(as.getServiceId());
            
            Optional<com.example.appointment_service.model.Service> service = 
                serviceRepository.findById(as.getServiceId());
            if (service.isPresent()) {
                String serviceName = service.get().getName();
                serviceNames.add(serviceName);
                
                // Build comma-separated service names for the serviceName field
                if (allServiceNames.length() > 0) {
                    allServiceNames.append(", ");
                }
                allServiceNames.append(serviceName);
            }
        }
        
        res.setServiceIds(serviceIds);
        res.setServiceNames(serviceNames);
        res.setServiceName(allServiceNames.toString()); // Set the single serviceName field
        
        return res;
    }
}
