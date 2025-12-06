-- Patients and Appointments Tables for Medicare Clinic Database System
-- Run this SQL in your 'medicare' database

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `patient_id` int(255) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`patient_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `appointment_id` int(255) NOT NULL AUTO_INCREMENT,
  `patient_id` int(255) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `appointment_type` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Scheduled',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`appointment_id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

