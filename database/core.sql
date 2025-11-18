-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2025 at 01:44 PM
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
  `fname` varchar(21) NOT NULL,
  `lname` varchar(21) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(21) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fname`, `lname`, `email`, `phone`, `password`, `bio`, `created_at`) VALUES
(1, 'Rahul', 'Sharma', 'admin@gmail.com', '9846598728', '$2y$10$rSEBQr2QAjwUY/eZAK5OF.APuvz4QSDx8VCuKBrqcHwLg0.G1y2PS', 'Team Manager', '2025-09-15 23:15:06');

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
(1, 'Mobile Phones', 'Mobile Phones.png', 'Latest smartphones from top brands - find your perfect phone today.', '1', '2025-09-26 12:28:25'),
(2, 'Mobile Accessories', 'Mobile Accessories.png', 'Screen protectors, stylish back covers, and magnetic phone holders - protect, style.', '1', '2025-09-26 12:29:07'),
(3, 'Buds', 'Buds.png', 'Auto pair. Noise cancel. Touch control. Tiny buds, big performance - perfect for work & workouts.', '1', '2025-09-26 12:30:14'),
(4, 'Laptops', 'Laptops_1763034773.png', 'Explore laptops built for every need — smart, fast, and ready for anything.', '1', '2025-11-13 17:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(5) NOT NULL,
  `promocode` varchar(20) NOT NULL,
  `discount` int(5) NOT NULL,
  `min_bill_price` int(5) NOT NULL,
  `usage_limit` int(10) DEFAULT 0,
  `used_count` int(100) DEFAULT 0,
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1-active,\r\n2-Inactive',
  `description` varchar(255) NOT NULL,
  `creat_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `promocode`, `discount`, `min_bill_price`, `usage_limit`, `used_count`, `status`, `description`, `creat_time`) VALUES
(1, 'QZ8R3KLP', 3, 1000, 248, 2, '1', 'New User Offer', '2025-11-07 17:06:23'),
(2, 'V9TL2XQM', 7, 2500, 200, 0, '1', 'Weekend Shopping Deal', '2025-11-07 17:06:53'),
(3, 'H2NB6PRJ', 5, 5000, 150, 0, '1', 'Mid-Month Saver', '2025-11-07 17:07:20'),
(4, 'K4FJ8TZQ', 10, 8000, 119, 1, '1', 'Festival Celebration Offer', '2025-11-07 17:07:49'),
(5, 'M1XW9GTR', 8, 12000, 98, 2, '1', 'Loyal Customer Reward', '2025-11-07 17:08:19'),
(6, 'R7LQ3DNP', 12, 35000, 45, 5, '1', 'Premium Shopper Benefit', '2025-11-07 17:08:50'),
(7, 'X6DM5JQR', 14, 90000, 47, 3, '1', 'Mega Purchase Advantage', '2025-11-07 17:15:19');

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
(1, 1, '5', 'Website ka design bohot simple aur fast hai, use karne mein maza aaya!', '2025-10-09', 'Thanks.!!'),
(2, 2, '4', 'Mujhe mobile site ka interface kaafi user-friendly laga. Great job!', '2025-10-09', NULL),
(3, 3, '5', 'Page load time fast hai, experience kaafi smooth tha.', '2025-10-09', NULL),
(4, 4, '3', 'Site theek hai lekin thoda aur fast ho sakti hai.', '2025-10-09', NULL),
(5, 5, '2', 'Website bar bar reload ho rahi thi, please isey fix karein.', '2025-10-09', NULL),
(6, 6, '4', 'Product images aur zoom option behtar ho sakta hai.', '2025-10-09', NULL),
(7, 7, '1', 'Checkout mein error aaya, order complete nahi ho saka.', '2025-10-09', 'Update Your Application.!!'),
(8, 8, '4', 'Mujhe jo chahiye tha, easily mil gaya. Website acchi lagi!', '2025-10-09', NULL),
(9, 9, '3', 'Thoda aur categories ka filter add karein toh search easy ho jayegi.', '2025-10-09', NULL),
(10, 10, '5', 'Checkout process asaan aur quick tha. Shukriya!', '2025-10-09', NULL),
(11, 12, '2', 'Some links mobile pe click nahi ho rahe the, issue check karein.', '2025-10-09', NULL),
(12, 13, '5', 'Mujhe product ka detail page open karne mein problem hui.', '2025-10-09', NULL),
(13, 16, '4', 'Chat support ka option add karein, helpful rahega.', '2025-10-09', NULL),
(14, 17, '3', 'Mobile view thoda aur responsive ho toh maza aa jaye.', '2025-10-09', NULL),
(15, 28, '4', '\"Good\"', '2025-11-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `product_details` text DEFAULT NULL COMMENT 'JSON or text of all products in order',
  `total_amount` decimal(10,2) DEFAULT NULL,
  `shipping_charge` decimal(10,2) DEFAULT 0.00,
  `payment_mode` enum('1','2') DEFAULT '1' COMMENT '1=Cash on Delivery, 2=Online Payment',
  `payment_status` enum('1','2','3','4') DEFAULT '1' COMMENT '1=Pending, 2=Success, 3=Failed, 4=Refunded',
  `payment_id` varchar(100) DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `order_status` enum('1','2','3','4','5') DEFAULT '1' COMMENT '1=Pending, 2=Processing, 3=Shipped, 4=Delivered, 5=Cancelled',
  `delivery_address` text DEFAULT NULL,
  `order_code` int(15) NOT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `discount_amount` varchar(20) DEFAULT NULL,
  `admin_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `product_details`, `total_amount`, `shipping_charge`, `payment_mode`, `payment_status`, `payment_id`, `razorpay_order_id`, `razorpay_payment_id`, `order_status`, `delivery_address`, `order_code`, `coupon_code`, `discount_amount`, `admin_note`) VALUES
(1, 7, '2025-10-16 16:32:44', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 1049.00, 50.00, NULL, '3', NULL, NULL, NULL, '1', 'Umiya bhavan, thakkar nagar, ahmedabad.', 723957, NULL, NULL, NULL),
(2, 7, '2025-10-16 16:34:11', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '2', '1', NULL, NULL, NULL, '5', 'Umiya bhavan, thakkar nagar, ahmedabad.', 421426, NULL, NULL, NULL),
(3, 7, '2025-10-17 10:24:10', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '1', '2', NULL, NULL, NULL, '4', '1, Thakkar Nagar, India Colony, Ahmedabad.', 578893, NULL, NULL, NULL),
(4, 17, '2025-10-17 10:25:59', '[{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":1,\"subtotal\":3999}]', 4049.00, 50.00, '1', NULL, NULL, NULL, NULL, '5', '101, opera royal, pasodra gam,kamrej, surat.', 4318, NULL, NULL, NULL),
(5, 9, '2025-10-17 10:30:01', '[{\"product_name\":\"Charger EliteGadgets 67 W\",\"price\":283,\"quantity\":2,\"subtotal\":566}]', 616.00, 50.00, '2', '1', NULL, NULL, NULL, '2', 'Mumbai', 436722, NULL, NULL, NULL),
(6, 7, '2025-10-17 11:22:11', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999},{\"product_name\":\"OnePlus Nord Buds 3r\",\"price\":1599,\"quantity\":1,\"subtotal\":1599}]', 2648.00, 50.00, '1', '2', NULL, NULL, NULL, '4', '1, Thakkar Nagar, India Colony, Ahmedabad.', 995211, NULL, NULL, NULL),
(7, 8, '2025-10-17 15:32:14', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900},{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 83949.00, 50.00, '2', '1', NULL, NULL, NULL, '5', '1021, raj mall, jaipur, rajesthan', 614236, NULL, NULL, NULL),
(8, 10, '2025-10-17 15:33:50', '[{\"product_name\":\"OPPO Enco Buds3 Pro\",\"price\":1399,\"quantity\":1,\"subtotal\":1399}]', 1449.00, 50.00, '1', '1', NULL, NULL, NULL, '3', 'sadar chowk, jetpur.', 376546, NULL, NULL, NULL),
(9, 16, '2025-10-17 15:36:28', '[{\"product_name\":\"Charger EliteGadgets 67 W\",\"price\":283,\"quantity\":2,\"subtotal\":566},{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":3,\"subtotal\":630}]', 1246.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'nasik , mumbai..', 242507, NULL, NULL, NULL),
(10, 17, '2025-10-27 10:20:53', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '1', '2', NULL, NULL, NULL, '4', '404, varni, pasodra gam,kamrej, surat.', 363056, NULL, NULL, NULL),
(11, 7, '2025-10-29 14:56:11', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '2', '1', NULL, NULL, NULL, '5', '106, Bapunagar, India Colony, Ahmedabad..', 725010, NULL, NULL, NULL),
(12, 7, '2025-10-29 15:01:20', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '2', '2', 'pay_RZEyDeKnYUcpIQ', 'pay_RZEyDeKnYUcpIQ', NULL, '4', '106, Bapunagar, India Colony, Ahmedabad..', 348744, NULL, NULL, NULL),
(13, 18, '2025-10-29 15:08:08', '[{\"product_name\":\"Noise Aura Buds\",\"price\":1499,\"quantity\":1,\"subtotal\":1499}]', 1549.00, 50.00, '2', '2', 'pay_RZF4aTYSnVMUd1', 'pay_RZF4aTYSnVMUd1', NULL, '4', '403, vraj vihar, jagatnaka, varachha, surat.', 105210, NULL, NULL, NULL),
(14, 18, '2025-10-29 15:24:39', '[{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":1,\"subtotal\":3999}]', 4049.00, 50.00, '2', '1', NULL, 'order_RZFLO4z0YJfw7A', NULL, '1', '403, vraj vihar, jagatnaka, varachha, surat.', 919482, NULL, NULL, NULL),
(15, 18, '2025-10-29 15:25:29', '[{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":1,\"subtotal\":3999}]', 4049.00, 50.00, '2', '2', NULL, 'order_RZFMGcbD68mGxJ', NULL, '4', '403, vraj vihar, jagatnaka, varachha, surat.', 633778, NULL, NULL, NULL),
(16, 18, '2025-10-29 15:32:59', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '2', '1', NULL, 'order_RZFUBlSFKTZqQt', NULL, '1', '403, vraj vihar, jagatnaka, varachha, surat.', 741939, NULL, NULL, NULL),
(17, 12, '2025-10-29 15:43:37', '[{\"product_name\":\"PTron Power Bank\",\"price\":1199,\"quantity\":1,\"subtotal\":1199}]', 1249.00, 50.00, '2', '1', NULL, 'order_RZFfQiBPptWy8g', NULL, '1', 'Mota varachha, surat.', 984347, NULL, NULL, NULL),
(18, 12, '2025-10-29 16:00:58', '[{\"product_name\":\"PTron Power Bank\",\"price\":1199,\"quantity\":1,\"subtotal\":1199}]', 1249.00, 50.00, '2', '2', NULL, NULL, NULL, '4', 'Mota varachha, surat.', 419385, NULL, NULL, NULL),
(19, 12, '2025-10-29 16:02:14', '[{\"product_name\":\"PTron Power Bank\",\"price\":1199,\"quantity\":1,\"subtotal\":1199}]', 1249.00, 50.00, '2', '1', NULL, NULL, NULL, '1', 'Mota varachha, surat.', 356221, NULL, NULL, NULL),
(20, 12, '2025-10-29 16:13:17', '[{\"product_name\":\"PTron Power Bank\",\"price\":1199,\"quantity\":1,\"subtotal\":1199}]', 1249.00, 50.00, '2', '2', 'pay_RZGArWwUGhOYEn', 'order_RZGAlfOA7sFuc8', 'pay_RZGArWwUGhOYEn', '4', 'Mota varachha, surat.', 730249, NULL, NULL, NULL),
(21, 10, '2025-10-29 16:21:15', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 1049.00, 50.00, '2', '1', NULL, 'order_RZGJAw8LOd1o8A', NULL, '1', 'sadar chowk, jetpur.', 682371, NULL, NULL, NULL),
(22, 10, '2025-10-29 16:21:48', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 1049.00, 50.00, '2', '1', NULL, 'order_RZGJkoAfXd002z', NULL, '1', 'sadar chowk, jetpur.', 432676, NULL, NULL, NULL),
(23, 10, '2025-10-29 16:24:20', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 1049.00, 50.00, '2', '1', NULL, 'order_RZGMRCnXDdXuvE', NULL, '1', 'sadar chowk, jetpur.', 549175, NULL, NULL, NULL),
(24, 10, '2025-10-29 16:24:38', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 1049.00, 50.00, '2', '1', NULL, 'order_RZGMkAcwOL6Fuf', NULL, '1', 'sadar chowk, jetpur.', 305247, NULL, NULL, NULL),
(25, 10, '2025-10-29 16:27:26', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 1049.00, 50.00, '2', '2', NULL, 'order_RZGPiOaFDLkjX3', NULL, '4', 'sadar chowk, jetpur.', 439362, NULL, NULL, NULL),
(26, 10, '2025-10-29 16:30:21', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 1049.00, 50.00, '2', '1', NULL, 'order_RZGSmaA8jOEEgX', NULL, '1', 'sadar chowk, jetpur.', 938789, NULL, NULL, NULL),
(27, 10, '2025-10-29 16:31:09', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999}]', 1049.00, 50.00, '2', '2', 'pay_RZGTivOX5dTirM', 'order_RZGTdZcDfsK2P0', 'pay_RZGTivOX5dTirM', '4', 'sadar chowk, jetpur.', 523966, NULL, NULL, NULL),
(28, 7, '2025-10-29 17:55:03', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '2', '2', 'pay_RZHutrHkx13XQx', 'order_RZHuGhareHZ8wi', 'pay_RZHutrHkx13XQx', '4', '106, Bapunagar, India Colony, Ahmedabad..', 811918, NULL, NULL, NULL),
(29, 7, '2025-10-29 17:57:39', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '2', '2', 'pay_RZHx5gz3wHUmdJ', 'order_RZHx0BzwdE7POi', 'pay_RZHx5gz3wHUmdJ', '4', '106, Bapunagar, India Colony, Ahmedabad..', 548934, NULL, NULL, NULL),
(30, 7, '2025-10-29 18:06:36', '[{\"product_name\":\"PTron Power Bank\",\"price\":1199,\"quantity\":1,\"subtotal\":1199}]', 1249.00, 50.00, '2', '2', 'pay_RZI6YUDY2Ik0Fm', 'order_RZI6SwbFeiej4l', 'pay_RZI6YUDY2Ik0Fm', '4', '106, Bapunagar, India Colony, Ahmedabad..', 792880, NULL, NULL, NULL),
(31, 7, '2025-10-29 18:29:54', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 248.00, 50.00, '2', '2', 'pay_RZIVEeA2EueLoI', 'order_RZIV61ZELQpfa2', 'pay_RZIVEeA2EueLoI', '4', '106, Bapunagar, India Colony, Ahmedabad..', 841001, NULL, NULL, NULL),
(32, 17, '2025-10-29 18:38:02', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '2', '2', 'pay_RZIdlhg7Q9HmlE', 'order_RZIdeuZ31XdlmG', 'pay_RZIdlhg7Q9HmlE', '4', '404, varni, pasodra gam,kamrej, surat.', 354597, NULL, NULL, NULL),
(33, 17, '2025-10-29 18:42:51', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 248.00, 50.00, '2', '1', NULL, NULL, NULL, '1', '404, varni, pasodra gam,kamrej, surat.', 157128, NULL, NULL, NULL),
(34, 17, '2025-10-29 18:43:31', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 248.00, 50.00, '2', '2', 'pay_RZIjYOOPGoRW6W', 'order_RZIjSbsvpbsadV', 'pay_RZIjYOOPGoRW6W', '4', '404, varni, pasodra gam,kamrej, surat.', 794882, NULL, NULL, NULL),
(35, 8, '2025-10-30 10:10:54', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 248.00, 50.00, '2', '2', 'pay_RZYXUEhzf5EXvO', 'order_RZYX5uDStbAaNr', 'pay_RZYXUEhzf5EXvO', '4', '1021, raj mall, jaipur, rajesthan', 665186, NULL, NULL, NULL),
(36, 8, '2025-10-30 10:19:46', '[{\"product_name\":\"Charger EliteGadgets 67 W\",\"price\":283,\"quantity\":1,\"subtotal\":283}]', 333.00, 50.00, '2', '2', NULL, 'order_RZYgRorymzZlfQ', NULL, '4', '1021, raj mall, jaipur, rajesthan', 767259, NULL, NULL, NULL),
(37, 8, '2025-10-30 12:31:43', '[{\"product_name\":\"Charger EliteGadgets 67 W\",\"price\":283,\"quantity\":1,\"subtotal\":283}]', 333.00, 50.00, '2', '2', 'pay_RZawBnXMrO7Uxk', 'order_RZavq1ZGMUF4o2', 'pay_RZawBnXMrO7Uxk', '4', '1021, raj mall, jaipur, rajesthan', 908971, NULL, NULL, NULL),
(38, 8, '2025-10-30 12:40:15', '[{\"product_name\":\"Samsung Galaxy A35 5G\",\"price\":17999,\"quantity\":1,\"subtotal\":17999}]', 18049.00, 50.00, '2', '2', NULL, 'order_RZb4pr5G8ZPol9', NULL, '4', '1021, raj mall, jaipur, rajesthan', 403498, NULL, NULL, NULL),
(39, 8, '2025-10-30 12:41:33', '[{\"product_name\":\"Samsung Galaxy A35 5G\",\"price\":17999,\"quantity\":1,\"subtotal\":17999}]', 18059.00, 60.00, '2', '2', NULL, 'order_RZb6CKDNVXNZj8', NULL, '4', '1021, raj mall, jaipur, rajesthan', 807922, NULL, NULL, NULL),
(40, 8, '2025-10-30 12:43:05', '[{\"product_name\":\"Samsung Galaxy A35 5G\",\"price\":17999,\"quantity\":1,\"subtotal\":17999}]', 18059.00, 60.00, '2', '2', 'pay_RZb8fEPPibZ00J', 'order_RZb7pHINI3tA4t', 'pay_RZb8fEPPibZ00J', '4', '1021, raj mall, jaipur, rajesthan', 748234, NULL, NULL, NULL),
(41, 16, '2025-10-30 12:46:37', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 258.00, 60.00, '2', '2', NULL, 'order_RZbBYKUBJx1wP9', NULL, '4', 'nasik , mumbai..', 497671, NULL, NULL, NULL),
(42, 16, '2025-10-30 13:59:00', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 258.00, 60.00, '2', '1', NULL, 'order_RZcQ1hym4I6mKy', NULL, '1', 'nasik , mumbai..', 543501, NULL, NULL, NULL),
(43, 16, '2025-10-30 13:59:30', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 258.00, 60.00, '2', '1', NULL, 'order_RZcQY3azHtlLaY', NULL, '1', 'nasik , mumbai..', 561679, NULL, NULL, NULL),
(44, 16, '2025-10-30 14:00:27', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 258.00, 60.00, '2', '2', 'pay_RZcRencXGNfTD7', 'order_RZcRYC5EnxMdid', 'pay_RZcRencXGNfTD7', '4', 'nasik , mumbai..', 109798, NULL, NULL, NULL),
(45, 16, '2025-10-30 17:41:05', '[{\"product_name\":\"PTron Power Bank\",\"price\":1199,\"quantity\":1,\"subtotal\":1199}]', 1249.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'nasik , mumbai..', 908334, NULL, NULL, NULL),
(46, 16, '2025-10-30 17:47:22', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 258.00, 60.00, '2', '2', 'pay_RZgJLxhNazQLR4', 'order_RZgJEzr9xmweMM', 'pay_RZgJLxhNazQLR4', '5', 'nasik , mumbai..', 762218, NULL, NULL, NULL),
(47, 16, '2025-10-30 17:49:56', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":2,\"subtotal\":396}]', 456.00, 60.00, '2', '2', 'pay_RZgM8KLx2PWXnc', 'order_RZgLwR53TgvpQV', 'pay_RZgM8KLx2PWXnc', '4', 'India gat, Taj Hotel, mumbai..', 873800, NULL, NULL, NULL),
(48, 16, '2025-10-30 17:59:29', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'India gat, Taj Hotel, mumbai..', 203682, NULL, NULL, NULL),
(49, 19, '2025-11-05 18:29:42', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 82950.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'gujarat', 166327, NULL, NULL, NULL),
(50, 20, '2025-11-05 18:45:50', '[{\"product_name\":\"Noise Buds VS102\",\"price\":1099,\"quantity\":6,\"subtotal\":6594}]', 6644.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'Raipur, Chhatisagadh.', 603524, NULL, NULL, NULL),
(51, 21, '2025-11-06 11:04:23', '[{\"product_name\":\"realme P4 Pro 5G\",\"price\":24999,\"quantity\":1,\"subtotal\":24999},{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":1,\"subtotal\":3999}]', 29058.00, 60.00, '2', '2', 'pay_RcLBj3ngS7Ho49', 'order_RcLBPazwBtl1zL', 'pay_RcLBj3ngS7Ho49', '4', 'New Darvaja, Rajeshthan', 402617, NULL, NULL, NULL),
(52, 21, '2025-11-06 17:57:34', '[{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":2,\"subtotal\":7998}]', 8048.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'New Darvaja, Rajeshthan', 485397, NULL, NULL, NULL),
(53, 22, '2025-11-07 14:49:56', '[{\"product_name\":\"realme Buds T200\",\"price\":999,\"quantity\":1,\"subtotal\":999},{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 1259.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'Doordarshan tower, Ahmedabad.', 567117, 'none', '0', NULL),
(54, 22, '2025-11-07 15:03:45', '[{\"product_name\":\"Samsung Galaxy S24 FE 5G\",\"price\":33999,\"quantity\":1,\"subtotal\":33999}]', 34049.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'Near Central Park,New Delhi', 315650, 'none', '0', NULL),
(55, 22, '2025-11-07 15:10:04', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 218.00, 50.00, '1', '1', NULL, NULL, NULL, '2', 'gujarat', 291678, 'VAMJA100', '42', NULL),
(56, 22, '2025-11-07 15:18:36', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 208.40, 50.00, '1', '1', NULL, NULL, NULL, '3', 'gujarat', 215057, 'VAMJA100', '39.6', NULL),
(57, 23, '2025-11-07 15:56:01', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 73841.00, 60.00, '2', '1', NULL, 'order_RcogfATsIldOd1', NULL, '1', 'Aanad, Gujarat', 583655, 'BIGSALE11', '9119', NULL),
(58, 23, '2025-11-07 16:08:19', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 73841.00, 60.00, '2', '1', NULL, 'order_RcotdCHzs9EzjY', NULL, '1', 'Aanad, Gujarat', 390633, 'BIGSALE11', '9119', NULL),
(59, 23, '2025-11-07 16:12:09', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 73841.00, 60.00, '2', '1', NULL, 'order_Rcoxg9G2pSRuhr', NULL, '1', 'Aanad, Gujarat', 394705, 'BIGSALE11', '9119', NULL),
(60, 23, '2025-11-07 16:18:50', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 73841.00, 60.00, '2', '1', NULL, 'order_Rcp4igyQarKRsA', NULL, '1', 'Aanad, Gujarat', 525667, 'BIGSALE11', '9119', NULL),
(61, 23, '2025-11-07 16:19:01', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 73841.00, 60.00, '2', '2', NULL, 'order_Rcp4uOnqmUTmOo', NULL, '4', 'Aanad, Gujarat', 285514, 'BIGSALE11', '9119', NULL),
(62, 23, '2025-11-07 16:26:47', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 73841.00, 60.00, '2', '3', NULL, 'order_RcpD7Ez9so9YBv', NULL, '1', 'Aanad, Gujarat', 668988, 'BIGSALE11', '9119', NULL),
(63, 23, '2025-11-07 16:32:30', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 73841.00, 60.00, '2', '3', NULL, 'order_RcpJ9QZBRmmDs9', NULL, '1', 'Aanad, Gujarat', 233102, 'BIGSALE11', '9119', NULL),
(64, 23, '2025-11-07 16:38:39', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900}]', 73831.00, 50.00, '1', '2', NULL, NULL, NULL, '4', 'Aanad, Gujarat', 920740, 'BIGSALE11', '9119', NULL),
(65, 8, '2025-11-10 12:27:46', '[{\"product_name\":\"Charger EliteGadgets 67 W\",\"price\":283,\"quantity\":1,\"subtotal\":283},{\"product_name\":\"Samsung Galaxy S24 FE 5G\",\"price\":33999,\"quantity\":1,\"subtotal\":33999},{\"product_name\":\"OnePlus Nord Buds 3r\",\"price\":1699,\"quantity\":1,\"subtotal\":1699}]', 33152.52, 50.00, '1', '3', NULL, NULL, NULL, '1', '1021, raj mall, jaipur, rajesthan', 581246, 'R7LQ3DNP', '2878.48', NULL),
(66, 8, '2025-11-10 12:29:37', '[{\"product_name\":\"Samsung Galaxy S24 FE 5G\",\"price\":33999,\"quantity\":1,\"subtotal\":33999},{\"product_name\":\"Charger EliteGadgets 67 W\",\"price\":283,\"quantity\":1,\"subtotal\":283},{\"product_name\":\"OnePlus Nord Buds 3r\",\"price\":1699,\"quantity\":1,\"subtotal\":1699}]', 33152.52, 50.00, '1', '3', NULL, NULL, NULL, '1', '1021, raj mall, jaipur, rajesthan', 858425, 'R7LQ3DNP', '2878.48', NULL),
(67, 8, '2025-11-10 12:38:43', '[{\"product_name\":\"Samsung Galaxy S24 FE 5G\",\"price\":33999,\"quantity\":1,\"subtotal\":33999},{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":1,\"subtotal\":3999}]', 35008.16, 50.00, '1', '3', NULL, NULL, NULL, '1', '1021, raj mall, jaipur, rajesthan', 427427, 'R7LQ3DNP', '3039.84', NULL),
(68, 8, '2025-11-10 12:58:09', '[{\"product_name\":\"Samsung Galaxy S24 FE 5G\",\"price\":33999,\"quantity\":1,\"subtotal\":33999},{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":1,\"subtotal\":3999}]', 35008.16, 50.00, '1', '2', NULL, NULL, NULL, '4', '1021, raj mall, jaipur, rajesthan', 861926, 'R7LQ3DNP', '3039.84', NULL),
(69, 24, '2025-11-10 14:14:18', '[{\"product_name\":\"Noise Buds VS102\",\"price\":1099,\"quantity\":1,\"subtotal\":1099}]', 1116.03, 50.00, '1', '2', NULL, NULL, NULL, '4', 'Sarathana Nature Park, Surat.', 426419, 'QZ8R3KLP', '32.97', NULL),
(70, 25, '2025-11-10 18:46:33', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82900,\"quantity\":1,\"subtotal\":82900},{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":2,\"subtotal\":7998},{\"product_name\":\"OnePlus Nord Buds 3r\",\"price\":1599,\"quantity\":1,\"subtotal\":1599}]', 79597.42, 50.00, '1', '2', NULL, NULL, NULL, '4', 'Rajasthan', 441209, 'X6DM5JQR', '12949.58', NULL),
(71, 25, '2025-11-10 18:48:13', '[{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":1,\"subtotal\":3999}]', 3779.07, 60.00, '2', '2', 'pay_Re3DzmMiOCSu9g', 'order_Re3DoZerhCBMcp', 'pay_Re3DzmMiOCSu9g', '4', 'Rajasthan', 113497, 'V9TL2XQM', '279.93', NULL),
(72, 25, '2025-11-10 18:49:19', '[{\"product_name\":\"PTron Type C\",\"price\":198,\"quantity\":1,\"subtotal\":198}]', 258.00, 60.00, '2', '3', NULL, 'order_Re3ExEkmPnX1uE', NULL, '1', 'Rajasthan', 795243, 'none', '0', NULL),
(73, 26, '2025-11-11 12:24:38', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82999,\"quantity\":1,\"subtotal\":82999},{\"product_name\":\"MarQ Power Bank\",\"price\":3999,\"quantity\":2,\"subtotal\":7998}]', 78307.42, 50.00, '1', '2', NULL, NULL, NULL, '4', 'Mota Varachha, Surat,Gujarat.', 210795, 'X6DM5JQR', '12739.58', NULL),
(74, 26, '2025-11-11 12:27:06', '[{\"product_name\":\"OnePlus Nord Buds 3r\",\"price\":1599,\"quantity\":1,\"subtotal\":1599}]', 1601.03, 50.00, '1', '1', NULL, NULL, NULL, '5', 'Mota Varachha, Surat,Gujarat.', 277877, 'QZ8R3KLP', '47.97', NULL),
(75, 27, '2025-11-13 12:59:45', '[{\"product_name\":\"Apple iPhone 17\",\"price\":82999,\"quantity\":1,\"subtotal\":82999}]', 76409.08, 50.00, '1', '2', NULL, NULL, NULL, '4', '32, darshan, kamrej, surat.', 665966, 'R7LQ3DNP', '6639.92', NULL),
(76, 27, '2025-11-13 15:50:17', '[{\"product_name\":\"realme P3 Pro 5G\",\"price\":16999,\"quantity\":1,\"subtotal\":16999}]', 15009.12, 50.00, '1', '2', NULL, NULL, NULL, '4', '32, darshan, kamrej, surat.', 569306, 'M1XW9GTR', '2039.88', NULL),
(77, 27, '2025-11-13 15:50:49', '[{\"product_name\":\"OnePlus Nord Buds 3r\",\"price\":1699,\"quantity\":1,\"subtotal\":1699}]', 1749.00, 50.00, '1', '1', NULL, NULL, NULL, '1', '32, darshan, kamrej, surat.', 790437, 'none', '0', NULL),
(78, 27, '2025-11-13 15:52:13', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 270.00, 60.00, '2', '3', NULL, 'order_RfBpJfYHqHCgdV', NULL, '1', '32, darshan, kamrej, surat.', 133163, 'none', '0', NULL),
(79, 27, '2025-11-13 15:52:51', '[{\"product_name\":\"USB Type C Cable\",\"price\":210,\"quantity\":1,\"subtotal\":210}]', 260.00, 50.00, '1', '2', NULL, NULL, NULL, '4', '32, darshan, kamrej, surat.', 521667, 'none', '0', NULL),
(80, 28, '2025-11-14 10:32:41', '[{\"product_name\":\"ASUS Vivobook 15 Intel Core i3\",\"price\":34990,\"quantity\":1,\"subtotal\":34990}]', 30841.20, 50.00, '1', '2', NULL, NULL, NULL, '4', 'Vesu Ring Road, Surat.', 610090, 'M1XW9GTR', '4198.8', NULL),
(81, 29, '2025-11-17 18:35:50', '[{\"product_name\":\"Apple iPhone 17\",\"price\":92999,\"quantity\":1,\"subtotal\":92999},{\"product_name\":\"MarQ Power Bank\",\"price\":5999,\"quantity\":2,\"subtotal\":11998}]', 90347.42, 50.00, '1', '2', NULL, NULL, NULL, '4', 'kapodra , Surat.', 511349, 'X6DM5JQR', '14699.58', NULL),
(82, 30, '2025-11-18 18:00:28', '[{\"product_name\":\"MarQ Power Bank\",\"price\":5999,\"quantity\":1,\"subtotal\":5999},{\"product_name\":\"OnePlus Nord Buds 3r\",\"price\":1699,\"quantity\":2,\"subtotal\":3398},{\"product_name\":\"PTron Power Bank\",\"price\":2199,\"quantity\":1,\"subtotal\":2199}]', 10486.40, 50.00, '1', '2', NULL, NULL, NULL, '4', 'surat.', 771497, 'K4FJ8TZQ', '1159.6', NULL);

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
  `product_off` int(11) DEFAULT NULL COMMENT 'Discount (%)',
  `product_creatdated` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_Id`, `product_name`, `product_image`, `product_desc`, `product_price`, `categorie_id`, `product_status`, `product_off`, `product_creatdated`) VALUES
