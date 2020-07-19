-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 19, 2020 at 11:37 AM
-- Server version: 5.7.29
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phasebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cid` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_uid` bigint(20) UNSIGNED NOT NULL,
  `to_uid` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cid`, `comment`, `from_uid`, `to_uid`, `post_id`, `created_at`, `updated_at`) VALUES
(43, 'Nice pic!', 14, 12, 19, '2020-07-08 04:27:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `friend_reqs`
--

CREATE TABLE `friend_reqs` (
  `fid` bigint(20) UNSIGNED NOT NULL,
  `from` bigint(20) UNSIGNED NOT NULL,
  `to` bigint(20) UNSIGNED NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_reqs`
--

INSERT INTO `friend_reqs` (`fid`, `from`, `to`, `accepted`, `created_at`, `updated_at`) VALUES
(14, 3, 14, 1, '2020-06-15 05:16:57', NULL),
(17, 14, 14, 1, '2020-07-08 04:02:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `like_options`
--

CREATE TABLE `like_options` (
  `lo_id` bigint(20) UNSIGNED NOT NULL,
  `reaction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `like_options`
--

INSERT INTO `like_options` (`lo_id`, `reaction`, `created_at`, `updated_at`) VALUES
(1, 'Liked', NULL, NULL),
(2, 'Dislike', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `mid` bigint(20) UNSIGNED NOT NULL,
  `from` bigint(20) UNSIGNED NOT NULL,
  `to` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`mid`, `from`, `to`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(298, 14, 3, 'fjff', 0, '2020-07-08 04:24:34', '2020-07-08 04:24:34'),
(299, 14, 3, '😉😉', 0, '2020-07-08 04:24:37', '2020-07-08 04:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2020_03_16_093835_create_posts_table', 1),
(4, '2020_03_16_100730_create_comments_table', 1),
(5, '2020_03_16_101642_create_like_options_table', 1),
(6, '2020_03_16_102212_create_reaction_table', 1),
(7, '2020_03_20_095722_create-friends-table', 2),
(8, '2020_03_20_112139_alter-friends-table', 3),
(9, '2020_03_20_161840_create_messages_table', 4),
(13, '2020_05_20_023229_create_notification', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `nid` bigint(20) UNSIGNED NOT NULL,
  `from_uid` bigint(20) UNSIGNED NOT NULL,
  `to_uid` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `notice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`nid`, `from_uid`, `to_uid`, `post_id`, `notice`, `is_read`, `created_at`, `updated_at`) VALUES
(48, 3, 12, 19, 'Samana M liked your post', 0, '2020-06-15 05:18:04', NULL),
(49, 3, 12, 19, 'Samana M liked your post', 0, '2020-06-15 05:18:05', NULL),
(55, 14, 12, 19, 'Ananth Sathvick commented your post <br/>Nice pic!', 0, '2020-07-08 04:27:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `pid` bigint(20) UNSIGNED NOT NULL,
  `post_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_caption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pid`, `post_image`, `post_caption`, `user_id`, `created_at`, `updated_at`) VALUES
(8, '1589532913.jpg', 'Hey there ppl', 2, '2020-05-15 03:25:13', NULL),
(18, '1590781604.jpg', 'HAsjsf', 11, '2020-05-29 14:16:44', NULL),
(19, '1591280301.jpeg', 'Hola amigos', 12, '2020-06-04 08:48:21', NULL),
(21, '1592217898.jpg', 'Paris it is', 3, '2020-06-15 05:14:58', NULL),
(22, '1592217998.png', 'The future is feminist', 3, '2020-06-15 05:16:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `rid` bigint(20) UNSIGNED NOT NULL,
  `reaction` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `from_uid` bigint(20) UNSIGNED NOT NULL,
  `to_uid` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`rid`, `reaction`, `from_uid`, `to_uid`, `post_id`, `created_at`, `updated_at`) VALUES
(25, 1, 3, 3, 21, '2020-06-15 05:15:07', NULL),
(26, 1, 12, 12, 19, '2020-06-15 05:18:00', NULL),
(28, 1, 3, 12, 19, '2020-06-15 05:18:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `work` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `study` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `email_verified_at`, `password`, `bio`, `gender`, `dob`, `work`, `study`, `pro_pic`, `cover_pic`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Varuni S D', 'varuni.ravi@gmail.com', '2020-05-17 09:44:03', '$2y$10$8l/g4A5UHcggwAfEAeoUtObDjrYBpLKGQqTRkQh2WvFxpAcPQsrEW', NULL, 'Female', '2017-03-02', NULL, NULL, NULL, NULL, NULL, '2020-03-18 12:27:18', '2020-03-18 12:27:18'),
(3, 'Samana M', 'samanahmanagoli@gmail.com', '2020-05-17 13:08:21', '$2y$10$gJe5Fhs0moDa7Yh1vHhzpOSeGAvTNvFFQjT39vOzHw6nufQCVJkyK', NULL, 'Female', '1999-03-29', NULL, NULL, 'pro.jpeg', 'cover.jpg', NULL, '2020-03-20 13:17:56', '2020-03-20 13:17:56'),
(4, 'Chaithra R Shetty', 'chaithrashetty399@gmail.com', NULL, '$2y$10$0o6OASB5iiElXxVkeoMh4uL77OfxGo/ebZ5WlKFrVOC93.rXiLtg6', NULL, 'Female', '1999-03-09', NULL, NULL, NULL, NULL, NULL, '2020-03-21 11:25:17', '2020-03-21 11:25:17'),
(11, 'Rakesh G', 'rakeshganesha3@gmail.com', '2020-05-29 14:14:41', '$2y$10$L0WNMCp/Xz.sf6eRkqJOVevHJzrFtXMLellwjR2otZEVrZQZ2wCzG', 'I\'m gibolo', 'Male', '2020-02-29', 'Prostitute', 'JSS', 'pro.jpeg', 'cover.jpg', NULL, '2020-05-29 14:08:49', '2020-05-29 14:14:41'),
(12, 'Srivatsa J', 'srivatsa1199@gmail.com', '2020-06-04 08:44:09', '$2y$10$L4c/iwOIJJnQDK8/BTk9oeQQR//F8NrB1xQpiX7TF6MjCriAOA6De', NULL, 'Male', '1999-05-11', NULL, NULL, NULL, NULL, NULL, '2020-06-04 08:43:01', '2020-06-04 08:44:09'),
(14, 'Ananth Sathvick', 'ananthsathvick@gmail.com', '2020-07-08 03:46:30', '$2y$10$sHplz87a3cf1wHtYWe8qIuMjlC/WyQXN5nEUdhKjsd/PWw2X4BSlG', 'Hey there !', 'Male', '2017-04-03', 'Studying!', 'UVCE', 'pro.jpeg', 'cover.png', NULL, '2020-07-08 03:44:56', '2020-07-08 03:46:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `comments_from_uid_foreign` (`from_uid`),
  ADD KEY `comments_to_uid_foreign` (`to_uid`),
  ADD KEY `comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `friend_reqs`
--
ALTER TABLE `friend_reqs`
  ADD PRIMARY KEY (`fid`),
  ADD UNIQUE KEY `friend_reqs_from_to_unique` (`from`,`to`),
  ADD KEY `friend_reqs_to_foreign` (`to`);

--
-- Indexes for table `like_options`
--
ALTER TABLE `like_options`
  ADD PRIMARY KEY (`lo_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `messages_from_foreign` (`from`),
  ADD KEY `messages_to_foreign` (`to`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`nid`),
  ADD KEY `notification_from_uid_foreign` (`from_uid`),
  ADD KEY `notification_to_uid_foreign` (`to_uid`),
  ADD KEY `notification_post_id_foreign` (`post_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `reactions_reaction_foreign` (`reaction`),
  ADD KEY `reactions_from_uid_foreign` (`from_uid`),
  ADD KEY `reactions_to_uid_foreign` (`to_uid`),
  ADD KEY `reactions_post_id_foreign` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `friend_reqs`
--
ALTER TABLE `friend_reqs`
  MODIFY `fid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `like_options`
--
ALTER TABLE `like_options`
  MODIFY `lo_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `mid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `nid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `pid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `rid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_from_uid_foreign` FOREIGN KEY (`from_uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`pid`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_to_uid_foreign` FOREIGN KEY (`to_uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `friend_reqs`
--
ALTER TABLE `friend_reqs`
  ADD CONSTRAINT `friend_reqs_from_foreign` FOREIGN KEY (`from`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_reqs_to_foreign` FOREIGN KEY (`to`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_foreign` FOREIGN KEY (`from`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_to_foreign` FOREIGN KEY (`to`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_from_uid_foreign` FOREIGN KEY (`from_uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`pid`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_to_uid_foreign` FOREIGN KEY (`to_uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_from_uid_foreign` FOREIGN KEY (`from_uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `reactions_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`pid`) ON DELETE CASCADE,
  ADD CONSTRAINT `reactions_reaction_foreign` FOREIGN KEY (`reaction`) REFERENCES `like_options` (`lo_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reactions_to_uid_foreign` FOREIGN KEY (`to_uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
