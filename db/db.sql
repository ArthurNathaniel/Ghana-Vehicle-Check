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


CREATE TABLE vehicle_registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_date DATE,
    license_plate_number VARCHAR(20),
    vehicle_make VARCHAR(50),
    vehicle_model VARCHAR(50),
    vehicle_year YEAR,
    vehicle_color VARCHAR(20),
    owner_name VARCHAR(100),
    owner_dob DATE,
    owner_address TEXT,
    owner_phone VARCHAR(15),
    owner_email VARCHAR(100),
    driver_name VARCHAR(100),
    driver_dob DATE,
    driver_address TEXT,
    driver_phone VARCHAR(15),
    driver_email VARCHAR(100),
    license_start_date DATE,
    license_expiry_date DATE
);
