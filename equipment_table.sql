-- Equipment Management System Table
-- Run this SQL script directly in your MySQL database

CREATE TABLE tblequipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    quantity INT DEFAULT 0 NOT NULL,
    available_count INT DEFAULT 0 NOT NULL,
    status VARCHAR(20) DEFAULT 'Active' NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
