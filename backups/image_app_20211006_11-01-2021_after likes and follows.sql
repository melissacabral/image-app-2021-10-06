-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2021 at 05:48 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `image_app_20211006`
--
CREATE DATABASE IF NOT EXISTS `image_app_20211006` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `image_app_20211006`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` mediumint(9) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Black and White'),
(2, 'Portraits'),
(3, 'Pet Photography'),
(4, 'Weddings'),
(5, 'Landscapes'),
(6, 'Macro Photos');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `body` varchar(2000) NOT NULL,
  `date` datetime NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `body`, `date`, `post_id`, `is_approved`) VALUES
(1, 1, 'this is a comment on the first post, by user #1!', '2021-10-13 19:37:19', 1, 1),
(2, 2, 'This is the second comment on the second post by user #2', '2021-10-13 10:38:39', 2, 1),
(3, 6, 'this is bananabread', '2021-10-21 10:36:51', 3, 1),
(4, 1, 'this reloads the page', '2021-10-29 09:19:41', 12, 1),
(5, 1, 'this is actually really slow', '2021-10-29 09:20:32', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
CREATE TABLE `follows` (
  `f_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followee_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`f_id`, `follower_id`, `followee_id`, `date`) VALUES
(0, 1, 26, '2021-11-01 09:39:18'),
(0, 1, 25, '2021-11-01 09:46:27'),
(0, 1, 24, '2021-11-01 09:46:28'),
(0, 1, 23, '2021-11-01 09:46:30'),
(0, 1, 22, '2021-11-01 09:46:31');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `like_id` mediumint(9) NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `post_id`, `user_id`) VALUES
(3, 9, 1),
(4, 8, 2),
(5, 12, 2),
(6, 12, 22),
(7, 12, 25),
(8, 12, 26);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` mediumint(9) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  `body` varchar(2000) DEFAULT NULL,
  `category_id` mediumint(9) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `image`, `body`, `category_id`, `date`, `user_id`, `allow_comments`, `is_published`) VALUES
(4, NULL, '6eb7da79274a9b72e7da042769ec91969290b0fc', NULL, 0, '2021-10-26 09:28:49', 1, 0, 0),
(5, '', 'be7022ba28b09cf5b2e8ff28937c907547f0fb65', '', 0, '2021-10-26 09:39:15', 1, 0, 0),
(6, 'hgklghkl', '15e540a3ee6b85019c51dd1b1cd0e6b3c8e1e20c', 'dfghdfhjdfhj', 1, '2021-10-27 08:08:38', 1, 0, 0),
(7, '', 'ed326b0155e1e4d44abf4ac74eee182fb1da8857', '', 0, '2021-10-27 08:45:01', 1, 0, 0),
(8, 'Lunch Time!', 'ddf2b87ce33e96d5ab0c39f8af572eebcaecd980', 'Testing the form', 1, '2021-10-27 09:53:37', 1, 1, 1),
(9, 'Lego tournament', '88c2ad8c972dc521793864566d4f96170d743b26', 'Classic Castle', 6, '2021-10-27 10:41:13', 1, 1, 1),
(10, 'Keyboard trooper', '74ca9aee5741b36f0554f3cfed2c2043ad2023b6', 'I break every keyboard', 1, '2021-10-27 10:42:06', 1, 1, 1),
(11, 'Zombies again', 'b3e505af485a35084daff86c29a3e3ca4a482f13', 'By Dr. Frank', 6, '2021-10-27 10:53:41', 22, 1, 1),
(12, 'Lunch Time', 'e5ea51e2815b7c9e476921484d9e636cdc5f4b5e', 'I&#39;m hungry!!!', 6, '2021-10-28 09:14:44', 22, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings` (
  `rating_id` mediumint(9) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `rating`, `post_id`, `user_id`) VALUES
