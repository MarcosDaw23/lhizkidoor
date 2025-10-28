-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.2.0 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para lhizki
CREATE DATABASE IF NOT EXISTS `lhizki` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `lhizki`;

-- Volcando estructura para tabla lhizki.centro
CREATE TABLE IF NOT EXISTS `centro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.centro: ~0 rows (aproximadamente)
INSERT IGNORE INTO `centro` (`id`, `nombre`) VALUES
	(1, 'san luis');

-- Volcando estructura para tabla lhizki.centro_sector
CREATE TABLE IF NOT EXISTS `centro_sector` (
  `id` int NOT NULL AUTO_INCREMENT,
  `centro` int DEFAULT NULL,
  `sector` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `centro_centro_sector` (`centro`),
  KEY `sector_centro_sector` (`sector`),
  CONSTRAINT `centro_centro_sector` FOREIGN KEY (`centro`) REFERENCES `centro` (`id`),
  CONSTRAINT `sector_centro_sector` FOREIGN KEY (`sector`) REFERENCES `sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.centro_sector: ~9 rows (aproximadamente)
INSERT IGNORE INTO `centro_sector` (`id`, `centro`, `sector`) VALUES
	(1, 1, 6),
	(2, 1, 8),
	(3, 1, 5),
	(4, 1, 3),
	(5, 1, 1),
	(6, 1, 4),
	(7, 1, 2),
	(8, 1, 9),
	(9, 1, 7);

-- Volcando estructura para tabla lhizki.clases
CREATE TABLE IF NOT EXISTS `clases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sector` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_clases_sectores` (`sector`),
  CONSTRAINT `FK_clases_sectores` FOREIGN KEY (`sector`) REFERENCES `sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.clases: ~18 rows (aproximadamente)
INSERT IGNORE INTO `clases` (`id`, `sector`, `nombre`) VALUES
	(1, 1, 'primero ASIR '),
	(2, 1, 'segundo ASIR'),
	(3, 2, 'primero DAW'),
	(4, 2, 'segundo DAW'),
	(5, 3, 'primero SMR'),
	(6, 3, 'segundo SMR'),
	(7, 4, 'primero AyF'),
	(8, 4, 'segundo AyF'),
	(9, 5, 'primero GA'),
	(10, 5, 'segundo GA'),
	(11, 6, 'primero SA'),
	(12, 6, 'segundo SA'),
	(13, 7, 'primero MyP'),
	(14, 7, 'segundo MyP'),
	(15, 8, 'primero AC'),
	(16, 8, 'segundo AC'),
	(17, 9, 'primero IS'),
	(18, 9, 'segundo IS');

