-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2024 at 10:55 AM
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
-- Database: `tutor_connect_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL,
  `deadline_material_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `total_marks` int(11) DEFAULT 0,
  `obtained_marks` int(11) DEFAULT 0,
  `is_get_marks` tinyint(2) DEFAULT 0,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`id`, `deadline_material_id`, `user_id`, `file_path`, `total_marks`, `obtained_marks`, `is_get_marks`, `submitted_at`) VALUES
(3, 6, 8, '8_9912070075.png', 10, 8, 1, '2024-07-20 12:23:26'),
(5, 9, 1, '1_1332927009.jpg', 0, 0, 0, '2024-10-16 05:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `class_notification`
--

CREATE TABLE `class_notification` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `class_date` date DEFAULT NULL,
  `from_time` time DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_notification`
--

INSERT INTO `class_notification` (`id`, `course_id`, `user_id`, `title`, `content`, `class_date`, `from_time`, `to_time`, `created_at`, `is_read`) VALUES
(2, 3, 2, 'Aut labore modi elig', 'Iusto sed labore aut', '1970-10-15', '07:31:00', '20:07:00', '2024-08-16 10:52:13', 0),
(3, 1, 2, 'Nam quis ipsam labor', 'Tempor modi molestia', '2024-08-22', '20:00:00', '18:53:00', '2024-08-16 10:52:28', 0),
(4, 1, 2, 'Meeting fdgfdsgdf fsdgsdf', 'kdjfdasjfkdsjklsjfkldsjfklsdjfksdljfdklsjflksdjf lk djfkljf\r\nLink Joining: https://meet.google.com/wqs-ugkr-yuq', '2024-10-12', '13:54:00', '15:54:00', '2024-10-07 08:54:25', 0),
(5, 3, 2, 'Meeting', 'Comkmfksjdklfjlkdsjfkljfjd', '2024-10-15', '03:19:00', '15:19:00', '2024-10-12 22:19:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `complaint_text` text NOT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `admin_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `complaint_text`, `status`, `admin_response`, `created_at`) VALUES
(1, 1, 'kljfalk;jfkdsjflk jflsdjflksdjflk;sadjfkl; sdjf', 'resolved', 'ok apky complent per amal ho rha hai', '2024-10-12 08:47:05'),
(2, 1, ';kj;dsjfkladsjfsdjfkldsjfklsadjfljhsdfjk dnbfmnsdbfmndsbf,mas', 'resolved', 'i know ', '2024-10-12 08:47:12'),
(3, 2, 'ye student bahoot batmezi kar rha hai please isko nikal do', 'pending', NULL, '2024-10-12 09:03:08'),
(4, 20, 'adfdsfdsf', 'pending', NULL, '2024-10-12 21:36:39'),
(5, 20, 'dfasdfdsahfdgdgf', 'pending', NULL, '2024-10-12 21:36:47'),
(6, 20, 'afewrewtretrytfjncvn', 'pending', NULL, '2024-10-12 21:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(20,2) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `section_id`, `name`, `description`, `price`, `video_path`, `created_at`) VALUES
(1, 1, 'Php', 'This is for Php', 1000.00, '1728751013_Video.mp4', '2024-07-16 14:17:49'),
(3, 2, 'Python', 'This is Python Couse', 600.00, '1728751366_Video.mp4', '2024-07-16 16:14:30'),
(4, 1, 'Web Develpment', 'This is a Web development course', 700.00, '1728751376_Video.mp4', '2024-10-12 16:04:33'),
(5, 3, 'Data Science', 'This is a data science course', 900.00, '1728751515_Video.mp4', '2024-10-12 16:43:35'),
(6, 2, 'Web Designing', 'In this course we will tech you HTML,CSS,Javascript,Bootstrip5', 1200.00, '1728751586_Video.mp4', '2024-10-12 16:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `course_feedback`
--

CREATE TABLE `course_feedback` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(5) NOT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_feedback`
--

INSERT INTO `course_feedback` (`id`, `course_id`, `user_id`, `rating`, `comments`, `created_at`) VALUES
(1, 1, 1, 5, 'dshkjhjkhckjxzckjxzhcjkxzhl', '2024-10-12 07:00:22'),
(2, 3, 1, 5, 'jlhlkjlkjhjhljdhjkd', '2024-10-12 07:01:15'),
(3, 3, 1, 4, 'lkjkl;jkljlk;klk', '2024-10-12 07:02:52');

-- --------------------------------------------------------

--
-- Table structure for table `course_instructor_assigned`
--

CREATE TABLE `course_instructor_assigned` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_instructor_assigned`
--

INSERT INTO `course_instructor_assigned` (`id`, `course_id`, `instructor_id`, `assigned_at`) VALUES
(1, 1, 9, '2024-07-16 18:57:58'),
(3, 1, 2, '2024-07-16 18:58:16'),
(4, 3, 2, '2024-07-17 13:11:37'),
(5, 4, 11, '2024-10-12 16:10:52');

-- --------------------------------------------------------

--
-- Table structure for table `course_materials`
--

CREATE TABLE `course_materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_materials`
--

INSERT INTO `course_materials` (`id`, `course_id`, `user_id`, `title`, `content`, `file_path`, `created_at`) VALUES
(7, 1, 2, 'Video', 'rauf', '2_4759740800.mp4', '2024-07-18 16:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `course_registration`
--

CREATE TABLE `course_registration` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transaction_no` varchar(255) DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `price` decimal(20,2) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_registration`
--

INSERT INTO `course_registration` (`id`, `course_id`, `user_id`, `transaction_no`, `receipt_path`, `price`, `payment_status`, `created_at`) VALUES
(3, 1, 1, '56465456465465', '1_1725893375.jpg', 500.00, 'Rejected', '2024-08-15 09:30:25'),
(4, 3, 1, '75674878768', '1_3160211571.png', 600.00, 'Verified', '2024-08-15 09:31:29'),
(5, 1, 8, '65448972', '8_3254293241.jpg', 500.00, 'Verified', '2024-08-16 13:15:28'),
(6, 3, 8, '874654654', '8_4020376962.jpg', 600.00, 'Verified', '2024-08-16 13:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `deadline_materials`
--

CREATE TABLE `deadline_materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('lecture','assignment','quiz') NOT NULL,
  `content` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deadline_materials`
--

INSERT INTO `deadline_materials` (`id`, `course_id`, `user_id`, `title`, `type`, `content`, `file_path`, `from_date`, `to_date`, `created_at`) VALUES
(4, 1, 2, 'fgfdgsfd g', 'lecture', '23312afdsafdfd', '2_6935292541.pdf', '2024-07-17', '2024-07-26', '2024-07-17 12:47:07'),
(5, 3, 2, 'ghfdhgfdh', 'assignment', 'hgfhfdghgfdh', '2_3915731912.docx', '2024-07-17', '2024-08-15', '2024-07-17 13:12:16'),
(6, 1, 2, 'dsfdsgfdgf', 'assignment', 'fgfdsgertr', '2_2333576706.docx', '2024-07-18', '2024-08-31', '2024-07-18 14:21:15'),
(7, 1, 2, 'Question No:1', 'quiz', 'the question is the like jnkashd jhj  hsdjsahj', '2_3832170304.png', '2024-07-20', '2024-07-25', '2024-07-20 15:49:49'),
(8, 3, 2, 'kjhljhjkl', 'lecture', 'Meeting', NULL, '2024-10-15', '2024-10-17', '2024-10-12 22:21:55'),
(9, 3, 2, 'Quiz', 'quiz', 'dasd', '2_3609836114.jpg', '2024-10-16', '2024-10-23', '2024-10-16 05:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `company_name`, `job_title`, `start_date`, `end_date`, `description`, `created_at`) VALUES
(0, 2, 'Macias Butler LLC', 'Aspernatur exercitat', '1999-03-18', '2004-07-31', 'Nobis vitae et irure', '2024-08-15 10:41:10'),
(0, 2, 'Salazar Taylor Associates', 'Aute voluptatem non ', '2006-03-23', '2018-06-19', 'Deserunt ducimus et', '2024-08-15 10:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(1, 3, 2, 'fdfjksf', '2024-10-12 05:57:51'),
(2, 3, 2, 'lklkjkjaskf', '2024-10-12 05:57:59'),
(3, 3, 2, 'dasfdsafdsewrqrrewrew', '2024-10-12 05:58:04'),
(4, 3, 2, 'dsfxzcvxzcvxzcv', '2024-10-12 05:58:06'),
(5, 3, 2, 'fasdfadsfdasfdsf', '2024-10-12 05:58:10'),
(6, 3, 2, 'ewrewrewr', '2024-10-12 05:58:13'),
(7, 3, 1, 'dfgfgsd', '2024-10-12 05:59:31'),
(8, 3, 1, 'sfdgfdsgfdsgf', '2024-10-12 05:59:33'),
(9, 3, 1, 'sgfsxvcbcvb', '2024-10-12 05:59:35'),
(10, 1, 9, 'vbncvnv', '2024-10-12 06:08:00'),
(11, 1, 2, 'dhgfhhdfgcv', '2024-10-12 06:16:32'),
(12, 1, 2, 'vxcvxz', '2024-10-12 06:21:24'),
(13, 3, 9, 'dsfasfsdgdfgd', '2024-10-12 06:23:41'),
(14, 3, 9, 'gfgxcvxcbvcxbvcb', '2024-10-12 06:23:43'),
(15, 3, 9, 'bxvcbvcbvcbvxcb', '2024-10-12 06:23:46'),
(16, 3, 11, 'hhhhhhh', '2024-10-12 06:23:53'),
(17, 2, 3, 'bvnvbnvcnv', '2024-10-12 06:32:54'),
(18, 2, 3, 'fgdhfstrstdgdfhgjhkfj', '2024-10-12 06:32:58'),
(19, 2, 3, 'dfsdfasdfsd', '2024-10-12 06:35:20'),
(20, 2, 3, 'skdjssdkvnnvmxc\n', '2024-10-12 06:36:25'),
(21, 2, 3, 'vxcvzxcvxczv', '2024-10-12 06:36:28'),
(22, 2, 1, 'dfdfadfsdf', '2024-10-12 06:37:07'),
(23, 4, 2, 'fgfdgdfsgfdg', '2024-10-12 21:39:33'),
(24, 4, 9, 'dfsfsdfdsf', '2024-10-12 21:48:25'),
(25, 4, 9, 'xcvxcbxcvbcvb', '2024-10-12 21:48:27'),
(26, 20, 9, 'xbvcbcvbcxvbvcb', '2024-10-12 21:48:30'),
(27, 20, 2, 'jhfajldsldsjflkd', '2024-10-12 21:48:45'),
(28, 20, 2, 'cxxcvzxcvx', '2024-10-12 21:49:37'),
(29, 2, 20, 'yes of course', '2024-10-12 21:51:12'),
(30, 2, 20, 'kjhjkhkljhkjl', '2024-10-12 21:55:34'),
(31, 2, 20, 'klj;kkllkj;', '2024-10-12 21:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Student'),
(2, 'Tutor'),
(3, 'Administrator'),
(4, 'Parent');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending',
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`id`, `tutor_id`, `amount`, `payment_status`, `payment_date`) VALUES
(1, 2, 1500.00, 'Pending', '2024-12-05 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `created_at`) VALUES
(1, 'Class A', '2024-10-12 15:55:00'),
(2, 'Class B', '2024-10-12 15:55:06'),
(3, 'Class C', '2024-10-12 15:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `parent_student_id` int(11) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `address`, `phone`, `profile_photo`, `password`, `role_id`, `parent_student_id`, `isActive`, `created_at`) VALUES
(1, 'student', 'student@gmail.com', '', '', '1728769410_user_1.jpg', '$2y$10$cQPzUVw8ZD8K2t2kaVCM6.Hu.wfMX4lu7xbz8OGSDp0OhqIYStS2.', 1, NULL, 1, '2024-07-15 19:07:31'),
(2, 'Mulajan123', 'ins@gmail.com', 'Village Waligai P/O Waligai Tehsel Domail District Bannu', '03366645807', '1728769404_user.jpg', '$2y$10$cQPzUVw8ZD8K2t2kaVCM6.Hu.wfMX4lu7xbz8OGSDp0OhqIYStS2.', 2, NULL, 1, '2024-07-15 18:40:09'),
(3, 'admin', 'admin@gmail.com', 'Village Waligai P/O Waligai Tehsel Domail District Bannu', '03366645807', '3_msg2.png', '$2y$10$cQPzUVw8ZD8K2t2kaVCM6.Hu.wfMX4lu7xbz8OGSDp0OhqIYStS2.', 3, NULL, 1, '2024-07-15 19:07:31'),
(8, 'kaleeem', 'kaleem@gmail.com', '', '', '1721137084_1208507_amazing_gaming_wallpapers_hd_3840x2160.jpg', '$2y$10$KnNvr1GTyeSPzToCCiZTS.25q.KSHj62/jQ8P4oaJHQAqIjztj.De', 1, NULL, 1, '2024-07-16 10:18:01'),
(9, 'AsadKhan2', 'asad2@gmail.com', '2 Village Waligai P/O Waligai Tehsel Domail District Bannu', '03362222222', '1728769419_user_3.jpg', '$2y$10$XvbEq4V5NY2Z3F.AiiIUNuIDRv85h9vkjEuYrznbRf3nrwoOTC1a2', 2, NULL, 1, '2024-07-16 10:19:17'),
(11, 'kaleemjani', 'kaleemjani@gmail.com', '', '', '1728769396_profile.jpg', '$2y$10$Elz/Cjk.UVHmkJ5HUjl/j.O1T34KcibM7dIMDZiRqPbYru4w/w.cu', 2, NULL, 1, '2024-07-29 13:51:07'),
(16, 'raufjanan', 'raufjanan@gmail.com', '', '', '1728769309_msg3.png', '$2y$10$w1jSXdGhxNybUmYMoy1Mo.jug9bK0yq0ay9q3iQ0eOaRUBYo6LcB.', 1, NULL, 1, '2024-07-29 15:28:39'),
(18, 'admingdfgfdg', 'raufkhalid90@hotmail.com', '', '', '1728769318_msg4.png', '$2y$10$GxzP1nzRy.0az65PDfR.yusGXAmdnYK/tWsKnclstxCP.fM4gNmL.', 1, NULL, 1, '2024-07-29 15:32:55'),
(19, 'kaleem212', 'kaleem212@gmail.com', '', '', '1728769326_user_img.jpg', '$2y$10$4ibYUh6xiGqsv3zjtf9MoeWHjJ2wl.Wk909Lzs94aEN7iK71yduy.', 1, NULL, 1, '2024-07-29 15:34:51'),
(20, 'Parent1', 'parent1@gmail.com', 'fgfdsgfd fg fdsgsdgfsdggdfg fg fd gfdg df', '03445874569', '20_msg5.png', '$2y$10$tywPxRErxVEGkIaGhwPMYuieHA1dH5gjkotsVvnMITQXbSQHIP9MC', 4, 8, 1, '2024-10-12 20:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `notification_id`, `is_read`, `read_at`) VALUES
(1, 1, 5, 1, '2024-12-25 09:46:24'),
(2, 1, 3, 1, '2024-12-25 09:46:30'),
(3, 3, 5, 1, '2024-12-25 09:52:35'),
(4, 3, 3, 1, '2024-12-25 09:54:26'),
(5, 3, 2, 1, '2024-12-25 09:54:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deadline_material_id` (`deadline_material_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `class_notification`
--
ALTER TABLE `class_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_section` (`section_id`);

--
-- Indexes for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course_instructor_assigned`
--
ALTER TABLE `course_instructor_assigned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `course_materials`
--
ALTER TABLE `course_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course_registration`
--
ALTER TABLE `course_registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `deadline_materials`
--
ALTER TABLE `deadline_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parent_student` (`parent_student_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `notification_id` (`notification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `class_notification`
--
ALTER TABLE `class_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_feedback`
--
ALTER TABLE `course_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_instructor_assigned`
--
ALTER TABLE `course_instructor_assigned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_materials`
--
ALTER TABLE `course_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course_registration`
--
ALTER TABLE `course_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deadline_materials`
--
ALTER TABLE `deadline_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD CONSTRAINT `assignment_submissions_ibfk_1` FOREIGN KEY (`deadline_material_id`) REFERENCES `deadline_materials` (`id`),
  ADD CONSTRAINT `assignment_submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_section` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD CONSTRAINT `course_feedback_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_instructor_assigned`
--
ALTER TABLE `course_instructor_assigned`
  ADD CONSTRAINT `course_instructor_assigned_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructor_assigned_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_materials`
--
ALTER TABLE `course_materials`
  ADD CONSTRAINT `course_materials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_materials_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_registration`
--
ALTER TABLE `course_registration`
  ADD CONSTRAINT `course_registration_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_registration_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deadline_materials`
--
ALTER TABLE `deadline_materials`
  ADD CONSTRAINT `deadline_materials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deadline_materials_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_parent_student` FOREIGN KEY (`parent_student_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notifications_ibfk_2` FOREIGN KEY (`notification_id`) REFERENCES `class_notification` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
