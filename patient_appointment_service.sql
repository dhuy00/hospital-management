-- USE SYS;
-- DROP DATABASE patient_db;
-- DROP DATABASE appointment_db;

CREATE DATABASE patient_db;
USE patient_db;

CREATE TABLE patients (
    id              BIGINT AUTO_INCREMENT PRIMARY KEY,
    email           VARCHAR(255) UNIQUE NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    full_name       VARCHAR(255) NOT NULL,
    phone           VARCHAR(20),
    date_of_birth   DATE,
    gender          ENUM('MALE', 'FEMALE', 'OTHER'),
    address         TEXT,
    blood_type      ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') DEFAULT 'O+',
    chronic_diseases TEXT,
    allergies       TEXT,
    medications      TEXT,
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20),
    insurance_number VARCHAR(50),
    occupation      VARCHAR(100),
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE DATABASE appointment_db;
USE appointment_db;

CREATE TABLE staffs (
    id              BIGINT AUTO_INCREMENT PRIMARY KEY,
    email           VARCHAR(255) UNIQUE NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    full_name       VARCHAR(255) NOT NULL,
    phone           VARCHAR(20),
    position        VARCHAR(50),
    date_of_birth   DATE,
    gender          ENUM('MALE', 'FEMALE', 'OTHER'),
    address         TEXT,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE doctors (
    id              BIGINT AUTO_INCREMENT PRIMARY KEY,
    email           VARCHAR(255) UNIQUE NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    full_name       VARCHAR(255) NOT NULL,
    phone           VARCHAR(20),
    department		VARCHAR(20),
    date_of_birth   DATE,
    gender          ENUM('MALE', 'FEMALE', 'OTHER'),
    address         TEXT,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE services(
	id				BIGINT AUTO_INCREMENT PRIMARY KEY,
    name			VARCHAR(255) NOT NULL
);

CREATE TABLE appointments (
    id              BIGINT AUTO_INCREMENT PRIMARY KEY,
    patient_id      BIGINT NOT NULL,
    doctor_id		BIGINT NOT NULL,
    appointment_time DATETIME NOT NULL,
    status          ENUM('SCHEDULED', 'CANCELLED', 'COMPLETED') DEFAULT 'SCHEDULED',
    reason          TEXT,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);

CREATE TABLE appointment_services (
    id              BIGINT AUTO_INCREMENT PRIMARY KEY,
    appointment_id  BIGINT NOT NULL,
    service_id      BIGINT NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id),
    UNIQUE KEY unique_appointment_service (appointment_id, service_id)
);

USE patient_db;
INSERT INTO patients (email, password_hash, full_name, phone, date_of_birth, gender, address)
VALUES 
('alice@example.com', '$2a$10$123456789012345678901u3pHpz9nLv6WyMfBmsC/4Q5ZB', 'Alice Nguyễn', '0901234567', '1995-04-12', 'FEMALE', '123 Lê Lợi, Q1, TP.HCM'),
('bob@example.com',   '$2a$10$abcdefghijklmno123456pqrstuABCDEFGHIJKLMNO', 'Bob Trần', '0912345678', '1989-10-01', 'MALE', '456 Trần Hưng Đạo, Q5, TP.HCM'),
('minh@example.com',  '$2a$10$zyxwvutsrqponmlkjihgfedcba0987654321ZYXWVU', 'Minh Võ', '0938765432', '2000-07-20', 'OTHER', '789 Pasteur, Q3, TP.HCM');

USE appointment_db;

-- Bác sĩ
INSERT INTO doctors (email, password_hash, full_name, phone, department, date_of_birth, gender, address)
VALUES
('dr.hoa@example.com', '$2a$10$doctorpasshashdoctorhash01', 'Dr. Hoa Phạm', '0909991111', 'Nội', '1980-03-05', 'FEMALE', '123 Nguyễn Thị Minh Khai'),
('dr.hung@example.com', '$2a$10$doctorpasshashdoctorhash02', 'Dr. Hùng Lê', '0918882222', 'Ngoại', '1975-12-12', 'MALE', '456 Cách Mạng Tháng Tám');

-- Nhân viên
INSERT INTO staffs (email, password_hash, full_name, phone, position, date_of_birth, gender, address)
VALUES
('reception01@example.com', '$2a$10$receptionhashexample123', 'Ngọc Hà', '0935123456', 'Lễ tân', '1998-06-15', 'FEMALE', '12 Nguyễn Du, Q1, TP.HCM'),
('admin02@example.com',     '$2a$10$adminpasshashexample456', 'Phúc Hùng', '0908999123', 'Quản lý', '1985-02-20', 'MALE', '34 Lê Văn Sỹ, Q3, TP.HCM'),
('support03@example.com',   '$2a$10$staffpasshashdemo789',   'Linh Lê', '0947333888', 'Hỗ trợ khách hàng', '1992-11-05', 'OTHER', '789 Huỳnh Thúc Kháng, Q1, TP.HCM');

-- Dịch vụ
INSERT INTO services (name)
VALUES
('Khám tổng quát'),
('Khám tai mũi họng'),
('Khám nội tiết');

-- Lịch hẹn
INSERT INTO appointments (patient_id, doctor_id, appointment_time, status, reason)
VALUES
(1, 1, '2025-07-10 09:00:00', 'SCHEDULED', 'Khám sức khỏe định kỳ'),
(2, 2, '2025-07-12 14:30:00', 'SCHEDULED', 'Đau họng liên tục'),
(3, 1, '2025-07-15 10:00:00', 'CANCELLED', 'Khám nội tiết');

-- Gán dịch vụ cho các cuộc hẹn
INSERT INTO appointment_services (appointment_id, service_id)
VALUES
-- Cuộc hẹn 1: Khám tổng quát
(1, 1),
-- Cuộc hẹn 2: Khám tai mũi họng
(2, 2),
-- Cuộc hẹn 3: Khám nội tiết
(3, 3),
-- Ví dụ: Cuộc hẹn 1 có thêm dịch vụ khám tai mũi họng
(1, 2);