-- Volcando estructura para tabla lhizki.diccionario
CREATE TABLE IF NOT EXISTS `diccionario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rama` int DEFAULT NULL,
  `cast` varchar(250) DEFAULT NULL,
  `eusk1` varchar(250) DEFAULT NULL,
  `eusk2` varchar(250) DEFAULT NULL,
  `eusk3` varchar(250) DEFAULT NULL,
  `ondo` int DEFAULT NULL,
  `definicion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rama_diccionario` (`rama`),
  CONSTRAINT `rama_diccionario` FOREIGN KEY (`rama`) REFERENCES `ramas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.diccionario: ~120 rows (aproximadamente)
INSERT IGNORE INTO `diccionario` (`id`, `rama`, `cast`, `eusk1`, `eusk2`, `eusk3`, `ondo`, `definicion`) VALUES
	(1, 1, 'ámbito de uso', 'erabileraeremu', 'erabilera-eremu', 'erabilera-ezparru', 2, 'A'),
	(2, 1, 'alinear', 'lerrokatu', 'errokatu', 'berdindu', 1, 'a'),
	(3, 1, 'auditoría interna', 'barne-auditoria', 'kanpo-auditoria', 'barneauditoria', 1, 'a'),
	(4, 1, 'búsqueda', 'kontaketa', 'bilaketa', 'bilatu', 2, 'a'),
	(5, 1, 'celda', 'gelaxka', 'zutabe', 'zelda', 1, 'a'),
	(6, 1, 'código', 'seinale', 'kode', 'arau', 2, 'a'),
	(7, 1, 'criterio general', 'baldintza', 'ikuspegi', 'irizpide orokor', 3, 'a'),
	(8, 1, 'dato de tráfico', 'zirkulazio-kontrol', 'seinale-datu', 'zirkulazio-datu', 3, 'a'),
	(9, 1, 'deterioro grave', 'narriadura larri', 'kalte arina', 'higadura', 1, 'a'),
	(10, 1, 'dirección', 'helbide', 'bide', 'kokapen', 1, 'a'),
	(11, 1, 'enlace', 'esteka', 'lokarri', 'hari', 1, 'a'),
	(12, 1, 'escritorio', 'bulego', 'mahai', 'mahaigain', 3, 'a'),
	(13, 1, 'estructura', 'eraikuntza', 'egitura', 'osaketa', 2, 'a'),
	(14, 1, 'extensión', 'handipen', 'luzapen', 'osagarri', 2, 'a'),
	(15, 1, 'fila', 'zutabe', 'errenkada', 'multzo', 2, 'a'),
	(16, 1, 'hoja de contenido', 'eduki-orri', 'aurkibide', 'eskuliburu', 1, 'a'),
	(17, 1, 'host', 'arduraduna', 'ostalari', 'ostatu', 2, 'a'),
	(18, 1, 'inteligencia artificial', 'adimen natural', 'adimen-natural', 'adimen artifizial', 3, 'a'),
	(19, 1, 'lenguaje asp', 'asp-lengoaia', 'asp lengoaia', 'asp lingoaia', 2, 'a'),
	(20, 1, 'librería', 'fitxategi', 'liburutegi', 'biltegi', 2, 'a'),
	(21, 1, 'lista', 'zerrenda', 'multzo', 'erregistro', 1, 'a'),
	(22, 1, 'marcador', 'fitxa', 'markatzaile', 'indikatzaile', 2, 'a'),
	(23, 1, 'nivel de suelo', 'zoru-maila', 'soru-maila', 'maila altua', 1, 'a'),
	(24, 1, 'norma general', 'arau orokor', 'arau zehatz', 'irizpide orokor', 1, 'a'),
	(25, 1, 'operador', 'erabiltzaile', 'kudeatzaile', 'eragile', 3, 'a'),
	(26, 1, 'página', 'dokumentu', 'fitxa', 'orri', 3, 'a'),
	(27, 1, 'página principal', 'sarrera', 'atari', 'orri nagusi', 3, 'a'),
	(28, 1, 'palabra clave', 'gako-hitz', 'pasahitz', 'seinale', 1, 'a'),
	(29, 1, 'puerto', 'ataka', 'ibilbide', 'atal', 1, 'a'),
	(30, 1, 'ratón', 'botoi', 'sagu', 'teklatu', 2, 'a'),
	(31, 2, 'absorción', 'irenspen', 'iragazketa', 'pilaketa', 1, 'a'),
	(32, 2, 'acreedor', 'hartzekodun', 'ordaintzaile', 'zorpetu', 1, 'aa'),
	(33, 2, 'actividad', 'ekintza', 'jarduera', 'lana', 2, 'a'),
	(34, 2, 'antigüedad', 'historia', 'antsinatasun', 'antzinatasun', 3, 'a'),
	(35, 2, 'apartado', 'eremu', 'atal', 'kutxa', 2, 'a'),
	(36, 2, 'asiento de ajuste', 'doikuntza-idazpen', 'kontu-lerro', 'erregistro', 1, 'a'),
	(37, 2, 'auditoría', 'azterketa', 'berrikuspen', 'ikuskaritza', 3, 'a'),
	(38, 2, 'autorización', 'baimen', 'agindu', 'ziurtagiri', 1, 'a'),
	(39, 2, 'base', 'oinarri', 'azpiegitura', 'hondo', 1, 'a'),
	(40, 2, 'base imponible', 'zerga-kuota', 'zerga-oinarri', 'tasa-maila', 2, 'a'),
	(41, 2, 'beneficio', 'sarrera', 'gastu', 'etekin', 3, 'a'),
	(42, 2, 'bien', 'ondasun', 'zerbitzu', 'produktu', 1, 'a'),
	(43, 2, 'bolsa', 'burtsa', 'karpeta', 'pakete', 1, 'a'),
	(44, 2, 'caja', 'kutxa', 'poltsa', 'karpeta', 1, 'a'),
	(45, 2, 'carta', 'agiri', 'gutun', 'nota', 2, 'a'),
	(46, 2, 'CIF', 'IFK', 'NAN', 'KPI', 1, 'a'),
	(47, 2, 'cliente', 'erabiltzaile', 'hornitzaile', 'bezero', 3, 'a'),
	(48, 2, 'cobertura', 'estaldura', 'hedadura', 'aseguramendu', 1, 'a'),
	(49, 2, 'comercio', 'merkataritza', 'industria', 'negozio', 1, 'a'),
	(50, 2, 'compra', 'eskaintza', 'erosketa', 'kontratazio', 2, 'a'),
	(51, 2, 'concesión', 'lizentzia', 'kontratu', 'emakida', 3, 'a'),
	(52, 2, 'convenio', 'kontratu', 'hitzarmen', 'araudi', 2, 'a'),
	(53, 2, 'cónyuge', 'senide', 'ezkontide', 'lagun', 2, 'a'),
	(54, 2, 'corte', 'ebaki', 'txanda', 'banaketa', 1, 'a'),
	(55, 2, 'departamento', 'sail', 'unitate', 'bulego', 1, 'a'),
	(56, 2, 'depósito', 'biltegi', 'fondo', 'gordailu', 3, 'a'),
	(57, 2, 'deuda', 'gastu', 'zor', 'kreditu', 2, 'a'),
	(58, 2, 'día natural', 'lanegun', 'egun natural', 'jai-egun', 2, 'a'),
	(59, 2, 'discapacidad', 'mugikortasun', 'ezintasun', 'ezintasun', 2, 'a'),
	(60, 2, 'ejercicio', 'ekitaldi', 'jarduera', 'saio', 1, 'a'),
	(61, 3, 'acogida', 'harrera', 'laguntza', 'topaketa', 1, 'aa'),
	(62, 3, 'actitud', 'izaera', 'jarrera', 'ohitura', 2, 'a'),
	(63, 3, 'adaptación', 'egokitzapen', 'aldaketa', 'prestaketa', 1, 'a'),
	(64, 3, 'adolescente', 'haur', 'gazte', 'nerabe', 3, 'a'),
	(65, 3, 'agresión', 'gatazka', 'eraso', 'eztabaida', 2, 'a'),
	(66, 3, 'alimentación', 'otordu', 'elikadura', 'sukaldaritza', 2, 'a'),
	(67, 3, 'alojamiento', 'ostatu', 'gela', 'gelaxka', 1, 'aa'),
	(68, 3, 'alumnado', 'ikastaro', 'klase', 'ikasle', 3, 'a'),
	(69, 3, 'amenaza', 'beldur', 'mehatxu', 'zigor', 2, 'a'),
	(70, 3, 'amistad', 'harreman', 'adiskidetasun', 'senidetasun', 2, 'a'),
	(71, 3, 'apego', 'harreman', 'maitasun', 'atxikimendu', 3, 'a'),
	(72, 3, 'apoyo', 'laguntza', 'sendotasun', 'konfiantza', 1, 'a'),
	(73, 3, 'asesoramiento', 'prestakuntza', 'ikasketa', 'aholkularitza', 3, 'a'),
	(74, 3, 'aula', 'klase', 'ikastoki', 'gela', 3, 'a'),
	(75, 3, 'barrio', 'auzo', 'herri', 'hiri', 1, 'a'),
	(76, 3, 'bienestar', 'ongisate', 'ongizate', 'lasaitasun', 2, 'a'),
	(77, 3, 'canica', 'pustarri', 'puxtarri', 'puxtaharri', 2, 'a'),
	(78, 3, 'carnaval', 'hinauteri', 'ihinauteri', 'inauteri', 3, 'a'),
	(79, 3, 'cesión', 'salmenta', 'lagapen', 'transferentzia', 2, 'a'),
	(80, 3, 'conducta', 'jarrera', 'ohitura', 'harrera', 1, 'a'),
	(81, 3, 'conferencia', 'hitzaldi', 'bilera', 'aurkezpen', 1, 'a'),
	(82, 3, 'conflicto', 'borroka', 'tentsio', 'gatazka', 3, 'a'),
	(83, 3, 'creatividad', 'sormen', 'adimen', 'inspirazio', 1, 'a'),
	(84, 3, 'crecimiento', 'hazkuntza', 'garapen', 'azkuntza', 1, 'a'),
	(85, 3, 'cuento', 'histori', 'ipuin', 'historia', 2, 'a'),
	(86, 3, 'cuidado', 'zaintza', 'laguntza', 'prebentzio', 1, 'a'),
	(87, 3, 'cuna', 'sehaska', 'seaska', 'zehaska', 1, 'a'),
	(88, 3, 'curso', 'ikastaro', 'ikasgai', 'ikasketa', 1, 'a'),
	(89, 3, 'dependencia', 'mendekotazun', 'mendekotasun', 'erlazio', 2, 'a'),
	(90, 3, 'derecho', 'arau', 'eskubide', 'ezkubide', 2, 'a'),
	(91, 4, 'variabilidad', 'aldakortasun', 'aldekortasun', 'egonkortasun', 1, 'a'),
	(92, 4, 'inseparabilidad', 'banaestazun', 'banaezintasun', 'bateragarritasun', 2, 'a'),
	(93, 4, 'novedad', 'ohikotasun', 'berritasun', 'berritazun', 2, 'a'),
	(94, 4, 'declive', 'ganbehera', 'gainbehera', 'gorakada', 2, 'a'),
	(95, 4, 'madurez', 'gaztetasun', 'gastetasun', 'heldutasun', 3, 'a'),
	(96, 4, 'caducidad', 'galkortasun', 'iraunkortasun', 'iraungitasun', 1, 'a'),
	(97, 4, 'imagen de marca', 'marka-irudi', 'markairudi', 'marka-izudi', 1, 'a'),
	(98, 4, 'lanzamiento', 'merkataritza', 'merkaturatze', 'merkaturazte', 2, 'a'),
	(99, 4, 'prueba', 'probaze', 'saiakuntza', 'probatze', 3, 'a'),
	(100, 4, 'producto cautivo', 'produktogaitibu', 'produktu lotu', 'produktu gatibu', 3, 'a'),
	(101, 4, 'servicio posventa', 'salduosteko laguntza', 'saldu osteko zerbitzu', 'saldu osteko arreta', 2, 'a'),
	(102, 4, 'intangibilidad', 'ukigarritasun', 'hukiezintasun', 'ukiezintasun', 3, 'a'),
	(103, 4, 'sobreprecio', 'gehigarri', 'gainprezio', 'gainkostu', 2, 'a'),
	(104, 4, 'fijación de precios', 'prezio-ezarpen', 'prezioen kontrola', 'prezio-politika', 1, 'a'),
	(105, 4, 'precio promocional', 'sustapen-prezio', 'eskaintza berezi', 'deskontu-prezio', 1, 'a'),
	(106, 4, 'distribución', 'zabalpena', 'banaketa', 'sabalpena', 2, 'a'),
	(107, 4, 'distribuidor', 'hornitzaile', 'bitartekari', 'banatzaile', 3, 'a'),
	(108, 4, 'intermediario', 'agente', 'ordezkari', 'bitartekari', 3, 'a'),
	(109, 4, 'cadena de tiendas', 'denda-kate', 'denda multzo', 'dendakate', 1, 'a'),
	(110, 4, 'escaparate', 'erakusleiho', 'erakusgela', 'erakusleio', 1, 'a'),
	(111, 4, 'mayorista', 'enpresari', 'handizkari', 'saltzaile', 2, 'a'),
	(112, 4, 'conflicto', 'eztabaida', 'gatazka', 'gataska', 2, 'a'),
	(113, 4, 'venta a granel', 'saltze', 'solteko salmeta', 'soltako salmeta', 2, 'a'),
	(114, 4, 'minorista', 'txikizkari', 'txikiskari', 'denda-kudeatzaile', 1, 'a'),
	(115, 4, 'DAFO', 'AIMA', 'AMYA', 'AMIA', 3, 'a'),
	(116, 4, 'imagen', 'irudi', 'ikuspegi', 'iduri', 1, 'a'),
	(117, 4, 'receptor', 'hartzaile', 'jasotzaile', 'entzule', 1, 'a'),
	(118, 4, 'promoción', 'publizitate', 'kanpaina', 'sustapen', 3, 'a'),
	(119, 4, 'ruido', 'zarata', 'oihu', 'sarata', 1, 'a'),
	(120, 4, 'cliente', 'erosle', 'bezero', 'hornitzaile', 2, 'a');

-- Volcando estructura para tabla lhizki.eventos
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.eventos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla lhizki.glosario
CREATE TABLE IF NOT EXISTS `glosario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rama` int NOT NULL,
  `cast` varchar(100) NOT NULL,
  `eusk` varchar(100) NOT NULL,
  `definicion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.glosario: ~0 rows (aproximadamente)
