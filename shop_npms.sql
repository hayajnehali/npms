-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2022 at 02:35 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_npms`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `c_id` int(11) NOT NULL,
  `c_address` varchar(255) DEFAULT NULL,
  `c_statues` int(11) NOT NULL COMMENT 'if 1 =compleate ,2 =waiting',
  `c_total_price` int(11) NOT NULL,
  `c_total_product` int(11) NOT NULL,
  `c_create` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`c_id`, `c_address`, `c_statues`, `c_total_price`, `c_total_product`, `c_create`, `user_id`) VALUES
(20, 'Jordan,irbd', 2, 2360, 3, '2022-01-01 15:18:45', 28),
(21, 'Jordan,irbd', 1, 955, 3, '2022-04-15 15:21:30', 28);

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `cart_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `Quantity` int(20) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_product`
--

INSERT INTO `cart_product` (`cart_id`, `prod_id`, `Quantity`) VALUES
(20, 44, 2),
(20, 47, 3),
(20, 48, 2),
(21, 43, 1),
(21, 44, 1),
(21, 45, 3);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cate_id` int(11) NOT NULL,
  `cate_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cate_id`, `cate_name`, `user_id`) VALUES
(9, 'Food', 24),
(10, 'Clothes', 24);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `com_comment` varchar(255) NOT NULL,
  `com_create` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `com_comment`, `com_create`, `user_id`, `product_id`) VALUES
(17, 'Good Product moh', '2022-01-15 15:30:22', 28, 44);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(10) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `feedback`, `user_id`) VALUES
(18, 'This web site very nice', 28);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_price` decimal(13,0) NOT NULL,
  `p_describe` varchar(255) NOT NULL,
  `p_create` datetime NOT NULL,
  `p_time_ready` int(11) NOT NULL DEFAULT 1,
  `p_category` int(11) NOT NULL DEFAULT 1,
  `p_image` varchar(255) NOT NULL,
  `p_rate` int(6) NOT NULL,
  `p_available` tinyint(1) NOT NULL DEFAULT 1,
  `p_requ` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `p_price`, `p_describe`, `p_create`, `p_time_ready`, `p_category`, `p_image`, `p_rate`, `p_available`, `p_requ`, `user_id`) VALUES
(43, 'Shemagh', '25', 'Kufiya man\'s head scarf popular in the Arab countries.', '2022-01-14 23:56:05', 2, 10, 'a4e836b0-83d5-4b3e-9567-ab757b1134a5.jfif,pexels-pixabay-40992.jpg,—Pngtree—ghutra arab headscarf still life_6865079.png,—Pngtree—ghutra arab scarf abstract businessman_6865075.png', 0, 1, 1, 27),
(44, 'Pomegranate', '30', 'Fifteen health benefits of pomegranate juice', '2022-01-15 00:14:43', 4, 9, 'pexels-engin-akyurt-3084219.jpg,pexels-iryna-ilieva-3570410.jpg,pexels-jessica-lewis-creative-992815.jpg,pexels-pixabay-65256.jpg', 0, 1, 1, 27),
(45, 'Jordanian Dress', '300', 'Jordanian traditional dress', '2022-01-15 00:23:59', 7, 10, '1cf0a951e9501ff4d8b9afaee8f54b7d.jpg,4cba858ce17cfa16094032b06ff59f18.jpg,5b3ffb2a875fd1b39d1d4892d792d695.jpg,69ecb08d4160c1e1488584942901df9b.jpg', 0, 1, 1, 27),
(46, 'Olive Oil', '600', 'Jordanian olive oil', '2022-01-15 00:25:40', 2, 9, 'pexels-pixabay-33783 (1).jpg,pexels-ramby-magnaye-7102126.jpg,pexels-ron-lach-8190302.jpg,pexels-ron-lach-10054922.jpg', 0, 1, 1, 27),
(47, 'Hony', '500', 'Hony', '2022-01-15 00:27:26', 3, 9, 'pexels-jackie-jabson-6149584.jpg,pexels-monstera-7144966.jpg,pexels-monstera-7144971.jpg,pexels-ramby-magnaye-7102126.jpg', 0, 1, 1, 27),
(48, 'Olive', '400', 'Olive ', '2022-01-15 00:29:42', 3, 9, 'pexels-fox-3900339.jpg,pexels-gary-barnes-6231898.jpg,pexels-meruyert-gonullu-6151968.jpg,pexels-polina-tankilevitch-4109910.jpg', 0, 1, 1, 27),
(50, 'laptop hp', '2255', 'this is ', '2022-01-15 15:27:22', 1, 9, '5b3ffb2a875fd1b39d1d4892d792d695.jpg,checked.png,download (2).jpg,download (3).jpg', 0, 1, 0, 28);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_fullname` varchar(255) NOT NULL,
  `u_phone` bigint(15) NOT NULL,
  `u_address` varchar(255) NOT NULL,
  `u_bdate` date DEFAULT NULL,
  `u_describe` varchar(255) NOT NULL,
  `u_groupID` int(11) NOT NULL DEFAULT 2,
  `u_req_status` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_password`, `u_email`, `u_fullname`, `u_phone`, `u_address`, `u_bdate`, `u_describe`, `u_groupID`, `u_req_status`, `avatar`) VALUES
(24, 'NPMS', '601f1889667efaebb33b8c12572835da3f027f78', 'npms@gmail.com', 'NPMS Admin', 791515151, 'Jordan', '2022-01-28', 'The Maneger of npms system', 1, 1, 'logo.png'),
(27, 'mohamad', 'afe64e7488bcc3637e9bd35cbe7b764a0a089f97', 'mohamad@gmail.com', 'Mohamad Obeidat', 791515452, 'irbid', '1999-03-29', '               I am a good person at production                                             ', 2, 1, 'avatar.jpg'),
(28, 'anmar', 'bc30a2a983c774b48410f9f2dec11941aebfe9c5', 'anmar@gmail.com', 'Anmar Okour', 771515452, 'jordan/irbid', '1999-12-11', ' I am a good person at production   ', 2, 1, '270427782_1520495874992305_1842386402549289706_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `cart_user_fk` (`user_id`);

--
-- Indexes for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`cart_id`,`prod_id`),
  ADD KEY `cart_prod2_fk` (`prod_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cate_id`),
  ADD KEY `cate_user_fk` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `comment_user_fk` (`user_id`),
  ADD KEY `comment_product_fk` (`product_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_name` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `prod_user_fk` (`user_id`),
  ADD KEY `pord_cate_fk` (`p_category`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_name` (`u_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `cart_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `cart_prod1_fk` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_prod2_fk` FOREIGN KEY (`prod_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `cate_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feed_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `pord_cate_fk` FOREIGN KEY (`p_category`) REFERENCES `category` (`cate_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prod_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
