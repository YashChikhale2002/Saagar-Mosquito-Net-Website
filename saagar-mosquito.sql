-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2026 at 02:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saagar-mosquito`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_log`
--

CREATE TABLE `admin_activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `detail` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_activity_log`
--

INSERT INTO `admin_activity_log` (`id`, `user_id`, `action`, `detail`, `ip`, `created_at`) VALUES
(1, 1, 'user_updated', 'Updated user: Admin (admin@gmail.com) role: editor', '::1', '2026-03-30 13:50:42'),
(2, 1, 'user_updated', 'Updated user: Admin (admin@gmail.com) role: editor', '::1', '2026-03-30 13:52:29'),
(3, 1, 'login', 'Login with 2FA captcha', '::1', '2026-03-30 15:52:12'),
(4, 1, 'logout', 'Admin logged out', '::1', '2026-03-30 15:54:25'),
(5, 1, 'login', 'Login with 2FA captcha', '::1', '2026-03-30 15:54:39'),
(6, 1, 'login', 'Login with 2FA captcha', '::1', '2026-03-31 11:28:45'),
(7, 2, 'user_created', 'Created user: Yash Chikahle (yashchikhale711@gmail.com) with role: admin', '::1', '2026-03-31 11:31:01'),
(8, 1, 'logout', 'Admin logged out', '::1', '2026-03-31 11:31:39'),
(9, 2, 'login', 'Login with 2FA captcha', '::1', '2026-03-31 11:32:10'),
(10, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 10:28:55'),
(11, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 10:38:27'),
(12, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 11:44:45'),
(13, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 12:51:21'),
(14, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 14:29:37'),
(15, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 15:05:59'),
(16, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 15:08:22'),
(17, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 16:08:33'),
(18, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 16:24:34'),
(19, 1, 'login', 'Login with 2FA captcha', '223.185.40.166', '2026-04-01 17:26:23'),
(20, 1, 'login', 'Login with 2FA captcha', '103.136.92.206', '2026-04-02 02:21:25'),
(21, 1, 'login', 'Login with 2FA captcha', '223.185.36.56', '2026-04-02 11:19:33'),
(22, 1, 'login', 'Login with 2FA captcha', '223.185.36.56', '2026-04-02 11:19:48'),
(23, 1, 'login', 'Login with 2FA captcha', '223.185.36.56', '2026-04-02 11:31:34'),
(24, 1, 'login', 'Login with 2FA captcha', '223.185.36.56', '2026-04-02 12:29:33'),
(25, 1, 'login', 'Login with 2FA captcha', '223.185.36.56', '2026-04-02 13:24:03'),
(26, 1, 'login', 'Login with 2FA captcha', '223.185.36.56', '2026-04-02 13:29:34'),
(27, 1, 'login', 'Login with 2FA captcha', '223.185.36.56', '2026-04-02 14:01:09'),
(28, 1, 'login', 'Login with 2FA captcha', '223.185.40.209', '2026-04-02 17:04:21'),
(29, 1, 'login', 'Login with 2FA captcha', '223.185.41.92', '2026-04-03 11:23:12'),
(30, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-03 17:50:14'),
(31, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-04 12:07:43'),
(32, 1, 'logout', 'Admin logged out', '::1', '2026-04-04 12:43:50'),
(33, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-04 12:53:52'),
(34, 1, 'logout', 'Admin logged out', '::1', '2026-04-04 13:19:51'),
(35, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-04 13:20:17'),
(36, 1, 'logout', 'Admin logged out', '::1', '2026-04-04 14:10:06'),
(37, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-04 14:11:11'),
(38, 1, 'blog_created', 'Blog created: wvfbgfh', '::1', '2026-04-04 19:04:37'),
(39, 1, 'blog_updated', 'Blog updated: wvfbgfh', '::1', '2026-04-04 19:05:02'),
(40, 1, 'blog_deleted', 'Blog deleted: Top 5 High-Strength Steel Grades for Commercial Construction', '::1', '2026-04-04 19:05:07'),
(41, 1, 'logout', 'Admin logged out', '::1', '2026-04-04 19:13:56'),
(42, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-04 19:14:24'),
(43, 1, 'blog_updated', 'Blog updated: wvfbgfh', '::1', '2026-04-04 19:19:00'),
(44, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-06 16:08:59'),
(45, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-06 18:43:07'),
(46, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-06 18:44:15'),
(47, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-07 11:31:58'),
(48, 1, 'blog_updated', 'Blog updated: Understanding Boiler Tubes in Industries', '::1', '2026-04-07 12:46:47'),
(49, 1, 'blog_updated', 'Blog updated: Understanding Boiler Tubes in Industries', '::1', '2026-04-07 13:03:00'),
(50, 1, 'blog_updated', 'Blog updated: Boiler Mountings Explained', '::1', '2026-04-07 13:43:54'),
(51, 1, 'blog_deleted', 'Blog deleted: Understanding Boiler Tubes in Industries', '::1', '2026-04-07 19:00:22'),
(52, 1, 'blog_deleted', 'Blog deleted: Top Industrial Valves Used in Commercial Projects', '::1', '2026-04-07 19:00:32'),
(53, 1, 'blog_created', 'Blog created: wlekjhgdddddddddddddddddg', '::1', '2026-04-07 19:04:53'),
(54, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-08 11:32:23'),
(55, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-09 19:01:18'),
(56, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-10 13:57:49'),
(57, 1, 'login', 'Login with 2FA captcha', '::1', '2026-04-10 18:36:06'),
(58, 1, 'blog_deleted', 'Blog deleted: wvfbgfh', '::1', '2026-04-10 18:56:45'),
(59, 1, 'blog_deleted', 'Blog deleted: Brass Pipe Fittings: Uses & Benefits', '::1', '2026-04-10 18:56:46'),
(60, 1, 'blog_deleted', 'Blog deleted: Commercial Piping Systems Overview', '::1', '2026-04-10 18:56:48'),
(61, 1, 'blog_deleted', 'Blog deleted: Boiler Mountings Explained', '::1', '2026-04-10 18:56:50'),
(62, 1, 'blog_deleted', 'Blog deleted: Ball Valve vs Butterfly Valve', '::1', '2026-04-10 18:56:52'),
(63, 1, 'blog_deleted', 'Blog deleted: wlekjhgdddddddddddddddddg', '::1', '2026-04-10 18:56:53'),
(64, 1, 'blog_deleted', 'Blog deleted: Top 5 Safety Gloves for Construction Workers in 2025', '::1', '2026-04-11 16:23:06'),
(65, 1, 'blog_deleted', 'Blog deleted: Best Industrial Gloves for Chemical and Oil Handling', '::1', '2026-04-11 16:23:08'),
(66, 1, 'blog_deleted', 'Blog deleted: Best Electrical Insulation Gloves for Electricians in 2025', '::1', '2026-04-11 16:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','editor','viewer') NOT NULL DEFAULT 'admin',
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `two_fa_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `role`, `avatar`, `phone`, `status`, `two_fa_enabled`, `last_login`, `last_login_ip`, `login_count`, `notes`, `updated_at`, `reset_token`, `reset_expires`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$7LOSNnhH61YkPmfaA9J2gOD8Hr8qQ9hMtyvnkLgXZbCxAVij00dry', 'superadmin', NULL, '', 1, 1, '2026-04-10 18:36:06', '::1', 37, '', '2026-03-30 13:52:29', NULL, NULL, '2026-03-26 09:21:34'),
(2, 'Yash Chikahle', 'yashchikhale711@gmail.com', '$2y$10$LSy9tMTjoLHSOIpy5iq7CeV1Zk8EpDCJ9SR0hzo4Q4rf9wNed7xhu', 'admin', NULL, '9860303965', 1, 1, '2026-03-31 11:32:10', '::1', 1, 'Managing Doctors', '2026-03-31 11:31:01', NULL, NULL, '2026-03-31 06:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(280) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT 'assets/img/blog/blog-01.jpg',
  `image_alt` varchar(255) DEFAULT NULL,
  `categories` int(10) UNSIGNED DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL COMMENT 'comma-separated tags',
  `views` int(10) UNSIGNED DEFAULT 0,
  `comments` int(10) UNSIGNED DEFAULT 0,
  `is_published` tinyint(1) DEFAULT 1,
  `published_at` date NOT NULL,
  `reading_time` tinyint(3) UNSIGNED DEFAULT NULL,
  `meta_title` varchar(70) DEFAULT NULL,
  `meta_description` varchar(180) DEFAULT NULL,
  `focus_keyword` varchar(100) DEFAULT NULL,
  `canonical_url` varchar(500) DEFAULT NULL,
  `og_title` varchar(200) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` varchar(500) DEFAULT NULL,
  `og_type` varchar(50) DEFAULT 'article',
  `twitter_title` varchar(200) DEFAULT NULL,
  `twitter_description` text DEFAULT NULL,
  `twitter_card` varchar(50) DEFAULT 'summary_large_image',
  `robots_meta` varchar(50) DEFAULT 'index,follow',
  `schema_type` varchar(50) DEFAULT 'BlogPosting',
  `schema_json` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `image`, `image_alt`, `categories`, `tags`, `views`, `comments`, `is_published`, `published_at`, `reading_time`, `meta_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`, `og_image`, `og_type`, `twitter_title`, `twitter_description`, `twitter_card`, `robots_meta`, `schema_type`, `schema_json`, `created_at`, `updated_at`) VALUES
(14, 'Top 5 Reasons Why a Good Mosquito Net Is Essential for Your Family', 'top-5-reasons-mosquito-net-essential-family', 'A quality mosquito net is your first line of defense against dengue, malaria, and other mosquito-borne diseases. Discover why every Indian household needs one.', '<h2>Why Mosquito Nets Are a Must-Have in Every Indian Home</h2>\r\n<p>Mosquitoes are more than just a nuisance — they are carriers of life-threatening diseases like malaria, dengue, chikungunya, and filariasis. In India, millions of cases are reported every year, and the most vulnerable are children and elderly family members who sleep during peak mosquito hours.</p>\r\n<p>A high-quality mosquito net (macchar daani) provides a simple, chemical-free, and cost-effective solution that protects your entire family while you sleep peacefully through the night.</p>\r\n\r\n<h2>1. Protection Against Malaria and Dengue</h2>\r\n<p>Malaria is caused by the Anopheles mosquito, which bites mostly at night. Dengue is spread by the Aedes mosquito, which can bite during the day as well. Using an insecticide-treated net (ITN) or a long-lasting insecticidal net (LLIN) can reduce mosquito bites by over 70%, significantly cutting your risk of infection.</p>\r\n<p>According to health studies, consistent use of bed nets reduces child malaria mortality by up to 20% in high-risk zones. This alone makes the mosquito net one of the most impactful public health tools available today.</p>\r\n\r\n<h2>2. Chemical-Free and Safe for Babies</h2>\r\n<p>Unlike mosquito coils, liquid vaporizers, and sprays that release chemicals into the air you breathe, a mosquito net creates a pure physical barrier. This makes it the safest option for newborns, infants, and toddlers who are sensitive to chemical irritants.</p>\r\n<p>Parents who use nets over baby cribs and beds report fewer respiratory issues in their children compared to those who rely solely on chemical repellents. The net acts as a breathable shield — keeping mosquitoes out without affecting the quality of air inside.</p>\r\n\r\n<h2>3. Cost-Effective Long-Term Solution</h2>\r\n<p>A good mosquito net, when maintained properly, can last 3 to 5 years. Compare this to the monthly expense of mosquito coils, repellent refills, or aerosol sprays — the net pays for itself within a few months. For large families or those in rural and semi-urban areas where mosquito density is high, this is a significant saving.</p>\r\n<p>Premium nets made from polyester or nylon with fine mesh (150–200 holes per square inch) offer better protection while remaining durable through regular washing and use.</p>\r\n\r\n<h2>4. Better Sleep Quality</h2>\r\n<p>The constant buzzing of mosquitoes is one of the most common reasons for disturbed sleep in tropical countries. Even a single mosquito inside your bedroom can disrupt hours of sleep. A well-fitted mosquito net eliminates this problem entirely, giving you and your family uninterrupted, restful sleep.</p>\r\n<p>Good sleep directly impacts immunity, mental health, and productivity. By investing in a mosquito net, you are not just protecting against disease — you are investing in the overall well-being of your household.</p>\r\n\r\n<h2>5. Eco-Friendly and Sustainable</h2>\r\n<p>Mosquito nets produce zero pollution, require no electricity, and release no harmful byproducts into the environment. In a world increasingly conscious of sustainability, the mosquito net stands out as the most eco-friendly pest protection solution available.</p>\r\n<p>Choosing a reusable, washable mosquito net over chemical repellents means fewer plastic waste items, fewer chemical pollutants, and a smaller carbon footprint for your household.</p>\r\n\r\n<h2>Choosing the Right Mosquito Net</h2>\r\n<p>When selecting a mosquito net, consider the following factors: mesh density (higher is better for fine insects), material quality (polyester lasts longer than cotton), size (ensure full coverage of your bed), and whether you need a treated or untreated net based on your region.</p>\r\n<p>Our range of mosquito nets is designed for Indian homes — offering the perfect balance of ventilation, durability, and protection. Whether you need a single-bed net, double-bed net, or a baby crib net, we have options to suit every family.</p>\r\n\r\n<h2>Conclusion</h2>\r\n<p>A mosquito net is not a luxury — it is a necessity for every Indian family. From protecting against deadly diseases to ensuring peaceful sleep without chemicals, the benefits are clear and proven. Make the smart choice today and give your family the protection they deserve.</p>', 'assets/img/blog/mosquito1.jpg', 'Mosquito net protecting a family from mosquito-borne diseases', 7, 'mosquito net, macchar daani, family protection, malaria prevention, dengue prevention', 1, 0, 1, '2026-04-11', 6, 'Top 5 Reasons Why a Mosquito Net Is Essential for Your Family', 'Discover why a quality mosquito net is your best defense against malaria, dengue, and sleepless nights. Safe, eco-friendly, and cost-effective protection for every family.', 'mosquito net for family protection', '', 'Top 5 Reasons Why a Mosquito Net Is Essential for Your Family', 'Discover why a quality mosquito net is your best defense against malaria, dengue, and sleepless nights.', '', 'article', 'Top 5 Reasons Why a Mosquito Net Is Essential for Your Family', 'Discover why a quality mosquito net is your best defense against malaria, dengue, and sleepless nights.', 'summary_large_image', 'index,follow', 'BlogPosting', '{\"@context\":\"https://schema.org\",\"@type\":\"BlogPosting\",\"headline\":\"Top 5 Reasons Why a Good Mosquito Net Is Essential for Your Family\",\"description\":\"A quality mosquito net is your first line of defense against dengue, malaria, and other mosquito-borne diseases.\",\"author\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"publisher\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"datePublished\":\"2026-04-11\",\"keywords\":\"mosquito net, macchar daani, family protection, malaria prevention\"}', '2026-04-11 10:47:29', '2026-04-11 10:48:36'),
(15, 'Different Types of Mosquito Nets: Which One Is Right for You?', 'different-types-of-mosquito-nets-which-one-right-for-you', 'From conical to box-style, treated to untreated — understand the different types of mosquito nets available in India and find the perfect fit for your home and lifestyle.', '<h2>A Complete Guide to Mosquito Net Types Available in India</h2>\r\n<p>Choosing the right mosquito net can feel overwhelming with so many options on the market. The right choice depends on your sleeping arrangement, the severity of mosquito presence in your area, your budget, and personal preference. This guide breaks down every major type of mosquito net to help you make an informed decision.</p>\r\n\r\n<h2>1. Conical Mosquito Nets</h2>\r\n<p>The conical mosquito net is the most iconic and widely recognized style. It hangs from a single point on the ceiling and drapes down in a cone shape over the bed. This design is elegant, easy to install, and works well for both single and double beds.</p>\r\n<p>Conical nets are ideal for bedrooms with standard ceiling heights. They are commonly used in Indian households and are available in white, cream, and off-white colors. They offer excellent full-body coverage and are easy to tuck under the mattress for a secure seal.</p>\r\n\r\n<h2>2. Box-Style (Rectangular) Mosquito Nets</h2>\r\n<p>Box-style nets are rectangular and hang from four corners, creating a tent-like enclosure over the bed. They offer more interior space than conical nets, making them more comfortable for people who move around during sleep.</p>\r\n<p>These nets are particularly popular for children who need more room to sleep freely, and for couples who share a larger double or queen-size bed. The flat top design also makes it easier to hang without a central hook.</p>\r\n\r\n<h2>3. Freestanding Mosquito Net Tents</h2>\r\n<p>Freestanding nets come with their own frame and do not require ceiling hooks or hanging infrastructure. They pop up like a tent and can be placed directly over any mattress or sleeping area. These are extremely portable and ideal for travel, camping, or temporary accommodation.</p>\r\n<p>If you frequently travel or live in rented accommodation where you cannot drill hooks into the ceiling, a freestanding net is the most practical solution. Modern freestanding nets fold flat and pack into a compact carry bag.</p>\r\n\r\n<h2>4. Insecticide-Treated Nets (ITNs)</h2>\r\n<p>Insecticide-treated nets are regular mosquito nets that have been soaked in a WHO-approved insecticide, typically permethrin. The insecticide does not just repel mosquitoes — it kills them on contact, providing an additional layer of protection beyond the physical mesh barrier.</p>\r\n<p>ITNs are especially recommended for areas with high malaria risk, such as forested regions, coastal areas, and parts of northeastern India. They are safe for human contact when used as directed, though they may need retreatment every 6–12 months depending on the product.</p>\r\n\r\n<h2>5. Long-Lasting Insecticidal Nets (LLINs)</h2>\r\n<p>LLINs are an advanced version of ITNs where the insecticide is embedded into the net fibers themselves, rather than applied as a coating. This means the insecticidal properties last for the full useful life of the net — typically 3 to 5 years — without any need for retreatment.</p>\r\n<p>LLINs are the gold standard recommended by the World Health Organization for malaria prevention. They are widely distributed through government health programs and are also available for purchase. If you live in a high-risk zone, investing in an LLIN is a wise long-term decision.</p>\r\n\r\n<h2>6. Baby Crib and Cradle Nets</h2>\r\n<p>Specially designed for infants and toddlers, baby crib nets are smaller in size and made with ultra-fine mesh to block even the tiniest insects. Many come with elastic edges that fit snugly over standard-size cribs and baby cots, ensuring no gaps for mosquitoes to enter.</p>\r\n<p>Baby crib nets are untreated, making them completely safe for newborns. They are washable and easy to remove and replace during feeding or playtime. If you have an infant at home, a dedicated baby crib net is non-negotiable.</p>\r\n\r\n<h2>7. Outdoor and Hammock Nets</h2>\r\n<p>For those who enjoy outdoor activities, camping, or sleeping on verandas and rooftops during summer nights, outdoor mosquito nets designed for hammocks and open-air setups are available. These are made from more durable, UV-resistant materials and often include ground-level coverage to protect against mosquitoes that fly low.</p>\r\n\r\n<h2>How to Choose the Right Net for You</h2>\r\n<p>Consider your bed size and sleeping setup first. If you have a permanent bedroom, a conical or box-style net is the best investment. For travel or flexibility, go with a freestanding or portable net. If you live in a malaria-prone area, always opt for an ITN or LLIN. For babies, always choose an untreated fine-mesh crib net.</p>\r\n<p>Our store offers all of these types with multiple size options, so you can find exactly what your family needs without compromise.</p>\r\n\r\n<h2>Conclusion</h2>\r\n<p>Understanding the different types of mosquito nets empowers you to make the right choice for your specific situation. Whether it is the classic conical net for your bedroom, a portable tent for travel, or a treated net for high-risk areas, the right mosquito net makes all the difference in your protection and comfort.</p>', 'assets/img/blog/mosquito2.jpg', 'Different types of mosquito nets displayed side by side', 8, 'types of mosquito nets, conical net, box net, treated net, LLIN, baby crib net', 4, 0, 1, '2026-04-11', 7, 'Different Types of Mosquito Nets: Which One Is Right for You?', 'From conical to box-style and treated nets to baby crib nets — explore all mosquito net types available in India and choose the best one for your home.', 'types of mosquito nets in India', '', 'Different Types of Mosquito Nets: Which One Is Right for You?', 'From conical to box-style and treated nets — explore all mosquito net types and choose the best one for your home.', '', 'article', 'Different Types of Mosquito Nets: Which One Is Right for You?', 'From conical to box-style and treated nets — explore all mosquito net types and choose the best one for your home.', 'summary_large_image', 'index,follow', 'BlogPosting', '{\"@context\":\"https://schema.org\",\"@type\":\"BlogPosting\",\"headline\":\"Different Types of Mosquito Nets: Which One Is Right for You?\",\"description\":\"Understand the different types of mosquito nets available in India and find the perfect fit for your home and lifestyle.\",\"author\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"publisher\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"datePublished\":\"2026-04-11\",\"keywords\":\"types of mosquito nets, conical net, box net, treated net, LLIN\"}', '2026-04-11 10:47:29', '2026-04-11 12:30:33'),
(16, 'How to Clean and Maintain Your Mosquito Net for Long-Lasting Protection', 'how-to-clean-maintain-mosquito-net-long-lasting-protection', 'A well-maintained mosquito net can protect your family for years. Learn the correct way to wash, store, and repair your mosquito net to maximize its lifespan and effectiveness.', '<h2>Why Proper Maintenance of Your Mosquito Net Matters</h2>\r\n<p>A mosquito net is an investment in your family\'s health. But like any household item, it requires proper care to remain effective over time. A torn, dirty, or improperly stored net loses its ability to protect you — and a damaged net can give you a false sense of security while mosquitoes freely enter through gaps and holes.</p>\r\n<p>The good news is that maintaining a mosquito net is simple and requires very little time or effort. Follow these practical tips to keep your net in top condition for years to come.</p>\r\n\r\n<h2>How Often Should You Wash Your Mosquito Net?</h2>\r\n<p>For untreated nets, washing once every two to four weeks is generally sufficient for normal household use. If you live in a dusty environment or the net is exposed to outdoor air frequently, washing it more often — every one to two weeks — is advisable.</p>\r\n<p>For insecticide-treated nets (ITNs), be more careful. Frequent washing can reduce the effectiveness of the chemical treatment. Check the manufacturer\'s guidelines, but as a general rule, wash treated nets no more than once a month using mild soap and cold water. Avoid soaking them for long periods.</p>\r\n\r\n<h2>Step-by-Step: How to Wash a Mosquito Net Correctly</h2>\r\n<p><strong>Step 1 — Check for Damage First:</strong> Before washing, carefully inspect the entire surface of the net for holes, tears, or loose seams. Small holes can be repaired before washing to prevent them from widening.</p>\r\n<p><strong>Step 2 — Hand Wash in Cold or Lukewarm Water:</strong> Always hand wash mosquito nets using a mild detergent or soap. Avoid harsh detergents, bleach, or fabric softeners as they can damage the fine mesh fibers and reduce durability.</p>\r\n<p><strong>Step 3 — Rinse Thoroughly:</strong> Rinse the net at least two to three times until no soap residue remains. Soap residue left in the mesh can attract dust and reduce ventilation over time.</p>\r\n<p><strong>Step 4 — Do Not Wring or Twist:</strong> Wringing a mosquito net can distort the mesh and damage the seams. Instead, gently press out excess water and allow it to drip dry naturally.</p>\r\n<p><strong>Step 5 — Dry in Shade:</strong> Hang the net in a shaded, well-ventilated area to dry. Avoid direct sunlight for extended periods as UV rays can weaken polyester and nylon mesh fibers over time.</p>\r\n<p><strong>Step 6 — Do Not Iron:</strong> Never iron a mosquito net. The heat will melt or distort the synthetic mesh material instantly.</p>\r\n\r\n<h2>Repairing Small Holes and Tears</h2>\r\n<p>Even a pinhole-sized hole in your mosquito net is enough for a mosquito to enter. Regularly inspect your net and repair any damage immediately. For small holes, a simple needle and thread in a matching color works perfectly. Use a fine whip stitch around the edges of the hole to seal it securely.</p>\r\n<p>For larger tears, self-adhesive repair patches made specifically for mosquito nets are available at most hardware and household stores. These patches bond quickly to the mesh without sewing and create a durable seal that holds through multiple washes.</p>\r\n\r\n<h2>Proper Storage When Not in Use</h2>\r\n<p>During winter months or when the net is not in regular use, store it properly to prevent damage. Fold the net neatly and place it in a breathable cloth bag or the original packaging. Avoid storing it in plastic bags, which can trap moisture and cause mold or mildew to develop on the fabric.</p>\r\n<p>Keep the stored net in a cool, dry place away from direct sunlight and away from sharp objects that could pierce the mesh. Never stack heavy items on top of a folded net as this can create permanent crease marks and weaken the fibers at the fold lines.</p>\r\n\r\n<h2>Retreating Insecticide-Treated Nets</h2>\r\n<p>If you use a regular ITN (as opposed to an LLIN), the insecticide coating will diminish over time with washing and use. Most ITNs require retreatment every six to twelve months. Retreatment kits containing permethrin solution are available, and the process involves soaking the net in the diluted solution and allowing it to dry completely before use.</p>\r\n<p>Always follow the product instructions carefully during retreatment, wear gloves, and keep the net away from children until it is fully dry. If retreatment feels complicated, consider upgrading to a Long-Lasting Insecticidal Net (LLIN) which does not require retreatment.</p>\r\n\r\n<h2>Signs That It Is Time to Replace Your Mosquito Net</h2>\r\n<p>Even with the best care, mosquito nets do not last forever. It is time to replace your net if you notice extensive holes or tears that cannot be repaired effectively, severe discoloration or odor that does not clear after washing, significant weakening or thinning of the mesh material, or broken hanging loops and damaged edges that compromise the seal around the bed.</p>\r\n<p>A net that no longer seals properly around the mattress provides incomplete protection and should be replaced promptly rather than patched repeatedly.</p>\r\n\r\n<h2>Quick Maintenance Checklist</h2>\r\n<p>Wash untreated nets every two to four weeks using mild soap and cold water. Wash treated nets carefully no more than once a month. Inspect for holes after every wash and repair immediately. Dry in shade and never iron. Store in a breathable bag in a cool, dry place. Retreat ITNs every six to twelve months as needed. Replace the net every three to five years or sooner if heavily damaged.</p>\r\n\r\n<h2>Conclusion</h2>\r\n<p>A little care goes a long way with mosquito nets. By following these simple maintenance steps, you can extend the life of your net significantly and ensure your family continues to receive maximum protection year after year. Treat your mosquito net with care — and it will take care of your family in return.</p>', 'assets/img/blog/mosquito3.AVIF', 'Person carefully washing and maintaining a mosquito net', 9, 'mosquito net care, how to wash mosquito net, mosquito net maintenance, mosquito net repair', 1, 0, 1, '2026-04-11', 8, 'How to Clean and Maintain Your Mosquito Net for Long-Lasting Protectio', 'Learn the correct way to wash, store, repair, and maintain your mosquito net so it protects your family effectively for years without losing its strength.', 'how to maintain mosquito net', '', 'How to Clean and Maintain Your Mosquito Net for Long-Lasting Protection', 'Learn the correct way to wash, store, repair, and maintain your mosquito net for maximum lifespan and protection.', '', 'article', 'How to Clean and Maintain Your Mosquito Net for Long-Lasting Protection', 'Learn the correct way to wash, store, repair, and maintain your mosquito net for maximum lifespan and protection.', 'summary_large_image', 'index,follow', 'BlogPosting', '{\"@context\":\"https://schema.org\",\"@type\":\"BlogPosting\",\"headline\":\"How to Clean and Maintain Your Mosquito Net for Long-Lasting Protection\",\"description\":\"Learn the correct way to wash, store, and repair your mosquito net to maximize its lifespan and effectiveness.\",\"author\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"publisher\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"datePublished\":\"2026-04-11\",\"keywords\":\"mosquito net care, how to wash mosquito net, mosquito net maintenance\"}', '2026-04-11 10:47:29', '2026-04-11 12:53:37'),
(17, 'Best Mosquito Nets for Babies and Toddlers: What Every Parent Must Know', 'best-mosquito-nets-babies-toddlers-what-parents-must-know', 'Babies are the most vulnerable to mosquito bites and the diseases they carry. Learn how to choose the safest, most effective mosquito net for your infant or toddler.', '<h2>Why Babies Need Special Mosquito Protection</h2>\r\n<p>Infants and toddlers have thinner skin, developing immune systems, and no ability to protect themselves from mosquito bites. A single bite from an infected mosquito can cause serious illness in a baby — and unlike adults, babies cannot communicate their discomfort clearly, which means infections can go undetected until they become serious.</p>\r\n<p>Standard adult mosquito nets are not designed for cribs, cradles, or baby cots. They may be too large, have mesh that is not fine enough, or use materials that are not safe for close contact with an infant. This is why choosing a dedicated baby mosquito net is so important.</p>\r\n\r\n<h2>Key Features to Look for in a Baby Mosquito Net</h2>\r\n<p>When selecting a mosquito net for your baby, the mesh density is the most important factor. Look for nets with at least 156 holes per square inch — this is fine enough to block not just mosquitoes but also smaller insects like sand flies and gnats that can bite through coarser mesh.</p>\r\n<p>The material should be soft, lightweight polyester that does not scratch or irritate delicate baby skin if it makes contact. The net should be completely untreated — never use an insecticide-treated net for infants under six months old, and exercise caution with older babies as well. Physical protection alone is sufficient and far safer for young children.</p>\r\n<p>Size and fit matter enormously. A baby net that is too loose can sag and make contact with the baby, while one that is too small may leave gaps. Measure your crib or cradle before purchasing and choose a net with a fitted elastic edge or adjustable attachment that ensures a snug, gap-free seal.</p>\r\n\r\n<h2>Types of Baby Mosquito Nets</h2>\r\n<p>Crib dome nets are the most popular style for newborns and young infants. They sit over the crib like a dome, held up by a lightweight frame or flexible hoops, and have an elastic base that grips the crib edges. They are easy to open and close for feeding and diaper changes, and they fold flat for storage or travel.</p>\r\n<p>Pram and stroller nets are designed to cover baby prams and strollers when you take your baby outdoors. They attach with elastic or drawstrings and provide protection during walks in parks, markets, or any area with mosquito presence. These are an absolute must if you take your baby out during early morning or evening hours when mosquitoes are most active.</p>\r\n<p>Portable pop-up baby nets are freestanding and can be placed over any flat sleeping surface — whether a mattress on the floor, a travel cot, or a bed at a relative home. They are ideal for families who travel frequently and need reliable protection away from home.</p>\r\n<p>Cradle nets are specifically designed for traditional Indian jhula-style cradles. They wrap around the cradle frame and tuck securely underneath, providing complete coverage while allowing airflow to keep the baby comfortable in warm weather.</p>\r\n\r\n<h2>Safety Rules Every Parent Must Follow</h2>\r\n<p>Never leave a baby unsupervised inside a mosquito net that has a frame or hoops that could collapse. Always ensure the net is taut and properly secured so it cannot fall onto the baby. Check for holes or tears regularly — a hole large enough for a finger is large enough for a mosquito.</p>\r\n<p>Keep the net away from any fan or air conditioning vent that could cause it to billow inward toward the baby. When the baby starts rolling or moving around independently, upgrade to a net with a more secure base to prevent them from pushing the net aside.</p>\r\n<p>Wash baby nets more frequently than adult nets — every one to two weeks — using a gentle, fragrance-free baby-safe detergent. Rinse thoroughly and air dry in shade. Never use the net if it is still damp as moisture can encourage mold growth in the mesh.</p>\r\n\r\n<h2>When to Use the Baby Net</h2>\r\n<p>Use the net whenever your baby is sleeping, regardless of the time of day. Aedes mosquitoes, which carry dengue, are active during daytime hours — so daytime naps require just as much protection as nighttime sleep. If your baby naps in a pram or on a play mat on the floor, cover them with a net every single time.</p>\r\n<p>When outdoors, always use a pram net — even in areas that do not seem heavily infested. Mosquitoes can be present even in clean, dry environments, and a single bite is all it takes to cause a problem.</p>\r\n\r\n<h2>Top Tips for Choosing the Right Baby Net</h2>\r\n<p>Always buy from a reputable brand with clearly stated mesh density specifications. Avoid nets with strong chemical smells as these may indicate undisclosed treatment. Check that the net material is certified non-toxic and free from harmful dyes. Choose a design that makes nighttime feeding easy — quick-release or zipper access panels are extremely helpful for parents during night feeds without fully dismantling the net each time.</p>\r\n\r\n<h2>Conclusion</h2>\r\n<p>Your baby deserves the safest sleep environment possible. A well-chosen, properly fitted mosquito net is the single most effective and safest way to protect your infant from mosquito bites throughout the night and during daytime naps. Invest in quality, check it regularly, and use it consistently — the health and peaceful sleep of your baby depend on it.</p>', 'assets/img/blog/mosquito4.webp', 'Baby sleeping safely inside a mosquito net over a crib', 9, 'baby mosquito net, mosquito net for infant, crib mosquito net, toddler mosquito protection, baby net India', 3, 0, 1, '2026-04-11', 8, 'Best Mosquito Nets for Babies and Toddlers: What Every Parent Must Kno', 'Protect your infant from dangerous mosquito bites with the right baby mosquito net. Learn what to look for, which types are safest, and how to use them correctly.', 'mosquito net for babies', '', 'Best Mosquito Nets for Babies and Toddlers: What Every Parent Must Know', 'Learn how to choose the safest and most effective mosquito net for your infant or toddler and keep them protected all night.', '', 'article', 'Best Mosquito Nets for Babies and Toddlers: What Every Parent Must Know', 'Learn how to choose the safest and most effective mosquito net for your infant or toddler and keep them protected all night.', 'summary_large_image', 'index,follow', 'BlogPosting', '{\"@context\":\"https://schema.org\",\"@type\":\"BlogPosting\",\"headline\":\"Best Mosquito Nets for Babies and Toddlers: What Every Parent Must Know\",\"description\":\"Learn how to choose the safest and most effective mosquito net for your infant or toddler.\",\"author\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"publisher\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"datePublished\":\"2026-04-11\",\"keywords\":\"baby mosquito net, mosquito net for infant, crib mosquito net, toddler mosquito protection\"}', '2026-04-11 10:53:44', '2026-04-11 11:00:08'),
(19, 'Mosquito Nets for Outdoor Use: Camping, Trekking and Open-Air Sleeping', 'mosquito-nets-outdoor-camping-trekking-open-air-sleeping', 'Planning a camping trip or sleeping outdoors? Discover the best mosquito net options for outdoor use and how to stay fully protected from mosquitoes in open environments.', '<h2>Mosquito Protection Does Not Stop at Your Bedroom Door</h2>\r\n<p>Most people think of mosquito nets only in the context of indoor sleeping. But mosquito exposure is often far greater outdoors — especially during camping trips, trekking expeditions, farm stays, and open-air sleeping on terraces or verandas during hot Indian summers. Without the right protection, outdoor sleeping can expose you to significantly more mosquito bites than staying indoors.</p>\r\n<p>The good news is that there are mosquito nets specifically engineered for outdoor use. These are built tougher, designed for quick setup without fixed infrastructure, and offer reliable protection even in high-mosquito environments like forests, riversides, and agricultural areas.</p>\r\n<h2>What Makes an Outdoor Mosquito Net Different</h2>\r\n<p>Outdoor mosquito nets differ from standard bedroom nets in several important ways. The material is typically heavier-duty polyester or nylon that resists snagging on branches, rocks, and rough surfaces. The mesh is treated with UV-stabilizing compounds so prolonged sun exposure does not degrade the fibers as quickly as it would with indoor nets.</p>\r\n<p>Most outdoor nets are designed to be self-supporting or to attach to existing structures like tent poles, tree branches, or trekking poles — eliminating the need for ceiling hooks. They pack down into compact stuff sacks and weigh very little, making them easy to carry in a backpack without adding significant load.</p>\r\n<p>Many outdoor nets also include ground sheets or tuck-under flaps that seal against the ground or sleeping mat, preventing crawling insects from entering from below — a risk that does not exist with elevated bedroom beds but is very real when sleeping on the ground or on a low camp mat.</p>\r\n<h2>Types of Outdoor Mosquito Nets</h2>\r\n<p>Hammock mosquito nets are among the most popular for outdoor enthusiasts. They wrap completely around a hammock and zip shut, creating a fully sealed sleeping pod between two trees. Ventilation is excellent because the net surrounds you with airflow on all sides, and the elevation keeps you away from ground-level insects entirely.</p>\r\n<p>Freestanding pop-up nets are the fastest to set up and pack down. They work exactly like a pop-up tent — unfold, allow the frame to spring into shape, and place over your sleeping mat or sleeping bag. They are ideal for casual campers and travelers who need quick protection without any assembly skill.</p>\r\n<p>Trekking pole nets use your existing trekking poles as the support structure, suspending a net over your sleeping area without requiring trees or tent frames. This makes them extremely versatile for open terrain like highland meadows or rocky campsites where trees are not available.</p>\r\n<p>Bivy nets are ultralight single-person nets designed for minimalist trekkers and mountaineers. They are essentially a net sleeve that you slide into alongside your sleeping bag, providing a snug protective shell with almost no packed weight or volume. These are the choice of serious long-distance trekkers where every gram counts.</p>\r\n<h2>Key Features to Check Before Buying</h2>\r\n<p>Mesh density matters outdoors just as much as indoors. In forested and jungle environments, smaller biting insects like sand flies and midges are common alongside mosquitoes. A mesh density of at least 156 holes per square inch is recommended for jungle and forest camping.</p>\r\n<p>Check the packed size and weight carefully. A net that is too bulky defeats the purpose of carrying it on a trek. Good outdoor nets weigh between 150 and 400 grams and pack to roughly the size of a water bottle.</p>\r\n<p>Look for reinforced hanging points and zipper entries. The hanging loops and attachment points take significant stress when the net is suspended between trees or poles in windy conditions. Reinforced stitching at these stress points prevents tearing over repeated use.</p>\r\n<h2>Using Mosquito Nets on Indian Rooftops and Verandas</h2>\r\n<p>In many parts of India, especially in smaller towns and villages, sleeping on the rooftop or veranda during summer is a common practice. This is one of the highest mosquito exposure situations possible — you are completely in the open during peak mosquito hours with no walls or screens to reduce exposure.</p>\r\n<p>For rooftop sleeping, a freestanding pop-up net or a portable frame net that can be assembled over a charpoy or mattress laid on the ground is the most practical solution. These require no drilling or permanent fixtures and can be set up and packed away each evening in under five minutes.</p>\r\n<p>Ensure the net fully covers the sleeping surface and is weighted or tucked at the edges to prevent wind from lifting it. In windy conditions, place heavy objects like shoes or water bottles along the base perimeter to keep the net sealed against the ground or mattress edges.</p>\r\n<h2>Care and Maintenance for Outdoor Nets</h2>\r\n<p>After each outdoor trip, inspect the net carefully for holes, tears, or insect damage before storing. Wash it with mild soap and cold water to remove dirt, sweat, and any residues from the environment. Dry it fully in the shade before folding and storing to prevent mold in the mesh.</p>\r\n<p>Store outdoor nets separately from sharp camping equipment that could pierce the mesh during transport. A dedicated small stuff sack or pouch keeps the net protected and easy to locate quickly when setting up camp after a long day of trekking.</p>\r\n<h2>Conclusion</h2>\r\n<p>Whether you are a serious trekker, a casual camper, or simply someone who enjoys summer rooftop sleeping, the right outdoor mosquito net transforms your experience completely. Protection from mosquitoes outdoors is not optional in India — it is a necessity. Invest in a good outdoor net and explore the outdoors freely without the constant threat of bites disrupting your rest and your health.</p>', 'assets/img/blog/mosquito5.webp', 'Outdoor mosquito net set up over a camping hammock in a forest', 8, 'outdoor mosquito net, camping mosquito net, trekking mosquito net, hammock net, rooftop mosquito protection', 2, 0, 1, '2026-04-11', 8, 'Mosquito Nets for Outdoor Use: Camping, Trekking and Open-Air Sleeping', 'Stay protected from mosquitoes during camping, trekking, and outdoor sleeping with the right net. Explore the best outdoor mosquito net options for Indian conditions.', 'outdoor mosquito net for camping trekking', '', 'Mosquito Nets for Outdoor Use: Camping, Trekking and Open-Air Sleeping', 'Stay protected from mosquitoes during camping, trekking, and outdoor sleeping with the right net.', '', 'article', 'Mosquito Nets for Outdoor Use: Camping, Trekking and Open-Air Sleeping', 'Stay protected from mosquitoes during camping, trekking, and outdoor sleeping with the right net.', 'summary_large_image', 'index,follow', 'BlogPosting', '{\"@context\":\"https://schema.org\",\"@type\":\"BlogPosting\",\"headline\":\"Mosquito Nets for Outdoor Use: Camping, Trekking and Open-Air Sleeping\",\"description\":\"Discover the best mosquito net options for outdoor use and how to stay fully protected in open environments.\",\"author\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"publisher\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"datePublished\":\"2026-04-11\",\"keywords\":\"outdoor mosquito net, camping mosquito net, trekking mosquito net\"}', '2026-04-11 11:00:49', '2026-04-11 12:13:53'),
(20, 'How Mosquito Nets Prevent Malaria, Dengue and Other Vector-Borne Diseases', 'how-mosquito-nets-prevent-malaria-dengue-vector-borne-diseases', 'Mosquito-borne diseases kill thousands in India every year. Learn exactly how mosquito nets work as a frontline defense against malaria, dengue, chikungunya, and more.', '<h2>The Invisible Threat in Your Bedroom</h2>\r\n<p>Every year, India reports hundreds of thousands of confirmed malaria cases and an even larger number of dengue fever cases. Chikungunya, Japanese encephalitis, lymphatic filariasis, and Zika virus are also transmitted by mosquitoes and pose serious public health risks across different parts of the country. What many people do not realize is that the majority of these infections happen at night — while people are sleeping and most vulnerable.</p>\r\n<p>The Anopheles mosquito, which transmits malaria, is primarily a nighttime biter. It is most active between dusk and dawn, which precisely coincides with sleeping hours. The Aedes mosquito, which spreads dengue, chikungunya, and Zika, bites during the day but can also bite in the early morning and late evening — periods when people are often resting.</p>\r\n<p>A mosquito net, used consistently and correctly, directly interrupts this transmission by creating a physical barrier between the sleeping person and the biting mosquito. This simple intervention has been demonstrated in large-scale global health studies to be one of the most cost-effective tools available for reducing mosquito-borne disease burden.</p>\r\n<h2>How Malaria Transmission Works and How Nets Stop It</h2>\r\n<p>Malaria is caused by Plasmodium parasites that live inside Anopheles mosquitoes. When an infected female Anopheles mosquito bites a sleeping person, it injects the parasite directly into the bloodstream through its saliva. The parasite then travels to the liver, multiplies, and re-enters the blood, causing the fever, chills, and organ stress that characterize malaria.</p>\r\n<p>A mosquito net physically prevents the Anopheles mosquito from reaching the sleeping person. Even if hundreds of infected mosquitoes are present in the same room, a properly installed and sealed net means zero bites and zero transmission. Studies conducted across sub-Saharan Africa and South Asia have consistently shown that regular net use reduces malaria incidence by 50 percent or more in high-transmission households.</p>\r\n<p>Insecticide-treated nets go further — the permethrin coating kills mosquitoes that land on the net surface, reducing the local mosquito population over time and providing a protective effect even for people sleeping nearby without a net.</p>\r\n<h2>How Dengue Transmission Works and Why Nets Still Matter</h2>\r\n<p>Dengue is caused by the dengue virus carried by Aedes aegypti mosquitoes. Unlike Anopheles, Aedes mosquitoes are daytime biters — they are most active in the two hours after sunrise and the two hours before sunset. This has led some people to believe that mosquito nets are less relevant for dengue prevention.</p>\r\n<p>However, this conclusion is incorrect for several reasons. First, many people — particularly children, elderly individuals, and those who are unwell — rest and sleep during the daytime, and nets provide full protection during these periods. Second, Aedes mosquitoes can and do bite in shaded or indoor environments throughout the day, not just during peak outdoor hours. A net used during daytime rest provides complete protection regardless of the time.</p>\r\n<p>Third, in areas where both malaria and dengue are co-endemic, a single mosquito net addresses both threats simultaneously — making it an exceptionally efficient protective tool.</p>\r\n<h2>Chikungunya, Zika and Filariasis — Protection Through the Same Net</h2>\r\n<p>Chikungunya and Zika are also transmitted by Aedes mosquitoes, meaning the same net that protects against dengue provides equivalent protection against these diseases as well. The mechanism is identical — physical exclusion of the biting vector.</p>\r\n<p>Lymphatic filariasis, commonly known as elephantiasis in its advanced form, is transmitted by Culex mosquitoes that bite predominantly at night. A mosquito net used during nighttime sleep is directly protective against this disease, which causes chronic swelling and disability in affected individuals.</p>\r\n<p>Japanese encephalitis, transmitted by Culex mosquitoes in rural and agricultural areas of India, is another nighttime-transmission disease where bed net use provides direct protection. Farmers and rural workers sleeping near rice fields and water bodies are at particular risk and benefit enormously from consistent net use.</p>\r\n<h2>The Science Behind Insecticide-Treated Nets</h2>\r\n<p>Long-lasting insecticidal nets (LLINs) work through two mechanisms simultaneously. First, they form the same physical barrier as untreated nets. Second, the insecticide — typically deltamethrin or permethrin embedded into the net fibers — kills or repels mosquitoes that land on the net surface attempting to bite through it.</p>\r\n<p>This dual action means that even if there is a tiny undetected hole in the net, mosquitoes attempting to enter through that hole are exposed to the insecticide and killed before they can successfully bite the sleeping person. LLINs are therefore considered superior to untreated nets in high-transmission zones.</p>\r\n<p>The World Health Organization recommends LLINs as a primary vector control intervention in malaria-endemic regions. In India, national malaria elimination programs distribute LLINs in high-burden districts as part of their core strategy.</p>\r\n<h2>Who Benefits Most From Using a Mosquito Net</h2>\r\n<p>While everyone benefits from mosquito net use, certain groups face substantially higher risk and should prioritize net use without exception. Pregnant women are at severe risk from malaria — infection during pregnancy can cause miscarriage, premature birth, low birth weight, and maternal death. Children under five years old have developing immune systems and can deteriorate rapidly from mosquito-borne infections. Elderly individuals and those with chronic illnesses have reduced immune capacity and face worse outcomes from infections.</p>\r\n<p>Travelers visiting malaria or dengue endemic regions from urban areas where they have no prior exposure or immunity are also at high risk. For all these groups, a mosquito net is not a comfort item — it is a critical health intervention.</p>\r\n<h2>Making Net Use a Consistent Family Habit</h2>\r\n<p>The protective benefit of a mosquito net is directly proportional to how consistently it is used. A net that is used only occasionally provides only occasional protection. Families that use their nets every single night — including during cooler months when mosquito activity feels lower — maintain continuous protection against diseases that can strike at any time.</p>\r\n<p>Make net use a non-negotiable bedtime routine, the same way brushing teeth or locking the door is routine. Check the net for holes at least once a month. Replace it promptly when it is too damaged to repair. The cumulative effect of consistent net use over months and years is a dramatic reduction in the household burden of mosquito-borne disease.</p>\r\n<h2>Conclusion</h2>\r\n<p>A mosquito net is not just a piece of fabric — it is a proven, science-backed shield against some of the most dangerous infectious diseases in India. From malaria to dengue, chikungunya to filariasis, consistent net use interrupts the chain of transmission and protects your family night after night. In a country where mosquito-borne diseases remain a leading cause of illness and death, using a mosquito net is one of the most impactful health decisions you can make for your household.</p>', 'assets/img/blog/mosquito6.jpg', 'Mosquito net protecting a person from malaria and dengue carrying mosquitoes', 9, 'mosquito net malaria prevention, dengue mosquito net, vector borne disease protection, LLIN India, mosquito net health benefits', 6, 0, 1, '2026-04-11', 10, 'How Mosquito Nets Prevent Malaria, Dengue and Vector-Borne Diseases', 'Learn how mosquito nets work as a frontline defense against malaria, dengue, chikungunya and other deadly mosquito-borne diseases affecting thousands in India every year.', 'mosquito net malaria dengue prevention', '', 'How Mosquito Nets Prevent Malaria, Dengue and Vector-Borne Diseases', 'Learn how mosquito nets work as a frontline defense against malaria, dengue and other deadly mosquito-borne diseases.', '', 'article', 'How Mosquito Nets Prevent Malaria, Dengue and Vector-Borne Diseases', 'Learn how mosquito nets work as a frontline defense against malaria, dengue and other deadly mosquito-borne diseases.', 'summary_large_image', 'index,follow', 'BlogPosting', '{\"@context\":\"https://schema.org\",\"@type\":\"BlogPosting\",\"headline\":\"How Mosquito Nets Prevent Malaria, Dengue and Other Vector-Borne Diseases\",\"description\":\"Learn exactly how mosquito nets work as a frontline defense against malaria, dengue, chikungunya, and more.\",\"author\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"publisher\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"datePublished\":\"2026-04-11\",\"keywords\":\"mosquito net malaria prevention, dengue mosquito net, vector borne disease protection, LLIN India\"}', '2026-04-11 11:00:49', '2026-04-11 12:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `sort_order` tinyint(3) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `sort_order`) VALUES
(5, 'Safety', 'safety', 5),
(6, 'Product Guide', 'product-guide', 6),
(7, 'Mosquito Protection Tips', 'mosquito-protection-tips', 1),
(8, 'Mosquito Net Types', 'mosquito-net-types', 2),
(9, 'Health & Safety', 'health-safety', 3);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `description`, `created_at`) VALUES
(1, 'Orthopedics', 'orthopedics', 'flaticon-bone', 'Expert care for bones, joints, and musculoskeletal conditions.', '2026-03-26 09:21:34'),
(2, 'Gynecology', 'gynecology', 'flaticon-baby', 'Comprehensive women\'s reproductive health and obstetric services.', '2026-03-26 09:21:34'),
(3, 'Pregnancy Care', 'pregnancy-care', 'flaticon-pregnant', 'Antenatal and postnatal care for mother and baby.', '2026-03-26 09:21:34'),
(4, 'Surgery', 'surgery', 'flaticon-surgery', 'Advanced open and laparoscopic surgical procedures.', '2026-03-26 09:21:34'),
(5, 'Spine Care', 'spine-care', 'flaticon-spine', 'Diagnosis and treatment of spine and disc disorders.', '2026-03-26 09:21:34'),
(6, 'Women\'s Health', 'womens-health', NULL, 'Hormonal health, PCOS/PCOD, and fertility care.', '2026-03-26 09:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `designation` varchar(200) DEFAULT NULL,
  `specialty` varchar(150) DEFAULT NULL,
  `satisfaction_rate` int(11) DEFAULT 0,
  `feedback_count` int(11) DEFAULT 0,
  `location` varchar(255) DEFAULT NULL,
  `consultation_fee` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `education_json` longtext DEFAULT NULL,
  `experience_json` longtext DEFAULT NULL,
  `awards_json` longtext DEFAULT NULL,
  `specializations` varchar(500) DEFAULT NULL,
  `map_iframe` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'assets/img/patients/default.jpg',
  `profile_url` varchar(255) DEFAULT 'doctor-profile.html',
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `is_published` tinyint(1) DEFAULT 1,
  `published_at` datetime DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `focus_keyword` varchar(255) DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `og_type` varchar(50) DEFAULT 'profile',
  `twitter_title` varchar(255) DEFAULT NULL,
  `twitter_description` text DEFAULT NULL,
  `twitter_card` varchar(50) DEFAULT 'summary_large_image',
  `robots_meta` varchar(50) DEFAULT 'index, follow',
  `schema_type` varchar(100) DEFAULT 'Physician',
  `schema_json` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `feature_image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `slug`, `designation`, `specialty`, `satisfaction_rate`, `feedback_count`, `location`, `consultation_fee`, `bio`, `education_json`, `experience_json`, `awards_json`, `specializations`, `map_iframe`, `photo`, `profile_url`, `excerpt`, `content`, `tags`, `views`, `is_published`, `published_at`, `meta_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`, `og_image`, `og_type`, `twitter_title`, `twitter_description`, `twitter_card`, `robots_meta`, `schema_type`, `schema_json`, `created_at`, `updated_at`, `feature_image`) VALUES
(8, 'Dr. Rahul Agrawal', 'dr-rahul-agrawal', 'MBBS, MS (Orthopedics)', 'Orthopedic Surgeon', 98, 0, 'Itwari, Nagpur, Maharashtra 440002', '', 'Dr. Rahul Agrawal is a highly experienced and dedicated Orthopedic Surgeon \r\nat RK Hospital, Nagpur, specializing in the diagnosis and treatment of bone, \r\njoint, and musculoskeletal conditions. Known for his precision, clinical \r\nexpertise, and compassionate approach, Dr. Agrawal has earned the trust of \r\nthousands of patients across Nagpur and the surrounding regions. His \r\nphilosophy is simple — restore mobility, relieve pain, and help every patient \r\nreturn to an active, fulfilling life.\r\n\r\nFracture Treatment\r\nDr. Agrawal provides expert, evidence-based management for all types of bone \r\nfractures — from hairline stress fractures to complex compound and \r\nmulti-fragmented injuries. Using advanced diagnostic imaging and proven \r\northopedic protocols, he designs individualized treatment plans that accelerate \r\nhealing, minimize complications, and reduce recovery time. Both conservative \r\nand surgical fracture management are handled with equal precision and care.\r\n\r\nJoint Pain Diagnosis\r\nChronic or sudden joint pain can severely limit daily life. Dr. Agrawal \r\nspecializes in accurately diagnosing the underlying causes of joint discomfort \r\nacross the knee, hip, shoulder, elbow, wrist, and ankle. Through thorough \r\nclinical evaluation and advanced investigations, he identifies conditions \r\nincluding arthritis, bursitis, ligament injuries, cartilage damage, and \r\ndegenerative joint disease — then builds targeted, effective treatment plans \r\nfor meaningful, lasting relief.\r\n\r\nBone Injury Care & Post-Injury Rehabilitation\r\nFrom sports accidents and workplace injuries to age-related bone degeneration, \r\nDr. Agrawal\'s bone injury care covers the full spectrum of orthopedic trauma. \r\nHe adopts a conservative-first approach — prioritizing physiotherapy, splinting, \r\nand medical management before recommending surgical intervention. Beyond \r\ntreatment, Dr. Agrawal places strong emphasis on Post-Injury Rehabilitation, \r\nworking closely with physiotherapy teams to design personalized recovery \r\nprograms that restore full strength, flexibility, and function safely and \r\nefficiently.\r\n\r\nOutpatient Orthopedic Care\r\nDr. Agrawal leads RK Hospital\'s outpatient orthopedic department, ensuring \r\nthat residents of Nagpur have access to world-class orthopedic consultations \r\nwithout unnecessary hospitalization. His efficient outpatient model is \r\ndesigned to be affordable, accessible, and patient-friendly — making expert \r\nbone and joint care available to everyone who needs it.\r\n\r\nIf you are experiencing bone pain, joint discomfort, or recovering from an \r\ninjury, Dr. Rahul Agrawal at RK Hospital, Itwari, Nagpur, is here to help. \r\nBook your consultation today and take the first step toward a stronger, \r\npain-free life.', '[]', '[]', '[]', 'Fracture Treatment, Joint Pain Diagnosis, Bone Injury Care, Post-Injury Rehabilitation, Outpatient Orthopedic Care, Sports Injury Management, Musculoskeletal Disorders, Trauma Care', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.0756953546743!2d79.11365600244474!3d21.149385686609815!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd4c786c015d623%3A0x5162afcdb26d73f5!2sDr.%20Rahul%20Agrawal!5e0!3m2!1sen!2sin!4v1775025515467!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'assets/img/doctors/dr-rahul-agrawal-69ce13ff9f639.webp', 'doctor-profile.html', 'Dr. Rahul Agrawal is a trusted Orthopedic Surgeon at RK Hospital, Aurangabad, specializing in fracture treatment, joint pain diagnosis, and bone injury care.', NULL, 'orthopedic surgeon nagpur, fracture treatment nagpur, joint pain specialist nagpur, bone injury care, post injury rehabilitation, sports injury doctor nagpur, knee pain treatment nagpur, outpatient orthopedic care, best orthopedic doctor itwari nagpur', 0, 1, '2026-04-02 00:00:00', 'Dr. Rahul Agrawal – Orthopedic Surgeon in Nagpur', 'Consult Dr. Rahul Agrawal, expert Orthopedic Surgeon at RK Hospital, Itwari, Nagpur. Specialist in fracture treatment, joint pain & bone injury care. Book now.', 'orthopedic surgeon in Nagpur', 'https://rkhospital.com/doctors/dr-rahul-agrawal', 'Dr. Rahul Agrawal', 'Dr. Rahul Agrawal is a trusted Orthopedic Surgeon at RK Hospital, Aurangabad, specializing in fracture treatment, joint pain diagnosis, and bone injury care.', 'assets/img/doctors/dr-rahul-agrawal-69ce13ff9f639.webp', 'profile', 'Dr. Rahul Agrawal', 'Dr. Rahul Agrawal is a trusted Orthopedic Surgeon at RK Hospital, Aurangabad, specializing in fracture treatment, joint pain diagnosis, and bone injury care.', 'summary_large_image', 'index,follow', 'Physician', '{\"@context\":\"https://schema.org\",\"@type\":\"Physician\",\"name\":\"Dr. Rahul Agrawal\",\"description\":\"Consult Dr. Rahul Agrawal, expert Orthopedic Surgeon at RK Hospital, Itwari, Nagpur. Specialist in fracture treatment, joint pain & bone injury care. Book now.\",\"image\":\"assets/img/doctors/dr-rahul-agrawal-69ce13ff9f639.webp\",\"url\":\"https://rkhospital.com/doctors/dr-rahul-agrawal\",\"medicalSpecialty\":\"Orthopedic Surgeon\"}', '2026-04-01 07:27:00', '2026-04-02 07:00:15', '/assets/img/doctors/rahulbanner.webp'),
(9, 'Dr. Priyanka Agrawal', 'dr-priyanka-agrawal', 'MBBS, MD (Obstetrics & Gynecology)', 'Gynecologist & Obstetrician', 99, 0, 'Itwari, Nagpur, Maharashtra 440002', '', 'Dr. Priyanka Agrawal is a highly skilled and compassionate Gynecologist and \r\nObstetrician at RK Hospital, Nagpur, committed to delivering comprehensive, \r\nevidence-based women\'s healthcare at every stage of life. From adolescent \r\ngynecology and reproductive health to complex obstetric care and fertility \r\ntreatment, Dr. Agrawal brings together advanced clinical expertise and a \r\ndeeply empathetic, patient-first approach. She is one of Nagpur\'s most \r\ntrusted OB-GYN specialists, known for making every patient feel heard, \r\nrespected, and genuinely cared for.\r\n\r\nObstetrics & Gynecology\r\nAs a board-certified Obstetrician-Gynecologist, Dr. Agrawal manages all \r\naspects of women\'s reproductive health — including routine gynecological \r\nexaminations, cervical screenings, menstrual health management, and complete \r\npregnancy care. Her holistic practice ensures that women receive seamless, \r\ncontinuous care from a provider who truly understands their unique needs.\r\n\r\nCesarean (C-Section) Delivery\r\nDr. Agrawal is proficient in both planned and emergency Cesarean deliveries, \r\nperforming C-sections with precision and an unwavering commitment to the \r\nsafety of mother and newborn. She provides comprehensive pre-operative \r\ncounseling, skilled surgical care, and attentive postpartum monitoring to \r\nensure a smooth, complete recovery for every patient.\r\n\r\nHigh-Risk Pregnancy Management\r\nManaging a high-risk pregnancy demands specialized expertise and vigilant \r\ncare. Dr. Agrawal provides individualized management for pregnancies \r\ncomplicated by gestational diabetes, pregnancy-induced hypertension, \r\npreeclampsia, placenta previa, multiple pregnancies (twins/triplets), and \r\nprevious uterine surgeries. Through close monitoring and timely, targeted \r\ninterventions, she consistently achieves the best possible outcomes for \r\nboth mother and baby.\r\n\r\nHormonal Imbalance Treatment\r\nDr. Agrawal specializes in diagnosing and treating a wide range of hormonal \r\ndisorders in women, including Polycystic Ovary Syndrome (PCOS), irregular \r\nor absent menstrual cycles, endometriosis, thyroid-related reproductive \r\nissues, and menopausal symptoms. Her treatment plans integrate medical \r\ntherapy with practical lifestyle guidance for sustainable, long-term \r\nhormonal balance and overall wellbeing.\r\n\r\nInfertility Evaluation & Treatment\r\nFor couples facing the challenges of infertility, Dr. Agrawal offers \r\nthorough, compassionate, and results-driven fertility care. She conducts \r\ncomprehensive evaluations — including hormonal profiling, ovarian reserve \r\ntesting, tubal assessments, and coordinated semen analysis — to identify \r\nroot causes. Treatment options include targeted medical therapy, ovulation \r\ninduction, and IUI guidance, with timely referrals for advanced reproductive \r\ntechnologies (ART/IVF) when required.\r\n\r\nFamily Planning & Contraception Counseling\r\nDr. Agrawal believes every woman deserves the right to make informed, \r\nconfident decisions about her reproductive future. She provides personalized \r\ncontraception counseling covering oral contraceptive pills, intrauterine \r\ndevices (IUDs), hormonal implants, barrier methods, and emergency \r\ncontraception — ensuring every recommendation aligns with the patient\'s \r\nhealth profile, preferences, and long-term reproductive goals.\r\n\r\nWhether you are planning a pregnancy, managing a gynecological condition, \r\nor seeking trusted reproductive health guidance, Dr. Priyanka Agrawal at \r\nRK Hospital, Itwari, Nagpur, is here for you. Book your appointment today \r\nand experience women\'s healthcare built on expertise, empathy, and excellence.', '[]', '[]', '[]', 'Obstetrics & Gynecology, Cesarean (C-Section) Delivery, High-Risk Pregnancy Management, Hormonal Imbalance Treatment, Infertility Evaluation & Treatment, Family Planning & Contraception Counseling, PCOS Treatment, Women\'s Reproductive Health', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.0751452020872!2d79.11106467430966!3d21.149407583625667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd4c7627f91e951%3A0xc5092704d82a04af!2sDr.%20Priyanka%20Jain%20Agrawal!5e0!3m2!1sen!2sin!4v1775029603105!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'assets/img/doctors/dr-priyanka-agrawal-69ce13f382d5c.webp', 'doctor-profile.html', 'Dr. Priyanka Agrawal is a compassionate Gynecologist & Obstetrician at RK Hospital, Aurangabad, specializing in high-risk pregnancy, infertility & women\'s health.', NULL, 'gynecologist nagpur, obstetrician nagpur, c-section delivery nagpur, high risk pregnancy management, hormonal imbalance treatment nagpur, infertility treatment nagpur, family planning counseling, PCOS doctor nagpur, women\'s health specialist itwari, best', 0, 1, '2026-04-02 00:00:00', 'Dr. Priyanka Agrawal – Gynecologist in Nagpur', 'Consult Dr. Priyanka Agrawal, trusted Gynecologist at RK Hospital, Itwari, Nagpur. Expert in C-section, high-risk pregnancy, infertility & women\'s health care.', 'gynecologist in Nagpur', 'https://rkhospital.com/doctors/dr-priyanka-agrawal', 'Dr. Priyanka Agrawal – Gynecologist in Nagpur', 'Consult Dr. Priyanka Agrawal, trusted Gynecologist at RK Hospital, Itwari, Nagpur. Expert in C-section, high-risk pregnancy, infertility & women\'s health care.', 'assets/img/doctors/dr-priyanka-agrawal-69ce13f382d5c.webp', 'profile', 'Dr. Priyanka Agrawal – Gynecologist in Nagpur', 'Consult Dr. Priyanka Agrawal, trusted Gynecologist at RK Hospital, Itwari, Nagpur. Expert in C-section, high-risk pregnancy, infertility & women\'s health care.', 'summary_large_image', 'index,follow', 'Physician', '{\"@context\":\"https://schema.org\",\"@type\":\"Physician\",\"name\":\"Dr. Priyanka Agrawal\",\"description\":\"Consult Dr. Priyanka Agrawal, trusted Gynecologist at RK Hospital, Itwari, Nagpur. Expert in C-section, high-risk pregnancy, infertility & women\'s health care.\",\"image\":\"assets/img/doctors/dr-priyanka-agrawal-69ce13f382d5c.webp\",\"url\":\"https://rkhospital.com/doctors/dr-priyanka-agrawal\",\"medicalSpecialty\":\"Gynecologist & Obstetrician\"}', '2026-04-01 07:48:22', '2026-04-02 07:00:03', '/assets/img/doctors/priyankabannar.webp');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_services`
--

CREATE TABLE `doctor_services` (
  `doctor_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mosquito_services`
--

CREATE TABLE `mosquito_services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_desc` text NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) DEFAULT '',
  `inner_image` varchar(255) DEFAULT '',
  `icon` varchar(100) DEFAULT '',
  `services_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`services_list`)),
  `features_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features_list`)),
  `why_choose_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`why_choose_list`)),
  `extra_block_title` varchar(255) DEFAULT '',
  `extra_block_desc` text DEFAULT '',
  `testimonial_text` text DEFAULT '',
  `testimonial_name` varchar(100) DEFAULT '',
  `testimonial_role` varchar(150) DEFAULT '',
  `testimonial_image` varchar(255) DEFAULT '',
  `faqs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`faqs`)),
  `meta_title` varchar(255) DEFAULT '',
  `meta_description` varchar(500) DEFAULT '',
  `focus_keyword` varchar(255) DEFAULT '',
  `canonical_url` varchar(500) DEFAULT '',
  `og_title` varchar(255) DEFAULT '',
  `og_description` varchar(500) DEFAULT '',
  `og_type` varchar(50) DEFAULT 'product',
  `og_image` varchar(255) DEFAULT '',
  `twitter_title` varchar(255) DEFAULT '',
  `twitter_description` varchar(500) DEFAULT '',
  `twitter_card` varchar(50) DEFAULT 'summary_large_image',
  `robots_meta` varchar(50) DEFAULT 'index,follow',
  `schema_type` varchar(100) DEFAULT 'Product',
  `schema_json` longtext DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mosquito_services`
--

INSERT INTO `mosquito_services` (`id`, `title`, `slug`, `short_desc`, `description`, `image`, `inner_image`, `icon`, `services_list`, `features_list`, `why_choose_list`, `extra_block_title`, `extra_block_desc`, `testimonial_text`, `testimonial_name`, `testimonial_role`, `testimonial_image`, `faqs`, `meta_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`, `og_type`, `og_image`, `twitter_title`, `twitter_description`, `twitter_card`, `robots_meta`, `schema_type`, `schema_json`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Premium Bedroom Mosquito Nets', 'premium-bedroom-mosquito-nets', 'Complete bedroom protection with our premium range of conical, box-style, and double-bed mosquito nets. Chemical-free, durable, and designed for Indian homes.', 'We offer a wide range of premium bedroom mosquito nets designed to provide complete, chemical-free protection for every member of your family. Our nets are manufactured using high-density polyester mesh with fine holes per square inch to block mosquitoes, sand flies, and other biting insects effectively. Available in conical, rectangular box-style, and double-bed configurations, our bedroom nets fit all standard Indian bed sizes including single, double, queen, and king. Each net is lightweight, breathable, and easy to install using a single ceiling hook or a simple frame system. The fine mesh allows full airflow so you stay cool and comfortable through the night without any stuffiness. Our nets are washable, reusable, and designed to last three to five years with proper care. Whether you need protection from malaria in a high-risk zone or simply want uninterrupted sleep without the buzzing and biting of mosquitoes, our bedroom nets deliver reliable performance night after night.', 'assets/img/service/mosquito1.jpg', 'assets/img/service/mosquito4.webp', 'flaticon-mosquito-net', '[\"Conical single-point hanging nets\",\"Rectangular box-style nets\",\"Double and queen bed nets\",\"Ultra-fine 200-mesh density nets\",\"Polyester and nylon variants\",\"Pre-stitched hem and tuck edges\"]', '[\"Fits all standard Indian bed sizes\",\"Chemical-free physical barrier protection\",\"Full airflow mesh for comfortable sleep\",\"Easy single-hook ceiling installation\",\"Machine washable and reusable\",\"3 to 5 year lifespan with proper care\"]', '[\"ISI-standard fine mesh material\",\"Available in white, cream, and off-white\",\"Reinforced hanging loop and hem stitching\",\"Suitable for all ceiling heights\",\"Bulk and wholesale pricing available\",\"Fast delivery across India\"]', 'Bedroom Net Customization', 'We offer customized sizing for non-standard beds, antique four-poster beds, and hospital cots. Contact us with your bed dimensions and we will manufacture a net that fits perfectly with no gaps.', 'We replaced chemical coils with your bedroom nets and the difference is remarkable. No more burning smell, no more coughing at night. The whole family sleeps peacefully now.', 'Priya Sharma', 'Homemaker, Nagpur', 'assets/img/user-3.png', '[{\"question\":\"What mesh density do your bedroom nets use?\",\"answer\":\"Our premium bedroom nets use a minimum of 156 holes per square inch, with our top-tier range offering 200 holes per square inch. This blocks mosquitoes, gnats, and sand flies completely.\"},{\"question\":\"Can I wash the net in a washing machine?\",\"answer\":\"We recommend hand washing with mild detergent and cold water for longer life. Machine washing on a gentle cycle is acceptable but may reduce the lifespan of the hem stitching over time.\"},{\"question\":\"What sizes are available?\",\"answer\":\"We stock nets for single, double, queen, and king size beds. Custom sizes for non-standard beds are available on order with a 5 to 7 day manufacturing lead time.\"},{\"question\":\"Do the nets require ceiling drilling?\",\"answer\":\"Conical nets require a single ceiling hook. We also offer freestanding frame kits that require no drilling and are ideal for renters or those who prefer not to modify their ceiling.\"}]', 'Premium Bedroom Mosquito Nets for Indian Homes', 'Buy high-quality bedroom mosquito nets in India. Chemical-free, fine mesh, available in single, double and queen sizes. Full protection from malaria and dengue at night.', 'premium bedroom mosquito net India', '', 'Premium Bedroom Mosquito Nets for Indian Homes', 'Chemical-free, fine mesh bedroom nets available in all sizes. Full family protection from malaria and dengue.', 'product', '', 'Premium Bedroom Mosquito Nets for Indian Homes', 'Chemical-free, fine mesh bedroom nets available in all sizes. Full family protection from malaria and dengue.', 'summary_large_image', 'index,follow', 'Product', '{\"@context\":\"https://schema.org\",\"@type\":\"Product\",\"name\":\"Premium Bedroom Mosquito Nets\",\"description\":\"Complete bedroom protection with premium conical and box-style mosquito nets designed for Indian homes.\",\"brand\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"offers\":{\"@type\":\"Offer\",\"availability\":\"https://schema.org/InStock\",\"priceCurrency\":\"INR\"}}', 1, 1, '2026-04-11 17:21:40', '2026-04-11 17:25:19'),
(2, 'Baby and Infant Mosquito Net Solutions', 'baby-infant-mosquito-net-solutions', 'Specially designed ultra-fine mosquito nets for babies, infants, and toddlers. Safe, untreated, and perfectly fitted for cribs, cradles, prams, and jhulas.', 'Protecting your baby from mosquito bites is one of the most important things you can do as a parent. Our dedicated baby and infant mosquito net range is designed from the ground up with infant safety as the top priority. All our baby nets are completely untreated — no insecticides, no chemical coatings, no harmful dyes. The mesh is ultra-fine at 200 holes per square inch, blocking even the smallest biting insects that can harm a newborn. Our crib dome nets fit snugly over standard baby cots and cribs using a flexible hoop frame and an elastic base that grips securely without slipping. For traditional Indian jhula-style cradles, we offer dedicated cradle nets that wrap around the frame and tuck underneath to create a completely sealed sleeping environment. Our pram nets are elasticated for a secure fit over all standard pram and stroller models, giving your baby protection during outdoor walks and trips to the market. All baby nets are made from soft, non-irritating polyester that will not scratch or harm delicate newborn skin even on accidental contact. Each net is easy to remove for feeding and diaper changes and reattaches in seconds. They are gentle-wash safe and dry quickly for easy daily maintenance.', 'assets/img/service/mosquito2.jpg', 'assets/img/service/mosquito5.webp', 'flaticon-baby', '[\"Crib and baby cot dome nets\",\"Jhula and cradle nets\",\"Pram and stroller nets\",\"Portable pop-up travel baby nets\",\"Ultra-fine 200-mesh density\",\"Elastic edge fitted base\"]', '[\"100 percent untreated and chemical free\",\"Ultra-soft non-irritating polyester mesh\",\"Elastic fitted base prevents gaps\",\"Easy open access for feeding\",\"Compatible with standard Indian jhulas\",\"Folds flat for travel and storage\"]', '[\"Designed specifically for newborns and infants\",\"No insecticide or chemical treatment\",\"200 mesh density blocks all biting insects\",\"Machine gentle-wash safe\",\"Available in white and pastel colors\",\"Pediatrician recommended for daily use\"]', 'Custom Cradle and Crib Net Orders', 'We manufacture custom-size cradle and crib nets for non-standard baby furniture. Provide us with the dimensions of your jhula or crib frame and we will deliver a perfectly fitted net within 5 to 7 working days.', 'Our baby had mosquito bites every morning before we found this net. Since we started using the crib dome net, not a single bite. The elastic base fits the cot perfectly and does not slip at all.', 'Anjali Mehta', 'Mother of 8-month-old, Pune', 'assets/img/user-3.png', '[{\"question\":\"Are your baby nets safe for newborns from day one?\",\"answer\":\"Yes. All our baby nets are completely untreated with no insecticides or chemical coatings. They are safe for use with newborns from the very first day.\"},{\"question\":\"Will the net fit my jhula?\",\"answer\":\"Our standard jhula nets fit cradles up to 90cm in length. For larger or custom jhulas, we offer made-to-order nets. Share your dimensions and we will prepare a fitted net for you.\"},{\"question\":\"How do I access my baby at night without removing the whole net?\",\"answer\":\"Our crib dome nets have a side opening panel that lifts open and holds in position, giving you easy access for feeding and diaper changes without dismantling the net.\"},{\"question\":\"How often should I wash the baby net?\",\"answer\":\"We recommend washing the baby net every 7 to 10 days using a gentle baby-safe detergent and cold water. Always air dry in shade and ensure the net is fully dry before use.\"}]', 'Baby and Infant Mosquito Nets for Cribs, Cradles and Prams', 'Safe, untreated, ultra-fine mosquito nets for babies and toddlers in India. Fits cribs, jhulas, prams and travel cots. Chemical-free protection from day one.', 'baby mosquito net for crib jhula India', '', 'Baby and Infant Mosquito Net Solutions', 'Safe, untreated ultra-fine nets for newborns. Fits cribs, jhulas, and prams. Chemical-free from day one.', 'product', '', 'Baby and Infant Mosquito Net Solutions', 'Safe, untreated ultra-fine nets for newborns. Fits cribs, jhulas, and prams. Chemical-free from day one.', 'summary_large_image', 'index,follow', 'Product', '{\"@context\":\"https://schema.org\",\"@type\":\"Product\",\"name\":\"Baby and Infant Mosquito Net Solutions\",\"description\":\"Ultra-fine, untreated mosquito nets for babies and infants. Fits cribs, cradles, jhulas and prams.\",\"brand\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"offers\":{\"@type\":\"Offer\",\"availability\":\"https://schema.org/InStock\",\"priceCurrency\":\"INR\"}}', 1, 2, '2026-04-11 17:21:40', '2026-04-11 17:25:28'),
(3, 'Outdoor and Camping Mosquito Net Solutions', 'outdoor-camping-mosquito-net-solutions', 'High-durability mosquito nets for camping, trekking, rooftop sleeping, and outdoor use. Lightweight, UV-resistant, and built to perform in Indian outdoor conditions.', 'Our outdoor and camping mosquito net range is engineered for people who need reliable protection beyond the bedroom. Whether you are trekking through forested regions, camping near rivers and lakes, sleeping on your rooftop or veranda during hot summer nights, or traveling to malaria-endemic areas, our outdoor nets provide professional-grade protection in any environment. All outdoor nets in our range are made from heavier-duty polyester or nylon that resists snagging, tearing, and UV degradation — unlike standard bedroom nets that wear out quickly under outdoor conditions. The mesh density is a minimum of 156 holes per square inch, blocking mosquitoes as well as smaller biting insects like sand flies and midges that are common in forest and riverside environments. Our hammock nets zip completely around the hammock and create a sealed sleeping pod between two trees. Our freestanding pop-up nets assemble in under 60 seconds and can be placed over any flat sleeping surface — a charpoy, a camp mat, or a sleeping bag on the ground. For trekkers who count every gram, our ultralight bivy nets weigh under 200 grams and pack to the size of a small water bottle. Each outdoor net includes reinforced hanging points, quality YKK-style zippers, and a carry pouch. For rooftop and veranda use, our portable frame nets assemble without drilling and can be set up and packed down each evening in under five minutes. All outdoor nets are treated for UV resistance and carry a minimum one-year durability guarantee under normal outdoor use conditions.', 'assets/img/service/mosquito3.avif', 'assets/img/service/mosquito6.jpg', 'flaticon-camping', '[\"Conical and box-style camping nets\",\"Hammock wrap-around nets\",\"Freestanding pop-up nets\",\"Ultralight bivy nets for trekking\",\"Rooftop and veranda frame nets\",\"Insecticide-treated outdoor variants\"]', '[\"UV-resistant heavy-duty polyester mesh\",\"Minimum 156 mesh density for forest use\",\"Reinforced stress-point stitching\",\"Quality zipper entry panels\",\"Packs into compact carry pouch\",\"One-year outdoor durability guarantee\"]', '[\"Designed for Indian outdoor conditions\",\"Works without ceiling hooks or fixed infrastructure\",\"Suitable for charpoys, camp mats, and hammocks\",\"Insecticide-treated options for high-risk zones\",\"Bulk supply for trek groups and NGOs\",\"Pan-India shipping with same-week dispatch\"]', 'Group and Bulk Outdoor Net Supply', 'We supply outdoor mosquito nets in bulk for trekking groups, adventure camps, NGO field programs, and government health initiatives. Contact us for volume pricing and customized branding options on nets.', 'We took your hammock nets on a 12-day trek through Bastar. Zero mosquito bites across the entire group. The zippers held up perfectly through rain and rough handling. Outstanding quality.', 'Rohan Deshmukh', 'Trek Leader, Adventure Club Nagpur', 'assets/img/user-3.png', '[{\"question\":\"Can these nets handle rain and humidity?\",\"answer\":\"Yes. Our outdoor nets are made from quick-dry polyester and nylon that handle rain, humidity, and morning dew without retaining moisture or developing mold. Always dry them fully before storing after a trip.\"},{\"question\":\"Do the pop-up nets work on a charpoy?\",\"answer\":\"Yes. Our freestanding pop-up nets work on charpoys, camp cots, ground mats, and any flat sleeping surface. The base is flexible and can be weighted down with shoes or water bottles in windy conditions.\"},{\"question\":\"What is the weight of the ultralight bivy net?\",\"answer\":\"Our ultralight bivy nets weigh between 160 and 200 grams depending on the size variant. They pack into a pouch roughly the size of a 500ml water bottle, making them ideal for long-distance trekking.\"},{\"question\":\"Are insecticide-treated outdoor nets safe?\",\"answer\":\"Yes. Our treated outdoor nets use WHO-approved permethrin treatment. They are safe for use as directed and are particularly recommended for high-risk malaria zones like forested and tribal areas.\"}]', 'Outdoor and Camping Mosquito Nets for Trekking and Travel India', 'Buy durable outdoor mosquito nets for camping, trekking, rooftop sleeping and travel in India. UV-resistant, lightweight, and built for Indian outdoor conditions.', 'outdoor camping mosquito net India trekking', '', 'Outdoor and Camping Mosquito Net Solutions', 'Durable, UV-resistant outdoor nets for camping, trekking, and rooftop sleeping. Built for Indian outdoor conditions.', 'product', '', 'Outdoor and Camping Mosquito Net Solutions', 'Durable, UV-resistant outdoor nets for camping, trekking, and rooftop sleeping. Built for Indian outdoor conditions.', 'summary_large_image', 'index,follow', 'Product', '{\"@context\":\"https://schema.org\",\"@type\":\"Product\",\"name\":\"Outdoor and Camping Mosquito Net Solutions\",\"description\":\"High-durability mosquito nets for camping, trekking, rooftop sleeping and outdoor use in India.\",\"brand\":{\"@type\":\"Organization\",\"name\":\"Your Brand\"},\"offers\":{\"@type\":\"Offer\",\"availability\":\"https://schema.org/InStock\",\"priceCurrency\":\"INR\"}}', 1, 3, '2026-04-11 17:21:40', '2026-04-11 17:26:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `full_description` text DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `applications` text DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `dimensions` varchar(100) DEFAULT NULL,
  `material` varchar(150) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `warranty` varchar(100) DEFAULT NULL,
  `certifications` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `in_stock` tinyint(1) NOT NULL DEFAULT 1,
  `availability` varchar(100) DEFAULT 'In Stock',
  `delivery_info` varchar(255) DEFAULT 'Pan India Delivery Available',
  `country_of_origin` varchar(100) DEFAULT 'India',
  `tags` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `badge_type` varchar(50) DEFAULT NULL,
  `moq` varchar(100) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 4.5,
  `reviews` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `meta_title` varchar(70) DEFAULT NULL,
  `meta_description` varchar(180) DEFAULT NULL,
  `focus_keyword` varchar(150) DEFAULT NULL,
  `canonical_url` varchar(500) DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` varchar(300) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `og_type` varchar(30) DEFAULT 'product',
  `twitter_title` varchar(255) DEFAULT NULL,
  `twitter_description` varchar(300) DEFAULT NULL,
  `twitter_card` varchar(30) DEFAULT 'summary_large_image',
  `robots_meta` varchar(30) DEFAULT 'index,follow',
  `schema_type` varchar(50) DEFAULT 'Product',
  `schema_json` longtext DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `full_description`, `specifications`, `features`, `applications`, `brand`, `sku`, `weight`, `dimensions`, `material`, `color`, `warranty`, `certifications`, `image2`, `image3`, `image4`, `in_stock`, `availability`, `delivery_info`, `country_of_origin`, `tags`, `image`, `badge`, `badge_type`, `moq`, `rating`, `reviews`, `is_active`, `sort_order`, `created_at`, `meta_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`, `og_image`, `og_type`, `twitter_title`, `twitter_description`, `twitter_card`, `robots_meta`, `schema_type`, `schema_json`, `updated_at`) VALUES
(14, 'Heavy Duty Leather Safety Gloves', 'heavy-duty-leather-safety-gloves', 'safety-gloves', 'ISI certified heavy-duty leather safety gloves ideal for construction, welding, and industrial use. Superior grip and cut-resistant protection.', 'Niraj Industries Heavy Duty Leather Safety Gloves are manufactured using premium full-grain cowhide leather, offering outstanding protection against cuts, abrasions, and heat. These gloves are a staple for construction sites, welding workshops, and heavy-duty industrial environments across India. The reinforced palm and fingertips ensure extended durability even under the harshest working conditions. The ergonomic design provides a snug fit, reducing hand fatigue during long working hours. ISI certified and compliant with IS:6994 standards, these gloves are trusted by contractors, builders, and safety officers pan-India.', 'Grade: Industrial Grade A\r\nStandard: IS:6994 Part-1\r\nPalm Material: Full-Grain Cowhide Leather\r\nBack Material: Canvas / Leather\r\nCuff Style: Slip-On Gauntlet\r\nLength: 27 cm\r\nSizes Available: M, L, XL, XXL\r\nTemperature Resistance: Up to 100°C\r\nTensile Strength: 150 N/cm²', 'Full-grain cowhide leather palm\r\nReinforced stitching at stress points\r\nCut and abrasion resistant\r\nSlip-resistant textured grip\r\nBreathable canvas back\r\nComfortable elasticated wrist\r\nISI certified IS:6994\r\nSweat-absorbent inner lining', 'Construction and demolition sites\r\nWelding and fabrication workshops\r\nMaterial handling and logistics\r\nBrick laying and masonry work\r\nRoad construction\r\nMining and quarrying\r\nElectrical maintenance (light duty)\r\nGeneral industrial use', 'Niraj Industries', 'NI-GLV-LTH-001', '250 gm per pair', '27 cm length, fits M to XXL', 'Full-Grain Cowhide Leather, Canvas Back', 'Brown / Natural Tan', '3 Months Manufacturing Defect Warranty', 'ISI Mark IS:6994, BIS Certified', 'assets/img/products/glove1.jpg', 'assets/img/products/heavy-duty-leather-safety-gloves-3.webp', 'assets/img/products/heavy-duty-leather-safety-gloves-4.webp', 1, 'Ships in 1–2 Business Days', 'Free delivery on orders above ₹5,000 | Pan India Shipping', 'India', 'leather gloves, safety gloves, construction gloves, welding gloves, ISI certified gloves, heavy duty gloves, nagpur, niraj industries', 'assets/img/products/glove1.jpg', 'Bestseller', 'bestseller', '12 Pairs (1 Dozen)', 4.8, 124, 1, 1, '2026-04-10 12:35:34', 'Heavy Duty Leather Safety Gloves | ISI Certified | Niraj Industries', 'Buy ISI certified heavy duty leather safety gloves from Niraj Industries, Nagpur. Best for construction, welding & industrial use. MOQ 12 pairs. Pan India delivery.', 'heavy duty leather safety gloves nagpur', 'https://nirajindustries.com/products/heavy-duty-leather-safety-gloves', 'Heavy Duty Leather Safety Gloves | ISI Certified | Niraj Industries', 'ISI certified heavy duty leather safety gloves for construction, welding & industrial use. Order in bulk from Niraj Industries, Nagpur.', 'assets/img/products/heavy-duty-leather-safety-gloves.webp', 'product', 'Heavy Duty Leather Safety Gloves | Niraj Industries', 'ISI certified leather safety gloves for construction & welding. Bulk orders available. Pan India delivery.', 'summary_large_image', 'index,follow', 'Product', '{\"@context\":\"https://schema.org\",\"@type\":\"Product\",\"name\":\"Heavy Duty Leather Safety Gloves\",\"description\":\"ISI certified heavy-duty leather safety gloves ideal for construction, welding, and industrial use.\",\"image\":\"https://nirajindustries.com/assets/img/products/heavy-duty-leather-safety-gloves.webp\",\"brand\":{\"@type\":\"Brand\",\"name\":\"Niraj Industries\"},\"sku\":\"NI-GLV-LTH-001\",\"category\":\"safety-gloves\",\"url\":\"https://nirajindustries.com/products/heavy-duty-leather-safety-gloves\"}', '2026-04-10 18:13:24'),
(15, 'Nitrile Chemical Resistant Gloves', 'nitrile-chemical-resistant-gloves', 'chemical-gloves', 'Heavy-gauge nitrile gloves offering excellent resistance to acids, oils, solvents and chemicals. Ideal for labs, paint shops and chemical plants.', 'Niraj Industries Nitrile Chemical Resistant Gloves are manufactured from 100% synthetic nitrile rubber, providing superior resistance to a wide range of chemicals including acids, alkalis, oils, greases, and solvents. Unlike latex gloves, these are latex-free and suitable for workers with latex allergies. The textured fingertips provide a secure grip even in wet and oily conditions. These gloves meet IS:4770 standards and are widely used in pharmaceutical plants, chemical factories, paint shops, and laboratory environments. The extended cuff design provides additional forearm protection during handling of hazardous materials.', 'Material: 100% Nitrile Rubber (Latex-Free)\r\nStandard: IS:4770 / EN 374\r\nThickness: 0.38 mm (fingers), 0.33 mm (palm)\r\nLength: 30 cm (extended cuff)\r\nSizes Available: S, M, L, XL\r\nChemical Resistance: Acids, Alkalis, Oils, Solvents\r\nAQL: 1.5\r\nTexture: Micro-textured fingertips\r\nColor: Blue', 'Latex-free — safe for latex allergy users\r\nExcellent chemical and solvent resistance\r\nMicro-textured fingertips for wet grip\r\nExtended 30 cm cuff for forearm protection\r\nPuncture and tear resistant\r\nPowder-free inner surface\r\nIS:4770 and EN 374 certified\r\nAmbidextrous design', 'Chemical manufacturing plants\r\nPharmaceutical and lab environments\r\nPaint shops and automotive refinishing\r\nAcid handling and battery maintenance\r\nPesticide and fertilizer handling\r\nCleaning and janitorial services\r\nFood processing (chemical wash)\r\nPetrochemical industry', 'Niraj Industries', 'NI-GLV-NTR-002', '120 gm per pair', '30 cm length, S to XL', '100% Nitrile Rubber, Latex-Free', 'Blue', '6 Months Shelf Life Warranty (Unopened)', 'IS:4770, EN 374, BIS Certified, Latex-Free Certified', 'assets/img/products/glove2.png', 'assets/img/products/nitrile-chemical-resistant-gloves-3.webp', 'assets/img/products/nitrile-chemical-resistant-gloves-4.webp', 1, 'In Stock — Ships Same Day', 'Free delivery on orders above ₹5,000 | Pan India Shipping', 'India', 'nitrile gloves, chemical gloves, acid resistant gloves, latex free gloves, lab gloves, chemical resistant gloves, nagpur', 'assets/img/products/glove2.png', 'New', 'new', '50 Pairs (1 Box)', 4.6, 87, 1, 2, '2026-04-10 12:35:34', 'Nitrile Chemical Resistant Gloves | IS:4770 | Niraj Industries', 'Buy nitrile chemical resistant gloves from Niraj Industries Nagpur. Latex-free, acid & solvent resistant. IS:4770 certified. MOQ 50 pairs. Bulk orders welcome.', 'nitrile chemical resistant gloves nagpur', 'https://nirajindustries.com/products/nitrile-chemical-resistant-gloves', 'Nitrile Chemical Resistant Gloves | IS:4770 | Niraj Industries', 'Latex-free nitrile gloves resistant to acids, solvents and chemicals. IS:4770 certified. Bulk supply from Niraj Industries, Nagpur.', 'assets/img/products/nitrile-chemical-resistant-gloves.webp', 'product', 'Nitrile Chemical Resistant Gloves | Niraj Industries', 'IS:4770 certified nitrile gloves for chemical, lab & industrial use. Pan India delivery.', 'summary_large_image', 'index,follow', 'Product', '{\"@context\":\"https://schema.org\",\"@type\":\"Product\",\"name\":\"Nitrile Chemical Resistant Gloves\",\"description\":\"Heavy-gauge nitrile gloves offering excellent resistance to acids, oils, solvents and chemicals.\",\"image\":\"https://nirajindustries.com/assets/img/products/nitrile-chemical-resistant-gloves.webp\",\"brand\":{\"@type\":\"Brand\",\"name\":\"Niraj Industries\"},\"sku\":\"NI-GLV-NTR-002\",\"category\":\"chemical-gloves\",\"url\":\"https://nirajindustries.com/products/nitrile-chemical-resistant-gloves\"}', '2026-04-10 18:12:51'),
(16, 'Electrical Insulated Rubber Gloves', 'electrical-insulated-rubber-gloves', 'electrical-gloves', 'High-voltage insulated rubber gloves rated up to 11KV. ISI certified for electricians and linemen working on live electrical installations.', 'Niraj Industries Electrical Insulated Rubber Gloves are engineered for maximum safety during electrical work on live lines and equipment. Manufactured from 100% natural rubber compound, these gloves are dielectric tested and rated up to 11KV (Class 1) as per IS:4770 and IEC 60903 standards. The seamless construction eliminates weak points and provides uniform wall thickness throughout. These gloves are used by electricians, power utility workers, substation maintenance teams, and electrical contractors across India. Each pair is individually air-tested before dispatch to ensure zero defects. The extended gauntlet cuff protects the wrist and lower forearm during panel work and cable jointing.', 'Material: 100% Natural Rubber Compound\r\nStandard: IS:4770 / IEC 60903\r\nVoltage Rating: 11KV (Class 1)\r\nProof Test Voltage: 20KV\r\nLength: 36 cm\r\nWall Thickness: Min 1.2 mm (palm)\r\nSizes Available: 8, 9, 10, 11\r\nColor: Red (outer) / Yellow (inner indicator)\r\nTest Frequency: 100% individually tested', 'Rated up to 11KV Class 1\r\nIndividually air-pressure tested\r\nSeamless dielectric rubber construction\r\nExtended 36 cm gauntlet cuff\r\nColor-coded inner layer for damage detection\r\nIS:4770 and IEC 60903 certified\r\nOzone and UV resistant\r\nFlexible even at low temperatures', 'Live electrical line maintenance\r\nSubstation and switchgear operation\r\nLT/HT panel work\r\nCable jointing and termination\r\nPower utility companies (MSEDCL etc.)\r\nElectrical contractors\r\nEPC and infrastructure projects\r\nGenerator and transformer maintenance', 'Niraj Industries', 'NI-GLV-ELC-003', '450 gm per pair', '36 cm length, Sizes 8 to 11', '100% Natural Rubber Compound, Dielectric Grade', 'Red / Yellow Indicator', '1 Year from Date of Manufacture (with proper storage)', 'IS:4770, IEC 60903, ISI Mark, BIS Certified', 'assets/img/products/glove3.jpg', 'assets/img/products/electrical-insulated-rubber-gloves-3.webp', 'assets/img/products/electrical-insulated-rubber-gloves-4.webp', 1, 'In Stock — Ships in 1 Day', 'Free delivery on orders above ₹5,000 | Pan India Shipping', 'India', 'electrical gloves, insulated gloves, 11kv gloves, rubber gloves, electrician gloves, dielectric gloves, high voltage gloves, nagpur', 'assets/img/products/electrical-insulated-rubber-gloves-69d8fcca51c1e.webp', 'Hot', 'hot', '6 Pairs', 4.9, 203, 1, 3, '2026-04-10 12:35:34', 'Electrical Insulated Rubber Gloves 11KV | IS:4770 | Niraj Industries', 'Buy 11KV electrical insulated rubber gloves from Niraj Industries Nagpur. IS:4770 & IEC 60903 certified. Individually tested. MOQ 6 pairs. Pan India delivery.', 'electrical insulated rubber gloves 11kv nagpur', 'https://nirajindustries.com/products/electrical-insulated-rubber-gloves', 'Electrical Insulated Rubber Gloves 11KV | Niraj Industries', '11KV rated electrical insulated rubber gloves. IS:4770 & IEC 60903 certified. Bulk supply from Niraj Industries, Nagpur.', 'assets/img/products/electrical-insulated-rubber-gloves-69d8fcca51c1e.webp', 'product', 'Electrical Insulated Gloves 11KV | Niraj Industries', 'IS:4770 certified 11KV electrical insulated gloves. Individually tested. Bulk orders welcome.', 'summary_large_image', 'index,follow', 'Product', '{\"@context\":\"https://schema.org\",\"@type\":\"Product\",\"name\":\"Electrical Insulated Rubber Gloves\",\"description\":\"Buy 11KV electrical insulated rubber gloves from Niraj Industries Nagpur. IS:4770 & IEC 60903 certified. Individually tested. MOQ 6 pairs. Pan India delivery.\",\"image\":\"http://localhost/gloves/assets/img/products/electrical-insulated-rubber-gloves-69d8fcca51c1e.webp\",\"brand\":{\"@type\":\"Brand\",\"name\":\"Niraj Industries\"},\"sku\":\"NI-GLV-ELC-003\",\"url\":\"https://nirajindustries.com/products/electrical-insulated-rubber-gloves\",\"category\":\"electrical-gloves\"}', '2026-04-10 19:06:10'),
(17, 'Anti-Cut Knitted Hand Gloves (HPPE)', 'anti-cut-knitted-hppe-gloves', 'cut-resistant-gloves', 'Level-5 cut-resistant HPPE knitted gloves with polyurethane coating. Lightweight, breathable and ideal for glass handling, metal fabrication and food processing.', 'Niraj Industries Anti-Cut Knitted Hand Gloves are engineered from High Performance Polyethylene (HPPE) fiber — the same material used in bullet-resistant vests — delivering Level 5 (EN 388) cut resistance in an ultra-lightweight and comfortable glove. The seamless 13-gauge knit construction combined with a palm-coated polyurethane (PU) finish ensures excellent grip on dry, wet, and oily surfaces. These gloves are the go-to choice for glass handling, sheet metal fabrication, automotive assembly, and food processing plants where hand safety and dexterity are equally critical. The breathable knit back keeps hands cool during extended use, reducing fatigue and improving productivity on the shop floor.', 'Fiber: HPPE (High Performance Polyethylene)\r\nCut Resistance Level: Level 5 (EN 388 / ANSI A4)\r\nGauge: 13 Gauge Seamless Knit\r\nCoating: Palm PU (Polyurethane) Coated\r\nBack: Breathable Open Knit\r\nLength: 24 cm\r\nSizes Available: S, M, L, XL, XXL\r\nAbrasion Resistance: Level 4\r\nColor: Grey / Black PU Palm', 'EN 388 Level-5 cut resistance\r\n13-gauge seamless HPPE knit construction\r\nPolyurethane palm coating for grip\r\nBreathable open-back design\r\nTouchscreen compatible fingertips\r\nLightweight — only 40 gm per pair\r\nMachine washable up to 40°C\r\nANSI A4 compliant', 'Glass cutting and handling\r\nSheet metal and fabrication shops\r\nAutomotive assembly lines\r\nFood processing and meat handling\r\nCardboard and packaging industry\r\nWire and cable handling\r\nElectronic component assembly\r\nPrinting and bindery operations', 'Niraj Industries', 'NI-GLV-CUT-004', '40 gm per pair', '24 cm length, S to XXL', 'HPPE Fiber, Polyurethane (PU) Palm Coating', 'Grey with Black PU Palm', '3 Months Manufacturing Defect Warranty', 'EN 388 Level 5, ANSI A4, CE Certified', 'assets/img/products/glove4.jpg', 'assets/img/products/anti-cut-knitted-hppe-gloves-3.webp', 'assets/img/products/anti-cut-knitted-hppe-gloves-4.webp', 1, 'In Stock — Ships in 1–2 Business Days', 'Free delivery on orders above ₹5,000 | Pan India Shipping', 'India', 'cut resistant gloves, anti cut gloves, HPPE gloves, level 5 gloves, glass handling gloves, EN388 gloves, metal fabrication gloves, nagpur', 'assets/img/products/glove4.jpg', 'Bestseller', 'bestseller', '12 Pairs (1 Dozen)', 4.7, 156, 1, 4, '2026-04-10 12:35:34', 'Anti-Cut HPPE Knitted Gloves Level 5 | EN 388 | Niraj Industries', 'Buy Level-5 cut resistant HPPE knitted gloves from Niraj Industries Nagpur. EN 388 & ANSI A4 certified. Ideal for glass, metal & food industry. MOQ 12 pairs.', 'cut resistant HPPE gloves level 5 nagpur', 'https://nirajindustries.com/products/anti-cut-knitted-hppe-gloves', 'Anti-Cut HPPE Knitted Gloves Level 5 | Niraj Industries', 'EN 388 Level-5 cut resistant HPPE gloves for glass, metal & food processing. Bulk supply from Niraj Industries, Nagpur.', 'assets/img/products/anti-cut-knitted-hppe-gloves.webp', 'product', 'Anti-Cut HPPE Gloves Level 5 | Niraj Industries', 'EN 388 Level-5 HPPE cut resistant gloves. Lightweight, breathable. Bulk orders available.', 'summary_large_image', 'index,follow', 'Product', '{\"@context\":\"https://schema.org\",\"@type\":\"Product\",\"name\":\"Anti-Cut Knitted Hand Gloves (HPPE)\",\"description\":\"Level-5 cut-resistant HPPE knitted gloves with polyurethane coating for glass handling, metal fabrication and food processing.\",\"image\":\"https://nirajindustries.com/assets/img/products/anti-cut-knitted-hppe-gloves.webp\",\"brand\":{\"@type\":\"Brand\",\"name\":\"Niraj Industries\"},\"sku\":\"NI-GLV-CUT-004\",\"category\":\"cut-resistant-gloves\",\"url\":\"https://nirajindustries.com/products/anti-cut-knitted-hppe-gloves\"}', '2026-04-10 18:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_subtitle` text DEFAULT NULL,
  `hero_content_json` longtext DEFAULT NULL,
  `service_card_json` longtext DEFAULT NULL,
  `why_choose_json` longtext DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `hero_image_alt` varchar(255) DEFAULT NULL,
  `slug` varchar(280) NOT NULL,
  `short_description` text DEFAULT NULL,
  `h1_title` varchar(255) DEFAULT NULL,
  `breadcrumb_json` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `sections_json` longtext DEFAULT NULL,
  `faqs_json` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT 'assets/img/services/default.jpg',
  `image_alt` varchar(255) DEFAULT NULL,
  `gallery_json` longtext DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `related_services_json` text DEFAULT NULL,
  `doctor_ids` text DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 1,
  `sort_order` smallint(5) UNSIGNED DEFAULT 0,
  `meta_title` varchar(70) DEFAULT NULL,
  `meta_description` varchar(180) DEFAULT NULL,
  `focus_keyword` varchar(100) DEFAULT NULL,
  `canonical_url` varchar(500) DEFAULT NULL,
  `og_title` varchar(200) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` varchar(500) DEFAULT NULL,
  `og_type` varchar(50) DEFAULT 'website',
  `twitter_title` varchar(200) DEFAULT NULL,
  `twitter_description` text DEFAULT NULL,
  `twitter_card` varchar(50) DEFAULT 'summary_large_image',
  `robots_meta` varchar(50) DEFAULT 'index,follow',
  `schema_type` varchar(50) DEFAULT 'MedicalProcedure',
  `schema_json` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_blog_cat` (`categories`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_services`
--
ALTER TABLE `doctor_services`
  ADD PRIMARY KEY (`doctor_id`,`service_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `mosquito_services`
--
ALTER TABLE `mosquito_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mosquito_services`
--
ALTER TABLE `mosquito_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `fk_blog_cat` FOREIGN KEY (`categories`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `doctor_services`
--
ALTER TABLE `doctor_services`
  ADD CONSTRAINT `doctor_services_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
