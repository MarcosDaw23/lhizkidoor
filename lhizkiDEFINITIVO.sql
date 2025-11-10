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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.centro: ~0 rows (aproximadamente)
INSERT INTO `centro` (`id`, `nombre`) VALUES
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
INSERT INTO `centro_sector` (`id`, `centro`, `sector`) VALUES
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
  CONSTRAINT `FK_clases_centro_sector` FOREIGN KEY (`sector`) REFERENCES `centro_sector` (`sector`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.clases: ~18 rows (aproximadamente)
INSERT INTO `clases` (`id`, `sector`, `nombre`) VALUES
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
  `definicion` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rama_diccionario` (`rama`),
  CONSTRAINT `rama_diccionario` FOREIGN KEY (`rama`) REFERENCES `ramas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.diccionario: ~120 rows (aproximadamente)
INSERT INTO `diccionario` (`id`, `rama`, `cast`, `eusk1`, `eusk2`, `eusk3`, `ondo`, `definicion`) VALUES
	(1, 1, 'ámbito de uso', 'erabileraeremu', 'erabilera-eremu', 'erabilera-ezparru', 2, 'Contexto o entorno en el que se aplica un sistema, software o tecnología.'),
	(2, 1, 'alinear', 'lerrokatu', 'errokatu', 'berdindu', 1, 'Ajustar elementos (texto, datos, código) para que tengan una disposición uniforme y ordenada.'),
	(3, 1, 'auditoría interna', 'barne-auditoria', 'kanpo-auditoria', 'barneauditoria', 1, 'Revisión sistemática de procesos, sistemas o códigos dentro de una organización para asegurar calidad y cumplimiento.'),
	(4, 1, 'búsqueda', 'kontaketa', 'bilaketa', 'bilatu', 2, 'Proceso de localizar información específica dentro de bases de datos, documentos o internet.'),
	(5, 1, 'celda', 'gelaxka', 'zutabe', 'zelda', 1, 'Unidad básica en hojas de cálculo o bases de datos, donde se almacenan datos individuales.'),
	(6, 1, 'código', 'seinale', 'kode', 'arau', 2, 'Conjunto de instrucciones escritas en un lenguaje de programación que una computadora puede ejecutar.'),
	(7, 1, 'criterio general', 'baldintza', 'ikuspegi', 'irizpide orokor', 3, 'Norma o regla estándar que se aplica para tomar decisiones o evaluar algo en sistemas o procesos.'),
	(8, 1, 'dato de tráfico', 'zirkulazio-kontrol', 'seinale-datu', 'zirkulazio-datu', 3, 'Información relacionada con el flujo de datos en redes o sistemas, como volumen o velocidad.'),
	(9, 1, 'deterioro grave', 'narriadura larri', 'kalte arina', 'higadura', 1, 'Estado en el que un sistema o hardware presenta fallas significativas que afectan su funcionamiento.'),
	(10, 1, 'dirección', 'helbide', 'bide', 'kokapen', 1, 'Identificador único que permite localizar un recurso en una red o memoria (por ejemplo, dirección IP).'),
	(11, 1, 'enlace', 'esteka', 'lokarri', 'hari', 1, 'Conexión física o lógica que permite la comunicación entre dos dispositivos o nodos en una red.'),
	(12, 1, 'escritorio', 'bulego', 'mahai', 'mahaigain', 3, 'Área de trabajo gráfica en un sistema operativo donde se gestionan archivos y aplicaciones.'),
	(13, 1, 'estructura', 'eraikuntza', 'egitura', 'osaketa', 2, 'Organización o formato de datos, archivos o código para facilitar su gestión y acceso.'),
	(14, 1, 'extensión', 'handipen', 'luzapen', 'osagarri', 2, 'Sufijo en el nombre de un archivo que indica su tipo o formato (por ejemplo, .txt, .jpg).'),
	(15, 1, 'fila', 'zutabe', 'errenkada', 'multzo', 2, 'Conjunto horizontal de elementos en tablas, hojas de cálculo o bases de datos.'),
	(16, 1, 'hoja de contenido', 'eduki-orri', 'aurkibide', 'eskuliburu', 1, 'Documento o sección que organiza y muestra índices o temas de manera estructurada.'),
	(17, 1, 'host', 'arduraduna', 'ostalari', 'ostatu', 2, 'Dispositivo o sistema que proporciona servicios o recursos en una red.'),
	(18, 1, 'inteligencia artificial', 'adimen natural', 'adimen-natural', 'adimen artifizial', 3, 'Tecnología que permite a las máquinas simular procesos cognitivos humanos, como aprendizaje y razonamiento.'),
	(19, 1, 'lenguaje asp', 'asp-lengoaia', 'asp lengoaia', 'asp lingoaia', 2, 'Lenguaje de programación y tecnología para crear páginas web dinámicas del lado del servidor (Active Server Pages).'),
	(20, 1, 'librería', 'fitxategi', 'liburutegi', 'biltegi', 2, 'Conjunto de funciones o rutinas predefinidas que pueden ser usadas por programas para facilitar tareas comunes.'),
	(21, 1, 'lista', 'zerrenda', 'multzo', 'erregistro', 1, 'Estructura de datos o conjunto ordenado de elementos que se pueden recorrer o manipular.'),
	(22, 1, 'marcador', 'fitxa', 'markatzaile', 'indikatzaile', 2, 'Elemento o referencia que señala una posición específica dentro de un documento o archivo para facilitar su acceso.'),
	(23, 1, 'nivel de suelo', 'zoru-maila', 'soru-maila', 'maila altua', 1, 'En diseño de interfaces o estructuras, hace referencia al nivel base o mínimo desde el cual se organiza o construye.'),
	(24, 1, 'norma general', 'arau orokor', 'arau zehatz', 'irizpide orokor', 1, 'Regla o estándar aceptado que guía procesos o desarrollo en informática.'),
	(25, 1, 'operador', 'erabiltzaile', 'kudeatzaile', 'eragile', 3, 'Símbolo o función que realiza una operación específica en programación o matemáticas (por ejemplo, +, -, &&).'),
	(26, 1, 'página', 'dokumentu', 'fitxa', 'orri', 3, 'Unidad de contenido en una aplicación web o documento digital.'),
	(27, 1, 'página principal', 'sarrera', 'atari', 'orri nagusi', 3, 'Página de inicio o portada de un sitio web que presenta la información principal y enlaces a otras secciones.'),
	(28, 1, 'palabra clave', 'gako-hitz', 'pasahitz', 'seinale', 1, 'Término específico usado en búsquedas o programación para identificar o acceder a información.'),
	(29, 1, 'puerto', 'ataka', 'ibilbide', 'atal', 1, 'Punto de conexión física o virtual para la transmisión de datos en redes o dispositivos.'),
	(30, 1, 'ratón', 'botoi', 'sagu', 'teklatu', 2, 'Dispositivo de entrada que permite al usuario interactuar con la interfaz gráfica mediante movimientos y clics.'),
	(31, 2, 'absorción', 'irenspen', 'iragazketa', 'pilaketa', 1, 'Proceso mediante el cual una empresa incorpora otra o asume sus activos y pasivos.'),
	(32, 2, 'acreedor', 'hartzekodun', 'ordaintzaile', 'zorpetu', 1, 'Persona o entidad a la que se le debe dinero o una obligación pendiente.'),
	(33, 2, 'actividad', 'ekintza', 'jarduera', 'lana', 2, 'Conjunto de tareas o procesos realizados para alcanzar un objetivo empresarial o administrativo.'),
	(34, 2, 'antigüedad', 'historia', 'antsinatasun', 'antzinatasun', 3, 'Tiempo que una persona o empresa ha estado en un puesto o actividad, utilizado para cálculos laborales o fiscales.'),
	(35, 2, 'apartado', 'eremu', 'atal', 'kutxa', 2, 'Cuenta o registro específico destinado a una función particular dentro de la contabilidad o administración.'),
	(36, 2, 'asiento de ajuste', 'doikuntza-idazpen', 'kontu-lerro', 'erregistro', 1, 'Registro contable que corrige errores o actualiza valores en los estados financieros.'),
	(37, 2, 'auditoría', 'azterketa', 'berrikuspen', 'ikuskaritza', 3, 'Revisión sistemática y objetiva de las cuentas, procesos o sistemas de una empresa para verificar su exactitud y cumplimiento.'),
	(38, 2, 'autorización', 'baimen', 'agindu', 'ziurtagiri', 1, 'Permiso oficial para realizar una acción o acceder a recursos dentro de una organización.'),
	(39, 2, 'base', 'oinarri', 'azpiegitura', 'hondo', 1, 'Referencia o fundamento sobre el que se calculan impuestos, precios o indicadores financieros.'),
	(40, 2, 'base imponible', 'zerga-kuota', 'zerga-oinarri', 'tasa-maila', 2, 'Valor sobre el que se calcula un impuesto o tributo.'),
	(41, 2, 'beneficio', 'sarrera', 'gastu', 'etekin', 3, 'Ganancia neta obtenida después de deducir todos los costos y gastos.'),
	(42, 2, 'bien', 'ondasun', 'zerbitzu', 'produktu', 1, 'Elemento tangible o intangible que posee valor económico y puede ser propiedad de una empresa o individuo.'),
	(43, 2, 'bolsa', 'burtsa', 'karpeta', 'pakete', 1, 'Mercado organizado donde se compran y venden valores como acciones o bonos.'),
	(44, 2, 'caja', 'kutxa', 'poltsa', 'karpeta', 1, 'Registro o lugar físico donde se manejan y controlan los ingresos y pagos en efectivo dentro de una empresa.'),
	(45, 2, 'carta', 'agiri', 'gutun', 'nota', 2, 'Documento escrito que comunica decisiones, solicitudes o información formal dentro de la administración.'),
	(46, 2, 'CIF', 'IFK', 'NAN', 'KPI', 1, 'Código de Identificación Fiscal usado para identificar a empresas y personas jurídicas en trámites fiscales.'),
	(47, 2, 'cliente', 'erabiltzaile', 'hornitzaile', 'bezero', 3, 'Persona o entidad que adquiere bienes o servicios de una empresa.'),
	(48, 2, 'cobertura', 'estaldura', 'hedadura', 'aseguramendu', 1, 'Medida o alcance de protección, aseguramiento o presencia en el mercado.'),
	(49, 2, 'comercio', 'merkataritza', 'industria', 'negozio', 1, 'Actividad de compra y venta de bienes o servicios con fines lucrativos.'),
	(50, 2, 'compra', 'eskaintza', 'erosketa', 'kontratazio', 2, 'Acción de adquirir bienes o servicios a cambio de un pago.'),
	(51, 2, 'concesión', 'lizentzia', 'kontratu', 'emakida', 3, 'Permiso o autorización otorgada para explotar un derecho o recurso.'),
	(52, 2, 'convenio', 'kontratu', 'hitzarmen', 'araudi', 2, 'Acuerdo formal entre dos o más partes para regular relaciones o actividades.'),
	(53, 2, 'cónyuge', 'senide', 'ezkontide', 'lagun', 2, 'Persona unida legalmente a otra en matrimonio, con implicaciones legales y económicas.'),
	(54, 2, 'corte', 'ebaki', 'txanda', 'banaketa', 1, 'Decisión o interrupción de un proceso administrativo o financiero.'),
	(55, 2, 'departamento', 'sail', 'unitate', 'bulego', 1, 'Unidad organizativa dentro de una empresa encargada de funciones específicas.'),
	(56, 2, 'depósito', 'biltegi', 'fondo', 'gordailu', 3, 'Lugar o acción de almacenar bienes o valores; también puede referirse a un pago anticipado.'),
	(57, 2, 'deuda', 'gastu', 'zor', 'kreditu', 2, 'Obligación financiera que una empresa o individuo debe pagar.'),
	(58, 2, 'día natural', 'lanegun', 'egun natural', 'jai-egun', 2, 'Día calendario completo, incluyendo fines de semana y festivos, usado en cálculos administrativos.'),
	(59, 2, 'discapacidad', 'mugikortasun', 'ezintasun', 'ezintasun', 2, 'Limitación física o mental que afecta la capacidad para realizar ciertas actividades, con implicaciones legales y laborales.'),
	(60, 2, 'ejercicio', 'ekitaldi', 'jarduera', 'saio', 1, 'Periodo fiscal o contable en el que se registran y analizan las operaciones económicas.'),
	(61, 3, 'acogida', 'harrera', 'laguntza', 'topaketa', 1, 'Proceso inicial de recepción y acompañamiento a personas o grupos (niños, mayores, inmigrantes, usuarios de servicios sociales, etc.) para facilitar su integración y adaptación al entorno o programa.'),
	(62, 3, 'actitud', 'izaera', 'jarrera', 'ohitura', 2, 'Disposición o forma de comportarse ante una situación o persona; en el trabajo social y educativo, es clave para promover relaciones positivas, respeto y empatía.'),
	(63, 3, 'adaptación', 'egokitzapen', 'aldaketa', 'prestaketa', 1, 'Capacidad o proceso mediante el cual una persona o grupo se ajusta a nuevas circunstancias, entornos o normas. Fundamental en programas de integración social o educativa.'),
	(64, 3, 'adolescente', 'haur', 'gazte', 'nerabe', 3, 'Persona en etapa de desarrollo entre la niñez y la adultez, con necesidades específicas de orientación, educación y apoyo emocional.'),
	(65, 3, 'agresión', 'gatazka', 'eraso', 'eztabaida', 2, 'Comportamiento violento o dañino hacia otros, ya sea físico, verbal o psicológico. En intervención social, se trabaja en su prevención y gestión.'),
	(66, 3, 'alimentación', 'otordu', 'elikadura', 'sukaldaritza', 2, 'Conjunto de acciones y hábitos relacionados con la ingesta de alimentos; en el ámbito comunitario, se promueve la alimentación saludable y equilibrada.'),
	(67, 3, 'alojamiento', 'ostatu', 'gela', 'gelaxka', 1, 'Espacio o servicio destinado a proporcionar vivienda temporal o permanente a personas (por ejemplo, residencias, pisos tutelados o albergues sociales).'),
	(68, 3, 'alumnado', 'ikastaro', 'klase', 'ikasle', 3, 'Conjunto de estudiantes que participan en un centro educativo o en actividades formativas dentro de programas comunitarios.'),
	(69, 3, 'amenaza', 'beldur', 'mehatxu', 'zigor', 2, 'Situación o expresión que indica posible daño físico o psicológico hacia alguien. En contextos sociales o escolares, se considera un factor de riesgo.'),
	(70, 3, 'amistad', 'harreman', 'adiskidetasun', 'senidetasun', 2, 'Relación afectiva basada en la confianza y el apoyo mutuo; fomentar relaciones sanas es parte del trabajo en animación sociocultural y educación emocional.'),
	(71, 3, 'apego', 'harreman', 'maitasun', 'atxikimendu', 3, 'Vínculo emocional que une a una persona con otra (especialmente entre cuidador y niño). Es clave en el desarrollo afectivo y social.'),
	(72, 3, 'apoyo', 'laguntza', 'sendotasun', 'konfiantza', 1, 'Ayuda o acompañamiento que se brinda a personas o grupos para favorecer su bienestar, autonomía o integración social.'),
	(73, 3, 'asesoramiento', 'prestakuntza', 'ikasketa', 'aholkularitza', 3, 'Orientación profesional que se ofrece a individuos o colectivos para resolver problemas, tomar decisiones o mejorar su desarrollo personal o social.'),
	(74, 3, 'aula', 'klase', 'ikastoki', 'gela', 3, 'Espacio físico o virtual donde se desarrollan actividades educativas, formativas o de convivencia.'),
	(75, 3, 'barrio', 'auzo', 'herri', 'hiri', 1, 'Unidad territorial dentro de una comunidad donde se desarrollan la vida cotidiana, la convivencia y las intervenciones comunitarias.'),
	(76, 3, 'bienestar', 'ongisate', 'ongizate', 'lasaitasun', 2, 'Estado de satisfacción física, mental y social; objetivo fundamental de las políticas y programas de servicios a la comunidad.'),
	(77, 3, 'canica', 'pustarri', 'puxtarri', 'puxtaharri', 2, 'Juguete tradicional usado en actividades lúdicas y educativas, especialmente en programas infantiles o de animación sociocultural.'),
	(78, 3, 'carnaval', 'hinauteri', 'ihinauteri', 'inauteri', 3, 'Celebración cultural y popular que fomenta la participación, la creatividad y la identidad colectiva; se utiliza como herramienta de dinamización comunitaria.'),
	(79, 3, 'cesión', 'salmenta', 'lagapen', 'transferentzia', 2, 'Acción de transferir un bien, espacio o derecho a otra persona o entidad, generalmente para uso temporal en actividades sociales o educativas.'),
	(80, 3, 'conducta', 'jarrera', 'ohitura', 'harrera', 1, 'Conjunto de acciones observables de una persona; se analiza para promover comportamientos adecuados y prevenir conflictos.'),
	(81, 3, 'conferencia', 'hitzaldi', 'bilera', 'aurkezpen', 1, 'Exposición o charla formativa sobre un tema de interés social, cultural o educativo, dirigida a un grupo o comunidad.'),
	(82, 3, 'conflicto', 'borroka', 'tentsio', 'gatazka', 3, 'Situación de desacuerdo o enfrentamiento entre personas o grupos. En la intervención social, se busca su resolución mediante el diálogo y la mediación.'),
	(83, 3, 'creatividad', 'sormen', 'adimen', 'inspirazio', 1, 'Capacidad de generar ideas originales y útiles; en la animación sociocultural se emplea para diseñar actividades participativas e innovadoras.'),
	(84, 3, 'crecimiento', 'hazkuntza', 'garapen', 'azkuntza', 1, 'Desarrollo físico, emocional o social de una persona; se promueve a través de programas educativos, de ocio y de apoyo familiar.'),
	(85, 3, 'cuento', 'histori', 'ipuin', 'historia', 2, 'Narración breve usada como recurso educativo, terapéutico o de animación para transmitir valores, emociones y aprendizajes.'),
	(86, 3, 'cuidado', 'zaintza', 'laguntza', 'prebentzio', 1, 'Atención y protección que se brinda a personas dependientes, menores o mayores, garantizando su seguridad, dignidad y bienestar.'),
	(87, 3, 'cuna', 'sehaska', 'seaska', 'zehaska', 1, 'Elemento natural que puede formar parte de actividades medioambientales o educativas al aire libre, especialmente en programas de educación ambiental.'),
	(88, 3, 'curso', 'ikastaro', 'ikasgai', 'ikasketa', 1, 'Periodo de formación o conjunto de clases estructuradas con objetivos educativos o de capacitación social o profesional.'),
	(89, 3, 'dependencia', 'mendekotazun', 'mendekotasun', 'erlazio', 2, 'Situación en la que una persona necesita ayuda para realizar actividades básicas de la vida diaria. Es un eje central en los servicios de atención a la comunidad.'),
	(90, 3, 'derecho', 'arau', 'eskubide', 'ezkubide', 2, 'Conjunto de normas y principios que protegen la dignidad y los intereses de las personas; en el ámbito social, implica la defensa de la igualdad, la inclusión y la justicia social.'),
	(91, 4, 'variabilidad', 'aldakortasun', 'aldekortasun', 'egonkortasun', 1, 'Diferencias en la calidad o desempeño de un producto o servicio debido a factores como la producción, personal o contexto de uso.'),
	(92, 4, 'inseparabilidad', 'banaestazun', 'banaezintasun', 'bateragarritasun', 2, 'Característica de los servicios que indica que su producción y consumo ocurren al mismo tiempo, a diferencia de los productos.'),
	(93, 4, 'novedad', 'ohikotasun', 'berritasun', 'berritazun', 2, 'Cualidad de un producto o servicio que lo hace percibido como nuevo o innovador por los clientes.'),
	(94, 4, 'declive', 'ganbehera', 'gainbehera', 'gorakada', 2, 'Etapa del ciclo de vida de un producto en la que las ventas disminuyen debido a cambios en el mercado, competencia o preferencias del consumidor.'),
	(95, 4, 'madurez', 'gaztetasun', 'gastetasun', 'heldutasun', 3, 'Etapa del ciclo de vida en la que las ventas se estabilizan y la competencia es intensa.'),
	(96, 4, 'caducidad', 'galkortasun', 'iraunkortasun', 'iraungitasun', 1, 'Fecha límite en la que un producto conserva su calidad y es seguro para su consumo o uso.'),
	(97, 4, 'imagen de marca', 'marka-irudi', 'markairudi', 'marka-izudi', 1, 'Percepción que los consumidores tienen de una marca basada en experiencias, publicidad y reputación.'),
	(98, 4, 'lanzamiento', 'merkataritza', 'merkaturatze', 'merkaturazte', 2, 'Introducción de un nuevo producto o servicio al mercado con estrategias de marketing específicas.'),
	(99, 4, 'prueba', 'probaze', 'saiakuntza', 'probatze', 3, 'Etapa inicial en la que los consumidores experimentan un producto para evaluar su utilidad y calidad.'),
	(100, 4, 'producto cautivo', 'produktogaitibu', 'produktu lotu', 'produktu gatibu', 3, 'Producto que requiere la compra de otro complementario para su uso (por ejemplo, impresoras y cartuchos).'),
	(101, 4, 'servicio posventa', 'salduosteko laguntza', 'saldu osteko zerbitzu', 'saldu osteko arreta', 2, 'Atención y soporte que se ofrece al cliente después de la compra para garantizar satisfacción y fidelidad.'),
	(102, 4, 'intangibilidad', 'ukigarritasun', 'hukiezintasun', 'ukiezintasun', 3, 'Característica de los servicios que indica que no se pueden tocar ni almacenar, a diferencia de los bienes físicos.'),
	(103, 4, 'sobreprecio', 'gehigarri', 'gainprezio', 'gainkostu', 2, 'Incremento del precio sobre su costo o precio estándar, generalmente justificado por valor percibido, marca o exclusividad.'),
	(104, 4, 'fijación de precios', 'prezio-ezarpen', 'prezioen kontrola', 'prezio-politika', 1, 'Estrategia mediante la cual se determina el precio de venta de un producto o servicio.'),
	(105, 4, 'precio promocional', 'sustapen-prezio', 'eskaintza berezi', 'deskontu-prezio', 1, 'Precio reducido temporalmente para incentivar la compra y atraer clientes.'),
	(106, 4, 'distribución', 'zabalpena', 'banaketa', 'sabalpena', 2, 'Conjunto de actividades para hacer llegar un producto o servicio desde el fabricante hasta el consumidor final.'),
	(107, 4, 'distribuidor', 'hornitzaile', 'bitartekari', 'banatzaile', 3, 'Empresa o persona que compra productos a fabricantes y los vende a minoristas o directamente al cliente.'),
	(108, 4, 'intermediario', 'agente', 'ordezkari', 'bitartekari', 3, 'Entidad que facilita el movimiento de productos entre productor y consumidor final, como mayoristas o agentes.'),
	(109, 4, 'cadena de tiendas', 'denda-kate', 'denda multzo', 'dendakate', 1, 'Conjunto de puntos de venta bajo la misma marca o gestión que distribuyen productos al público.'),
	(110, 4, 'escaparate', 'erakusleiho', 'erakusgela', 'erakusleio', 1, 'Espacio visible en un comercio donde se exhiben productos para atraer la atención de los clientes.'),
	(111, 4, 'mayorista', 'enpresari', 'handizkari', 'saltzaile', 2, 'Intermediario que compra grandes volúmenes de productos para venderlos a minoristas o empresas.'),
	(112, 4, 'conflicto', 'eztabaida', 'gatazka', 'gataska', 2, 'Situación de desacuerdo o enfrentamiento entre personas o grupos. En la intervención social, se busca su resolución mediante el diálogo y la mediación.'),
	(113, 4, 'venta a granel', 'saltze', 'solteko salmeta', 'soltako salmeta', 2, 'Comercialización de productos sin envasar o en grandes cantidades, generalmente más económica.'),
	(114, 4, 'minorista', 'txikizkari', 'txikiskari', 'denda-kudeatzaile', 1, 'Comerciantes que venden directamente al consumidor final en pequeñas cantidades.'),
	(115, 4, 'DAFO', 'AIMA', 'AMYA', 'AMIA', 3, 'Herramienta estratégica que analiza Debilidades, Amenazas, Fortalezas y Oportunidades de una empresa o producto.'),
	(116, 4, 'imagen', 'irudi', 'ikuspegi', 'iduri', 1, 'Percepción global que tienen los consumidores sobre un producto, marca o empresa.'),
	(117, 4, 'receptor', 'hartzaile', 'jasotzaile', 'entzule', 1, 'Persona o público objetivo que recibe un mensaje de marketing o comunicación.'),
	(118, 4, 'promoción', 'publizitate', 'kanpaina', 'sustapen', 3, 'Conjunto de acciones de marketing destinadas a dar a conocer un producto y estimular su compra.'),
	(119, 4, 'ruido', 'zarata', 'oihu', 'sarata', 1, 'Cualquier interferencia o distracción que dificulta que el mensaje de marketing llegue al receptor correctamente.'),
	(120, 4, 'cliente', 'erosle', 'bezero', 'hornitzaile', 2, 'Persona o entidad que adquiere bienes o servicios de una empresa.');

-- Volcando estructura para tabla lhizki.eventos
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `num_preguntas` int DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.eventos: ~0 rows (aproximadamente)
INSERT INTO `eventos` (`id`, `user`, `fechaInicio`, `fechaFin`, `nombre`, `num_preguntas`, `fechaCreacion`) VALUES
	(6, 6, '2025-11-07 07:36:37', NULL, 'vsfc', 10, '2025-11-07 07:36:37'),
	(7, 6, '2025-11-07 07:41:07', NULL, 'vfsfsfs', 11, '2025-11-07 07:41:07'),
	(8, 6, '2025-11-07 07:42:48', NULL, 'Evento OFFICIAL 1', 10, '2025-11-07 07:42:48');

-- Volcando estructura para tabla lhizki.evento_destinatarios
CREATE TABLE IF NOT EXISTS `evento_destinatarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `evento_id` int NOT NULL,
  `clase_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_evento_destinatarios_eventos` (`evento_id`),
  KEY `FK_evento_destinatarios_clases` (`clase_id`),
  CONSTRAINT `FK_evento_destinatarios_clases` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`),
  CONSTRAINT `FK_evento_destinatarios_eventos` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla lhizki.evento_destinatarios: ~0 rows (aproximadamente)
