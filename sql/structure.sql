/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table tli_registrations.tli_administrators
DROP TABLE IF EXISTS `tli_administrators`;
CREATE TABLE IF NOT EXISTS `tli_administrators` (
  `id_administrator` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_administrator`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_clubs
DROP TABLE IF EXISTS `tli_clubs`;
CREATE TABLE IF NOT EXISTS `tli_clubs` (
  `id_club` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `division` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_club`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_discount_codes
DROP TABLE IF EXISTS `tli_discount_codes`;
CREATE TABLE IF NOT EXISTS `tli_discount_codes` (
  `id_discount_code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_redeemed` datetime DEFAULT NULL,
  `fk_registration` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_discount_code`),
  UNIQUE KEY `code` (`code`),
  KEY `code_email_date_redeemed` (`code`,`email`,`date_redeemed`),
  KEY `FK_tli_discount_codes_tli_registrations` (`fk_registration`),
  CONSTRAINT `FK_tli_discount_codes_tli_registrations` FOREIGN KEY (`fk_registration`) REFERENCES `tli_registrations` (`id_registration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_events
DROP TABLE IF EXISTS `tli_events`;
CREATE TABLE IF NOT EXISTS `tli_events` (
  `id_event` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_id` int(10) unsigned DEFAULT NULL,
  `fk_administrator` int(10) unsigned DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `date_occurred` datetime NOT NULL,
  PRIMARY KEY (`id_event`),
  KEY `FK__tli_administrators` (`fk_administrator`),
  CONSTRAINT `FK__tli_administrators` FOREIGN KEY (`fk_administrator`) REFERENCES `tli_administrators` (`id_administrator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_pricing_items
DROP TABLE IF EXISTS `tli_pricing_items`;
CREATE TABLE IF NOT EXISTS `tli_pricing_items` (
  `id_pricing_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `variant` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_valid_through` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pricing_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_pricing_prices
DROP TABLE IF EXISTS `tli_pricing_prices`;
CREATE TABLE IF NOT EXISTS `tli_pricing_prices` (
  `fk_pricing_item` int(10) unsigned NOT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`fk_pricing_item`,`currency`),
  CONSTRAINT `FK_tli_pricing_prices_tli_pricing_items` FOREIGN KEY (`fk_pricing_item`) REFERENCES `tli_pricing_items` (`id_pricing_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_registrations
DROP TABLE IF EXISTS `tli_registrations`;
CREATE TABLE IF NOT EXISTS `tli_registrations` (
  `id_registration` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `language_entered` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('waiting-list','pending-review','pending-payment','processing-payment','paid','cancelled') COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_entered` datetime NOT NULL,
  `date_paid` datetime DEFAULT NULL,
  PRIMARY KEY (`id_registration`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_registration_fields
DROP TABLE IF EXISTS `tli_registration_fields`;
CREATE TABLE IF NOT EXISTS `tli_registration_fields` (
  `fk_registration` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`fk_registration`,`name`),
  KEY `name_value` (`name`,`value`(255)),
  CONSTRAINT `FK_tli_registration_fields_tli_registration` FOREIGN KEY (`fk_registration`) REFERENCES `tli_registrations` (`id_registration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_rel_discount_codes_pricing_items
DROP TABLE IF EXISTS `tli_rel_discount_codes_pricing_items`;
CREATE TABLE IF NOT EXISTS `tli_rel_discount_codes_pricing_items` (
  `fk_discount_code` int(10) unsigned NOT NULL,
  `fk_pricing_item` int(10) unsigned NOT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`fk_discount_code`,`fk_pricing_item`,`currency`),
  KEY `FK_tli_rel_discount_codes_pricing_items_tli_pricing_items` (`fk_pricing_item`),
  CONSTRAINT `FK_tli_rel_discount_codes_pricing_items_tli_discount_codes` FOREIGN KEY (`fk_discount_code`) REFERENCES `tli_discount_codes` (`id_discount_code`),
  CONSTRAINT `FK_tli_rel_discount_codes_pricing_items_tli_pricing_items` FOREIGN KEY (`fk_pricing_item`) REFERENCES `tli_pricing_items` (`id_pricing_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table tli_registrations.tli_transactions
DROP TABLE IF EXISTS `tli_transactions`;
CREATE TABLE IF NOT EXISTS `tli_transactions` (
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fk_registration` int(10) unsigned NOT NULL,
  `amount` float NOT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `method` int(11) DEFAULT NULL,
  `statement` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_started` datetime NOT NULL,
  `date_valid` datetime NOT NULL,
  `date_paid` datetime DEFAULT NULL,
  PRIMARY KEY (`session_id`),
  KEY `FK__tli_registrations` (`fk_registration`),
  KEY `date_valid` (`date_valid`),
  CONSTRAINT `FK__tli_registrations` FOREIGN KEY (`fk_registration`) REFERENCES `tli_registrations` (`id_registration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
