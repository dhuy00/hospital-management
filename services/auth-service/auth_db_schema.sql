-- Authentication Database Schema
-- This schema handles user authentication and authorization for the hospital management system

CREATE DATABASE IF NOT EXISTS auth_db;
USE auth_db;

-- Users table for authentication
CREATE TABLE users (
    id              BIGINT AUTO_INCREMENT PRIMARY KEY,
    email           VARCHAR(255) UNIQUE NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    role            ENUM('PATIENT', 'DOCTOR', 'STAFF', 'ADMIN') NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
);

-- Insert sample users for testing
INSERT INTO users (email, password_hash, role) VALUES 
-- Password: password123
('admin@hospital.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'ADMIN'),
('alice@example.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'PATIENT'),
('bob@example.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'PATIENT'),
('minh@example.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'PATIENT'),
('dr.hoa@example.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'DOCTOR'),
('dr.hung@example.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'DOCTOR'),
('reception01@example.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'STAFF'),
('admin02@example.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'STAFF'),
('support03@example.com', '$2a$10$rOPzIQ6fBqOaLvtQYfqpAuNTYJ9jP8kUKCHNmJMtHFrRyINJ4tqga', 'STAFF');
