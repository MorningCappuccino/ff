-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 05 2016 г., 12:55
-- Версия сервера: 10.1.8-MariaDB
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
  `type_name` int(11) NOT NULL,
  `begin_date` date NOT NULL,
  `finish_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fest_type`
--

CREATE TABLE `fest_type` (
  `id` int(11) NOT NULL,
  `name` int(66) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `score` tinyint(2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `films`
--

INSERT INTO `films` (`id`, `film_name`, `img_link`, `descr`, `event_id`, `score`, `category_id`, `user_id`) VALUES
(1, 'DeadPool', NULL, NULL, 0, 0, 2, 1),
(2, 'Тайм-код', NULL, NULL, 0, 0, 1, 1),
(4, '&lt;h1&gt;Cry&lt;/h1&gt;', NULL, NULL, 0, 0, 3, 1),
(5, 'The Texas chainsaw messacre1', NULL, NULL, 0, 0, 3, 1),
(6, 'Ace Ventura: pet detective', NULL, NULL, 0, 0, 0, 1);

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
(7, 'Science fiction');

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
(6, 6, 2);

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
(3, 5, 1, 5);

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
(1, 'bjdnn29t1ftoo4jc26c0dcek84', 'demo', '$2y$10$OvprunjvKOOhM1h9bzMPs.vuwGIsOqZbw88rzSyGCTJTcE61g5WXi', 'demo@demo.com', 1, 0, 7, 0, '99a62452c0aa2c680ade632831c5b6f0bec36173a4328ff2f33245a0fd81bae5', 1422205178, NULL, 1457167488, 0, NULL, NULL, NULL, NULL, 'DEFAULT'),
(2, NULL, 'demo2', '$2y$10$OvprunjvKOOhM1h9bzMPs.vuwGIsOqZbw88rzSyGCTJTcE61g5WXi', 'demo2@demo.com', 1, 0, 1, 0, NULL, 1422205178, NULL, 1422209189, 0, NULL, NULL, NULL, NULL, 'DEFAULT');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `fest_type`
--
ALTER TABLE `fest_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `films`
--
ALTER TABLE `films`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `film_category`
--
ALTER TABLE `film_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `link_film_nomination`
--
ALTER TABLE `link_film_nomination`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `link_user_film_score`
--
ALTER TABLE `link_user_film_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