INSERT IGNORE INTO `glosario` (`id`, `rama`, `cast`, `eusk`, `definicion`) VALUES
	(1, 1, 'ámbito de uso', 'erabilera-eremu', 'A'),
	(2, 1, 'alinear', 'lerrokatu', 'A'),
	(3, 1, 'auditoría interna', 'barne-auditoria', 'A'),
	(4, 1, 'búsqueda', 'bilaketa', 'A'),
	(5, 1, 'celda', 'gelaxka', 'A'),
	(6, 1, 'código', 'kode', 'A'),
	(7, 1, 'criterio general', 'irizpide orokor', 'A'),
	(8, 1, 'dato de tráfico', 'zirkulazio-datu', 'A'),
	(9, 1, 'deterioro grave', 'narriadura larri', 'A'),
	(10, 1, 'dirección', 'helbide', 'A'),
	(11, 1, 'enlace', 'esteka', 'A'),
	(12, 1, 'escritorio', 'mahaigain', 'A'),
	(13, 1, 'estructura', 'egitura', 'A'),
	(14, 1, 'extensión', 'luzapen', 'A'),
	(15, 1, 'fila', 'errenkada', 'A'),
	(16, 1, 'hoja de contenido', 'eduki-orri', 'A'),
	(17, 1, 'host', 'ostalari', 'A'),
	(18, 1, 'inteligencia artificial', 'adimen artifizial', 'A'),
	(19, 1, 'lenguaje asp', 'asp lengoaia', 'A'),
	(20, 1, 'librería', 'liburutegi', 'A'),
	(21, 1, 'lista', 'zerrenda', 'A'),
	(22, 1, 'marcador', 'markatzaile', 'A'),
	(23, 1, 'nivel de suelo', 'zoru-maila', 'A'),
	(24, 1, 'norma general', 'arau orokor', 'A'),
	(25, 1, 'operador', 'eragile', 'A'),
	(26, 1, 'página', 'orri', 'A'),
	(27, 1, 'página principal', 'orri nagusi', 'A'),
	(28, 1, 'palabra clave', 'gako-hitz', 'A'),
	(29, 1, 'puerto', 'ataka', 'A'),
	(30, 1, 'ratón', 'sagu', 'A'),
	(31, 2, 'absorción', 'irenspen', 'A'),
	(32, 2, 'acreedor', 'hartzekodun', 'A'),
	(33, 2, 'actividad', 'jarduera', 'A'),
	(34, 2, 'antigüedad', 'antzinatasun', 'A'),
	(35, 2, 'apartado', 'atal', 'A'),
	(36, 2, 'asiento de ajuste', 'doikuntza-idazpen', 'A'),
	(37, 2, 'auditoría', 'ikuskaritza', 'A'),
	(38, 2, 'autorización', 'baimen', 'A'),
	(39, 2, 'base', 'oinarri', 'A'),
	(40, 2, 'base imponible', 'zerga-oinarri', 'A'),
	(41, 2, 'beneficio', 'etekin', 'A'),
	(42, 2, 'bien', 'ondasun', 'A'),
	(43, 2, 'bolsa', 'burtsa', 'A'),
	(44, 2, 'caja', 'kutxa', 'A'),
	(45, 2, 'carta', 'gutun', 'A'),
	(46, 2, 'CIF', 'IFK', 'A'),
	(47, 2, 'cliente', 'bezero', 'A'),
	(48, 2, 'cobertura', 'estaldura', 'A'),
	(49, 2, 'comercio', 'merkataritza', 'A'),
	(50, 2, 'compra', 'erosketa', 'A'),
	(51, 2, 'concesión', 'emakida', 'A'),
	(52, 2, 'convenio', 'hitzarmen', 'A'),
	(53, 2, 'cónyuge', 'ezkontide', 'A'),
	(54, 2, 'corte', 'ebaki', 'A'),
	(55, 2, 'departamento', 'sail', 'A'),
	(56, 2, 'depósito', 'gordailu', 'A'),
	(57, 2, 'deuda', 'zor', 'A'),
	(58, 2, 'día natural', 'egun natural', 'A'),
	(59, 2, 'discapacidad', 'ezintasun', 'A'),
	(60, 2, 'ejercicio', 'ekitaldi', 'A'),
	(61, 3, 'acogida', 'harrera', 'A'),
	(62, 3, 'actitud', 'jarrera', 'A'),
	(63, 3, 'adaptación', 'egokitzapen', 'A'),
	(64, 3, 'adolescente', 'nerabe', 'A'),
	(65, 3, 'agresión', 'eraso', 'A'),
	(66, 3, 'alimentación', 'elikadura', 'A'),
	(67, 3, 'alojamiento', 'ostatu', 'A'),
	(68, 3, 'alumnado', 'ikasle', 'A'),
	(69, 3, 'amenaza', 'mehatxu', 'A'),
	(70, 3, 'amistad', 'adiskidetasun', 'A'),
	(71, 3, 'apego', 'atxikimendu', 'A'),
	(72, 3, 'apoyo', 'laguntza', 'A'),
	(73, 3, 'asesoramiento', 'aholkularitza', 'A'),
	(74, 3, 'aula', 'gela', 'A'),
	(75, 3, 'barrio', 'auzo', 'A'),
	(76, 3, 'bienestar', 'ongizate', 'A'),
	(77, 3, 'canica', 'puxtarri', 'A'),
	(78, 3, 'carnaval', 'inauteri', 'A'),
	(79, 3, 'cesión', 'lagapen', 'A'),
	(80, 3, 'conducta', 'jarrera', 'A'),
	(81, 3, 'conferencia', 'hitzaldi', 'A'),
	(82, 3, 'conflicto', 'gatazka', 'A'),
	(83, 3, 'creatividad', 'sormen', 'A'),
	(84, 3, 'crecimiento', 'hazkuntza', 'A'),
	(85, 3, 'cuento', 'ipuin', 'A'),
	(86, 3, 'cuidado', 'zaintza', 'A'),
	(87, 3, 'cuna', 'sehaska', 'A'),
	(88, 3, 'curso', 'ikastaro', 'A'),
	(89, 3, 'dependencia', 'mendekotasun', 'A'),
	(90, 3, 'derecho', 'eskubide', 'A'),
	(91, 4, 'variabilidad', 'aldakortasun', 'A'),
	(92, 4, 'inseparabilidad', 'banaezintasun', 'A'),
	(93, 4, 'novedad', 'berritasun', 'A'),
	(94, 4, 'declive', 'gainbehera', 'A'),
	(95, 4, 'madurez', 'heldutasun', 'A'),
	(96, 4, 'caducidad', 'galkortasun', 'A'),
	(97, 4, 'imagen de marca', 'marka-irudi', 'A'),
	(98, 4, 'lanzamiento', 'merkaturatze', 'A'),
	(99, 4, 'prueba', 'probatze', 'A'),
	(100, 4, 'producto cautivo', 'produktu gatibu', 'A'),
	(101, 4, 'servicio posventa', 'saldu osteko zerbitzu', 'A'),
	(102, 4, 'intangibilidad', 'ukiezintasun', 'A'),
	(103, 4, 'sobreprecio', 'gainprezio', 'A'),
	(104, 4, 'fijación de precios', 'prezio-ezarpen', 'A'),
	(105, 4, 'precio promocional', 'sustapen-prezio', 'A'),
	(106, 4, 'distribución', 'banaketa', 'A'),
	(107, 4, 'distribuidor', 'banatzaile', 'A'),
	(108, 4, 'intermediario', 'bitartekari', 'A'),
	(109, 4, 'cadena de tiendas', 'denda-kate', 'A'),
	(110, 4, 'escaparate', 'erakusleiho', 'A'),
	(111, 4, 'mayorista', 'handizkari', 'A'),
	(112, 4, 'conflicto', 'gatazka', 'A'),
	(113, 4, 'venta a granel', 'solteko salmeta', 'A'),
	(114, 4, 'minorista', 'txikizkari', 'A'),
	(115, 4, 'DAFO', 'AMIA', 'A'),
	(116, 4, 'imagen', 'irudi', 'A'),
	(117, 4, 'receptor', 'hartzaile', 'A'),
	(118, 4, 'promoción', 'sustapen', 'A'),
	(119, 4, 'ruido', 'zarata', 'A'),
	(120, 4, 'cliente', 'bezero', 'A');

