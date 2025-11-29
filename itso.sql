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