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
	(1, 'admission', 'regular', '2015-01-02 23:59:59'),
	(2, 'admission', 'late', '2015-01-27 23:59:59'),
	(3, 'saturday-dinner-participate', NULL, NULL),
	(4, 'saturday-party-participate', NULL, NULL),
	(5, 'lunch', NULL, NULL),
	(6, 'friday-copernicus-attend', 'center', NULL),
	(7, 'friday-copernicus-attend', 'planetarium', NULL);
/*!40000 ALTER TABLE `tli_pricing_items` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_pricing_prices: ~14 rows (approximately)
DELETE FROM `tli_pricing_prices`;
/*!40000 ALTER TABLE `tli_pricing_prices` DISABLE KEYS */;
INSERT INTO `tli_pricing_prices` (`fk_pricing_item`, `currency`, `price`) VALUES
	(1, 'EUR', 14),
	(1, 'PLN', 55),
	(2, 'EUR', 18),
	(2, 'PLN', 70),
	(3, 'EUR', 12),
	(3, 'PLN', 45),
	(4, 'EUR', 6),
	(4, 'PLN', 20),
	(5, 'EUR', 5),
	(5, 'PLN', 15),
	(6, 'EUR', 4),
	(6, 'PLN', 13),
	(7, 'EUR', 3),
	(7, 'PLN', 11);
/*!40000 ALTER TABLE `tli_pricing_prices` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_registrations: ~5 rows (approximately)
DELETE FROM `tli_registrations`;
/*!40000 ALTER TABLE `tli_registrations` DISABLE KEYS */;
INSERT INTO `tli_registrations` (`id_registration`, `email`, `hash`, `language_entered`, `status`, `date_entered`, `date_paid`) VALUES
	(1, '***REMOVED***', '30085d747a6d6e2711c7c2446fdf296dc65d67f5', 'en', NULL, '2014-10-16 09:50:26', '2014-11-23 08:39:03'),
	(2, 'john@example.com', '5224cb6fdd5bbe463af1db8ee499e858fcb79f81', 'pl', 'waiting-list', '2014-10-16 10:50:42', NULL),
	(3, 'jane@example.com', '0850a4cffb73cbc53fd33e8990c2184c915ff041', 'pl', 'processing-payment', '2014-10-19 22:46:36', NULL),
	(4, 'ibrahim@example.com', '0361f888e4fd81b343da82653e0961c8bffac06a', 'en', 'pending-review', '2014-11-16 21:38:30', NULL),
	(5, 'maria@example.org', '7d8967805b752068007564285fd65fe78121bab6', 'pl', NULL, '2014-11-23 13:22:27', NULL);
/*!40000 ALTER TABLE `tli_registrations` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_registration_fields: ~60 rows (approximately)
DELETE FROM `tli_registration_fields`;
/*!40000 ALTER TABLE `tli_registration_fields` DISABLE KEYS */;
INSERT INTO `tli_registration_fields` (`fk_registration`, `name`, `value`) VALUES
	(1, 'accommodation-on', '["fri-sat"]'),
	(1, 'accommodation-with-toastmasters', '"stay"'),
	(1, 'comments', '"This is my comment. I\'ll add some  code to that."'),
	(1, 'contest-attend', '"on"'),
	(1, 'country', '"poland"'),
	(1, 'educational-awards', '"ACS, ALB"'),
	(1, 'exec-position', '"vpe"'),
	(1, 'friday-copernicus-attend', '"on"'),
	(1, 'friday-copernicus-options', '["center", "planetarium"]'),
	(1, 'friday-social-event', '"on"'),
	(1, 'full-name', '"Michal Paluchowski"'),
	(1, 'home-club', '"Speaking Elephants"'),
	(1, 'lunch', '"on"'),
	(1, 'lunch-days', '["saturday", "sunday"]'),
	(1, 'phone', '"+48888205402"'),
	(1, 'saturday-dinner-meal', '"vegetarian"'),
	(1, 'saturday-dinner-participate', '"on"'),
	(1, 'saturday-party-participate', '"on"'),
	(1, 'translator', '"on"'),
	(2, 'accommodation-with-toastmasters', '"host"'),
	(2, 'country', '"outside"'),
	(2, 'exec-position', '"none"'),
	(2, 'friday-social-event', '"on"'),
	(2, 'full-name', '"John Doe"'),
	(2, 'home-club', '"None"'),
	(2, 'phone', '"+48694470100"'),
	(3, 'accommodation-with-toastmasters', '"independent"'),
	(3, 'contest-attend', '"on"'),
	(3, 'country', '"poland"'),
	(3, 'exec-position', '"vpe"'),
	(3, 'full-name', '"Jane Doe"'),
	(3, 'home-club', '"Speaking Elephants"'),
	(3, 'lunch', '"on"'),
	(3, 'lunch-days', '["saturday"]'),
	(3, 'phone', '"+48 123 456 789"'),
	(4, 'accommodation-with-toastmasters', '"independent"'),
	(4, 'comments', '"I need visa! What is Toastmasters?"'),
	(4, 'country', '"outside"'),
	(4, 'exec-position', '"none"'),
	(4, 'friday-copernicus-attend', '"on"'),
	(4, 'friday-copernicus-options', '["center"]'),
	(4, 'full-name', '"Ibrahim Abdullah"'),
	(4, 'home-club', '"None"'),
	(4, 'phone', '"+33 123 456 789"'),
	(4, 'saturday-dinner-meal', '"vegetarian"'),
	(4, 'saturday-dinner-participate', '"on"'),
	(4, 'translator', '"on"'),
	(5, 'accommodation-with-toastmasters', '"host"'),
	(5, 'country', '"poland"'),
	(5, 'educational-awards', '"DTM"'),
	(5, 'exec-position', '"vpe"'),
	(5, 'friday-social-event', '"on"'),
	(5, 'full-name', '"Maria dos Santos"'),
	(5, 'home-club', '"Top Careers Toastmasters"'),
	(5, 'lunch', '"on"'),
	(5, 'lunch-days', '["saturday"]'),
	(5, 'phone', '"+48234567890"'),
	(5, 'saturday-dinner-meal', '"meat"'),
	(5, 'saturday-dinner-participate', '"on"'),
	(5, 'translator', '"on"');
/*!40000 ALTER TABLE `tli_registration_fields` ENABLE KEYS */;

-- Dumping data for table tli_registrations.tli_transactions: ~1 rows (approximately)
DELETE FROM `tli_transactions`;
/*!40000 ALTER TABLE `tli_transactions` DISABLE KEYS */;
INSERT INTO `tli_transactions` (`session_id`, `fk_registration`, `amount`, `currency`, `order_id`, `method`, `statement`, `date_started`, `date_paid`) VALUES
	('9a9ebbef3f63398c984b71c1f28c0ad1', 1, 169, 'PLN', 18382624, 25, 'ABCD', '2014-11-22 19:00:29', '2014-11-23 08:39:03'),
	('c47045e40c0baf9815c5a12856fb0ce5', 3, 65, 'PLN', NULL, NULL, NULL, '2014-11-23 13:50:05', NULL);
/*!40000 ALTER TABLE `tli_transactions` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
