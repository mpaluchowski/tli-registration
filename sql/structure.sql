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
  PRIMARY KEY (`id_club`),
  UNIQUE KEY `name` (`name`)
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
  `status` enum('waiting-list','pending-review','processing-payment') COLLATE utf8_unicode_ci DEFAULT NULL,
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
  CONSTRAINT `FK_tli_registration_fields_tli_registration` FOREIGN KEY (`fk_registration`) REFERENCES `tli_registrations` (`id_registration`)
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
