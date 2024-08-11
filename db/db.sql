CREATE TABLE admins (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);


CREATE TABLE police (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    dob DATE NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    house_address VARCHAR(255) NOT NULL,
    badge_number VARCHAR(50) NOT NULL,
    mttd_rank VARCHAR(50) NOT NULL,
    police_station VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE police ADD COLUMN reset_code VARCHAR(6);

CREATE TABLE dvla_personnel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL
);
ALTER TABLE dvla_personnel
ADD profile_picture VARCHAR(255) DEFAULT 'dvla_profile.png';

CREATE TABLE driver_license_application_forms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profile_picture VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    place_of_birth VARCHAR(255) NOT NULL,
    nationality VARCHAR(255) NOT NULL,
    gender VARCHAR(255) NOT NULL,
    residential_address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email_address VARCHAR(255) NOT NULL,
    id_type VARCHAR(255) NOT NULL,
    id_number VARCHAR(255) NOT NULL,
    license_category VARCHAR(255) NOT NULL,
    purpose_of_license VARCHAR(255) NOT NULL,
    medical_fitness_declaration VARCHAR(255) NOT NULL,
    eye_test_results VARCHAR(255) NOT NULL,
    emergency_name VARCHAR(255) NOT NULL,
    relationship VARCHAR(255) NOT NULL,
    emergency_phone_number VARCHAR(20) NOT NULL,
    license_start_date DATE NOT NULL,
    license_end_date DATE NOT NULL,
    application_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

