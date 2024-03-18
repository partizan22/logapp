-- Adminer 4.8.1 MySQL 8.0.31 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `migrations` (
  `name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE `account`;
INSERT INTO `account` (`id`, `name`) VALUES
(3,	'');

DROP TABLE IF EXISTS `account_subject_rel`;
CREATE TABLE `account_subject_rel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int DEFAULT NULL,
  `subject_id` int NOT NULL,
  `rel_type` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `number` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `is_cat` tinyint NOT NULL DEFAULT '0',
  `unit` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE `article`;
INSERT INTO `article` (`id`, `name`, `number`, `is_cat`, `unit`) VALUES
(26,	'Баклажани свіжі',	'1001',	0,	'кг'),
(27,	'Баклажани свіжі сезонні',	'1002',	0,	'кг'),
(28,	'Буряк готовий до вживання',	'1003',	0,	'кг'),
(29,	'Буряк столовий свіжий',	'1004',	0,	'кг'),
(30,	'Гарбуз продовольчий свіжий',	'1005',	0,	'кг'),
(31,	'Горошок зелений консервований',	'1006',	0,	'кг'),
(32,	'Ікра баклажанна',	'1007',	0,	'кг'),
(33,	'Ікра кабачкова',	'1008',	0,	'кг'),
(34,	'Кабачки консервовані',	'1009',	0,	'кг'),
(35,	'Кабачки свіжі',	'1010',	0,	'кг'),
(36,	'Кабачки свіжі сезонні',	'1011',	0,	'кг'),
(37,	'Капуста білоголова свіжа',	'1012',	0,	'кг'),
(38,	'Капуста броколі свіжа сезонна',	'1013',	0,	'кг'),
(39,	'Капуста квашена',	'1014',	0,	'кг'),
(40,	'Капуста пекінська свіжа',	'1015',	0,	'кг'),
(41,	'Капуста цвітна свіжа',	'1016',	0,	'кг'),
(42,	'Капуста цвітна свіжа сезонна',	'1017',	0,	'кг'),
(43,	'Картопля свіжа',	'1018',	0,	'кг'),
(44,	'Картопля свіжа рання',	'1019',	0,	'кг'),
(45,	'Квасоля продовольча',	'1020',	0,	'кг'),
(46,	'Квасоля консервована',	'1021',	0,	'кг'),
(47,	'Квасоля консервована в томаті (у томатному соусі)',	'1022',	0,	'кг'),
(48,	'Консерви, заправки для перших страв',	'1023',	0,	'кг'),
(49,	'Кукурудза консервована',	'1024',	0,	'кг'),
(50,	'Маслини без кісточки',	'1025',	0,	'кг'),
(51,	'Морква свіжа',	'1026',	0,	'кг'),
(52,	'Морква готова до вживання',	'1027',	0,	'кг'),
(53,	'Огірки свіжі',	'1028',	0,	'кг'),
(54,	'Огірки консервовані',	'1029',	0,	'кг'),
(55,	'Огірки солоні',	'1030',	0,	'кг'),
(56,	'Огірки свіжі сезонні',	'1031',	0,	'кг'),
(57,	'Оливки без кісточки',	'1032',	0,	'кг'),
(58,	'Перець солодкий свіжий (болгарський жовтий)',	'1033',	0,	'кг'),
(59,	'Перець солодкий свіжий сезонний (болгарський жовтий)',	'1034',	0,	'кг'),
(60,	'Перець солодкий свіжий (болгарський зелений)',	'1035',	0,	'кг'),
(61,	'Перець солодкий свіжий сезонний (болгарський зелений)',	'1036',	0,	'кг'),
(62,	'Перець солодкий свіжий (болгарський червоний)',	'1037',	0,	'кг'),
(63,	'Перець солодкий свіжий сезонний (болгарський червоний)',	'1038',	0,	'кг'),
(64,	'Перець стручковий свіжий червоний',	'1039',	0,	'кг'),
(65,	'Перець консервований солодкий (болгарський)',	'1040',	0,	'кг'),
(66,	'Салат свіжий',	'1041',	0,	'кг'),
(67,	'Салат свіжий сезонний',	'1042',	0,	'кг'),
(68,	'Томат свіжий',	'1043',	0,	'кг'),
(69,	'Томат свіжий сезонний',	'1044',	0,	'кг'),
(70,	'Томат консервований',	'1045',	0,	'кг'),
(71,	'Томат солоний',	'1046',	0,	'кг'),
(72,	'Цибуля зелена свіжа',	'1047',	0,	'кг'),
(73,	'Цибуля порей свіжа',	'1048',	0,	'кг'),
(74,	'Цибуля ріпчаста свіжа',	'1049',	0,	'кг'),
(75,	'Часник свіжий',	'1050',	0,	'кг'),
(76,	'Шампіньйони свіжі',	'1051',	0,	'кг'),
(77,	'Шампіньйони консервовані',	'1052',	0,	'кг'),
(78,	'Щавель свіжий',	'1053',	0,	'кг'),
(79,	'Щавель консервований',	'1054',	0,	'кг'),
(80,	'Салат овочевий закусочний',	'1055',	0,	'кг'),
(81,	'Спаржа свіжа',	'1056',	0,	'кг'),
(82,	'Редис свіжий',	'1057',	0,	'кг'),
(83,	'Редька свіжа',	'1058',	0,	'кг'),
(84,	'Капуста морська свіжа',	'1059',	0,	'кг'),
(85,	'М\'ята свіжа',	'1060',	0,	'кг'),
(86,	'Цибуля синя',	'1061',	0,	'кг'),
(87,	'Цибуля червона',	'1062',	0,	'кг'),
(88,	'Картопля пізня',	'1063',	0,	'кг'),
(89,	'Капуста червоноголова свіжа',	'1064',	0,	'кг'),
(90,	'Рукола свіжа',	'1065',	0,	'кг'),
(91,	'Капуста броколі заморожена',	'1201',	0,	'кг'),
(92,	'Вишня заморожена',	'1202',	0,	'кг'),
(93,	'Горошок зелений заморожений',	'1203',	0,	'кг'),
(94,	'Капуста цвітна заморожена',	'1204',	0,	'кг'),
(95,	'Картопля фрі заморожена',	'1205',	0,	'кг'),
(96,	'Кукурудза заморожена',	'1206',	0,	'кг'),
(97,	'Морква заморожена',	'1207',	0,	'кг'),
(98,	'Перець солодкий (болгарський) заморожений',	'1208',	0,	'кг'),
(99,	'Полуниця заморожена',	'1209',	0,	'кг'),
(100,	'Слива заморожена',	'1210',	0,	'кг'),
(101,	'Смородина чорна заморожена',	'1211',	0,	'кг'),
(102,	'Спаржа заморожена',	'1212',	0,	'кг'),
(103,	'Чорниця заморожена',	'1213',	0,	'кг'),
(104,	'Крупа горохова швидкого приготування',	'1301',	0,	'кг'),
(105,	'Крупа гречана швидкого приготування',	'1302',	0,	'кг'),
(106,	'Крупа кукурудзяна швидкого приготування',	'1303',	0,	'кг'),
(107,	'Крупа перлова швидкого приготування',	'1304',	0,	'кг'),
(108,	'Крупа пшенична швидкого приготування',	'1305',	0,	'кг'),
(109,	'Крупа пшоняна швидкого приготування',	'1306',	0,	'кг'),
(110,	'Крупа рисова швидкого приготування',	'1307',	0,	'кг'),
(111,	'Крупа ячна швидкого приготування',	'1308',	0,	'кг'),
(112,	'Пластівці вівсяні',	'1401',	0,	'кг'),
(113,	'Крупа вівсяна',	'1402',	0,	'кг'),
(114,	'Геркулес',	'1403',	0,	'кг'),
(115,	'Крупа горохова',	'1404',	0,	'кг'),
(116,	'Крупа гречана ядриця',	'1405',	0,	'кг'),
(117,	'Крупа кукурудзяна',	'1406',	0,	'кг'),
(118,	'Крупа манна',	'1407',	0,	'кг'),
(119,	'Крупа перлова',	'1408',	0,	'кг'),
(120,	'Крупа пшенична',	'1409',	0,	'кг'),
(121,	'Крупа пшоняна',	'1410',	0,	'кг'),
(122,	'Крупа ячна',	'1411',	0,	'кг'),
(123,	'Пластівці кукурудзяні',	'1412',	0,	'кг'),
(124,	'Пластівці різні з фруктами',	'1413',	0,	'кг'),
(125,	'Плаcтівці 4 злаки',	'1414',	0,	'кг'),
(126,	'Рис довгозернистий полірований',	'1415',	0,	'кг'),
(127,	'Рис довгозернистий пропарений',	'1416',	0,	'кг'),
(128,	'Рис довгозернистий шліфований',	'1417',	0,	'кг'),
(129,	'Рис круглий',	'1418',	0,	'кг'),
(130,	'Рис нешліфований',	'1419',	0,	'кг'),
(131,	'Сніданки сухі зернові',	'1420',	0,	'кг'),
(132,	'Крупа саго',	'1421',	0,	'кг'),
(133,	'Вермішель довга',	'1501',	0,	'кг'),
(134,	'Макарони',	'1502',	0,	'кг'),
(135,	'Пера',	'1503',	0,	'кг'),
(136,	'Ріжки',	'1504',	0,	'кг'),
(137,	'Фігурні макаронні вироби',	'1505',	0,	'кг'),
(138,	'Базилік свіжий',	'1601',	0,	'кг'),
(139,	'Базилік (спеції)',	'1602',	0,	'кг'),
(140,	'Гірчиця харчова',	'1603',	0,	'кг'),
(141,	'Дріжджі хлібопекарські пресовані',	'1604',	0,	'кг'),
(142,	'Дріжджі хлібопекарські сухі',	'1605',	0,	'кг'),
(143,	'Желатин харчовий',	'1606',	0,	'кг'),
(144,	'Кетчуп',	'1607',	0,	'кг'),
(145,	'Корінь селери',	'1608',	0,	'кг'),
(146,	'Кріп свіжий',	'1609',	0,	'кг'),
(147,	'Кріп сушений',	'1610',	0,	'кг'),
(148,	'Крохмаль картопляний',	'1611',	0,	'кг'),
(149,	'Лист лавровий сухий',	'1612',	0,	'кг'),
(150,	'Майонезний соус 30 %',	'1613',	0,	'кг'),
(151,	'Майонез 67 %',	'1614',	0,	'кг'),
(152,	'Орегано (спеції)',	'1615',	0,	'кг'),
(153,	'Оцет 9 %',	'1616',	0,	'кг'),
(154,	'Перець червоний мелений',	'1617',	0,	'кг'),
(155,	'Петрушка свіжа',	'1618',	0,	'кг'),
(156,	'Петрушка сушена',	'1619',	0,	'кг'),
(157,	'Порошок гірчичний',	'1620',	0,	'кг'),
(158,	'Приправи для моркви по-корейськи',	'1621',	0,	'кг'),
(159,	'Перець чорний горошком',	'1622',	0,	'кг'),
(160,	'Перець чорний мелений',	'1623',	0,	'кг'),
(161,	'Сіль кухонна екстра',	'1624',	0,	'кг'),
(162,	'Сіль кухонна',	'1625',	0,	'кг'),
(163,	'Томатна паста',	'1626',	0,	'кг'),
(164,	'Хрін',	'1627',	0,	'кг'),
(165,	'Кориця мелена',	'1628',	0,	'кг'),
(166,	'Ванілін',	'1629',	0,	'кг'),
(167,	'Ванільний цукор',	'1630',	0,	'кг'),
(168,	'Сіль йодована',	'1631',	0,	'кг'),
(169,	'Желе фруктове в асортименті',	'1632',	0,	'кг'),
(170,	'Оцет яблучний 9 %',	'1633',	0,	'кг'),
(171,	'Кислота лимонна',	'1634',	0,	'кг'),
(172,	'Сода харчова',	'1635',	0,	'кг'),
(173,	'Бекон',	'2001',	0,	'кг'),
(174,	'Ковбаса варено-копчена першого ґатунку',	'2002',	0,	'кг'),
(175,	'Ковбаса варено-копчена вищого ґатунку',	'2003',	0,	'кг'),
(176,	'Ковбаса напівкопчена першого ґатунку',	'2004',	0,	'кг'),
(177,	'Ковбаса напівкопчена вищого ґатунку',	'2005',	0,	'кг'),
(178,	'Ковбаса сирокопчена першого ґатунку',	'2006',	0,	'кг'),
(179,	'Ковбаса сирокопчена вищого ґатунку',	'2007',	0,	'кг'),
(180,	'Консерви “Паштети м’ясні”',	'2008',	0,	'кг'),
(181,	'Консерви  “Паштети м’ясні” вищого  ґатунку',	'2009',	0,	'кг'),
(182,	'Консерви м’ясорослинні (гречка з яловичиною)',	'2010',	0,	'кг'),
(183,	'Консерви м’ясорослинні (перлова з яловичиною)',	'2011',	0,	'кг'),
(184,	'Консерви “Свинина тушкована”',	'2012',	0,	'кг'),
(185,	'Консерви “Яловичина тушкована вищого ґатунку”',	'2013',	0,	'кг'),
(186,	'Качина тушка охолоджена',	'2014',	0,	'кг'),
(187,	'Індиче філе охолоджене',	'2015',	0,	'кг'),
(188,	'Індиче філе заморожене',	'2016',	0,	'кг'),
(189,	'Індича гомілка охолоджена',	'2017',	0,	'кг'),
(190,	'Індича гомілка заморожена',	'2018',	0,	'кг'),
(191,	'Індиче стегно охолоджене',	'2019',	0,	'кг'),
(192,	'Індиче стегно заморожене',	'2020',	0,	'кг'),
(193,	'Індича тушка',	'2021',	0,	'кг'),
(194,	'Куряче філе заморожене',	'2022',	0,	'кг'),
(195,	'Куряче філе охолоджене',	'2023',	0,	'кг'),
(196,	'Куряча гомілка заморожена',	'2024',	0,	'кг'),
(197,	'Куряча гомілка охолоджена',	'2025',	0,	'кг'),
(198,	'Куряче крило заморожене',	'2026',	0,	'кг'),
(199,	'Куряче крило охолоджене',	'2027',	0,	'кг'),
(200,	'Куряче стегно заморожене',	'2028',	0,	'кг'),
(201,	'Куряче стегно охолоджене',	'2029',	0,	'кг'),
(202,	'Куряча тушка заморожена',	'2030',	0,	'кг'),
(203,	'Куряча тушка охолоджена',	'2031',	0,	'кг'),
(204,	'Печінка куряча',	'2032',	0,	'кг'),
(205,	'Сало свіже',	'2033',	0,	'кг'),
(206,	'Сало солоне',	'2034',	0,	'кг'),
(207,	'Сардельки першого ґатунку',	'2035',	0,	'кг'),
(208,	'Сардельки вищого ґатунку',	'2036',	0,	'кг'),
(209,	'Свинина, грудинка ціла охолоджена',	'2037',	0,	'кг'),
(210,	'Свинина, корейка без кістки заморожена',	'2038',	0,	'кг'),
(211,	'Свинина, корейка без кістки охолоджена',	'2039',	0,	'кг'),
(212,	'Свинина, корейка з кісткою заморожена',	'2040',	0,	'кг'),
(213,	'Свинина, корейка з кісткою охолоджена',	'2041',	0,	'кг'),
(214,	'Свинина, лопатка без кістки заморожена',	'2042',	0,	'кг'),
(215,	'Свинина, лопатка без кістки охолоджена',	'2043',	0,	'кг'),
(216,	'Свинина півтуші, заморожена',	'2044',	0,	'кг'),
(217,	'Свинина півтуші, охолоджена',	'2045',	0,	'кг'),
(218,	'Свинина, ошийок охолоджений',	'2046',	0,	'кг'),
(219,	'Свинина, печінка заморожена',	'2047',	0,	'кг'),
(220,	'Свинина, печінка охолоджена',	'2048',	0,	'кг'),
(221,	'Свинина, ребра заморожені',	'2049',	0,	'кг'),
(222,	'Свинина, ребра охолоджені',	'2050',	0,	'кг'),
(223,	'Свинина, стегно заморожене',	'2051',	0,	'кг'),
(224,	'Свинина, стегно охолоджене',	'2052',	0,	'кг'),
(225,	'Сосиски першого ґатунку',	'2053',	0,	'кг'),
(226,	'Сосиски вищого ґатунку',	'2054',	0,	'кг'),
(227,	'Шинка, грудинка (копчені)',	'2055',	0,	'кг'),
(228,	'Яйця курячі першого ґатунку',	'2056',	0,	'шт'),
(229,	'Яйця курячі вищого ґатунку',	'2057',	0,	'шт'),
(230,	'Яловичина, задня частина заморожена без кістки',	'2058',	0,	'кг'),
(231,	'Яловичина, задня частина охолоджена без кістки',	'2059',	0,	'кг'),
(232,	'Яловичина, лопатка заморожена без кістки',	'2060',	0,	'кг'),
(233,	'Яловичина, лопатка охолоджена без кістки',	'2061',	0,	'кг'),
(234,	'Яловичина півтуші, заморожена',	'2062',	0,	'кг'),
(235,	'Яловичина півтуші, охолоджена',	'2063',	0,	'кг'),
(236,	'Яловичина, печінка заморожена',	'2064',	0,	'кг'),
(237,	'Яловичина, стейк (биток)',	'2065',	0,	'кг'),
(238,	'М’ясні субпродукти другої категорії',	'2066',	0,	'кг'),
(239,	'Телятина, задня частина заморожена без кістки',	'2067',	0,	'кг'),
(240,	'Телятина, задня частина охолоджена без кістки',	'2068',	0,	'кг'),
(241,	'Телятина, лопатка заморожена без кістки',	'2069',	0,	'кг'),
(242,	'Телятина, лопатка охолоджена без кістки',	'2070',	0,	'кг'),
(243,	'Телятина півтуші, заморожена',	'2071',	0,	'кг'),
(244,	'Телятина півтуші, охолоджена',	'2072',	0,	'кг'),
(245,	'Телятина, стейк (биток)',	'2073',	0,	'кг'),
(246,	'М’ясо кролика, тушка охолоджена',	'2074',	0,	'кг'),
(247,	'Мерлуза, філе заморожене',	'2201',	0,	'кг'),
(248,	'Горбуша без голови заморожена',	'2202',	0,	'кг'),
(249,	'Камбала заморожена',	'2203',	0,	'кг'),
(250,	'Консерви тунець в олії',	'2204',	0,	'кг'),
(251,	'Консерви з риби дрібної у томаті першого ґатунку',	'2205',	0,	'кг'),
(252,	'Консерви з риби дрібної у томаті вищого ґатунку',	'2206',	0,	'кг'),
(253,	'Консерви рибні першого ґатунку',	'2207',	0,	'кг'),
(254,	'Консерви рибні в олії першого ґатунку',	'2208',	0,	'кг'),
(255,	'Консерви рибні в олії вищого ґатунку',	'2209',	0,	'кг'),
(256,	'Консерви рибні вищого ґатунку',	'2210',	0,	'кг'),
(257,	'Консерви рибні у томаті першого ґатунку',	'2211',	0,	'кг'),
(258,	'Консерви рибні у томаті вищого ґатунку',	'2212',	0,	'кг'),
(259,	'Консерви сардини в олії першого ґатунку',	'2213',	0,	'кг'),
(260,	'Консерви сардини в олії вищого ґатунку',	'2214',	0,	'кг'),
(261,	'Консерви шпроти в олії першого ґатунку',	'2215',	0,	'кг'),
(262,	'Консерви шпроти в олії вищого ґатунку',	'2216',	0,	'кг'),
(263,	'Короп охолоджений',	'2217',	0,	'кг'),
(264,	'Крабові палички заморожені',	'2218',	0,	'кг'),
(265,	'Минтай, філе заморожене',	'2219',	0,	'кг'),
(266,	'Минтай заморожений',	'2220',	0,	'кг'),
(267,	'Минтай без голови заморожений',	'2221',	0,	'кг'),
(268,	'Осетр охолоджений',	'2222',	0,	'кг'),
(269,	'Сайда заморожена',	'2223',	0,	'кг'),
(270,	'Сайда без голови заморожена',	'2224',	0,	'кг'),
(271,	'Сайра заморожена',	'2225',	0,	'кг'),
(272,	'Сайра без голови заморожена',	'2226',	0,	'кг'),
(273,	'Скумбрія заморожена',	'2227',	0,	'кг'),
(274,	'Скумбрія без голови заморожена',	'2228',	0,	'кг'),
(275,	'Форель охолоджена',	'2229',	0,	'кг'),
(276,	'Хек заморожений',	'2230',	0,	'кг'),
(277,	'Хек без голови заморожений',	'2231',	0,	'кг'),
(278,	'Хек, філе заморожене',	'2232',	0,	'кг'),
(279,	'Тріска без голови заморожена ',	'2233',	0,	'кг'),
(280,	'Тріска, філе заморожена',	'2234',	0,	'кг'),
(281,	'Сом без голови заморожений',	'2235',	0,	'кг'),
(282,	'Сом без голови охолоджений',	'2236',	0,	'кг'),
(283,	'Філе оселедця (солоне)',	'2237',	0,	'кг'),
(284,	'Маргарин столовий 70 %',	'2301',	0,	'кг'),
(285,	'Масло вершкове селянське 72,5 % - 79,9 %',	'2302',	0,	'кг'),
(286,	'Масло вершкове селянське 72,5 % - 79,9 %',	'2303',	0,	'кг'),
(287,	'Масло бутербродне 61,5 % - 72,4 %',	'2304',	0,	'кг'),
(288,	'Олія оливкова',	'2305',	0,	'кг'),
(289,	'Олія соняшникова нерафінована',	'2306',	0,	'кг'),
(290,	'Олія соняшникова рафінована',	'2307',	0,	'кг'),
(291,	'Жир тваринний',	'2308',	0,	'кг'),
(292,	'Варення з малини',	'3001',	0,	'кг'),
(293,	'Варення з полуниці',	'3002',	0,	'кг'),
(294,	'Варення плодово-ягідне',	'3003',	0,	'кг'),
(295,	'Джем плодово-ягідний',	'3004',	0,	'кг'),
(296,	'Льодяники різні',	'3005',	0,	'кг'),
(297,	'Мед натуральний',	'3006',	0,	'кг'),
(298,	'Повидло яблучне',	'3007',	0,	'кг'),
(299,	'Варення з малини індивідуального пакування',	'3008',	0,	'кг'),
(300,	'Варення з полуниці індивідуального пакування',	'3009',	0,	'кг'),
(301,	'Варення плодово-ягідне індивідуального пакування',	'3010',	0,	'кг'),
(302,	'Джем плодово-ягідний індивідуального пакування',	'3011',	0,	'кг'),
(303,	'Льодяники різні індивідуального пакування',	'3012',	0,	'кг'),
(304,	'Мед натуральний індивідуального пакування',	'3013',	0,	'кг'),
(305,	'Повидло яблучне індивідуального пакування',	'3014',	0,	'кг'),
(306,	'Горіхова паста',	'3015',	0,	'кг'),
(307,	'Батончик енергетичний',	'3016',	0,	'кг'),
(308,	'Шоколад молочний',	'3017',	0,	'кг'),
(309,	'Шоколад молочний індивідуального пакування',	'3018',	0,	'кг'),
(310,	'Шоколад темний (чорний)',	'3019',	0,	'кг'),
(311,	'Шоколад темний (чорний) індивідуального пакування',	'3020',	0,	'кг'),
(312,	'Батончик шоколадний з арахісом',	'3021',	0,	'кг'),
(313,	'Бринза',	'3101',	0,	'кг'),
(314,	'Вершки питні порційні',	'3102',	0,	'кг'),
(315,	'Вершки кондитерські (кулінарні)',	'3103',	0,	'кг'),
(316,	'Йогурт з добавками від 1,5 %',	'3104',	0,	'кг'),
(317,	'Йогурт натуральний від 1,5 %',	'3105',	0,	'кг'),
(318,	'Кефір нежирний',	'3106',	0,	'кг'),
(319,	'Кефір від 2,5 %',	'3107',	0,	'кг'),
(320,	'Молоко згущене 8,5 %',	'3108',	0,	'кг'),
(321,	'Молоко пастеризоване 1 % - 2,4 %',	'3109',	0,	'кг'),
(322,	'Молоко ультрапастеризоване 1,5 %',	'3110',	0,	'кг'),
(323,	'Молоко ультрапастеризоване 2,5 %',	'3111',	0,	'кг'),
(324,	'Молоко ультрапастеризоване 3,2 %',	'3112',	0,	'кг'),
(325,	'Сир кисломолочний 9 %',	'3113',	0,	'кг'),
(326,	'Сир кисломолочний не жирний',	'3114',	0,	'кг'),
(327,	'Сир плавлений індивідуального пакування',	'3115',	0,	'кг'),
(328,	'Сир російський',	'3116',	0,	'кг'),
(329,	'Сир напівтвердий',	'3117',	0,	'кг'),
(330,	'Сир твердий сичужний',	'3118',	0,	'кг'),
(331,	'Сир фета',	'3119',	0,	'кг'),
(332,	'Сметана 15 % - 20 %',	'3120',	0,	'кг'),
(333,	'Сметана 21 % - 25 %',	'3121',	0,	'кг'),
(334,	'Молоко пастеризоване від 2,5 %',	'3122',	0,	'кг'),
(335,	'Десерт сирковий',	'3123',	0,	'кг'),
(336,	'Сир Моцарела',	'3124',	0,	'кг'),
(337,	'Апельсиновий сік до 0,3 л',	'4001',	0,	'кг'),
(338,	'Апельсиновий сік',	'4002',	0,	'кг'),
(339,	'Виноградний сік до 0,3 л',	'4003',	0,	'кг'),
(340,	'Виноградний сік',	'4004',	0,	'кг'),
(341,	'Вишневий сік до 0,3 л',	'4005',	0,	'кг'),
(342,	'Вишневий сік',	'4006',	0,	'кг'),
(343,	'Вода газована солодка 0,5 л',	'4007',	0,	'кг'),
(344,	'Вода газована солодка 1,5 л',	'4008',	0,	'кг'),
(345,	'Вода мінеральна 0,33 л',	'4009',	0,	'кг'),
(346,	'Вода мінеральна 0,5 л',	'4010',	0,	'кг'),
(347,	'Вода мінеральна 1,5 л',	'4011',	0,	'л'),
(348,	'Вода питна бутильована до 1,5 л',	'4012',	0,	'кг'),
(349,	'Гранатовий сік',	'4013',	0,	'кг'),
(350,	'Грейпфрутовий сік',	'4014',	0,	'кг'),
(351,	'Кава натуральна мелена',	'4015',	0,	'кг'),
(352,	'Кава розчинна',	'4016',	0,	'кг'),
(353,	'Кавовий напій',	'4017',	0,	'кг'),
(354,	'Какао-порошок',	'4018',	0,	'кг'),
(355,	'Мультивітамінний сік до 0,3 л',	'4019',	0,	'кг'),
(356,	'Мультивітамінний сік',	'4020',	0,	'кг'),
(357,	'Томатний сік до 0,3 л',	'4021',	0,	'кг'),
(358,	'Томатний сік',	'4022',	0,	'кг'),
(359,	'Енергетичний напій',	'4023',	0,	'кг'),
(360,	'Цукор індивідуального пакування',	'4024',	0,	'кг'),
(361,	'Цукор',	'4025',	0,	'кг'),
(362,	'Чай зелений пакетований',	'4026',	0,	'кг'),
(363,	'Чай зелений нефасований',	'4027',	0,	'кг'),
(364,	'Чай чорний з добавками пакетований',	'4028',	0,	'кг'),
(365,	'Чай чорний пакетований',	'4029',	0,	'кг'),
(366,	'Чай чорний нефасований',	'4030',	0,	'кг'),
(367,	'Яблучний сік до 0,3 л',	'4031',	0,	'кг'),
(368,	'Яблучний сік',	'4032',	0,	'кг'),
(369,	'Напій швидкорозчинний фруктовий',	'4033',	0,	'кг'),
(370,	'Сік лимонний',	'4034',	0,	'кг'),
(371,	'Ананас консервований',	'4101',	0,	'кг'),
(372,	'Ананас свіжий',	'4102',	0,	'кг'),
(373,	'Апельсин',	'4103',	0,	'кг'),
(374,	'Банан',	'4104',	0,	'кг'),
(375,	'Виноград',	'4105',	0,	'кг'),
(376,	'Арахіс смажений',	'4106',	0,	'кг'),
(377,	'Горіх грецький ядро',	'4107',	0,	'кг'),
(378,	'Горіх кеш\'ю',	'4108',	0,	'кг'),
(379,	'Горіх фундук ядро сушений',	'4109',	0,	'кг'),
(380,	'Грейпфрут',	'4110',	0,	'кг'),
(381,	'Груша свіжа (рання) сезонна',	'4111',	0,	'кг'),
(382,	'Груша пізня',	'4112',	0,	'кг'),
(383,	'Груша консервована',	'4113',	0,	'кг'),
(384,	'Диня',	'4114',	0,	'кг'),
(385,	'Кавун',	'4115',	0,	'кг'),
(386,	'Ківі',	'4116',	0,	'кг'),
(387,	'Курага',	'4117',	0,	'кг'),
(388,	'Лимон',	'4118',	0,	'кг'),
(389,	'Мак',	'4119',	0,	'кг'),
(390,	'Малина свіжа',	'4120',	0,	'кг'),
(391,	'Мандарин',	'4121',	0,	'кг'),
(392,	'Персик консервований',	'4122',	0,	'кг'),
(393,	'Родзинки',	'4123',	0,	'кг'),
(394,	'Суміш сухофруктів',	'4124',	0,	'кг'),
(395,	'Суміш фруктів консервовані',	'4125',	0,	'кг'),
(396,	'Хурма',	'4126',	0,	'кг'),
(397,	'Черешня',	'4127',	0,	'кг'),
(398,	'Чорнослив без кісточки',	'4128',	0,	'кг'),
(399,	'Нектарин',	'4129',	0,	'кг'),
(400,	'Яблука свіжі сезонні',	'4130',	0,	'кг'),
(401,	'Яблука ранні',	'4131',	0,	'кг'),
(402,	'Яблука пізні',	'4132',	0,	'кг'),
(403,	'Насіння льону',	'4133',	0,	'кг'),
(404,	'Шипшина сушена',	'4134',	0,	'кг'),
(405,	'Слива свіжа сезонна',	'4135',	0,	'кг'),
(406,	'Гарбузове насіння чищене',	'4136',	0,	'кг'),
(407,	'Інжир сушений',	'4137',	0,	'кг'),
(408,	'Абрикос',	'4138',	0,	'кг'),
(409,	'Персик',	'4139',	0,	'кг'),
(410,	'Журавлина',	'4140',	0,	'кг'),
(411,	'Полуниця',	'4141',	0,	'кг'),
(412,	'Смородина чорна',	'4142',	0,	'кг'),
(413,	'Авокадо',	'4143',	0,	'кг'),
(414,	'Батон',	'5001',	0,	'кг'),
(415,	'Борошно житнє',	'5002',	0,	'кг'),
(416,	'Борошно пшеничне першого ґатунку',	'5003',	0,	'кг'),
(417,	'Борошно пшеничне другого ґатунку',	'5004',	0,	'кг'),
(418,	'Борошно пшеничне вищого ґатунку',	'5005',	0,	'кг'),
(419,	'Бублики',	'5006',	0,	'кг'),
(420,	'Вафлі з масляними начинками',	'5007',	0,	'кг'),
(421,	'Вафлі з фруктовими начинками',	'5008',	0,	'кг'),
(422,	'Галети',	'5009',	0,	'кг'),
(423,	'Здобна випічка',	'5010',	0,	'кг'),
(424,	'Печиво вівсяне',	'5011',	0,	'кг'),
(425,	'Печиво до кави',	'5012',	0,	'кг'),
(426,	'Печиво з листкового тіста з фруктовою начинкою',	'5013',	0,	'кг'),
(427,	'Печиво “Марія”',	'5014',	0,	'кг'),
(428,	'Сухарі',	'5015',	0,	'кг'),
(429,	'Хліб тривалого зберігання',	'5016',	0,	'кг'),
(430,	'Хліб житній',	'5017',	0,	'кг'),
(431,	'Хліб житній (нарізний)',	'5018',	0,	'кг'),
(432,	'Хліб з пшеничного борошна першого ґатунку',	'5019',	0,	'кг'),
(433,	'Хліб з пшеничного борошна першого ґатунку (нарізний)',	'5020',	0,	'кг'),
(434,	'Булочка для гамбургера',	'5021',	0,	'кг');

DROP TABLE IF EXISTS `book_item`;
CREATE TABLE `book_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `account_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `book_record`;
CREATE TABLE `book_record` (
  `id` int NOT NULL AUTO_INCREMENT,
  `document_id` int DEFAULT NULL,
  `type` enum('total','storage','department') NOT NULL,
  `item_id` int NOT NULL,
  `category` int DEFAULT NULL,
  `value` decimal(10,4) NOT NULL,
  `department_id` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `department_id` (`department_id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int DEFAULT NULL,
  `number` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `reg_number` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `type` enum('income','income_act','internal','outcome') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `form_id` int DEFAULT NULL,
  `status` enum('draft','active') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `document_forms`;
CREATE TABLE `document_forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `document_item`;
CREATE TABLE `document_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `document_id` int NOT NULL,
  `book_item_id` int DEFAULT NULL,
  `category` int DEFAULT NULL,
  `count` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`),
  KEY `book_item_id` (`book_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2024-03-11 17:49:42
