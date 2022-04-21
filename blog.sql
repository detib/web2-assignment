-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2022 at 05:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user`, `body`, `time`, `post_id`) VALUES
(1, 'detib', 'This is the first comment\r\n', '2022-04-20 14:24:44', 6),
(2, 'detib', 'This is the second comment\r\n', '2022-04-20 14:26:46', 6),
(3, 'detib', 'This is the first good coment', '2021-04-20 14:28:02', 6),
(4, 'detib', 'This is a good comment', '2022-04-20 16:04:07', 6),
(5, 'user1', 'Test comment from another user', '2022-04-20 16:14:22', 6),
(6, 'user4', 'Test from user4\r\n', '2022-04-20 16:15:22', 6),
(7, 'user4', 'This is the first comment on this post', '2022-04-20 16:15:39', 5),
(8, 'user4', 'This is the comment with breaks\r\nThis is a comment with breaks\r\nThis is a comment with breaks\r\n\r\nThis is a comment with breaks\r\n', '2022-04-20 16:16:26', 5),
(9, 'detib', 'This is a comment with \r\nLine break', '2022-04-20 17:00:20', 10),
(10, 'user1', 'jdsaiajdpsadpsaoj', '2022-04-20 17:17:37', 10),
(11, 'user1', 'test\r\n\r\n\r\n\r\n', '2022-04-20 22:52:14', 11),
(12, 'detib', 'Comment', '2022-04-21 02:42:05', 14),
(13, 'detib', 'Comment2', '2022-04-21 02:42:13', 14),
(14, 'detib', 'Comment', '2022-04-21 02:42:34', 13),
(15, 'detib', 'Comment', '2022-04-21 02:42:39', 13),
(16, 'detib', 'Comment', '2022-04-21 02:42:42', 13),
(17, 'detib', 'Comment', '2022-04-21 02:42:45', 13),
(18, 'detib', 'WTF', '2022-04-21 02:45:13', 15);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'general',
  `post_image` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `edit_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `category`, `post_image`, `date`, `edit_date`) VALUES
