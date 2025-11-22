-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 04:54 AM
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
-- Database: `m.i.a`
--

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `order_numbers` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Items` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`order_numbers`, `fullname`, `address`, `email`, `user_name`, `password`, `Items`, `price`, `quantity`) VALUES
(1, 'Isabel Mayelin Arickx', 'Stacruz, Polangui, Albay', 'IMarickx@email.com', 'IMA01', '101010', 'BLACK SHOES, FORMAL SHOES', '269,359', 1),
(2, 'James Bryan Llagas', 'Irayasur, Oas, Albay', 'JBllagas@email.com', 'JL02', '10381', 'BROWN OUTDOOR  SANDALS', '499', 1),
(3, 'Marife Son', 'Macabugos, Libon, Albay', 'Mson@email.com', 'MS03', '60189', 'NUDE, CLASSY HIGH HEELS, RED, CLASSY HIGH HEELS', '1200,1200', 1),
(4, 'Angela Sofia Salimpade', 'Gabon, Polangui, Albay', 'Asalimpade@email.com', 'AS04', '11034', 'BLACK FLAT SANDALS', '235', 1),
(5, 'Mark James Bermido', 'Sagrada Familia, Libon, Albay', 'MJbermido@email.com', 'MJB05', '7348', 'BLACK LEATHER SANDALS, BROWN LEATHER SANDALS, WHITE LEATHER SANDALS', '359,359,359', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order details`
--

CREATE TABLE `order details` (
  `Order_id` int(11) NOT NULL,
  `Items` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order details`
--

INSERT INTO `order details` (`Order_id`, `Items`) VALUES
(1, 'BLACK DOLL SHOES, FORMAL SANDALS'),
(2, 'BROWN OUTDOOR SANDALS'),
(3, 'NUDE CLASSY HIGH HEELS, RED CLASSY HIGH HEELS'),
(4, 'BLACK FLAT SANDALS'),
(5, 'BLACK LEATHER SANDALS, BROWN LEATHER SANDALS, WHITE LEATHER SANDALS');

-- --------------------------------------------------------

--
-- Table structure for table `order details table`
--

CREATE TABLE `order details table` (
  `Order_id` int(11) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order details table`
--

INSERT INTO `order details table` (`Order_id`, `product_id`, `quantity`) VALUES
(1, 'MIA-02, MIA-03', 1),
(2, 'MIA-06', 1),
(3, 'MIA-04, MIA-05', 1),
(4, 'MIA-01', 1),
(5, 'MIA-07, MIA-08, MIA-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_numbers` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Items` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_numbers`, `customer_name`, `address`, `email`, `user_name`, `password`, `Items`, `quantity`) VALUES
(1, 'Isabel Mayelin Arickx', 'Stacruz, Polangui, Albay', 'IMarickx@email.com', 'IMA01', 'IM101010', 'BLACK DOLLSHOES, 269 FORMAL SANDALS, 499', 2),
(2, 'James Bryan Llagas', 'Irayasur, Oas, Albay', 'JBllagas@email.com', 'JL02', 'JL10381', 'BROWN OUTDOORS SANDALS, 359', 1),
(3, 'Marife Son', 'Macabugos, Libon, Albay', 'Mson@email.com', 'MS03', 'MS60189', 'CLASSY HIGH HEELS, NUDE AND RED,1200', 2),
(4, 'Angela Sofia Salimpade', 'Gabon, Polangui, Albay', 'Asalimpade@email.con', 'AS04', 'AS110347', 'BLACK FLAT SANDALS,235', 1),
(5, 'Mark James Bermido', 'Sagrada Familia, Libon, Albay', 'MJbermido@email.com', 'MJB05', 'MJ734891', 'LEATHER SANDALS BLACK, BROWN WHITE, 359', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order table`
--

CREATE TABLE `order table` (
  `Order_id` int(11) NOT NULL,
  `Customer_id` int(11) NOT NULL,
  `Order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order table`
--

INSERT INTO `order table` (`Order_id`, `Customer_id`, `Order_date`) VALUES
(1, 11, '2025-09-17 01:18:19'),
(2, 12, '2025-09-17 01:18:19'),
(3, 13, '2025-09-18 01:18:19'),
(4, 14, '2025-09-18 01:18:19'),
(5, 15, '2025-09-19 01:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `product table`
--

CREATE TABLE `product table` (
  `Product_id` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product table`
--

INSERT INTO `product table` (`Product_id`, `product_name`, `price`) VALUES
('MIA-01', 'BLACK FLAT SANDALS', '235'),
('MIA-02', 'BLACK DOLL SHOES', '269'),
('MIA-03', 'FORMAL SANDALS', '359'),
('MIA-04', 'RED, CLASSY HIGH HEELS', '1200'),
('MIA-05', 'NUDE, CLASSY HIGH HEELS', '1200'),
('MIA-06', 'BROWN OUTDOOR SANDALS', '499'),
('MIA-07', 'BLACK LEATHER SANDALS', '359'),
('MIA-08', 'BROWN LEATHER SANDALS', '359'),
('MIA-09', 'WHITE LEATHER SANDALS', '359');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `customer_name`, `address`, `email`, `user_name`, `password`) VALUES
(11, 'Isabel Mayelin Arickx', 'Stacruz, Polangui ,Albay', 'IMarickx@email.com', 'IMA01', 'IM101010'),
(12, 'James Bryan Llagas', 'Irayasur, Oas ,Albay', 'JBllagas@email.com', 'JL02', 'JL103812'),
(13, 'Marife Son', 'Macabugos, Libon ,Albay', 'Mson@email.com', 'MS03', 'MS601895'),
(14, 'Angela Sofia Salimpade', 'Gabon, Polangui ,Albay', 'Asalimpade@email.com', 'AS04', 'AS110347'),
(15, 'Mark James Bermido', 'Sagrada Familia, Libon ,Albay', 'MJbermido@email.com', 'MJB05', 'MJ734891 ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`order_numbers`);

--
-- Indexes for table `order details`
--
ALTER TABLE `order details`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `order details table`
--
ALTER TABLE `order details table`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_numbers`);

--
-- Indexes for table `order table`
--
ALTER TABLE `order table`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `product table`
--
ALTER TABLE `product table`
  ADD PRIMARY KEY (`Product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `order_numbers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order details`
--
ALTER TABLE `order details`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order details table`
--
ALTER TABLE `order details table`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_numbers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order table`
--
ALTER TABLE `order table`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
