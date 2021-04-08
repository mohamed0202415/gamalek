-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 27, 2020 at 04:09 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamalek`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads_images`
--

CREATE TABLE `ads_images` (
  `id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `page` varchar(10) NOT NULL,
  `position` varchar(10) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, 'البشرة', 0, '2020-08-27 18:44:53', 0, '2020-08-28 19:29:41', 1),
(2, 'الشعر', 0, '2020-08-27 18:46:54', 0, '2020-08-28 19:29:51', 1),
(5, 'مالتي ثيرابي', 2, '2020-08-27 18:47:44', 0, '2020-08-27 18:47:44', 0),
(6, 'علاج حب الشباب', 1, '2020-08-28 19:31:35', 1, '2020-08-28 19:31:35', 1),
(7, 'منتجات التفتيح', 1, '2020-08-28 19:31:43', 1, '2020-08-28 19:31:43', 1),
(8, 'التقشيرر الكيميائي', 1, '2020-08-28 19:31:54', 1, '2020-08-28 19:31:54', 1),
(9, 'التقشير الطبيعي ', 1, '2020-08-28 19:32:04', 1, '2020-08-28 19:32:04', 1),
(10, 'شامبو قبل الترميم', 2, '2020-08-28 19:33:08', 1, '2020-08-28 19:33:08', 1),
(11, 'الترميم البارد', 2, '2020-08-28 19:33:54', 1, '2020-08-28 19:33:54', 1),
(12, 'مجموعات العناية بالشعر', 2, '2020-08-28 19:34:08', 1, '2020-08-28 19:34:29', 1),
(13, 'حمام الكريم', 2, '2020-08-28 19:34:14', 1, '2020-08-28 19:34:38', 1),
(14, 'سيرم بعد الترميم', 2, '2020-08-28 19:36:12', 1, '2020-08-28 19:36:12', 1),
(15, 'علاج تساقط الشعر', 0, '2020-08-31 23:19:56', 1, '2020-08-31 23:19:56', 1),
(16, 'أمبولات', 15, '2020-08-31 23:20:12', 1, '2020-08-31 23:20:12', 1),
(17, 'فيتامينات', 15, '2020-08-31 23:20:36', 1, '2020-08-31 23:20:36', 1),
(18, 'كريمات', 15, '2020-08-31 23:20:41', 1, '2020-08-31 23:20:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `code`, `parent_id`) VALUES
(1, 'القاهرة', '02', 0),
(2, 'الجيزة', '02', 0),
(3, 'القليوبية', '013', 0),
(4, '	الإسكندرية', '03', 0),
(5, '	البحيرة', '045', 0),
(6, 'مرسى مطروح', '064', 0),
(7, 'الدقهلية', '050', 0),
(8, 'كفر الشيخ', '047', 0),
(9, 'الغربية', '040', 0),
(10, 'المنوفية', '048', 0),
(11, 'دمياط', '057', 0),
(12, 'بورسعيد', '066', 0),
(13, '	الإسماعيلية', '064', 0),
(14, '	السويس', '062', 0),
(15, '	الشرقية', '055', 0),
(16, '	شمال سيناء', '068', 0),
(17, '	جنوب سيناء', '063', 0),
(18, 'بني سويف', '082', 0),
(19, 'المنيا', '086', 0),
(20, 'الفيوم', '084', 0),
(21, 'أسيوط', '088', 0),
(22, 'الوادي الجديد', '092', 0),
(23, 'سوهاج', '093', 0),
(24, 'قنا', '093', 0),
(25, 'الأقصر', '095', 0),
(26, 'أسوان', '097', 0),
(27, 'البحر الأحمر', '065', 0),
(29, 'الإبراهيمية\r', '', 4),
(30, 'الإسكندرية\r', '', 4),
(31, 'الأزاريطة\r', '', 4),
(32, 'الأنفوشي\r', '', 4),
(33, 'الجمرك\r', '', 4),
(34, 'الحضرة\r', '', 4),
(35, 'الدخيلة\r', '', 4),
(36, 'السرايا\r', '', 4),
(37, 'السيوف\r', '', 4),
(38, 'الشاطبي\r', '', 4),
(39, 'الشرق\r', '', 4),
(40, 'الصالحية\r', '', 4),
(41, 'العامرية\r', '', 4),
(42, 'العجمي\r', '', 4),
(43, 'العصافرة\r', '', 4),
(44, 'العطارين\r', '', 4),
(45, 'العوايد\r', '', 4),
(46, 'القباري\r', '', 4),
(47, 'اللبان\r', '', 4),
(48, 'المتراس\r', '', 4),
(49, 'المعمورة\r', '', 4),
(50, 'المكس\r', '', 4),
(51, 'المنتزة\r', '', 4),
(52, 'المندرة\r', '', 4),
(53, 'المنشية\r', '', 4),
(54, 'الورديان\r', '', 4),
(55, 'الوسط\r', '', 4),
(56, 'أبيس\r', '', 4),
(57, 'باكوس\r', '', 4),
(58, 'بحري\r', '', 4),
(59, 'برج العرب\r', '', 4),
(60, 'بولكلي\r', '', 4),
(61, 'ثروت\r', '', 4),
(62, 'جليم\r', '', 4),
(63, 'جناككليس\r', '', 4),
(64, 'رأس التين\r', '', 4),
(65, 'رشدي\r', '', 4),
(66, 'زيزينيا\r', '', 4),
(67, 'سابا باشا\r', '', 4),
(68, 'سان ستيفانو\r', '', 4),
(69, 'سبورتنج\r', '', 4),
(70, 'ستانلي\r', '', 4),
(71, 'سموحة\r', '', 4),
(72, 'سيدي بشر\r', '', 4),
(73, 'سيدي جابر\r', '', 4),
(74, 'شدس\r', '', 4),
(75, 'صفر\r', '', 4),
(76, 'فكتوريا\r', '', 4),
(77, 'فلمنج\r', '', 4),
(78, 'كامب شيزار\r', '', 4),
(79, 'كرموز\r', '', 4),
(80, 'كفر عبده\r', '', 4),
(81, 'كليوباترا\r', '', 4),
(82, 'كوم الدكة\r', '', 4),
(83, 'لوران\r', '', 4),
(84, 'محرم بك\r', '', 4),
(85, 'محطة الرمل\r', '', 4),
(86, 'ميامي', '', 4),
(87, ' الزاوية الحمراء\r', '', 1),
(88, 'الأزبكية\r', '', 1),
(89, 'البساتين\r', '', 1),
(90, 'الجمالية\r', '', 1),
(91, 'الخليفة\r', '', 1),
(92, 'الدرب الأحمر\r', '', 1),
(93, 'الزمالك\r', '', 1),
(94, 'الزيتون\r', '', 1),
(95, 'الساحل\r', '', 1),
(96, 'السلام أول\r', '', 1),
(97, 'السلام ثاني\r', '', 1),
(98, 'السيدة زينب\r', '', 1),
(99, 'الشرابية\r', '', 1),
(100, 'المرج\r', '', 1),
(101, 'المطرية\r', '', 1),
(102, 'المقطم\r', '', 1),
(103, 'النزهة\r', '', 1),
(104, 'بولاق\r', '', 1),
(105, 'حدائق القبة\r', '', 1),
(106, 'دار السلام\r', '', 1),
(107, 'روض الفرج\r', '', 1),
(108, 'شبرا\r', '', 1),
(109, 'شرق مدينة نصر\r', '', 1),
(110, 'عابدين\r', '', 1),
(111, 'عين شمس\r', '', 1),
(112, 'غرب مدينة نصر\r', '', 1),
(113, 'قصر النيل \r', '', 1),
(114, 'مصر الجديدة\r', '', 1),
(115, 'مصر القديمة\r', '', 1),
(116, 'منشأة ناصر\r', '', 1),
(117, 'التبين\r', '', 1),
(118, 'حلوان\r', '', 1),
(119, 'المعادي\r', '', 1),
(120, 'طرة\r', '', 1),
(121, '15-مايو', '', 1),
(122, 'البدرشين\r', '', 2),
(123, 'الحوامدية\r', '', 2),
(124, 'الدقي\r', '', 2),
(125, 'الصف\r', '', 2),
(126, 'العجوزة \r', '', 2),
(127, 'العمرانية\r', '', 2),
(128, 'العياط \r', '', 2),
(129, 'القناطر\r', '', 2),
(130, 'الهرم\r', '', 2),
(131, 'الواحات\r', '', 2),
(132, 'أبو النمرس\r', '', 2),
(133, 'أطفيح \r', '', 2),
(134, 'أوسيم\r', '', 2),
(135, 'بولاق الدكرور\r', '', 2),
(136, 'جنوب الجيزة \r', '', 2),
(137, 'شمال الجيزة \r', '', 2),
(138, 'غطاطي\r', '', 2),
(139, 'كرداسة\r', '', 2),
(140, 'منشأة البكاري', '', 2),
(141, 'الخانكة\r', '', 3),
(142, 'العبور\r', '', 3),
(143, 'القناطر الخيرية\r', '', 3),
(144, 'بنها\r', '', 3),
(145, 'شبرا الخيمة\r', '', 3),
(146, 'شبين القناطر\r', '', 3),
(147, 'طوخ\r', '', 3),
(148, 'قليوب\r', '', 3),
(149, 'كفر شكر', '', 3),
(150, 'الدلنجات\r', '', 5),
(151, 'الرحمانية\r', '', 5),
(152, 'المحمودية\r', '', 5),
(153, 'النوبارية الجديدة\r', '', 5),
(154, 'ايتاي البارود\r', '', 5),
(155, 'إدكو\r', '', 5),
(156, 'أبو المطامير\r', '', 5),
(157, 'أبو حمص \r', '', 5),
(158, 'حوش عيسى\r', '', 5),
(159, 'دمنهور\r', '', 5),
(160, 'رشيد\r', '', 5),
(161, 'شبراخيت\r', '', 5),
(162, 'كفر الدوار\r', '', 5),
(163, 'كوم حمادة\r', '', 5),
(164, 'وادي النطرون', '', 5),
(165, 'الجمالية\r', '', 7),
(166, 'السنبلاوين\r', '', 7),
(167, 'الكردي\r', '', 7),
(168, 'المطرية\r', '', 7),
(169, 'المنزلة\r', '', 7),
(170, 'المنصورة\r', '', 7),
(171, 'أجا\r', '', 7),
(172, 'بلقاس\r', '', 7),
(173, 'بنى عبيد\r', '', 7),
(174, 'تمى الأمديد\r', '', 7),
(175, 'جمصة\r', '', 7),
(176, 'دكرنس\r', '', 7),
(177, 'شربين\r', '', 7),
(178, 'طلخا\r', '', 7),
(179, 'منية النصر\r', '', 7),
(180, 'ميت سلسيل\r', '', 7),
(181, 'ميت غمر\r', '', 7),
(182, 'نبروه', '', 7),
(183, 'الحمام\r', '', 6),
(184, 'السلوم\r', '', 6),
(185, 'الضبعة\r', '', 6),
(186, 'العلمين\r', '', 6),
(187, 'النجيلة\r', '', 6),
(188, 'سيدي براني\r', '', 6),
(189, 'سيوة\r', '', 6),
(190, 'مرسى مطروح', '', 6),
(191, 'البرلـــس\r', '', 8),
(192, 'الحامـول\r', '', 8),
(193, 'الريـاض\r', '', 8),
(194, 'بيـــــلا\r', '', 8),
(195, 'دســــوق\r', '', 8),
(196, 'سيدي سالم\r', '', 8),
(197, 'فـــــــــوه\r', '', 8),
(198, 'قليـــــــن\r', '', 8),
(199, 'كفر الشيخ\r', '', 8),
(200, 'مطوبس', '', 8),
(201, 'السنطة\r', '', 9),
(202, 'بسيون\r', '', 9),
(203, 'زفتى\r', '', 9),
(204, 'سمنود\r', '', 9),
(205, 'قطور\r', '', 9),
(206, 'كفر الزيات\r', '', 9),
(207, 'المحلة الكبرى\r', '', 9),
(208, 'طنطا', '', 9),
(209, 'شبين الكوم\r', '', 10),
(210, 'منوف\r', '', 10),
(211, 'الباجور\r', '', 10),
(212, 'السادات\r', '', 10),
(213, 'أشمون\r', '', 10),
(214, 'تلا\r', '', 10),
(215, 'قويسنا\r', '', 10),
(216, 'بركة السبع\r', '', 10),
(217, 'الشهداء\r', '', 10),
(218, 'سرس الليان', '', 10),
(219, 'راس البر\r', '', 11),
(220, 'عزبة البرج\r', '', 11),
(221, 'دمياط الجديدة\r', '', 11),
(222, 'كفر البطيخ\r', '', 11),
(223, 'ميت ابوغالب\r', '', 11),
(224, 'الروضة ،\r', '', 11),
(225, 'السرو\r', '', 11),
(226, 'فارسكور\r', '', 11),
(227, 'كفر سعد\r', '', 11),
(228, 'الزرقا', '', 11),
(229, 'حي الجنوب\r', '', 12),
(230, 'حي الزهور\r', '', 12),
(231, 'حي الشرق\r', '', 12),
(232, 'حي الضواحي\r', '', 12),
(233, 'حي العرب\r', '', 12),
(234, 'حي المناخ\r', '', 12),
(235, 'حي بورفؤاد', '', 12),
(236, 'الإسماعيلية\r', '', 13),
(237, 'التل الكبير\r', '', 13),
(238, 'القصاصين\r', '', 13),
(239, 'القنطرة شرق\r', '', 13),
(240, 'القنطرة غرب \r', '', 13),
(241, 'أبوصوير\r', '', 13),
(242, 'فايد', '', 13),
(243, 'السويس\r', '', 14),
(244, 'الأربعين\r', '', 14),
(245, 'عتاقة\r', '', 14),
(246, 'الجناين\r', '', 14),
(247, 'فيصل', '', 14),
(248, 'ابو كبير\r', '', 15),
(249, 'أولاد صقر\r', '', 15),
(250, 'بلبيس\r', '', 15),
(251, 'الحسينية\r', '', 15),
(252, 'ديرب نجم\r', '', 15),
(253, 'الزقازيق\r', '', 15),
(254, 'الصالحية\r', '', 15),
(255, 'العاشر من رمضان\r', '', 15),
(256, 'كفر صقر\r', '', 15),
(257, 'منيا القمح\r', '', 15),
(258, 'ههيا\r', '', 15),
(259, 'مشتول السوق\r', '', 15),
(260, 'الإبراهيمية\r', '', 15),
(261, 'القرين\r', '', 15),
(262, 'القنايات', '', 15),
(263, 'بئر العبد\r', '', 16),
(264, 'نخل\r', '', 16),
(265, 'الحسنة\r', '', 16),
(266, 'العريش\r', '', 16),
(267, 'الشيخ زويد\r', '', 16),
(268, 'رفح', '', 16),
(269, 'أبو رديس\r', '', 17),
(270, 'أبو زنيمة\r', '', 17),
(271, 'نويبع\r', '', 17),
(272, 'دهب\r', '', 17),
(273, 'رأس سدر\r', '', 17),
(274, 'شرم الشيخ\r', '', 17),
(275, 'سانت كاترين\r', '', 17),
(276, 'طور سيناء', '', 17),
(277, 'بني سويف\r', '', 18),
(278, 'ناصر(الشناوية)\r', '', 18),
(279, 'الفشن\r', '', 18),
(280, 'ببا\r', '', 18),
(281, 'إهناسيا\r', '', 18),
(282, 'الواسطى\r', '', 18),
(283, 'سمسطا\r', '', 18),
(284, 'بني سويف الجديدة', '', 18),
(285, 'أبو قرقاص\r', '', 19),
(286, 'بني مزار\r', '', 19),
(287, 'دير مواس\r', '', 19),
(288, 'سمالوط\r', '', 19),
(289, 'العدوة\r', '', 19),
(290, 'مطاي\r', '', 19),
(291, 'مغاغة\r', '', 19),
(292, 'ملوي\r', '', 19),
(293, 'المنيا', '', 19),
(294, 'الفيوم\r', '', 20),
(295, 'سنورس\r', '', 20),
(296, 'ابشواي\r', '', 20),
(297, 'اطسا\r', '', 20),
(298, 'طامية\r', '', 20),
(299, 'يوسف الصديق', '', 20),
(300, 'ديروط\r', '', 21),
(301, 'القوصية\r', '', 21),
(302, 'أبنوب\r', '', 21),
(303, 'منفلوط\r', '', 21),
(304, 'أسيوط\r', '', 21),
(305, 'أبو تيج\r', '', 21),
(306, 'الغنايم\r', '', 21),
(307, 'ساحل سليم\r', '', 21),
(308, 'البداري\r', '', 21),
(309, 'صدفا\r', '', 21),
(310, 'الفتح', '', 21),
(311, 'الداخلة\r', '', 22),
(312, 'الخارجة\r', '', 22),
(313, 'الفرافرة\r', '', 22),
(314, 'باريس', '', 22),
(315, 'سوهاج\r', '', 23),
(316, 'أخميم\r', '', 23),
(317, 'ساقلتة\r', '', 23),
(318, 'دار السلام\r', '', 23),
(319, 'المراغة\r', '', 23),
(320, 'طهطا\r', '', 23),
(321, 'طما\r', '', 23),
(322, 'جهينة\r', '', 23),
(323, 'المنشاه\r', '', 23),
(324, 'جرجا\r', '', 23),
(325, 'البلينا', '', 23),
(326, 'أبو تشت\r', '', 24),
(327, 'فرشوط\r', '', 24),
(328, 'نجع حمادي\r', '', 24),
(329, 'الوقف\r', '', 24),
(330, 'دشنا\r', '', 24),
(331, 'قنا\r', '', 24),
(332, 'قفط\r', '', 24),
(333, 'قوص\r', '', 24),
(334, 'نقادة\r', '', 24),
(335, 'أرمنت', '', 24),
(336, 'الأقصر\r', '', 25),
(337, 'الزينية\r', '', 25),
(338, 'القرنة\r', '', 25),
(339, 'البياضية\r', '', 25),
(340, 'الطود\r', '', 25),
(341, 'أرمنت\r', '', 25),
(342, 'إسنا', '', 25),
(343, 'إدفو\r', '', 26),
(344, 'كوم امبو\r', '', 26),
(345, 'دراو\r', '', 26),
(346, 'أسوان\r', '', 26),
(347, 'نصر النوبة\r', '', 26),
(348, 'ابو سمبل\r', '', 26),
(349, 'كلابشة\r', '', 26),
(350, 'الرديسية\r', '', 26),
(351, 'البصيلية\r', '', 26),
(352, 'السباعية', '', 26),
(353, 'الغردقة\r', '', 27),
(354, 'سفاجا\r', '', 27),
(355, 'مرسى علم\r', '', 27),
(356, 'القصير \r', '', 27),
(357, 'رأس غارب\r', '', 27),
(358, 'شلاتين', '', 27);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `city_id` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `confirmed` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `user_ip` varchar(25) NOT NULL,
  `user_os` varchar(25) NOT NULL,
  `user_browser` varchar(25) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `mobile`, `subject`, `message`, `user_ip`, `user_os`, `user_browser`, `created`, `is_read`) VALUES
(1, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', 'مهم جدا', 'يا وحشني طل عليا ازيك سلامات', '127.0.0.1', 'Windows 10', 'Chrome', '2020-09-05 03:35:15', 1),
(2, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', 'مهم جدا', 'يا وحشني طل عليا ازيك سلامات', '127.0.0.1', 'Windows 10', 'Chrome', '2020-09-05 03:35:47', 1),
(3, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', 'مهم جدا', 'يا وحشني طل عليا ازيك سلامات', '127.0.0.1', 'Windows 10', 'Chrome', '2020-09-05 03:36:14', 1),
(4, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', 'مهم جدا', 'يا وحشني طل عليا ازيك سلامات', '127.0.0.1', 'Windows 10', 'Chrome', '2020-09-05 03:36:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `incoming`
--

CREATE TABLE `incoming` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `note` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(150) DEFAULT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `image`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, 'أتراكتا', NULL, '2020-08-27 23:22:18', 0, '2020-08-27 23:22:18', 0),
(2, 'بيوتي اند بيوند', NULL, '2020-08-27 23:22:25', 0, '2020-08-27 23:22:25', 0),
(3, 'ديرما سوفت', NULL, '2020-08-27 23:22:35', 0, '2020-08-27 23:22:35', 0),
(4, 'دكتور بيوتي', NULL, '2020-08-28 19:40:24', 1, '2020-08-28 19:40:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_no` varchar(50) NOT NULL,
  `client_id` int(11) NOT NULL,
  `cost` int(11) NOT NULL DEFAULT '0',
  `shipping_id` int(11) NOT NULL,
  `status` varchar(25) DEFAULT 'pending',
  `is_paid` tinyint(4) NOT NULL DEFAULT '0',
  `note` varchar(250) NOT NULL,
  `receipt_no` varchar(20) DEFAULT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `confirmed` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `description` text,
  `online` tinyint(4) NOT NULL DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `manufacturer_id`, `cost`, `amount`, `size`, `total_cost`, `discount`, `description`, `online`, `views`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(2, 'اتراكتا سيرم', 14, 1, 240, 60, 120, 14400, 15, '<h1><strong>Atrakta Post-Epilation Cream &ndash; 100ml</strong></h1>\r\n\r\n<p>استخدمي كريم Post-Epilation من أتراكتا لمنع التهاب الجلد وتلطيفه بعد إزالة الشعر وجلسات الليزر<br />\r\n<br />\r\nولشعر أرفع وأنعم خلال ٤ أسابيع من ازالته<br />\r\n<br />\r\nيوضع على الجلد بعد ازالة الشعر و جلسات الليزر، يستخدم مرتين يوميا في اول اسبوع ثم مرة يوميا</p>\r\n\r\n<p>Laser hair removal has become a commonly sought-after procedure in recent years. However, it can have some undesirable side-effects such as skin inflammation and hair regrowth</p>\r\n\r\n<p>Apply Attrakta&rsquo;s Post-Epilation cream and have thinner, smoother hair in just 4 weeks</p>\r\n\r\n<p>Apply to the skin after hair removal and laser sessions, use twice a day during the first week and then once daily after that</p>\r\n\r\n<p>#The_Velvet_Radiance</p>\r\n\r\n<p>استخدمى Post epilation creamبعد الليزر لأنه:<br />\r\n<br />\r\nيقلل ظهور الشعر بعد ازالته<br />\r\n<br />\r\nيمنع غمقان الجلد بعد ازاله الشعر<br />\r\n<br />\r\nيمنع التهاب الجلد و يلطفه بعد ازاله الشعر<br />\r\n<br />\r\nيستخدم مباشرة بعد الجلسات مرتين يوميا اول اسبوع<br />\r\n<br />\r\nو بعدها مرة يوميا<br />\r\n<br />\r\nApply Post epilation cream after laser treatment to<br />\r\n<br />\r\n&ndash; Reduce hair growth in the treated area<br />\r\n<br />\r\n&ndash; Prevent pigmentary changes post procedure<br />\r\n<br />\r\nAccelerate skin healing<br />\r\n<br />\r\nPowerful anti-inflammatory effect<br />\r\n<br />\r\nApply on dry skin after hair removal procedure &amp; spread well<br />\r\n<br />\r\nUsed twice daily at the first week<br />\r\n<br />\r\nThen once daily</p>\r\n\r\n<p>&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;-</p>\r\n\r\n<h2>DESCRIPTION</h2>\r\n\r\n<p>Post hair removal laser cream, lightweight non-greasy formula,</p>\r\n\r\n<p>easily absorbed for quick soothing effect.</p>\r\n\r\n<p>Post epilation cream suitable for all skin types, non-comedogenic.</p>\r\n\r\n<p><strong>Application</strong></p>\r\n\r\n<p>Apply on dry skin after hair removal procedure &amp; spread well.</p>\r\n\r\n<p>Used twice daily.</p>\r\n\r\n<p><strong>Ingredients:</strong></p>\r\n\r\n<p>Aqua (Water), Caprylic/Capric Triglyceride, Glyceryl Stearate, Glycine Soja Oil (Soybean),</p>\r\n\r\n<p>Propylene Glycol, Ethylhexyl Palmitate, Cetearyl Alcohol, Aesculus Hippocastanum Seed Extract</p>\r\n\r\n<p>(Horse Chest), Phenoxyethanol, Tea-Stearate, Dimethicone, Prunus Amygdalus Dulcis Oil (Sweet Almond),</p>\r\n\r\n<p>Ceteareth-25, Sodium Dehydroacetate, Ethylhexylglycerin, Tocopherol, Linalool, Citronellol,</p>\r\n\r\n<p>Triethyl Citrate, Coumarin, Geraniol, Citral, Limonene, B.H.T., Parfum.</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>الوزن</th>\r\n			<td>100 g</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 1, 69, '2020-08-27 22:56:58', 0, '2020-09-13 16:11:17', 1),
(3, 'كلاريفاينج شامبو ', 10, 3, 75, 9, 100, 750, 0, '', 1, 5, '2020-08-28 19:38:44', 1, '2020-08-31 22:55:44', 1),
(4, 'دكتور بيوتي مالتي ثيرابي ', 5, 4, 500, 2, 100, 2500, 50, '', 1, 55, '2020-08-28 19:40:17', 1, '2020-09-04 00:37:04', 1),
(5, 'هيلثي هير', 11, 3, 200, 24, 100, 12000, 0, NULL, 1, 12, '2020-08-28 19:47:15', 1, '2020-08-28 19:47:15', 1),
(6, 'مجموعة بيوتي اند بيوند ', 12, 2, 450, 5, 0, 2250, 35, '', 1, 1, '2020-08-28 19:47:56', 1, '2020-08-30 06:57:28', 1),
(7, 'كليوباترا حمام كريم', 13, 4, 35, 24, 700, 840, 0, NULL, 1, 0, '2020-08-28 19:52:57', 1, '2020-08-28 19:52:57', 1),
(8, 'كيو تي كير - حمام كريم', 13, 4, 75, 60, 500, 7500, 0, NULL, 1, 4, '2020-08-29 01:30:06', 1, '2020-08-29 01:30:06', 1),
(9, 'دكتور بيوتي مالتي ثيرابي - 1 لتر', 5, 4, 4000, 0, 1000, 0, 0, '', 0, 1, '2020-09-03 18:12:39', 1, '2020-09-22 00:57:40', 1),
(10, 'دكتور بيوتي مالتي ثيرابي عبوة - 500 مللي', 5, 4, 2000, 0, 500, 2000, 0, '', 0, 3, '2020-09-03 18:13:08', 1, '2020-09-04 02:02:30', 1),
(11, 'علبة أمبولات بول ميتشل - 8 أمبول', 5, 4, 230, 7, 20, 1840, 0, NULL, 1, 5, '2020-09-04 00:35:20', 1, '2020-09-04 00:35:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `main` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image`, `product_id`, `description`, `main`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, '5408816-1760510371.jpg', 4, '', 1, '2020-08-29 20:54:25', 1, '2020-08-29 20:54:25', 1),
(2, '8-248x300.jpg', 4, '', 0, '2020-08-29 21:02:50', 1, '2020-08-29 21:02:50', 1),
(4, '373659-600x850.jpg', 2, '', 1, '2020-08-30 04:27:54', 1, '2020-08-30 04:27:54', 1),
(5, 'N14105830A_1.jpg', 3, '', 1, '2020-08-30 04:29:17', 1, '2020-08-30 04:29:17', 1),
(6, 'download.jpg', 5, '', 1, '2020-08-30 04:30:21', 1, '2020-08-30 04:30:21', 1),
(7, 'Viola-Kit-300-01-1.png', 6, '', 1, '2020-08-30 04:31:25', 1, '2020-08-30 04:31:25', 1),
(8, '39253499_316012318960488_1785962631354384384_n.jpg', 7, '', 1, '2020-08-30 04:32:17', 1, '2020-08-30 04:32:17', 1),
(9, 'N20094877A_1.jpg', 8, '', 1, '2020-08-30 04:32:54', 1, '2020-08-30 04:32:54', 1),
(10, 'paul mitchell.png', 11, '', 1, '2020-09-04 05:17:19', 1, '2020-09-04 05:17:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(11) NOT NULL,
  `review` text,
  `user_ip` varchar(25) NOT NULL,
  `user_os` varchar(25) NOT NULL,
  `user_browser` varchar(25) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `stars`, `name`, `email`, `mobile`, `review`, `user_ip`, `user_os`, `user_browser`, `created`, `is_read`) VALUES
(1, 4, 4, 'ay hamada', '', '01000000000', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:32:35', 1),
(2, 4, 4, 'ay hamada', '', '01000000000', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:33:37', 0),
(3, 4, 4, 'ay hamada', '', '01000000000', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:34:19', 0),
(4, 4, 4, 'ay hamada', '', '01000000000', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:36:56', 0),
(5, 4, 4, 'ay hamada', '', '01000000000', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:39:05', 0),
(6, 4, 4, 'ay hamada', '', '01000000000', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:40:08', 0),
(7, 4, 4, 'ay hamada', '', '01000000000', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:42:02', 1),
(8, 4, 4, 'ay hamada', '', '01000000000', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:42:31', 0),
(9, 4, 4, 'ay hamada', '', '01000000000', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:42:38', 0),
(10, 4, 3, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:43:19', 0),
(11, 4, 3, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:45:13', 0),
(12, 4, 3, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:45:56', 0),
(13, 4, 5, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', '', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:46:52', 0),
(14, 4, 1, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', 'اللي مجربوش خسران كتير ', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:47:26', 0),
(15, 4, 1, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', 'منتج ممتاز انصح به الجميع', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:47:57', 0),
(16, 4, 1, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', 'منتج رائع جدا ونتيجتة ممتازة', '127.0.0.1', 'Windows 10', 'Chrome', '2020-08-30 04:48:14', 0),
(17, 4, 4, 'Ahmed Ouda', 'anaouda@gmail.com', '01100864586', 'ndfeijh jfekrf', '127.0.0.1', 'Windows 10', 'Chrome', '2020-09-13 17:53:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_companies`
--

CREATE TABLE `shipping_companies` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipping_companies`
--

INSERT INTO `shipping_companies` (`id`, `name`, `address`, `mobile`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, 'ايرجنت للشحن السريع', 'شارع الشهيد طيار - الحسينية', '01100864586', '2020-08-27 00:24:41', 0, '2020-08-27 00:25:51', 0),
(3, 'ارامكس', 'حي الزهور', '0551234567', '2020-08-27 00:30:58', 0, '2020-08-27 00:30:58', 0),
(4, 'توصيل شخصي', 'لا يوجد', '01060767726', '2020-09-03 18:13:54', 1, '2020-09-03 18:13:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `quote` varchar(50) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `image`, `name`, `description`, `quote`, `link`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, '1.jpg', 'Skin Products', 'Provides You With The Best Products For Your Skin', 'NEW Arrivals', 'http://gamalek.store/products.php?category=5', '2020-09-05 02:40:31', 1, '2020-09-05 03:13:24', 1),
(2, 'hair-1.jpg', 'hair products', 'for your hair', 'New', 'http://gamalek.store/products.php?category=11', '2020-09-05 03:00:41', 1, '2020-09-05 03:00:41', 1),
(3, 'hair-2.jpg', 'Hair  Treatment', 'Fix Hair Lose Treatment', 'NEW', 'http://gamalek.store/products.php?category=10', '2020-09-05 03:06:06', 1, '2020-09-05 03:06:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `note` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `value` varchar(150) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `name`, `value`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, 'facebook', ' https://www.facebook.com/gamalekstore  ', '2020-09-05 06:38:50', 1, '2020-09-05 06:38:50', 1),
(2, 'instagram', '  https://www.instagram.com/gamalek.store  ', '2020-09-05 06:39:07', 1, '2020-09-05 06:39:07', 1),
(3, 'whatsApp', '01060767726', '2020-09-05 06:39:19', 1, '2020-09-05 06:39:19', 1),
(4, 'youtube', '  https://www.youtube.com/channel/gamalekstore  ', '2020-09-05 06:39:34', 1, '2020-09-05 06:39:34', 1),
(5, 'email', ' gamalekstore2020@gmail.com  ', '2020-09-05 06:39:48', 1, '2020-09-05 06:39:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'offline',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `last_activity` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `mobile`, `status`, `created`, `created_by`, `updated`, `updated_by`, `last_activity`) VALUES
(1, 'احمد عودة', 'anaouda', '6afd3ce668cc8f0bb03c8f0cee3614844d92d8b6', '01060767726', 'online', '2020-08-28 00:34:54', 0, '2020-08-28 00:34:54', 0, '2020-09-27 15:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `product_id`, `count`, `updated`) VALUES
(1, 4, 4, '2020-08-30 04:13:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads_images`
--
ALTER TABLE `ads_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incoming`
--
ALTER TABLE `incoming`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_companies`
--
ALTER TABLE `shipping_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads_images`
--
ALTER TABLE `ads_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incoming`
--
ALTER TABLE `incoming`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `shipping_companies`
--
ALTER TABLE `shipping_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
