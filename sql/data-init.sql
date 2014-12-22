/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- Dumping data for table tli_registrations.tli_clubs: ~51 rows (approximately)
DELETE FROM `tli_clubs`;
/*!40000 ALTER TABLE `tli_clubs` DISABLE KEYS */;
INSERT INTO `tli_clubs` (`id_club`, `name`, `division`, `area`) VALUES
	(1, 'Speaking Elephants', 'J', 1),
	(2, 'Toastmasters Polska SA', 'J', 1),
	(3, 'Top Careers Toastmasters Club', 'J', 2),
	(4, 'Silesia Toastmasters', 'B', 1),
	(5, 'Toastmasters Częstochowa', 'B', 1),
	(6, 'Silesia Speech Masters', 'B', 1),
	(7, 'Toastmasters Na Szczycie', 'B', 1),
	(8, 'Krakow Public Speaking Club', 'B', 2),
	(9, 'Toastmasters Kraków', 'B', 2),
	(10, 'Pionier Rzeszów Toastmasters', 'B', 2),
	(11, 'BBH Poland Toastmasters', 'B', 2),
	(12, 'State Street Kraków', 'B', 3),
	(13, 'Toastmasters AGH', 'B', 3),
	(14, 'Toastmasters PK', 'B', 3),
	(15, 'Profesjonalni Mówcy i Liderzy', 'B', 3),
	(16, 'Sokrates Toruń', 'E', 1),
	(17, 'Toastmasters Bydgoszcz', 'E', 1),
	(18, 'Grudziądz Toastmasters', 'E', 1),
	(19, 'Toruń Toastmasters', 'E', 1),
	(20, 'Bydgoszcz Toastmasters Professionals', 'E', 1),
	(21, 'Tricity Toastmasters', 'E', 2),
	(22, 'Toastmasters Gdańsk', 'E', 2),
	(23, 'Toastmasters Sopot Leaders', 'E', 2),
	(24, 'Toastmasters Olsztyn', 'E', 2),
	(25, 'Toastmasters Gdynia', 'E', 2),
	(26, 'Toastmasters Szczecin Passionate Speakers', 'E', 3),
	(27, 'Sedina Toastmasters', 'E', 3),
	(28, 'Toastmasters Poznań', 'E', 3),
	(29, 'Verbal Victory', 'E', 3),
	(30, 'Lodz Toastmasters', 'J', 1),
	(31, 'The Leader Ship', 'J', 1),
	(32, 'Toastmasters w Orange', 'J', 1),
	(33, 'Shall We Speak?', 'J', 1),
	(34, 'Toastmasters Lublin', 'J', 2),
	(35, 'Toastmasters Leaders', 'J', 2),
	(36, 'Toastmasters Białystok', 'J', 2),
	(37, 'Toastmasters @ EDC', 'J', 2),
	(38, 'ASBIRO Toastmasters', 'J', 2),
	(39, 'Vistula Toastmasters Leaders', 'J', 2),
	(40, 'WrocLove Toastmasters PL', 'J', 3),
	(41, 'Toast @ Capgemini', 'J', 3),
	(42, 'WrocLove Speakers', 'J', 3),
	(43, 'Toastmasters Premium', NULL, NULL),
	(44, 'Toastmasters Centrum', NULL, NULL),
	(45, 'Toastmasters Opole', NULL, NULL),
	(46, 'Rednerfabrik Toastmasters', NULL, NULL),
	(47, 'Lift-Off Toastmasters', NULL, NULL),
	(48, 'Toastmasters Rzeszów', NULL, NULL),
	(49, 'Brave Up Toastmasters', NULL, NULL),
	(50, 'POZnaj Toastmasters', 'E', 3),
	(51, 'HSBC Krakow Toastmasters Club', 'B', 2);
/*!40000 ALTER TABLE `tli_clubs` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
