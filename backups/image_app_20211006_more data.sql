-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2021 at 08:53 PM
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
(2, 2, 'This is the second comment on the second post by user #2', '2021-10-13 10:38:39', 2, 1);

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
(1, 'This is the first post, it\'s a puppy', 'https://picsum.photos/id/237/600/600', 'Cute pup', 2, '2021-10-13 10:02:14', 1, 1, 1),
(2, 'Second post ', 'https://picsum.photos/id/100/600/600', 'This is the second post, by user #2', 2, '2021-10-13 10:37:14', 2, 1, 1),
(3, 'A deer in the woods', 'https://picsum.photos/id/1003/600/600', 'It\'s pretty cute', 1, '2021-10-14 09:52:15', 1, 1, 1);

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
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_pic`, `bio`, `is_admin`) VALUES
(1, 'Melissa', 'melissa@dontemailme.com', 'password', 'https://randomuser.me/api/portraits/women/38.jpg', 'This is my bio blurb. I like tacos. ', 1),
(2, 'Sharlene Wood', 'sharlene@example.com', 'newpassword', 'https://randomuser.me/api/portraits/women/35.jpg', 'this is sharlene\'s shiny new bio', 0),
(4, 'Another Person', 'cheeseburger@mail.com', 'password123', NULL, NULL, 0),
(5, 'Anonymous Squirrel', 'acorns@mail.com', 'password123', NULL, NULL, 0);

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
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

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
  MODIFY `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
