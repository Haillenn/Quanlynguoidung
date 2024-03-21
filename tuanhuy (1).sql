-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 31, 2024 lúc 03:25 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tuanhuy`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hocsinh`
--

CREATE TABLE `hocsinh` (
  `id` int(30) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `age` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hocsinh`
--

INSERT INTO `hocsinh` (`id`, `fullname`, `age`) VALUES
(1, 'dhuiahduiqdhiuqhduiqhduiqhduiqhdquidhuqihduiqdhqui', NULL),
(2, 'Tuan huy', 18);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tokenlogin`
--

CREATE TABLE `tokenlogin` (
  `id` int(11) NOT NULL,
  `user_Id` int(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tokenlogin`
--

INSERT INTO `tokenlogin` (`id`, `user_Id`, `token`, `create_at`) VALUES
(1, 2, '4269b1146a9368ad19093184f75a5aa22ecf4bfc', '2024-01-30 18:35:03'),
(2, NULL, '26661d1c1fdd5713404cb271de41d363454537b7', '2024-01-31 10:46:18'),
(7, NULL, '04cd0bdbc3c5a0a3d4a6b8baf4a0bf919b561e9e', '2024-01-31 15:12:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `forgotToken` varchar(100) DEFAULT NULL,
  `activeToken` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password`, `forgotToken`, `activeToken`, `status`, `create_at`, `update_at`) VALUES
(2, 'Bùi Tuấn Huy', 'comudation.1@gmail.com', '0384869336', '$2y$10$qYSD24nHYn/KlDhAH/F3.eiPlPPlfyKzAhK0A6YuBtTOVcN29zawu', NULL, '806be6b15ef12de6e9f1679f70203fadb3387cc9', 1, '2024-01-29 13:53:58', '2024-01-31 10:41:54'),
(4, 'Bùi Tuấn Huy', 'tuanhuy8a3@gmail.com', '0384869336', '$2y$10$0kIBQiY8lz5aOLHNusmI5.vlhXLKEg1Mt/Me6NfaaO.KspP3.KR52', NULL, 'dba62d038c22cf51ebd3eb89e441330e08660332', 0, '2024-01-31 15:13:29', NULL),
(5, 'Bùi Tuấn Huy', 'comudation.12@gmail.com', '0384869336', '$2y$10$.E0hs0oxV6EYp9rud/uk1OaL71YnBWb8SypuyZzQrY4axupMJdK8K', NULL, '7ea7482354ad725ddfbd036d348dcccc86a859dc', 0, '2024-01-30 18:00:30', NULL),
(9, 'Bùi Tuấn Huy', 'huybuituan21@gmail.com', '0384869336', '$2y$10$ziDKK2IKiCxB/6CdC4Uc3efvwqFylBLALTrLWw2heVA3W5RmcMhmK', NULL, '6059df2539ab9a40b2b888a343f2bdfdfd06aeaa', 0, '2024-01-30 18:13:55', NULL),
(15, 'Bùi Tuấn Huy', 'comudation.13@gmail.com', '0384869336', '$2y$10$0VUwOnXGYUXJCo8yF1k./ebnpgSVSsQs83y/iMo0bWpcu7qYFYjbe', NULL, NULL, 1, '2024-01-31 15:03:29', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `hocsinh`
--
ALTER TABLE `hocsinh`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tokenlogin`
--
ALTER TABLE `tokenlogin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_Id` (`user_Id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `hocsinh`
--
ALTER TABLE `hocsinh`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tokenlogin`
--
ALTER TABLE `tokenlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tokenlogin`
--
ALTER TABLE `tokenlogin`
  ADD CONSTRAINT `tokenlogin_ibfk_1` FOREIGN KEY (`user_Id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
