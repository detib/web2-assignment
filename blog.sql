-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2022 at 01:03 AM
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

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user`, `body`, `time`, `post_id`) VALUES
(5, 'therealrock ', 'This is a great post.', '2022-04-25 22:06:57', 2),
(6, 'twitterIsMineNow', 'This is a really great read.', '2022-04-25 22:07:31', 3),
(9, 'therealrock ', 'Imho, it does not matter if the person is a 90\'s dev. They clearly missed the past few years of development in the JS ecosystem. It is true that many years ago JS was ugly and not scalable, however it grew. A lot. We have so many new ways to scale JS, so many ideas to workaround JS weaknesses and so many strong new features. It is best to tell people who probably don\'t know better to first go and research the topic. If they don\'t, try to keep away, because such people tend to be toxic.', '2022-04-25 22:56:56', 3),
(10, 'JesseWeHaveToCook', 'People thinking that JS sucks:\r\n  1.Don\'t know JS\'s history\r\n  2.Don\'t know that JS matured a lot\r\n  3.They probably heard it from their role model, and they hate it too\r\n', '2022-04-25 23:00:11', 3),
(11, 'JesseWeHaveToCook', 'This post really helped me find ways to improve my programming skills.\r\n\r\nGreat Post.', '2022-04-25 23:01:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(1, 'elonmusk@gmail.com'),
(2, 'lebronjames@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'general',
  `post_image` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `edit_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `category`, `post_image`, `date`, `edit_date`) VALUES