-- Volcando estructura para tabla lhizki.juegos
CREATE TABLE IF NOT EXISTS `juegos` (
  `Columna 1` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.juegos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla lhizki.partidas
CREATE TABLE IF NOT EXISTS `partidas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `semana` int DEFAULT NULL,
  `fechaInicio` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.partidas: ~0 rows (aproximadamente)
INSERT IGNORE INTO `partidas` (`id`, `semana`, `fechaInicio`) VALUES
	(1, 44, '2025-10-28 08:29:08');

-- Volcando estructura para tabla lhizki.partida_user
CREATE TABLE IF NOT EXISTS `partida_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `partida_id` int DEFAULT NULL,
  `puntuacion` int DEFAULT '0',
  `fechaJugada` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `partida_id` (`partida_id`),
  CONSTRAINT `partida_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `partida_user_ibfk_2` FOREIGN KEY (`partida_id`) REFERENCES `partidas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.partida_user: ~0 rows (aproximadamente)
INSERT IGNORE INTO `partida_user` (`id`, `user_id`, `partida_id`, `puntuacion`, `fechaJugada`) VALUES
	(1, 1, 3, 0, '2025-10-28 08:28:00'),
	(3, 2, 1, 0, '2025-10-28 09:21:31'),
	(5, 1, 1, 0, '2025-10-28 09:56:05'),
	(6, 1, 1, 50, '2025-10-28 09:56:27');

-- Volcando estructura para tabla lhizki.ramas
CREATE TABLE IF NOT EXISTS `ramas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `puntuacionRamas` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.ramas: ~4 rows (aproximadamente)
INSERT IGNORE INTO `ramas` (`id`, `nombre`, `puntuacionRamas`) VALUES
	(1, 'Administardcion y gestion   ', 2000),
	(2, 'comercio y marketing', 3000),
	(3, 'informatica y comunicaciones', 4000),
	(4, 'servicio socioculturales y a la comunidad', 5000);

-- Volcando estructura para tabla lhizki.ranking
CREATE TABLE IF NOT EXISTS `ranking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rama` int DEFAULT NULL,
  `clase` int DEFAULT NULL,
  `sector` int DEFAULT NULL,
  `puntuacionRanking` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rama_ranking` (`rama`),
  KEY `clase_ranking` (`clase`),
  KEY `sector_ranking` (`sector`),
  CONSTRAINT `clase_ranking` FOREIGN KEY (`clase`) REFERENCES `clases` (`id`),
  CONSTRAINT `rama_ranking` FOREIGN KEY (`rama`) REFERENCES `ramas` (`id`),
  CONSTRAINT `sector_ranking` FOREIGN KEY (`sector`) REFERENCES `sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.ranking: ~18 rows (aproximadamente)
INSERT IGNORE INTO `ranking` (`id`, `rama`, `clase`, `sector`, `puntuacionRanking`) VALUES
	(7, 3, 1, 1, NULL),
	(8, 3, 2, 1, NULL),
	(9, 3, 3, 2, NULL),
	(10, 3, 4, 2, NULL),
	(11, 3, 5, 3, NULL),
	(12, 3, 6, 3, NULL),
	(13, 1, 7, 4, NULL),
	(14, 1, 8, 4, NULL),
	(15, 1, 9, 5, NULL),
	(16, 1, 10, 5, NULL),
	(17, 1, 11, 6, NULL),
	(18, 1, 12, 6, NULL),
	(19, 2, 13, 7, NULL),
	(20, 2, 14, 7, NULL),
	(21, 2, 15, 8, NULL),
	(22, 2, 16, 8, NULL),
	(23, 4, 17, 9, NULL),
	(24, 4, 18, 9, NULL);

-- Volcando estructura para tabla lhizki.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.roles: ~3 rows (aproximadamente)
INSERT IGNORE INTO `roles` (`id`, `rol`) VALUES
	(1, 'Admin'),
	(2, 'Profesor'),
	(3, 'Usuario');

-- Volcando estructura para tabla lhizki.sectores
CREATE TABLE IF NOT EXISTS `sectores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rama` int DEFAULT NULL,
  `puntuacionTotal` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rama_sectores` (`rama`),
  CONSTRAINT `rama_sectores` FOREIGN KEY (`rama`) REFERENCES `ramas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.sectores: ~9 rows (aproximadamente)
INSERT IGNORE INTO `sectores` (`id`, `nombre`, `rama`, `puntuacionTotal`) VALUES
	(1, 'Grado Superior en Administración de Sistemas Informáticos en Red', 3, 111),
	(2, 'Grado Superior en Desarrollo de Aplicaciones Web', 3, 322),
	(3, 'Grado Medio en Sistemas Microinformáticos y Redes', 3, 333),
	(4, 'Grado Superior en Administración y finanzas ', 1, 444),
	(5, 'Grado Medio en Gestión Administrativa', 1, 555),
	(6, 'Grado Inicial en Servicios Administrativos', 1, 666),
	(7, 'Grado Superior en Marketing y Publicidad', 2, 777),
	(8, 'Grado Medio en Actividades Comerciales', 2, 888),
	(9, 'Grado Superior en Integración Social ', 4, 999);

-- Volcando estructura para tabla lhizki.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `centro` int DEFAULT NULL,
  `sector` int DEFAULT NULL,
  `clase` int DEFAULT NULL,
  `puntuacionIndividual` int DEFAULT '0',
  `token` varchar(50) DEFAULT NULL,
  `fechaConfirmacion` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rol` (`rol`),
  KEY `centro_user` (`centro`),
  KEY `clase_user` (`clase`),
  KEY `sector_user` (`sector`),
  CONSTRAINT `centro_user` FOREIGN KEY (`centro`) REFERENCES `centro` (`id`),
  CONSTRAINT `clase_user` FOREIGN KEY (`clase`) REFERENCES `clases` (`id`),
  CONSTRAINT `rol` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`),
  CONSTRAINT `sector_user` FOREIGN KEY (`sector`) REFERENCES `sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.user: ~1 rows (aproximadamente)
INSERT IGNORE INTO `user` (`id`, `rol`, `nombre`, `apellido`, `mail`, `password`, `centro`, `sector`, `clase`, `puntuacionIndividual`, `token`, `fechaConfirmacion`) VALUES
	(1, 3, 'juan', 'puertas', 'juanpu2004@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 1, 2, 4, 50, NULL, '2025-10-27'),
	(2, 3, 'Marcos', 'Brian', 'marcbaraka20@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 1, 2, 4, 0, NULL, '2025-10-28');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
