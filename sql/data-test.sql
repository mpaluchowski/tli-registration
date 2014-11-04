/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- Dumping data for table tli_registrations.tli_administrators: ~1 rows (approximately)
DELETE FROM `tli_administrators`;
/*!40000 ALTER TABLE `tli_administrators` DISABLE KEYS */;
INSERT INTO `tli_administrators` (`id_administrator`, `full_name`, `email`, `password`) VALUES
	(1, 'Michał Paluchowski', '***REMOVED***', '$2y$10$ZDTlEI.ER1GXb4YvTuZ/E.vjV9hwZCGI1su2Gd8qtXek2loHcpGK6');
/*!40000 ALTER TABLE `tli_administrators` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_clubs: ~4 rows (approximately)
DELETE FROM `tli_clubs`;
/*!40000 ALTER TABLE `tli_clubs` DISABLE KEYS */;
INSERT INTO `tli_clubs` (`id_club`, `name`) VALUES
	(1, 'Speaking Elephants'),
	(2, 'Toastmasters Polska SA'),
	(3, 'Top Careers Toastmasters');
/*!40000 ALTER TABLE `tli_clubs` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_pricing_items: ~7 rows (approximately)
DELETE FROM `tli_pricing_items`;
/*!40000 ALTER TABLE `tli_pricing_items` DISABLE KEYS */;
INSERT INTO `tli_pricing_items` (`id_pricing_item`, `item`, `variant`, `date_valid_through`) VALUES
	(1, 'admission', 'early', '2014-11-30 23:59:59'),
	(2, 'admission', 'regular', '2015-01-10 23:59:59'),
	(3, 'admission', 'late', '2015-01-20 23:59:59'),
	(4, 'friday-social-event', NULL, NULL),
	(5, 'saturday-dinner-participate', 'meat', NULL),
	(6, 'saturday-dinner-participate', 'vegetarian', NULL),
	(7, 'saturday-party-participate', NULL, NULL);
/*!40000 ALTER TABLE `tli_pricing_items` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_pricing_prices: ~7 rows (approximately)
DELETE FROM `tli_pricing_prices`;
/*!40000 ALTER TABLE `tli_pricing_prices` DISABLE KEYS */;
INSERT INTO `tli_pricing_prices` (`fk_pricing_item`, `currency`, `price`) VALUES
	(1, 'EUR', 10),
	(1, 'PLN', 39),
	(2, 'EUR', 15),
	(2, 'PLN', 49),
	(3, 'EUR', 20),
	(3, 'PLN', 59),
	(4, 'EUR', 8),
	(4, 'PLN', 30),
	(5, 'EUR', 13),
	(5, 'PLN', 50),
	(6, 'EUR', 11),
	(6, 'PLN', 40),
	(7, 'EUR', 5),
	(7, 'PLN', 20);
/*!40000 ALTER TABLE `tli_pricing_prices` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_registrations: ~3 rows (approximately)
DELETE FROM `tli_registrations`;
/*!40000 ALTER TABLE `tli_registrations` DISABLE KEYS */;
INSERT INTO `tli_registrations` (`id_registration`, `email`, `hash`, `date_entered`, `date_paid`) VALUES
	(1, '***REMOVED***', '30085d747a6d6e2711c7c2446fdf296dc65d67f5', '2014-10-16 09:50:26', NULL),
	(2, 'john@example.com', '5224cb6fdd5bbe463af1db8ee499e858fcb79f81', '2014-10-16 10:50:42', NULL),
	(3, 'jane@example.com', '0850a4cffb73cbc53fd33e8990c2184c915ff041', '2014-10-19 22:46:36', '2014-10-19 22:46:56');
/*!40000 ALTER TABLE `tli_registrations` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_registration_fields: ~29 rows (approximately)
DELETE FROM `tli_registration_fields`;
/*!40000 ALTER TABLE `tli_registration_fields` DISABLE KEYS */;
INSERT INTO `tli_registration_fields` (`fk_registration`, `name`, `value`) VALUES
	(1, 'accommodation-on', '["fri-sat"]'),
	(1, 'accommodation-with-toastmasters', '"stay"'),
	(1, 'comments', '"This is my comment. I\'ll add some  code to that."'),
	(1, 'educational-awards', '"ACS, ALB"'),
	(1, 'exec-position', '"vpe"'),
	(1, 'friday-social-event', '"on"'),
	(1, 'full-name', '"Michal Paluchowski"'),
	(1, 'home-club', '"Speaking Elephants"'),
	(1, 'phone', '"+48888205402"'),
	(1, 'saturday-dinner-meal', '"vegetarian"'),
	(1, 'saturday-dinner-participate', '"on"'),
	(1, 'saturday-party-participate', '"on"'),
	(1, 'translator', '"on"'),
	(2, 'accommodation-with-toastmasters', '"host"'),
	(2, 'exec-position', '"none"'),
	(2, 'friday-social-event', '"on"'),
	(2, 'full-name', '"John Doe"'),
	(2, 'home-club', '"None"'),
	(2, 'phone', '"+48694470100"'),
	(3, 'accommodation-with-toastmasters', '"independent"'),
	(3, 'exec-position', '"vpe"'),
	(3, 'full-name', '"Jane Doe"'),
	(3, 'home-club', '"Speaking Elephants"'),
	(3, 'phone', '"+48 123 456 789"');
/*!40000 ALTER TABLE `tli_registration_fields` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