(13, 'Title', 'SUB TITLE BREAK FIXED^%implode%^SUB TITLE BREAK FIXEDSUB TITLE BREAK FIXED   *%^sp^%* PARAGRAPH BREAK FIXEDPARAGRAPH BREAK FIXED^%break%^\r\n^%break%^\r\nPARAGRAPH BREAK FIXED^%break%^\r\n^%break%^\r\nPARAGRAPH BREAK FIXED^%implode%^PARAGRAPH BREAK FIXEDPARAGRAPH BREAK FIXED^%break%^\r\nPARAGRAPH BREAK FIXEDPARAGRAPH BREAK FIXED^%break%^\r\nPARAGRAPH BREAK FIXEDPARAGRAPH BREAK FIXED^%break%^\r\nPARAGRAPH BREAK FIXEDPARAGRAPH BREAK FIXED', 'php', 'learnjs.jpeg', '2022-04-20 23:26:46', '2022-04-21 03:37:59'),
(14, 'Main Title', 'Sub TITLE 1^%implode%^Sub TITLE 2  *%^sp^%* Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus odio, consequuntur similique dolor sunt esse quis? Doloribus atque perspiciatis, dolore rerum nihil doloremque. Minima, qui quia. Aliquam in, dolorum vitae sit provident quae sequi, recusandae minus quisquam perferendis hic quaerat magni illum ipsam maxime, eveniet consectetur! Provident hic sapiente beatae necessitatibus. Atque adipisci vitae iste minus! Ducimus, ullam aliquid deleniti tempora amet earum et necessitatibus nulla nam quam minima aliquam reiciendis impedit minus totam numquam quibusdam nisi id sed? Qui placeat tempore illo iure repellendus reprehenderit quasi alias quas, rem adipisci expedita nisi cupiditate itaque sequi omnis. Totam, provident inventore?^%break%^\n^%break%^\nLorem ipsum dolor sit amet consectetur adipisicing elit. Cum sit maxime ullam reprehenderit enim harum maiores quidem ab possimus, aperiam in sapiente beatae ducimus accusamus, numquam alias veritatis necessitatibus illum libero amet accusantium. Exercitationem culpa nostrum vitae id molestias assumenda.^%break%^\n^%break%^\n^%break%^\n^%break%^\n^%break%^\n^%break%^\n^%break%^\n^%break%^\n^%implode%^Lorem ipsum dolor sit amet consectetur, adipisicing elit. Necessitatibus temporibus reiciendis adipisci ipsum beatae aperiam obcaecati accusamus fugit blanditiis facere corporis ut aliquam unde, dignissimos eum omnis eligendi nisi alias dolorum. ^%break%^\nAliquam quasi consectetur labore vero cum sit pariatur, accusantium similique reprehenderit molestiae eveniet, repudiandae assumenda repellat animi temporibus repellendus, fuga recusandae dignissimos. Eos, velit aperiam harum minus blanditiis delectus. ^%break%^\n^%break%^\nDicta quidem ad magni corrupti delectus recusandae accusamus praesentium quia, in quas. Cumque est, iure tempora magnam necessitatibus possimus consectetur porro accusamus aspernatur amet in voluptates suscipit dignissimos nam delectus sapiente ipsam esse. ^%break%^\n^%break%^\nQuis, voluptatem amet vel dolores est doloremque consequatur deserunt sunt blanditiis modi velit sint. Aliquam ex vero odit sapiente quam optio laboriosam, explicabo officiis voluptates quidem iusto perferendis esse itaque facilis voluptatibus asperiores mollitia dolorem, commodi quae! ^%break%^\n^%break%^\nNihil sit harum nisi facilis labore quod velit repellat excepturi, dolorem quibusdam soluta at dolores inventore quo. Praesentium corrupti laudantium, rem eius fugit modi vel amet, corporis culpa, sequi quae dicta expedita porro nam laborum accusantium obcaecati omnis nemo vero consectetur maxime velit exercitationem. Ipsa expedita atque voluptate beatae eligendi vel sunt, quisquam tempore ex accusamus, molestiae perferendis cumque ullam laboriosam minus maxime temporibus, nulla facere laborum vitae in voluptatem.', 'html', 'post-img-YTMxYzI0NTVjYzIwMjkz.jpg', '2022-04-20 23:30:36', '2022-04-21 02:40:39'),
(15, 'Test Post', 'Edited *%^sp^%* Edited', 'html', 'post-img-YTMxYzI0NTVjYzIwMjkz.jpg', '2022-04-21 02:44:53', '2022-04-21 03:37:31'),
(16, 'Test Post', 'Test ssub title post *%^sp^%* Test sub paragraph Post', 'html', 'post-img-YTMxYzI0NTVjYzIwMjkz.jpg', '2022-04-21 03:18:21', '2022-04-21 03:37:36'),
(17, 'Test Post', 'Test ssub title post *%^sp^%* Test sub paragraph Post', 'html', 'post-img-YTMxYzI0NTVjYzIwMjkz.jpg', '2022-04-21 03:19:33', '2022-04-21 03:37:43'),
(18, 'Test', 'Test Sub 1^%implode%^Test2  *%^sp^%* Test^%implode%^Test2', 'html', 'post-img-YTMxYzI0NTVjYzIwMjkz.jpg', '2022-04-21 03:22:48', '2022-04-21 03:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = user, 1 = admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `username`, `password`, `picture`, `role`, `is_active`, `date_created`) VALUES
(1, 'Deti', 'Baholli', 'deti@gmail.com', 'detib', 'OpvyoDPvmkL5uQcEDb914w==', 'default.png', 1, 1, '2022-04-19 14:40:47'),
(8, 'user1', 'user1', 'user1@user.com', 'user1', '3ySAIsRx95OYktRKdKieOg==', 'default.png', 0, 1, '2022-04-19 22:17:17'),
(9, 'user2', 'user2', 'user2@user.com', 'user2', '3ySAIsRx95OYktRKdKieOg==', 'default.png', 0, 1, '2022-04-19 22:17:45'),
(10, 'user3', 'user3', 'user3@user.com', 'user3', '3ySAIsRx95OYktRKdKieOg==', 'default.png', 0, 1, '2022-04-19 22:18:05'),
(11, 'user4', 'user4', 'user4@gmail.com', 'user4', '3ySAIsRx95OYktRKdKieOg==', 'default.png', 0, 1, '2022-04-19 22:18:22'),
(12, 'user5', 'user5', 'user5@user.com', 'user5', '3ySAIsRx95OYktRKdKieOg==', 'default.png', 0, 1, '2022-04-19 22:18:48'),
(13, 'user6', 'user6', 'user6@user.com', 'user6', '3ySAIsRx95OYktRKdKieOg==', 'default.png', 0, 1, '2022-04-19 22:19:12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
