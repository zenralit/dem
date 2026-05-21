-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 21 2026 г., 13:20
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `book`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `publisher_year` varchar(50) NOT NULL,
  `cover_type` varchar(100) NOT NULL,
  `book_state` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `reject_reason` text NOT NULL,
  `created_at` varchar(100) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `author`, `book_name`, `card_type`, `publisher`, `publisher_year`, `cover_type`, `book_state`, `status`, `reject_reason`, `created_at`) VALUES
(1, 1, 'ывапыва', 'ываыва', 'хочу в бмблиотеку', 'ываыва', '1212', 'ываыва', 'ываыва', 'approved', 'tdrujyysertszrthsxrfgh', '2026-05-20 22:58:02'),
(4, 1, 'tyhtyu', 'fghfgh', '', 'fghfgh', '234', 'ghjghj', 'fghjfgh', 'approved', 'dfgdfgdfg', '2026-05-20 23:03:18'),
(5, 1, 'wertjyrw', 'fdyhdtyaretetr', '', 'uhjrstyja5yh', '123123123', 'fhjdghjsgfdh', 'sdfghjdfghkjh', 'approved', '', '2026-05-21 11:23:36');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fullname`, `phone`, `email`, `login`, `password`) VALUES
(1, 'Рома', '+7(924)-779-89-40', 'useruser@gmail.com', 'zeent', 'f56489576624c56a9748ad42e142785e'),
(2, 'роман Новиков', '+7(924)-779-89-40', 'user@gmail.com', 'asd', 'e927dc7852a98359f58fdf3889c002ce'),
(3, 'ыва ыва ', '+7(924)-779-89-40', 'asdasdr@gmail.com', 'asdasd', 'a8f5f167f44f4964e6c998dee827110c');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
