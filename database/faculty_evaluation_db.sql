-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2023 at 02:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faculty_evaluation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_id`, `admin_level`) VALUES
(1, 2, 'Dean'),
(2, 6, 'Chair');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `eval_id` int(11) NOT NULL,
  `evaluator_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `eval_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`eval_id`, `evaluator_id`, `target_id`, `form_id`, `eval_date`) VALUES
(1, 4, 1, 119, '2023-08-31 22:51:10'),
(6, 3, 1, 118, '2023-09-01 16:11:35'),
(7, 3, 1, 118, '2023-09-01 18:16:34'),
(8, 2, 1, 118, '2023-09-01 18:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `user_id` int(11) NOT NULL,
  `faculty_id` int(50) NOT NULL,
  `employment_status` varchar(150) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`user_id`, `faculty_id`, `employment_status`, `data`) VALUES
(5, 2, 'full time', '{\"courses\":[\n    {\n      \"course_code\": \"PHYS201\",\n      \"course_name\": \"Physics Fundamentals\",\n      \"program\": \"BSIT\",\n      \"year_level\": \"4\",\n      \"section\": \"BSIT4A\",\n      \"schedule\": [\n        {\n          \"day\": \"Tuesday\",\n          \"time\": \"9:00 AM - 10:30 AM\"\n        },\n        {\n          \"day\": \"Thursday\",\n          \"time\": \"9:00 AM - 10:30 AM\"\n        }\n      ]\n    }\n  ]\n}'),
(6, 3, 'full time', '{\"courses\":[\n    {\n      \"course_code\": \"CS200\",\n      \"course_name\": \"Introduction to Programming\",\n      \"program\": \"BSIT\",\n      \"year_level\": \"4\",\n      \"section\": \"BSIT4A\",\n      \"schedule\": [\n        {\n          \"day\": \"Monday\",\n          \"time\": \"2:00 PM - 3:30 PM\"\n        },\n        {\n          \"day\": \"Wednesday\",\n          \"time\": \"2:00 PM - 3:30 PM\"\n        }\n      ]\n    }\n  ]\n}'),
(7, 4, 'full time', '{\"courses\":[\r\n    {\r\n      \"course_code\": \"ART110\",\r\n      \"course_name\": \"Introduction to Art\",\r\n      \"program\": \"BSIT\",\r\n      \"year_level\": \"4\",\r\n      \"section\": \"BSIT4A\",\r\n      \"schedule\": [\r\n        {\r\n          \"day\": \"Tuesday\",\r\n          \"time\": \"3:00 PM - 4:30 PM\"\r\n        },\r\n        {\r\n          \"day\": \"Thursday\",\r\n          \"time\": \"3:00 PM - 4:30 PM\"\r\n        }\r\n      ]\r\n    }\r\n  ]\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `form_id` int(11) NOT NULL,
  `form_name` varchar(50) NOT NULL,
  `form_description` varchar(150) NOT NULL,
  `form_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`form_id`, `form_name`, `form_description`, `form_type`) VALUES
