-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 19 2016 г., 06:46
-- Версия сервера: 10.1.8-MariaDB-log
-- Версия PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ff`
--

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `fest_type_id` int(3) NOT NULL,
  `begin_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `img_link` varchar(250) NOT NULL,
  `status_id` int(2) NOT NULL,
  `year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id`, `fest_type_id`, `begin_date`, `finish_date`, `img_link`, `status_id`, `year`) VALUES
(1, 2, '2016-03-09', '2016-04-06', '8c2b14338167d4441334ce3309459ce5b598a80a', 1, 2016),
(2, 1, '2016-02-01', '2016-02-06', '9370606d0f15d8e1077507c1bd2b290387326e6b', 1, 2016),
(3, 1, '2015-02-01', '2015-02-06', '9370606d0f15d8e1077507c1bd2b290387326e6b', 3, 2015),
(4, 3, '2015-02-02', '2015-02-06', 'd7648dcf6945503f0cbe410df6719f72eebb7476', 3, 2015),
(5, 1, '2016-02-01', '2016-03-18', 'd7648dcf6945503f0cbe410df6719f72eebb7476', 1, 2016),
(6, 1, '2016-02-01', '2016-02-06', '9370606d0f15d8e1077507c1bd2b290387326e6b', 3, 2016),
(7, 1, '2016-02-01', '2016-02-06', '9370606d0f15d8e1077507c1bd2b290387326e6b', 1, 2016),
(8, 1, '2016-02-01', '2016-02-06', '9370606d0f15d8e1077507c1bd2b290387326e6b', 1, 2016),
(9, 1, '2016-02-01', '2016-02-06', '9370606d0f15d8e1077507c1bd2b290387326e6b', 1, 2016);

-- --------------------------------------------------------

--
-- Структура таблицы `event_status`
--