INSERT INTO `evento_destinatarios` (`id`, `evento_id`, `clase_id`) VALUES
	(2, 6, 4),
	(3, 7, 4),
	(4, 8, 4);

-- Volcando estructura para tabla lhizki.evento_ranking
CREATE TABLE IF NOT EXISTS `evento_ranking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_evento` int NOT NULL DEFAULT '0',
  `alumno` varchar(100) NOT NULL,
  `puntuacion` int NOT NULL DEFAULT '0',
  `fallos` int NOT NULL DEFAULT '0',
  `aciertos` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK__eventos` (`id_evento`),
  CONSTRAINT `FK__eventos` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='este ranking recoge la clase en la que se esta realizando un evento, toma todos los datos de los alumnos que han participado y hace un top 5. Cuando el profesor finalice el evento, los datos de ese evento se eliminaran.';

-- Volcando datos para la tabla lhizki.evento_ranking: ~0 rows (aproximadamente)

-- Volcando estructura para tabla lhizki.glosario
CREATE TABLE IF NOT EXISTS `glosario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rama` int NOT NULL,
  `cast` varchar(100) NOT NULL,
  `eusk` varchar(100) NOT NULL,
  `definicion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.glosario: ~120 rows (aproximadamente)
INSERT INTO `glosario` (`id`, `rama`, `cast`, `eusk`, `definicion`) VALUES
	(1, 1, 'ámbito de uso', 'erabilera-eremu', 'Contexto o entorno en el que se aplica un sistema, software o tecnología.'),
	(2, 1, 'alinear', 'lerrokatu', 'Ajustar elementos (texto, datos, código) para que tengan una disposición uniforme y ordenada.'),
	(3, 1, 'auditoría interna', 'barne-auditoria', 'Revisión sistemática de procesos, sistemas o códigos dentro de una organización para asegurar calidad y cumplimiento.'),
	(4, 1, 'búsqueda', 'bilaketa', 'Proceso de localizar información específica dentro de bases de datos, documentos o internet.'),
	(5, 1, 'celda', 'gelaxka', 'Unidad básica en hojas de cálculo o bases de datos, donde se almacenan datos individuales.'),
	(6, 1, 'código', 'kode', 'Conjunto de instrucciones escritas en un lenguaje de programación que una computadora puede ejecutar.'),
	(7, 1, 'criterio general', 'irizpide orokor', 'Norma o regla estándar que se aplica para tomar decisiones o evaluar algo en sistemas o procesos.'),
	(8, 1, 'dato de tráfico', 'zirkulazio-datu', 'Información relacionada con el flujo de datos en redes o sistemas, como volumen o velocidad.'),
	(9, 1, 'deterioro grave', 'narriadura larri', 'Estado en el que un sistema o hardware presenta fallas significativas que afectan su funcionamiento.'),
	(10, 1, 'dirección', 'helbide', 'Identificador único que permite localizar un recurso en una red o memoria (por ejemplo, dirección IP).'),
	(11, 1, 'enlace', 'esteka', 'Conexión física o lógica que permite la comunicación entre dos dispositivos o nodos en una red.'),
	(12, 1, 'escritorio', 'mahaigain', 'Área de trabajo gráfica en un sistema operativo donde se gestionan archivos y aplicaciones.'),
	(13, 1, 'estructura', 'egitura', 'Organización o formato de datos, archivos o código para facilitar su gestión y acceso.'),
	(14, 1, 'extensión', 'luzapen', 'Sufijo en el nombre de un archivo que indica su tipo o formato (por ejemplo, .txt, .jpg).'),
	(15, 1, 'fila', 'errenkada', 'Conjunto horizontal de elementos en tablas, hojas de cálculo o bases de datos.'),
	(16, 1, 'hoja de contenido', 'eduki-orri', 'Documento o sección que organiza y muestra índices o temas de manera estructurada.'),
	(17, 1, 'host', 'ostalari', 'Dispositivo o sistema que proporciona servicios o recursos en una red.'),
	(18, 1, 'inteligencia artificial', 'adimen artifizial', 'Tecnología que permite a las máquinas simular procesos cognitivos humanos, como aprendizaje y razonamiento.'),
	(19, 1, 'lenguaje asp', 'asp lengoaia', 'Lenguaje de programación y tecnología para crear páginas web dinámicas del lado del servidor (Active Server Pages).'),
	(20, 1, 'librería', 'liburutegi', 'Conjunto de funciones o rutinas predefinidas que pueden ser usadas por programas para facilitar tareas comunes.'),
	(21, 1, 'lista', 'zerrenda', 'Estructura de datos o conjunto ordenado de elementos que se pueden recorrer o manipular.'),
	(22, 1, 'marcador', 'markatzaile', 'Elemento o referencia que señala una posición específica dentro de un documento o archivo para facilitar su acceso.'),
	(23, 1, 'nivel de suelo', 'zoru-maila', 'En diseño de interfaces o estructuras, hace referencia al nivel base o mínimo desde el cual se organiza o construye.'),
	(24, 1, 'norma general', 'arau orokor', 'Regla o estándar aceptado que guía procesos o desarrollo en informática.'),
	(25, 1, 'operador', 'eragile', 'Símbolo o función que realiza una operación específica en programación o matemáticas (por ejemplo, +, -, &&).'),
	(26, 1, 'página', 'orri', 'Unidad de contenido en una aplicación web o documento digital.'),
	(27, 1, 'página principal', 'orri nagusi', 'Página de inicio o portada de un sitio web que presenta la información principal y enlaces a otras secciones.'),
	(28, 1, 'palabra clave', 'gako-hitz', 'Término específico usado en búsquedas o programación para identificar o acceder a información.'),
	(29, 1, 'puerto', 'ataka', 'Punto de conexión física o virtual para la transmisión de datos en redes o dispositivos.'),
	(30, 1, 'ratón', 'sagu', 'Dispositivo de entrada que permite al usuario interactuar con la interfaz gráfica mediante movimientos y clics.'),
	(31, 2, 'absorción', 'irenspen', 'Proceso mediante el cual una empresa incorpora otra o asume sus activos y pasivos.'),
	(32, 2, 'acreedor', 'hartzekodun', 'Persona o entidad a la que se le debe dinero o una obligación pendiente.'),
	(33, 2, 'actividad', 'jarduera', 'Conjunto de tareas o procesos realizados para alcanzar un objetivo empresarial o administrativo.'),
	(34, 2, 'antigüedad', 'antzinatasun', 'Tiempo que una persona o empresa ha estado en un puesto o actividad, utilizado para cálculos laborales o fiscales.'),
	(35, 2, 'apartado', 'atal', 'Cuenta o registro específico destinado a una función particular dentro de la contabilidad o administración.'),
	(36, 2, 'asiento de ajuste', 'doikuntza-idazpen', 'Registro contable que corrige errores o actualiza valores en los estados financieros.'),
	(37, 2, 'auditoría', 'ikuskaritza', 'Revisión sistemática y objetiva de las cuentas, procesos o sistemas de una empresa para verificar su exactitud y cumplimiento.'),
	(38, 2, 'autorización', 'baimen', 'Permiso oficial para realizar una acción o acceder a recursos dentro de una organización.'),
	(39, 2, 'base', 'oinarri', 'Referencia o fundamento sobre el que se calculan impuestos, precios o indicadores financieros.'),
	(40, 2, 'base imponible', 'zerga-oinarri', 'Valor sobre el que se calcula un impuesto o tributo.'),
	(41, 2, 'beneficio', 'etekin', 'Ganancia neta obtenida después de deducir todos los costos y gastos.'),
	(42, 2, 'bien', 'ondasun', 'Elemento tangible o intangible que posee valor económico y puede ser propiedad de una empresa o individuo.'),
	(43, 2, 'bolsa', 'burtsa', 'Mercado organizado donde se compran y venden valores como acciones o bonos.'),
	(44, 2, 'caja', 'kutxa', 'Registro o lugar físico donde se manejan y controlan los ingresos y pagos en efectivo dentro de una empresa.'),
	(45, 2, 'carta', 'gutun', 'Documento escrito que comunica decisiones, solicitudes o información formal dentro de la administración.'),
	(46, 2, 'CIF', 'IFK', 'Código de Identificación Fiscal usado para identificar a empresas y personas jurídicas en trámites fiscales.'),
	(47, 2, 'cliente', 'bezero', 'Persona o entidad que adquiere bienes o servicios de una empresa.'),
	(48, 2, 'cobertura', 'estaldura', 'Medida o alcance de protección, aseguramiento o presencia en el mercado.'),
	(49, 2, 'comercio', 'merkataritza', 'Actividad de compra y venta de bienes o servicios con fines lucrativos.'),
	(50, 2, 'compra', 'erosketa', 'Acción de adquirir bienes o servicios a cambio de un pago.'),
	(51, 2, 'concesión', 'emakida', 'Permiso o autorización otorgada para explotar un derecho o recurso.'),
	(52, 2, 'convenio', 'hitzarmen', 'Acuerdo formal entre dos o más partes para regular relaciones o actividades.'),
	(53, 2, 'cónyuge', 'ezkontide', 'Persona unida legalmente a otra en matrimonio, con implicaciones legales y económicas.'),
	(54, 2, 'corte', 'ebaki', 'Decisión o interrupción de un proceso administrativo o financiero.'),
	(55, 2, 'departamento', 'sail', 'Unidad organizativa dentro de una empresa encargada de funciones específicas.'),
	(56, 2, 'depósito', 'gordailu', 'Lugar o acción de almacenar bienes o valores; también puede referirse a un pago anticipado.'),
	(57, 2, 'deuda', 'zor', 'Obligación financiera que una empresa o individuo debe pagar.'),
	(58, 2, 'día natural', 'egun natural', 'Día calendario completo, incluyendo fines de semana y festivos, usado en cálculos administrativos.'),
	(59, 2, 'discapacidad', 'ezintasun', 'Limitación física o mental que afecta la capacidad para realizar ciertas actividades, con implicaciones legales y laborales.'),
	(60, 2, 'ejercicio', 'ekitaldi', 'Periodo fiscal o contable en el que se registran y analizan las operaciones económicas.'),
	(61, 3, 'acogida', 'harrera', 'Proceso inicial de recepción y acompañamiento a personas o grupos (niños, mayores, inmigrantes, usuarios de servicios sociales, etc.) para facilitar su integración y adaptación al entorno o programa.'),
	(62, 3, 'actitud', 'jarrera', 'Disposición o forma de comportarse ante una situación o persona; en el trabajo social y educativo, es clave para promover relaciones positivas, respeto y empatía.'),
	(63, 3, 'adaptación', 'egokitzapen', 'Capacidad o proceso mediante el cual una persona o grupo se ajusta a nuevas circunstancias, entornos o normas. Fundamental en programas de integración social o educativa.'),
	(64, 3, 'adolescente', 'nerabe', 'Persona en etapa de desarrollo entre la niñez y la adultez, con necesidades específicas de orientación, educación y apoyo emocional.'),
	(65, 3, 'agresión', 'eraso', 'Comportamiento violento o dañino hacia otros, ya sea físico, verbal o psicológico. En intervención social, se trabaja en su prevención y gestión.'),
	(66, 3, 'alimentación', 'elikadura', 'Conjunto de acciones y hábitos relacionados con la ingesta de alimentos; en el ámbito comunitario, se promueve la alimentación saludable y equilibrada.'),
	(67, 3, 'alojamiento', 'ostatu', 'Espacio o servicio destinado a proporcionar vivienda temporal o permanente a personas (por ejemplo, residencias, pisos tutelados o albergues sociales).'),
	(68, 3, 'alumnado', 'ikasle', 'Conjunto de estudiantes que participan en un centro educativo o en actividades formativas dentro de programas comunitarios.'),
	(69, 3, 'amenaza', 'mehatxu', 'Situación o expresión que indica posible daño físico o psicológico hacia alguien. En contextos sociales o escolares, se considera un factor de riesgo.'),
	(70, 3, 'amistad', 'adiskidetasun', 'Relación afectiva basada en la confianza y el apoyo mutuo; fomentar relaciones sanas es parte del trabajo en animación sociocultural y educación emocional.'),
	(71, 3, 'apego', 'atxikimendu', 'Vínculo emocional que une a una persona con otra (especialmente entre cuidador y niño). Es clave en el desarrollo afectivo y social.'),
	(72, 3, 'apoyo', 'laguntza', 'Ayuda o acompañamiento que se brinda a personas o grupos para favorecer su bienestar, autonomía o integración social.'),
	(73, 3, 'asesoramiento', 'aholkularitza', 'Orientación profesional que se ofrece a individuos o colectivos para resolver problemas, tomar decisiones o mejorar su desarrollo personal o social.'),
	(74, 3, 'aula', 'gela', 'Espacio físico o virtual donde se desarrollan actividades educativas, formativas o de convivencia.'),
	(75, 3, 'barrio', 'auzo', 'Unidad territorial dentro de una comunidad donde se desarrollan la vida cotidiana, la convivencia y las intervenciones comunitarias.'),
	(76, 3, 'bienestar', 'ongizate', 'Estado de satisfacción física, mental y social; objetivo fundamental de las políticas y programas de servicios a la comunidad.'),
	(77, 3, 'canica', 'puxtarri', 'Juguete tradicional usado en actividades lúdicas y educativas, especialmente en programas infantiles o de animación sociocultural.'),
	(78, 3, 'carnaval', 'inauteri', 'Celebración cultural y popular que fomenta la participación, la creatividad y la identidad colectiva; se utiliza como herramienta de dinamización comunitaria.'),
	(79, 3, 'cesión', 'lagapen', 'Acción de transferir un bien, espacio o derecho a otra persona o entidad, generalmente para uso temporal en actividades sociales o educativas.'),
	(80, 3, 'conducta', 'jarrera', 'Conjunto de acciones observables de una persona; se analiza para promover comportamientos adecuados y prevenir conflictos.'),
	(81, 3, 'conferencia', 'hitzaldi', 'Exposición o charla formativa sobre un tema de interés social, cultural o educativo, dirigida a un grupo o comunidad.'),
	(82, 3, 'conflicto', 'gatazka', 'Situación de desacuerdo o enfrentamiento entre personas o grupos. En la intervención social, se busca su resolución mediante el diálogo y la mediación.'),
	(83, 3, 'creatividad', 'sormen', 'Capacidad de generar ideas originales y útiles; en la animación sociocultural se emplea para diseñar actividades participativas e innovadoras.'),
	(84, 3, 'crecimiento', 'hazkuntza', 'Desarrollo físico, emocional o social de una persona; se promueve a través de programas educativos, de ocio y de apoyo familiar.'),
	(85, 3, 'cuento', 'ipuin', 'Narración breve usada como recurso educativo, terapéutico o de animación para transmitir valores, emociones y aprendizajes.'),
	(86, 3, 'cuidado', 'zaintza', 'Atención y protección que se brinda a personas dependientes, menores o mayores, garantizando su seguridad, dignidad y bienestar.'),
	(87, 3, 'cuna', 'sehaska', 'Elemento natural que puede formar parte de actividades medioambientales o educativas al aire libre, especialmente en programas de educación ambiental.'),
	(88, 3, 'curso', 'ikastaro', 'Periodo de formación o conjunto de clases estructuradas con objetivos educativos o de capacitación social o profesional.'),
	(89, 3, 'dependencia', 'mendekotasun', 'Situación en la que una persona necesita ayuda para realizar actividades básicas de la vida diaria. Es un eje central en los servicios de atención a la comunidad.'),
	(90, 3, 'derecho', 'eskubide', 'Conjunto de normas y principios que protegen la dignidad y los intereses de las personas; en el ámbito social, implica la defensa de la igualdad, la inclusión y la justicia social.'),
	(91, 4, 'variabilidad', 'aldakortasun', 'Diferencias en la calidad o desempeño de un producto o servicio debido a factores como la producción, personal o contexto de uso.'),
	(92, 4, 'inseparabilidad', 'banaezintasun', 'Característica de los servicios que indica que su producción y consumo ocurren al mismo tiempo, a diferencia de los productos.'),
	(93, 4, 'novedad', 'berritasun', 'Cualidad de un producto o servicio que lo hace percibido como nuevo o innovador por los clientes.'),
	(94, 4, 'declive', 'gainbehera', 'Etapa del ciclo de vida de un producto en la que las ventas disminuyen debido a cambios en el mercado, competencia o preferencias del consumidor.'),
	(95, 4, 'madurez', 'heldutasun', 'Etapa del ciclo de vida en la que las ventas se estabilizan y la competencia es intensa.'),
	(96, 4, 'caducidad', 'galkortasun', 'Fecha límite en la que un producto conserva su calidad y es seguro para su consumo o uso.'),
	(97, 4, 'imagen de marca', 'marka-irudi', 'Percepción que los consumidores tienen de una marca basada en experiencias, publicidad y reputación.'),
	(98, 4, 'lanzamiento', 'merkaturatze', 'Introducción de un nuevo producto o servicio al mercado con estrategias de marketing específicas.'),
	(99, 4, 'prueba', 'probatze', 'Etapa inicial en la que los consumidores experimentan un producto para evaluar su utilidad y calidad.'),
	(100, 4, 'producto cautivo', 'produktu gatibu', 'Producto que requiere la compra de otro complementario para su uso (por ejemplo, impresoras y cartuchos).'),
	(101, 4, 'servicio posventa', 'saldu osteko zerbitzu', 'Atención y soporte que se ofrece al cliente después de la compra para garantizar satisfacción y fidelidad.'),
	(102, 4, 'intangibilidad', 'ukiezintasun', 'Característica de los servicios que indica que no se pueden tocar ni almacenar, a diferencia de los bienes físicos.'),
	(103, 4, 'sobreprecio', 'gainprezio', 'Incremento del precio sobre su costo o precio estándar, generalmente justificado por valor percibido, marca o exclusividad.'),
	(104, 4, 'fijación de precios', 'prezio-ezarpen', 'Estrategia mediante la cual se determina el precio de venta de un producto o servicio.'),
	(105, 4, 'precio promocional', 'sustapen-prezio', 'Precio reducido temporalmente para incentivar la compra y atraer clientes.'),
	(106, 4, 'distribución', 'banaketa', 'Conjunto de actividades para hacer llegar un producto o servicio desde el fabricante hasta el consumidor final.'),
	(107, 4, 'distribuidor', 'banatzaile', 'Empresa o persona que compra productos a fabricantes y los vende a minoristas o directamente al cliente.'),
	(108, 4, 'intermediario', 'bitartekari', 'Entidad que facilita el movimiento de productos entre productor y consumidor final, como mayoristas o agentes.'),
	(109, 4, 'cadena de tiendas', 'denda-kate', 'Conjunto de puntos de venta bajo la misma marca o gestión que distribuyen productos al público.'),
	(110, 4, 'escaparate', 'erakusleiho', 'Espacio visible en un comercio donde se exhiben productos para atraer la atención de los clientes.'),
	(111, 4, 'mayorista', 'handizkari', 'Intermediario que compra grandes volúmenes de productos para venderlos a minoristas o empresas.'),
	(112, 4, 'conflicto', 'gatazka', 'Problemas o desacuerdos entre miembros de la cadena de distribución por precios, territorios o ventas.'),
	(113, 4, 'venta a granel', 'solteko salmeta', 'Comercialización de productos sin envasar o en grandes cantidades, generalmente más económica.'),
	(114, 4, 'minorista', 'txikizkari', 'Comerciantes que venden directamente al consumidor final en pequeñas cantidades.'),
	(115, 4, 'DAFO', 'AMIA', 'Herramienta estratégica que analiza Debilidades, Amenazas, Fortalezas y Oportunidades de una empresa o producto.'),
	(116, 4, 'imagen', 'irudi', 'Percepción global que tienen los consumidores sobre un producto, marca o empresa.'),
	(117, 4, 'receptor', 'hartzaile', 'Persona o público objetivo que recibe un mensaje de marketing o comunicación.'),
	(118, 4, 'promoción', 'sustapen', 'Conjunto de acciones de marketing destinadas a dar a conocer un producto y estimular su compra.'),
	(119, 4, 'ruido', 'zarata', 'Cualquier interferencia o distracción que dificulta que el mensaje de marketing llegue al receptor correctamente.'),
	(120, 4, 'cliente', 'bezero', 'Persona o entidad que adquiere productos o servicios de una empresa.');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.partidas: ~0 rows (aproximadamente)
