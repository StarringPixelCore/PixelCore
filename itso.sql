CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_number` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'ITSO PERSONNEL',
  `profile_picture` varchar(255) DEFAULT 'default.jpg',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `verify_token` varchar(255) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tblusers` (`id`, `id_number`, `firstname`, `lastname`, `email`, `password`, `role`, `profile_picture`, `created_at`, `verify_token`, `is_verified`, `reset_token`, `reset_token_expires_at`) VALUES
(1, '202511111', 'ITSO', 'Personnel', 'riacruzit0049@gmail.com', '$2y$10$1tVkGlfkDmw1t6I1VwkRi.3EFPX/M7tLu/KkBFIinsC3LlDxJUEdW', 'ITSO PERSONNEL', 'default.jpg', '2025-11-29 22:44:45', 'da09202ae8899cad7374f80ff3fdf06d', 0, NULL, NULL),
(2, '202522222', 'Associate', 'Demo', 'dummy1.dumd0m@gmail.com', '$2y$10$5AESFPgPtIv0J6A.1JFoye7UJo//GfRFy0wJ2vi8wionrP0YIIvH6', 'ASSOCIATE', 'default.jpg', '2025-11-29 22:47:31', '24a5834776442b4ef61546720d7f4e39', 0, NULL, NULL),
(3, '202533333', 'Student', 'Demo', 'fudgechocooreo@gmail.com', '$2y$10$jr0/Ky.z6he..Adp26bk2.REwmXgZfcqOTkOc9ai8h8gla4yVYcLa', 'STUDENT', 'default.jpg', '2025-11-29 22:49:10', '6c2e4b4fddc2a94e6a66c27be4c7cd5e', 0, NULL, NULL);

CREATE TABLE `tblequipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `available_count` int(11) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tblequipment` (`id`, `equipment_name`, `category`, `quantity`, `available_count`, `status`, `created_at`) VALUES
(1, 'Laptop', 'Laptop', 10, 10, 'Active', '2025-11-29 00:21:09'),
(2, 'DLP', 'DLP', 5, 5, 'Active', '2025-11-29 00:21:09'),
(3, 'HDMI and VGA Cable', 'Cable', 15, 15, 'Active', '2025-11-29 00:21:09'),
(5, 'DLP Remote Control', 'Remote Control', 5, 5, 'Active', '2025-11-29 00:21:09'),
(6, 'Keyboard & Mouse', 'Keyboard/Mouse', 8, 8, 'Active', '2025-11-29 00:21:09'),
(7, 'Wacom Drawing Tablet', 'Drawing Tablet', 6, 6, 'Active', '2025-11-29 00:21:09'),
(8, 'Speaker Set', 'Speaker Set', 4, 4, 'Active', '2025-11-29 00:21:09'),
(9, 'Webcam', 'Webcam', 10, 10, 'Active', '2025-11-29 00:21:09'),
(10, 'Extension Cord', 'Extension Cord', 12, 12, 'Active', '2025-11-29 00:21:09'),
(11, 'Cable Crimping Tool', 'Crimping Tool', 3, 3, 'Active', '2025-11-29 00:21:09'),
(12, 'Cable Tester', 'Cable Tester', 3, 3, 'Active', '2025-11-29 00:21:09'),
(13, 'Lab Room Key', 'Lab Room Key', 7, 7, 'Active', '2025-11-29 00:21:09'),
(15, 'Laptop Charger', 'Charger', 10, 10, 'Active', '2025-11-29 13:30:32'),
(16, 'Power Cable', 'Cable', 5, 5, 'Active', '2025-11-29 13:30:32'),
(17, 'VGA/HDMI Cable', 'Cable', 5, 5, 'Active', '2025-11-29 13:30:32'),
(18, 'Lightning Cable', 'Cable', 8, 8, 'Active', '2025-11-29 13:30:32'),
(19, 'Drawing Tablet Pen', 'Pen', 6, 6, 'Active', '2025-11-29 13:30:32');

CREATE TABLE `tblequipment_bundles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_equipment_id` int(11) NOT NULL,
  `accessory_equipment_id` int(11) NOT NULL,
  `quantity_per_parent` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_bundle_parent` (`parent_equipment_id`),
  KEY `fk_bundle_accessory` (`accessory_equipment_id`),
  CONSTRAINT `fk_bundle_parent` FOREIGN KEY (`parent_equipment_id`) REFERENCES `tblequipment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bundle_accessory` FOREIGN KEY (`accessory_equipment_id`) REFERENCES `tblequipment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tblequipment_bundles` (`id`, `parent_equipment_id`, `accessory_equipment_id`, `quantity_per_parent`) VALUES
(1, 1, 15, 1),
(2, 2, 10, 1),
(3, 2, 17, 1),
(4, 2, 16, 1),
(5, 6, 18, 1),
(6, 7, 19, 1);

CREATE TABLE `tblborrows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(255) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `borrow_date` date NOT NULL,
  `borrow_time` time NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `returned_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `equipment_id` (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tblreservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(255) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `reserve_date` date NOT NULL,
  `reserve_time` time NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `returned_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `equipment_id` (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;