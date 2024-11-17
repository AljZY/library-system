-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 02:48 PM
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
-- Database: `library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `isbn`, `category`, `title`, `author`, `file_path`, `created_at`, `updated_at`) VALUES
(15, '978-0-7475-3269-9', '800-899 Literature', 'Harry Potter and the Philosopher\'s Stone', 'J. K. Rowling', 'books/lNajk1kuCJcSCQFyctq6ALOT1BSRqbsG6RQ23EQj.jpg', '2024-11-17 05:16:09', '2024-11-17 05:16:09'),
(16, '0-7475-3849-2', '800-899 Literature', 'Harry Potter and the Chamber of Secrets', 'J. K. Rowling', 'books/H7CXqxr6WwQR85IB0cUY6SQBdfejj7xHaXetg9Gz.jpg', '2024-11-17 05:17:54', '2024-11-17 05:17:54'),
(17, '0-7475-4215-5', '800-899 Literature', 'Harry Potter and the Prisoner of Azkaban', 'J. K. Rowling', 'books/sPF3mzeMJuokhojXvZGrdlh3MRFRBipi9zsAzOMA.jpg', '2024-11-17 05:19:34', '2024-11-17 05:19:34'),
(18, '0-7475-5079-4', '800-899 Literature', 'Harry Potter and the Goblet of Fire', 'J. K. Rowling', 'books/KwvLX9iwPprYI6sejwYqhEeB8r5b0OIIVOYC0cSQ.png', '2024-11-17 05:22:05', '2024-11-17 05:22:05'),
(19, '0-7475-5100-6', '800-899 Literature', 'Harry Potter and the Order of the Phoenix', 'J. K. Rowling', 'books/7GAu1xnXH5yvFplEdxOIB18OhZiQ6m6oaJQMUaER.jpg', '2024-11-17 05:23:38', '2024-11-17 05:23:38'),
(20, '0-7475-8108-8', '800-899 Literature', 'Harry Potter and the Half-Blood Prince', 'J. K. Rowling', 'books/ghHV2QVg2NeXGdYcMSH3NLUctAgbz0m5PV2gA0FS.png', '2024-11-17 05:25:07', '2024-11-17 05:25:07'),
(21, '9780751565355', '800-899 Literature', 'Harry Potter and the Cursed Child', 'J. K. Rowling', 'books/pHUL4GiSLgteh4JFQZqfXsJ8QMOb8Gj9xF4xD5gu.jpg', '2024-11-17 05:27:58', '2024-11-17 05:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`id`, `book_id`, `member_id`, `borrow_date`, `due_date`, `created_at`, `updated_at`) VALUES
(17, 21, 22, '2024-11-17', '2024-11-24', '2024-11-17 05:30:49', '2024-11-17 05:30:49'),
(18, 18, 22, '2024-11-17', '2024-11-25', '2024-11-17 05:32:00', '2024-11-17 05:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_history`
--

CREATE TABLE `borrow_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrow_history`
--

INSERT INTO `borrow_history` (`id`, `book_id`, `member_id`, `borrow_date`, `due_date`, `return_date`, `created_at`, `updated_at`) VALUES
(16, 21, 22, '2024-11-17', '2024-11-24', NULL, '2024-11-17 05:30:49', '2024-11-17 05:30:49'),
(17, 18, 22, '2024-11-17', '2024-11-25', NULL, '2024-11-17 05:32:00', '2024-11-17 05:32:00'),
(18, 20, 22, '2024-11-17', '2024-11-22', '2024-11-17', '2024-11-17 05:32:22', '2024-11-17 05:32:22');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `address`, `contact_number`, `password`, `created_at`, `updated_at`) VALUES
(19, 'Natsu Dragniel', 'Fairy Tail Building, Magnolia Town', '09123456789', '$2y$12$P33H0L2otL9QNCqvxrOn7.sfQeBmR3LN5m1uC112mwd5I.ofRcH4K', '2024-11-17 05:04:19', '2024-11-17 05:04:19'),
(20, 'Gray Fullbuster', 'Fairy Tail Building, Magnolia Town', '09090909090', '$2y$12$2wnWHIyxOBBo19b93LWP2uCwuzqD2LUrP6wxLjHQpHXIQwsMGOKk2', '2024-11-17 05:05:32', '2024-11-17 05:05:32'),
(21, 'Erza Scarlet', 'Fairy Tail Building, Magnolia Town', '09876543210', '$2y$12$wjCTYSNJiHSP/PnGClmRYesuoKZB3CArtw1EPyeaX5AttaemGGBRq', '2024-11-17 05:06:32', '2024-11-17 05:06:32'),
(22, 'Lucy Heartfilia', 'Lucy Apartment, Magnolia Town', '09123123123', '$2y$12$n/x2/CfIqzLueBDMRsXiCOBz1dnNYcMfirL4dyfTD7Dc1hB0ruUcS', '2024-11-17 05:07:24', '2024-11-17 05:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `return_history`
--

CREATE TABLE `return_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1HeauggKgSsuilhi5O5shDusr8ljEhmHDjJ4ckjg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnpQNkloSU45RFloSlFlWUJiUm5Yd3NQWGJvNE9GbmtqTTdYWXU4ayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ib3Jyb3ctaGlzdG9yeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1731850379),
('w3cxAHsHfUqQMq54y5rpQGCBJKLhpYFRozpXcaGM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2hvbWVwYWdlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IktjN0NLRzgyNlM2WUxZRG04dEpiRHN1cW5YaFpsREh1eXgwZ0JWYXQiO3M6MTU6ImFkbWluX2xvZ2dlZF9pbiI7YjoxO30=', 1731801258);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrows_book_id_foreign` (`book_id`);

--
-- Indexes for table `borrow_history`
--
ALTER TABLE `borrow_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrow_history_book_id_foreign` (`book_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_history`
--
ALTER TABLE `return_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_history_book_id_foreign` (`book_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `borrow_history`
--
ALTER TABLE `borrow_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `return_history`
--
ALTER TABLE `return_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `borrows_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrow_history`
--
ALTER TABLE `borrow_history`
  ADD CONSTRAINT `borrow_history_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `return_history`
--
ALTER TABLE `return_history`
  ADD CONSTRAINT `return_history_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
