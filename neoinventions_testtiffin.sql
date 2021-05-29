-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2021 at 11:17 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neoinventions_testtiffin`
--

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audits`
--

INSERT INTO `audits` (`id`, `user_type`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(3073, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"remember_token\":\"b1UWHGMqT5X3Hq3VUorZhZQxiHzU51FwDsfDqSKeqZPdizEFh4gvqhD5yIOF\"}', '{\"remember_token\":\"4GqgvcALeHAE8CmzgU5HyVjQSsxIyIxndkiK5v8VZFGl2wI8zqEEdQ3UMyO7\"}', 'https://www.neoinventions.com/dailytiffin/logout?', '203.88.145.30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-11 00:20:46', '2021-05-11 00:20:46'),
(3074, 'App\\User', 2, 'created', 'App\\Category', 15, '[]', '{\"name\":\"Sweets\",\"description\":null,\"main_category_id\":\"3\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":15}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 00:04:59', '2021-05-24 00:04:59'),
(3075, 'App\\User', 2, 'created', 'App\\Category', 16, '[]', '{\"name\":\"Namkeen\",\"description\":null,\"main_category_id\":\"3\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":16}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 00:05:23', '2021-05-24 00:05:23'),
(3076, 'App\\User', 2, 'created', 'App\\Category', 17, '[]', '{\"name\":\"Bread\",\"description\":null,\"main_category_id\":\"3\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":17}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 00:05:55', '2021-05-24 00:05:55'),
(3077, 'App\\User', 2, 'created', 'App\\Product', 76, '[]', '{\"p_name\":\"Bundi Ladu\",\"p_code\":\"MSW0001\",\"description\":\"Bundi Ladu\",\"categories_id\":\"15\",\"price\":\"5\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"\",\"small_image\":\"\",\"id\":76}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 00:07:26', '2021-05-24 00:07:26'),
(3078, 'App\\User', 2, 'updated', 'App\\Product', 76, '{\"image\":\"\",\"small_image\":\"\"}', '{\"image\":\"public\\/products\\/1621869472bundi-ladoo-500x500.jpg\",\"small_image\":\"public\\/products\\/small\\/1621869472bundi-ladoo-500x500.jpg\"}', 'https://www.neoinventions.com/dailytiffin/product/76?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:17:54', '2021-05-24 09:17:54'),
(3079, 'App\\User', 2, 'created', 'App\\Product', 77, '[]', '{\"p_name\":\"Kaju Katli\",\"p_code\":\"MSW00002\",\"description\":\"Kaju Katali 200 gm\",\"categories_id\":\"15\",\"price\":\"5\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"public\\/products\\/1621869698kaju-katli-500x500.jpg\",\"small_image\":\"public\\/products\\/small\\/1621869698kaju-katli-500x500.jpg\",\"id\":77}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:21:39', '2021-05-24 09:21:39'),
(3080, 'App\\User', 2, 'updated', 'App\\Product', 76, '{\"description\":\"Bundi Ladu\"}', '{\"description\":\"Bundi Ladu 5 pieces.\"}', 'https://www.neoinventions.com/dailytiffin/product/76?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:21:52', '2021-05-24 09:21:52'),
(3081, 'App\\User', 2, 'created', 'App\\Product', 78, '[]', '{\"p_name\":\"Mohanthal\",\"p_code\":\"MSW0003\",\"description\":\"Mohanthal Gram Flour Fudge 5 pieces\",\"categories_id\":\"15\",\"price\":\"5\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"public\\/products\\/1621869992Mohanthal.jpg\",\"small_image\":\"public\\/products\\/small\\/1621869992Mohanthal.jpg\",\"id\":78}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:26:34', '2021-05-24 09:26:34'),
(3082, 'App\\User', 2, 'created', 'App\\Product', 79, '[]', '{\"p_name\":\"Ratlami Sev\",\"p_code\":\"MNAM0001\",\"description\":\"Dahod Style Ratlami Sev\",\"categories_id\":\"16\",\"price\":\"5\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"public\\/products\\/1621870689RatlamiSev.jpg\",\"small_image\":\"public\\/products\\/small\\/1621870689RatlamiSev.jpg\",\"id\":79}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:38:10', '2021-05-24 09:38:10'),
(3083, 'App\\User', 2, 'created', 'App\\Product', 80, '[]', '{\"p_name\":\"Khari Sing\",\"p_code\":\"MNAM002\",\"description\":\"Bharuchi Khari sing\",\"categories_id\":\"16\",\"price\":\"3\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"public\\/products\\/1621870721Khari Sing.jpg\",\"small_image\":\"public\\/products\\/small\\/1621870721Khari Sing.jpg\",\"id\":80}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:38:41', '2021-05-24 09:38:41'),
(3084, 'App\\User', 2, 'created', 'App\\Product', 81, '[]', '{\"p_name\":\"Kenyan Chevdo\",\"p_code\":\"MNAM003\",\"description\":\"Tropical Heat Kenyan Chevdo\",\"categories_id\":\"16\",\"price\":\"6\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"public\\/products\\/1621870793KenyanChevdo.jpg\",\"small_image\":\"public\\/products\\/small\\/1621870793KenyanChevdo.jpg\",\"id\":81}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:39:53', '2021-05-24 09:39:53'),
(3085, 'App\\User', 2, 'created', 'App\\Product', 82, '[]', '{\"p_name\":\"Rotli 5pc\",\"p_code\":\"MBR001\",\"description\":\"Gujarati Rotali 5 Pc\",\"categories_id\":\"17\",\"price\":\"3\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"\",\"small_image\":\"\",\"id\":82}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:40:48', '2021-05-24 09:40:48'),
(3086, 'App\\User', 2, 'updated', 'App\\Product', 82, '{\"image\":\"\",\"small_image\":\"\"}', '{\"image\":\"public\\/products\\/1621870967Rotali.jpg\",\"small_image\":\"public\\/products\\/small\\/1621870967Rotali.jpg\"}', 'https://www.neoinventions.com/dailytiffin/product/82?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:42:47', '2021-05-24 09:42:47'),
(3087, 'App\\User', 2, 'created', 'App\\Product', 83, '[]', '{\"p_name\":\"Rotli 10pc\",\"p_code\":\"MBR0002\",\"description\":\"Gujarati Rotali 10 Pc\",\"categories_id\":\"17\",\"price\":\"5\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"public\\/products\\/1621871017Rotali.jpg\",\"small_image\":\"public\\/products\\/small\\/1621871017Rotali.jpg\",\"id\":83}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:43:37', '2021-05-24 09:43:37'),
(3088, 'App\\User', 2, 'created', 'App\\Product', 84, '[]', '{\"p_name\":\"Methi thepla 5 pc\",\"p_code\":\"MBR0003\",\"description\":\"Methi na Thepla 5 Pc.\",\"categories_id\":\"17\",\"price\":\"5\",\"is_featured\":\"yes\",\"is_visible\":\"yes\",\"main_categories_id\":3,\"image\":\"public\\/products\\/1621871177Dhebra.jpg\",\"small_image\":\"public\\/products\\/small\\/1621871177Dhebra.jpg\",\"id\":84}', 'https://www.neoinventions.com/dailytiffin/product?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:46:17', '2021-05-24 09:46:17'),
(3089, 'App\\User', 2, 'created', 'App\\Category', 18, '[]', '{\"name\":\"Subji\",\"description\":\"Veg Curries\",\"main_category_id\":\"2\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":18}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:50:29', '2021-05-24 09:50:29'),
(3090, 'App\\User', 2, 'created', 'App\\Category', 19, '[]', '{\"name\":\"Bread\",\"description\":\"Roti Naan etc\",\"main_category_id\":\"2\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":19}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:51:03', '2021-05-24 09:51:03'),
(3091, 'App\\User', 2, 'created', 'App\\Category', 20, '[]', '{\"name\":\"Sweets\",\"description\":\"Sweets\",\"main_category_id\":\"2\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":20}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:51:24', '2021-05-24 09:51:24'),
(3092, 'App\\User', 2, 'created', 'App\\Category', 21, '[]', '{\"name\":\"Drinks\",\"description\":\"Drinks\",\"main_category_id\":\"2\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":21}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:52:02', '2021-05-24 09:52:02'),
(3093, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"remember_token\":\"4GqgvcALeHAE8CmzgU5HyVjQSsxIyIxndkiK5v8VZFGl2wI8zqEEdQ3UMyO7\"}', '{\"remember_token\":\"EysaqAlzKjOJFtKi5f6wOoakq9j5sc6vkDvcvZ8mMQgJehLWpt2kYuTo0Tnu\"}', 'https://www.neoinventions.com/dailytiffin/logout?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 09:53:11', '2021-05-24 09:53:11'),
(3094, 'App\\User', 2, 'created', 'App\\Category', 22, '[]', '{\"name\":\"Daily\",\"description\":\"Daily Tiffin\",\"main_category_id\":\"1\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":22}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:23:18', '2021-05-24 10:23:18'),
(3095, 'App\\User', 2, 'created', 'App\\Product', 85, '[]', '{\"p_name\":\"Veg Tiffin\",\"p_code\":\"veg-tiffin1621873420\",\"description\":\"<div>Kadhi&nbsp;<br><\\/div><div>Bhat&nbsp;<\\/div><div>Bharela Bhinda nu Saak&nbsp;<\\/div><div>Mug ni Dal&nbsp;<\\/div><div>Rotli&nbsp;<\\/div><div>Pickle<\\/div>\",\"categories_id\":\"22\",\"main_categories_id\":1,\"price\":\"10\",\"is_featured\":\"no\",\"is_visible\":\"yes\",\"tiffin_preparation_date\":\"2021-05-25\",\"image\":\"public\\/products\\/1609569332tiffin.png\",\"small_image\":\"public\\/products\\/small\\/1609570657tiffin.png\",\"id\":85}', 'https://www.neoinventions.com/dailytiffin/tiffinproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:23:40', '2021-05-24 10:23:40'),
(3096, 'App\\User', 2, 'created', 'App\\Product', 86, '[]', '{\"p_name\":\"Veg Tiffin\",\"p_code\":\"veg-tiffin1621873546\",\"description\":\"<div>Tadka Dal&nbsp;<\\/div><div>Jira Rice&nbsp;<\\/div><div>Bataka nu Shak&nbsp;<\\/div><div>Puri<\\/div><div>Khaman<\\/div>\",\"categories_id\":\"22\",\"main_categories_id\":1,\"price\":\"10.00\",\"is_featured\":\"no\",\"is_visible\":\"yes\",\"tiffin_preparation_date\":\"2021-05-26\",\"image\":\"public\\/products\\/1609569332tiffin.png\",\"small_image\":\"public\\/products\\/small\\/1609570657tiffin.png\",\"id\":86}', 'https://www.neoinventions.com/dailytiffin/tiffinproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:25:46', '2021-05-24 10:25:46'),
(3097, 'App\\User', 2, 'created', 'App\\Product', 87, '[]', '{\"p_name\":\"Veg Tiffin\",\"p_code\":\"veg-tiffin1621873561\",\"description\":\"<div>Dam Aloo&nbsp;<\\/div><div>Pulav&nbsp;<\\/div><div>Paratha&nbsp;<\\/div><div>Raitu<\\/div><div>Sweet<\\/div>\",\"categories_id\":\"22\",\"main_categories_id\":1,\"price\":\"10.00\",\"is_featured\":\"no\",\"is_visible\":\"yes\",\"tiffin_preparation_date\":\"2021-05-27\",\"image\":\"public\\/products\\/1609569332tiffin.png\",\"small_image\":\"public\\/products\\/small\\/1609570657tiffin.png\",\"id\":87}', 'https://www.neoinventions.com/dailytiffin/tiffinproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:26:01', '2021-05-24 10:26:01'),
(3098, 'App\\User', 2, 'created', 'App\\Product', 88, '[]', '{\"p_name\":\"Veg Tiffin\",\"p_code\":\"veg-tiffin1621873573\",\"description\":\"<div>Kadhi&nbsp;<\\/div><div>Bhat&nbsp;<\\/div><div>Val ni Dal&nbsp;<\\/div><div>Flower Bataka Vatana nu Shak&nbsp;<\\/div><div>Rotli&nbsp;<\\/div><div>Pickle<\\/div>\",\"categories_id\":\"22\",\"main_categories_id\":1,\"price\":\"10.00\",\"is_featured\":\"no\",\"is_visible\":\"yes\",\"tiffin_preparation_date\":\"2021-05-28\",\"image\":\"public\\/products\\/1609569332tiffin.png\",\"small_image\":\"public\\/products\\/small\\/1609570657tiffin.png\",\"id\":88}', 'https://www.neoinventions.com/dailytiffin/tiffinproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:26:13', '2021-05-24 10:26:13'),
(3099, 'App\\User', 2, 'created', 'App\\Product', 89, '[]', '{\"p_name\":\"Veg Tiffin\",\"p_code\":\"veg-tiffin1621873590\",\"description\":\"<div>Dal Dhokri<\\/div><div>Bhat&nbsp;<\\/div><div>Dahi<\\/div><div>Thepla 3<\\/div><div>Pickle<\\/div>\",\"categories_id\":\"22\",\"main_categories_id\":1,\"price\":\"10.00\",\"is_featured\":\"no\",\"is_visible\":\"yes\",\"tiffin_preparation_date\":\"2021-05-29\",\"image\":\"public\\/products\\/1609569332tiffin.png\",\"small_image\":\"public\\/products\\/small\\/1609570657tiffin.png\",\"id\":89}', 'https://www.neoinventions.com/dailytiffin/tiffinproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:26:30', '2021-05-24 10:26:30'),
(3100, 'App\\User', 2, 'created', 'App\\Product', 90, '[]', '{\"p_name\":\"Veg Tiffin\",\"p_code\":\"veg-tiffin1621873608\",\"description\":\"<div>Kadhi&nbsp;<\\/div><div>Bhat&nbsp;<\\/div><div>Mug na Vaidha&nbsp;<\\/div><div>Tindora Bataka nu Saak&nbsp;<\\/div><div>Rotli&nbsp;<\\/div><div>Pickle<\\/div>\",\"categories_id\":\"22\",\"main_categories_id\":1,\"price\":\"10.00\",\"is_featured\":\"no\",\"is_visible\":\"yes\",\"tiffin_preparation_date\":\"2021-05-30\",\"image\":\"public\\/products\\/1609569332tiffin.png\",\"small_image\":\"public\\/products\\/small\\/1609570657tiffin.png\",\"id\":90}', 'https://www.neoinventions.com/dailytiffin/tiffinproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:26:48', '2021-05-24 10:26:48'),
(3101, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"remember_token\":\"EysaqAlzKjOJFtKi5f6wOoakq9j5sc6vkDvcvZ8mMQgJehLWpt2kYuTo0Tnu\"}', '{\"remember_token\":\"scFz3fhY8r8c6q8gJ4gkkWLCq3rDM2EZF4H0xEdoHJofqwucfrQO0Qj7IwwQ\"}', 'https://www.neoinventions.com/dailytiffin/logout?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:26:53', '2021-05-24 10:26:53'),
(3102, 'App\\User', 2, 'created', 'App\\Product', 91, '[]', '{\"p_name\":\"Ladu\",\"p_code\":\"CSW0001\",\"description\":\"Gor na Ladu\",\"categories_id\":\"20\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621874616rava-ladoo.jpg\",\"small_image\":\"public\\/products\\/small\\/1621874616rava-ladoo.jpg\",\"id\":91}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:43:38', '2021-05-24 10:43:38'),
(3103, 'App\\User', 2, 'created', 'App\\Product', 92, '[]', '{\"p_name\":\"Shrikhand\",\"p_code\":\"CSW0002\",\"description\":\"Kesar Shrikhand\",\"categories_id\":\"20\",\"price\":\"1.25\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621874675Shrikhand.jpg\",\"small_image\":\"public\\/products\\/small\\/1621874675Shrikhand.jpg\",\"id\":92}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:44:35', '2021-05-24 10:44:35'),
(3104, 'App\\User', 2, 'created', 'App\\Product', 93, '[]', '{\"p_name\":\"Mango Ras\",\"p_code\":\"CSW0003\",\"description\":\"Kesar Ras\",\"categories_id\":\"20\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621874703MangoRas.jpg\",\"small_image\":\"public\\/products\\/small\\/1621874703MangoRas.jpg\",\"id\":93}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:45:04', '2021-05-24 10:45:04'),
(3105, 'App\\User', 2, 'created', 'App\\Product', 94, '[]', '{\"p_name\":\"Rotali\",\"p_code\":\"CBR0001\",\"description\":\"Gujarati Rotali\",\"categories_id\":\"19\",\"price\":\"2.5\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621875092Rotali.jpg\",\"small_image\":\"public\\/products\\/small\\/1621875092Rotali.jpg\",\"id\":94}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:51:32', '2021-05-24 10:51:32'),
(3106, 'App\\User', 2, 'created', 'App\\Product', 95, '[]', '{\"p_name\":\"Puri\",\"p_code\":\"CBR0002\",\"description\":\"Fried Puri\",\"categories_id\":\"19\",\"price\":\"1.25\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621875128Puri.jpg\",\"small_image\":\"public\\/products\\/small\\/1621875128Puri.jpg\",\"id\":95}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:52:08', '2021-05-24 10:52:08'),
(3107, 'App\\User', 2, 'created', 'App\\Product', 96, '[]', '{\"p_name\":\"Naan\",\"p_code\":\"CBR0003\",\"description\":\"Punjabi Naan\",\"categories_id\":\"19\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621875158Naan.jpg\",\"small_image\":\"public\\/products\\/small\\/1621875158Naan.jpg\",\"id\":96}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:52:38', '2021-05-24 10:52:38'),
(3108, 'App\\User', 2, 'created', 'App\\Category', 23, '[]', '{\"name\":\"Rice\",\"description\":\"Different style Rice\",\"main_category_id\":\"2\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":23}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:59:04', '2021-05-24 10:59:04'),
(3109, 'App\\User', 2, 'created', 'App\\Category', 24, '[]', '{\"name\":\"Daal\",\"description\":\"Different Daals\",\"main_category_id\":\"2\",\"parent_id\":null,\"url\":null,\"status\":\"1\",\"id\":24}', 'https://www.neoinventions.com/dailytiffin/category?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 10:59:28', '2021-05-24 10:59:28'),
(3110, 'App\\User', 2, 'created', 'App\\Product', 97, '[]', '{\"p_name\":\"Kadhi\",\"p_code\":\"CDAL0001\",\"description\":\"Gujarati Kadhi\",\"categories_id\":\"24\",\"price\":\".85\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621876889Gujarati Kadhi.jpg\",\"small_image\":\"public\\/products\\/small\\/1621876889Gujarati Kadhi.jpg\",\"id\":97}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:21:31', '2021-05-24 11:21:31'),
(3111, 'App\\User', 2, 'created', 'App\\Product', 98, '[]', '{\"p_name\":\"Dal Tadaka\",\"p_code\":\"CDAL0002\",\"description\":\"Punjabi Daal Tadka\",\"categories_id\":\"24\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621876926Dal-tadka.jpg\",\"small_image\":\"public\\/products\\/small\\/1621876926Dal-tadka.jpg\",\"id\":98}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:22:06', '2021-05-24 11:22:06'),
(3112, 'App\\User', 2, 'created', 'App\\Product', 99, '[]', '{\"p_name\":\"Daal\",\"p_code\":\"CDAL0003\",\"description\":\"Gujarati Daal\",\"categories_id\":\"24\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621876953Gujarati Daal.jpg\",\"small_image\":\"public\\/products\\/small\\/1621876953Gujarati Daal.jpg\",\"id\":99}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:22:33', '2021-05-24 11:22:33'),
(3113, 'App\\User', 2, 'created', 'App\\Product', 100, '[]', '{\"p_name\":\"White Rice\",\"p_code\":\"CRIC0001\",\"description\":\"White Rice\",\"categories_id\":\"23\",\"price\":\".5\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621876997WhiteRice.jpg\",\"small_image\":\"public\\/products\\/small\\/1621876997WhiteRice.jpg\",\"id\":100}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:23:17', '2021-05-24 11:23:17'),
(3114, 'App\\User', 2, 'created', 'App\\Product', 101, '[]', '{\"p_name\":\"Veg Pulao\",\"p_code\":\"CRIC0002\",\"description\":\"Vegetarian Pulao\",\"categories_id\":\"23\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877032vegetable pulao.JPG\",\"small_image\":\"public\\/products\\/small\\/1621877032vegetable pulao.JPG\",\"id\":101}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:23:52', '2021-05-24 11:23:52'),
(3115, 'App\\User', 2, 'created', 'App\\Product', 102, '[]', '{\"p_name\":\"Veg Biryani\",\"p_code\":\"CRIC0003\",\"description\":\"Veg. Biryani\",\"categories_id\":\"23\",\"price\":\"1.1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877063Veg Biryani.jpg\",\"small_image\":\"public\\/products\\/small\\/1621877063Veg Biryani.jpg\",\"id\":102}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:24:23', '2021-05-24 11:24:23'),
(3116, 'App\\User', 2, 'created', 'App\\Product', 103, '[]', '{\"p_name\":\"Mango Lassi\",\"p_code\":\"CDRK0001\",\"description\":\"Mango Lassi\",\"categories_id\":\"21\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877110Mango Lassi.jpg\",\"small_image\":\"public\\/products\\/small\\/1621877110Mango Lassi.jpg\",\"id\":103}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:25:10', '2021-05-24 11:25:10'),
(3117, 'App\\User', 2, 'created', 'App\\Product', 104, '[]', '{\"p_name\":\"Masala Chaas\",\"p_code\":\"CDRK0002\",\"description\":\"Kathiyawadi Chaas\",\"categories_id\":\"21\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877138Masala Chaas.jpg\",\"small_image\":\"public\\/products\\/small\\/1621877138Masala Chaas.jpg\",\"id\":104}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:25:38', '2021-05-24 11:25:38'),
(3118, 'App\\User', 2, 'created', 'App\\Product', 105, '[]', '{\"p_name\":\"Tea\",\"p_code\":\"CDRK0003\",\"description\":\"Masala Tea\",\"categories_id\":\"21\",\"price\":\".5\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877172Tea.jpg\",\"small_image\":\"public\\/products\\/small\\/1621877172Tea.jpg\",\"id\":105}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:26:12', '2021-05-24 11:26:12'),
(3119, 'App\\User', 2, 'created', 'App\\Product', 106, '[]', '{\"p_name\":\"Coffee\",\"p_code\":\"CDRK0004\",\"description\":\"Indian Coffee\",\"categories_id\":\"21\",\"price\":\".5\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877200Coffee.jpg\",\"small_image\":\"public\\/products\\/small\\/1621877200Coffee.jpg\",\"id\":106}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:26:40', '2021-05-24 11:26:40'),
(3120, 'App\\User', 2, 'created', 'App\\Product', 107, '[]', '{\"p_name\":\"Bottled Water\",\"p_code\":\"CDRK0005\",\"description\":\"Bottled Water\",\"categories_id\":\"21\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877244BottledWater.jpg\",\"small_image\":\"public\\/products\\/small\\/1621877244BottledWater.jpg\",\"id\":107}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:27:24', '2021-05-24 11:27:24'),
(3121, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"remember_token\":\"scFz3fhY8r8c6q8gJ4gkkWLCq3rDM2EZF4H0xEdoHJofqwucfrQO0Qj7IwwQ\"}', '{\"remember_token\":\"pMyzDx5UDNN3dGuMT0DnF0FTySdRqioeAx5Ffn78tmuxdetZKmEsakwXNjuF\"}', 'https://www.neoinventions.com/dailytiffin/logout?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:27:27', '2021-05-24 11:27:27'),
(3122, 'App\\User', 2, 'created', 'App\\Product', 108, '[]', '{\"p_name\":\"Sev Tamato\",\"p_code\":\"KSUB001\",\"description\":\"Sev Tamatar Shaak\",\"categories_id\":\"18\",\"price\":\"1\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877645SevTamato.jpg\",\"small_image\":\"public\\/products\\/small\\/1621877645SevTamato.jpg\",\"id\":108}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:34:07', '2021-05-24 11:34:07'),
(3123, 'App\\User', 2, 'created', 'App\\Product', 109, '[]', '{\"p_name\":\"Navratna Korma\",\"p_code\":\"KSUB002\",\"description\":\"Punjabi NavRatna Korma\",\"categories_id\":\"18\",\"price\":\"1.25\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877680Navratna Korma.jpg\",\"small_image\":\"public\\/products\\/small\\/1621877680Navratna Korma.jpg\",\"id\":109}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:34:40', '2021-05-24 11:34:40'),
(3124, 'App\\User', 2, 'created', 'App\\Product', 110, '[]', '{\"p_name\":\"Paneer Tikka Masala\",\"p_code\":\"KSUB003\",\"description\":\"Paneer Masala Gravy\",\"categories_id\":\"18\",\"price\":\"1.5\",\"is_visible\":\"yes\",\"main_categories_id\":2,\"image\":\"public\\/products\\/1621877713Paneer Tikka Masala.gif\",\"small_image\":\"public\\/products\\/small\\/1621877713Paneer Tikka Masala.gif\",\"id\":110}', 'https://www.neoinventions.com/dailytiffin/cateringproduct?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:35:13', '2021-05-24 11:35:13'),
(3125, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"remember_token\":\"pMyzDx5UDNN3dGuMT0DnF0FTySdRqioeAx5Ffn78tmuxdetZKmEsakwXNjuF\"}', '{\"remember_token\":\"QPtJhhuqUqcJIBkTenOZRqekr3ips1EizZtPFlBBAsNGUgHzTXHuGjamOpsT\"}', 'https://www.neoinventions.com/dailytiffin/logout?', '104.58.85.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66', NULL, '2021-05-24 11:35:18', '2021-05-24 11:35:18'),
(3126, NULL, NULL, 'created', 'App\\Cart', 1, '[]', '{\"products_id\":\"110\",\"product_name\":\"Paneer Tikka Masala\",\"product_code\":\"KSUB003\",\"price\":\"1.50\",\"quantity\":\"10\",\"session_id\":\"mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie\",\"id\":1}', 'https://www.neoinventions.com/dailytiffin/addToCateringajax?', '104.58.85.89', 'Mozilla/5.0 (Linux; Android 10; Surface Duo) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/46.04.4.5157', NULL, '2021-05-24 11:39:14', '2021-05-24 11:39:14'),
(3127, NULL, NULL, 'created', 'App\\Cart', 2, '[]', '{\"products_id\":\"108\",\"product_name\":\"Sev Tamato\",\"product_code\":\"KSUB001\",\"price\":\"1.00\",\"quantity\":\"10\",\"session_id\":\"mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie\",\"id\":2}', 'https://www.neoinventions.com/dailytiffin/addToCateringajax?', '104.58.85.89', 'Mozilla/5.0 (Linux; Android 10; Surface Duo) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/46.04.4.5157', NULL, '2021-05-24 11:39:20', '2021-05-24 11:39:20'),
(3128, NULL, NULL, 'created', 'App\\Cart', 3, '[]', '{\"products_id\":\"96\",\"product_name\":\"Naan\",\"product_code\":\"CBR0003\",\"price\":\"1.00\",\"quantity\":\"10\",\"session_id\":\"mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie\",\"id\":3}', 'https://www.neoinventions.com/dailytiffin/addToCateringajax?', '104.58.85.89', 'Mozilla/5.0 (Linux; Android 10; Surface Duo) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/46.04.4.5157', NULL, '2021-05-24 11:39:25', '2021-05-24 11:39:25'),
(3129, NULL, NULL, 'created', 'App\\Cart', 4, '[]', '{\"products_id\":\"93\",\"product_name\":\"Mango Ras\",\"product_code\":\"CSW0003\",\"price\":\"1.00\",\"quantity\":\"10\",\"session_id\":\"mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie\",\"id\":4}', 'https://www.neoinventions.com/dailytiffin/addToCateringajax?', '104.58.85.89', 'Mozilla/5.0 (Linux; Android 10; Surface Duo) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/46.04.4.5157', NULL, '2021-05-24 11:39:29', '2021-05-24 11:39:29'),
(3130, NULL, NULL, 'created', 'App\\Cart', 5, '[]', '{\"products_id\":\"107\",\"product_name\":\"Bottled Water\",\"product_code\":\"CDRK0005\",\"price\":\"1.00\",\"quantity\":\"10\",\"session_id\":\"mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie\",\"id\":5}', 'https://www.neoinventions.com/dailytiffin/addToCateringajax?', '104.58.85.89', 'Mozilla/5.0 (Linux; Android 10; Surface Duo) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/46.04.4.5157', NULL, '2021-05-24 11:39:32', '2021-05-24 11:39:32'),
(3131, NULL, NULL, 'created', 'App\\Cart', 6, '[]', '{\"products_id\":\"106\",\"product_name\":\"Coffee\",\"product_code\":\"CDRK0004\",\"price\":\"0.50\",\"quantity\":\"10\",\"session_id\":\"mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie\",\"id\":6}', 'https://www.neoinventions.com/dailytiffin/addToCateringajax?', '104.58.85.89', 'Mozilla/5.0 (Linux; Android 10; Surface Duo) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/46.04.4.5157', NULL, '2021-05-24 11:39:33', '2021-05-24 11:39:33'),
(3132, NULL, NULL, 'created', 'App\\Cart', 7, '[]', '{\"products_id\":\"101\",\"product_name\":\"Veg Pulao\",\"product_code\":\"CRIC0002\",\"price\":\"1.00\",\"quantity\":\"10\",\"session_id\":\"mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie\",\"id\":7}', 'https://www.neoinventions.com/dailytiffin/addToCateringajax?', '104.58.85.89', 'Mozilla/5.0 (Linux; Android 10; Surface Duo) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/46.04.4.5157', NULL, '2021-05-24 11:39:39', '2021-05-24 11:39:39'),
(3133, NULL, NULL, 'created', 'App\\Cart', 8, '[]', '{\"products_id\":\"98\",\"product_name\":\"Dal Tadaka\",\"product_code\":\"CDAL0002\",\"price\":\"1.00\",\"quantity\":\"10\",\"session_id\":\"mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie\",\"id\":8}', 'https://www.neoinventions.com/dailytiffin/addToCateringajax?', '104.58.85.89', 'Mozilla/5.0 (Linux; Android 10; Surface Duo) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/46.04.4.5157', NULL, '2021-05-24 11:39:47', '2021-05-24 11:39:47'),
(3134, NULL, NULL, 'created', 'App\\Cart', 9, '[]', '{\"products_id\":\"85\",\"product_name\":\"Veg Tiffin\",\"product_code\":\"veg-tiffin1621873420\",\"price\":\"10.00\",\"quantity\":\"1\",\"session_id\":\"b5XxpBbxaUaLFmbFeIgXjw40dpTbLSoDIZLMmM8R\",\"id\":9}', 'https://neoinventions.com/dailytiffin/addToCart?', '113.193.112.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-24 23:42:18', '2021-05-24 23:42:18'),
(3135, NULL, NULL, 'created', 'App\\Cart', 10, '[]', '{\"products_id\":\"85\",\"product_name\":\"Veg Tiffin\",\"product_code\":\"veg-tiffin1621873420\",\"price\":\"10.00\",\"quantity\":\"1\",\"session_id\":\"5pJcX0XZDU1upoU22VhMj7isYoDoE2d5zkGiGaN0\",\"id\":10}', 'https://www.neoinventions.com/dailytiffin/addToCart?', '113.193.112.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 03:37:04', '2021-05-25 03:37:04'),
(3136, NULL, NULL, 'deleted', 'App\\Cart', 10, '{\"id\":\"10\",\"products_id\":\"85\",\"product_name\":\"Veg Tiffin\",\"product_code\":\"veg-tiffin1621873420\",\"price\":\"10.00\",\"quantity\":\"2\",\"user_email\":null,\"session_id\":\"5pJcX0XZDU1upoU22VhMj7isYoDoE2d5zkGiGaN0\"}', '[]', 'https://www.neoinventions.com/dailytiffin/cart/deleteItem/10?', '113.193.112.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 05:30:50', '2021-05-25 05:30:50'),
(3137, NULL, NULL, 'created', 'App\\Cart', 11, '[]', '{\"products_id\":\"88\",\"product_name\":\"Veg Tiffin\",\"product_code\":\"veg-tiffin1621873573\",\"price\":\"10.00\",\"quantity\":\"1\",\"session_id\":\"5pJcX0XZDU1upoU22VhMj7isYoDoE2d5zkGiGaN0\",\"id\":11}', 'https://www.neoinventions.com/dailytiffin/addToCart?', '113.193.112.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 05:52:06', '2021-05-25 05:52:06'),
(3138, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"remember_token\":\"QPtJhhuqUqcJIBkTenOZRqekr3ips1EizZtPFlBBAsNGUgHzTXHuGjamOpsT\"}', '{\"remember_token\":\"IYDdVFvdMuPEx90piUqKcZ8pOlido5QWcVKz9SCgLWLef29Vx4Qrj5DD2cGs\"}', 'http://localhost/dailytiffin/logout?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:47:51', '2021-05-25 12:47:51'),
(3139, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"address\":\"Addresssssssssssssaaaaaaaa\"}', '{\"address\":\"Address\"}', 'http://localhost/dailytiffin/edituserprofile/2?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:50:42', '2021-05-25 12:50:42'),
(3140, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"remember_token\":\"IYDdVFvdMuPEx90piUqKcZ8pOlido5QWcVKz9SCgLWLef29Vx4Qrj5DD2cGs\"}', '{\"remember_token\":\"dro0OFwpcUVg1HnCdpFBw0eVsINuZ1c0TotZNva37zcbrT7gKVOAKDmsZkkc\"}', 'http://localhost/dailytiffin/logout?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:50:55', '2021-05-25 12:50:55'),
(3141, 'App\\User', 2, 'created', 'App\\Cart', 12, '[]', '{\"products_id\":\"77\",\"product_name\":\"Kaju Katli\",\"product_code\":\"MSW00002\",\"price\":\"5\",\"quantity\":\"1\",\"session_id\":\"vIEAG16M0o7bmG1PKu2nyzACX3bRhuVzZVt9YxfF\",\"id\":12}', 'http://localhost/dailytiffin/addToCartajax?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:51:25', '2021-05-25 12:51:25'),
(3142, 'App\\User', 2, 'created', 'App\\Cart', 13, '[]', '{\"products_id\":\"78\",\"product_name\":\"Mohanthal\",\"product_code\":\"MSW0003\",\"price\":\"5\",\"quantity\":\"1\",\"session_id\":\"vIEAG16M0o7bmG1PKu2nyzACX3bRhuVzZVt9YxfF\",\"id\":13}', 'http://localhost/dailytiffin/addToCartajax?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:51:33', '2021-05-25 12:51:33'),
(3143, 'App\\User', 2, 'updated', 'App\\Cart', 12, '{\"quantity\":1}', '{\"quantity\":2}', 'http://localhost/dailytiffin/addToCartajax?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:51:39', '2021-05-25 12:51:39'),
(3144, 'App\\User', 2, 'created', 'App\\Cart', 14, '[]', '{\"products_id\":\"82\",\"product_name\":\"Rotli 5pc\",\"product_code\":\"MBR001\",\"price\":\"3\",\"quantity\":\"1\",\"session_id\":\"vIEAG16M0o7bmG1PKu2nyzACX3bRhuVzZVt9YxfF\",\"id\":14}', 'http://localhost/dailytiffin/addToCartajax?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:56:48', '2021-05-25 12:56:48'),
(3145, 'App\\User', 2, 'updated', 'App\\Cart', 14, '{\"quantity\":1}', '{\"quantity\":2}', 'http://localhost/dailytiffin/addToCartajax?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:56:50', '2021-05-25 12:56:50'),
(3146, 'App\\User', 2, 'updated', 'App\\Cart', 14, '{\"quantity\":2}', '{\"quantity\":3}', 'http://localhost/dailytiffin/addToCartajax?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:56:54', '2021-05-25 12:56:54'),
(3147, 'App\\User', 2, 'updated', 'App\\Cart', 14, '{\"quantity\":3}', '{\"quantity\":4}', 'http://localhost/dailytiffin/addToCartajax?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:56:57', '2021-05-25 12:56:57'),
(3148, 'App\\User', 2, 'deleted', 'App\\Cart', 12, '{\"id\":12,\"products_id\":77,\"product_name\":\"Kaju Katli\",\"product_code\":\"MSW00002\",\"price\":5,\"quantity\":2,\"user_email\":null,\"session_id\":\"vIEAG16M0o7bmG1PKu2nyzACX3bRhuVzZVt9YxfF\"}', '[]', 'http://localhost/dailytiffin/cart/deleteItem/12?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:57:06', '2021-05-25 12:57:06'),
(3149, 'App\\User', 2, 'deleted', 'App\\Cart', 13, '{\"id\":13,\"products_id\":78,\"product_name\":\"Mohanthal\",\"product_code\":\"MSW0003\",\"price\":5,\"quantity\":1,\"user_email\":null,\"session_id\":\"vIEAG16M0o7bmG1PKu2nyzACX3bRhuVzZVt9YxfF\"}', '[]', 'http://localhost/dailytiffin/cart/deleteItem/13?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:57:09', '2021-05-25 12:57:09'),
(3150, 'App\\User', 2, 'deleted', 'App\\Cart', 14, '{\"id\":14,\"products_id\":82,\"product_name\":\"Rotli 5pc\",\"product_code\":\"MBR001\",\"price\":3,\"quantity\":4,\"user_email\":null,\"session_id\":\"vIEAG16M0o7bmG1PKu2nyzACX3bRhuVzZVt9YxfF\"}', '[]', 'http://localhost/dailytiffin/cart/deleteItem/14?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 12:57:13', '2021-05-25 12:57:13'),
(3151, 'App\\User', 2, 'created', 'App\\Cart', 15, '[]', '{\"products_id\":\"77\",\"product_name\":\"Kaju Katli\",\"product_code\":\"MSW00002\",\"price\":\"5\",\"quantity\":\"1\",\"session_id\":\"vIEAG16M0o7bmG1PKu2nyzACX3bRhuVzZVt9YxfF\",\"id\":15}', 'http://localhost/dailytiffin/addToCartajax?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-25 13:00:40', '2021-05-25 13:00:40'),
(3152, 'App\\User', 2, 'updated', 'App\\User', 2, '{\"remember_token\":\"dro0OFwpcUVg1HnCdpFBw0eVsINuZ1c0TotZNva37zcbrT7gKVOAKDmsZkkc\"}', '{\"remember_token\":\"1F4phUvc8GwMQyWyQ30wFdzP52j4DtJbVE03U2YkXWnbsDMXYnMN1IV8iZhw\"}', 'http://localhost/dailytiffin/logout?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 06:07:52', '2021-05-29 06:07:52'),
(3153, NULL, NULL, 'created', 'App\\Contact', 1, '[]', '{\"name\":\"Dhamecha Pruthvi\",\"email\":\"pruthvi.abs@gmail.com\",\"phone\":\"(999) 823-6897\",\"consultationdate\":\"2021-05-29\",\"eventdate\":\"2021-07-31\",\"eventvenue\":\"Vadodara\",\"id\":1}', 'http://localhost/dailytiffin/submitgetintouch?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 08:31:51', '2021-05-29 08:31:51'),
(3154, NULL, NULL, 'created', 'App\\Contact', 2, '[]', '{\"name\":\"Dhamecha Pruthvi\",\"email\":\"pruthvi.abs@gmail.com\",\"phone\":\"(999) 823-6897\",\"consultationdate\":\"2021-05-29\",\"eventdate\":\"2021-07-31\",\"eventvenue\":\"Vadodara\",\"id\":2}', 'http://localhost/dailytiffin/submitgetintouch?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 08:33:12', '2021-05-29 08:33:12'),
(3155, NULL, NULL, 'created', 'App\\Contact', 3, '[]', '{\"name\":\"Dhamecha Pruthvi\",\"email\":\"pruthvi.abs@gmail.com\",\"phone\":\"(999) 823-6897\",\"consultationdate\":\"2021-05-29\",\"eventdate\":\"2021-07-31\",\"eventvenue\":\"Vadodara\",\"id\":3}', 'http://localhost/dailytiffin/submitgetintouch?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 09:06:33', '2021-05-29 09:06:33'),
(3156, NULL, NULL, 'created', 'App\\Contact', 4, '[]', '{\"name\":\"Dhamecha Pruthvi\",\"email\":\"pruthvi.abs@gmail.com\",\"phone\":\"(999) 823-6897\",\"consultationdate\":\"2021-05-29\",\"eventdate\":\"2021-07-31\",\"eventvenue\":\"Vadodara\",\"id\":4}', 'http://localhost/dailytiffin/submitgetintouch?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 09:09:29', '2021-05-29 09:09:29'),
(3157, NULL, NULL, 'created', 'App\\Contact', 5, '[]', '{\"name\":\"Dhamecha Pruthvi\",\"email\":\"pruthvi.abs@gmail.com\",\"phone\":\"(999) 823-6897\",\"consultationdate\":\"2021-05-29\",\"eventdate\":\"2021-07-31\",\"eventvenue\":\"Vadodara\",\"id\":5}', 'http://localhost/dailytiffin/submitgetintouch?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 09:11:11', '2021-05-29 09:11:11'),
(3158, NULL, NULL, 'created', 'App\\Contact', 6, '[]', '{\"name\":\"Dhamecha Pruthvi\",\"email\":\"pruthvi.abs@gmail.com\",\"phone\":\"(999) 823-6897\",\"consultationdate\":\"2021-05-29\",\"eventdate\":\"2021-07-31\",\"eventvenue\":\"Vadodara\",\"id\":6}', 'http://localhost/dailytiffin/submitgetintouch?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 09:11:59', '2021-05-29 09:11:59'),
(3159, NULL, NULL, 'created', 'App\\Contact', 7, '[]', '{\"name\":\"Dhamecha Pruthvi\",\"email\":\"pruthvi.abs@gmail.com\",\"phone\":\"(999) 823-6897\",\"consultationdate\":\"2021-05-29\",\"eventdate\":\"2021-07-31\",\"eventvenue\":\"Vadodara\",\"id\":7}', 'http://localhost/dailytiffin/submitgetintouch?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 09:13:25', '2021-05-29 09:13:25'),
(3160, NULL, NULL, 'created', 'App\\Contact', 8, '[]', '{\"name\":\"Dhamecha Pruthvi\",\"email\":\"pruthvi.abs@gmail.com\",\"phone\":\"(999) 823-6897\",\"consultationdate\":\"2021-05-29\",\"eventdate\":\"2021-07-31\",\"eventvenue\":\"Vadodara\",\"id\":8}', 'http://localhost/dailytiffin/submitgetintouch?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0', NULL, '2021-05-29 09:13:58', '2021-05-29 09:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `products_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `products_id`, `product_name`, `product_code`, `price`, `quantity`, `user_email`, `session_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 110, 'Paneer Tikka Masala', 'KSUB003', 1.50, 10, NULL, 'mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie', '2021-05-24 11:39:14', '2021-05-24 11:39:14', NULL),
(2, 108, 'Sev Tamato', 'KSUB001', 1.00, 10, NULL, 'mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie', '2021-05-24 11:39:20', '2021-05-24 11:39:20', NULL),
(3, 96, 'Naan', 'CBR0003', 1.00, 10, NULL, 'mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie', '2021-05-24 11:39:25', '2021-05-24 11:39:25', NULL),
(4, 93, 'Mango Ras', 'CSW0003', 1.00, 10, NULL, 'mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie', '2021-05-24 11:39:29', '2021-05-24 11:39:29', NULL),
(5, 107, 'Bottled Water', 'CDRK0005', 1.00, 10, NULL, 'mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie', '2021-05-24 11:39:32', '2021-05-24 11:39:32', NULL),
(6, 106, 'Coffee', 'CDRK0004', 0.50, 10, NULL, 'mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie', '2021-05-24 11:39:33', '2021-05-24 11:39:33', NULL),
(7, 101, 'Veg Pulao', 'CRIC0002', 1.00, 10, NULL, 'mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie', '2021-05-24 11:39:39', '2021-05-24 11:39:39', NULL),
(8, 98, 'Dal Tadaka', 'CDAL0002', 1.00, 10, NULL, 'mkK7V3YF09L1Qf8mJyOYLiwXx3EgJWb9h92y7zie', '2021-05-24 11:39:47', '2021-05-24 11:39:47', NULL),
(9, 85, 'Veg Tiffin', 'veg-tiffin1621873420', 10.00, 1, NULL, 'b5XxpBbxaUaLFmbFeIgXjw40dpTbLSoDIZLMmM8R', '2021-05-24 23:42:18', '2021-05-24 23:42:18', NULL),
(11, 88, 'Veg Tiffin', 'veg-tiffin1621873573', 10.00, 1, NULL, '5pJcX0XZDU1upoU22VhMj7isYoDoE2d5zkGiGaN0', '2021-05-25 05:52:06', '2021-05-25 05:52:06', NULL),
(15, 77, 'Kaju Katli', 'MSW00002', 5.00, 1, NULL, 'vIEAG16M0o7bmG1PKu2nyzACX3bRhuVzZVt9YxfF', '2021-05-25 13:00:40', '2021-05-25 13:00:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_category_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `seq` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `main_category_id`, `parent_id`, `seq`, `name`, `description`, `url`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15, 3, NULL, 1, 'Sweets', NULL, NULL, 1, NULL, '2021-05-24 00:04:59', '2021-05-24 00:04:59', NULL),
(16, 3, NULL, 2, 'Namkeen', NULL, NULL, 1, NULL, '2021-05-24 00:05:23', '2021-05-24 00:05:23', NULL),
(17, 3, NULL, 3, 'Bread', NULL, NULL, 1, NULL, '2021-05-24 00:05:54', '2021-05-24 00:05:54', NULL),
(18, 2, NULL, 3, 'Subji', 'Veg Curries', NULL, 1, NULL, '2021-05-24 09:50:29', '2021-05-24 09:50:29', NULL),
(19, 2, NULL, 1, 'Bread', 'Roti Naan etc', NULL, 1, NULL, '2021-05-24 09:51:03', '2021-05-24 09:51:03', NULL),
(20, 2, NULL, 5, 'Sweets', 'Sweets', NULL, 1, NULL, '2021-05-24 09:51:24', '2021-05-24 09:51:24', NULL),
(21, 2, NULL, 8, 'Drinks', 'Drinks', NULL, 1, NULL, '2021-05-24 09:52:02', '2021-05-24 09:52:02', NULL),
(22, 1, NULL, 1, 'Daily', 'Daily Tiffin', NULL, 1, NULL, '2021-05-24 10:23:18', '2021-05-24 10:23:18', NULL),
(23, 2, NULL, 9, 'Rice', 'Different style Rice', NULL, 1, NULL, '2021-05-24 10:59:04', '2021-05-24 10:59:04', NULL),
(24, 2, NULL, 10, 'Daal', 'Different Daals', NULL, 1, NULL, '2021-05-24 10:59:28', '2021-05-24 10:59:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `consultationdate` date NOT NULL,
  `eventdate` date NOT NULL,
  `eventvenue` varchar(255) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `consultationdate`, `eventdate`, `eventvenue`, `updated_at`, `created_at`) VALUES
(1, 'Dhamecha Pruthvi', 'pruthvi.abs@gmail.com', '(999) 823-6897', '2021-05-29', '2021-07-31', 'Vadodara', '2021-05-29', '2021-05-29'),
(2, 'Dhamecha Pruthvi', 'pruthvi.abs@gmail.com', '(999) 823-6897', '2021-05-29', '2021-07-31', 'Vadodara', '2021-05-29', '2021-05-29'),
(3, 'Dhamecha Pruthvi', 'pruthvi.abs@gmail.com', '(999) 823-6897', '2021-05-29', '2021-07-31', 'Vadodara', '2021-05-29', '2021-05-29'),
(4, 'Dhamecha Pruthvi', 'pruthvi.abs@gmail.com', '(999) 823-6897', '2021-05-29', '2021-07-31', 'Vadodara', '2021-05-29', '2021-05-29'),
(5, 'Dhamecha Pruthvi', 'pruthvi.abs@gmail.com', '(999) 823-6897', '2021-05-29', '2021-07-31', 'Vadodara', '2021-05-29', '2021-05-29'),
(6, 'Dhamecha Pruthvi', 'pruthvi.abs@gmail.com', '(999) 823-6897', '2021-05-29', '2021-07-31', 'Vadodara', '2021-05-29', '2021-05-29'),
(7, 'Dhamecha Pruthvi', 'pruthvi.abs@gmail.com', '(999) 823-6897', '2021-05-29', '2021-07-31', 'Vadodara', '2021-05-29', '2021-05-29'),
(8, 'Dhamecha Pruthvi', 'pruthvi.abs@gmail.com', '(999) 823-6897', '2021-05-29', '2021-07-31', 'Vadodara', '2021-05-29', '2021-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'AL', 'Albania', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(3, 'DZ', 'Algeria', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(4, 'DS', 'American Samoa', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(5, 'AD', 'Andorra', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(6, 'AO', 'Angola', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(7, 'AI', 'Anguilla', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(8, 'AQ', 'Antarctica', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(9, 'AG', 'Antigua and Barbuda', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(10, 'AR', 'Argentina', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(11, 'AM', 'Armenia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(12, 'AW', 'Aruba', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(13, 'AU', 'Australia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(14, 'AT', 'Austria', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(15, 'AZ', 'Azerbaijan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(16, 'BS', 'Bahamas', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(17, 'BH', 'Bahrain', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(18, 'BD', 'Bangladesh', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(19, 'BB', 'Barbados', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(20, 'BY', 'Belarus', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(21, 'BE', 'Belgium', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(22, 'BZ', 'Belize', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(23, 'BJ', 'Benin', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(24, 'BM', 'Bermuda', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(25, 'BT', 'Bhutan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(26, 'BO', 'Bolivia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(27, 'BA', 'Bosnia and Herzegovina', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(28, 'BW', 'Botswana', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(29, 'BV', 'Bouvet Island', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(30, 'BR', 'Brazil', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(31, 'IO', 'British Indian Ocean Territory', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(32, 'BN', 'Brunei Darussalam', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(33, 'BG', 'Bulgaria', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(34, 'BF', 'Burkina Faso', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(35, 'BI', 'Burundi', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(36, 'KH', 'Cambodia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(37, 'CM', 'Cameroon', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(38, 'CA', 'Canada', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(39, 'CV', 'Cape Verde', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(40, 'KY', 'Cayman Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(41, 'CF', 'Central African Republic', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(42, 'TD', 'Chad', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(43, 'CL', 'Chile', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(44, 'CN', 'China', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(45, 'CX', 'Christmas Island', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(46, 'CC', 'Cocos (Keeling) Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(47, 'CO', 'Colombia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(48, 'KM', 'Comoros', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(49, 'CG', 'Congo', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(50, 'CK', 'Cook Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(51, 'CR', 'Costa Rica', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(52, 'AF', 'Afghanistan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(53, 'AL', 'Albania', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(54, 'DZ', 'Algeria', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(55, 'DS', 'American Samoa', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(56, 'AD', 'Andorra', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(57, 'AO', 'Angola', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(58, 'AI', 'Anguilla', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(59, 'AQ', 'Antarctica', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(60, 'AG', 'Antigua and Barbuda', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(61, 'AR', 'Argentina', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(62, 'AM', 'Armenia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(63, 'AW', 'Aruba', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(64, 'AU', 'Australia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(65, 'AT', 'Austria', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(66, 'AZ', 'Azerbaijan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(67, 'BS', 'Bahamas', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(68, 'BH', 'Bahrain', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(69, 'BD', 'Bangladesh', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(70, 'BB', 'Barbados', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(71, 'BY', 'Belarus', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(72, 'BE', 'Belgium', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(73, 'BZ', 'Belize', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(74, 'BJ', 'Benin', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(75, 'BM', 'Bermuda', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(76, 'BT', 'Bhutan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(77, 'BO', 'Bolivia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(78, 'BA', 'Bosnia and Herzegovina', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(79, 'BW', 'Botswana', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(80, 'BV', 'Bouvet Island', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(81, 'BR', 'Brazil', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(82, 'IO', 'British Indian Ocean Territory', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(83, 'BN', 'Brunei Darussalam', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(84, 'BG', 'Bulgaria', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(85, 'BF', 'Burkina Faso', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(86, 'BI', 'Burundi', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(87, 'KH', 'Cambodia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(88, 'CM', 'Cameroon', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(89, 'CA', 'Canada', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(90, 'CV', 'Cape Verde', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(91, 'KY', 'Cayman Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(92, 'CF', 'Central African Republic', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(93, 'TD', 'Chad', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(94, 'CL', 'Chile', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(95, 'CN', 'China', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(96, 'CX', 'Christmas Island', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(97, 'CC', 'Cocos (Keeling) Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(98, 'CO', 'Colombia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(99, 'KM', 'Comoros', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(100, 'CG', 'Congo', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(101, 'CK', 'Cook Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(102, 'CR', 'Costa Rica', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(103, 'HR', 'Croatia (Hrvatska)', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(104, 'CU', 'Cuba', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(105, 'CY', 'Cyprus', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(106, 'CZ', 'Czech Republic', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(107, 'DK', 'Denmark', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(108, 'DJ', 'Djibouti', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(109, 'DM', 'Dominica', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(110, 'DO', 'Dominican Republic', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(111, 'TP', 'East Timor', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(112, 'EC', 'Ecuador', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(113, 'EG', 'Egypt', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(114, 'SV', 'El Salvador', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(115, 'GQ', 'Equatorial Guinea', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(116, 'ER', 'Eritrea', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(117, 'EE', 'Estonia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(118, 'ET', 'Ethiopia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(119, 'FK', 'Falkland Islands (Malvinas)', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(120, 'FO', 'Faroe Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(121, 'FJ', 'Fiji', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(122, 'FI', 'Finland', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(123, 'FR', 'France', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(124, 'FX', 'France, Metropolitan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(125, 'GF', 'French Guiana', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(126, 'PF', 'French Polynesia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(127, 'TF', 'French Southern Territories', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(128, 'GA', 'Gabon', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(129, 'GM', 'Gambia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(130, 'GE', 'Georgia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(131, 'DE', 'Germany', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(132, 'GH', 'Ghana', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(133, 'GI', 'Gibraltar', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(134, 'GK', 'Guernsey', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(135, 'GR', 'Greece', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(136, 'GL', 'Greenland', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(137, 'GD', 'Grenada', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(138, 'GP', 'Guadeloupe', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(139, 'GU', 'Guam', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(140, 'GT', 'Guatemala', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(141, 'GN', 'Guinea', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(142, 'GW', 'Guinea-Bissau', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(143, 'GY', 'Guyana', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(144, 'HT', 'Haiti', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(145, 'HM', 'Heard and Mc Donald Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(146, 'HN', 'Honduras', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(147, 'HK', 'Hong Kong', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(148, 'HU', 'Hungary', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(149, 'IS', 'Iceland', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(150, 'IN', 'India', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(151, 'IM', 'Isle of Man', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(152, 'ID', 'Indonesia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(153, 'IR', 'Iran (Islamic Republic of)', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(154, 'IQ', 'Iraq', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(155, 'IE', 'Ireland', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(156, 'IL', 'Israel', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(157, 'IT', 'Italy', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(158, 'CI', 'Ivory Coast', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(159, 'JE', 'Jersey', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(160, 'JM', 'Jamaica', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(161, 'JP', 'Japan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(162, 'JO', 'Jordan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(163, 'KZ', 'Kazakhstan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(164, 'KE', 'Kenya', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(165, 'KI', 'Kiribati', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(166, 'KP', 'Korea, Democratic People\'s Republic of', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(167, 'KR', 'Korea, Republic of', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(168, 'XK', 'Kosovo', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(169, 'KW', 'Kuwait', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(170, 'KG', 'Kyrgyzstan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(171, 'LA', 'Lao People\'s Democratic Republic', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(172, 'LV', 'Latvia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(173, 'LB', 'Lebanon', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(174, 'LS', 'Lesotho', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(175, 'LR', 'Liberia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(176, 'LY', 'Libyan Arab Jamahiriya', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(177, 'LI', 'Liechtenstein', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(178, 'LT', 'Lithuania', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(179, 'LU', 'Luxembourg', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(180, 'MO', 'Macau', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(181, 'MK', 'Macedonia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(182, 'MG', 'Madagascar', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(183, 'MW', 'Malawi', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(184, 'MY', 'Malaysia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(185, 'MV', 'Maldives', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(186, 'ML', 'Mali', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(187, 'MT', 'Malta', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(188, 'MH', 'Marshall Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(189, 'MQ', 'Martinique', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(190, 'MR', 'Mauritania', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(191, 'MU', 'Mauritius', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(192, 'TY', 'Mayotte', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(193, 'MX', 'Mexico', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(194, 'FM', 'Micronesia, Federated States of', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(195, 'MD', 'Moldova, Republic of', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(196, 'MC', 'Monaco', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(197, 'MN', 'Mongolia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(198, 'ME', 'Montenegro', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(199, 'MS', 'Montserrat', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(200, 'MA', 'Morocco', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(201, 'MZ', 'Mozambique', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(202, 'MM', 'Myanmar', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(203, 'NA', 'Namibia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(204, 'NR', 'Nauru', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(205, 'NP', 'Nepal', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(206, 'NL', 'Netherlands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(207, 'AN', 'Netherlands Antilles', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(208, 'NC', 'New Caledonia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(209, 'NZ', 'New Zealand', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(210, 'NI', 'Nicaragua', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(211, 'NE', 'Niger', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(212, 'NG', 'Nigeria', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(213, 'NU', 'Niue', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(214, 'NF', 'Norfolk Island', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(215, 'MP', 'Northern Mariana Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(216, 'NO', 'Norway', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(217, 'OM', 'Oman', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(218, 'PK', 'Pakistan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(219, 'PW', 'Palau', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(220, 'PS', 'Palestine', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(221, 'PA', 'Panama', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(222, 'PG', 'Papua New Guinea', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(223, 'PY', 'Paraguay', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(224, 'PE', 'Peru', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(225, 'PH', 'Philippines', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(226, 'PN', 'Pitcairn', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(227, 'PL', 'Poland', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(228, 'PT', 'Portugal', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(229, 'PR', 'Puerto Rico', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(230, 'QA', 'Qatar', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(231, 'RE', 'Reunion', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(232, 'RO', 'Romania', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(233, 'RU', 'Russian Federation', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(234, 'RW', 'Rwanda', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(235, 'KN', 'Saint Kitts and Nevis', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(236, 'LC', 'Saint Lucia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(237, 'VC', 'Saint Vincent and the Grenadines', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(238, 'WS', 'Samoa', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(239, 'SM', 'San Marino', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(240, 'ST', 'Sao Tome and Principe', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(241, 'SA', 'Saudi Arabia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(242, 'SN', 'Senegal', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(243, 'RS', 'Serbia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(244, 'SC', 'Seychelles', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(245, 'SL', 'Sierra Leone', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(246, 'SG', 'Singapore', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(247, 'SK', 'Slovakia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(248, 'SI', 'Slovenia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(249, 'SB', 'Solomon Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(250, 'SO', 'Somalia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(251, 'ZA', 'South Africa', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(252, 'GS', 'South Georgia South Sandwich Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(253, 'SS', 'South Sudan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(254, 'ES', 'Spain', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(255, 'LK', 'Sri Lanka', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(256, 'SH', 'St. Helena', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(257, 'PM', 'St. Pierre and Miquelon', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(258, 'SD', 'Sudan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(259, 'SR', 'Suriname', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(260, 'SJ', 'Svalbard and Jan Mayen Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(261, 'SZ', 'Swaziland', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(262, 'SE', 'Sweden', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(263, 'CH', 'Switzerland', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(264, 'SY', 'Syrian Arab Republic', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(265, 'TW', 'Taiwan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(266, 'TJ', 'Tajikistan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(267, 'TZ', 'Tanzania, United Republic of', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(268, 'TH', 'Thailand', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(269, 'TG', 'Togo', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(270, 'TK', 'Tokelau', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(271, 'TO', 'Tonga', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(272, 'TT', 'Trinidad and Tobago', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(273, 'TN', 'Tunisia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(274, 'TR', 'Turkey', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(275, 'TM', 'Turkmenistan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(276, 'TC', 'Turks and Caicos Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(277, 'TV', 'Tuvalu', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(278, 'UG', 'Uganda', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(279, 'UA', 'Ukraine', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(280, 'AE', 'United Arab Emirates', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(281, 'GB', 'United Kingdom', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(282, 'US', 'United States', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(283, 'UM', 'United States minor outlying islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(284, 'UY', 'Uruguay', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(285, 'UZ', 'Uzbekistan', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(286, 'VU', 'Vanuatu', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(287, 'VA', 'Vatican City State', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(288, 'VE', 'Venezuela', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(289, 'VN', 'Vietnam', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(290, 'VG', 'Virgin Islands (British)', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(291, 'VI', 'Virgin Islands (U.S.)', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(292, 'WF', 'Wallis and Futuna Islands', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(293, 'EH', 'Western Sahara', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(294, 'YE', 'Yemen', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(295, 'ZR', 'Zaire', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(296, 'ZM', 'Zambia', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(297, 'ZW', 'Zimbabwe', '2020-11-18 20:44:41', '2020-11-18 20:44:41', NULL),
(298, 'xx', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', '2020-11-18 15:41:52', '2020-11-18 15:44:26', '2020-11-18 15:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `min_amount` int(11) DEFAULT NULL,
  `amount_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `amount`, `min_amount`, `amount_type`, `expiry_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', 10, 100, 'Fixed', '2021-01-15', 1, '2020-11-27 11:04:24', '2021-01-02 09:31:26', NULL),
(2, 'test20', 10, 50, '%', '2021-01-15', 1, '2020-11-27 13:59:47', '2021-01-02 09:31:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_addresses`
--

CREATE TABLE `delivery_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `users_id` int(11) NOT NULL,
  `users_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maincategories`
--

CREATE TABLE `maincategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maincategories`
--

INSERT INTO `maincategories` (`id`, `name`, `description`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tiffin', NULL, 1, NULL, '2020-11-26 12:58:54', '2020-11-26 08:16:37', NULL),
(2, 'Catering', 'Catering..........', 1, NULL, '2020-11-26 07:56:56', '2020-11-26 07:59:58', NULL),
(3, 'Menu', NULL, 1, NULL, '2020-11-26 08:20:32', '2020-11-26 08:20:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_11_17_182818_create_roles_table', 1),
(4, '2020_11_17_120800_create_socialproviders_table', 1),
(5, '2020_11_17_122954_create_maincategories_table', 1),
(6, '2020_11_17_122955_create_categories_table', 1),
(7, '2020_11_17_123337_create_products_table', 1),
(8, '2020_11_17_123410_create_product_atts_table', 1),
(9, '2020_11_17_123601_create_tblgalleries_table', 1),
(10, '2020_11_17_123634_create_sliders_table', 1),
(11, '2020_11_17_123925_create_carts_table', 1),
(12, '2020_11_17_124117_create_countries_table', 1),
(13, '2020_11_17_124312_create_delivery_addresses_table', 1),
(14, '2020_11_17_124342_create_orders_table', 1),
(15, '2020_11_17_124459_create_theme_settings_table', 1),
(16, '2020_11_17_125019_create_audits_table', 1),
(17, '2020_11_18_082338_create_photos_table', 1),
(20, '2020_11_27_104242_create_coupons_table', 2),
(22, '2020_12_20_105429_create_orderproducts_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orderpayments`
--

CREATE TABLE `orderpayments` (
  `id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `payment_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_amount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` datetime NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('Paid','Refund') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Paid',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderproducts`
--

CREATE TABLE `orderproducts` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `p_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_price` double(8,2) NOT NULL,
  `p_qty` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_categories_id` int(10) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `users_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_charges` double(8,2) DEFAULT NULL,
  `coupon_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_amount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grand_total` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` datetime NOT NULL,
  `payer_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_received` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `order_pickup` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `file`, `created_at`, `updated_at`) VALUES
(1, '1605724236IMG_20190523_101133.jpeg', '2020-11-18 17:30:36', '2020-11-18 17:30:36'),
(2, '1605724281IMG_20190523_101133.jpeg', '2020-11-18 17:31:21', '2020-11-18 17:31:21'),
(3, '1605724334IMG_20190523_101133.jpeg', '2020-11-18 17:32:14', '2020-11-18 17:32:14'),
(4, '1605724376IMG_20190523_101133.jpeg', '2020-11-18 17:32:56', '2020-11-18 17:32:56'),
(5, '1605724424IMG_20190523_101133.jpeg', '2020-11-18 17:33:44', '2020-11-18 17:33:44'),
(6, '1606123090index.jpg', '2020-11-23 08:18:10', '2020-11-23 08:18:10'),
(7, '16061255651.png', '2020-11-23 08:59:25', '2020-11-23 08:59:25'),
(8, '2_16061296401599284336Rock-Cairn.png', '2020-11-23 10:07:20', '2020-11-23 10:07:20'),
(9, '1611489024Miners-Castle.png', '2021-01-24 04:50:24', '2021-01-24 04:50:24'),
(10, '1611489139Miners-Castle.png', '2021-01-24 04:52:19', '2021-01-24 04:52:19'),
(11, '1611489578Miners-Castle.png', '2021-01-24 04:59:38', '2021-01-24 04:59:38'),
(12, '1611489695Miners-Castle.png', '2021-01-24 05:01:35', '2021-01-24 05:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_categories_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `p_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `small_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `is_visible` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `tiffin_preparation_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `main_categories_id`, `categories_id`, `p_name`, `p_code`, `description`, `price`, `image`, `small_image`, `is_featured`, `is_visible`, `tiffin_preparation_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(76, 3, 15, 'Bundi Ladu', 'MSW0001', 'Bundi Ladu 5 pieces.', 5.00, 'public/products/1621869472bundi-ladoo-500x500.jpg', 'public/products/small/1621869472bundi-ladoo-500x500.jpg', 'yes', 'yes', NULL, '2021-05-24 00:07:26', '2021-05-24 09:21:52', NULL),
(77, 3, 15, 'Kaju Katli', 'MSW00002', 'Kaju Katali 200 gm', 5.00, 'public/products/1621869698kaju-katli-500x500.jpg', 'public/products/small/1621869698kaju-katli-500x500.jpg', 'yes', 'yes', NULL, '2021-05-24 09:21:39', '2021-05-24 09:21:39', NULL),
(78, 3, 15, 'Mohanthal', 'MSW0003', 'Mohanthal Gram Flour Fudge 5 pieces', 5.00, 'public/products/1621869992Mohanthal.jpg', 'public/products/small/1621869992Mohanthal.jpg', 'yes', 'yes', NULL, '2021-05-24 09:26:34', '2021-05-24 09:26:34', NULL),
(79, 3, 16, 'Ratlami Sev', 'MNAM0001', 'Dahod Style Ratlami Sev', 5.00, 'public/products/1621870689RatlamiSev.jpg', 'public/products/small/1621870689RatlamiSev.jpg', 'yes', 'yes', NULL, '2021-05-24 09:38:10', '2021-05-24 09:38:10', NULL),
(80, 3, 16, 'Khari Sing', 'MNAM002', 'Bharuchi Khari sing', 3.00, 'public/products/1621870721Khari Sing.jpg', 'public/products/small/1621870721Khari Sing.jpg', 'yes', 'yes', NULL, '2021-05-24 09:38:41', '2021-05-24 09:38:41', NULL),
(81, 3, 16, 'Kenyan Chevdo', 'MNAM003', 'Tropical Heat Kenyan Chevdo', 6.00, 'public/products/1621870793KenyanChevdo.jpg', 'public/products/small/1621870793KenyanChevdo.jpg', 'yes', 'yes', NULL, '2021-05-24 09:39:53', '2021-05-24 09:39:53', NULL),
(82, 3, 17, 'Rotli 5pc', 'MBR001', 'Gujarati Rotali 5 Pc', 3.00, 'public/products/1621870967Rotali.jpg', 'public/products/small/1621870967Rotali.jpg', 'yes', 'yes', NULL, '2021-05-24 09:40:48', '2021-05-24 09:42:47', NULL),
(83, 3, 17, 'Rotli 10pc', 'MBR0002', 'Gujarati Rotali 10 Pc', 5.00, 'public/products/1621871017Rotali.jpg', 'public/products/small/1621871017Rotali.jpg', 'yes', 'yes', NULL, '2021-05-24 09:43:37', '2021-05-24 09:43:37', NULL),
(84, 3, 17, 'Methi thepla 5 pc', 'MBR0003', 'Methi na Thepla 5 Pc.', 5.00, 'public/products/1621871177Dhebra.jpg', 'public/products/small/1621871177Dhebra.jpg', 'yes', 'yes', NULL, '2021-05-24 09:46:17', '2021-05-24 09:46:17', NULL),
(85, 1, 22, 'Veg Tiffin', 'veg-tiffin1621873420', '<div>Kadhi&nbsp;<br></div><div>Bhat&nbsp;</div><div>Bharela Bhinda nu Saak&nbsp;</div><div>Mug ni Dal&nbsp;</div><div>Rotli&nbsp;</div><div>Pickle</div>', 10.00, 'public/products/1609569332tiffin.png', 'public/products/small/1609570657tiffin.png', 'no', 'yes', '2021-05-25', '2021-05-24 10:23:40', '2021-05-24 10:23:40', NULL),
(86, 1, 22, 'Veg Tiffin', 'veg-tiffin1621873546', '<div>Tadka Dal&nbsp;</div><div>Jira Rice&nbsp;</div><div>Bataka nu Shak&nbsp;</div><div>Puri</div><div>Khaman</div>', 10.00, 'public/products/1609569332tiffin.png', 'public/products/small/1609570657tiffin.png', 'no', 'yes', '2021-05-26', '2021-05-24 10:25:46', '2021-05-24 10:25:46', NULL),
(87, 1, 22, 'Veg Tiffin', 'veg-tiffin1621873561', '<div>Dam Aloo&nbsp;</div><div>Pulav&nbsp;</div><div>Paratha&nbsp;</div><div>Raitu</div><div>Sweet</div>', 10.00, 'public/products/1609569332tiffin.png', 'public/products/small/1609570657tiffin.png', 'no', 'yes', '2021-05-27', '2021-05-24 10:26:01', '2021-05-24 10:26:01', NULL),
(88, 1, 22, 'Veg Tiffin', 'veg-tiffin1621873573', '<div>Kadhi&nbsp;</div><div>Bhat&nbsp;</div><div>Val ni Dal&nbsp;</div><div>Flower Bataka Vatana nu Shak&nbsp;</div><div>Rotli&nbsp;</div><div>Pickle</div>', 10.00, 'public/products/1609569332tiffin.png', 'public/products/small/1609570657tiffin.png', 'no', 'yes', '2021-05-28', '2021-05-24 10:26:13', '2021-05-24 10:26:13', NULL),
(89, 1, 22, 'Veg Tiffin', 'veg-tiffin1621873590', '<div>Dal Dhokri</div><div>Bhat&nbsp;</div><div>Dahi</div><div>Thepla 3</div><div>Pickle</div>', 10.00, 'public/products/1609569332tiffin.png', 'public/products/small/1609570657tiffin.png', 'no', 'yes', '2021-05-29', '2021-05-24 10:26:30', '2021-05-24 10:26:30', NULL),
(90, 1, 22, 'Veg Tiffin', 'veg-tiffin1621873608', '<div>Kadhi&nbsp;</div><div>Bhat&nbsp;</div><div>Mug na Vaidha&nbsp;</div><div>Tindora Bataka nu Saak&nbsp;</div><div>Rotli&nbsp;</div><div>Pickle</div>', 10.00, 'public/products/1609569332tiffin.png', 'public/products/small/1609570657tiffin.png', 'no', 'yes', '2021-05-30', '2021-05-24 10:26:48', '2021-05-24 10:26:48', NULL),
(91, 2, 20, 'Ladu', 'CSW0001', 'Gor na Ladu', 1.00, 'public/products/1621874616rava-ladoo.jpg', 'public/products/small/1621874616rava-ladoo.jpg', 'no', 'yes', NULL, '2021-05-24 10:43:38', '2021-05-24 10:43:38', NULL),
(92, 2, 20, 'Shrikhand', 'CSW0002', 'Kesar Shrikhand', 1.25, 'public/products/1621874675Shrikhand.jpg', 'public/products/small/1621874675Shrikhand.jpg', 'no', 'yes', NULL, '2021-05-24 10:44:35', '2021-05-24 10:44:35', NULL),
(93, 2, 20, 'Mango Ras', 'CSW0003', 'Kesar Ras', 1.00, 'public/products/1621874703MangoRas.jpg', 'public/products/small/1621874703MangoRas.jpg', 'no', 'yes', NULL, '2021-05-24 10:45:03', '2021-05-24 10:45:03', NULL),
(94, 2, 19, 'Rotali', 'CBR0001', 'Gujarati Rotali', 2.50, 'public/products/1621875092Rotali.jpg', 'public/products/small/1621875092Rotali.jpg', 'no', 'yes', NULL, '2021-05-24 10:51:32', '2021-05-24 10:51:32', NULL),
(95, 2, 19, 'Puri', 'CBR0002', 'Fried Puri', 1.25, 'public/products/1621875128Puri.jpg', 'public/products/small/1621875128Puri.jpg', 'no', 'yes', NULL, '2021-05-24 10:52:08', '2021-05-24 10:52:08', NULL),
(96, 2, 19, 'Naan', 'CBR0003', 'Punjabi Naan', 1.00, 'public/products/1621875158Naan.jpg', 'public/products/small/1621875158Naan.jpg', 'no', 'yes', NULL, '2021-05-24 10:52:38', '2021-05-24 10:52:38', NULL),
(97, 2, 24, 'Kadhi', 'CDAL0001', 'Gujarati Kadhi', 0.85, 'public/products/1621876889Gujarati Kadhi.jpg', 'public/products/small/1621876889Gujarati Kadhi.jpg', 'no', 'yes', NULL, '2021-05-24 11:21:31', '2021-05-24 11:21:31', NULL),
(98, 2, 24, 'Dal Tadaka', 'CDAL0002', 'Punjabi Daal Tadka', 1.00, 'public/products/1621876926Dal-tadka.jpg', 'public/products/small/1621876926Dal-tadka.jpg', 'no', 'yes', NULL, '2021-05-24 11:22:06', '2021-05-24 11:22:06', NULL),
(99, 2, 24, 'Daal', 'CDAL0003', 'Gujarati Daal', 1.00, 'public/products/1621876953Gujarati Daal.jpg', 'public/products/small/1621876953Gujarati Daal.jpg', 'no', 'yes', NULL, '2021-05-24 11:22:33', '2021-05-24 11:22:33', NULL),
(100, 2, 23, 'White Rice', 'CRIC0001', 'White Rice', 0.50, 'public/products/1621876997WhiteRice.jpg', 'public/products/small/1621876997WhiteRice.jpg', 'no', 'yes', NULL, '2021-05-24 11:23:17', '2021-05-24 11:23:17', NULL),
(101, 2, 23, 'Veg Pulao', 'CRIC0002', 'Vegetarian Pulao', 1.00, 'public/products/1621877032vegetable pulao.JPG', 'public/products/small/1621877032vegetable pulao.JPG', 'no', 'yes', NULL, '2021-05-24 11:23:52', '2021-05-24 11:23:52', NULL),
(102, 2, 23, 'Veg Biryani', 'CRIC0003', 'Veg. Biryani', 1.10, 'public/products/1621877063Veg Biryani.jpg', 'public/products/small/1621877063Veg Biryani.jpg', 'no', 'yes', NULL, '2021-05-24 11:24:23', '2021-05-24 11:24:23', NULL),
(103, 2, 21, 'Mango Lassi', 'CDRK0001', 'Mango Lassi', 1.00, 'public/products/1621877110Mango Lassi.jpg', 'public/products/small/1621877110Mango Lassi.jpg', 'no', 'yes', NULL, '2021-05-24 11:25:10', '2021-05-24 11:25:10', NULL),
(104, 2, 21, 'Masala Chaas', 'CDRK0002', 'Kathiyawadi Chaas', 1.00, 'public/products/1621877138Masala Chaas.jpg', 'public/products/small/1621877138Masala Chaas.jpg', 'no', 'yes', NULL, '2021-05-24 11:25:38', '2021-05-24 11:25:38', NULL),
(105, 2, 21, 'Tea', 'CDRK0003', 'Masala Tea', 0.50, 'public/products/1621877172Tea.jpg', 'public/products/small/1621877172Tea.jpg', 'no', 'yes', NULL, '2021-05-24 11:26:12', '2021-05-24 11:26:12', NULL),
(106, 2, 21, 'Coffee', 'CDRK0004', 'Indian Coffee', 0.50, 'public/products/1621877200Coffee.jpg', 'public/products/small/1621877200Coffee.jpg', 'no', 'yes', NULL, '2021-05-24 11:26:40', '2021-05-24 11:26:40', NULL),
(107, 2, 21, 'Bottled Water', 'CDRK0005', 'Bottled Water', 1.00, 'public/products/1621877244BottledWater.jpg', 'public/products/small/1621877244BottledWater.jpg', 'no', 'yes', NULL, '2021-05-24 11:27:24', '2021-05-24 11:27:24', NULL),
(108, 2, 18, 'Sev Tamato', 'KSUB001', 'Sev Tamatar Shaak', 1.00, 'public/products/1621877645SevTamato.jpg', 'public/products/small/1621877645SevTamato.jpg', 'no', 'yes', NULL, '2021-05-24 11:34:07', '2021-05-24 11:34:07', NULL),
(109, 2, 18, 'Navratna Korma', 'KSUB002', 'Punjabi NavRatna Korma', 1.25, 'public/products/1621877680Navratna Korma.jpg', 'public/products/small/1621877680Navratna Korma.jpg', 'no', 'yes', NULL, '2021-05-24 11:34:40', '2021-05-24 11:34:40', NULL),
(110, 2, 18, 'Paneer Tikka Masala', 'KSUB003', 'Paneer Masala Gravy', 1.50, 'public/products/1621877713Paneer Tikka Masala.gif', 'public/products/small/1621877713Paneer Tikka Masala.gif', 'no', 'yes', NULL, '2021-05-24 11:35:13', '2021-05-24 11:35:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`, `user_id`, `deleted_at`) VALUES
(1, 'Admin', '2020-11-18 16:42:55', '2020-11-18 16:42:55', 2, NULL),
(2, 'Sales User', '2020-11-18 16:43:10', '2020-11-18 16:43:10', 2, NULL),
(3, 'Kitchen User', '2021-01-21 16:09:16', '2021-01-21 04:41:28', 2, NULL),
(4, 'Counter User', '2021-01-21 16:09:37', '2021-01-21 16:09:37', 2, NULL),
(5, 'Front User', '2020-11-18 16:43:33', '2020-11-18 11:44:47', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `btntitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `btnlink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `description`, `image`, `btntitle`, `btnlink`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Welcome to Prasadam', '<strong>Lorem Ipsum</strong> is simply dummy text of the printing and \r\ntypesetting industry. Lorem Ipsum has been the industry\'s standard dummy\r\n text ever since the 1500s, when an unknown printer took a galley of \r\ntype and scrambled it to make a type specimen book. It has survived not \r\nonly five centuries,', 'public/frontend/images/slider/1606807663tifin-banner.png', 'Know More', 'https://www.neoinventions.com/tiffin/about', '2020-11-29 15:21:49', '2021-01-23 21:39:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `socialproviders`
--

CREATE TABLE `socialproviders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `tenant_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tenant_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tenant_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tenant_favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_cutoff_time` time NOT NULL,
  `pickup_start_time` time DEFAULT NULL,
  `pickup_end_time` time DEFAULT NULL,
  `pickup_catering_start_time` time DEFAULT NULL,
  `pickup_catering_end_time` time DEFAULT NULL,
  `front_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `front_mobile` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime_format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catering_min_date` int(11) DEFAULT NULL,
  `smtp_website_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_server` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_port` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_email_pass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_from_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_transport_exp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_encryption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_reasons` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catering_cancel_cutoff_time` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `tenant_title`, `tenant_description`, `tenant_image`, `tenant_favicon`, `currency`, `order_cutoff_time`, `pickup_start_time`, `pickup_end_time`, `pickup_catering_start_time`, `pickup_catering_end_time`, `front_email`, `front_mobile`, `datetime_format`, `phone_format`, `catering_min_date`, `smtp_website_name`, `smtp_server`, `smtp_port`, `smtp_email`, `smtp_email_pass`, `smtp_from_name`, `smtp_from_email`, `smtp_transport_exp`, `smtp_encryption`, `cancel_reasons`, `catering_cancel_cutoff_time`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tiffin Services', '2397 Satellite Blvd , Buford Georgia 30518', '1606712299logo.png', '1606712299favicon.png', '$', '08:00:00', '12:00:00', '20:00:00', '07:00:00', '20:00:00', 'kintushah@hotmail.com', '(770) 492-4346', 'm/d/Y H:i:s', '(888) 888-8888', 2, 'https://www.neoinventions.com/tiffin', 'mail.neoinventions.com', '465', 'noreply@neoinventions.com', 'noreply@123', 'Neoinventions', 'noreply@neoinventions.com', 'sendmail', 'ssl', 'Reason 1, Reason 2, Reason 3', 48, '2020-11-23 16:26:40', '2021-03-24 07:23:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_id` int(11) DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `photo_id`, `address`, `city`, `state`, `country`, `pincode`, `mobile`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 'Saurabh', 'absdevlop@gmail.com', NULL, '$2y$10$MO99PscQOZB4X9XtGrGasup9DtaNAPh1uaFvGoLsbR4XAVpeGt6vy', 8, 'Address', 'Vadodara', 'Gujarat', 'India', '390011', '(784) 512-4574', 1, '1F4phUvc8GwMQyWyQ30wFdzP52j4DtJbVE03U2YkXWnbsDMXYnMN1IV8iZhw', '2020-11-18 08:02:11', '2021-05-25 12:50:42', NULL),
(3, 2, 'Sales User', 'sales@gmail.com', NULL, '$2y$10$nSGICR8J8qXn/oklMBo4L.vNQFVHueCWzT4GPHaCDIWzcIhQ2xDga', 6, 'as', 'Vadodara', 'Gujarat', 'India', '390011', '(784) 512-4578', 1, 'crV0CTuTeXmlZANbhaL3mxVKN9okR1vChNsds2mTUGpIIZRTDPTTuWm7JCaV', '2020-11-23 08:18:10', '2020-11-23 08:56:10', NULL),
(4, 3, 'Kitchen User', 'kitchen@gmail.com', NULL, '$2y$10$nSGICR8J8qXn/oklMBo4L.vNQFVHueCWzT4GPHaCDIWzcIhQ2xDga', 6, 'as', 'Vadodara', 'Gujarat', 'India', '390011', '(784) 512-4578', 1, 'fKO1mMZepEK4mZk2auTdSZSBx64YhrsSaLGINLPXBpubs0W0rrcxkr6tgCw8', '2020-11-23 08:18:10', '2020-11-23 08:56:10', NULL),
(5, 4, 'Counter User', 'counter@gmail.com', NULL, '$2y$10$nSGICR8J8qXn/oklMBo4L.vNQFVHueCWzT4GPHaCDIWzcIhQ2xDga', 6, 'as', 'Vadodara', 'Gujarat', 'India', '390011', '(784) 512-4578', 1, 'KP09oGz1tzajZ9X51siD9yxKii1VTgNSQdyTZ2QnfAEMcm5q0lTc8MX6zy9P', '2020-11-23 08:18:10', '2020-11-23 08:56:10', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maincategories`
--
ALTER TABLE `maincategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderpayments`
--
ALTER TABLE `orderpayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderproducts`
--
ALTER TABLE `orderproducts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_user_id_foreign` (`user_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socialproviders`
--
ALTER TABLE `socialproviders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3161;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maincategories`
--
ALTER TABLE `maincategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orderpayments`
--
ALTER TABLE `orderpayments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderproducts`
--
ALTER TABLE `orderproducts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `socialproviders`
--
ALTER TABLE `socialproviders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
