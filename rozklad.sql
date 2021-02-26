-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 26 2021 г., 13:46
-- Версия сервера: 10.4.17-MariaDB
-- Версия PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `rozklad`
--

-- --------------------------------------------------------

--
-- Структура таблицы `grp_2020_2021_1`
--

CREATE TABLE `grp_2020_2021_1` (
  `id_groups` int(11) NOT NULL,
  `faculty_id` text DEFAULT NULL,
  `Kurs` int(2) DEFAULT NULL,
  `name_groups` text DEFAULT NULL,
  `nomber_groups` text DEFAULT NULL,
  `quantity` text DEFAULT NULL,
  `foreign_quantity` int(11) NOT NULL DEFAULT 0,
  `expelled_students` int(11) NOT NULL DEFAULT 0,
  `international_practice` int(11) NOT NULL DEFAULT 0,
  `subgroup` text DEFAULT NULL,
  `specialnost` int(11) NOT NULL,
  `view` int(2) NOT NULL DEFAULT 1,
  `checked` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `grp_2020_2021_1`
--

INSERT INTO `grp_2020_2021_1` (`id_groups`, `faculty_id`, `Kurs`, `name_groups`, `nomber_groups`, `quantity`, `foreign_quantity`, `expelled_students`, `international_practice`, `subgroup`, `specialnost`, `view`, `checked`) VALUES
(1, '3', 3, '322', NULL, NULL, 0, 0, 0, 'б', 0, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `online_2020_2021_2`
--

CREATE TABLE `online_2020_2021_2` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `code` text NOT NULL,
  `setdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `online_2020_2021_2`
--

INSERT INTO `online_2020_2021_2` (`id`, `id_item`, `week`, `code`, `setdate`) VALUES
(1, 1, 26, 'Идентификатор конференции 352 306 6371\r\nSecurityКод доступа  6cELPd \r\nInvite Link\r\nhttps://us02web.zoom.us/j/3523066371?pwd=b20yM1I5UHlBa24wOVQzc3RlUE1Pdz09', '2021-02-18 17:23:39'),
(2, 6, 25, 'Подключиться к конференции Zoom\r\nhttps://us04web.zoom.us/j/76292439716?pwd=OXNCdUhIQU42QWxybWswcUN5Q0NLQT09', '2021-02-18 17:23:45'),
(3, 4, 25, 'Тема физика\r\nОписание механика\r\nВремя\r\n23 сен 2020 11:30 AM Киев\r\nДобавить к     Google Календарь    Outlook Календарь (.ics)   Yahoo календарь\r\nИдентификатор конференции 898 7280 6673\r\nSecurityКод доступа   9n95Au Скрыть  Зал ожидания\r\nInvite Link\r\nhttps://us02web.zoom.us/j/89872806673?pwd=QkZlRVA0YkI5ckNGdTBGSm5lS25JQT09', '2021-02-19 11:25:39');

-- --------------------------------------------------------

--
-- Структура таблицы `planes`
--

CREATE TABLE `planes` (
  `id_subject` int(11) NOT NULL,
  `name_subject` text DEFAULT NULL,
  `short_subject` text DEFAULT NULL,
  `id_specialnost` int(11) NOT NULL,
  `kafedra` int(11) NOT NULL,
  `control` int(11) NOT NULL,
  `Hours` int(11) NOT NULL,
  `KP_type` int(11) NOT NULL,
  `sem` int(11) DEFAULT NULL,
  `Lect` int(11) DEFAULT NULL,
  `Prakt` int(11) DEFAULT NULL,
  `Lab` int(11) DEFAULT NULL,
  `KP` int(11) NOT NULL,
  `potok_id` int(11) NOT NULL,
  `modul` enum('1','2','3','4') NOT NULL DEFAULT '2',
  `assisted` enum('yes','no') NOT NULL DEFAULT 'no',
  `calculate_for_stat` tinyint(4) NOT NULL DEFAULT 1,
  `lastsem` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `planes`
--

INSERT INTO `planes` (`id_subject`, `name_subject`, `short_subject`, `id_specialnost`, `kafedra`, `control`, `Hours`, `KP_type`, `sem`, `Lect`, `Prakt`, `Lab`, `KP`, `potok_id`, `modul`, `assisted`, `calculate_for_stat`, `lastsem`) VALUES
(1, 'Объектно-ориентированное программирование', 'ООП', 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, '2', 'no', 1, 0),
(2, 'Базы данных', 'БД', 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, '2', 'no', 1, 0),
(3, 'Английский язык ', 'Англ. яз.', 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, '2', 'no', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `room`
--

CREATE TABLE `room` (
  `id_room` int(11) NOT NULL,
  `box` text DEFAULT NULL,
  `nomber_room` text DEFAULT NULL,
  `capacity` text DEFAULT NULL,
  `area` float NOT NULL,
  `kafedra_id` text DEFAULT NULL,
  `specialization` text DEFAULT NULL,
  `Inform` text NOT NULL,
  `Korp` tinyint(4) NOT NULL DEFAULT 0,
  `educational` tinyint(1) NOT NULL DEFAULT 0,
  `photo_url` text CHARACTER SET utf8 NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `room`
--

INSERT INTO `room` (`id_room`, `box`, `nomber_room`, `capacity`, `area`, `kafedra_id`, `specialization`, `Inform`, `Korp`, `educational`, `photo_url`, `deleted`) VALUES
(1, 'ДВ', '322', NULL, 0, NULL, NULL, '', 0, 0, '', 0),
(2, 'А', '101', NULL, 0, NULL, NULL, '', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `id_teacher` int(11) NOT NULL,
  `familia` text CHARACTER SET cp1251 NOT NULL,
  `imya` text CHARACTER SET cp1251 NOT NULL,
  `otchestvo` text CHARACTER SET cp1251 NOT NULL,
  `zvanie_id` text CHARACTER SET cp1251 NOT NULL,
  `stepen_id` text CHARACTER SET cp1251 NOT NULL,
  `diploma_head` tinyint(1) NOT NULL DEFAULT 0,
  `Info` text CHARACTER SET cp1251 COLLATE cp1251_ukrainian_ci NOT NULL,
  `contacts` text NOT NULL,
  `is_employee` int(11) NOT NULL DEFAULT 0,
  `Deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`id_teacher`, `familia`, `imya`, `otchestvo`, `zvanie_id`, `stepen_id`, `diploma_head`, `Info`, `contacts`, `is_employee`, `Deleted`) VALUES
(1, 'Иванова', 'Елена', 'Викторовна', '', '', 0, '', '', 0, 0),
(2, 'Шарикова', 'Юлия', 'Андреевна', '', '', 0, '', '', 0, 0),
(3, 'Левандовский', 'Грег', 'Евгеньевич ', '', '', 0, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tt_2020_2021_1`
--

CREATE TABLE `tt_2020_2021_1` (
  `id_item` int(11) NOT NULL,
  `day` enum('1','2','3','4','5','6') NOT NULL,
  `lesson` enum('1','2','3','4','5','6','7','8','9') NOT NULL,
  `group_id` smallint(4) NOT NULL,
  `room_id` text NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` smallint(4) NOT NULL,
  `tasktype` tinyint(2) NOT NULL,
  `begin` tinyint(2) NOT NULL,
  `end` tinyint(2) NOT NULL,
  `stars` enum('**','***','*') NOT NULL,
  `no_control` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tt_2020_2021_1`
--

INSERT INTO `tt_2020_2021_1` (`id_item`, `day`, `lesson`, `group_id`, `room_id`, `subject_id`, `teacher_id`, `tasktype`, `begin`, `end`, `stars`, `no_control`) VALUES
(1, '3', '2', 1, '1', 1, 1, 1, 25, 28, '***', 0),
(2, '1', '4', 1, '1', 1, 1, 2, 26, 28, '***', 0),
(3, '4', '2', 1, '1', 1, 1, 2, 2, 8, '**', 0),
(4, '3', '4', 1, '1', 1, 1, 1, 19, 29, '*', 0),
(5, '2', '1', 1, '1', 2, 2, 1, 20, 26, '**', 0),
(6, '2', '3', 1, '1', 2, 2, 1, 20, 26, '**', 0),
(7, '3', '1', 1, '1', 3, 3, 1, 24, 28, '***', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `weeks_2020_2021_1`
--

CREATE TABLE `weeks_2020_2021_1` (
  `id` int(11) NOT NULL,
  `week_num` int(3) DEFAULT NULL,
  `week_begin` date DEFAULT NULL,
  `week_end` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `weeks_2020_2021_1`
--

INSERT INTO `weeks_2020_2021_1` (`id`, `week_num`, `week_begin`, `week_end`) VALUES
(1, 1, '2020-08-31', '2020-09-06'),
(2, 2, '2020-09-07', '2020-09-13'),
(3, 3, '2020-09-14', '2020-09-20'),
(4, 4, '2020-09-21', '2020-09-27'),
(5, 5, '2020-09-28', '2020-10-04'),
(6, 6, '2020-10-05', '2020-10-11'),
(7, 7, '2020-10-12', '2020-10-18'),
(8, 8, '2020-10-19', '2020-10-25'),
(9, 9, '2020-10-26', '2020-11-01'),
(10, 10, '2020-11-02', '2020-11-08'),
(11, 11, '2020-11-09', '2020-11-15'),
(12, 12, '2020-11-16', '2020-11-22'),
(13, 13, '2020-11-23', '2020-11-29'),
(14, 14, '2020-11-30', '2020-12-06'),
(15, 15, '2020-12-07', '2020-12-13'),
(16, 16, '2020-12-14', '2020-12-20'),
(17, 17, '2020-12-21', '2020-12-27'),
(18, 18, '2020-12-28', '2021-01-03'),
(19, 19, '2021-01-04', '2021-01-10'),
(20, 20, '2021-01-11', '2021-01-17'),
(21, 21, '2021-01-18', '2021-01-24'),
(22, 22, '2021-01-25', '2021-01-31'),
(23, 23, '2021-02-01', '2021-02-07'),
(24, 24, '2021-02-08', '2021-02-14'),
(25, 25, '2021-02-15', '2021-02-21'),
(26, 26, '2021-02-22', '2021-02-28'),
(27, 27, '2021-03-01', '2021-03-07'),
(28, 28, '2021-03-08', '2021-03-14'),
(29, 29, '2021-03-15', '2021-03-21'),
(30, 30, '2021-03-22', '2021-03-28'),
(58, 44, '2021-06-28', '2021-07-04'),
(57, 43, '2021-06-21', '2021-06-27'),
(56, 42, '2021-06-14', '2021-06-20'),
(55, 41, '2021-06-07', '2021-06-13'),
(54, 40, '2021-05-31', '2021-06-06'),
(53, 39, '2021-05-24', '2021-05-30'),
(52, 38, '2021-05-17', '2021-05-23'),
(51, 37, '2021-05-10', '2021-05-16'),
(50, 36, '2021-05-03', '2021-05-09'),
(49, 35, '2021-04-26', '2021-05-02'),
(48, 34, '2021-04-19', '2021-04-25'),
(47, 33, '2021-04-12', '2021-04-18'),
(46, 32, '2021-04-05', '2021-04-11'),
(45, 31, '2021-03-29', '2021-04-04');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `grp_2020_2021_1`
--
ALTER TABLE `grp_2020_2021_1`
  ADD PRIMARY KEY (`id_groups`);

--
-- Индексы таблицы `online_2020_2021_2`
--
ALTER TABLE `online_2020_2021_2`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id_subject`);

--
-- Индексы таблицы `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id_room`);
ALTER TABLE `room` ADD FULLTEXT KEY `Inform` (`Inform`);

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id_teacher`);

--
-- Индексы таблицы `tt_2020_2021_1`
--
ALTER TABLE `tt_2020_2021_1`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `Subj` (`subject_id`),
  ADD KEY `Teacher` (`teacher_id`),
  ADD KEY `Group` (`group_id`),
  ADD KEY `Room` (`room_id`(4)),
  ADD KEY `day` (`day`,`lesson`,`group_id`,`teacher_id`);

--
-- Индексы таблицы `weeks_2020_2021_1`
--
ALTER TABLE `weeks_2020_2021_1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `grp_2020_2021_1`
--
ALTER TABLE `grp_2020_2021_1`
  MODIFY `id_groups` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `online_2020_2021_2`
--
ALTER TABLE `online_2020_2021_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `planes`
--
ALTER TABLE `planes`
  MODIFY `id_subject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `room`
--
ALTER TABLE `room`
  MODIFY `id_room` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id_teacher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tt_2020_2021_1`
--
ALTER TABLE `tt_2020_2021_1`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `weeks_2020_2021_1`
--
ALTER TABLE `weeks_2020_2021_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
