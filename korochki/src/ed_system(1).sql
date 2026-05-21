-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 15 2025 г., 09:02
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
-- База данных: `ed_system`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ADMIN`
--

CREATE TABLE `ADMIN` (
  `ID` int(11) NOT NULL,
  `FIO` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Role` varchar(255) DEFAULT NULL,
  `Hire_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `APPLICATION`
--

CREATE TABLE `APPLICATION` (
  `ID` int(11) NOT NULL,
  `COURSE_ID` int(11) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `Application_date` varchar(255) DEFAULT NULL,
  `Comments` varchar(255) DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `Desired_start_date` date DEFAULT NULL,
  `Payment_method` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `APPLICATION`
--

INSERT INTO `APPLICATION` (`ID`, `COURSE_ID`, `Status`, `Application_date`, `Comments`, `USER_ID`, `Desired_start_date`, `Payment_method`) VALUES
(1, 1, 'Обучение завершено', '2025-12-06 20:42:16', 'фыв', 1, '1212-12-12', 'наличными'),
(2, 1, 'Обучение завершено', '2025-12-06 21:04:46', 'ываыва', 2, '1212-12-12', 'карта'),
(4, 1, 'Обучение завершено', '2025-12-10 15:01:08', 'люблю', 6, '1212-12-12', 'карта');

-- --------------------------------------------------------

--
-- Структура таблицы `COURSE`
--

CREATE TABLE `COURSE` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Duration` varchar(255) DEFAULT NULL,
  `Price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `COURSE`
--

INSERT INTO `COURSE` (`ID`, `Name`, `Description`, `Duration`, `Price`) VALUES
(1, 'программирование', 'крутые языки и воопбще хорошим программистом будешь', 'ееее круто', 9999);

-- --------------------------------------------------------

--
-- Структура таблицы `PAYMENT`
--

CREATE TABLE `PAYMENT` (
  `ID` int(11) NOT NULL,
  `Amount` float DEFAULT NULL,
  `Payment_date` varchar(255) DEFAULT NULL,
  `Payment_method` varchar(255) DEFAULT NULL,
  `APPLICATION_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `REVIEWS`
--

CREATE TABLE `REVIEWS` (
  `ID` int(11) NOT NULL,
  `APPLICATION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `Review_text` text NOT NULL,
  `Rating` int(11) NOT NULL CHECK (`Rating` >= 1 and `Rating` <= 5),
  `Created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `REVIEWS`
--

INSERT INTO `REVIEWS` (`ID`, `APPLICATION_ID`, `USER_ID`, `Review_text`, `Rating`, `Created_at`) VALUES
(1, 1, 1, 'asdasdasdasd', 5, '2025-12-06 20:54:07'),
(5, 2, 2, '((((', 3, '2025-12-06 21:05:28'),
(7, 4, 6, 'круто', 5, '2025-12-10 15:01:48');

-- --------------------------------------------------------

--
-- Структура таблицы `USER`
--

CREATE TABLE `USER` (
  `ID` int(11) NOT NULL,
  `FIO` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Login` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Birth_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `USER`
--

INSERT INTO `USER` (`ID`, `FIO`, `Phone`, `Email`, `Login`, `Password`, `Address`, `Birth_date`) VALUES
(1, 'фыв фыв фыв ', '123123123', 'asd@gmail.com', 'фывфыв', '$2y$10$f6z1wnpSJQC3OfXbJ3CpmeLjGaG3qVsAKbyZ3Q1AAkDjEObBL6ZGi', NULL, NULL),
(2, 'йцу йцу йцу', '123123123', 'user@gmail.com', 'йцуйцу', '$2y$10$fnxajgCo3UVcWfWzWGjrjOqp2BuCkkKs0dKEzJHL6KZIN3gXZmzU6', NULL, NULL),
(6, 'ячс ячс ячс', '8924779840', 'zxc@gmail.com', 'ячсячс', '$2y$10$exPz34x3W33qoLuVglAS5eYIlZnfQ3CCxs5/DX.jwh89suJgO5Nwy', NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `APPLICATION`
--
ALTER TABLE `APPLICATION`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `COURSE_ID` (`COURSE_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Индексы таблицы `COURSE`
--
ALTER TABLE `COURSE`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `PAYMENT`
--
ALTER TABLE `PAYMENT`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `APPLICATION_ID` (`APPLICATION_ID`);

--
-- Индексы таблицы `REVIEWS`
--
ALTER TABLE `REVIEWS`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `APPLICATION_ID` (`APPLICATION_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Индексы таблицы `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ADMIN`
--
ALTER TABLE `ADMIN`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `APPLICATION`
--
ALTER TABLE `APPLICATION`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `COURSE`
--
ALTER TABLE `COURSE`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `PAYMENT`
--
ALTER TABLE `PAYMENT`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `REVIEWS`
--
ALTER TABLE `REVIEWS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `USER`
--
ALTER TABLE `USER`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `APPLICATION`
--
ALTER TABLE `APPLICATION`
  ADD CONSTRAINT `APPLICATION_ibfk_1` FOREIGN KEY (`COURSE_ID`) REFERENCES `COURSE` (`ID`),
  ADD CONSTRAINT `APPLICATION_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `USER` (`ID`);

--
-- Ограничения внешнего ключа таблицы `PAYMENT`
--
ALTER TABLE `PAYMENT`
  ADD CONSTRAINT `PAYMENT_ibfk_1` FOREIGN KEY (`APPLICATION_ID`) REFERENCES `APPLICATION` (`ID`);

--
-- Ограничения внешнего ключа таблицы `REVIEWS`
--
ALTER TABLE `REVIEWS`
  ADD CONSTRAINT `REVIEWS_ibfk_1` FOREIGN KEY (`APPLICATION_ID`) REFERENCES `APPLICATION` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `REVIEWS_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `USER` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