(1, 'How to improve your programming skills on your own', 'Reading Code^%seperator%^Set Aside Refactoring Time^%seperator%^Practice By Doing *%^sp^%* It goes without saying&hellip; If you want to be a better writer, you&rsquo;ve got to become a better reader &mdash; this means reading more books, as well as a wider range of books. There are plenty of books out there to help you become a better programmer &mdash; A popular book to get you started is The Pragmatic Programmer by David Thomas &amp; Andrew Hunt &mdash; but reading, in general, is really useful as it expands your mind.^%seperator%^I&rsquo;ll be honest, initially, I adopted the mindset of &ldquo;if it works, then it&rsquo;s good&rdquo;. Refactoring code always gets put off. In hindsight, it&rsquo;s actually quite daft. I would never publish an article without iterating over it once or twice to ensure I am conveying the messaging I wish to.^%break%^\r\n^%break%^\r\nOf course, code refactoring serves a different purpose. The purpose of refactoring code is to either make the code more efficient, more maintainable or both.^%break%^\r\n^%break%^\r\nTo become a better programmer, you must set aside time to refactor. To improve your refactoring skills, you must learn about refactoring &mdash; this will give you an idea of what to look for. Lastly, ensure you devote a lot of time refactoring code. You can revisit past projects or others people\'s projects and modify their code to make it more efficient, maintainable, or both.^%break%^\r\n^%seperator%^If you want to become a better writer, you have to write more. If you want to become a better cook, you have to cook more. If you want to become a better programmer, you have to write more programs.^%break%^\r\n^%break%^\r\nA little hack you could steal to write more programs is to start by writing lots of small programs. This will allow you to crank up the amount of code you&rsquo;re writing each day which would allow you to create a lot more programs.^%break%^\r\n^%break%^\r\nHowever, a large number of small programs would not cover the scope of programming skills required to be considered a good programmer. At some point, it&rsquo;s important to make the transition from writing lots of small programs to writing larger programs as this would reveal a new set challenges that would force you to become a better programmer.^%break%^\r\n^%break%^\r\nIf you think I&rsquo;ve left some ideas out leave a comment so we can continue to develop in unison.', 'javascript', 'post-img-ZDkyNDUzY2EzNTAxNjY5.jpg', '2022-04-25 21:54:29', '2022-04-25 21:54:29'),
(2, 'Why is JavaScript so unpopular?', 'There are a lot of different opinions *%^sp^%* Hey developers,^%break%^\r\n^%break%^\r\nI recently met a 90\'s developer and we were having a casual conversation about tech. On him asking, what stack do we use in our company, I answered &quot;the JavaScript Stack&quot;.^%break%^\r\n^%break%^\r\nHe was shocked and replied: &quot;JavaScript is not scalable and you should consider rewriting the app to Python.&quot;^%break%^\r\n^%break%^\r\nWell, I told him all the popular apps which are built on JavaScript and he was like they all have some or other system which handles traffic separately and it\'s not JavaScript which is handling the traffic.^%break%^\r\n^%break%^\r\nI had to quit the conversation as it was a birthday ceremony and I didn\'t want any fight. :)^%break%^\r\n^%break%^\r\nWhy do you think people think bad about JavaScript?', 'javascript', 'post-img-OTc3NmI0MmFmYTY2Y2Y5.jpg', '2022-04-25 21:56:14', '2022-04-25 21:56:14'),
(3, 'Why Python is not the programming language of the future', 'Pretty Slow^%seperator%^Scope^%seperator%^Runtime Errors *%^sp^%* Python is slow. Like, really slow. On average, you&rsquo;ll need about 2&ndash;10 times longer to complete a task with Python than with any other language.^%break%^\r\n^%break%^\r\nThere are various reasons for that. One of them is that it&rsquo;s dynamically typed &mdash; remember that you don&rsquo;t need to specify data types like in other languages. This means that a lot of memory needs to be used, because the program needs to reserve enough space for each variable that it works in any case. And lots of memory usage translates to lots of computing time.^%break%^\r\n^%break%^\r\nAnother reason is that Python can only execute one task at a time. This is a consequence of flexible datatypes &mdash; Python needs to make sure each variable has only one datatype, and parallel processes could mess that up.^%break%^\r\n^%break%^\r\nIn comparison, your average web browser can run a dozen different threads at once. And there are some other theories around, too.^%seperator%^Originally, Python was dynamically scoped. This basically means that, to evaluate an expression, a compiler first searches the current block and then successively all the calling functions.^%break%^\r\n^%break%^\r\nThe problem with dynamic scoping is that every expression needs to be tested in every possible context &mdash; which is tedious. That&rsquo;s why most modern programming languages use static scoping.^%break%^\r\n^%break%^\r\nPython tried to transition to static scoping, but messed it up. Usually, inner scopes &mdash; for example functions within functions &mdash; would be able to see and change outer scopes. In Python, inner scopes can only see outer scopes, but not change them. This leads to a lot of confusion.^%seperator%^A Python script isn&rsquo;t compiled first and then executed. Instead, it compiles every time you execute it, so any coding error manifests itself at runtime. This leads to poor performance, time consumption, and the need for a lot of tests. Like, a lot of tests.^%break%^\r\n^%break%^\r\nThis is great for beginners since testing teaches them a lot. But for seasoned developers, having to debug a complex program in Python makes them go awry. This lack of performance is the biggest factor that sets a timestamp on Python.', 'python', 'post-img-ZTJlNzdkODQwNGQyZGQ0.jpg', '2022-04-25 21:58:23', '2022-04-25 21:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = user, 1 = admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `username`, `password`, `picture`, `role`, `is_active`, `date_created`) VALUES
(1, 'Deti', 'Baholli', 'deti@gmail.com', 'detib', 'OpvyoDPvmkL5uQcEDb914w==', 'profile-pic-OGMxNTdlZjVhMDIwODA0.png', 1, 1, '2022-04-25 21:35:17'),
(2, 'John', 'Cena', 'johncena@gmail.com', 'youcantseeme', 'Wu7JFaF0Hs8QYjy4grkWsA==', 'profile-pic-NGQwNzJiMjcxODM5MDg2.jpg', 0, 0, '2022-04-25 21:38:33'),
(3, 'Dwayne', 'Johnson', 'therock@gmail.com', 'therealrock ', '9ns+gIcSEVmJerGLEWqB8w==', 'profile-pic-MjU4N2NlZDc4YWFmM2M2.jpg', 0, 1, '2022-04-25 21:41:57'),
(4, 'Jesse', 'Pinkman', 'jessepinkman@gmail.com', 'JesseWeHaveToCook', 'uiZJ/cqbOyv13LCNvpdWew==', 'profile-pic-NmZlNTc0NmNlYmFiYjRl.jpg', 0, 1, '2022-04-25 21:42:33'),
(5, 'Elon', 'Musk', 'elonmusk@gmail.com', 'twitterIsMineNow', 'z2frz244LA9lmVrYz4hBZQ==', 'profile-pic-YjhiM2Y3MmU1YjBlOWQx.jpg', 0, 1, '2022-04-25 21:44:23'),
(6, 'LeBron', 'James', 'lebronjames@gmail.com', 'KingJames', 'j7p7sbUkaoC8BJdsU+Cwow==', 'profile-pic-MmQ1OWUwZjUyNzVlNGI3.jpg', 0, 0, '2022-04-25 21:45:07'),
(7, 'Donat', 'Kusari', 'donat@gmail.com', 'donatk', 'xvsjuJjCOskCMGXDJKW3MA==', 'default.png', 0, 0, '2022-04-25 21:49:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
