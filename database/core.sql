-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2025 at 07:40 AM
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
-- Database: `core`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$rSEBQr2QAjwUY/eZAK5OF.APuvz4QSDx8VCuKBrqcHwLg0.G1y2PS', '2025-09-16 04:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categorie_id` int(100) NOT NULL,
  `categorie_name` varchar(255) NOT NULL,
  `categorie_image` varchar(255) NOT NULL,
  `categorie_desc` varchar(255) NOT NULL,
  `categorie_status` enum('1','2') NOT NULL DEFAULT '1' COMMENT 'active = 1, \r\ninactive = 2',
  `categorie_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categorie_id`, `categorie_name`, `categorie_image`, `categorie_desc`, `categorie_status`, `categorie_created`) VALUES
(1, 'Mobile Phones', 'Mobile Phones_1758520829.jpg', 'Latest smartphones from top brands – find your perfect phone today.', '1', '2025-09-22 11:30:29'),
(2, 'Mobile Accessories', 'Mobile Accessories_1758605025.jpg', 'Screen protectors, stylish back covers, and magnetic phone holders – protect, style.', '1', '2025-09-23 10:53:45'),
(5, 'Buds', '1758604460032.jpg', 'Auto pair. Noise cancel. Touch control. Tiny buds, big performance-perfect for work & workouts.', '1', '2025-09-25 11:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_Id` int(100) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `product_price` int(12) NOT NULL,
  `categorie_id` int(100) NOT NULL,
  `product_status` enum('1','2') NOT NULL DEFAULT '1' COMMENT 'active - 1, \r\ninactive - 2',
  `product_creatdated` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_Id`, `product_name`, `product_image`, `product_desc`, `product_price`, `categorie_id`, `product_status`, `product_creatdated`) VALUES
(1, 'iPhone 14 (Blue , 256 GB)', 'iPhone 14 (Blue , 256 GB)_1758608967.jpeg', '256 GB ROM\r\n15.49 cm (6.1 inch) Super Retina XDR Display\r\n12MP + 12MP | 12MP Front Camera\r\nA15 Bionic Chip, 6 Core Processor Processor', 64999, 1, '1', '2025-09-23 11:59:27.280043'),
(2, 'Samsung Galaxy S24 FE 5G (Blue, 8 GB RAM, 128 GB)', 'Samsung Galaxy S24 FE 5G (Blue, 8 GB RAM, 128 GB)  )_1758609268.jpeg', '8 GB RAM | 128 GB ROM,\r\n17.02 cm (6.7 inch) Full HD+ Display,\r\n50MP + 12MP | 10MP Front Camera,\r\n4700 mAh Battery,\r\nExynos 2400e Processor.', 29999, 1, '1', '2025-09-23 12:04:28.129371'),
(3, 'MOTOROLA G96 5G (Pantone Cattleya Orchid, 8 GB RAM, 128 GB)', 'MOTOROLA G96 5G (Pantone Cattleya Orchid, 8 GB RAM, 128 GB)._1758609451.jpeg', '8 GB RAM | 128 GB ROM,\r\n16.94 cm (6.67 inch) Full HD+ Display,\r\n50MP + 8MP | 32MP Front Camera,\r\n5500 mAh Battery,\r\n7s Gen 2 Processor.', 15999, 1, '1', '2025-09-23 12:07:31.594614'),
(4, 'SuperVOOC 80 W Charger (White, Cable Included)', 'SuperVOOC 80 W Charger (White, Cable Included)._1758609749.jpeg', 'Wall Charger,\r\nSuitable For: Mobile,\r\nUniversal Voltage,\r\nOutput Current : 6 A.', 283, 2, '1', '2025-09-23 12:12:29.051542'),
(5, 'Power Bank Ambrane 20000 mAh 22.5 W ( Green )', 'Power Bank Ambrane 20000 mAh 22.5 W ( Green )_1758609963.jpeg', 'Capacity: 20000 mAh,\r\nLithium Polymer Battery | Type-A, Type-C Connector,\r\nPower Source: AC Adapter,\r\nCharging Cable Included.', 1099, 2, '1', '2025-09-23 12:16:03.430299'),
(6, 'Noise Buds VS102', 'Noise Buds VS102_1758610163.jpeg', 'With Mic:Yes,\r\nWireless range: 10 m,\r\nBattery life: 50 Hours | Charging time: 2 Hour,\r\nBattery life: 50 hrs Playtime,\r\nDriver Size : Immersive Audio with 11mm driver,\r\nType - C Charging Port | Upto 50 Hours of Total Playtime,\r\nUnique Flybird Design.', 799, 3, '1', '2025-09-23 12:19:23.814518'),
(8, 'realme Buds T200', 'realme Buds T200_1758621032.jpeg', 'With Mic:Yes.,\r\nWireless range: 10 m,\r\nBattery life: 48 hr | Charging time: 2,\r\n12.4mm Dynamic Bass Driver,\r\n48 Hours Total Playback | 10mins Charge for 5 Hrs Playback,\r\nDual-mic AI Deep Call Noise Cancellation,\r\nDual Device Connection.', 999, 5, '1', '2025-09-23 15:20:32.300604'),
(12, 'OnePlus USB Type C Cable', 'OnePlus USB Type C Cable_1758804495.jpeg', 'Length 1 m, \r\nRound Cable,\r\nConnector One: USB Type A|Connector Two: Type-C,\r\nCable Speed: 480 Mbps,\r\nMobile, Computer, Laptop.', 259, 2, '1', '2025-09-25 18:18:15.677126'),
(13, 'ZOLDYCK Nord Buds 2r', 'ZOLDYCK Nord Buds 2r_1758804719.jpeg', 'With Mic : Yes,\r\nConnector type: no', 1199, 5, '1', '2025-09-25 18:21:59.668466'),
(14, 'OnePlus USB Type C Cable', 'OnePlus USB Type C Cable._1758862753.jpeg', 'Length 1 m.\r\nRound Cable,\r\nConnector One: USB Type C|Connector Two: TYPE C,\r\nCable Speed: 480 Mbps,\r\nMobile.', 295, 2, '2', '2025-09-26 10:29:13.082740');

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `gender` enum('1','2') DEFAULT NULL COMMENT 'male = 1,\r\nfemale = 2',
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT 'active = 1, \r\ninactive = 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `username`, `email`, `password`, `phone`, `city`, `gender`, `status`) VALUES
(1, 'hiten', 'hiten@gmail.com', '$2y$10$ZUA/3jx2MScfwqtYNthgCeDP7kh7LKOLDJqjPB', '9898989898', 'surat', '1', '2'),
(2, 'om', 'om@gmail.com', '$2y$10$azeyEt45SovTnV8hisMxdeNfOdar7hwuw2nCLb', '7894859475', 'bharuch', '1', '1'),
(3, 'prince', 'prince@gmail.com', '$2y$10$.QCLcK9mNYlQrptKR6R8Lus.KGAxWbD/WFfu7k', '7096761516', 'amreli', '1', '1'),
(4, 'admin', 'admin@gmail.com', '$2y$10$0Jg5MUd92.NXOvFsln8cdu/UAxDE1PmMILmA5w', '9638527415', 'rajakot', '2', '1'),
(5, 'anil', 'anil@gmail.com', '$2y$10$PIAUkD3hjhXLPoc9lBCBleLWBNDGVQbbpAUZaN2klpxxGd.v3838C', '9879879872', 'surat', '1', '2'),
(7, 'dixitpatel', 'dixitpatel@gmail.com', '$2y$10$a0XpIEU3korUVQ3U86n5A..A4GW0orTGRzt/UFevoq2lgE7LlAfX.', '9797979797', 'surat', '1', '1'),
(8, 'vardhit', 'vardhit31@gmail.com', '$2y$10$0.Xphxy3/m3nqoM.3j2BAesybkcpxHrXLYHQKY4LJdHqyRN543uYa', '', '', '', '1'),
(9, 'prince123', 'prince123@gmail.com', '$2y$10$7vsf.dmO2lLUskgcNWjpg.VggGiwqKfEkLGPmAWrux5ZaHnGczi5a', '', '', '', '2'),
(10, 'dhruv321', 'dhruv321@gmail.com', '$2y$10$GLkGP8f2XraRWU9E.x1WU.sbXMXQCbc6eH3h224jJj0vqFl.yVh2S', '', '', '', '1'),
(12, 'pateldix', 'pateldix@gmail.com', '$2y$10$7kiih7PgCM3zmi68q7.LVOGY6WjoShfHz97IAjd/uPmMh1u6OUs0O', '9876543210', 'gandhinagar', '2', '1'),
(13, 'abc', 'abc@gmail.com', '$2y$10$yu5/obd1ogq2Yf3VQrvaP.wLA7c.XXTjvRud2c/kZXwTvTg6BjIii', '9513578524', 'bharuch', '2', '1'),
(15, 'xyz', '', '', '1234567890', 'xyz', '', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categorie_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_Id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categorie_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
