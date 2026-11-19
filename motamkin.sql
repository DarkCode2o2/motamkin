-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2026 at 02:49 PM
-- Server version: 10.11.16-MariaDB-ubu2204
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `made_motamkin`
--

-- --------------------------------------------------------

--
-- Table structure for table `numbers`
--

CREATE TABLE `numbers` (
  `id` int(11) NOT NULL,
  `number` varchar(50) NOT NULL,
  `number_two` varchar(50) DEFAULT NULL,
  `price` varchar(250) NOT NULL,
  `category` enum('economic','special','elite','vip','bundle') NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `numbers`
--

INSERT INTO `numbers` (`id`, `number`, `number_two`, `price`, `category`, `user_id`) VALUES
(112, '0582838482', NULL, '450', 'economic', 1),
(115, '0596939495 ', NULL, '350', 'economic', 1),
(116, '0580471010', NULL, '200', 'economic', 1),
(117, '0581889191', NULL, '350', 'economic', 1),
(161, '0505338448', NULL, '650', 'special', 1),
(165, '0515075757', NULL, '650', 'special', 1),
(167, '0531913141', NULL, '550', 'special', 1),
(168, '0533353069', NULL, '399', 'economic', 1),
(169, '0558070758', NULL, '550', 'special', 1),
(170, '0539987987', NULL, '550', 'special', 1),
(171, '0554048085', NULL, '550', 'special', 1),
(172, '0500901201', NULL, '550', 'special', 1),
(174, '0573801801', NULL, '750', 'special', 1),
(175, '0579899986', NULL, '399', 'economic', 1),
(177, '0556528333', NULL, '450', 'economic', 1),
(178, '0562260662', NULL, '700', 'special', 1),
(180, '0580108181 ', NULL, '1499', 'special', 1),
(181, '0571071117', '0572072227', '2000', 'bundle', 1),
(186, '0509509789', NULL, '1499', 'special', 1),
(187, '0562506262', NULL, '1500', 'elite', 1),
(188, '0591817151', NULL, '1500', 'elite', 1),
(189, '0533011022', NULL, '2500', 'elite', 1),
(190, '0503030003', '0553030003', '25,000', 'bundle', 1),
(191, '0583838883', NULL, '6500', 'vip', 1),
(192, '0592292229', NULL, '8000', 'vip', 1),
(193, '0574744444', NULL, '60,000', 'vip', 1),
(194, '0511955151', NULL, '450', 'economic', 1),
(195, '0530449990', NULL, '550', 'special', 1),
(196, '0561161505', NULL, '550', 'special', 1),
(198, '0509309392', NULL, '400', 'economic', 7),
(203, '0551119946', NULL, '1499', 'special', 7),
(204, '0555311172', NULL, '2000', 'elite', 7),
(205, '0530399309', NULL, '399', 'economic', 7),
(206, '0555332798', NULL, '350', 'economic', 7),
(207, '0500059152', NULL, '350', 'economic', 7),
(208, '0555229759', NULL, '300', 'economic', 7),
(213, '0573370770', NULL, '450', 'economic', 7),
(214, '0594900404', NULL, '499', 'economic', 7),
(216, '0544450615', NULL, '450', 'economic', 7),
(219, '0502500205', NULL, '1550', 'elite', 7),
(220, '0533308797', NULL, '400', 'economic', 7),
(221, '0566115529', NULL, '450', 'economic', 7),
(223, '0550077287', NULL, '499', 'economic', 7),
(224, '0550022873', NULL, '499', 'economic', 7),
(225, '0580870080', NULL, '599', 'special', 7),
(226, '0550333288', NULL, '750', 'special', 7),
(227, '0573730370', NULL, '499', 'economic', 7),
(228, '0580960888', NULL, '650', 'special', 7),
(229, '0554054504', NULL, '1450', 'special', 7),
(231, '0533111793', NULL, '449', 'economic', 7),
(232, '0573703337', NULL, '850', 'special', 7),
(233, '0555656803', NULL, '399', 'economic', 7),
(235, '0501115571', NULL, '599', 'special', 7),
(236, '0508001081', NULL, '550', 'special', 7),
(239, '0555036236', NULL, '600', 'special', 5),
(240, '0555994886', NULL, '700', 'special', 5),
(241, '0569163666', NULL, '650', 'special', 5),
(242, '0571117150', '0572227250', '2000', 'bundle', 1),
(243, '0583848513', '0583848514', '500', 'bundle', 1),
(244, '0580850516', '0580850561', '750', 'bundle', 1),
(246, '0539558880', NULL, '350', 'economic', 1),
(248, '0555099580', NULL, '499', 'economic', 1),
(252, '0573520520', NULL, '350', 'economic', 1),
(253, '0575907590', NULL, '499', 'economic', 1),
(254, '0575097509', NULL, '499', 'economic', 1),
(256, '0534907090', NULL, '399', 'economic', 1),
(258, '0533332211', NULL, '19,000', 'vip', 1),
(259, '0551150505', '0501150505', '8500', 'bundle', 1),
(260, '0500021666', NULL, '5500', 'vip', 1),
(261, '0500033312', NULL, '6000', 'vip', 1),
(310, '0574111222', NULL, '5500', 'vip', 1),
(311, '0574797979', NULL, '5500', 'vip', 1),
(312, '0574020202', NULL, '3500', 'elite', 1),
(313, '0574030303', NULL, '3500', 'elite', 1),
(314, '0574090909', NULL, '3500', 'elite', 1),
(316, '0559955735', NULL, '750', 'special', 7),
(340, '0559759590', NULL, '750', 'special', 8),
(343, '0534455543', NULL, '1500', 'elite', 8),
(347, '0506046044', NULL, '1200', 'special', 8),
(349, '0573733350', NULL, '1200', 'special', 8),
(358, '0500102202', NULL, '1500', 'elite', 8),
(359, '0503737033', NULL, '499', 'economic', 7);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=>admin 1=>user',
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `remember_token`) VALUES
(1, 'ابو عبد الرحمن', 'm', '$2y$10$9wELEmXI1O4YaEr.Efskpe5g.XJqSotJhWNS95PyO0.2rpBUaXfsW', 0, '3f83757490a4d3a7b772da1fe70575530575598d933f77a7771a40d8f8dec5b2'),
(5, 'ابو مناحي', 'f', '$2y$10$gTrf02H/ZtFsGopav5Y3V.RdOqdqzrQvN5xMzBw7t5LWImm1ovGHq', 1, 'f0c6efe844235393445fef2534d927a9e1abb624d6ccb91cbee64a97adca4a2b'),
(7, 'ابو ساره', 's', '$2y$10$0MtI7jVRHV5YO4ovYmDPcuV1YAbc3ERkn.aclQrzdck9bTbmhpkTe', 1, 'a3e446893bf87e7f20d16ccf28f2e5456486045bb46f5763d50c8b71dd30dfd3'),
(8, 'ابو عبدالرحمن (( تركي )) ', 't', '$2y$10$G3b67YCDFzwTdV8M2BY19uVa1/uy2/zUsr2zyCs5DxHf2pqfu0Ppy', 1, '8e2e433963aec125575dec82c75959a6df8a3662ae6d679a68b051802d7700bc'),
(9, 'عمر', 'dc', '$2y$10$25pBiOtzVXeezWFU/qmPHuTLS2I12D1/io6VlgzcdPxXJxYj7eOmy', 1, '4c7e58e2050fe8e2c432728edd65dae311c4822f77ca097b1218f3581eba9f69');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `numbers`
--
ALTER TABLE `numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
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
-- AUTO_INCREMENT for table `numbers`
--
ALTER TABLE `numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `numbers`
--
ALTER TABLE `numbers`
  ADD CONSTRAINT `numbers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
