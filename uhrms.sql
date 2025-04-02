-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 02, 2025 at 05:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uhrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `content` text NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `date`, `content`, `created_at`) VALUES
(1, 'ANNUAL GENERAL MEETING', '0000-00-00', 'AGM to be held on 01/06/2025 starting from 2pm', '2025-03-20 07:00:08'),
(2, 'Monthly Meeting', '0000-00-00', 'Monthly Meeting to be held on 30th this  month .', '2025-03-20 09:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `applicant_name` varchar(100) NOT NULL,
  `listing_id` int(11) DEFAULT NULL,
  `status` enum('Under Review','Rejected','Accepted') DEFAULT 'Under Review',
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `resume` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `applicant_name`, `listing_id`, `status`, `email`, `phone_number`, `resume`, `submitted_at`, `updated_at`) VALUES
(1, 'Hirary Clinton', 2, 'Rejected', 'rary@gmail.com', '0790070095', 'Resume – Hirary Clinton\r\nName: Hirary Clinton\r\nEmail: rary@gmail.com\r\nPhone Number: 0790070095\r\n\r\nProfessional Summary\r\nResults-driven Account Manager with extensive experience in financial management, client relations, and strategic account growth. Adept at fostering strong client relationships to ensure high levels of satisfaction and retention. Expertise in financial analysis, budgeting, forecasting, and risk management, with a proven ability to drive revenue growth and optimize financial operations.\r\n\r\nProficient in account reconciliation, financial reporting, and ensuring compliance with industry regulations. Strong analytical and problem-solving skills, coupled with excellent communication and leadership abilities, facilitating seamless collaboration across departments. Passionate about delivering value-driven financial solutions that enhance business performance and profitability.\r\n\r\nWork Experience\r\nAccount Manager | XYZ Financial Services\r\nJanuary 2020 – Present\r\n\r\nManaged and grew key client accounts, increasing revenue by 25% through strategic financial planning and service optimization.\r\n\r\nDeveloped and implemented financial strategies to maximize profitability and reduce operational costs.\r\n\r\nConducted budgeting, forecasting, and variance analysis to support decision-making.\r\n\r\nLed cross-functional teams to improve financial processes and compliance with industry regulations.\r\n\r\nMaintained excellent relationships with stakeholders, ensuring client retention and satisfaction.\r\n\r\nFinancial Analyst | ABC Consulting\r\nJune 2017 – December 2019\r\n\r\nAssisted in financial reporting, budgeting, and data analysis to support executive decision-making.\r\n\r\nConducted risk assessments and financial audits, ensuring regulatory compliance.\r\n\r\nCollaborated with sales and operations teams to develop cost-effective solutions.\r\n\r\nProvided actionable insights to optimize financial performance and efficiency.\r\n\r\nEducation\r\nBachelor’s Degree in Finance & Accounting\r\nUniversity of Business & Economics | Graduated: 2017', '2025-03-27 20:18:31', '2025-03-28 10:04:06'),
(2, 'Hirary Clinton', 2, 'Under Review', 'rary@gmail.com', '0790070095', 'Resume – Hirary Clinton\r\nName: Hirary Clinton\r\nEmail: rary@gmail.com\r\nPhone Number: 0790070095\r\n\r\nProfessional Summary\r\nResults-driven Account Manager with extensive experience in financial management, client relations, and strategic account growth. Adept at fostering strong client relationships to ensure high levels of satisfaction and retention. Expertise in financial analysis, budgeting, forecasting, and risk management, with a proven ability to drive revenue growth and optimize financial operations.\r\n\r\nProficient in account reconciliation, financial reporting, and ensuring compliance with industry regulations. Strong analytical and problem-solving skills, coupled with excellent communication and leadership abilities, facilitating seamless collaboration across departments. Passionate about delivering value-driven financial solutions that enhance business performance and profitability.\r\n\r\nWork Experience\r\nAccount Manager | XYZ Financial Services\r\nJanuary 2020 – Present\r\n\r\nManaged and grew key client accounts, increasing revenue by 25% through strategic financial planning and service optimization.\r\n\r\nDeveloped and implemented financial strategies to maximize profitability and reduce operational costs.\r\n\r\nConducted budgeting, forecasting, and variance analysis to support decision-making.\r\n\r\nLed cross-functional teams to improve financial processes and compliance with industry regulations.\r\n\r\nMaintained excellent relationships with stakeholders, ensuring client retention and satisfaction.\r\n\r\nFinancial Analyst | ABC Consulting\r\nJune 2017 – December 2019\r\n\r\nAssisted in financial reporting, budgeting, and data analysis to support executive decision-making.\r\n\r\nConducted risk assessments and financial audits, ensuring regulatory compliance.\r\n\r\nCollaborated with sales and operations teams to develop cost-effective solutions.\r\n\r\nProvided actionable insights to optimize financial performance and efficiency.\r\n\r\nEducation\r\nBachelor’s Degree in Finance & Accounting\r\nUniversity of Business & Economics | Graduated: 2017', '2025-03-27 23:14:13', '2025-03-27 23:14:13'),
(3, 'Hirary Clinton', 2, 'Under Review', 'rary@gmail.com', '0790070095', 'Resume – Hirary Clinton\r\nName: Hirary Clinton\r\nEmail: rary@gmail.com\r\nPhone Number: 0790070095\r\n\r\nProfessional Summary\r\nResults-driven Account Manager with extensive experience in financial management, client relations, and strategic account growth. Adept at fostering strong client relationships to ensure high levels of satisfaction and retention. Expertise in financial analysis, budgeting, forecasting, and risk management, with a proven ability to drive revenue growth and optimize financial operations.\r\n\r\nProficient in account reconciliation, financial reporting, and ensuring compliance with industry regulations. Strong analytical and problem-solving skills, coupled with excellent communication and leadership abilities, facilitating seamless collaboration across departments. Passionate about delivering value-driven financial solutions that enhance business performance and profitability.\r\n\r\nWork Experience\r\nAccount Manager | XYZ Financial Services\r\nJanuary 2020 – Present\r\n\r\nManaged and grew key client accounts, increasing revenue by 25% through strategic financial planning and service optimization.\r\n\r\nDeveloped and implemented financial strategies to maximize profitability and reduce operational costs.\r\n\r\nConducted budgeting, forecasting, and variance analysis to support decision-making.\r\n\r\nLed cross-functional teams to improve financial processes and compliance with industry regulations.\r\n\r\nMaintained excellent relationships with stakeholders, ensuring client retention and satisfaction.\r\n\r\nFinancial Analyst | ABC Consulting\r\nJune 2017 – December 2019\r\n\r\nAssisted in financial reporting, budgeting, and data analysis to support executive decision-making.\r\n\r\nConducted risk assessments and financial audits, ensuring regulatory compliance.\r\n\r\nCollaborated with sales and operations teams to develop cost-effective solutions.\r\n\r\nProvided actionable insights to optimize financial performance and efficiency.\r\n\r\nEducation\r\nBachelor’s Degree in Finance & Accounting\r\nUniversity of Business & Economics | Graduated: 2017', '2025-03-28 10:07:25', '2025-03-28 10:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `employee_id`, `date`, `status`, `timestamp`) VALUES
(1, 2, '2025-03-20', 'Present', '2025-03-25 09:08:36'),
(2, 4, '2025-03-20', 'Present', '2025-03-25 09:08:36'),
(3, 2, '2025-03-23', 'Absent', '2025-03-25 09:08:36'),
(4, 2, '2025-03-27', 'Present', '2025-03-27 11:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `award_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `award_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`award_id`, `employee_id`, `award_name`, `description`, `date`, `created_at`, `updated_at`) VALUES
(2, 2, 'employee of the month', 'KUdos', '2025-03-26', '2025-03-27 16:23:52', '2025-03-27 16:23:52'),
(3, 2, 'employee of the month', 'The most performed employee for this month', '2025-03-20', '2025-03-27 21:59:08', '2025-03-27 21:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `head` int(11) DEFAULT NULL,
  `members` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `name`, `head`, `members`) VALUES
(4, 'Human Resource Mangement', 1, 10),
(5, 'Admin', 1, 2),
(6, 'IT', 3, 10),
(7, 'Finance', 2, 15),
(8, 'Academics', 3, 100);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `tenure_start` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `full_name`, `role`, `department_id`, `email`, `phone`, `tenure_start`) VALUES
(2, 'Dan snipers', 'Manager', 4, 'dansnipp@gmail.com', '0987654321', '2024-02-01'),
(4, 'Faith Ndunge', 'IT Admin', 6, 'ndanu444@gmail.com', '0748090815', '2024-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `joblistings`
--

CREATE TABLE `joblistings` (
  `listing_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `application_deadline` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `joblistings`
--

INSERT INTO `joblistings` (`listing_id`, `title`, `department`, `description`, `status`, `application_deadline`, `created_at`) VALUES
(2, 'Accounts Manager', 'Finance', 'Applicant to have a certified degree in Finance and accounting. 3 years of work experience.', 'open', NULL, '2025-03-27 19:03:42');

-- --------------------------------------------------------

--
-- Table structure for table `leaverequests`
--

CREATE TABLE `leaverequests` (
  `leave_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `leave_type` enum('Annual Leave','Sick Leave','Maternity Leave','Other') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaverequests`
--

INSERT INTO `leaverequests` (`leave_id`, `employee_id`, `leave_type`, `start_date`, `end_date`, `status`, `reason`, `created_at`, `updated_at`) VALUES
(6, 4, 'Sick Leave', '2025-03-24', '2025-03-30', 'Pending', 'Cold Fever', '2025-03-28 09:56:18', '2025-03-28 09:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `payslip_id` int(11) NOT NULL,
  `month` year(4) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `allowances` decimal(10,2) DEFAULT 0.00,
  `deductions` decimal(10,2) DEFAULT 0.00,
  `net_salary` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payslips`
--

INSERT INTO `payslips` (`payslip_id`, `month`, `employee_id`, `basic_salary`, `allowances`, `deductions`, `net_salary`, `created_at`, `updated_at`) VALUES
(1, '0000', 2, 34000.00, 4000.00, 4000.00, 0.00, '2025-03-27 15:35:29', '2025-03-27 15:35:29'),
(2, '0000', 4, 44000.00, 400.00, 400.00, 0.00, '2025-03-27 15:37:33', '2025-03-27 15:37:33'),
(3, '0000', 4, 3456.00, 4400.00, 34565.00, 0.00, '2025-03-27 15:50:29', '2025-03-27 15:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `role`) VALUES
(1, 'GATINU SIMON', 'simong@gmail.com', NULL, '$2y$10$d7S9.O2GFOZeJ9Av3eutFeOReQ4gBHGy.sWNhlzww/HaUvaDqfCv6', 'admin'),
(2, 'Dan Snipper', 'dansnipp@gmail.com', '0987654321', '$2y$10$NUb6LX9fuWhrri3WgL08jO..6k21tKaIDw85a4tJezjjckXs.m8ju', 'employee'),
(3, 'Benanzia B', 'bena@gmail.com', NULL, '$2y$10$YbvGgjxgMsC.66m0VneaaOgltN9vDVek4S.0Dpu08h89q8CdSG0f2', 'employee'),
(4, 'Faith Ndunge', 'ndanu444@gmail.com', '0748090815', '$2y$10$YbvGgjxgMsC.66m0VneaaOgltN9vDVek4S.0Dpu08h89q8CdSG0f2', 'employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`award_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `head` (`head`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_employee_department` (`department_id`);

--
-- Indexes for table `joblistings`
--
ALTER TABLE `joblistings`
  ADD PRIMARY KEY (`listing_id`);

--
-- Indexes for table `leaverequests`
--
ALTER TABLE `leaverequests`
  ADD PRIMARY KEY (`leave_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`payslip_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `joblistings`
--
ALTER TABLE `joblistings`
  MODIFY `listing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leaverequests`
--
ALTER TABLE `leaverequests`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `payslip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `joblistings` (`listing_id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`head`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employee_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE SET NULL;

--
-- Constraints for table `leaverequests`
--
ALTER TABLE `leaverequests`
  ADD CONSTRAINT `leaverequests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `payslips`
--
ALTER TABLE `payslips`
  ADD CONSTRAINT `payslips_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

