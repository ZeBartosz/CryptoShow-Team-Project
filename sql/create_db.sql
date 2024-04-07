SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS cryptoshow_db;

CREATE DATABASE cryptoshow_db;

USE cryptoshow_db;

CREATE USER IF NOT EXISTS cryptoshowuser@localhost IDENTIFIED BY 'cryptoshowpass';

GRANT SELECT, INSERT, UPDATE, DELETE on cryptoshow_db.* TO cryptoshowuser@localhost;

-- -------------------------------------
-- Table structure for `registered_user`
-- -------------------------------------
DROP TABLE IF EXISTS `registered_user`;

CREATE TABLE `registered_user` (
    `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_nickname` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `user_name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `user_email` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `user_hashed_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `user_device_count` tinyint(5) unsigned NOT NULL DEFAULT 0,
    `user_registered_timestamp` timestamp NOT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



-- ------------------------------------
-- Table structure for `crypto_device`
-- ------------------------------------
DROP TABLE IF EXISTS `crypto_device`;
CREATE TABLE `crypto_device` (
    `crypto_device_id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
    `fk_user_id` INT(10) unsigned NOT NULL,
    `crypto_device_name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `crypto_device_image_name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `crypto_device_record_visible` BOOLEAN DEFAULT FALSE,
    `crypto_device_registered_timestamp` timestamp NOT NULL,
    FOREIGN KEY (fk_user_id) REFERENCES registered_user (user_id),
    PRIMARY KEY (`crypto_device_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
COLLATE=utf8_unicode_ci;



-- ---------------------------
-- Table structure for `event`
-- ---------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
    `event_id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
    `event_name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `event_date` DATE COLLATE utf8_unicode_ci DEFAULT NULL,
    `event_venue` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
COLLATE=utf8_unicode_ci;



-- --------------------------------
-- Table structure for `user_event`
-- --------------------------------
DROP TABLE IF EXISTS `user_event`;
CREATE TABLE `user_event` (
    `fk_user_id` INT(10) unsigned NOT NULL,
    `fk_event_id` INT(10) unsigned NOT NULL,
     FOREIGN KEY (fk_user_id) REFERENCES registered_user (user_id),
     FOREIGN KEY (fk_event_id) REFERENCES event (event_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
COLLATE=utf8_unicode_ci;

-- --------------------------------
-- Add is_admin column
-- --------------------------------
ALTER TABLE `registered_user` ADD COLUMN `is_admin` BOOLEAN DEFAULT FALSE;

-- --------------------------------
-- Update value of is_admin for user_id 1
-- --------------------------------
UPDATE registered_user SET is_admin = true WHERE user_id = 1;


-- Insert data into `registered_user`
INSERT INTO `registered_user` (`user_nickname`, `user_name`, `user_email`, `user_hashed_password`, `user_device_count`, `user_registered_timestamp`, `is_admin`)
VALUES
('john_doe', 'John Doe', 'john.doe@example.com', 'hashed_password1', 2, NOW(), FALSE),
('jane_smith', 'Jane Smith', 'jane.smith@example.com', 'hashed_password2', 1, NOW(), TRUE),
('bob_jones', 'Bob Jones', 'bob.jones@example.com', 'hashed_password3', 3, NOW(), FALSE);

-- Insert data into `crypto_device`
INSERT INTO `crypto_device` (`fk_user_id`, `crypto_device_name`, `crypto_device_image_name`, `crypto_device_record_visible`, `crypto_device_registered_timestamp`)
VALUES
(1, 'Bitcoin Miner', 'bitcoin_miner.png', TRUE, NOW()),
(1, 'Ethereum Rig', 'ethereum_rig.png', TRUE, NOW()),
(2, 'Litecoin Miner', 'litecoin_miner.png', FALSE, NOW()),
(3, 'Ripple Node', 'ripple_node.png', TRUE, NOW()),
(3, 'Cardano Machine', 'cardano_machine.png', FALSE, NOW()),
(3, 'Monero Miner', 'monero_miner.png', TRUE, NOW());

-- Insert data into `event`
INSERT INTO `event` (`event_name`, `event_date`, `event_venue`)
VALUES
('CryptoCon 2024', '2024-07-15', 'Convention Center, San Francisco'),
('Blockchain Expo 2024', '2024-09-20', 'Expo Hall, New York'),
('Bitcoin Summit 2024', '2024-11-05', 'Summit Arena, Los Angeles');

-- Insert data into `user_event`
INSERT INTO `user_event` (`fk_user_id`, `fk_event_id`)
VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 3);

-- --------------------------------
-- Update value of is_admin for user_id 1
-- --------------------------------
UPDATE registered_user SET is_admin = true WHERE user_id = 1;