CREATE TABLE `event_status` (
  `id` int(1) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `event_status`
--

INSERT INTO `event_status` (`id`, `name`) VALUES
(1, 'Мотор'),
(2, 'В подготовке'),
(3, 'Завершён'),
(4, 'Отсутствует');

-- --------------------------------------------------------

--
-- Структура таблицы `fest_type`
--

CREATE TABLE `fest_type` (
  `id` int(11) NOT NULL,
  `name` varchar(66) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `fest_type`
--

INSERT INTO `fest_type` (`id`, `name`) VALUES
(1, 'Веницианский'),
(2, 'Московский'),
(3, 'Каннский');

-- --------------------------------------------------------

--
-- Структура таблицы `films`
--

CREATE TABLE `films` (
  `id` int(4) NOT NULL,
  `film_name` varchar(100) DEFAULT NULL,
  `img_link` varchar(300) DEFAULT NULL,
  `descr` text,
  `event_id` int(5) NOT NULL,
  `score` decimal(2,1) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `films`
--

INSERT INTO `films` (`id`, `film_name`, `img_link`, `descr`, `event_id`, `score`, `category_id`, `user_id`) VALUES
(1, 'DeadPool', NULL, NULL, 0, '6.0', 2, 1),
(2, 'Pulp Fiction', '46e01b3449cfa47074466eddca12de24ef6ca888', '<p>The lives of two mob hit men, a boxer, a gangster''s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.</p>\r\n<h4>Storyline</h4>\r\n<p>Jules Winnfield and Vincent Vega are two hitmen who are out to retrieve a suitcase stolen from their employer, mob boss Marsellus Wallace. Wallace has also asked Vincent to take his wife Mia out a few days later when Wallace himself will be out of town. Butch Coolidge is an aging boxer who is paid by Wallace to lose his next fight. The lives of these seemingly unrelated people are woven together comprising of a series of funny, bizarre and uncalled-for incidents.</p>', 4, '0.0', 2, 1),
(4, '&lt;h1&gt;Cry&lt;/h1&gt;', NULL, NULL, 0, '6.0', 3, 1),
(5, 'The Texas chainsaw messacre', 'c6ad2601e85c023e9ec6b84ccd05f8c47c5105f7', 'В штате Техас на ферме обычного работника скотобойни Томаса Хьюитта полиция обнаружила 33 изувеченных человеческих тела. Ужасающее открытие шокировало людей, и было названо самым жутким массовым убийством за все время. Газеты писали: «Дом террора национального масштаба. Бойня в Техасе». Пресса окрестила убийцу как «Человек с лицом из кожи». \r\n<br>\r\nМестные власти застрелили человека, носившего на лице кожаную маску. Дело было закрыто. Но в последующие годы, множество убийств показало, что полиция нашла не того преступника. Случайно уцелевший свидетель рассказал настоящую историю того, что на самом деле произошло на заброшенном техасском шоссе, когда пятеро подростков оказались в ловушке у безумного человека с бензопилой…', 3, '8.6', 3, 1),
(6, 'Ace Ventura: pet detective', 'c136110771df6b760767a5c8c0e106c1deac1965', 'Эйс Вентура - частный детектив, занимающийся поиском пропавших и похищенных домашних животных. Он отличается странной причёской, гавайской рубашкой и гипертрофированным чувством юмора. В начальной сцене фильма показано, как он ловко спас похищенную собачку, обманув похитителя с помощью игрушечной копии.\r\n\r\nЗа две недели до начала финального матча по американскому футболу со стадиона имени Джо Робби (ныне стадион «Долфин») неизвестные похищают главный талисман команды Майами Долфинс, дельфина по кличке Снежок. Мистер Риддл, владелец команды, понимает, что если во время проведения соревнований талисман будет отсутствовать, настрой игроков резко ухудшится, и при таком раскладе они обязательно проиграют важнейший матч сезона. Он приказывает главному менеджеру Роджеру Подактеру (Трой Эванс) и главному пресс-секретарю Мелиссе Робинсон (Кортни Кокс) до начала Суперкубка вернуть дельфина, иначе они будут уволены. Секретарь команды рекомендует Мелиссе обратиться за помощью к Эйсу Вентуре. После знакомства с Мелиссой и Подактером Эйс спускается в резервуар, в котором когда-то плавал Снежок, и находит первую улику преступления: редкой выделки янтарный камень.\r\n\r\nЭйс узнаёт, что в городе проживает некто Рональд Кэмп, успешный бизнесмен и коллекционер рыб и морских животных. Подозревая его в похищении, Эйс вместе с Мелиссой отправляется на званый ужин в загородный особняк. Там он обследует большой резервуар, но обнаруживает в нём только несколько больших белых акул. Уходя с вечеринки, Эйс замечает на пальце Кэмпа кольцо с точно таким же янтарным камнем, какой он нашёл в фильтре бассейна Снежка. Выясняется, что подобные кольца с треугольно-обработанным куском янтаря в 1984 году от американской футбольной конференции получили все игроки команды. Эйс делает вывод, что похитителем является тот игрок, в кольце которого не окажется камня. Но после тотальной проверки всего состава оказывается, что янтарь имеется у всех.\r\n\r\nВскоре погибает выпав из окна своей квартиры администратор команды дельфинов Роджер Подактер, Эйс заключает, что это убийство было заказным. Он пытается связать смерть менеджера команды с пропажей Снежка и случайно узнаёт о ещё одном игроке Дельфинов, центральном нападающем по имени Рэй Финкл, который отсутствовал в списке и не был проверен на наличие янтаря. Мелисса объясняет отсутствие Финкла на групповой фотографии тем, что он перешёл в команду только в середине сезона. Но кольцо он получил так же, как и остальные игроки. Выясняется, что карьера Финкла была довольно неудачной, в финальном матче того года на последних секундах игры он не забил верный гол, и Дельфины проиграли Суперкубок. Проклинаемый многочисленными фанатами он попытался продолжить выступления в чемпионате, но команда не продлила с ним контракт.\r\n\r\nЭйс отправляется в родной город Финкла Тампа и знакомится с его престарелыми родителями. Он посещает детскую комнату, по обстановке которой становится ясно, что Финкл ужасно ненавидит другого игрока Дельфинов Дэна Марино, который в том злополучном матче (финал 1984 года против Сан-Франциско Форти Найнерс) для пробития решающего удара поставил мяч шнуровкой к игроку, а не к воротам, из-за чего Финкл смазал удар, и Дельфины проиграли. Эйс и Мелисса решают, что Марино находится в смертельной опасности, но его похищают до того, как они успевают что-либо сделать.\r\n\r\nЭйс возвращается в Майами и рассказывает всё лейтенанту полиции Луис Эйнхорн (Шон Янг), женщине, занимающейся расследованием этого дела. Он предполагает, что мотивом похищения дельфина явился тот факт, что Снежку присвоили 5-й командный номер, который когда-то принадлежал Финклу. Финкл воспринял это как оскорбление и решил выпустить всю накопившуюся злость на несчастном водоплавающем животном.\r\n\r\nВ поисках Рэя Финкла Эйс посещает больницу для душевнобольных под названием «Тенистые Земли», в которую тот был когда-то насильственно помещён, и из которой когда-то сбежал. Изображая душевнобольного футболиста, Эйс обследует кладовую больницы и находит коробку с личными вещами Финкла. Среди них детектив обнаруживает вырезанную из газеты статью, в которой сообщается о пропаже девушки по имени Луис Эйнхорн, тело которой так и не было найдено. Эйс просит помощи у Эмилио, своего приятеля из полицейского участка, тот обследует ящики стола Эйнхорн и находит адресованное ей любовное письмо от Роджера Подактера.\r\n\r\nВсе попытки найти хоть какую-нибудь связь между Финклом и Эйнхорн заканчиваются неудачно, пока маленькая собака Эйса не ложится на фотографию Финкла. Шерсть собаки располагается таким образом, что у Финкла появляются волосы, то есть выставляет его в роли женщины. Наблюдая за этим, Эйс наконец понимает, что лейтенант Луис Эйнхорн — это на самом деле и есть бывший футболист Рэй Финкл. Эйс судорожно чистит зубы, сжигает одежду и принимает долгий-долгий душ, потому что намедни целовался с Эйнхорн, не зная, что она является мужчиной.\r\n\r\nПреследуя подозреваемую, Эйс попадает в портовые склады, где находит и Снежка, и Дэна Марино. Эйнхорн ловит его и немедленно вызывает полицию. Когда полицейские приезжают и уже собираются арестовать Эйса (по приказу Эйнхорн), появляются Мелисса и Эмилио и спасают своего друга. Эйс объясняет всем собравшимся мотивы Финкла и то, что Эйнхорн на самом деле не является той, за кого себя выдаёт. В качестве доказательства он срывает с неё платье и указывает всем на огромный член, зажатый между ног. В отчаянии Эйнхорн предпринимает последнюю попытку убийства Эйса, но падает в резервуар к Снежку. Эйс снимает с неё кольцо, на котором как раз не хватает маленького янтарного камня.\r\n\r\nФильм заканчивается сценой драки между Эйсом и талисманом команды Филадельфия Иглз. Во время футбольного матча Эйс пытался поймать редкого белого голубя (того, что был в начале), за которого назначена награда в 25 тысяч долларов. Но человек в костюме попугая спугивает птицу, в результате чего оказывается втянутым в ожесточённое противостояние с детективом домашних животных.', 3, '8.0', 6, 1),
(7, 'Requiem for a dream', '5032b8d7439c500b636363cca0a4737d8e192c48', 'Каждый из главных героев фильма стремился к своей заветной мечте. Сара Голдфарб мечтала сняться в известном телешоу, ее сын Гарольд со своим другом Тайроном — сказочно разбогатеть, подруга Гарольда Мэрион грезила о собственном модном магазине, но на их пути были всяческие препятствия. События фильма разворачиваются стремительно, герои погрязли в наркотиках. Мечты по-прежнему остаются недостижимыми, а жизни героев рушатся безвозвратно', 0, '0.0', 2, 1),
(8, 'Страшные сказки', 'd7648dcf6945503f0cbe410df6719f72eebb7476', 'Маги и волшебники, короли и королевы, красавицы-принцессы и страшилы-великаны населяют эту потрясающую готическую фантазию. Сластолюбивый Король Одинокого Утеса берет в жены прелестную деву, а она превращается в уродливую старуху. Отважный Король Долины Туманов отправляется на бой с драконом, поскольку волшебник предсказал, что королева понесет ребенка, если съест сердце дракона. Ну, а Король Диких Гор с любовью выращивает гигантскую блоху, а родную дочь без тени сожаления отдает в жены горному огру. За стенами величественных замков строятся коварные козни, даются безрассудные обеты, там страстно любят и жестоко убивают…', 4, '6.4', 8, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `film_category`
--

CREATE TABLE `film_category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `film_category`
--

INSERT INTO `film_category` (`id`, `cat_name`) VALUES
(1, 'Art Chaos'),
(2, 'Drama'),
(3, '<h3>Horror</h3>'),
(4, 'Action'),
(5, 'Adventure'),
(6, 'Comedy'),
(7, 'Science fiction'),
(8, 'Fantasy');

-- --------------------------------------------------------

--
-- Структура таблицы `link_film_nomination`
--

CREATE TABLE `link_film_nomination` (
  `id` int(4) NOT NULL,
  `film_id` int(10) UNSIGNED NOT NULL,
  `nomination_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `link_film_nomination`
--

INSERT INTO `link_film_nomination` (`id`, `film_id`, `nomination_id`) VALUES
(1, 5, 7),
(2, 5, 8),
(4, 5, 6),
(5, 4, 7),
(6, 6, 2),
(7, 2, 2),
(8, 6, 6),
(9, 5, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `link_user_film_score`
--

CREATE TABLE `link_user_film_score` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `link_user_film_score`
--

INSERT INTO `link_user_film_score` (`id`, `film_id`, `user_id`, `score`) VALUES
(1, 1, 1, 7),
(3, 5, 1, 5),
(4, 1, 3, 3),
(5, 6, 1, 8),
(6, 8, 1, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `nominations`
--

CREATE TABLE `nominations` (
  `nomination_id` int(4) UNSIGNED NOT NULL,
  `nomination_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `nominations`
--

INSERT INTO `nominations` (`nomination_id`, `nomination_name`) VALUES
(1, '0'),
(2, 'Гран-при'),
(3, 'Приз жюри'),
(4, 'Лучшая актриса'),
(6, 'Лучший актёр'),
(7, 'Лучшая режессура'),
(8, 'Лучший сценарий'),
(9, 'Золотой королевский пингвин');

-- --------------------------------------------------------

--
-- Структура таблицы `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) UNSIGNED NOT NULL,
  `note_text` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user notes';

--
-- Дамп данных таблицы `notes`
--

INSERT INTO `notes` (`note_id`, `note_text`, `user_id`) VALUES
(1, 'Something away', 1),
(2, 'asf', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `people_award`
--

CREATE TABLE `people_award` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `people_award`
--

INSERT INTO `people_award` (`id`, `event_id`, `film_id`) VALUES
(1, 4, 2),
(3, 3, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `session_id` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'stores session cookie id to prevent session concurrency',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
  `user_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s deletion status',
  `user_account_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'user''s account type (basic, premium, etc)',
  `user_has_avatar` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 if user has a local avatar, 0 if not',
  `user_remember_me_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
  `user_creation_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the creation of user''s account',
  `user_suspension_timestamp` bigint(20) DEFAULT NULL COMMENT 'Timestamp till the end of a user suspension',
  `user_last_login_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of user''s last login',
  `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attempts',
  `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
  `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
  `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
  `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
  `user_provider_type` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `session_id`, `user_name`, `user_password_hash`, `user_email`, `user_active`, `user_deleted`, `user_account_type`, `user_has_avatar`, `user_remember_me_token`, `user_creation_timestamp`, `user_suspension_timestamp`, `user_last_login_timestamp`, `user_failed_logins`, `user_last_failed_login`, `user_activation_hash`, `user_password_reset_hash`, `user_password_reset_timestamp`, `user_provider_type`) VALUES
(1, '4k756bipj7sudc5hf53aqjvqd0', 'demo', '$2y$10$OvprunjvKOOhM1h9bzMPs.vuwGIsOqZbw88rzSyGCTJTcE61g5WXi', 'demo@demo.com', 1, 0, 7, 1, NULL, 1422205178, NULL, 1457806497, 0, NULL, NULL, NULL, NULL, 'DEFAULT'),
(2, NULL, 'demo2', '$2y$10$OvprunjvKOOhM1h9bzMPs.vuwGIsOqZbw88rzSyGCTJTcE61g5WXi', 'demo2@demo.com', 1, 0, 1, 0, NULL, 1422205178, NULL, 1457375030, 0, NULL, NULL, NULL, NULL, 'DEFAULT'),
(3, NULL, 'Betty', '$2y$10$7pGnNAih63pdHE9sofN5KOCRQb4zzLWCb9fofuQMVjaA8M0tp.Uhe', 'Betty@mail.com', 1, 0, 1, 0, NULL, 1457719060, NULL, 1457719335, 0, NULL, '7f7657f8b0178b3ff1540db13aff9a7c4fa65412', NULL, NULL, 'DEFAULT');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_events`
--
CREATE TABLE `view_events` (
`id` int(11)
,`fest_type_name` varchar(66)
,`year` int(4)
,`event_status` varchar(25)
,`img_link` varchar(250)
,`begin_date` date
,`finish_date` date
);

-- --------------------------------------------------------

--
-- Структура для представления `view_events`
--
DROP TABLE IF EXISTS `view_events`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_events`  AS  select `events`.`id` AS `id`,`fest_type`.`name` AS `fest_type_name`,`events`.`year` AS `year`,`es`.`name` AS `event_status`,`events`.`img_link` AS `img_link`,`events`.`begin_date` AS `begin_date`,`events`.`finish_date` AS `finish_date` from ((`events` join `fest_type` on((`fest_type`.`id` = `events`.`fest_type_id`))) join `event_status` `es` on((`events`.`status_id` = `es`.`id`))) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `event_status`
--
ALTER TABLE `event_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fest_type`
--
ALTER TABLE `fest_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `film_category`
--
ALTER TABLE `film_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `link_film_nomination`
--
ALTER TABLE `link_film_nomination`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `link_user_film_score`
--
ALTER TABLE `link_user_film_score`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `nominations`
--
ALTER TABLE `nominations`
  ADD PRIMARY KEY (`nomination_id`);

--
-- Индексы таблицы `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Индексы таблицы `people_award`
--
ALTER TABLE `people_award`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `event_status`
--
ALTER TABLE `event_status`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `fest_type`
--
ALTER TABLE `fest_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `films`
--
ALTER TABLE `films`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `film_category`
--
ALTER TABLE `film_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `link_film_nomination`
--
ALTER TABLE `link_film_nomination`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `link_user_film_score`
--
ALTER TABLE `link_user_film_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `nominations`
--
ALTER TABLE `nominations`
  MODIFY `nomination_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `people_award`
--
ALTER TABLE `people_award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
