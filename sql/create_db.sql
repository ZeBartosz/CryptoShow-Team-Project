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
    `is_admin` BOOLEAN DEFAULT FALSE,
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
    FOREIGN KEY (fk_user_id) REFERENCES registered_user (user_id) ON DELETE CASCADE,
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
    `event_description` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `is_published` BOOLEAN DEFAULT FALSE,
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
     FOREIGN KEY (fk_event_id) REFERENCES event (event_id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 
COLLATE=utf8_unicode_ci;

-- --------------------------------
-- Update value of is_admin for user_id 1
-- --------------------------------
UPDATE registered_user SET is_admin = true WHERE user_id = 1;