(5, 3, 1, 1),
(6, 5, 1, 1),
(7, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `tag_id` mediumint(9) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `name`) VALUES
(1, 'tag1'),
(2, 'tag2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` mediumint(9) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  `bio` varchar(2000) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `join_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_pic`, `bio`, `is_admin`, `access_token`, `join_date`) VALUES
(1, 'Melissa', 'melissa@dontemailme.com', '$2y$10$z9z1MKmkzlcbN3kr.lqBfO4BS7LhPqjDrMCkiQ0zVGPkcUXgxAtUm', 'https://randomuser.me/api/portraits/women/38.jpg', 'This is my bio blurb. I like tacos. ', 1, '5a1477f1de0f0deba79f5d96fb69a061354b94a948483881843ffd321476', '2021-10-26 10:52:29'),
(2, 'Sharlene Wood', 'sharlene@example.com', '$2y$10$DukPEBDFTI3dzjq4sMftSekHSTjoTvWBw9TUIqtY6koo9F7GotTRy', 'https://randomuser.me/api/portraits/women/35.jpg', 'this is sharlene\'s shiny new bio', 0, NULL, '2021-10-26 10:52:29'),
(4, 'Another Person', 'cheeseburger@mail.com', '$2y$10$DukPEBDFTI3dzjq4sMftSekHSTjoTvWBw9TUIqtY6koo9F7GotTRy', NULL, NULL, 0, NULL, '2021-10-26 10:52:29'),
(5, 'Anonymous Squirrel', 'acorns@mail.com', '$2y$10$DukPEBDFTI3dzjq4sMftSekHSTjoTvWBw9TUIqtY6koo9F7GotTRy', NULL, NULL, 0, NULL, '2021-10-26 10:52:29'),
(6, 'Bananabread', 'banana@bread.com', '$2y$10$DukPEBDFTI3dzjq4sMftSekHSTjoTvWBw9TUIqtY6koo9F7GotTRy', NULL, NULL, 0, 'f98b0c720a7c2a9a5a2ee48f6e117bb17843f39e93e46a33153dd9d3c343', '2021-10-26 10:52:29'),
(7, 'Zucchini Bread', 'zucc@bread.com', '$2y$10$bYZTi81GS/J3mAkgL6yEX.64Ralr.U02RWtcSNfwpKyWQPyOaMC8q', NULL, NULL, 0, NULL, '2021-10-26 10:52:29'),
(9, 'New person ', 'newbie@email.com', '$2y$10$uWAK.T56CpyP7tFUzlciFOWeG.0ZT4QALxsmKVe2paJGJ9snJ6Jo6', NULL, NULL, 0, NULL, '2021-10-26 10:52:29'),
(21, 'Mad Scientist', 'madness@mail.com', '$2y$10$4WDxorrA6FQTJgzgjZKFIu5UWlbL.rr9CaJu8FZvpRnqIp.I930v.', 'images/M_347_26_96.png', NULL, 0, NULL, '2021-10-26 10:52:29'),
(22, 'Frankenstein', 'frank@gmail.com', '$2y$10$ze7Oio3RuyHbjCKAda.bMeLF/kp39DudsVtj5neTYCmuJKmjGgzc.', 'avatars/F_260_35_90.png', NULL, 0, NULL, '2021-10-26 10:52:29'),
(23, 'Count Dracula', 'Draco@gmail.com', '$2y$10$TEuIae5P0NZGhq2oaOn5NuDmEeri9XoLaigZDFbWpz28sWUbuAAkS', 'avatars/C_317_34_95.png', NULL, 0, NULL, '2021-10-26 10:52:29'),
(24, 'Jack o&#39;Lantern', 'Jack@gmail.com', '$2y$10$fZk/poqbR7iGVPxvbzT0OuI6//UoVtkEi6S68Q6iAKCU9u1TyUydi', 'avatars/J_150_31_92.png', NULL, 0, NULL, '2021-10-26 10:52:29'),
(25, 'Wicked Witch', 'witchy@gmail.com', '$2y$10$PdtR19UmE7wdYOGyvyE2hu9yMgeXICRZcGECg1PqvSkMf2iyRcJuW', 'avatars/W_293_26_93.png', NULL, 0, NULL, '2021-10-26 10:52:29'),
(26, 'Spooky Bat', 'bat@mail.com', '$2y$10$DMT6U1MzFL2SR5BoJ8K0duciz7zQKeojsoTK7KFpbD6LY51Sv0ZW6', 'avatars/S_255_41_95.png', NULL, 0, NULL, '2021-10-28 09:35:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
