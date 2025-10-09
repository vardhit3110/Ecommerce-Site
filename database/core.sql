-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2025 at 01:32 PM
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
(1, 'Mobile Phones', 'Mobile Phones_1758869905.jpg', 'Latest smartphones from top brands - find your perfect phone today.', '1', '2025-09-26 12:28:25'),
(2, 'Mobile Accessories', 'Mobile Accessories_1758869947.jpg', 'Screen protectors, stylish back covers, and magnetic phone holders - protect, style.', '1', '2025-09-26 12:29:07'),
(3, 'Buds', 'Buds_1758870014.jpg', 'Auto pair. Noise cancel. Touch control. Tiny buds, big performance - perfect for work & workouts.', '1', '2025-09-26 12:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL COMMENT '1 = Worst, 5 = Best',
  `comment` varchar(255) NOT NULL,
  `submision_date` date NOT NULL DEFAULT current_timestamp(),
  `reply_comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `rating`, `comment`, `submision_date`, `reply_comment`) VALUES
(1, 1, '5', 'Website ka design bohot simple aur fast hai, use karne mein maza aaya!', '2025-10-09', NULL),
(2, 2, '4', 'Mujhe mobile site ka interface kaafi user-friendly laga. Great job!', '2025-10-09', NULL),
(3, 3, '5', 'Page load time fast hai, experience kaafi smooth tha.', '2025-10-09', NULL),
(4, 4, '3', 'Site theek hai lekin thoda aur fast ho sakti hai.', '2025-10-09', NULL),
(5, 5, '2', 'Website bar bar reload ho rahi thi, please isey fix karein.', '2025-10-09', NULL),
(6, 6, '4', 'Product images aur zoom option behtar ho sakta hai.', '2025-10-09', NULL),
(7, 7, '1', 'Checkout mein error aaya, order complete nahi ho saka.', '2025-10-09', NULL),
(8, 8, '4', 'Mujhe jo chahiye tha, easily mil gaya. Website acchi lagi!', '2025-10-09', NULL),
(9, 9, '3', 'Thoda aur categories ka filter add karein toh search easy ho jayegi.', '2025-10-09', NULL),
(10, 10, '5', 'Checkout process asaan aur quick tha. Shukriya!', '2025-10-09', NULL),
(11, 12, '2', 'Some links mobile pe click nahi ho rahe the, issue check karein.', '2025-10-09', NULL),
(12, 13, '5', 'Mujhe product ka detail page open karne mein problem hui.', '2025-10-09', NULL),
(13, 16, '4', 'Chat support ka option add karein, helpful rahega.', '2025-10-09', NULL),
(14, 17, '3', 'Mobile view thoda aur responsive ho toh maza aa jaye.', '2025-10-09', NULL);

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
(1, 'realme P4 Pro 5G', 'realme P4 Pro 5G_1758870375.jpeg', '8 GB RAM | 256 GB ROM,\r\n17.27 cm (6.8 inch) Display,\r\n50MP + 8MP | 50MP Front Camera,\r\n7000 mAh Battery,\r\nSnapdragon 7 Gen 4 Mobile Processor.', 24999, 1, '1', '2025-09-26 12:36:15.435172'),
(2, 'Samsung Galaxy A35 5G', 'Samsung Galaxy A35 5G_1758870502.jpeg', '8 GB RAM | 128 GB ROM | Expandable Upto 1 TB,\r\n16.76 cm (6.6 inch) Full HD+ Display,\r\n50MP + 8MP + 5MP | 13MP Front Camera,\r\n5000 mAh Battery,\r\nSamsung Exynos 1380 Processor.', 17999, 1, '1', '2025-09-26 12:38:22.340524'),
(3, 'Samsung Galaxy S24 FE 5G', 'Samsung Galaxy S24 FE 5G_1758870636.jpeg', '8 GB RAM | 256 GB ROM,\r\n17.02 cm (6.7 inch) Full HD+ Display,\r\n50MP + 12MP | 10MP Front Camera,\r\n4700 mAh Battery,\r\nExynos 2400e Processor.', 33999, 1, '1', '2025-09-26 12:40:36.809211'),
(4, 'Apple iPhone 17', 'Apple iPhone 17_1758870730.jpeg', '256 GB ROM,\r\n16.0 cm (6.3 inch) Super Retina XDR Display,\r\n48MP + 48MP | 18MP Front Camera,\r\nA19 Chip, 6 Core Processor Processor.', 82900, 1, '1', '2025-09-26 12:42:10.507793'),
(5, 'realme Buds T200', 'realme Buds T200_1758871015.jpeg', 'With Mic:Yes,\r\nWireless range: 10 m.\r\nBattery life: 48 hr | Charging time: 2,\r\n12.4mm Dynamic Bass Driver,\r\n48 Hours Total Playback | 10mins Charge for 5 Hrs Playback,\r\nDual-mic AI Deep Call Noise Cancellation,\r\nDual Device Connection,\r\nLow Latency for Ga', 999, 3, '1', '2025-09-26 12:46:55.321459'),
(6, 'OnePlus Nord Buds 3r', 'OnePlus Nord Buds 3r_1758871100.jpeg', 'Fast Charging:Get 8 hours of playback with just 10 minutes of charging.Up to 54 hours of total music time on a full charge.', 1599, 3, '1', '2025-09-26 12:48:20.615559'),
(7, 'OnePlus Nord Buds 3r', 'OnePlus Nord Buds 3r_1758871346.jpeg', 'Fast Charging:Get 8 hours of playback with just 10 minutes of charging.Up to 54 hours of total music time on a full charge.\r\n\r\nTitanium-coated Drivers:Enjoy powerful bass and crisp audio with 12.4mm Titanium-coated drivers and fixed spatial audio.', 1699, 3, '1', '2025-09-26 12:52:26.342437'),
(8, 'Charger EliteGadgets 67 W', 'Charger EliteGadgets 67 W_1758875222.jpeg', 'Wall Charger,\r\nSuitable For: Mobile,\r\nNo Cable Included,\r\nUniversal Voltage.', 283, 2, '1', '2025-09-26 13:57:02.813674'),
(9, 'Apple iPhone 17', 'Apple iPhone 17_1758875436.jpeg', '256 GB ROM, 1\r\n6.0 cm (6.3 inch) Super Retina XDR Display, \r\n48MP + 48MP | 18MP Front Camera, \r\nA19 Chip, \r\n6 Core Processor Processor.', 82999, 1, '1', '2025-09-26 14:00:36.415872'),
(10, 'realme P4 5G', 'realme P4 5G_1759147927.jpeg', '8 GB RAM | 128 GB ROM,\r\n17.2 cm (6.77 inch) Display,\r\n50MP + 8MP | 16MP Front Camera,\r\n7000 mAh Battery,\r\nMediatek Dimensity 7400 Processor.', 19499, 1, '1', '2025-09-29 17:42:07.131418'),
(11, 'realme P3 Pro 5G', 'realme P3 Pro 5G_1759148137.jpeg', '8 GB RAM | 128 GB ROM,\r\n17.35 cm (6.83 inch) Display,\r\n50MP + 2MP | 16MP Front Camera,\r\n6000 mAh Battery,\r\n7s Gen 3 Mobile Platform Processor.', 16999, 1, '1', '2025-09-29 17:45:37.503636'),
(12, 'Noise Aura Buds', 'Noise Aura Buds_1759470841.jpeg', 'Battery life: 60 hrs Playtime,\r\nENC with Quad Mic,\r\nDriver Size : 12mm polymer composite driver,\r\nInstacharge: 10-min = 150-min playtime,\r\nLow Latency(Upto 50ms).', 1499, 3, '1', '2025-10-03 11:24:01.806162'),
(13, 'OPPO Enco Buds3 Pro', 'OPPO Enco Buds3 Pro_1759471019.jpeg', 'Battery life: 54 hr | Charging time: 2.0 hr,\r\n12.4mm Dynamic Bass Boost Driver - Powerful & Rhythmic Bass,\r\nFast Charging- 4Hrs Playback after 10mins Charge,\r\nIntelligent Touch Controls | IP55 Dust &Water Resistant.', 1799, 3, '1', '2025-10-03 11:26:59.068164'),
(14, 'OPPO Enco Buds3 Pro', 'OPPO Enco Buds3 Pro_1759471138.jpeg', 'Battery life: 28 hrs | Charging time: 1.5 hrs,\r\n10mm Dynamic Bass Boost Driver - Powerful & Rhythmic Bass,\r\nEnco Live Stereo Sound Effects,\r\nAI Deep Noise Cancellation | 80ms Ultra Low Latency game mode.', 1399, 3, '1', '2025-10-03 11:28:58.484094'),
(15, 'USB Type C Cable', 'USB Type C Cable_1759471431.jpeg', 'Length 1 m,\r\nRound Cable,\r\nConnector One: USB Type A | Connector Two: USB Type C,\r\nCable Speed: 680 Mbps.\r\nMobile, Tablet.', 210, 2, '1', '2025-10-03 11:33:51.784597'),
(16, 'MarQ Power Bank', 'MarQ Power Bank_1759471631.jpeg', 'Capacity: 10000 mAh,\r\nLithium Polymer Battery | Type-C Connector,\r\nPower Source: DC 5V,9V,12V,\r\nCharging Cable Included.', 3999, 2, '1', '2025-10-03 11:37:11.243206'),
(17, 'PTron Power Bank', 'PTron Power Bank_1759471796.jpeg', 'Pocket Size Power Bank with Max. Output: 22.5W (Max.),\r\nCharging Protocols: PD 3.0, QC 3.0, VOOC, PPS & Number of Ports: 3 (1 Type-C, 2 USB A),\r\nCompatibility: All iPhones & Android Phones Charging Compatibility,\r\nWeight: 407 g | Capacity: 20000 mAh.', 1199, 2, '1', '2025-10-03 11:39:56.892581'),
(18, 'PTron Type C', 'PTron Type C_1759471978.jpeg', 'Length 1 m,\r\nRound Cable,\r\nConnector One: Type C|Connector Two: Type C,\r\nCable Speed: 480 Mbps,\r\nMobile, Tablet.', 198, 2, '1', '2025-10-03 11:42:58.819258');

-- --------------------------------------------------------

--
-- Table structure for table `subcriber`
--

CREATE TABLE `subcriber` (
  `id` int(21) NOT NULL,
  `subcriber_email` varchar(50) NOT NULL,
  `subcriber_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcriber`
--

INSERT INTO `subcriber` (`id`, `subcriber_email`, `subcriber_date`) VALUES
(1, 'abc@gmail.com', '2025-10-01');

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
  `address` varchar(155) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gender` enum('1','2') DEFAULT NULL COMMENT 'male = 1,\r\nfemale = 2',
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT 'active = 1, \r\ninactive = 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `username`, `email`, `password`, `phone`, `address`, `city`, `image`, `gender`, `status`) VALUES
(1, 'hiten', 'hiten@gmail.com', '$2y$10$ZUA/3jx2MScfwqtYNthgCeDP7kh7LKOLDJqjPB', '9898989898', NULL, 'surat', NULL, '1', '2'),
(2, 'om', 'om@gmail.com', '$2y$10$azeyEt45SovTnV8hisMxdeNfOdar7hwuw2nCLb', '7894859475', NULL, 'bharuch', NULL, '1', '1'),
(3, 'prince', 'prince@gmail.com', '$2y$10$.QCLcK9mNYlQrptKR6R8Lus.KGAxWbD/WFfu7k', '7096761516', NULL, 'amreli', NULL, '1', '1'),
(4, 'admin', 'admin@gmail.com', '$2y$10$0Jg5MUd92.NXOvFsln8cdu/UAxDE1PmMILmA5w', '9638527415', NULL, 'rajakot', NULL, '2', '1'),
(5, 'anil', 'anil@gmail.com', '$2y$10$PIAUkD3hjhXLPoc9lBCBleLWBNDGVQbbpAUZaN2klpxxGd.v3838C', '9879879872', NULL, 'surat', NULL, '1', '2'),
(7, 'dixitpatel', 'dixitpatel@gmail.com', '$2y$10$a0XpIEU3korUVQ3U86n5A..A4GW0orTGRzt/UFevoq2lgE7LlAfX.', '9876543210', 'hirabaugh, surat.', 'surat', 'dixitpatel_1759745881.png', '1', '1'),
(8, 'vardhit', 'vardhit31@gmail.com', '$2y$10$0.Xphxy3/m3nqoM.3j2BAesybkcpxHrXLYHQKY4LJdHqyRN543uYa', '', NULL, '', NULL, '', '1'),
(9, 'prince123', 'prince123@gmail.com', '$2y$10$7vsf.dmO2lLUskgcNWjpg.VggGiwqKfEkLGPmAWrux5ZaHnGczi5a', '', NULL, '', NULL, '', '1'),
(10, 'dhruv321', 'dhruv321@gmail.com', '$2y$10$GLkGP8f2XraRWU9E.x1WU.sbXMXQCbc6eH3h224jJj0vqFl.yVh2S', '', NULL, '', NULL, '', '1'),
(12, 'pateldix', 'pateldix@gmail.com', '$2y$10$7kiih7PgCM3zmi68q7.LVOGY6WjoShfHz97IAjd/uPmMh1u6OUs0O', '9876543210', NULL, 'gandhinagar', NULL, '2', '1'),
(13, 'abc', 'abc@gmail.com', '$2y$10$yu5/obd1ogq2Yf3VQrvaP.wLA7c.XXTjvRud2c/kZXwTvTg6BjIii', '9513578524', NULL, 'bharuch', NULL, '2', '1'),
(16, 'dev', 'dev@gmail.com', '$2y$10$hPOQSvgt0R4KoRM5U4GhFOBQNJkcc1v5EO/stAlQRc5.aUpRVt2fi', NULL, NULL, NULL, NULL, NULL, '1'),
(17, 'kishan', 'kishan@gmail.com', '$2y$10$vN9AF1oBXWr0l1kO97qN/OLDClQdqyM6rUjLn2n2RR3jmfemGfnQ6', '9409601795', '32, sarita darshan soc., hirabaugh, surat.', 'surat', 'kishan_1759746626.png', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `prod_id`, `created_at`) VALUES
(6, 4, 6, '2025-10-07 17:07:39'),
(9, 7, 8, '2025-10-07 17:29:22'),
(15, 7, 15, '2025-10-08 11:33:37'),
(29, 17, 15, '2025-10-08 11:50:01'),
(40, 7, 5, '2025-10-08 12:01:18'),
(41, 7, 6, '2025-10-08 12:01:18'),
(42, 7, 7, '2025-10-08 12:01:19'),
(43, 7, 12, '2025-10-08 12:01:20'),
(45, 7, 1, '2025-10-08 14:03:14'),
(46, 16, 1, '2025-10-08 14:46:00'),
(47, 16, 2, '2025-10-08 14:46:02'),
(48, 16, 4, '2025-10-08 14:46:03'),
(49, 16, 8, '2025-10-08 14:46:07'),
(50, 16, 16, '2025-10-08 14:46:10'),
(51, 16, 7, '2025-10-08 14:46:20'),
(52, 16, 13, '2025-10-08 14:46:24'),
(53, 12, 3, '2025-10-08 14:48:36'),
(54, 12, 10, '2025-10-08 14:48:38'),
(55, 12, 8, '2025-10-08 14:48:41'),
(56, 12, 18, '2025-10-08 14:48:43'),
(57, 12, 5, '2025-10-08 14:48:48'),
(58, 12, 14, '2025-10-08 14:48:50'),
(59, 9, 1, '2025-10-08 14:50:17'),
(60, 9, 8, '2025-10-08 14:50:21'),
(61, 9, 15, '2025-10-08 14:50:22'),
(62, 9, 5, '2025-10-08 14:50:25'),
(64, 7, 2, '2025-10-08 15:30:36'),
(65, 7, 3, '2025-10-08 15:30:37'),
(66, 7, 4, '2025-10-08 15:30:38'),
(67, 10, 15, '2025-10-09 10:53:44'),
(68, 10, 16, '2025-10-09 10:53:45'),
(69, 10, 17, '2025-10-09 10:53:46');

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_Id`),
  ADD KEY `fk_product_category` (`categorie_id`);

--
-- Indexes for table `subcriber`
--
ALTER TABLE `subcriber`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `prod_id` (`prod_id`);

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
  MODIFY `categorie_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subcriber`
--
ALTER TABLE `subcriber`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`categorie_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
