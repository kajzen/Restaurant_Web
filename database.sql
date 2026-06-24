-- LiChun Restaurant — Database Schema
-- Run this file to set up the database before starting the project.
-- Import via phpMyAdmin or: mysql -u root -p your_database < database.sql

SET NAMES utf8;
SET time_zone = '+00:00';

-- ----------------------------
-- Table: menu_items
-- ----------------------------
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id`          INT(11)        NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(255)   NOT NULL,
  `price`       DECIMAL(10,2)  NOT NULL,
  `category`    ENUM('soups','main','desserts','drinks') NOT NULL,
  `allergens`   VARCHAR(255)   DEFAULT NULL,
  `description` TEXT           DEFAULT NULL,
  `image_path`  VARCHAR(255)   DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table: reservations
-- ----------------------------
CREATE TABLE IF NOT EXISTS `reservations` (
  `id`               INT(11)      NOT NULL AUTO_INCREMENT,
  `name`             VARCHAR(255) NOT NULL,
  `phone`            VARCHAR(50)  NOT NULL,
  `email`            VARCHAR(255) DEFAULT NULL,
  `guests`           INT(11)      NOT NULL,
  `reservation_date` DATE         NOT NULL,
  `reservation_time` TIME         NOT NULL,
  `notes`            TEXT         DEFAULT NULL,
  `status`           ENUM('New','Confirmed','Cancelled') NOT NULL DEFAULT 'New',
  `created_at`       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table: reviews
-- ----------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `author_name` VARCHAR(255) NOT NULL,
  `rating`      TINYINT(1)   NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `comment`     TEXT         DEFAULT NULL,
  `status`      ENUM('New','Approved','Rejected') NOT NULL DEFAULT 'New',
  `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table: news
-- ----------------------------
CREATE TABLE IF NOT EXISTS `news` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `title`      VARCHAR(255) NOT NULL,
  `content`    TEXT         NOT NULL,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table: admin (credentials)
-- Default login: admin / admin123
-- Change password after first login!
-- ----------------------------
CREATE TABLE IF NOT EXISTS `admin` (
  `id`       INT(11)      NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin` (`username`, `password`)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE `username` = `username`;
-- Default password: "password" (bcrypt) — change immediately!
