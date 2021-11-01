-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2021 at 08:00 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

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
(3, 6, 'this is bananabread', '2021-10-21 10:36:51', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

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
(1, 'This is the first post, it\'s a puppy', 'https://picsum.photos/id/237/600/600', 'Cute pup', 3, '2021-10-13 10:02:14', 1, 1, 1),
(2, 'Second post ', 'https://picsum.photos/id/100/600/600', 'This is the second post, by user #2', 2, '2021-10-13 10:37:14', 2, 1, 1),
(3, 'A deer in the woods', 'https://picsum.photos/id/1003/600/600', 'It\'s pretty cute', 1, '2021-10-14 09:52:15', 1, 1, 1),
(4, NULL, '6eb7da79274a9b72e7da042769ec91969290b0fc', NULL, 0, '2021-10-26 09:28:49', 1, 0, 0),
(5, '', 'be7022ba28b09cf5b2e8ff28937c907547f0fb65', '', 0, '2021-10-26 09:39:15', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

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
(1, 'Melissa', 'melissa@dontemailme.com', '$2y$10$z9z1MKmkzlcbN3kr.lqBfO4BS7LhPqjDrMCkiQ0zVGPkcUXgxAtUm', 'https://randomuser.me/api/portraits/women/38.jpg', 'This is my bio blurb. I like tacos. ', 1, 'f7ccaaa4d6a60878f68d605b6de4894cd020bd824e696ce6be9239c05edb', '2021-10-26 10:52:29'),
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
(25, 'Wicked Witch', 'witchy@gmail.com', '$2y$10$PdtR19UmE7wdYOGyvyE2hu9yMgeXICRZcGECg1PqvSkMf2iyRcJuW', 'avatars/W_293_26_93.png', NULL, 0, NULL, '2021-10-26 10:52:29');

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
  MODIFY `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