INSERT INTO `partidas` (`id`, `semana`, `fechaInicio`) VALUES
	(1, 44, '2025-10-28 08:29:08'),
	(2, 45, '2025-11-07 06:25:26'),
	(3, 46, '2025-11-10 12:09:26');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.partida_user: ~5 rows (aproximadamente)
INSERT INTO `partida_user` (`id`, `user_id`, `partida_id`, `puntuacion`, `fechaJugada`) VALUES
	(1, 1, 3, 0, '2025-10-28 08:28:00'),
	(3, 2, 1, 0, '2025-10-28 09:21:31'),
	(5, 1, 1, 0, '2025-10-28 09:56:05'),
	(6, 1, 1, 50, '2025-10-28 09:56:27'),
	(7, 4, 1, 200, '2025-10-30 08:22:48'),
	(8, 6, 2, 0, '2025-11-07 06:26:11'),
	(9, 8, 3, 550, '2025-11-10 12:09:56');

-- Volcando estructura para tabla lhizki.ramas
CREATE TABLE IF NOT EXISTS `ramas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.ramas: ~4 rows (aproximadamente)
INSERT INTO `ramas` (`id`, `nombre`) VALUES
	(1, ' Informatica y comunicaciones'),
	(2, 'Administardcion y gestion'),
	(3, 'Servicio socioculturales y a la comunidad '),
	(4, 'Comercio y marketing');

-- Volcando estructura para tabla lhizki.ranking
CREATE TABLE IF NOT EXISTS `ranking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rama` int DEFAULT NULL,
  `centro` int DEFAULT NULL,
  `puntuacionRanking` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ranking_centro_sector_2` (`centro`),
  KEY `rama_ranking` (`rama`) USING BTREE,
  CONSTRAINT `FK_ranking_centro_sector_2` FOREIGN KEY (`centro`) REFERENCES `centro_sector` (`centro`),
  CONSTRAINT `FK_ranking_ramas` FOREIGN KEY (`rama`) REFERENCES `ramas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.ranking: ~0 rows (aproximadamente)
INSERT INTO `ranking` (`id`, `rama`, `centro`, `puntuacionRanking`) VALUES
	(26, 1, 1, 250);

-- Volcando estructura para tabla lhizki.ranking_clases
CREATE TABLE IF NOT EXISTS `ranking_clases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `clase` int DEFAULT NULL,
  `centro` int DEFAULT NULL,
  `puntuacionClase` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_ranking_centro_sector_2` (`centro`) USING BTREE,
  KEY `rama_ranking` (`clase`) USING BTREE,
  CONSTRAINT `FK_ranking_clases_clases` FOREIGN KEY (`clase`) REFERENCES `clases` (`id`),
  CONSTRAINT `ranking_clases_ibfk_1` FOREIGN KEY (`centro`) REFERENCES `centro_sector` (`centro`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla lhizki.ranking_clases: ~0 rows (aproximadamente)
INSERT INTO `ranking_clases` (`id`, `clase`, `centro`, `puntuacionClase`) VALUES
	(23, 4, 1, 250);

-- Volcando estructura para tabla lhizki.ranking_sectores
CREATE TABLE IF NOT EXISTS `ranking_sectores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sector` int DEFAULT NULL,
  `centro` int DEFAULT NULL,
  `puntuacionSector` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_ranking_centro_sector_2` (`centro`) USING BTREE,
  KEY `rama_ranking` (`sector`) USING BTREE,
  CONSTRAINT `FK_ranking_sectores_centro_sector` FOREIGN KEY (`sector`) REFERENCES `centro_sector` (`sector`),
  CONSTRAINT `ranking_sectores_ibfk_2` FOREIGN KEY (`centro`) REFERENCES `centro_sector` (`centro`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla lhizki.ranking_sectores: ~0 rows (aproximadamente)
INSERT INTO `ranking_sectores` (`id`, `sector`, `centro`, `puntuacionSector`) VALUES
	(25, 2, 1, 250);

-- Volcando estructura para tabla lhizki.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.roles: ~3 rows (aproximadamente)
INSERT INTO `roles` (`id`, `rol`) VALUES
	(1, 'Admin'),
	(2, 'Profesor'),
	(3, 'Usuario');

-- Volcando estructura para tabla lhizki.sectores
CREATE TABLE IF NOT EXISTS `sectores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rama` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rama_sectores` (`rama`),
  CONSTRAINT `rama_sectores` FOREIGN KEY (`rama`) REFERENCES `ramas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.sectores: ~9 rows (aproximadamente)
INSERT INTO `sectores` (`id`, `nombre`, `rama`) VALUES
	(1, 'Grado Superior en Administración de Sistemas Informáticos en Red', 1),
	(2, 'Grado Superior en Desarrollo de Aplicaciones Web', 1),
	(3, 'Grado Medio en Sistemas Microinformáticos y Redes', 1),
	(4, 'Grado Superior en Administración y finanzas ', 2),
	(5, 'Grado Medio en Gestión Administrativa', 2),
	(6, 'Grado Inicial en Servicios Administrativos', 2),
	(7, 'Grado Superior en Marketing y Publicidad', 4),
	(8, 'Grado Medio en Actividades Comerciales', 4),
	(9, 'Grado Superior en Integración Social ', 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla lhizki.user: ~3 rows (aproximadamente)
INSERT INTO `user` (`id`, `rol`, `nombre`, `apellido`, `mail`, `password`, `centro`, `sector`, `clase`, `puntuacionIndividual`, `token`, `fechaConfirmacion`) VALUES
	(1, 3, 'juan', 'puertas', 'juanpu2004@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 1, 2, 4, 50, NULL, '2025-10-27'),
	(2, 3, 'Marcos', 'Brian', 'marcbaraka20@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 1, 2, 4, 0, NULL, '2025-10-28'),
	(4, 1, 'Aldo', 'Arrieta', 'aldo.dayron81@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1, 2, 4, 200, NULL, '2025-10-30'),
	(6, 2, 'Dayron', 'Arrieta', 'silverdayron20@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 2, 4, 0, NULL, '2025-11-05'),
	(8, 3, 'Asura', 'Tanaka', 'asuratanaka7@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 2, 4, 550, NULL, '2025-11-05');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
