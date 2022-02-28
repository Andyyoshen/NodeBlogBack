-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-02-28 16:23:38
-- 伺服器版本： 10.3.16-MariaDB
-- PHP 版本： 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `books`
--

-- --------------------------------------------------------

--
-- 資料表結構 `bookslist`
--

CREATE TABLE `bookslist` (
  `id` int(11) NOT NULL,
  `ISBN` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `Version` text COLLATE utf8_unicode_ci NOT NULL,
  `BookName` text COLLATE utf8_unicode_ci NOT NULL,
  `Author` text COLLATE utf8_unicode_ci NOT NULL,
  `Price` int(10) NOT NULL,
  `OutDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `bookslist`
--

INSERT INTO `bookslist` (`id`, `ISBN`, `Version`, `BookName`, `Author`, `Price`, `OutDate`) VALUES
(59, '123-879-817-0', '123', '123213213', '\\\'作者\\\",;', 123123, '2022-02-02'),
(60, '123-999-878-8', '\\\'出版社\\\",;', '\\\'書名\\\",;', '\\\'作者\\\",;', 9998, '2022-02-12'),
(72, '123-897-852-9', '2a', '3', '5', 1, '2020-05-06'),
(76, '999-888-555-2', '2b', '3', '5', 6, '0000-00-00'),
(88, '888-555-666-3', '1', '2', '23', 11, '2021-02-22'),
(91, '888-555-666-6', '1', '2', '23', 13, '2021-02-22'),
(95, '888-555-666-0', '1', '2', '23', 14, '2021-02-22'),
(96, '854-878-999-5', '5456', '546', '456', 456, '2022-02-10'),
(97, '789-897-899-9', '88', '8', '8', 8, '2022-02-16'),
(98, '955-789-897-8', '9', '99', '9', 9, '2022-02-10'),
(99, '456-789-879-8', '5', '1', '1', 123, '2022-02-04');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `bookslist`
--
ALTER TABLE `bookslist`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `bookslist`
--
ALTER TABLE `bookslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
