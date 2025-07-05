package com.example.appointment_service.service;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Optional;

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
import com.example.appointment_service.repository.DoctorRepository;
import com.example.appointment_service.repository.ServiceRepository;


@Service
public class AppointmentService {

    @Autowired
    private AppointmentRepository appointmentRepository;

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

    public AppointmentResponse book(AppointmentRequest request) {
        // Validate patient exists
        if (!checkPatientExists(request.getPatientId())) {
        	throw new RuntimeException("Patient not found");
    	}
    	
    	// Validate doctor exists
    	if (!doctorRepository.existsById(request.getDoctorId())) {
    	    throw new RuntimeException("Doctor not found");
    	}
    	
    	// Validate service exists (if provided)
    	if (request.getServiceId() != null && !serviceRepository.existsById(request.getServiceId())) {
    	    throw new RuntimeException("Service not found");
    	}
		
		Appointment a = new Appointment();
        a.setPatientId(request.getPatientId());
        a.setDoctorId(request.getDoctorId());
        a.setAppointmentTime(request.getAppointmentTime());
        a.setServiceId(request.getServiceId());
        a.setReason(request.getReason());
        a.setStatus(AppointmentStatus.SCHEDULED);
        a.setCreatedAt(LocalDateTime.now());
        a.setUpdatedAt(LocalDateTime.now());

        a = appointmentRepository.save(a);

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
        return appointmentRepository.findByServiceId(serviceId)
                .stream().map(this::toResponse).toList();
    }

    public AppointmentResponse cancel(Long appointmentId) {
        Appointment a = appointmentRepository.findById(appointmentId).orElseThrow();
        a.setStatus(AppointmentStatus.CANCELLED);
        a.setUpdatedAt(LocalDateTime.now());
        return toResponse(appointmentRepository.save(a));
    }

    public AppointmentResponse complete(Long appointmentId) {
        Appointment a = appointmentRepository.findById(appointmentId).orElseThrow();
        a.setStatus(AppointmentStatus.COMPLETED);
        a.setUpdatedAt(LocalDateTime.now());
        return toResponse(appointmentRepository.save(a));
    }

    private AppointmentResponse toResponse(Appointment a) {
        AppointmentResponse res = new AppointmentResponse();
        res.setId(a.getId());
        res.setPatientId(a.getPatientId());
        res.setDoctorId(a.getDoctorId());
        res.setAppointmentTime(a.getAppointmentTime());
        res.setServiceId(a.getServiceId());
        res.setStatus(a.getStatus());
        res.setReason(a.getReason());
        res.setCreatedAt(a.getCreatedAt());
        res.setUpdatedAt(a.getUpdatedAt());
        
        // Populate doctor and service names for better UX
        Optional<Doctor> doctor = doctorRepository.findById(a.getDoctorId());
        if (doctor.isPresent()) {
            res.setDoctorName(doctor.get().getFullName());
            res.setDoctorDepartment(doctor.get().getDepartment());
        }
        
        if (a.getServiceId() != null) {
            Optional<com.example.appointment_service.model.Service> service = serviceRepository.findById(a.getServiceId());
            if (service.isPresent()) {
                res.setServiceName(service.get().getName());
            }
        }
        
        return res;
    }
}