(1, 'realme P4 Pro 5G', 'realme P4 Pro 5G_1758870375.jpeg', '8 GB RAM | 256 GB ROM,\r\n17.27 cm (6.8 inch) Display,\r\n50MP + 8MP | 50MP Front Camera,\r\n7000 mAh Battery,\r\nSnapdragon 7 Gen 4 Mobile Processor.', 34999, 1, '1', 40, '2025-09-26 12:36:15.435172'),
(2, 'Samsung Galaxy A35 5G', 'Samsung Galaxy A35 5G_1758870502.jpeg', '8 GB RAM | 128 GB ROM | Expandable Upto 1 TB,\r\n16.76 cm (6.6 inch) Full HD+ Display,\r\n50MP + 8MP + 5MP | 13MP Front Camera,\r\n5000 mAh Battery,\r\nSamsung Exynos 1380 Processor.', 27999, 1, '1', 32, '2025-09-26 12:38:22.340524'),
(3, 'Samsung Galaxy S24 FE 5G', 'Samsung Galaxy S24 FE 5G_1758870636.jpeg', '8 GB RAM | 256 GB ROM,\r\n17.02 cm (6.7 inch) Full HD+ Display,\r\n50MP + 12MP | 10MP Front Camera,\r\n4700 mAh Battery,\r\nExynos 2400e Processor.', 40999, 1, '1', 7, '2025-09-26 12:40:36.809211'),
(4, 'Apple iPhone 17', 'Apple iPhone 17_1758870730.jpeg', '256 GB ROM,\r\n16.0 cm (6.3 inch) Super Retina XDR Display,\r\n48MP + 48MP | 18MP Front Camera,\r\nA19 Chip, 6 Core Processor Processor.', 92999, 1, '1', 7, '2025-09-26 12:42:10.507793'),
(5, 'realme Buds T200', 'realme Buds T200_1758871015.jpeg', 'With Mic:Yes,\r\nWireless range: 10 m.\r\nBattery life: 48 hr | Charging time: 2,\r\n12.4mm Dynamic Bass Driver,\r\n48 Hours Total Playback | 10mins Charge for 5 Hrs Playback,\r\nDual-mic AI Deep Call Noise Cancellation,\r\nDual Device Connection,\r\nLow Latency for Ga', 1399, 3, '1', 20, '2025-09-26 12:46:55.321459'),
(6, 'OnePlus Nord Buds 3r', 'OnePlus Nord Buds 3r_1758871100.jpeg', 'Fast Charging:Get 8 hours of playback with just 10 minutes of charging.Up to 54 hours of total music time on a full charge.', 1599, 3, '1', 0, '2025-09-26 12:48:20.615559'),
(7, 'OnePlus Nord Buds 3r', 'OnePlus Nord Buds 3r_1758871346.jpeg', 'Fast Charging:Get 8 hours of playback with just 10 minutes of charging.Up to 54 hours of total music time on a full charge.\r\n\r\nTitanium-coated Drivers:Enjoy powerful bass and crisp audio with 12.4mm Titanium-coated drivers and fixed spatial audio.', 1699, 3, '1', 0, '2025-09-26 12:52:26.342437'),
(8, 'Charger EliteGadgets 67 W', 'Charger EliteGadgets 67 W_1758875222.jpeg', 'Wall Charger,\r\nSuitable For: Mobile,\r\nNo Cable Included,\r\nUniversal Voltage.', 783, 2, '1', 50, '2025-09-26 13:57:02.813674'),
(9, 'Apple iPhone 17', 'Apple iPhone 17_1758875436.jpeg', '256 GB ROM, 1\r\n6.0 cm (6.3 inch) Super Retina XDR Display, \r\n48MP + 48MP | 18MP Front Camera, \r\nA19 Chip, \r\n6 Core Processor Processor.', 92999, 1, '1', 7, '2025-09-26 14:00:36.415872'),
(10, 'realme P4 5G', 'realme P4 5G_1759147927.jpeg', '8 GB RAM | 128 GB ROM,\r\n17.2 cm (6.77 inch) Display,\r\n50MP + 8MP | 16MP Front Camera,\r\n7000 mAh Battery,\r\nMediatek Dimensity 7400 Processor.', 25999, 1, '1', 11, '2025-09-29 17:42:07.131418'),
(11, 'realme P3 Pro 5G', 'realme P3 Pro 5G_1759148137.jpeg', '8 GB RAM | 128 GB ROM,\r\n17.35 cm (6.83 inch) Display,\r\n50MP + 2MP | 16MP Front Camera,\r\n6000 mAh Battery,\r\n7s Gen 3 Mobile Platform Processor.', 26999, 1, '1', 17, '2025-09-29 17:45:37.503636'),
(12, 'Noise Aura Buds', 'Noise Aura Buds_1759470841.jpeg', 'Battery life: 60 hrs Playtime,\r\nENC with Quad Mic,\r\nDriver Size : 12mm polymer composite driver,\r\nInstacharge: 10-min = 150-min playtime,\r\nLow Latency(Upto 50ms).', 1499, 3, '1', 27, '2025-10-03 11:24:01.806162'),
(13, 'OPPO Enco Buds3 Pro', 'OPPO Enco Buds3 Pro_1759471019.jpeg', 'Battery life: 54 hr | Charging time: 2.0 hr,\r\n12.4mm Dynamic Bass Boost Driver - Powerful & Rhythmic Bass,\r\nFast Charging- 4Hrs Playback after 10mins Charge,\r\nIntelligent Touch Controls | IP55 Dust &Water Resistant.', 1799, 3, '1', 10, '2025-10-03 11:26:59.068164'),
(14, 'OPPO Enco Buds3 Pro', 'OPPO Enco Buds3 Pro_1759471138.jpeg', 'Battery life: 28 hrs | Charging time: 1.5 hrs,\r\n10mm Dynamic Bass Boost Driver - Powerful & Rhythmic Bass,\r\nEnco Live Stereo Sound Effects,\r\nAI Deep Noise Cancellation | 80ms Ultra Low Latency game mode.', 1399, 3, '1', 10, '2025-10-03 11:28:58.484094'),
(15, 'USB Type C Cable', 'USB Type C Cable_1759471431.jpeg', 'Length 1 m,\r\nRound Cable,\r\nConnector One: USB Type A | Connector Two: USB Type C,\r\nCable Speed: 680 Mbps.\r\nMobile, Tablet.', 410, 2, '1', 60, '2025-10-03 11:33:51.784597'),
(16, 'MarQ Power Bank', 'MarQ Power Bank_1759471631.jpeg', 'Capacity: 10000 mAh,\r\nLithium Polymer Battery | Type-C Connector,\r\nPower Source: DC 5V,9V,12V,\r\nCharging Cable Included.', 5999, 2, '1', 39, '2025-10-03 11:37:11.243206'),
(17, 'PTron Power Bank', 'PTron Power Bank_1759471796.jpeg', 'Pocket Size Power Bank with Max. Output: 22.5W (Max.),\r\nCharging Protocols: PD 3.0, QC 3.0, VOOC, PPS & Number of Ports: 3 (1 Type-C, 2 USB A),\r\nCompatibility: All iPhones & Android Phones Charging Compatibility,\r\nWeight: 407 g | Capacity: 20000 mAh.', 2199, 2, '1', 10, '2025-10-03 11:39:56.892581'),
(18, 'PTron Type C', 'PTron Type C_1759471978.jpeg', 'Length 1 m,\r\nRound Cable,\r\nConnector One: Type C,\r\nConnector Two: Type C,\r\nCable Speed: 480 Mbps | Mobile | Tablet.', 449, 2, '1', 35, '2025-10-03 11:42:58.819258'),
(19, 'Noise Buds VS102', 'Noise Buds VS102_1761904945.jpeg', 'Bluetooth version: 5.3,\r\nWireless range: 10 m,\r\nBattery life: 70 hrs,\r\nBattery life: 70 Hour Playtime | Type - C Charging Port,\r\nUnique Flybird Design | ENC with Quad Mic.', 1099, 3, '1', 10, '2025-10-31 15:32:25.099519'),
(20, 'ASUS Vivobook 15 Intel Core i3', 'ASUS Vivobook 15 Intel Core i3_1763035300.jpeg', 'Stylish & Portable Thin and Light Laptop,\r\n15.6 Inch Full HD, 16:9 aspect ratio, LED Backlit, 60Hz refresh rate, 250nits, 45% NTSC color gamut, Anti-glare display,\r\nFinger Print Sensor for Faster System Access,\r\nLight Laptop without Optical Disk Drive.', 44990, 4, '1', 25, '2025-11-13 17:31:40.829247'),
(21, 'DELL', 'DELL_1763386023.jpeg', 'Intel Core i3 Processor (13th Gen),\r\n    16 GB DDR5 RAM,\r\n    64 bit Windows 11 Home Operating System,\r\n    512 GB SSD,\r\n    35.56 cm (14 inch) Display,\r\n    Microsoft Office 2021, Windows 11 Home,\r\n    1 Year Accidentaly Damage Protection + Onsite.', 70990, 4, '1', 48, '2025-11-17 18:57:03.764603');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `uploaded_at`) VALUES
(1, 19, 'Noise Buds VS102_1761909030_0.jpeg', '2025-10-31 16:40:30'),
(2, 19, 'Noise Buds VS102_1761909031_1.jpeg', '2025-10-31 16:40:31'),
(3, 19, 'Noise Buds VS102_1761909031_2.jpeg', '2025-10-31 16:40:31'),
(4, 19, 'Noise Buds VS102_1761909031_3.jpeg', '2025-10-31 16:40:31'),
(5, 1, 'realme P4 Pro 5G_1762149100_0.jpeg', '2025-10-31 18:08:01'),
(6, 1, 'realme P4 Pro 5G_1762149100_1.jpeg', '2025-10-31 18:08:01'),
(7, 1, 'realme P4 Pro 5G_1762149100_2.jpeg', '2025-10-31 18:08:01'),
(8, 1, 'realme P4 Pro 5G_1762149100_3.jpeg', '2025-10-31 18:08:01'),
(9, 5, 'realme Buds T200_1762839783_0.jpeg', '2025-11-11 11:13:03'),
(10, 5, 'realme Buds T200_1762839783_1.jpeg', '2025-11-11 11:13:03'),
(11, 5, 'realme Buds T200_1762839783_2.jpeg', '2025-11-11 11:13:03'),
(12, 5, 'realme Buds T200_1762839783_3.jpeg', '2025-11-11 11:13:03'),
(13, 20, 'ASUS Vivobook 15 Intel Core i3_1763035300_0.jpeg', '2025-11-13 17:31:40'),
(14, 20, 'ASUS Vivobook 15 Intel Core i3_1763035300_1.jpeg', '2025-11-13 17:31:40'),
(15, 20, 'ASUS Vivobook 15 Intel Core i3_1763035300_2.jpeg', '2025-11-13 17:31:40'),
(16, 20, 'ASUS Vivobook 15 Intel Core i3_1763035300_3.jpeg', '2025-11-13 17:31:40'),
(17, 21, 'DELL_1763386023_0.jpeg', '2025-11-17 18:57:03'),
(18, 21, 'DELL_1763386023_1.jpeg', '2025-11-17 18:57:03'),
(19, 21, 'DELL_1763386023_2.jpeg', '2025-11-17 18:57:03'),
(20, 21, 'DELL_1763386023_3.jpeg', '2025-11-17 18:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `sitedetail`
--

CREATE TABLE `sitedetail` (
  `id` int(100) NOT NULL,
  `systemName` varchar(21) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(21) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sitedetail`
--

INSERT INTO `sitedetail` (`id`, `systemName`, `email`, `contact`, `address`) VALUES
(1, 'MobileSite', 'info@mobilesite.com', '9876543210', '123, Rosewood Apartments,MG Road, Near Central Park,New Delhi, India');

-- --------------------------------------------------------

--
-- Table structure for table `site_image`
--

CREATE TABLE `site_image` (
  `id` int(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `sub_title` varchar(100) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1-active,\r\n2-Inactive',
  `creatat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_image`
--

INSERT INTO `site_image` (`id`, `title`, `sub_title`, `image_path`, `status`, `creatat`) VALUES
(1, 'Welcome to MobileSite', 'Explore the best deals on latest mobiles!', 'banner1_1763015369.png', '1', '2025-11-13 11:59:29'),
(2, 'Shop Now', 'Don’t miss exclusive offers — limited time only!', 'banner2_1763015423.png', '1', '2025-11-13 12:00:23'),
(3, 'Top Brands Available', 'Get your favorite smartphone at the best price.', 'banner3_1763015442.png', '1', '2025-11-13 12:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE `subscriber` (
  `subscriber_id` int(11) NOT NULL,
  `subscriber_email` varchar(255) NOT NULL,
  `subscriber_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriber`
--

INSERT INTO `subscriber` (`subscriber_id`, `subscriber_email`, `subscriber_date`) VALUES
(1, 'user1@example.com', '2025-10-01 10:15:23'),
(2, 'user2@example.com', '2025-10-01 10:45:10'),
(3, 'user3@example.com', '2025-10-01 11:05:42'),
(4, 'user4@example.com', '2025-10-01 11:22:18'),
(5, 'user5@example.com', '2025-10-01 11:55:37'),
(6, 'user6@example.com', '2025-10-02 09:15:11'),
(7, 'user7@example.com', '2025-10-02 09:45:08'),
(8, 'user8@example.com', '2025-10-02 10:01:29'),
(9, 'user9@example.com', '2025-10-02 10:25:34'),
(10, 'user10@example.com', '2025-10-02 11:02:45'),
(11, 'user11@example.com', '2025-10-03 08:12:33'),
(12, 'user12@example.com', '2025-10-03 08:47:51'),
(13, 'user13@example.com', '2025-10-03 09:10:06'),
(14, 'user14@example.com', '2025-10-03 09:30:19'),
(15, 'user15@example.com', '2025-10-03 09:55:40'),
(16, 'user16@example.com', '2025-10-04 12:12:10'),
(17, 'user17@example.com', '2025-10-04 12:25:45'),
(18, 'user18@example.com', '2025-10-04 12:40:33'),
(19, 'user19@example.com', '2025-10-04 13:05:12'),
(20, 'user20@example.com', '2025-10-04 13:35:57'),
(21, 'user21@example.com', '2025-10-05 14:12:22'),
(22, 'user22@example.com', '2025-10-05 14:25:18'),
(23, 'user23@example.com', '2025-10-05 14:48:09'),
(24, 'user24@example.com', '2025-10-05 15:10:33'),
(25, 'user25@example.com', '2025-10-05 15:45:27'),
(26, 'user26@example.com', '2025-10-06 09:05:15'),
(27, 'user27@example.com', '2025-10-06 09:35:42'),
(28, 'user28@example.com', '2025-10-06 10:02:50'),
(29, 'user29@example.com', '2025-10-06 10:20:33'),
(30, 'user30@example.com', '2025-10-06 10:55:47'),
(31, 'user31@example.com', '2025-10-07 11:12:19'),
(32, 'user32@example.com', '2025-10-07 11:32:46'),
(33, 'user33@example.com', '2025-10-07 11:55:03'),
(34, 'user34@example.com', '2025-10-07 12:15:29'),
(35, 'user35@example.com', '2025-10-07 12:40:56'),
(36, 'user36@example.com', '2025-10-08 13:02:18'),
(37, 'user37@example.com', '2025-10-08 13:25:44'),
(38, 'user38@example.com', '2025-10-08 13:45:09'),
(39, 'user39@example.com', '2025-10-08 14:10:31'),
(40, 'user40@example.com', '2025-10-08 14:33:17'),
(41, 'user41@example.com', '2025-10-09 08:11:42'),
(42, 'user42@example.com', '2025-10-09 08:30:55'),
(43, 'user43@example.com', '2025-10-09 08:47:20'),
(44, 'user44@example.com', '2025-10-09 09:05:09'),
(45, 'user45@example.com', '2025-10-09 09:25:33'),
(46, 'user46@example.com', '2025-10-09 09:45:51'),
(47, 'user47@example.com', '2025-10-10 10:02:18'),
(48, 'user48@example.com', '2025-10-10 10:25:44'),
(49, 'user49@example.com', '2025-10-10 10:55:10'),
(50, 'user50@example.com', '2025-10-10 11:20:29'),
(51, 'user51@example.com', '2025-10-11 09:10:11'),
(52, 'user52@example.com', '2025-10-11 09:20:32'),
(53, 'user53@example.com', '2025-10-11 09:35:44'),
(54, 'user54@example.com', '2025-10-11 09:55:12'),
(55, 'user55@example.com', '2025-10-11 10:12:33'),
(56, 'user56@example.com', '2025-10-11 10:28:19'),
(57, 'user57@example.com', '2025-10-11 10:42:21'),
(58, 'user58@example.com', '2025-10-11 10:58:55'),
(59, 'user59@example.com', '2025-10-11 11:10:31'),
(60, 'user60@example.com', '2025-10-11 11:20:47'),
(61, 'user61@example.com', '2025-10-11 11:35:23'),
(62, 'user62@example.com', '2025-10-11 11:48:09'),
(63, 'user63@example.com', '2025-10-11 12:02:41'),
(64, 'user64@example.com', '2025-10-11 12:15:56'),
(65, 'user65@example.com', '2025-10-11 12:30:28'),
(66, 'user66@example.com', '2025-10-11 12:40:50'),
(67, 'user67@example.com', '2025-10-11 12:55:09'),
(68, 'user68@example.com', '2025-10-11 13:05:31'),
(69, 'user69@example.com', '2025-10-11 13:20:14'),
(70, 'user70@example.com', '2025-10-11 13:35:47'),
(71, 'user71@example.com', '2025-10-11 13:50:02'),
(72, 'user72@example.com', '2025-10-11 14:05:26'),
(73, 'user73@example.com', '2025-10-11 14:20:41'),
(74, 'user74@example.com', '2025-10-11 14:35:55'),
(75, 'user75@example.com', '2025-10-11 14:50:37'),
(76, 'user76@example.com', '2025-10-11 15:05:19'),
(77, 'user77@example.com', '2025-10-11 15:20:51'),
(78, 'user78@example.com', '2025-10-11 15:35:25'),
(79, 'user79@example.com', '2025-10-11 15:50:39'),
(80, 'user80@example.com', '2025-10-11 16:05:47'),
(81, 'user81@example.com', '2025-10-11 16:20:13'),
(82, 'user82@example.com', '2025-10-11 16:35:41'),
(83, 'user83@example.com', '2025-10-11 16:50:58'),
(84, 'user84@example.com', '2025-10-11 17:05:27'),
(85, 'user85@example.com', '2025-10-11 17:20:53'),
(86, 'user86@example.com', '2025-10-11 17:35:40'),
(87, 'user87@example.com', '2025-10-11 17:50:16'),
(88, 'user88@example.com', '2025-10-11 18:05:45'),
(89, 'user89@example.com', '2025-10-11 18:20:59'),
(90, 'user90@example.com', '2025-10-11 18:35:27'),
(91, 'user91@example.com', '2025-10-11 18:50:42'),
(92, 'user92@example.com', '2025-10-11 19:05:31'),
(93, 'user93@example.com', '2025-10-11 19:20:57'),
(94, 'user94@example.com', '2025-10-11 19:35:43'),
(95, 'user95@example.com', '2025-10-11 19:50:58'),
(96, 'user96@example.com', '2025-10-11 20:05:14'),
(97, 'user97@example.com', '2025-10-11 20:20:46'),
(98, 'user98@example.com', '2025-10-11 20:35:11'),
(99, 'user99@example.com', '2025-10-11 20:50:42'),
(100, 'user100@example.com', '2025-10-11 21:05:29'),
(101, 'user101@example.com', '2025-10-12 08:10:11'),
(102, 'user102@example.com', '2025-10-12 08:25:32'),
(103, 'user103@example.com', '2025-10-12 08:40:44'),
(104, 'user104@example.com', '2025-10-12 08:55:12'),
(105, 'user105@example.com', '2025-10-12 09:10:33'),
(106, 'user106@example.com', '2025-10-12 09:25:19'),
(107, 'user107@example.com', '2025-10-12 09:42:21'),
(108, 'user108@example.com', '2025-10-12 09:58:55'),
(109, 'user109@example.com', '2025-10-12 10:10:31'),
(110, 'user110@example.com', '2025-10-12 10:20:47'),
(111, 'user249@example.com', '2025-10-19 22:15:32'),
(112, 'user250@example.com', '2025-10-19 22:30:17'),
(113, 'abc@gmail.com', '2025-10-30 15:56:20'),
(114, 'alexander@example.com', '2025-10-20 10:05:11'),
(115, 'brianna@example.com', '2025-10-20 10:12:42'),
(116, 'charlie@example.com', '2025-10-20 10:25:37'),
(117, 'danielle@example.com', '2025-10-20 10:45:19'),
(118, 'ethan@example.com', '2025-10-20 11:05:55'),
(119, 'fiona@example.com', '2025-10-20 11:15:28'),
(120, 'george@example.com', '2025-10-20 11:25:10'),
(121, 'hannah@example.com', '2025-10-20 11:35:46'),
(122, 'isaac@example.com', '2025-10-20 11:50:22'),
(123, 'jasmine@example.com', '2025-10-20 12:05:14'),
(124, 'kevin@example.com', '2025-10-20 12:15:47'),
(125, 'linda@example.com', '2025-10-20 12:28:55'),
(126, 'michael@example.com', '2025-10-20 12:40:23'),
(127, 'natalie@example.com', '2025-10-20 12:52:41'),
(128, 'oliver@example.com', '2025-10-20 13:05:33'),
(129, 'penelope@example.com', '2025-10-20 13:15:09'),
(130, 'quentin@example.com', '2025-10-20 13:25:54'),
(131, 'rachel@example.com', '2025-10-20 13:35:20'),
(132, 'samuel@example.com', '2025-10-20 13:45:42'),
(133, 'tiffany@example.com', '2025-10-20 13:55:37'),
(134, 'ursula@example.com', '2025-10-20 14:05:23'),
(135, 'victor@example.com', '2025-10-20 14:15:11'),
(136, 'wanda@example.com', '2025-10-20 14:25:47'),
(137, 'xavier@example.com', '2025-10-20 14:35:55'),
(138, 'yasmin@example.com', '2025-10-20 14:45:42'),
(139, 'zachary@example.com', '2025-10-20 14:55:28'),
(140, 'aarav@example.com', '2025-10-21 09:05:14'),
(141, 'bella@example.com', '2025-10-21 09:15:33'),
(142, 'carlos@example.com', '2025-10-21 09:25:42'),
(143, 'divya@example.com', '2025-10-21 09:35:19'),
(144, 'elijah@example.com', '2025-10-21 09:45:56'),
(145, 'fatima@example.com', '2025-10-21 09:55:23'),
(146, 'gabriel@example.com', '2025-10-21 10:05:49'),
(147, 'harper@example.com', '2025-10-21 10:15:38'),
(148, 'ivan@example.com', '2025-10-21 10:25:12'),
(149, 'jade@example.com', '2025-10-21 10:35:44'),
(150, 'karthik@example.com', '2025-10-21 10:45:29'),
(151, 'lara@example.com', '2025-10-21 10:55:18'),
(152, 'mateo@example.com', '2025-10-21 11:05:46'),
(153, 'noah@example.com', '2025-10-21 11:15:55'),
(154, 'ophelia@example.com', '2025-10-21 11:25:33'),
(155, 'paul@example.com', '2025-10-21 11:35:47'),
(156, 'qiara@example.com', '2025-10-21 11:45:56'),
(157, 'rishi@example.com', '2025-10-21 11:55:22'),
(158, 'sofia@example.com', '2025-10-21 12:05:13'),
(159, 'tomas@example.com', '2025-10-21 12:15:40'),
(160, 'uma@example.com', '2025-10-21 12:25:51'),
(161, 'vanya@example.com', '2025-10-21 12:35:48'),
(162, 'william@example.com', '2025-10-21 12:45:33'),
(163, 'xena@example.com', '2025-10-21 12:55:24'),
(164, 'yuvraj@example.com', '2025-10-21 13:05:42'),
(165, 'zoe@example.com', '2025-10-21 13:15:59'),
(166, 'aditya@example.com', '2025-10-21 13:25:36'),
(167, 'bianca@example.com', '2025-10-21 13:35:51'),
(168, 'catherine@example.com', '2025-10-21 13:45:19'),
(169, 'daksh@example.com', '2025-10-21 13:55:42'),
(170, 'elena@example.com', '2025-10-21 14:05:24'),
(171, 'farhan@example.com', '2025-10-21 14:15:47'),
(172, 'grace@example.com', '2025-10-21 14:25:59'),
(173, 'hitesh@example.com', '2025-10-21 14:35:33'),
(174, 'irene@example.com', '2025-10-21 14:45:26'),
(175, 'jayden@example.com', '2025-10-21 14:55:39'),
(176, 'kiran@example.com', '2025-10-21 15:05:42'),
(177, 'lisa@example.com', '2025-10-21 15:15:51'),
(178, 'manish@example.com', '2025-10-21 15:25:18'),
(179, 'nina@example.com', '2025-10-21 15:35:56'),
(180, 'omar@example.com', '2025-10-21 15:45:43'),
(181, 'priya@example.com', '2025-10-21 15:55:59'),
(182, 'quentina@example.com', '2025-10-21 16:05:23'),
(183, 'rohit@example.com', '2025-10-21 16:15:44'),
(184, 'sara@example.com', '2025-10-21 16:25:38'),
(185, 'tanmay@example.com', '2025-10-21 16:35:57'),
(186, 'ursala@example.com', '2025-10-21 16:45:41'),
(187, 'vaishnavi@example.com', '2025-10-21 16:55:12'),
(188, 'willow@example.com', '2025-10-21 17:05:36'),
(189, 'xander@example.com', '2025-10-21 17:15:58'),
(190, 'yasir@example.com', '2025-10-21 17:25:47'),
(191, 'zoha@example.com', '2025-10-21 17:35:59'),
(192, 'arjun@example.com', '2025-10-22 09:05:11'),
(193, 'brielle@example.com', '2025-10-22 09:15:24'),
(194, 'cyrus@example.com', '2025-10-22 09:25:45'),
(195, 'dia@example.com', '2025-10-22 09:35:32'),
(196, 'eman@example.com', '2025-10-22 09:45:40'),
(197, 'farah@example.com', '2025-10-22 09:55:59'),
(198, 'gautam@example.com', '2025-10-22 10:05:48'),
(199, 'hana@example.com', '2025-10-22 10:15:19'),
(200, 'ian@example.com', '2025-10-22 10:25:57'),
(201, 'joanna@example.com', '2025-10-22 10:35:41'),
(202, 'karan@example.com', '2025-10-22 10:45:59'),
(203, 'leah@example.com', '2025-10-22 10:55:31'),
(204, 'mohit@example.com', '2025-10-22 11:05:14'),
(205, 'nora@example.com', '2025-10-22 11:15:37'),
(206, 'omkar@example.com', '2025-10-22 11:25:55'),
(207, 'paula@example.com', '2025-10-22 11:35:12'),
(208, 'rahul@example.com', '2025-10-22 11:45:47'),
(209, 'sneha@example.com', '2025-10-22 11:55:29'),
(210, 'taran@example.com', '2025-10-22 12:05:15'),
(211, 'urmi@example.com', '2025-10-22 12:15:59'),
(212, 'vedant@example.com', '2025-10-22 12:25:46'),
(213, 'willie@example.com', '2025-10-22 12:35:28'),
(214, 'ximena@example.com', '2025-10-22 12:45:11'),
(215, 'yasmeen@example.com', '2025-10-22 12:55:33'),
(216, 'zaheer@example.com', '2025-10-22 13:05:25'),
(217, 'amelia@example.com', '2025-10-22 13:15:18'),
(218, 'ben@example.com', '2025-10-22 13:25:36'),
(219, 'carla@example.com', '2025-10-22 13:35:22'),
(220, 'dylan@example.com', '2025-10-22 13:45:55'),
(221, 'emily@example.com', '2025-10-22 13:55:47'),
(222, 'felix@example.com', '2025-10-22 14:05:33'),
(223, 'gita@example.com', '2025-10-22 14:15:18'),
(224, 'harry@example.com', '2025-10-22 14:25:47'),
(225, 'ines@example.com', '2025-10-22 14:35:41'),
(226, 'joseph@example.com', '2025-10-22 14:45:59'),
(227, 'krisha@example.com', '2025-10-22 14:55:28'),
(228, 'liam@example.com', '2025-10-22 15:05:15'),
(229, 'maya@example.com', '2025-10-22 15:15:47'),
(230, 'nolan@example.com', '2025-10-22 15:25:51'),
(231, 'olive@example.com', '2025-10-22 15:35:12'),
(232, 'peter@example.com', '2025-10-22 15:45:56'),
(233, 'qasim@example.com', '2025-10-22 15:55:39'),
(234, 'riva@example.com', '2025-10-22 16:05:27'),
(235, 'sahil@example.com', '2025-10-22 16:15:19'),
(236, 'tara@example.com', '2025-10-22 16:25:33'),
(237, 'ujwal@example.com', '2025-10-22 16:35:47'),
(238, 'vicky@example.com', '2025-10-22 16:45:51'),
(239, 'winnie@example.com', '2025-10-22 16:55:13'),
(240, 'ximon@example.com', '2025-10-22 17:05:24'),
(241, 'yara@example.com', '2025-10-22 17:15:42'),
(242, 'zane@example.com', '2025-10-22 17:25:55'),
(243, 'arya@example.com', '2025-10-22 17:35:28'),
(244, 'aarohi@example.com', '2025-10-23 09:00:12'),
(245, 'brandon@example.com', '2025-10-23 09:05:44'),
(246, 'celine@example.com', '2025-10-23 09:10:31'),
(247, 'dev@example.com', '2025-10-23 09:15:55'),
(248, 'elisa@example.com', '2025-10-23 09:21:23'),
(249, 'fahad@example.com', '2025-10-23 09:26:47'),
(250, 'gracey@example.com', '2025-10-23 09:32:11'),
(251, 'haroon@example.com', '2025-10-23 09:37:58'),
(252, 'isha@example.com', '2025-10-23 09:43:21'),
(253, 'jared@example.com', '2025-10-23 09:48:46'),
(254, 'karina@example.com', '2025-10-23 09:54:13'),
(255, 'leo@example.com', '2025-10-23 09:59:40'),
(256, 'meera@example.com', '2025-10-23 10:04:55'),
(257, 'nathan@example.com', '2025-10-23 10:10:29'),
(258, 'oliviaa@example.com', '2025-10-23 10:15:55'),
(259, 'parth@example.com', '2025-10-23 10:21:22'),
(260, 'qianna@example.com', '2025-10-23 10:26:40'),
(261, 'rajat@example.com', '2025-10-23 10:31:56'),
(262, 'sana@example.com', '2025-10-23 10:37:19'),
(263, 'tahir@example.com', '2025-10-23 10:42:41'),
(264, 'urvashi@example.com', '2025-10-23 10:48:07'),
(265, 'veer@example.com', '2025-10-23 10:53:33'),
(266, 'whitney@example.com', '2025-10-23 10:58:49'),
(267, 'ximon2@example.com', '2025-10-23 11:04:11'),
(268, 'yasira@example.com', '2025-10-23 11:09:36'),
(269, 'zuber@example.com', '2025-10-23 11:14:50'),
(270, 'abhay@example.com', '2025-10-23 11:20:12'),
(271, 'bhavna@example.com', '2025-10-23 11:25:39'),
(272, 'chris@example.com', '2025-10-23 11:31:03'),
(273, 'divakar@example.com', '2025-10-23 11:36:28'),
(274, 'elina@example.com', '2025-10-23 11:41:47'),
(275, 'farooq@example.com', '2025-10-23 11:47:03'),
(276, 'gargi@example.com', '2025-10-23 11:52:32'),
(277, 'harryg@example.com', '2025-10-23 11:57:48'),
(278, 'ishaana@example.com', '2025-10-23 12:03:17'),
(279, 'jaydeep@example.com', '2025-10-23 12:08:45'),
(280, 'kylie@example.com', '2025-10-23 12:14:12'),
(281, 'lokesh@example.com', '2025-10-23 12:19:41'),
(282, 'mira@example.com', '2025-10-23 12:25:07'),
(283, 'nihal@example.com', '2025-10-23 12:30:30'),
(284, 'opal@example.com', '2025-10-23 12:36:02'),
(285, 'pranav@example.com', '2025-10-23 12:41:27'),
(286, 'qadir@example.com', '2025-10-23 12:46:54'),
(287, 'rashmi@example.com', '2025-10-23 12:52:21'),
(288, 'sumit@example.com', '2025-10-23 12:57:49'),
(289, 'tina@example.com', '2025-10-23 13:03:15'),
(290, 'udit@example.com', '2025-10-23 13:08:41'),
(291, 'vaibhav@example.com', '2025-10-23 13:14:12'),
(292, 'wasim@example.com', '2025-10-23 13:19:45'),
(293, 'xaria@example.com', '2025-10-23 13:25:14'),
(294, 'yogesh@example.com', '2025-10-23 13:30:43'),
(295, 'zaina@example.com', '2025-10-23 13:36:10'),
(296, 'alina@example.com', '2025-10-23 13:41:37'),
(297, 'bilal@example.com', '2025-10-23 13:47:03'),
(298, 'charlotte@example.com', '2025-10-23 13:52:24'),
(299, 'derek@example.com', '2025-10-23 13:57:49'),
(300, 'elijahs@example.com', '2025-10-23 14:03:15'),
(301, 'farida@example.com', '2025-10-23 14:08:42'),
(302, 'geet@example.com', '2025-10-23 14:14:05'),
(303, 'hassan@example.com', '2025-10-23 14:19:27'),
(304, 'inesa@example.com', '2025-10-23 14:24:49'),
(305, 'jack@example.com', '2025-10-23 14:30:14'),
(306, 'kavya@example.com', '2025-10-23 14:35:39'),
(307, 'liya@example.com', '2025-10-23 14:41:05'),
(308, 'muhammad@example.com', '2025-10-23 14:46:31'),
(309, 'nidhi@example.com', '2025-10-23 14:52:03'),
(310, 'omarh@example.com', '2025-10-23 14:57:28'),
(311, 'preeti@example.com', '2025-10-23 15:02:54'),
(312, 'qiana@example.com', '2025-10-23 15:08:17'),
(313, 'rakesh@example.com', '2025-10-23 15:13:45'),
(314, 'saira@example.com', '2025-10-23 15:19:06'),
(315, 'toby@example.com', '2025-10-23 15:24:38'),
(316, 'uriel@example.com', '2025-10-23 15:29:59'),
(317, 'vidya@example.com', '2025-10-23 15:35:28'),
(318, 'walter@example.com', '2025-10-23 15:40:57'),
(319, 'ximara@example.com', '2025-10-23 15:46:20'),
(320, 'yuvan@example.com', '2025-10-23 15:51:45'),
(321, 'zoheb@example.com', '2025-10-23 15:57:08'),
(322, 'aisha@example.com', '2025-10-23 16:02:35'),
(323, 'bryce@example.com', '2025-10-23 16:08:01'),
(324, 'ciara@example.com', '2025-10-23 16:13:29'),
(325, 'dinesh@example.com', '2025-10-23 16:18:55'),
(326, 'emmaw@example.com', '2025-10-23 16:24:21'),
(327, 'faizal@example.com', '2025-10-23 16:29:47'),
(328, 'guneet@example.com', '2025-10-23 16:35:13'),
(329, 'hira@example.com', '2025-10-23 16:40:38'),
(330, 'ianh@example.com', '2025-10-23 16:46:04'),
(331, 'julia@example.com', '2025-10-23 16:51:29'),
(332, 'kamal@example.com', '2025-10-23 16:56:54'),
(333, 'lavina@example.com', '2025-10-23 17:02:18'),
(334, 'mohan@example.com', '2025-10-23 17:07:47'),
(335, 'noraq@example.com', '2025-10-23 17:13:10'),
(336, 'oscar@example.com', '2025-10-23 17:18:35'),
(337, 'paige@example.com', '2025-10-23 17:24:01'),
(338, 'queenie@example.com', '2025-10-23 17:29:29'),
(339, 'rajiv@example.com', '2025-10-23 17:34:50'),
(340, 'simran@example.com', '2025-10-23 17:40:15'),
(341, 'tarun@example.com', '2025-10-23 17:45:37'),
(342, 'urvansh@example.com', '2025-10-23 17:51:05'),
(343, 'vivek@example.com', '2025-10-23 17:56:29'),
(344, 'whitneyb@example.com', '2025-10-23 18:01:56'),
(345, 'xavian@example.com', '2025-10-23 18:07:21'),
(346, 'yashika@example.com', '2025-10-23 18:12:44'),
(347, 'zeke@example.com', '2025-10-23 18:18:07'),
(348, 'aayushi@example.com', '2025-10-23 18:23:31'),
(349, 'benita@example.com', '2025-10-23 18:28:55'),
(350, 'chandan@example.com', '2025-10-23 18:34:22'),
(351, 'danica@example.com', '2025-10-23 18:39:48'),
(352, 'edward@example.com', '2025-10-23 18:45:14'),
(353, 'fiza@example.com', '2025-10-23 18:50:39'),
(354, 'gaurav@example.com', '2025-10-23 18:56:05'),
(355, 'helen@example.com', '2025-10-23 19:01:27'),
(356, 'ishan@example.com', '2025-10-23 19:06:52'),
(357, 'jennifer@example.com', '2025-10-23 19:12:20'),
(358, 'kunal@example.com', '2025-10-23 19:17:47'),
(359, 'louis@example.com', '2025-10-23 19:23:13'),
(360, 'manu@example.com', '2025-10-23 19:28:41'),
(361, 'nivedita@example.com', '2025-10-23 19:34:08'),
(362, 'omprakash@example.com', '2025-10-23 19:39:35'),
(363, 'pallavi@example.com', '2025-10-23 19:45:01'),
(364, 'quadir@example.com', '2025-10-23 19:50:27'),
(365, 'ravi@example.com', '2025-10-23 19:55:54'),
(366, 'shweta@example.com', '2025-10-23 20:01:20'),
(367, 'tanisha@example.com', '2025-10-23 20:06:47'),
(368, 'uday@example.com', '2025-10-23 20:12:13'),
(369, 'vishal@example.com', '2025-10-23 20:17:39'),
(370, 'waseem@example.com', '2025-10-23 20:23:06'),
(371, 'xia@example.com', '2025-10-23 20:28:32'),
(372, 'yuvika@example.com', '2025-10-23 20:33:59'),
(373, 'zoya@example.com', '2025-10-23 20:39:25'),
(374, 'amrit@example.com', '2025-10-23 20:44:51'),
(375, 'bhavesh@example.com', '2025-10-23 20:50:18'),
(376, 'clara@example.com', '2025-10-23 20:55:44'),
(377, 'deepika@example.com', '2025-10-23 21:01:10'),
(378, 'emmanuel@example.com', '2025-10-23 21:06:37'),
(379, 'fatimah@example.com', '2025-10-23 21:12:03'),
(380, 'gokul@example.com', '2025-10-23 21:17:30'),
(381, 'harsha@example.com', '2025-10-23 21:22:56'),
(382, 'ishaans@example.com', '2025-10-23 21:28:22'),
(383, 'jose@example.com', '2025-10-23 21:33:49'),
(384, 'krishaana@example.com', '2025-10-23 21:39:15'),
(385, 'lina@example.com', '2025-10-23 21:44:41'),
(386, 'manoj@example.com', '2025-10-23 21:50:08'),
(387, 'neel@example.com', '2025-10-23 21:55:34'),
(388, 'omisha@example.com', '2025-10-23 22:01:01'),
(389, 'parveen@example.com', '2025-10-23 22:06:27'),
(390, 'qurat@example.com', '2025-10-23 22:11:54'),
(391, 'rhea@example.com', '2025-10-23 22:17:20'),
(392, 'shivam@example.com', '2025-10-23 22:22:46'),
(393, 'tanishq@example.com', '2025-10-23 22:28:13'),
(394, 'aarush@example.com', '2025-10-24 09:00:15'),
(395, 'bhumika@example.com', '2025-10-24 09:05:33'),
(396, 'chaitanya@example.com', '2025-10-24 09:10:49'),
(397, 'daisy@example.com', '2025-10-24 09:16:05'),
(398, 'ekansh@example.com', '2025-10-24 09:21:24'),
(399, 'fiona2@example.com', '2025-10-24 09:26:47'),
(400, 'gautami@example.com', '2025-10-24 09:32:10'),
(401, 'hardik@example.com', '2025-10-24 09:37:28'),
(402, 'ishaana2@example.com', '2025-10-24 09:42:54'),
(403, 'jay@example.com', '2025-10-24 09:48:21'),
(404, 'kristina@example.com', '2025-10-24 09:53:40'),
(405, 'lakshay@example.com', '2025-10-24 09:59:02'),
(406, 'meghana@example.com', '2025-10-24 10:04:29'),
(407, 'nirmal@example.com', '2025-10-24 10:09:56'),
(408, 'omkar2@example.com', '2025-10-24 10:15:12'),
(409, 'priyansh@example.com', '2025-10-24 10:20:37'),
(410, 'qamar@example.com', '2025-10-24 10:25:59'),
(411, 'riddhi@example.com', '2025-10-24 10:31:22'),
(412, 'sagar@example.com', '2025-10-24 10:36:44'),
(413, 'talia@example.com', '2025-10-24 10:42:01'),
(414, 'udita@example.com', '2025-10-24 10:47:23'),
(415, 'vihan@example.com', '2025-10-24 10:52:46'),
(416, 'winston@example.com', '2025-10-24 10:58:11'),
(417, 'ximena2@example.com', '2025-10-24 11:03:38'),
(418, 'yasmin2@example.com', '2025-10-24 11:08:59'),
(419, 'zoe2@example.com', '2025-10-24 11:14:22'),
(420, 'aditya2@example.com', '2025-10-24 11:19:46'),
(421, 'bianca2@example.com', '2025-10-24 11:25:11'),
(422, 'chirag@example.com', '2025-10-24 11:30:35'),
(423, 'devika@example.com', '2025-10-24 11:35:58'),
(424, 'edward2@example.com', '2025-10-24 11:41:20'),
(425, 'fatima2@example.com', '2025-10-24 11:46:42'),
(426, 'gauri@example.com', '2025-10-24 11:52:08'),
(427, 'harper2@example.com', '2025-10-24 11:57:33'),
(428, 'ian2@example.com', '2025-10-24 12:02:59'),
(429, 'jasmine2@example.com', '2025-10-24 12:08:21'),
(430, 'krish@example.com', '2025-10-24 12:13:48'),
(431, 'lara2@example.com', '2025-10-24 12:19:10'),
(432, 'milan@example.com', '2025-10-24 12:24:33'),
(433, 'nisha2@example.com', '2025-10-24 12:29:58'),
(434, 'omisha2@example.com', '2025-10-24 12:35:21'),
(435, 'paul2@example.com', '2025-10-24 12:40:42'),
(436, 'qiara2@example.com', '2025-10-24 12:46:06'),
(437, 'rohit2@example.com', '2025-10-24 12:51:29'),
(438, 'sneha2@example.com', '2025-10-24 12:56:51'),
(439, 'tanvi@example.com', '2025-10-24 13:02:15'),
(440, 'udit2@example.com', '2025-10-24 13:07:40'),
(441, 'vaishali@example.com', '2025-10-24 13:12:59'),
(442, 'william2@example.com', '2025-10-24 13:18:27'),
(443, 'xander2@example.com', '2025-10-24 13:23:49'),
(444, 'yashvi@example.com', '2025-10-24 13:29:14'),
(445, 'zainab@example.com', '2025-10-24 13:34:37'),
(446, 'aanya@example.com', '2025-10-24 13:40:02'),
(447, 'bhavesh2@example.com', '2025-10-24 13:45:28'),
(448, 'catherine2@example.com', '2025-10-24 13:50:49'),
(449, 'deepika2@example.com', '2025-10-24 13:56:17'),
(450, 'emmanuel2@example.com', '2025-10-24 14:01:42'),
(451, 'farhan2@example.com', '2025-10-24 14:07:09'),
(452, 'gita2@example.com', '2025-10-24 14:12:31'),
(453, 'hemant@example.com', '2025-10-24 14:17:59'),
(454, 'isha2@example.com', '2025-10-24 14:23:21'),
(455, 'jayant@example.com', '2025-10-24 14:28:47'),
(456, 'kamini@example.com', '2025-10-24 14:34:09'),
(457, 'lokesh2@example.com', '2025-10-24 14:39:33'),
(458, 'manisha2@example.com', '2025-10-24 14:44:59'),
(459, 'navya@example.com', '2025-10-24 14:50:21'),
(460, 'omprakash2@example.com', '2025-10-24 14:55:48'),
(461, 'pavitra@example.com', '2025-10-24 15:01:09'),
(462, 'quadir2@example.com', '2025-10-24 15:06:33'),
(463, 'ramesh@example.com', '2025-10-24 15:11:57'),
(464, 'shweta2@example.com', '2025-10-24 15:17:20'),
(465, 'tanisha2@example.com', '2025-10-24 15:22:45'),
(466, 'udit3@example.com', '2025-10-24 15:28:09'),
(467, 'vaibhavi@example.com', '2025-10-24 15:33:31'),
(468, 'wasim2@example.com', '2025-10-24 15:38:58'),
(469, 'xia@example.com', '2025-10-24 15:44:20'),
(470, 'yogita@example.com', '2025-10-24 15:49:43'),
(471, 'zoya2@example.com', '2025-10-24 15:55:05'),
(472, 'aryan2@example.com', '2025-10-24 16:00:27'),
(473, 'bela@example.com', '2025-10-24 16:05:51'),
(474, 'chetan@example.com', '2025-10-24 16:11:13'),
(475, 'divya2@example.com', '2025-10-24 16:16:39'),
(476, 'elena2@example.com', '2025-10-24 16:22:04'),
(477, 'faiz@example.com', '2025-10-24 16:27:26'),
(478, 'geeta@example.com', '2025-10-24 16:32:49'),
(479, 'harsha2@example.com', '2025-10-24 16:38:12'),
(480, 'isha3@example.com', '2025-10-24 16:43:36'),
(481, 'joseph2@example.com', '2025-10-24 16:49:01'),
(482, 'karuna@example.com', '2025-10-24 16:54:25'),
(483, 'lakshya2@example.com', '2025-10-24 16:59:48'),
(484, 'mehul@example.com', '2025-10-24 17:05:11'),
(485, 'nikita@example.com', '2025-10-24 17:10:35'),
(486, 'omisha3@example.com', '2025-10-24 17:15:57'),
(487, 'pankaj@example.com', '2025-10-24 17:21:21'),
(488, 'qiara3@example.com', '2025-10-24 17:26:46'),
(489, 'ravi2@example.com', '2025-10-24 17:32:08'),
(490, 'sarita@example.com', '2025-10-24 17:37:31'),
(491, 'tarun2@example.com', '2025-10-24 17:42:53'),
(492, 'ujjwal2@example.com', '2025-10-24 17:48:19'),
(493, 'varun2@example.com', '2025-10-24 17:53:44'),
(494, 'waqar@example.com', '2025-10-24 17:59:05'),
(495, 'ximena3@example.com', '2025-10-24 18:04:27'),
(496, 'yasir2@example.com', '2025-10-24 18:09:52'),
(497, 'zain2@example.com', '2025-10-24 18:15:16'),
(498, 'akshita@example.com', '2025-10-24 18:20:38'),
(499, 'brian@example.com', '2025-10-24 18:26:01'),
(500, 'celina@example.com', '2025-10-24 18:31:27'),
(501, 'deep@example.com', '2025-10-24 18:36:53'),
(502, 'elijah2@example.com', '2025-10-24 18:42:15'),
(503, 'farida2@example.com', '2025-10-24 18:47:37'),
(504, 'gopal@example.com', '2025-10-24 18:52:59'),
(505, 'hema@example.com', '2025-10-24 18:58:22'),
(506, 'ishan2@example.com', '2025-10-24 19:03:44'),
(507, 'jaya2@example.com', '2025-10-24 19:09:09'),
(508, 'kavita@example.com', '2025-10-24 19:14:33'),
(509, 'luke2@example.com', '2025-10-24 19:19:59'),
(510, 'mona@example.com', '2025-10-24 19:25:20'),
(511, 'nilesh@example.com', '2025-10-24 19:30:44'),
(512, 'oscar2@example.com', '2025-10-24 19:36:07'),
(513, 'parveen2@example.com', '2025-10-24 19:41:33'),
(514, 'quinn@example.com', '2025-10-24 19:46:57'),
(515, 'rhea2@example.com', '2025-10-24 19:52:21'),
(516, 'siddharth@example.com', '2025-10-24 19:57:43'),
(517, 'tisha@example.com', '2025-10-24 20:03:09'),
(518, 'ujwala@example.com', '2025-10-24 20:08:32'),
(519, 'vicky2@example.com', '2025-10-24 20:13:54'),
(520, 'warren@example.com', '2025-10-24 20:19:19'),
(521, 'xia2@example.com', '2025-10-24 20:24:43'),
(522, 'yuvraj2@example.com', '2025-10-24 20:30:05'),
(523, 'zoya3@example.com', '2025-10-24 20:35:29'),
(524, 'aaryan@example.com', '2025-10-24 20:40:53'),
(525, 'bhavna2@example.com', '2025-10-24 20:46:15'),
(526, 'chetna@example.com', '2025-10-24 20:51:39'),
(527, 'devansh@example.com', '2025-10-24 20:56:59'),
(528, 'esha@example.com', '2025-10-24 21:02:25'),
(529, 'fahim2@example.com', '2025-10-24 21:07:48'),
(530, 'garima2@example.com', '2025-10-24 21:13:10'),
(531, 'hitesh2@example.com', '2025-10-24 21:18:36'),
(532, 'indra@example.com', '2025-10-24 21:23:59'),
(533, 'janvi2@example.com', '2025-10-24 21:29:23'),
(534, 'kartik2@example.com', '2025-10-24 21:34:47'),
(535, 'lavanya@example.com', '2025-10-24 21:40:09'),
(536, 'manav@example.com', '2025-10-24 21:45:33'),
(537, 'nandini@example.com', '2025-10-24 21:50:58'),
(538, 'omkar3@example.com', '2025-10-24 21:56:20'),
(539, 'piyush@example.com', '2025-10-24 22:01:43'),
(540, 'qurat2@example.com', '2025-10-24 22:07:05'),
(541, 'rajesh@example.com', '2025-10-24 22:12:29'),
(542, 'shruti@example.com', '2025-10-24 22:17:51'),
(543, 'tanya@example.com', '2025-10-24 22:23:17'),
(544, 'udit4@example.com', '2025-10-25 08:00:15'),
(545, 'vaidehi@example.com', '2025-10-25 08:05:37'),
(546, 'waseem3@example.com', '2025-10-25 08:10:59'),
(547, 'xenia@example.com', '2025-10-25 08:16:21'),
(548, 'yogesh2@example.com', '2025-10-25 08:21:44'),
(549, 'zahara@example.com', '2025-10-25 08:27:08'),
(550, 'aarav3@example.com', '2025-10-25 08:32:32'),
(551, 'bhavika@example.com', '2025-10-25 08:37:55'),
(552, 'chetan2@example.com', '2025-10-25 08:43:19'),
(553, 'daksh@example.com', '2025-10-25 08:48:42'),
(554, 'ekta2@example.com', '2025-10-25 08:54:07'),
(555, 'firoz@example.com', '2025-10-25 08:59:31'),
(556, 'gargi2@example.com', '2025-10-25 09:04:55'),
(557, 'harman@example.com', '2025-10-25 09:10:17'),
(558, 'isha4@example.com', '2025-10-25 09:15:39'),
(559, 'jatin@example.com', '2025-10-25 09:21:05'),
(560, 'karishma2@example.com', '2025-10-25 09:26:27'),
(561, 'lalit@example.com', '2025-10-25 09:31:49'),
(562, 'meera2@example.com', '2025-10-25 09:37:15'),
(563, 'nirmala@example.com', '2025-10-25 09:42:39'),
(564, 'om2@example.com', '2025-10-25 09:47:58'),
(565, 'pranav@example.com', '2025-10-25 09:53:23'),
(566, 'quincy@example.com', '2025-10-25 09:58:46'),
(567, 'riya3@example.com', '2025-10-25 10:04:10'),
(568, 'saket@example.com', '2025-10-25 10:09:37'),
(569, 'tanu@example.com', '2025-10-25 10:14:59'),
(570, 'urvashi@example.com', '2025-10-25 10:20:22'),
(571, 'vishal@example.com', '2025-10-25 10:25:49'),
(572, 'winnie2@example.com', '2025-10-25 10:31:10'),
(573, 'xander3@example.com', '2025-10-25 10:36:34'),
(574, 'yasmeen2@example.com', '2025-10-25 10:41:56'),
(575, 'zoya4@example.com', '2025-10-25 10:47:18'),
(576, 'aisha3@example.com', '2025-10-25 10:52:40'),
(577, 'bharat@example.com', '2025-10-25 10:58:07'),
(578, 'chitra@example.com', '2025-10-25 11:03:29'),
(579, 'dinesh@example.com', '2025-10-25 11:08:55'),
(580, 'elina@example.com', '2025-10-25 11:14:21'),
(581, 'fatema@example.com', '2025-10-25 11:19:45'),
(582, 'ganesh@example.com', '2025-10-25 11:25:09'),
(583, 'harshit@example.com', '2025-10-25 11:30:32'),
(584, 'indira@example.com', '2025-10-25 11:35:59'),
(585, 'jose@example.com', '2025-10-25 11:41:23'),
(586, 'kriti2@example.com', '2025-10-25 11:46:48'),
(587, 'laxmi@example.com', '2025-10-25 11:52:10'),
(588, 'mohit@example.com', '2025-10-25 11:57:36'),
(589, 'naina@example.com', '2025-10-25 12:02:59'),
(590, 'omkar4@example.com', '2025-10-25 12:08:21'),
(591, 'priya3@example.com', '2025-10-25 12:13:43'),
(592, 'qureshi@example.com', '2025-10-25 12:19:06'),
(593, 'rahul3@example.com', '2025-10-25 12:24:28'),
(594, 'shivani2@example.com', '2025-10-25 12:29:51'),
(595, 'tahir@example.com', '2025-10-25 12:35:13'),
(596, 'uma2@example.com', '2025-10-25 12:40:39'),
(597, 'vicky3@example.com', '2025-10-25 12:46:03'),
(598, 'wajid@example.com', '2025-10-25 12:51:27'),
(599, 'ximena4@example.com', '2025-10-25 12:56:50'),
(600, 'yash3@example.com', '2025-10-25 13:02:14'),
(601, 'zarin@example.com', '2025-10-25 13:07:39'),
(602, 'aarti@example.com', '2025-10-25 13:13:01'),
(603, 'brijesh@example.com', '2025-10-25 13:18:26'),
(604, 'chandni@example.com', '2025-10-25 13:23:49'),
(605, 'dhruv@example.com', '2025-10-25 13:29:13'),
(606, 'elisa@example.com', '2025-10-25 13:34:38'),
(607, 'fahad@example.com', '2025-10-25 13:40:02'),
(608, 'gagan@example.com', '2025-10-25 13:45:25'),
(609, 'heena@example.com', '2025-10-25 13:50:49'),
(610, 'ishita@example.com', '2025-10-25 13:56:14'),
(611, 'jayesh@example.com', '2025-10-25 14:01:37'),
(612, 'kiran2@example.com', '2025-10-25 14:07:01'),
(613, 'lakshmi@example.com', '2025-10-25 14:12:26'),
(614, 'mahesh@example.com', '2025-10-25 14:17:50'),
(615, 'nidhi@example.com', '2025-10-25 14:23:13'),
(616, 'omkar5@example.com', '2025-10-25 14:28:39'),
(617, 'pooja@example.com', '2025-10-25 14:33:59'),
(618, 'qureshia@example.com', '2025-10-25 14:39:25'),
(619, 'rajendra@example.com', '2025-10-25 14:44:49'),
(620, 'shraddha@example.com', '2025-10-25 14:50:13'),
(621, 'tushar@example.com', '2025-10-25 14:55:36'),
(622, 'usha@example.com', '2025-10-25 15:00:59'),
(623, 'vanshika@example.com', '2025-10-25 15:06:22'),
(624, 'wazir@example.com', '2025-10-25 15:11:45'),
(625, 'xia3@example.com', '2025-10-25 15:17:09'),
(626, 'yuvika@example.com', '2025-10-25 15:22:32'),
(627, 'zain3@example.com', '2025-10-25 15:27:54'),
(628, 'aaliya@example.com', '2025-10-25 15:33:17'),
(629, 'bhoomi@example.com', '2025-10-25 15:38:41'),
(630, 'chandan@example.com', '2025-10-25 15:43:59'),
(631, 'devanshi@example.com', '2025-10-25 15:49:26'),
(632, 'eva@example.com', '2025-10-25 15:54:49'),
(633, 'firoza@example.com', '2025-10-25 16:00:12'),
(634, 'gaurav@example.com', '2025-10-25 16:05:36'),
(635, 'harini@example.com', '2025-10-25 16:10:59'),
(636, 'indrajeet@example.com', '2025-10-25 16:16:23'),
(637, 'jaya3@example.com', '2025-10-25 16:21:46'),
(638, 'krunal@example.com', '2025-10-25 16:27:09'),
(639, 'lata@example.com', '2025-10-25 16:32:33'),
(640, 'manoj@example.com', '2025-10-25 16:37:57'),
(641, 'nikhil@example.com', '2025-10-25 16:43:19'),
(642, 'ojas@example.com', '2025-10-25 16:48:42'),
(643, 'payal@example.com', '2025-10-25 16:54:06'),
(644, 'qadir@example.com', '2025-10-25 16:59:30'),
(645, 'rahima@example.com', '2025-10-25 17:04:53'),
(646, 'sunil@example.com', '2025-10-25 17:10:17'),
(647, 'tanmay@example.com', '2025-10-25 17:15:41'),
(648, 'urmi@example.com', '2025-10-25 17:20:59'),
(649, 'vinit@example.com', '2025-10-25 17:26:23'),
(650, 'walia@example.com', '2025-10-25 17:31:47'),
(651, 'ximon@example.com', '2025-10-25 17:37:10'),
(652, 'yasir3@example.com', '2025-10-25 17:42:34'),
(653, 'zubaida@example.com', '2025-10-25 17:47:59'),
(654, 'abhay@example.com', '2025-10-25 17:53:23'),
(655, 'bharti@example.com', '2025-10-25 17:58:47'),
(656, 'chanchal@example.com', '2025-10-25 18:04:09'),
(657, 'deepa@example.com', '2025-10-25 18:09:32'),
(658, 'eric@example.com', '2025-10-25 18:14:56'),
(659, 'faisal@example.com', '2025-10-25 18:20:21'),
(660, 'gokul@example.com', '2025-10-25 18:25:44'),
(661, 'hema2@example.com', '2025-10-25 18:31:08'),
(662, 'ishwar@example.com', '2025-10-25 18:36:31'),
(663, 'jyoti@example.com', '2025-10-25 18:41:55'),
(664, 'kailash@example.com', '2025-10-25 18:47:19'),
(665, 'leela@example.com', '2025-10-25 18:52:42'),
(666, 'mukesh@example.com', '2025-10-25 18:58:06'),
(667, 'neha@example.com', '2025-10-25 19:03:30'),
(668, 'omika@example.com', '2025-10-25 19:08:54'),
(669, 'pranay@example.com', '2025-10-25 19:14:17'),
(670, 'qais@example.com', '2025-10-25 19:19:40'),
(671, 'rupal@example.com', '2025-10-25 19:25:04'),
(672, 'sachin@example.com', '2025-10-25 19:30:28'),
(673, 'tanuja@example.com', '2025-10-25 19:35:51'),
(674, 'uday@example.com', '2025-10-25 19:41:15'),
(675, 'vansh2@example.com', '2025-10-25 19:46:38'),
(676, 'wahida@example.com', '2025-10-25 19:52:02'),
(677, 'xenia2@example.com', '2025-10-25 19:57:25'),
(678, 'yashoda@example.com', '2025-10-25 20:02:49'),
(679, 'zulfikar@example.com', '2025-10-25 20:08:13'),
(680, 'aamir@example.com', '2025-10-25 20:13:36'),
(681, 'bhumika2@example.com', '2025-10-25 20:19:00'),
(682, 'chaitali@example.com', '2025-10-25 20:24:23'),
(683, 'divyansh@example.com', '2025-10-25 20:29:47'),
(684, 'esha2@example.com', '2025-10-25 20:35:10'),
(685, 'farha@example.com', '2025-10-25 20:40:34'),
(686, 'girish@example.com', '2025-10-25 20:45:58'),
(687, 'harshita@example.com', '2025-10-25 20:51:22'),
(688, 'indra2@example.com', '2025-10-25 20:56:45'),
(689, 'jyoti2@example.com', '2025-10-25 21:02:09'),
(690, 'kapil@example.com', '2025-10-25 21:07:32'),
(691, 'lavina@example.com', '2025-10-25 21:12:56'),
(692, 'manasi@example.com', '2025-10-25 21:18:20'),
(693, 'naveen2@example.com', '2025-10-25 21:23:44'),
(694, 'ojasvi@example.com', '2025-10-26 08:00:11'),
(695, 'priyanka@example.com', '2025-10-26 08:05:35'),
(696, 'qureshk@example.com', '2025-10-26 08:10:59'),
(697, 'rajiv@example.com', '2025-10-26 08:16:22'),
(698, 'shalini@example.com', '2025-10-26 08:21:46'),
(699, 'tapas@example.com', '2025-10-26 08:27:10'),
(700, 'urvish@example.com', '2025-10-26 08:32:33'),
(701, 'vikas@example.com', '2025-10-26 08:37:57'),
(702, 'waqar@example.com', '2025-10-26 08:43:21'),
(703, 'ximona@example.com', '2025-10-26 08:48:44'),
(704, 'yogita@example.com', '2025-10-26 08:54:08'),
(705, 'zuber@example.com', '2025-10-26 08:59:32'),
(706, 'abhilash@example.com', '2025-10-26 09:04:55'),
(707, 'bhavna@example.com', '2025-10-26 09:10:19'),
(708, 'chandresh@example.com', '2025-10-26 09:15:43'),
(709, 'deepali@example.com', '2025-10-26 09:21:07'),
(710, 'ekansh@example.com', '2025-10-26 09:26:30'),
(711, 'fariha@example.com', '2025-10-26 09:31:54'),
(712, 'girish2@example.com', '2025-10-26 09:37:18'),
(713, 'harpreet@example.com', '2025-10-26 09:42:42'),
(714, 'ishaque@example.com', '2025-10-26 09:48:05'),
(715, 'jaydeep@example.com', '2025-10-26 09:53:29'),
(716, 'kanika@example.com', '2025-10-26 09:58:53'),
(717, 'lokesh@example.com', '2025-10-26 10:04:16'),
(718, 'manasi2@example.com', '2025-10-26 10:09:40'),
(719, 'neeraj@example.com', '2025-10-26 10:15:04'),
(720, 'omisha@example.com', '2025-10-26 10:20:27'),
(721, 'pradeep@example.com', '2025-10-26 10:25:51'),
(722, 'quintin@example.com', '2025-10-26 10:31:15'),
(723, 'rishabh@example.com', '2025-10-26 10:36:38'),
(724, 'sakshi@example.com', '2025-10-26 10:42:02'),
(725, 'tanya@example.com', '2025-10-26 10:47:26'),
(726, 'ujjwal@example.com', '2025-10-26 10:52:50'),
(727, 'vaishnavi@example.com', '2025-10-26 10:58:13'),
(728, 'wasim@example.com', '2025-10-26 11:03:37'),
(729, 'xena@example.com', '2025-10-26 11:09:01'),
(730, 'yogeshwari@example.com', '2025-10-26 11:14:24'),
(731, 'zara@example.com', '2025-10-26 11:19:48'),
(732, 'aaryan@example.com', '2025-10-26 11:25:12'),
(733, 'bhupendra@example.com', '2025-10-26 11:30:35'),
(734, 'charvi@example.com', '2025-10-26 11:35:59'),
(735, 'devika@example.com', '2025-10-26 11:41:23'),
(736, 'eshaan@example.com', '2025-10-26 11:46:46'),
(737, 'fatima3@example.com', '2025-10-26 11:52:10'),
(738, 'gautam@example.com', '2025-10-26 11:57:34'),
(739, 'harini2@example.com', '2025-10-26 12:02:58'),
(740, 'ishani@example.com', '2025-10-26 12:08:21'),
(741, 'jasmin@example.com', '2025-10-26 12:13:45'),
(742, 'kabir@example.com', '2025-10-26 12:19:09'),
(743, 'laxman@example.com', '2025-10-26 12:24:32'),
(744, 'mitali@example.com', '2025-10-26 12:29:56'),
(745, 'nikita@example.com', '2025-10-26 12:35:20'),
(746, 'omprakash@example.com', '2025-10-26 12:40:43'),
(747, 'pankaj@example.com', '2025-10-26 12:46:07'),
(748, 'qasim2@example.com', '2025-10-26 12:51:31'),
(749, 'rekha@example.com', '2025-10-26 12:56:55'),
(750, 'samar@example.com', '2025-10-26 13:02:18'),
(751, 'tanisha@example.com', '2025-10-26 13:07:42'),
(752, 'umesh@example.com', '2025-10-26 13:13:06'),
(753, 'vinod@example.com', '2025-10-26 13:18:29'),
(754, 'wasima@example.com', '2025-10-26 13:23:53'),
(755, 'ximon2@example.com', '2025-10-26 13:29:17'),
(756, 'yasmeen3@example.com', '2025-10-26 13:34:40'),
(757, 'zulfia@example.com', '2025-10-26 13:40:04'),
(758, 'aditya@example.com', '2025-10-26 13:45:28'),
(759, 'bhavneet@example.com', '2025-10-26 13:50:51'),
(760, 'chintan@example.com', '2025-10-26 13:56:15'),
(761, 'divya@example.com', '2025-10-26 14:01:39'),
(762, 'ekta3@example.com', '2025-10-26 14:07:03'),
(763, 'farid@example.com', '2025-10-26 14:12:26'),
(764, 'gauri2@example.com', '2025-10-26 14:17:50'),
(765, 'himanshu@example.com', '2025-10-26 14:23:14'),
(766, 'inder@example.com', '2025-10-26 14:28:37'),
(767, 'jagriti@example.com', '2025-10-26 14:34:01'),
(768, 'kavita@example.com', '2025-10-26 14:39:25'),
(769, 'laksh@example.com', '2025-10-26 14:44:48'),
(770, 'mehul@example.com', '2025-10-26 14:50:12'),
(771, 'neha3@example.com', '2025-10-26 14:55:36'),
(772, 'omkar6@example.com', '2025-10-26 15:00:59'),
(773, 'prateek@example.com', '2025-10-26 15:06:23'),
(774, 'quinn@example.com', '2025-10-26 15:11:47'),
(775, 'riya4@example.com', '2025-10-26 15:17:10'),
(776, 'sujata@example.com', '2025-10-26 15:22:34'),
(777, 'tapan@example.com', '2025-10-26 15:27:58'),
(778, 'umra@example.com', '2025-10-26 15:33:21'),
(779, 'vimal@example.com', '2025-10-26 15:38:45'),
(780, 'wasim2@example.com', '2025-10-26 15:44:09'),
(781, 'xia2@example.com', '2025-10-26 15:49:33'),
(782, 'yuvraj@example.com', '2025-10-26 15:54:56'),
(783, 'zaira@example.com', '2025-10-26 16:00:20'),
(784, 'abhishek@example.com', '2025-10-26 16:05:44'),
(785, 'brinda@example.com', '2025-10-26 16:11:07'),
(786, 'chetali@example.com', '2025-10-26 16:16:31'),
(787, 'darshan@example.com', '2025-10-26 16:21:55'),
(788, 'esha4@example.com', '2025-10-26 16:27:18'),
(789, 'falguni@example.com', '2025-10-26 16:32:42'),
(790, 'gokul2@example.com', '2025-10-26 16:38:06'),
(791, 'hema3@example.com', '2025-10-26 16:43:29'),
(792, 'inderjeet@example.com', '2025-10-26 16:48:53'),
(793, 'jatin2@example.com', '2025-10-26 16:54:17'),
(794, 'karan3@example.com', '2025-10-26 16:59:40'),
(795, 'leena@example.com', '2025-10-26 17:05:04'),
(796, 'manju@example.com', '2025-10-26 17:10:28'),
(797, 'naman@example.com', '2025-10-26 17:15:51'),
(798, 'opal@example.com', '2025-10-26 17:21:15'),
(799, 'parveen@example.com', '2025-10-26 17:26:39'),
(800, 'quadir@example.com', '2025-10-26 17:32:02'),
(801, 'ruchi@example.com', '2025-10-26 17:37:26'),
(802, 'sarthak@example.com', '2025-10-26 17:42:50'),
(803, 'tanveer@example.com', '2025-10-26 17:48:13'),
(804, 'urmi2@example.com', '2025-10-26 17:53:37'),
(805, 'vivek3@example.com', '2025-10-26 17:59:01'),
(806, 'waseema@example.com', '2025-10-26 18:04:24'),
(807, 'xian@example.com', '2025-10-26 18:09:48'),
(808, 'yograj@example.com', '2025-10-26 18:15:12'),
(809, 'zayra@example.com', '2025-10-26 18:20:36'),
(810, 'aadarsh@example.com', '2025-10-26 18:25:59'),
(811, 'bhavana2@example.com', '2025-10-26 18:31:23'),
(812, 'charmi@example.com', '2025-10-26 18:36:47'),
(813, 'devansh@example.com', '2025-10-26 18:42:10'),
(814, 'ekta4@example.com', '2025-10-26 18:47:34'),
(815, 'farha2@example.com', '2025-10-26 18:52:58'),
(816, 'gauransh@example.com', '2025-10-26 18:58:21'),
(817, 'harpreet2@example.com', '2025-10-26 19:03:45'),
(818, 'ishant@example.com', '2025-10-26 19:09:09'),
(819, 'jaya4@example.com', '2025-10-26 19:14:32'),
(820, 'khushi@example.com', '2025-10-26 19:19:56'),
(821, 'lalita@example.com', '2025-10-26 19:25:20'),
(822, 'mukta@example.com', '2025-10-26 19:30:44'),
(823, 'nikhil2@example.com', '2025-10-26 19:36:07'),
(824, 'omisha2@example.com', '2025-10-26 19:41:31'),
(825, 'pranay2@example.com', '2025-10-26 19:46:55'),
(826, 'quamar@example.com', '2025-10-26 19:52:18'),
(827, 'ravi@example.com', '2025-10-26 19:57:42'),
(828, 'shruti@example.com', '2025-10-26 20:03:06'),
(829, 'tahir2@example.com', '2025-10-26 20:08:29'),
(830, 'umang@example.com', '2025-10-26 20:13:53'),
(831, 'vishnu@example.com', '2025-10-26 20:19:17'),
(832, 'waheeda@example.com', '2025-10-26 20:24:40'),
(833, 'ximona2@example.com', '2025-10-26 20:30:04'),
(834, 'yaseen@example.com', '2025-10-26 20:35:28'),
(835, 'zainab@example.com', '2025-10-26 20:40:51'),
(836, 'ajay@example.com', '2025-10-26 20:46:15'),
(837, 'bina@example.com', '2025-10-26 20:51:39'),
(838, 'chiranjeevi@example.com', '2025-10-26 20:57:02'),
(839, 'deepika@example.com', '2025-10-26 21:02:26'),
(840, 'eshaan2@example.com', '2025-10-26 21:07:50'),
(841, 'fahim2@example.com', '2025-10-26 21:13:13'),
(842, 'gayatri@example.com', '2025-10-26 21:18:37'),
(843, 'hari@example.com', '2025-10-26 21:24:01'),
(844, 'indu@example.com', '2025-10-26 21:29:24'),
(845, 'joginder@example.com', '2025-10-26 21:34:48'),
(846, 'kanishk@example.com', '2025-10-26 21:40:12'),
(847, 'lavleen@example.com', '2025-10-26 21:45:36'),
(848, 'meera3@example.com', '2025-10-26 21:50:59'),
(849, 'nidhi3@example.com', '2025-10-26 21:56:23'),
(850, 'omkar7@example.com', '2025-10-26 22:01:47'),
(851, 'priya4@example.com', '2025-10-26 22:07:10'),
(852, 'qadir2@example.com', '2025-10-26 22:12:34'),
(853, 'rakesh@example.com', '2025-10-26 22:17:58'),
(854, 'shravan@example.com', '2025-10-26 22:23:21'),
(855, 'tina2@example.com', '2025-10-26 22:28:45'),
(856, 'ujala@example.com', '2025-10-26 22:34:09'),
(857, 'vaibhav@example.com', '2025-10-26 22:39:32'),
(858, 'wajid2@example.com', '2025-10-26 22:44:56'),
(859, 'ximena5@example.com', '2025-10-26 22:50:20'),
(860, 'yogendra@example.com', '2025-10-26 22:55:43'),
(861, 'zara2@example.com', '2025-10-26 23:01:07'),
(862, 'abha@example.com', '2025-10-26 23:06:31'),
(863, 'bhushan@example.com', '2025-10-26 23:11:54'),
(864, 'chanda@example.com', '2025-10-26 23:17:18'),
(865, 'dilip@example.com', '2025-10-26 23:22:42'),
(866, 'esha5@example.com', '2025-10-26 23:27:59'),
(867, 'firoza2@example.com', '2025-10-26 23:33:25'),
(868, 'girish3@example.com', '2025-10-26 23:38:48'),
(869, 'hemant@example.com', '2025-10-26 23:44:12'),
(870, 'ishwar2@example.com', '2025-10-26 23:49:36'),
(871, 'jaya5@example.com', '2025-10-26 23:54:59'),
(872, 'krishna@example.com', '2025-10-27 00:00:23'),
(873, 'lalit2@example.com', '2025-10-27 00:05:47'),
(874, 'manoj2@example.com', '2025-10-27 00:11:10'),
(875, 'nirmala2@example.com', '2025-10-27 00:16:34'),
(876, 'omkar8@example.com', '2025-10-27 00:21:58'),
(877, 'pooja2@example.com', '2025-10-27 00:27:21'),
(878, 'quadir3@example.com', '2025-10-27 00:32:45'),
(879, 'ratan@example.com', '2025-10-27 00:38:09'),
(880, 'sunita@example.com', '2025-10-27 00:43:32'),
(881, 'tushar2@example.com', '2025-10-27 00:48:56'),
(882, 'usha2@example.com', '2025-10-27 00:54:20'),
(883, 'vikram@example.com', '2025-10-27 00:59:43'),
(884, 'wahid@example.com', '2025-10-27 01:05:07'),
(885, 'xia3@example.com', '2025-10-27 01:10:31'),
(886, 'yuvika2@example.com', '2025-10-27 01:15:54'),
(887, 'zainul@example.com', '2025-10-27 01:21:18'),
(888, 'aman@example.com', '2025-10-27 01:26:42'),
(889, 'bhagyashree@example.com', '2025-10-27 01:32:05'),
(890, 'chanchal2@example.com', '2025-10-27 01:37:29'),
(891, 'deepak@example.com', '2025-10-27 01:42:53'),
(892, 'ekansha@example.com', '2025-10-27 01:48:16'),
(893, 'farhana@example.com', '2025-10-27 01:53:40'),
(894, 'gautami@example.com', '2025-10-27 01:59:04'),
(895, 'harini3@example.com', '2025-10-27 02:04:27'),
(896, 'isha5@example.com', '2025-10-27 02:09:51'),
(897, 'joseph@example.com', '2025-10-27 02:15:15'),
(898, 'kanishka@example.com', '2025-10-27 02:20:38'),
(899, 'lalima@example.com', '2025-10-27 02:26:02'),
(900, 'megha@example.com', '2025-10-27 02:31:26'),
(901, 'naina2@example.com', '2025-10-27 02:36:49'),
(902, 'omika2@example.com', '2025-10-27 02:42:13'),
(903, 'pratap@example.com', '2025-10-27 02:47:37'),
(904, 'qais2@example.com', '2025-10-27 02:53:00'),
(905, 'richa@example.com', '2025-10-27 02:58:24'),
(906, 'santosh@example.com', '2025-10-27 03:03:48'),
(907, 'tanu2@example.com', '2025-10-27 03:09:11'),
(908, 'uma3@example.com', '2025-10-27 03:14:35'),
(909, 'vaidehi2@example.com', '2025-10-27 03:19:59'),
(910, 'wasim3@example.com', '2025-10-27 03:25:22'),
(911, 'xavier@example.com', '2025-10-27 03:30:46'),
(912, 'yash4@example.com', '2025-10-27 03:36:10'),
(913, 'zoya5@example.com', '2025-10-27 03:41:33'),
(914, 'aakansha@example.com', '2025-10-27 03:46:57'),
(915, 'bhupali@example.com', '2025-10-27 03:52:21'),
(916, 'chintu@example.com', '2025-10-27 03:57:44'),
(917, 'diksha@example.com', '2025-10-27 04:03:08'),
(918, 'esha6@example.com', '2025-10-27 04:08:32'),
(919, 'firoz2@example.com', '2025-10-27 04:13:55'),
(920, 'gagan2@example.com', '2025-10-27 04:19:19'),
(921, 'hitesh@example.com', '2025-10-27 04:24:43'),
(922, 'indra2@example.com', '2025-10-27 04:30:06'),
(923, 'jayant@example.com', '2025-10-27 04:35:30'),
(924, 'karuna@example.com', '2025-10-27 04:40:54'),
(925, 'lavina2@example.com', '2025-10-27 04:46:17'),
(926, 'manish@example.com', '2025-10-27 04:51:41'),
(927, 'nehal@example.com', '2025-10-27 04:57:05'),
(928, 'omkar9@example.com', '2025-10-27 05:02:28'),
(929, 'priya5@example.com', '2025-10-27 05:07:52'),
(930, 'quamar2@example.com', '2025-10-27 05:13:16'),
(931, 'rahim@example.com', '2025-10-27 05:18:39'),
(932, 'soumya@example.com', '2025-10-27 05:24:03'),
(933, 'tushar3@example.com', '2025-10-27 05:29:27'),
(934, 'urvashi2@example.com', '2025-10-27 05:34:50'),
(935, 'vinita@example.com', '2025-10-27 05:40:14'),
(936, 'wasif@example.com', '2025-10-27 05:45:38'),
(937, 'xander4@example.com', '2025-10-27 05:50:59'),
(938, 'yogendra2@example.com', '2025-10-27 05:56:23'),
(939, 'zain6@example.com', '2025-10-27 06:01:47'),
(940, 'aayushi@example.com', '2025-10-27 06:07:11'),
(941, 'bhoomi3@example.com', '2025-10-27 06:12:34'),
(942, 'chirag@example.com', '2025-10-27 06:17:58'),
(943, 'devanshi2@example.com', '2025-10-27 06:23:22'),
(944, 'ekta5@example.com', '2025-10-27 06:28:45'),
(945, 'fahad2@example.com', '2025-10-27 06:34:09'),
(946, 'gauri3@example.com', '2025-10-27 06:39:33'),
(947, 'harshil@example.com', '2025-10-27 06:44:56'),
(948, 'ishaan@example.com', '2025-10-27 06:50:20'),
(949, 'jigna@example.com', '2025-10-27 06:55:44'),
(950, 'kamal@example.com', '2025-10-27 07:01:07'),
(951, 'leela2@example.com', '2025-10-27 07:06:31'),
(952, 'manu@example.com', '2025-10-27 07:11:55'),
(953, 'nirmal@example.com', '2025-10-27 07:17:18'),
(954, 'omika3@example.com', '2025-10-27 07:22:42'),
(955, 'pranay3@example.com', '2025-10-27 07:28:06'),
(956, 'qadir4@example.com', '2025-10-27 07:33:29'),
(957, 'richa2@example.com', '2025-10-27 07:38:53'),
(958, 'sumit@example.com', '2025-10-27 07:44:17'),
(959, 'tanya2@example.com', '2025-10-27 07:49:40'),
(960, 'umra2@example.com', '2025-10-27 07:55:04'),
(961, 'vimal2@example.com', '2025-10-27 08:00:28'),
(962, 'wahida2@example.com', '2025-10-27 08:05:51'),
(963, 'xenia3@example.com', '2025-10-27 08:11:15'),
(964, 'yashoda2@example.com', '2025-10-27 08:16:39'),
(965, 'zain7@example.com', '2025-10-27 08:22:02'),
(966, 'arun@example.com', '2025-10-27 08:27:26'),
(967, 'bindiya@example.com', '2025-10-27 08:32:50'),
(968, 'chetan3@example.com', '2025-10-27 08:38:13'),
(969, 'deepa2@example.com', '2025-10-27 08:43:37'),
(970, 'eshan@example.com', '2025-10-27 08:49:01'),
(971, 'fatima4@example.com', '2025-10-27 08:54:24'),
(972, 'ganesh2@example.com', '2025-10-27 08:59:48'),
(973, 'hema4@example.com', '2025-10-27 09:05:12'),
(974, 'indrajeet2@example.com', '2025-10-27 09:10:35'),
(975, 'jayanthi@example.com', '2025-10-27 09:15:59'),
(976, 'krish@example.com', '2025-10-27 09:21:23'),
(977, 'lata2@example.com', '2025-10-27 09:26:46'),
(978, 'meera4@example.com', '2025-10-27 09:32:10'),
(979, 'neeta@example.com', '2025-10-27 09:37:34'),
(980, 'omkar10@example.com', '2025-10-27 09:42:57'),
(981, 'pradeep2@example.com', '2025-10-27 09:48:21'),
(982, 'qureshi2@example.com', '2025-10-27 09:53:45'),
(983, 'rajat@example.com', '2025-10-27 09:59:08'),
(984, 'shruti2@example.com', '2025-10-27 10:04:32'),
(985, 'tarun2@example.com', '2025-10-27 10:09:56'),
(986, 'ujjwala@example.com', '2025-10-27 10:15:19'),
(987, 'vanshika2@example.com', '2025-10-27 10:20:43'),
(988, 'wasim4@example.com', '2025-10-27 10:26:07'),
(989, 'xander5@example.com', '2025-10-27 10:31:30'),
(990, 'yuvraj2@example.com', '2025-10-27 10:36:54'),
(991, 'zara3@example.com', '2025-10-27 10:42:18'),
(992, 'abhinav@example.com', '2025-10-27 10:47:41'),
(993, 'bhavika2@example.com', '2025-10-27 10:53:05'),
(994, 'chaitra@example.com', '2025-10-27 10:58:29'),
(995, 'dinesh3@example.com', '2025-10-27 11:03:52'),
(996, 'ekta6@example.com', '2025-10-27 11:09:16'),
(997, 'farid@example.com', '2025-10-27 11:14:40'),
(998, 'gautam2@example.com', '2025-10-27 11:20:03'),
(999, 'hemlata@example.com', '2025-10-27 11:25:27'),
(1000, 'ishika2@example.com', '2025-10-27 11:30:51'),
(1001, 'jayesh2@example.com', '2025-10-27 11:36:14'),
(1002, 'kanika2@example.com', '2025-10-27 11:41:38');
INSERT INTO `subscriber` (`subscriber_id`, `subscriber_email`, `subscriber_date`) VALUES
(1003, 'lalita3@example.com', '2025-10-27 11:47:02'),
(1004, 'manoj3@example.com', '2025-10-27 11:52:25'),
(1005, 'neha3@example.com', '2025-10-27 11:57:49'),
(1006, 'omkar11@example.com', '2025-10-27 12:03:13'),
(1007, 'praveen3@example.com', '2025-10-27 12:08:36'),
(1008, 'qamar3@example.com', '2025-10-27 12:14:00'),
(1009, 'rekha3@example.com', '2025-10-27 12:19:24'),
(1010, 'suresh3@example.com', '2025-10-27 12:24:47'),
(1011, 'tanya3@example.com', '2025-10-27 12:30:11'),
(1012, 'ujwal@example.com', '2025-10-27 12:35:35'),
(1013, 'vaibhav3@example.com', '2025-10-27 12:40:58'),
(1014, 'wasim5@example.com', '2025-10-27 12:46:22'),
(1015, 'xena3@example.com', '2025-10-27 12:51:46'),
(1016, 'yogita3@example.com', '2025-10-27 12:57:09'),
(1017, 'zoya6@example.com', '2025-10-27 13:02:33'),
(1018, 'anaya2@example.com', '2025-10-27 13:07:57'),
(1019, 'bhuvan@example.com', '2025-10-27 13:13:20'),
(1020, 'chitra@example.com', '2025-10-27 13:18:44'),
(1021, 'deepika2@example.com', '2025-10-27 13:24:08'),
(1022, 'ekansh@example.com', '2025-10-27 13:29:31'),
(1023, 'farheen@example.com', '2025-10-27 13:34:55'),
(1024, 'girish4@example.com', '2025-10-27 13:40:19'),
(1025, 'harsha3@example.com', '2025-10-27 13:45:42'),
(1026, 'isha6@example.com', '2025-10-27 13:51:06'),
(1027, 'jay3@example.com', '2025-10-27 13:56:30'),
(1028, 'kruti@example.com', '2025-10-27 14:01:53'),
(1029, 'lavanya2@example.com', '2025-10-27 14:07:17'),
(1030, 'mitali@example.com', '2025-10-27 14:12:41'),
(1031, 'nayan@example.com', '2025-10-27 14:18:04'),
(1032, 'omika4@example.com', '2025-10-27 14:23:28'),
(1033, 'pankaj3@example.com', '2025-10-27 14:28:52'),
(1034, 'qasim3@example.com', '2025-10-27 14:34:15'),
(1035, 'ritu3@example.com', '2025-10-27 14:39:39'),
(1036, 'sandeep3@example.com', '2025-10-27 14:45:03'),
(1037, 'tanvi3@example.com', '2025-10-27 14:50:26'),
(1038, 'uma4@example.com', '2025-10-27 14:55:50'),
(1039, 'vipin3@example.com', '2025-10-27 15:01:14'),
(1040, 'wasim6@example.com', '2025-10-27 15:06:37'),
(1041, 'xander6@example.com', '2025-10-27 15:12:01'),
(1042, 'yash5@example.com', '2025-10-27 15:17:25'),
(1043, 'zain8@example.com', '2025-10-27 15:22:48'),
(1044, 'aditi@example.com', '2025-10-27 15:28:12'),
(1045, 'bhavana@example.com', '2025-10-27 15:33:36'),
(1046, 'chetna2@example.com', '2025-10-27 15:38:59'),
(1047, 'devika@example.com', '2025-10-27 15:44:23'),
(1048, 'ekta7@example.com', '2025-10-27 15:49:47'),
(1049, 'faiz3@example.com', '2025-10-27 15:55:10'),
(1050, 'gargi@example.com', '2025-10-27 16:00:34'),
(1051, 'harshal@example.com', '2025-10-27 16:05:58'),
(1052, 'isha7@example.com', '2025-10-27 16:11:21'),
(1053, 'janhvi@example.com', '2025-10-27 16:16:45'),
(1054, 'kabir2@example.com', '2025-10-27 16:22:09'),
(1055, 'laxmi2@example.com', '2025-10-27 16:27:32'),
(1056, 'manav2@example.com', '2025-10-27 16:32:56'),
(1057, 'nidhi3@example.com', '2025-10-27 16:38:20'),
(1058, 'omkar12@example.com', '2025-10-27 16:43:43'),
(1059, 'prisha3@example.com', '2025-10-27 16:49:07'),
(1060, 'quamar3@example.com', '2025-10-27 16:54:31'),
(1061, 'ramesh3@example.com', '2025-10-27 16:59:54'),
(1062, 'suhana@example.com', '2025-10-27 17:05:18'),
(1063, 'tarun3@example.com', '2025-10-27 17:10:42'),
(1064, 'urmi3@example.com', '2025-10-27 17:15:58'),
(1065, 'vaidehi3@example.com', '2025-10-27 17:21:21'),
(1066, 'wasim7@example.com', '2025-10-27 17:26:45'),
(1067, 'xavier2@example.com', '2025-10-27 17:32:09'),
(1068, 'yogesh2@example.com', '2025-10-27 17:37:32'),
(1069, 'zara4@example.com', '2025-10-27 17:42:56'),
(1070, 'anirudh@example.com', '2025-10-27 17:48:20'),
(1071, 'bhavya@example.com', '2025-10-27 17:53:43'),
(1072, 'charu@example.com', '2025-10-27 17:59:07'),
(1073, 'devansh2@example.com', '2025-10-27 18:04:31'),
(1074, 'esha7@example.com', '2025-10-27 18:09:54'),
(1075, 'fiza2@example.com', '2025-10-27 18:15:18'),
(1076, 'gaurav3@example.com', '2025-10-27 18:20:42'),
(1077, 'harshit@example.com', '2025-10-27 18:26:05'),
(1078, 'isha8@example.com', '2025-10-27 18:31:29'),
(1079, 'jaya6@example.com', '2025-10-27 18:36:53'),
(1080, 'kamini2@example.com', '2025-10-27 18:42:16'),
(1081, 'lucky@example.com', '2025-10-27 18:47:40'),
(1082, 'mohit2@example.com', '2025-10-27 18:53:04'),
(1083, 'nisha2@example.com', '2025-10-27 18:58:27'),
(1084, 'omkar13@example.com', '2025-10-27 19:03:51'),
(1085, 'pratik2@example.com', '2025-10-27 19:09:15'),
(1086, 'qureshi3@example.com', '2025-10-27 19:14:38'),
(1087, 'rekha4@example.com', '2025-10-27 19:20:02'),
(1088, 'sneha4@example.com', '2025-10-27 19:25:26'),
(1089, 'tanu4@example.com', '2025-10-27 19:30:49'),
(1090, 'urvashi3@example.com', '2025-10-27 19:36:13'),
(1091, 'vinit3@example.com', '2025-10-27 19:41:37'),
(1092, 'wahida3@example.com', '2025-10-27 19:47:00'),
(1093, 'xander7@example.com', '2025-10-27 19:52:24'),
(1094, 'yuvika3@example.com', '2025-10-27 19:57:48'),
(1095, 'zain9@example.com', '2025-10-27 20:03:11'),
(1096, 'abhay@example.com', '2025-10-27 20:08:35'),
(1097, 'bina@example.com', '2025-10-27 20:13:59'),
(1098, 'chetan4@example.com', '2025-10-27 20:19:22'),
(1099, 'divya2@example.com', '2025-10-27 20:24:46'),
(1100, 'esha8@example.com', '2025-10-27 20:30:10'),
(1101, 'amisha@example.com', '2025-10-27 20:35:33'),
(1102, 'bhavesh@example.com', '2025-10-27 20:40:57'),
(1103, 'chandni@example.com', '2025-10-27 20:46:21'),
(1104, 'daksh@example.com', '2025-10-27 20:51:44'),
(1105, 'ekta8@example.com', '2025-10-27 20:57:08'),
(1106, 'farhan@example.com', '2025-10-27 21:02:32'),
(1107, 'gauri4@example.com', '2025-10-27 21:07:55'),
(1108, 'harshal2@example.com', '2025-10-27 21:13:19'),
(1109, 'isha9@example.com', '2025-10-27 21:18:43'),
(1110, 'jignesh@example.com', '2025-10-27 21:24:06'),
(1111, 'kritika@example.com', '2025-10-27 21:29:30'),
(1112, 'lalita4@example.com', '2025-10-27 21:34:54'),
(1113, 'manish2@example.com', '2025-10-27 21:40:17'),
(1114, 'neelam2@example.com', '2025-10-27 21:45:41'),
(1115, 'omkar14@example.com', '2025-10-27 21:51:05'),
(1116, 'pranav2@example.com', '2025-10-27 21:56:28'),
(1117, 'qasim4@example.com', '2025-10-27 22:01:52'),
(1118, 'radhika2@example.com', '2025-10-27 22:07:16'),
(1119, 'siddharth@example.com', '2025-10-27 22:12:39'),
(1120, 'tulika@example.com', '2025-10-27 22:18:03'),
(1121, 'umesh@example.com', '2025-10-27 22:23:27'),
(1122, 'vaibhavi@example.com', '2025-10-27 22:28:50'),
(1123, 'wasim8@example.com', '2025-10-27 22:34:14'),
(1124, 'xena4@example.com', '2025-10-27 22:39:38'),
(1125, 'yogendra3@example.com', '0000-00-00 00:00:00'),
(1126, 'zara5@example.com', '2025-10-27 22:50:25'),
(1127, 'abhilash@example.com', '2025-10-27 22:55:48'),
(1128, 'bhumika@example.com', '2025-10-27 23:01:12'),
(1129, 'chitra2@example.com', '2025-10-27 23:06:36'),
(1130, 'devesh@example.com', '2025-10-27 23:11:59'),
(1131, 'esha9@example.com', '2025-10-27 23:17:23'),
(1132, 'faizan@example.com', '2025-10-27 23:22:47'),
(1133, 'garima2@example.com', '2025-10-27 23:28:10'),
(1134, 'harish@example.com', '2025-10-27 23:33:34'),
(1135, 'ishita@example.com', '2025-10-27 23:38:58'),
(1136, 'jay4@example.com', '2025-10-27 23:44:21'),
(1137, 'krunal@example.com', '2025-10-27 23:49:45'),
(1138, 'latika@example.com', '2025-10-27 23:55:09'),
(1139, 'mayur2@example.com', '2025-10-28 00:00:32'),
(1140, 'nikita3@example.com', '2025-10-28 00:05:56'),
(1141, 'omkar15@example.com', '2025-10-28 00:11:20'),
(1142, 'priya6@example.com', '2025-10-28 00:16:43'),
(1143, 'qadir5@example.com', '2025-10-28 00:22:07'),
(1144, 'raunak@example.com', '2025-10-28 00:27:31'),
(1145, 'sakshi2@example.com', '2025-10-28 00:32:54'),
(1146, 'tanu5@example.com', '2025-10-28 00:38:18'),
(1147, 'umra3@example.com', '2025-10-28 00:43:42'),
(1148, 'vijay3@example.com', '0000-00-00 00:00:00'),
(1149, 'wasim9@example.com', '2025-10-28 00:54:29'),
(1150, 'xander8@example.com', '2025-10-28 00:59:53'),
(1151, 'yuvraj3@example.com', '2025-10-28 01:05:16'),
(1152, 'zain10@example.com', '2025-10-28 01:10:40'),
(1153, 'aashi@example.com', '2025-10-28 01:16:04'),
(1154, 'bhavik@example.com', '2025-10-28 01:21:27'),
(1155, 'chandrika@example.com', '2025-10-28 01:26:51'),
(1156, 'dilip2@example.com', '2025-10-28 01:32:15'),
(1157, 'ekta9@example.com', '2025-10-28 01:37:38'),
(1158, 'farheen2@example.com', '2025-10-28 01:43:02'),
(1159, 'gagan3@example.com', '2025-10-28 01:48:26'),
(1160, 'himani@example.com', '2025-10-28 01:53:49'),
(1161, 'ishaan2@example.com', '2025-10-28 01:59:13'),
(1162, 'jahnavi@example.com', '2025-10-28 02:04:37'),
(1163, 'kabir3@example.com', '0000-00-00 00:00:00'),
(1164, 'leena2@example.com', '2025-10-28 02:15:24'),
(1165, 'manasi@example.com', '2025-10-28 02:20:48'),
(1166, 'nivedita@example.com', '2025-10-28 02:26:11'),
(1167, 'omkar16@example.com', '2025-10-28 02:31:35'),
(1168, 'pratap2@example.com', '2025-10-28 02:36:59'),
(1169, 'qadir6@example.com', '2025-10-28 02:42:22'),
(1170, 'riya3@example.com', '2025-10-28 02:47:46'),
(1171, 'sourabh@example.com', '2025-10-28 02:53:10'),
(1172, 'tanuja@example.com', '2025-10-28 02:58:33'),
(1173, 'urvashi4@example.com', '2025-10-28 03:03:57'),
(1174, 'vimal3@example.com', '2025-10-28 03:09:21'),
(1175, 'wasim10@example.com', '2025-10-28 03:14:44'),
(1176, 'xena5@example.com', '2025-10-28 03:20:08'),
(1177, 'yash6@example.com', '2025-10-28 03:25:32'),
(1178, 'zoya7@example.com', '2025-10-28 03:30:55'),
(1179, 'amit3@example.com', '2025-10-28 03:36:19'),
(1180, 'bhavna2@example.com', '2025-10-28 03:41:43'),
(1181, 'chetan5@example.com', '2025-10-28 03:47:06'),
(1182, 'dipali@example.com', '2025-10-28 03:52:30'),
(1183, 'esha10@example.com', '2025-10-28 03:57:54'),
(1184, 'farhan2@example.com', '2025-10-28 04:03:17'),
(1185, 'gopal@example.com', '2025-10-28 04:08:41'),
(1186, 'hitesh2@example.com', '2025-10-28 04:14:05'),
(1187, 'isha10@example.com', '2025-10-28 04:19:28'),
(1188, 'jay5@example.com', '2025-10-28 04:24:52'),
(1189, 'kiran@example.com', '2025-10-28 04:30:16'),
(1190, 'lakshmi@example.com', '2025-10-28 04:35:39'),
(1191, 'meena@example.com', '2025-10-28 04:41:03'),
(1192, 'nilesh@example.com', '2025-10-28 04:46:27'),
(1193, 'omkar17@example.com', '2025-10-28 04:51:50'),
(1194, 'priya7@example.com', '2025-10-28 04:57:14'),
(1195, 'qamar4@example.com', '2025-10-28 05:02:38'),
(1196, 'raj2@example.com', '0000-00-00 00:00:00'),
(1197, 'sita@example.com', '2025-10-28 05:13:25'),
(1198, 'tushar4@example.com', '2025-10-28 05:18:49'),
(1199, 'urmi4@example.com', '2025-10-28 05:24:12'),
(1200, 'vaidehi4@example.com', '2025-10-28 05:29:36');

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
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT 'active = 1, \r\ninactive = 2',
  `country` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip_city2` varchar(50) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_expires` varchar(100) DEFAULT NULL,
  `is_used` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `username`, `email`, `password`, `phone`, `address`, `city`, `image`, `gender`, `status`, `country`, `state`, `zip_city2`, `reset_token`, `reset_expires`, `is_used`) VALUES
(1, 'hiten', 'hiten@gmail.com', '$2y$10$ZUA/3jx2MScfwqtYNthgCeDP7kh7LKOLDJqjPB', '9898989898', 'add', 'surat', NULL, '1', '2', NULL, NULL, NULL, NULL, '2025-11-07 18:36:16', '1'),
(2, 'om', 'om@gmail.com', '$2y$10$azeyEt45SovTnV8hisMxdeNfOdar7hwuw2nCLb', '7894859475', NULL, 'bharuch', NULL, '1', '2', NULL, NULL, NULL, NULL, '2025-11-07 18:36:16', '1'),
(3, 'prince', 'prince@gmail.com', '$2y$10$.QCLcK9mNYlQrptKR6R8Lus.KGAxWbD/WFfu7k', '7096761516', NULL, 'amreli', NULL, '1', '1', NULL, NULL, NULL, NULL, '2025-11-07 18:36:16', '1'),
(4, 'admin', 'admin@gmail.com', '$2y$10$0Jg5MUd92.NXOvFsln8cdu/UAxDE1PmMILmA5w', '9638527415', NULL, 'rajakot', NULL, '2', '1', NULL, NULL, NULL, NULL, '2025-11-07 18:36:16', '1'),
(5, 'anil', 'anil@gmail.com', '$2y$10$PIAUkD3hjhXLPoc9lBCBleLWBNDGVQbbpAUZaN2klpxxGd.v3838C', '9879879872', NULL, 'surat', NULL, '1', '1', NULL, NULL, NULL, NULL, '2025-11-07 18:36:16', '1'),
(7, 'dixitpatel', 'dixitpatel@gmail.com', '$2y$10$a0XpIEU3korUVQ3U86n5A..A4GW0orTGRzt/UFevoq2lgE7LlAfX.', '9876543210', '106, Bapunagar, India Colony, Ahmedabad..', 'surat', 'dixitpatel_1762856047.jpg', '1', '1', 'India', 'Gujarat', 'Surat - 395003', NULL, '2025-11-07 18:36:16', '1'),
(8, 'vardhit', 'vamjavardhit461@gmail.com', '$2y$10$X6ESH9MDbF8pWEbm9vhsm.H18RQQ7KkhmOJnm8Jz2vIaFNxbGZDlW', '9876543210', '1021, raj mall, jaipur, rajesthan', 'Ahmedabad', 'vardhit_1762855113.jpg', '1', '1', 'India', 'Rajasthan', 'Jaipur - 302001', NULL, NULL, '1'),
(9, 'prince123', 'prince123@gmail.com', '$2y$10$7vsf.dmO2lLUskgcNWjpg.VggGiwqKfEkLGPmAWrux5ZaHnGczi5a', '', 'Mumbai', '', NULL, '', '1', 'India', 'Maharashtra', 'Mumbai - 400001', NULL, '2025-11-07 18:36:16', '1'),
(10, 'dhruv321', 'dhruv321@gmail.com', '$2y$10$GLkGP8f2XraRWU9E.x1WU.sbXMXQCbc6eH3h224jJj0vqFl.yVh2S', '9512128080', 'sadar chowk, jetpur.', 'surat', NULL, '1', '1', 'India', 'Gujarat', 'Surat - 395003', NULL, '2025-11-07 18:36:16', '1'),
(12, 'pateldix', 'pateldix@gmail.com', '$2y$10$7kiih7PgCM3zmi68q7.LVOGY6WjoShfHz97IAjd/uPmMh1u6OUs0O', '9876543210', 'Mota varachha, surat.', 'gandhinagar', NULL, '2', '1', 'India', 'Gujarat', 'Surat - 395003', NULL, '2025-11-07 18:36:16', '1'),
(13, 'abc', 'abc@gmail.com', '$2y$10$yu5/obd1ogq2Yf3VQrvaP.wLA7c.XXTjvRud2c/kZXwTvTg6BjIii', '9513578524', NULL, 'bharuch', NULL, '2', '1', NULL, NULL, NULL, NULL, '2025-11-07 18:36:16', '1'),
(16, 'dev', 'dev@gmail.com', '$2y$10$hPOQSvgt0R4KoRM5U4GhFOBQNJkcc1v5EO/stAlQRc5.aUpRVt2fi', '9876543210', 'India gat, Taj Hotel, mumbai..', '', NULL, '', '1', 'India', 'Maharashtra', 'Nashik - 422001', NULL, '2025-11-07 18:36:16', '1'),
(17, 'kishan', 'kishan@gmail.com', '$2y$10$vN9AF1oBXWr0l1kO97qN/OLDClQdqyM6rUjLn2n2RR3jmfemGfnQ6', '9409601795', '404, varni, pasodra gam,kamrej, surat.', 'surat', NULL, '1', '1', 'India', 'Maharashtra', 'Nashik - 422001', NULL, '2025-11-07 18:36:16', '1'),
(18, 'xyz', 'xyz@gmail.com', '$2y$10$hKDV6ZJzafLX.pAzgNSt6ODAoaXdYTTMhPR7jGonO.Mn7m6kQacBq', '', '403, vraj vihar, jagatnaka, varachha, surat.', '', NULL, '2', '1', 'India', 'Gujarat', 'Surat - 395003', NULL, '2025-11-07 18:36:16', '1'),
(19, 'neel321', 'neel321@gmail.com', '$2y$10$3w5Th7QXBjkQl22x6qP4vOzBO2QI1XjlqUNCpLp.6c5bkC94.U4Xy', '', 'gujarat', '', NULL, '1', '1', NULL, NULL, NULL, NULL, '2025-11-07 18:36:16', '1'),
(20, 'om987', 'om987@gmail.com', '$2y$10$//4BIQdh5xqzcoiQvG7XVeW3jfHhSi2eiddQ2JYMtiMWX4gRCdvra', '9875468151', 'Raipur, Chhatisagadh.', NULL, NULL, '', '1', NULL, NULL, NULL, NULL, '2025-11-07 18:36:16', '1'),
(21, 'khushal', 'khushal@gmail.com', '$2y$10$Pmd6xV4ekYj4sy6gi364B.vMVrz.o54mdQEOsdtzRGYbG8C8rs2sa', NULL, 'New Darvaja, Rajeshthan', NULL, NULL, NULL, '1', 'India', 'Rajasthan', 'Bikaner - 334001', NULL, '2025-11-07 18:36:16', '1'),
(22, 'ravi003', 'ravi@gmail.com', '$2y$10$Ap3v2V9Mf5fMObioMk6XTOTi3dF3nwHyndN4jqUPiM19tmH1PWKze', NULL, 'gujarat', NULL, NULL, NULL, '1', 'India', 'Gujarat', 'Surat - 395003', NULL, '2025-11-07 18:36:16', '1'),
(23, 'ketan59', 'ketan@gmail.com', '$2y$10$CI2dZj68aYfpXanmkSdXeeIz/isKsA4DJF9scBLpDtxe.apl2aE5C', NULL, 'Aanad, Gujarat', NULL, NULL, NULL, '1', 'India', 'Gujarat', 'Surat - 395003', NULL, '2025-11-07 18:36:16', '1'),
(24, 'neelpatel', 'neelpatel@gmail.com', '$2y$10$1pVkKlmQ45745GZKJuCtrOEm4soKLCmEFhuXWpRbVZmfTn5ZBt29i', NULL, 'Sarathana Nature Park, Surat.', NULL, NULL, NULL, '1', 'India', 'Gujarat', 'Surat - 395003', NULL, NULL, '1'),
(25, 'ravina', 'ravina852@gmail.com', '$2y$10$y6cpD.xlld4DmuNG3kJWJe5BDAeXJyfjunrNwZa7HvKOzICCUm9ju', '9898989898', 'Rajasthan', 'Rajasthan', NULL, '2', '1', 'India', 'Rajasthan', 'Udaipur - 313001', NULL, NULL, '1'),
(26, 'vishal98', 'vishal@gmail.com', '$2y$10$DhDhPRmUsu.eK6rhJF7OxeALWZ1/FY1lQn.1wAM9wm3HY6fUU0BlG', '7539518528', 'Mota Varachha, Surat,Gujarat.', NULL, 'vishal98_1762863111.jpg', '1', '1', 'India', 'Gujarat', 'Surat - 395003', NULL, NULL, '1'),
(27, 'sujal87', 'sujal87@gmail.com', '$2y$10$TdmZ0gnyij13nU9ooTj/HuNO31cJjfRCrbx9UNx1QugiZVA83vwV.', NULL, '32, darshan, kamrej, surat.', NULL, NULL, NULL, '1', 'India', 'Gujarat', 'Surat - 395003', NULL, NULL, '1'),
(28, 'umang3110', 'umang3110@gmail.com', '$2y$10$Y00rZm86Kg5sqbFzk67gIuQ8mvZ5NQeO7jhDe5dgFBsxIg3msMtDa', NULL, 'Vesu Ring Road, Surat.', NULL, 'umang3110_1763096661.png', NULL, '1', 'India', 'Gujarat', 'Surat - 395003', NULL, NULL, '1'),
(29, 'divyraj', 'divyraj@gmail.com', '$2y$10$OexejsLHYmtDf/xu2LctV.k8r6g5Mq9NmO3pI3cIqPMzfOdFkEYAG', NULL, 'kapodra , Surat.', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '1'),
(30, 'yash87', 'yash87@gmail.com', '$2y$10$bMkDlUzZxgSmkgeYAvED8ennXYRW8dZal5TgRwr1sUy4VvWOwgmYy', NULL, 'surat.', NULL, NULL, NULL, '1', 'India', 'Gujarat', 'Surat - 395003', NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `viewcart`
--

CREATE TABLE `viewcart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `viewcart`
--

INSERT INTO `viewcart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(64, 18, 15, 1, '2025-10-29 04:32:35'),
(81, 16, 1, 1, '2025-10-30 07:38:16'),
(83, 19, 7, 1, '2025-11-05 13:02:50'),
(105, 24, 12, 1, '2025-11-10 08:58:49'),
(110, 25, 18, 1, '2025-11-10 13:19:01');

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
(15, 7, 15, '2025-10-08 11:33:37'),
(29, 17, 15, '2025-10-08 11:50:01'),
(40, 7, 5, '2025-10-08 12:01:18'),
(41, 7, 6, '2025-10-08 12:01:18'),
(43, 7, 12, '2025-10-08 12:01:20'),
(45, 7, 1, '2025-10-08 14:03:14'),
(47, 16, 2, '2025-10-08 14:46:02'),
(48, 16, 4, '2025-10-08 14:46:03'),
(49, 16, 8, '2025-10-08 14:46:07'),
(50, 16, 16, '2025-10-08 14:46:10'),
(51, 16, 7, '2025-10-08 14:46:20'),
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
(69, 10, 17, '2025-10-09 10:53:46'),
(70, 7, 7, '2025-10-10 11:15:21'),
(71, 17, 3, '2025-10-10 13:42:16'),
(72, 17, 4, '2025-10-10 13:42:19'),
(73, 17, 1, '2025-10-10 13:42:22'),
(74, 17, 2, '2025-10-10 13:42:24'),
(75, 7, 8, '2025-10-10 15:24:34'),
(76, 9, 7, '2025-10-13 11:13:02'),
(77, 9, 14, '2025-10-13 11:13:09'),
(79, 9, 6, '2025-10-13 11:18:27'),
(80, 9, 2, '2025-10-13 11:30:01'),
(82, 8, 5, '2025-10-17 15:30:26'),
(83, 8, 4, '2025-10-17 15:30:34'),
(84, 10, 14, '2025-10-17 15:32:52'),
(85, 16, 15, '2025-10-17 15:34:38'),
(86, 18, 8, '2025-10-27 17:10:56'),
(88, 18, 18, '2025-10-27 17:11:01'),
(89, 18, 17, '2025-10-27 17:11:04'),
(90, 18, 11, '2025-10-27 17:11:18'),
(91, 18, 5, '2025-10-27 17:11:25'),
(92, 18, 16, '2025-10-29 15:24:10'),
(93, 10, 5, '2025-10-29 16:20:34'),
(94, 8, 18, '2025-10-30 10:10:22'),
(95, 16, 18, '2025-10-30 12:46:13'),
(96, 16, 1, '2025-10-30 18:38:16'),
(97, 19, 8, '2025-11-05 18:28:55'),
(98, 19, 15, '2025-11-05 18:28:56'),
(99, 19, 17, '2025-11-05 18:28:57'),
(100, 19, 4, '2025-11-05 18:29:01'),
(101, 19, 1, '2025-11-05 18:29:02'),
(102, 20, 1, '2025-11-05 18:43:08'),
(103, 20, 2, '2025-11-05 18:43:08'),
(104, 20, 3, '2025-11-05 18:43:09'),
(105, 20, 4, '2025-11-05 18:43:10'),
(106, 20, 9, '2025-11-05 18:43:12'),
(107, 20, 11, '2025-11-05 18:43:13'),
(108, 20, 15, '2025-11-05 18:43:17'),
(109, 20, 8, '2025-11-05 18:43:17'),
(110, 20, 16, '2025-11-05 18:43:18'),
(111, 20, 18, '2025-11-05 18:43:20'),
(112, 20, 5, '2025-11-05 18:43:23'),
(113, 20, 6, '2025-11-05 18:43:23'),
(114, 20, 19, '2025-11-05 18:43:26'),
(115, 21, 16, '2025-11-06 10:57:38'),
(116, 21, 1, '2025-11-06 10:58:14'),
(117, 21, 18, '2025-11-06 10:58:20'),
(118, 21, 5, '2025-11-06 10:58:26'),
(119, 21, 7, '2025-11-06 10:58:28'),
(120, 21, 6, '2025-11-06 10:58:29'),
(121, 21, 13, '2025-11-06 10:58:31'),
(122, 21, 19, '2025-11-06 10:58:34'),
(123, 22, 8, '2025-11-06 18:02:34'),
(124, 22, 16, '2025-11-06 18:02:35'),
(125, 22, 18, '2025-11-06 18:02:39'),
(126, 22, 1, '2025-11-06 18:02:44'),
(127, 22, 2, '2025-11-06 18:02:45'),
(128, 22, 6, '2025-11-06 18:02:49'),
(129, 22, 12, '2025-11-06 18:02:50'),
(130, 22, 13, '2025-11-06 18:02:54'),
(131, 22, 19, '2025-11-06 18:02:55'),
(132, 22, 3, '2025-11-07 14:51:12'),
(133, 8, 7, '2025-11-10 10:47:58'),
(134, 24, 4, '2025-11-10 13:02:56'),
(135, 24, 3, '2025-11-10 13:02:58'),
(136, 24, 15, '2025-11-10 13:03:00'),
(137, 24, 8, '2025-11-10 13:03:01'),
(138, 24, 16, '2025-11-10 13:03:02'),
(139, 24, 19, '2025-11-10 13:03:08'),
(140, 24, 13, '2025-11-10 13:03:11'),
(141, 25, 1, '2025-11-10 18:42:54'),
(142, 25, 2, '2025-11-10 18:42:55'),
(143, 25, 3, '2025-11-10 18:42:56'),
(144, 25, 4, '2025-11-10 18:42:57'),
(145, 25, 8, '2025-11-10 18:43:05'),
(146, 25, 15, '2025-11-10 18:43:06'),
(147, 25, 17, '2025-11-10 18:43:08'),
(148, 25, 5, '2025-11-10 18:43:13'),
(149, 25, 6, '2025-11-10 18:43:14'),
(150, 25, 7, '2025-11-10 18:43:15'),
(151, 25, 12, '2025-11-10 18:43:16'),
(152, 26, 1, '2025-11-11 12:21:31'),
(153, 26, 2, '2025-11-11 12:21:32'),
(154, 26, 3, '2025-11-11 12:21:32'),
(155, 26, 4, '2025-11-11 12:21:34'),
(156, 26, 9, '2025-11-11 12:21:39'),
(157, 26, 10, '2025-11-11 12:21:40'),
(158, 26, 11, '2025-11-11 12:21:41'),
(159, 26, 8, '2025-11-11 12:21:48'),
(160, 26, 15, '2025-11-11 12:21:49'),
(161, 26, 16, '2025-11-11 12:21:50'),
(162, 26, 5, '2025-11-11 12:21:56'),
(163, 26, 6, '2025-11-11 12:21:56'),
(164, 26, 7, '2025-11-11 12:21:57'),
(165, 26, 12, '2025-11-11 12:21:58'),
(166, 26, 13, '2025-11-11 12:22:00'),
(167, 26, 14, '2025-11-11 12:22:01'),
(168, 26, 19, '2025-11-11 12:22:02'),
(172, 27, 4, '2025-11-13 12:58:05'),
(173, 27, 9, '2025-11-13 12:58:21'),
(174, 27, 3, '2025-11-13 15:49:10'),
(175, 27, 11, '2025-11-13 15:49:56'),
(176, 8, 20, '2025-11-13 17:37:27'),
(177, 8, 14, '2025-11-13 17:39:45'),
(178, 8, 9, '2025-11-13 18:13:10'),
(179, 8, 2, '2025-11-13 18:13:18'),
(180, 28, 12, '2025-11-14 10:30:03'),
(181, 28, 7, '2025-11-14 10:30:04'),
(182, 28, 6, '2025-11-14 10:30:05'),
(183, 28, 5, '2025-11-14 10:30:06'),
(184, 28, 4, '2025-11-14 10:30:10'),
(185, 28, 3, '2025-11-14 10:30:11'),
(186, 28, 1, '2025-11-14 10:30:13'),
(187, 28, 2, '2025-11-14 10:30:14'),
(188, 28, 8, '2025-11-14 10:30:18'),
(189, 28, 15, '2025-11-14 10:30:19'),
(190, 28, 16, '2025-11-14 10:30:20'),
(191, 28, 20, '2025-11-14 10:30:22'),
(192, 29, 16, '2025-11-17 14:32:34'),
(193, 29, 4, '2025-11-17 14:32:44'),
(194, 29, 3, '2025-11-17 14:32:46'),
(195, 29, 2, '2025-11-17 14:32:46'),
(196, 29, 1, '2025-11-17 14:32:47'),
(197, 29, 9, '2025-11-17 14:32:50'),
(198, 29, 10, '2025-11-17 14:32:51'),
(199, 29, 11, '2025-11-17 14:32:51'),
(200, 29, 21, '2025-11-17 18:58:22'),
(201, 30, 15, '2025-11-18 10:34:59'),
(202, 30, 8, '2025-11-18 10:34:59'),
(203, 30, 4, '2025-11-18 10:35:06'),
(204, 30, 9, '2025-11-18 10:35:11'),
(205, 30, 11, '2025-11-18 10:35:12'),
(206, 30, 13, '2025-11-18 10:35:24'),
(207, 30, 14, '2025-11-18 10:35:25'),
(208, 30, 19, '2025-11-18 10:35:26'),
(209, 30, 21, '2025-11-18 10:35:31'),
(210, 30, 20, '2025-11-18 10:35:33'),
(211, 30, 18, '2025-11-18 12:17:12');

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
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_Id`),
  ADD KEY `fk_product_category` (`categorie_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sitedetail`
--
ALTER TABLE `sitedetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_image`
--
ALTER TABLE `site_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`subscriber_id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viewcart`
--
ALTER TABLE `viewcart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_entry` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

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
  MODIFY `categorie_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sitedetail`
--
ALTER TABLE `sitedetail`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_image`
--
ALTER TABLE `site_image`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `subscriber_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1201;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `viewcart`
--
ALTER TABLE `viewcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_user` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`categorie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_Id`) ON DELETE CASCADE;

--
-- Constraints for table `viewcart`
--
ALTER TABLE `viewcart`
  ADD CONSTRAINT `viewcart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `viewcart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