(118, 'tst', 'null', NULL),
(119, 'tset2', 'null', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `form_page`
--

CREATE TABLE `form_page` (
  `page_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `page_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_page`
--

INSERT INTO `form_page` (`page_id`, `form_id`, `page_sequence`) VALUES
(31, 118, 1),
(32, 118, 2),
(33, 118, 3),
(34, 119, 1),
(35, 119, 2);

-- --------------------------------------------------------

--
-- Table structure for table `form_permission`
--

CREATE TABLE `form_permission` (
  `permission_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `form_id` int(11) NOT NULL,
  `can_access` tinyint(1) NOT NULL,
  `can_modify` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_permission`
--

INSERT INTO `form_permission` (`permission_id`, `user_id`, `role`, `form_id`, `can_access`, `can_modify`) VALUES
(127, 0, 'superadmin', 118, 1, 1),
(128, 0, 'superadmin', 119, 1, 1),
(129, 0, 'student', 119, 1, 0),
(131, 0, 'faculty', 118, 1, 0),
(132, 0, 'admin', 118, 1, 0),
(133, 0, 'admin', 119, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_question`
--

CREATE TABLE `form_question` (
  `question_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `question_text` varchar(150) NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `question_order` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_question`
--

INSERT INTO `form_question` (`question_id`, `section_id`, `question_text`, `question_type`, `options`, `question_order`, `form_id`, `page_id`) VALUES
(478, 138, 'Student Number', 'textbox', NULL, 1, 118, 31),
(479, 138, 'Section', 'textbox', NULL, 2, 118, 31),
(480, 138, 'Professor', 'dropdown', '[]', 3, 118, 31),
(481, 138, 'Class Schedule', 'textbox', NULL, 4, 118, 31),
(482, 138, '', 'page', NULL, 5, 118, 31),
(483, 139, 'test date', 'date', NULL, 7, 118, 32),
(484, 139, 'test time', 'time', NULL, 8, 118, 32),
(485, 140, 't3', 'time', NULL, 11, 118, 33),
(486, 140, 'd3', 'date', NULL, 12, 118, 33),
(487, 141, 'Student Number', 'textbox', NULL, 1, 119, 34),
(488, 141, 'Section', 'textbox', NULL, 2, 119, 34),
(489, 141, 'Professor', 'dropdown', '{\"option1\":\"1\",\"option2\":\"2\",\"option3\":\"3\"}', 3, 119, 34),
(490, 141, 'Class Schedule', 'textbox', NULL, 4, 119, 34),
(491, 142, 'a2 p2', 'paragraph', NULL, 7, 119, 35),
(492, 142, 'd2 p2', 'date', NULL, 8, 119, 35);

-- --------------------------------------------------------

--
-- Table structure for table `form_response`
--

CREATE TABLE `form_response` (
  `response_id` int(11) NOT NULL,
  `form_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `response_value` varchar(255) DEFAULT NULL,
  `response_type` enum('text','choice','date') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_response`
--

INSERT INTO `form_response` (`response_id`, `form_id`, `user_id`, `question_id`, `response_value`, `response_type`) VALUES
(224, 119, 4, 487, 'fdadf', ''),
(225, 119, 4, 488, 'fadf', ''),
(226, 119, 4, 489, '2', ''),
(227, 119, 4, 490, 'adfadf', ''),
(228, 119, 4, 491, 'fadfadf', ''),
(229, 119, 4, 492, '2023-09-30', 'date'),
(230, 119, 4, 487, 'test', ''),
(231, 119, 4, 488, 'stasd', ''),
(232, 119, 4, 489, '1', ''),
(233, 119, 4, 490, 'dfadf', ''),
(234, 119, 4, 491, 'adfadf', ''),
(235, 119, 4, 492, '2023-09-21', 'date'),
(236, 119, 4, 487, 'adfad', ''),
(237, 119, 4, 488, 'dfadf', ''),
(238, 119, 4, 489, '2', ''),
(239, 119, 4, 490, 'fadf', ''),
(240, 119, 4, 491, 'adfadf', ''),
(241, 119, 4, 492, '2023-09-20', 'date'),
(243, 118, 3, 478, 'adfa', ''),
(244, 118, 3, 479, 'fadf', ''),
(245, 118, 3, 480, '', ''),
(246, 118, 3, 481, 'dfadf', ''),
(247, 118, 3, 483, '2023-09-22', 'date'),
(248, 118, 3, 484, '15:55', ''),
(249, 118, 3, 485, '05:52', ''),
(250, 118, 3, 486, '2023-09-28', 'date'),
(251, 118, 3, 478, 'adfa', ''),
(252, 118, 3, 479, 'fadf', ''),
(253, 118, 3, 480, '', ''),
(254, 118, 3, 481, 'dfadf', ''),
(255, 118, 3, 483, '2023-09-22', 'date'),
(256, 118, 3, 484, '15:55', ''),
(257, 118, 3, 485, '05:52', ''),
(258, 118, 3, 486, '2023-09-28', 'date'),
(259, 118, 3, 478, 'adfa', ''),
(260, 118, 3, 479, 'fadf', ''),
(261, 118, 3, 480, '', ''),
(262, 118, 3, 481, 'dfadf', ''),
(263, 118, 3, 483, '2023-09-22', 'date'),
(264, 118, 3, 484, '15:55', ''),
(265, 118, 3, 485, '05:52', ''),
(266, 118, 3, 486, '2023-09-28', 'date'),
(267, 118, 3, 478, '', ''),
(268, 118, 3, 479, '', ''),
(269, 118, 3, 480, '', ''),
(270, 118, 3, 481, '', ''),
(271, 118, 3, 483, '', 'date'),
(272, 118, 3, 484, '', ''),
(273, 118, 3, 485, '', ''),
(274, 118, 3, 486, '', 'date'),
(275, 118, 3, 478, 'fadf', ''),
(276, 118, 3, 479, 'adfa', ''),
(277, 118, 3, 480, '', ''),
(278, 118, 3, 481, 'fadf', ''),
(279, 118, 3, 483, '2023-09-13', 'date'),
(280, 118, 3, 484, '06:18', ''),
(281, 118, 3, 485, '18:18', ''),
(282, 118, 3, 486, '2023-09-21', 'date'),
(283, 118, 2, 478, 'fadf', ''),
(284, 118, 2, 479, 'fadf', ''),
(285, 118, 2, 480, '', ''),
(286, 118, 2, 481, 'fadf', ''),
(287, 118, 2, 483, '2023-08-28', 'date'),
(288, 118, 2, 484, '06:31', ''),
(289, 118, 2, 485, '09:28', ''),
(290, 118, 2, 486, '2023-09-07', 'date');

-- --------------------------------------------------------

--
-- Table structure for table `form_section`
--

CREATE TABLE `form_section` (
  `section_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `section_order` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_section`
--

INSERT INTO `form_section` (`section_id`, `form_id`, `section_name`, `section_order`, `page_id`) VALUES
(138, 118, 'Faculty Information', 1, 31),
(139, 118, 'senctino1 p2', 2, 32),
(140, 118, 's3 p3', 3, 33),
(141, 119, 'Faculty Information', 1, 34),
(142, 119, 's2 p2', 2, 35);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(50) NOT NULL,
  `year_level` int(11) NOT NULL,
  `course` varchar(150) NOT NULL,
  `section` varchar(50) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `year_level`, `course`, `section`, `data`, `user_id`) VALUES
(2018200836, 4, 'BSIT', 'BSIT4A', '{\n  \"courses\": [\n    {\n      \"course_code\": \"MATH101\",\n      \"course_name\": \"Introduction to Mathematics\",\n      \"professor\": \"John Doe\",\n      \"faculty_id\": \"1\",\n      \"schedule\": [\n        {\n          \"day\": \"Monday\",\n          \"time\": \"10:00 AM - 11:30 AM\"\n        },\n        {\n          \"day\": \"Wednesday\",\n          \"time\": \"10:00 AM - 11:30 AM\"\n        }\n      ]\n    },\n    {\n      \"course_code\": \"PHYS201\",\n      \"course_name\": \"Physics Fundamentals\",\n      \"professor\": \"Jane Smith\",\n      \"faculty_id\": \"2\",\n      \"schedule\": [\n        {\n          \"day\": \"Tuesday\",\n          \"time\": \"9:00 AM - 10:30 AM\"\n        },\n        {\n          \"day\": \"Thursday\",\n          \"time\": \"9:00 AM - 10:30 AM\"\n        }\n      ]\n    },\n{\n      \"course_code\": \"CS200\",\n      \"course_name\": \"Introduction to Programming\",\n      \"professor\": \"David Smith\",\n      \"faculty_id\": \"3\",\n      \"schedule\": [\n        {\n          \"day\": \"Monday\",\n          \"time\": \"2:00 PM - 3:30 PM\"\n        },\n        {\n          \"day\": \"Wednesday\",\n          \"time\": \"2:00 PM - 3:30 PM\"\n        }\n      ]\n    },\n    {\n      \"course_code\": \"ART110\",\n      \"course_name\": \"Introduction to Art\",\n      \"faculty_id\": \"4\",\n      \"professor\": \"Emily White\",\n      \"schedule\": [\n        {\n          \"day\": \"Tuesday\",\n          \"time\": \"3:00 PM - 4:30 PM\"\n        },\n        {\n          \"day\": \"Thursday\",\n          \"time\": \"3:00 PM - 4:30 PM\"\n        }\n      ]\n    }\n  ]\n}', 4);

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `superadmin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`superadmin_id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `role` varchar(50) NOT NULL,
  `photo` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `email`, `role`, `photo`) VALUES
(1, 'superadmin', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'superadmin', 'test', 'superadmin@test.com', 'superadmin', 0x6e756c6c),
(2, 'admin', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'admin', 'test', 'admin@test.com', 'admin', 0x6e756c6c),
(3, 'faculty', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'faculty', 'test', 'faculty@test.com', 'faculty', 0x6e756c6c),
(4, 'student', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'student', 'test', 'student@test.com', 'student', 0x6e756c6c),
(5, 'jane', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'Jane', 'Smith', 'janesmith@sample.com', 'faculty', NULL),
(6, 'david', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'david', 'smith', 'davidsmith@sample.com', 'faculty', NULL),
(7, 'emily', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'emily', 'white', 'emilywhite@sample.com', 'faculty', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`eval_id`),
  ADD KEY `evaluator_id` (`evaluator_id`),
  ADD KEY `target_id` (`target_id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `form_page`
--
ALTER TABLE `form_page`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `form_permission`
--
ALTER TABLE `form_permission`
  ADD PRIMARY KEY (`permission_id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `form_question`
--
ALTER TABLE `form_question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `form_response`
--
ALTER TABLE `form_response`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `form_section`
--
ALTER TABLE `form_section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`superadmin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `eval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `form_page`
--
ALTER TABLE `form_page`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `form_permission`
--
ALTER TABLE `form_permission`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `form_question`
--
ALTER TABLE `form_question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=497;

--
-- AUTO_INCREMENT for table `form_response`
--
ALTER TABLE `form_response`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `form_section`
--
ALTER TABLE `form_section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2018200837;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `superadmin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`evaluator_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`target_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `evaluation_ibfk_3` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_target` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `form_page`
--
ALTER TABLE `form_page`
  ADD CONSTRAINT `form_page_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`);

--
-- Constraints for table `form_permission`
--
ALTER TABLE `form_permission`
  ADD CONSTRAINT `form_permission_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`);

--
-- Constraints for table `form_question`
--
ALTER TABLE `form_question`
  ADD CONSTRAINT `form_question_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`),
  ADD CONSTRAINT `form_question_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `form_section` (`section_id`),
  ADD CONSTRAINT `form_question_ibfk_3` FOREIGN KEY (`page_id`) REFERENCES `form_page` (`page_id`);

--
-- Constraints for table `form_response`
--
ALTER TABLE `form_response`
  ADD CONSTRAINT `form_response_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `form_response_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`),
  ADD CONSTRAINT `form_response_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `form_question` (`question_id`);

--
-- Constraints for table `form_section`
--
ALTER TABLE `form_section`
  ADD CONSTRAINT `form_section_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`),
  ADD CONSTRAINT `form_section_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `form_page` (`page_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD CONSTRAINT `superadmin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
