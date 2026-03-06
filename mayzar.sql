-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 02:31 PM
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
-- Database: `mayzar`
--

-- --------------------------------------------------------

--
-- Table structure for table `compro_clients`
--

CREATE TABLE `compro_clients` (
  `id` int(11) NOT NULL,
  `anchor_id` varchar(50) DEFAULT 'clients',
  `title` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_clients`
--

INSERT INTO `compro_clients` (`id`, `anchor_id`, `title`, `updated_at`) VALUES
(1, 'clients', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                <span class=\"color-blue4\">Trusted by 5,000+</span> Retail &amp; Enterprise Businesses                                                                                                ', '2026-02-23 13:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `compro_clients_logos`
--

CREATE TABLE `compro_clients_logos` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT 1,
  `logo_path` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_clients_logos`
--

INSERT INTO `compro_clients_logos` (`id`, `client_id`, `logo_path`, `sort_order`) VALUES
(34, 1, '/assets/img/wikipedia.png', 0),
(35, 1, '/assets/img/youtube.png', 1),
(36, 1, '/assets/img/fb.png', 2),
(37, 1, '/assets/img/google.png', 3),
(38, 1, '/assets/img/fb.png', 4),
(39, 1, '/assets/img/fb.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `compro_community`
--

CREATE TABLE `compro_community` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'community',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_community`
--

INSERT INTO `compro_community` (`id`, `anchor_id`, `tagline`, `title`, `updated_at`) VALUES
(1, 'community', '\r\n                Mayzar Network            ', '\r\n                Join Our <span>Partner Network</span>            ', '2026-02-23 05:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `compro_community_list`
--

CREATE TABLE `compro_community_list` (
  `id` int(11) NOT NULL,
  `community_id` int(11) DEFAULT 1,
  `icon` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_community_list`
--

INSERT INTO `compro_community_list` (`id`, `community_id`, `icon`, `title`, `description`, `url`, `sort_order`) VALUES
(4, 1, 'bi bi-wordpress', '\r\n                Developer API            ', '\r\n                Integrate our POS with your custom solutions            ', '', 0),
(5, 1, 'bi bi-kanban', '\r\n                Help Center            ', '\r\n                Comprehensive guides for our ERP modules            ', '', 1),
(6, 1, 'bi bi-puzzle', '\r\n                Community Forum            ', '\r\n                Discuss business strategies with other Mayzar users            ', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `compro_download`
--

CREATE TABLE `compro_download` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'download',
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_download`
--

INSERT INTO `compro_download` (`id`, `anchor_id`, `title`, `description`, `updated_at`) VALUES
(1, 'download', '\r\n                Start Scaling <span>Today</span>            ', '\r\n                Download our native POS applications for your retail hardware or access the Cloud ERP via any web browser.            ', '2026-02-23 05:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `compro_download_buttons`
--

CREATE TABLE `compro_download_buttons` (
  `id` int(11) NOT NULL,
  `download_id` int(11) DEFAULT 1,
  `icon` varchar(100) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_download_buttons`
--

INSERT INTO `compro_download_buttons` (`id`, `download_id`, `icon`, `text`, `url`, `is_primary`, `sort_order`) VALUES
(4, 1, 'bi bi-windows', 'Windows POS', '', 0, 0),
(5, 1, 'bi bi-android2', 'Android POS', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `compro_faq`
--

CREATE TABLE `compro_faq` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'faq',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_faq`
--

INSERT INTO `compro_faq` (`id`, `anchor_id`, `tagline`, `title`, `updated_at`) VALUES
(1, 'faq', 'Frequently Asked Questions', 'Need <span>Assistance?</span>', '2026-02-23 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `compro_faq_list`
--

CREATE TABLE `compro_faq_list` (
  `id` int(11) NOT NULL,
  `faq_id` int(11) DEFAULT 1,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_faq_list`
--

INSERT INTO `compro_faq_list` (`id`, `faq_id`, `question`, `answer`, `sort_order`) VALUES
(1, 1, 'Can the POS work offline?', 'Yes, our POS application has an offline mode. It stores transactions locally and automatically syncs with the Cloud ERP once the connection is restored.', 0),
(2, 1, 'Does the ERP support multi-branch management?', 'Absolutely. Mayzar is built for scalability, allowing you to manage inventory, sales, and employees across multiple locations from a single centralized dashboard.', 1),
(3, 1, 'Is hardware included with the POS software?', 'We provide the software, but it is compatible with most standard POS hardware, including barcode scanners, receipt printers, and cash drawers.', 2),
(4, 1, 'How secure is my financial data?', 'We use enterprise-grade encryption and daily automated backups to ensure your financial and operational data is always secure and compliant with industry standards.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `compro_features`
--

CREATE TABLE `compro_features` (
  `id` int(11) NOT NULL,
  `anchor_id` varchar(50) DEFAULT 'features',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_features`
--

INSERT INTO `compro_features` (`id`, `anchor_id`, `tagline`, `title`, `updated_at`) VALUES
(1, 'features', '\r\n                \r\n                \r\n                \r\n                \r\n                Mayzar - Comprehensive Business Management                                                            ', '\r\n                \r\n                \r\n                \r\n                \r\n                Powerful <span>Capabilities</span>                                                            ', '2026-02-23 13:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `compro_features_items`
--

CREATE TABLE `compro_features_items` (
  `id` int(11) NOT NULL,
  `feature_id` int(11) DEFAULT 1,
  `icon` varchar(255) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `label_color` varchar(20) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_features_items`
--

INSERT INTO `compro_features_items` (`id`, `feature_id`, `icon`, `title`, `label`, `label_color`, `sort_order`) VALUES
(21, 1, '/assets/img/inventory.png', '\r\n                \r\n                \r\n                \r\n                Real-Time Inventory<br>Tracking                                                ', '', '#1b4d82', 0),
(22, 1, '/assets/img/point-of-sale.png', '\r\n                \r\n                \r\n                \r\n                Omnichannel<br>Point of Sale                                                ', 'new', '#d9d336', 1),
(23, 1, '/assets/img/accounting.png', '\r\n                \r\n                \r\n                \r\n                Integrated<br>Accounting                                                ', '', '#1b4d82', 2),
(24, 1, '/assets/img/management.png', '\r\n                \r\n                \r\n                \r\n                HR &amp; Employee<br>Management                                                ', '', '#1b4d82', 3),
(25, 1, '/assets/img/analysis.png', '\r\n                \r\n                \r\n                \r\n                Advanced Analytics<br>&amp; Reporting                                                ', 'new', '#1b4d82', 4);

-- --------------------------------------------------------

--
-- Table structure for table `compro_footer`
--

CREATE TABLE `compro_footer` (
  `id` int(11) NOT NULL DEFAULT 1,
  `copyright` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_footer`
--

INSERT INTO `compro_footer` (`id`, `copyright`, `updated_at`) VALUES
(1, '\r\n                \r\n                © 2026 Copyrights by Mayzar. All Rights Reserved.                        ', '2026-02-23 12:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `compro_footer_links`
--

CREATE TABLE `compro_footer_links` (
  `id` int(11) NOT NULL,
  `footer_id` int(11) DEFAULT 1,
  `label` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_footer_links`
--

INSERT INTO `compro_footer_links` (`id`, `footer_id`, `label`, `url`, `sort_order`) VALUES
(13, 1, 'Privacy Policy', 'privacy', 0),
(14, 1, 'Terms of Service', 'terms', 1),
(15, 1, 'Partner Portal', 'https://google.com/', 2),
(16, 1, 'About Us', 'about', 3),
(17, 1, 'Contact Us', 'contact', 4);

-- --------------------------------------------------------

--
-- Table structure for table `compro_header`
--

CREATE TABLE `compro_header` (
  `id` int(11) NOT NULL DEFAULT 1,
  `top_bar_show` tinyint(1) DEFAULT 1,
  `top_bar_badge` varchar(255) DEFAULT '',
  `top_bar_icon` varchar(100) DEFAULT '',
  `top_bar_text` text DEFAULT NULL,
  `top_bar_link_text` varchar(255) DEFAULT '',
  `top_bar_link_url` varchar(255) DEFAULT '',
  `cta_text` varchar(255) DEFAULT '',
  `cta_url` varchar(255) DEFAULT '',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_header`
--

INSERT INTO `compro_header` (`id`, `top_bar_show`, `top_bar_badge`, `top_bar_icon`, `top_bar_text`, `top_bar_link_text`, `top_bar_link_url`, `cta_text`, `cta_url`, `updated_at`) VALUES
(1, 1, 'Update', '', 'New Module Released: Advanced Supply Chain Management', 'Read Docs', '', 'Request a Demo', '', '2026-02-23 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `compro_header_nav_links`
--

CREATE TABLE `compro_header_nav_links` (
  `id` int(11) NOT NULL,
  `header_id` int(11) DEFAULT 1,
  `label` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT '',
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_header_nav_links`
--

INSERT INTO `compro_header_nav_links` (`id`, `header_id`, `label`, `url`, `icon`, `sort_order`) VALUES
(21, 1, 'Home', '#home', '', 0),
(22, 1, 'Solutions', '#clients', '', 1),
(23, 1, 'Features', '#features', '', 2),
(24, 1, 'Pricing', '#pricing', '', 3),
(25, 1, 'Contact', 'contact', '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `compro_hero`
--

CREATE TABLE `compro_hero` (
  `id` int(11) NOT NULL,
  `anchor_id` varchar(50) DEFAULT 'hero',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `app_store_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_icon` varchar(100) DEFAULT NULL,
  `main_image` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_hero`
--

INSERT INTO `compro_hero` (`id`, `anchor_id`, `tagline`, `title`, `description`, `app_store_url`, `video_url`, `button_text`, `button_icon`, `main_image`, `updated_at`) VALUES
(1, 'hero', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Mayzar - Enterprise Resource Planning &amp; POS                                                                                                            ', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Manage <span>Your Entire Business</span> In One Place                                                                                                            ', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Streamline operations, boost sales, and gain real-time insights with our unified ERP and POS platform built for modern enterprises.                                                                                                            ', 'https://www.apple.com/app-store', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'Get Started', 'bi-send-fill', '/assets/img/mAYZAR.jpg', '2026-02-23 12:56:45');

-- --------------------------------------------------------

--
-- Table structure for table `compro_hero_features`
--

CREATE TABLE `compro_hero_features` (
  `id` int(11) NOT NULL,
  `hero_id` int(11) DEFAULT 1,
  `icon` varchar(100) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_hero_features`
--

INSERT INTO `compro_hero_features` (`id`, `hero_id`, `icon`, `text`, `sort_order`) VALUES
(15, 1, 'bi-heart-pulse', 'Free 14 Days Trial', 0),
(16, 1, 'bi-hospital', 'Cloud-Based Data Sync', 1);

-- --------------------------------------------------------

--
-- Table structure for table `compro_integrations`
--

CREATE TABLE `compro_integrations` (
  `id` int(11) NOT NULL,
  `anchor_id` varchar(50) DEFAULT 'integrations',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_integrations`
--

INSERT INTO `compro_integrations` (`id`, `anchor_id`, `tagline`, `title`, `description`, `updated_at`) VALUES
(1, 'integrations', '\r\n                \r\n                \r\n                \r\n                Seamless Connectivity                                                ', '\r\n                \r\n                \r\n                \r\n                Integrates With <span>Your Favorite Tools</span>                                                ', '\r\n                \r\n                \r\n                \r\n                Mayzar connects seamlessly with payment gateways, e-commerce platforms, and logistics providers to keep your workflow uninterrupted.                                                ', '2026-02-23 13:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `compro_integrations_items`
--

CREATE TABLE `compro_integrations_items` (
  `id` int(11) NOT NULL,
  `integration_id` int(11) DEFAULT 1,
  `image` text DEFAULT NULL,
  `spacing` int(11) DEFAULT 30,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_integrations_items`
--

INSERT INTO `compro_integrations_items` (`id`, `integration_id`, `image`, `spacing`, `sort_order`) VALUES
(15, 1, '/assets/img/mcdonalds.png', 30, 0),
(16, 1, '/assets/img/burger-king.png', 30, 1),
(17, 1, '/assets/img/starbucks.png', 30, 2),
(18, 1, '/assets/img/erp.png', 30, 3),
(19, 1, '/assets/img/POA.png', 30, 4);

-- --------------------------------------------------------

--
-- Table structure for table `compro_modules`
--

CREATE TABLE `compro_modules` (
  `id` int(11) NOT NULL,
  `module_id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_modules`
--

INSERT INTO `compro_modules` (`id`, `module_id`, `name`, `visible`, `sort_order`) VALUES
(79, 'hero', 'Hero Section', 1, 0),
(80, 'clients', 'Clients Section', 1, 1),
(81, 'products', 'Products Section', 1, 2),
(82, 'features', 'Features Section', 1, 3),
(83, 'integrations', 'Integrations', 1, 4),
(84, 'security', 'Security Management', 1, 5),
(85, 'themes', 'Dashboard Section', 1, 6),
(86, 'screenshots', 'Screenshot Slider', 1, 7),
(87, 'testimonials', 'Testimonials', 1, 8),
(88, 'pricing', 'Pricing', 1, 9),
(89, 'faq', 'FAQ', 1, 10),
(90, 'community', 'Community Hub', 1, 11),
(91, 'download', 'Download Section', 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `compro_pages`
--

CREATE TABLE `compro_pages` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_pages`
--

INSERT INTO `compro_pages` (`id`, `slug`, `title`, `description`, `content`, `updated_at`) VALUES
(1, 'about', '\r\n                \r\n                About Our <span>Enterprise</span>                        ', '\r\n\r\n<h2>Welcome to Mayzar</h2>\r\n<p>\r\nMayzar is a technology-driven company focused on delivering modern, reliable, and scalable business software solutions. We specialize in developing ERP (Enterprise Resource Planning) and POS (Point of Sale) systems designed to simplify operations and improve efficiency for businesses of all sizes.\r\n</p>\r\n\r\n<h2>Our Mission</h2>\r\n<p>\r\nOur mission is to empower businesses through smart, practical, and affordable digital solutions. We aim to streamline workflows, improve data accuracy, and help organizations make better decisions through integrated systems.\r\n</p>\r\n\r\n<h2>What We Do</h2>\r\n<ul>\r\n<li>ERP system development and customization</li>\r\n<li>POS application solutions</li>\r\n<li>Business process automation</li>\r\n<li>System integration and data management</li>\r\n<li>Technical support and system maintenance</li>\r\n</ul>\r\n\r\n<h2>Our Approach</h2>\r\n<p>\r\nAt Mayzar, we believe technology should work for people — not the other way around. Our approach focuses on:\r\n</p>\r\n<ul>\r\n<li>Understanding real business needs</li>\r\n<li>Building user-friendly interfaces</li>\r\n<li>Ensuring system reliability and security</li>\r\n<li>Providing continuous improvement and support</li>\r\n</ul>\r\n\r\n<h2>Why Choose Mayzar</h2>\r\n<ul>\r\n<li>Scalable solutions tailored to your business</li>\r\n<li>Efficient and structured system architecture</li>\r\n<li>Cost-effective implementation</li>\r\n<li>Dedicated technical support</li>\r\n</ul>\r\n\r\n<h2>Our Vision</h2>\r\n<p>\r\nWe envision a future where businesses of all sizes can access powerful digital tools without complexity. Mayzar strives to become a trusted partner in digital transformation, helping companies grow sustainably through technology.\r\n</p>\r\n\r\n<h2>Contact Us</h2>\r\n<p>\r\nWe are always open to collaboration and partnership opportunities. If you would like to learn more about our services or discuss your project needs, feel free to reach out.\r\n</p>\r\n\r\n<ul>\r\n<li>Email: [info@mayzar.com]</li>\r\n<li>Phone: [Insert Phone Number]</li>\r\n<li>Address: [Insert Company Address]</li>\r\n</ul>\r\n', '', '2026-02-23 12:35:55'),
(2, 'contact', '\r\n                \r\n                Get In <span>Touch</span>                        ', 'We\'re here to help you scale your business. Reach out to us anytime.', '<div class=\"contact-cards py-5\">\r\n    <div class=\"row g-4\">\r\n\r\n        <!-- Email -->\r\n        <div class=\"col-lg-4\">\r\n            <div class=\"contact-card text-center p-4 h-100\">\r\n                <div class=\"icon-wrapper mb-3\">\r\n                    <i class=\"bi bi-envelope\"></i>\r\n                </div>\r\n                <h5 class=\"fw-bold mb-2\">Email Us</h5>\r\n                <p class=\"text-muted mb-3\">Have questions? Send us an email anytime.</p>\r\n                <a href=\"mailto:support@mayzar.com\" class=\"contact-link\">\r\n                    support@mayzar.com\r\n                </a>\r\n            </div>\r\n        </div>\r\n\r\n        <!-- Address -->\r\n        <div class=\"col-lg-4\">\r\n            <div class=\"contact-card text-center p-4 h-100\">\r\n                <div class=\"icon-wrapper mb-3\">\r\n                    <i class=\"bi bi-geo-alt\"></i>\r\n                </div>\r\n                <h5 class=\"fw-bold mb-2\">Visit Us</h5>\r\n                <p class=\"text-muted mb-3\">We welcome you to our office.</p>\r\n                <p class=\"contact-link mb-0\">\r\n                    123 Enterprise Way,<br>Tech City\r\n                </p>\r\n            </div>\r\n        </div>\r\n\r\n        <!-- Phone -->\r\n        <div class=\"col-lg-4\">\r\n            <div class=\"contact-card text-center p-4 h-100\">\r\n                <div class=\"icon-wrapper mb-3\">\r\n                    <i class=\"bi bi-telephone\"></i>\r\n                </div>\r\n                <h5 class=\"fw-bold mb-2\">Call Us</h5>\r\n                <p class=\"text-muted mb-3\">Speak directly with our team.</p>\r\n                <a href=\"tel:+12345678910\" class=\"contact-link\">\r\n                    +1 (234) 567-8910\r\n                </a>\r\n            </div>\r\n        </div>\r\n\r\n    </div>\r\n</div>\r\n\r\n<style>\r\n.contact-card {\r\n    background: #ffffff;\r\n    border-radius: 16px;\r\n    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);\r\n    transition: all 0.3s ease;\r\n    border: 1px solid #f1f1f1;\r\n}\r\n\r\n.contact-card:hover {\r\n    transform: translateY(-8px);\r\n    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);\r\n}\r\n\r\n.icon-wrapper {\r\n    width: 70px;\r\n    height: 70px;\r\n    margin: 0 auto;\r\n    border-radius: 50%;\r\n    background: linear-gradient(135deg, #0d6efd, #4f8cff);\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n}\r\n\r\n.icon-wrapper i {\r\n    font-size: 28px;\r\n    color: #ffffff;\r\n}\r\n\r\n.contact-link {\r\n    font-weight: 500;\r\n    color: #0d6efd;\r\n    text-decoration: none;\r\n    transition: color 0.3s ease;\r\n}\r\n\r\n.contact-link:hover {\r\n    color: #0a58ca;\r\n    text-decoration: underline;\r\n}\r\n</style>', '2026-02-23 12:38:32'),
(3, 'privacy', '\r\n                \r\n                \r\n                \r\n                \r\n                Privacy <span>Policy</span>                                                            ', 'Your privacy is our priority. Learn how we handle your data.', '\r\n                <p><strong>Company Name:</strong> Mayzar</p>\r\n<p><strong>Effective Date:</strong>&nbsp;Feb 23, 2026</p>\r\n\r\n<h2>1. Introduction</h2>\r\n<p>\r\nMayzar (\"we\", \"our\", or \"us\") values your privacy. This Privacy Policy explains how we collect, use, store, and protect your information when you use our website, applications, and services.\r\n</p>\r\n<p>\r\nBy accessing or using our services, you agree to the collection and use of information in accordance with this policy.\r\n</p>\r\n\r\n<h2>2. Information We Collect</h2>\r\n\r\n<h3>2.1 Personal Information</h3>\r\n<p>We may collect personal information that you voluntarily provide, including but not limited to:</p>\r\n<ul>\r\n<li>Full name</li>\r\n<li>Email address</li>\r\n<li>Phone number</li>\r\n<li>Company name</li>\r\n<li>Billing and payment details</li>\r\n</ul>\r\n\r\n<h3>2.2 Non-Personal Information</h3>\r\n<p>We may automatically collect certain non-personal information such as:</p>\r\n<ul>\r\n<li>IP address</li>\r\n<li>Browser type and version</li>\r\n<li>Device information</li>\r\n<li>Pages visited and time spent</li>\r\n<li>Cookies and usage data</li>\r\n</ul>\r\n\r\n<h2>3. How We Use Your Information</h2>\r\n<p>Mayzar may use collected information for the following purposes:</p>\r\n<ul>\r\n<li>To provide and maintain our services</li>\r\n<li>To process transactions</li>\r\n<li>To improve user experience</li>\r\n<li>To send service-related notifications</li>\r\n<li>To provide customer support</li>\r\n<li>To comply with legal obligations</li>\r\n</ul>\r\n\r\n<h2>4. Cookies and Tracking Technologies</h2>\r\n<p>\r\nWe may use cookies and similar tracking technologies to enhance your browsing experience, analyze site traffic, and understand user behavior. You may disable cookies through your browser settings; however, some features may not function properly.\r\n</p>\r\n\r\n<h2>5. Data Sharing and Disclosure</h2>\r\n<p>\r\nMayzar does not sell, trade, or rent your personal information to third parties. We may share information with:\r\n</p>\r\n<ul>\r\n<li>Service providers and partners who assist in operating our services</li>\r\n<li>Legal authorities when required by law</li>\r\n<li>Business successors in case of merger, acquisition, or asset sale</li>\r\n</ul>\r\n\r\n<h2>6. Data Security</h2>\r\n<p>\r\nWe implement reasonable technical and organizational measures to protect your information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet is 100% secure.\r\n</p>\r\n\r\n<h2>7. Data Retention</h2>\r\n<p>\r\nWe retain personal information only for as long as necessary to fulfill the purposes outlined in this policy, unless a longer retention period is required or permitted by law.\r\n</p>\r\n\r\n<h2>8. Your Rights</h2>\r\n<p>\r\nDepending on your jurisdiction, you may have the right to:\r\n</p>\r\n<ul>\r\n<li>Access the personal data we hold about you</li>\r\n<li>Request correction of inaccurate information</li>\r\n<li>Request deletion of your data</li>\r\n<li>Object to or restrict certain processing activities</li>\r\n<li>Withdraw consent at any time</li>\r\n</ul>\r\n\r\n<h2>9. Third-Party Links</h2>\r\n<p>\r\nOur services may contain links to third-party websites. We are not responsible for the privacy practices or content of such external sites.\r\n</p>\r\n\r\n<h2>10. Children\'s Privacy</h2>\r\n<p>\r\nOur services are not intended for individuals under the age of 13. We do not knowingly collect personal information from children.\r\n</p>\r\n\r\n<h2>11. Changes to This Privacy Policy</h2>\r\n<p>\r\nMayzar reserves the right to update or modify this Privacy Policy at any time. Changes will be posted on this page with an updated effective date.\r\n</p>\r\n\r\n<h2>12. Contact Us</h2>\r\n<p>\r\nIf you have any questions about this Privacy Policy, you may contact us at:\r\n</p>\r\n<ul>\r\n<li>Email: [privacy@mayzar.com]</li>\r\n<li>Address: Jln. Jendral Sudirman Kav. 123 </li>\r\n</ul>\r\n\r\n<p>\r\nBy continuing to use our services, you acknowledge that you have read and understood this Privacy Policy.\r\n</p>\r\n                        ', '2026-02-23 12:31:37'),
(4, 'terms', '\r\n                \r\n                \r\n                \r\n                Terms Of <span>Service</span>                                                ', 'Guidelines for using our platforms and services.', '<p><strong>Company Name:</strong> Mayzar</p>\r\n<p><strong>Effective Date:</strong> Feb 23, 2026</p>\r\n\r\n<h2>1. Acceptance of Terms</h2>\r\n<p>\r\nBy accessing or using the website, applications, or services provided by Mayzar (\"Company\", \"we\", \"our\", or \"us\"), you agree to be bound by these Terms of Service (\"Terms\"). If you do not agree to these Terms, you must not use our services.\r\n</p>\r\n\r\n<h2>2. Description of Services</h2>\r\n<p>\r\nMayzar provides software solutions, including but not limited to ERP, POS systems, and related business management tools. We reserve the right to modify, suspend, or discontinue any part of the services at any time without prior notice.\r\n</p>\r\n\r\n<h2>3. User Accounts</h2>\r\n<p>\r\nTo access certain features, you may be required to create an account. You agree to:\r\n</p>\r\n<ul>\r\n<li>Provide accurate and complete information</li>\r\n<li>Maintain the confidentiality of your login credentials</li>\r\n<li>Accept responsibility for all activities under your account</li>\r\n</ul>\r\n<p>\r\nWe reserve the right to suspend or terminate accounts that violate these Terms.\r\n</p>\r\n\r\n<h2>4. Payment and Fees</h2>\r\n<p>\r\nCertain services may require payment. By purchasing our services, you agree to:\r\n</p>\r\n<ul>\r\n<li>Pay all applicable fees and taxes</li>\r\n<li>Provide valid payment information</li>\r\n<li>Authorize us to charge your selected payment method</li>\r\n</ul>\r\n<p>\r\nAll fees are non-refundable unless otherwise stated in writing.\r\n</p>\r\n\r\n<h2>5. Acceptable Use</h2>\r\n<p>\r\nYou agree not to:\r\n</p>\r\n<ul>\r\n<li>Use the services for unlawful purposes</li>\r\n<li>Attempt to gain unauthorized access to systems or data</li>\r\n<li>Interfere with or disrupt the integrity of the services</li>\r\n<li>Upload malicious code, viruses, or harmful content</li>\r\n<li>Reverse engineer or attempt to extract source code without authorization</li>\r\n</ul>\r\n\r\n<h2>6. Intellectual Property</h2>\r\n<p>\r\nAll content, software, trademarks, logos, and materials provided by Mayzar are the intellectual property of the Company or its licensors. You are granted a limited, non-exclusive, non-transferable license to use the services for business purposes in accordance with these Terms.\r\n</p>\r\n\r\n<h2>7. Data and User Content</h2>\r\n<p>\r\nYou retain ownership of any data you input into the system. By using our services, you grant Mayzar a limited license to process and store your data solely for the purpose of providing the services.\r\n</p>\r\n<p>\r\nYou are solely responsible for the accuracy, legality, and integrity of your data.\r\n</p>\r\n\r\n<h2>8. Service Availability</h2>\r\n<p>\r\nWe strive to ensure continuous availability but do not guarantee uninterrupted or error-free operation. Maintenance, updates, or unforeseen technical issues may cause temporary service disruptions.\r\n</p>\r\n\r\n<h2>9. Limitation of Liability</h2>\r\n<p>\r\nTo the maximum extent permitted by law, Mayzar shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including loss of profits, data, or business opportunities arising from the use or inability to use our services.\r\n</p>\r\n<p>\r\nOur total liability for any claim related to the services shall not exceed the amount paid by you to Mayzar in the twelve (12) months preceding the claim.\r\n</p>\r\n\r\n<h2>10. Indemnification</h2>\r\n<p>\r\nYou agree to indemnify and hold harmless Mayzar, its directors, employees, and affiliates from any claims, damages, losses, liabilities, and expenses arising out of your use of the services or violation of these Terms.\r\n</p>\r\n\r\n<h2>11. Termination</h2>\r\n<p>\r\nWe may suspend or terminate your access to the services at our discretion if you violate these Terms. Upon termination, your right to use the services will immediately cease.\r\n</p>\r\n\r\n<h2>12. Governing Law</h2>\r\n<p>\r\nThese Terms shall be governed by and construed in accordance with the laws of [Insert Jurisdiction], without regard to conflict of law principles.\r\n</p>\r\n\r\n<h2>13. Changes to Terms</h2>\r\n<p>\r\nMayzar reserves the right to update or modify these Terms at any time. Continued use of the services after changes are posted constitutes acceptance of the revised Terms.\r\n</p>\r\n\r\n<h2>14. Contact Information</h2>\r\n<p>\r\nIf you have questions about these Terms of Service, please contact us at:\r\n</p>\r\n<ul>\r\n<li>Email: [support@mayzar.com]</li>\r\n<li>Address: [Insert Company Address]</li>\r\n</ul>\r\n\r\n<p>\r\nBy using our services, you acknowledge that you have read, understood, and agreed to these Terms of Service.\r\n</p>\r\n', '2026-02-23 12:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `compro_pricing`
--

CREATE TABLE `compro_pricing` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'pricing',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_pricing`
--

INSERT INTO `compro_pricing` (`id`, `anchor_id`, `tagline`, `title`, `updated_at`) VALUES
(1, 'pricing', '\r\n                \r\n                \r\n                \r\n                Mayzar - Scalable Solutions                                                ', '\r\n                \r\n                \r\n                \r\n                Transparent <span>Pricing Plans</span>                                                ', '2026-02-23 05:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `compro_pricing_features`
--

CREATE TABLE `compro_pricing_features` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_pricing_features`
--

INSERT INTO `compro_pricing_features` (`id`, `plan_id`, `icon`, `text`, `active`, `sort_order`) VALUES
(49, 13, '', '\r\n                \r\n                \r\n                \r\n                1 Store Location                                                ', 1, 0),
(50, 13, '', '\r\n                \r\n                \r\n                \r\n                Basic POS Functions                                                ', 1, 1),
(51, 13, '', '\r\n                \r\n                \r\n                \r\n                Standard Inventory                                                ', 1, 2),
(52, 13, '', '\r\n                \r\n                \r\n                \r\n                Advanced ERP Modules                                                ', 0, 3),
(53, 14, '', '\r\n                \r\n                \r\n                \r\n                Up to 5 Store Locations                                                ', 1, 0),
(54, 14, '', '\r\n                \r\n                \r\n                \r\n                Advanced POS &amp; Barcode                                                ', 1, 1),
(55, 14, '', '\r\n                \r\n                \r\n                \r\n                Multi-warehouse Inventory                                                ', 1, 2),
(56, 14, '', '\r\n                \r\n                \r\n                \r\n                Financial Accounting                                                ', 1, 3),
(57, 15, '', '\r\n                \r\n                \r\n                \r\n                Unlimited Locations                                                ', 1, 0),
(58, 15, '', '\r\n                \r\n                \r\n                \r\n                Custom ERP Implementations                                                ', 1, 1),
(59, 15, '', '\r\n                \r\n                \r\n                \r\n                Dedicated Account Manager                                                ', 1, 2),
(60, 15, '', '\r\n                \r\n                \r\n                \r\n                Priority 24/7 Support                                                ', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `compro_pricing_plans`
--

CREATE TABLE `compro_pricing_plans` (
  `id` int(11) NOT NULL,
  `pricing_id` int(11) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `period` varchar(50) DEFAULT 'month',
  `description` text DEFAULT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `is_popular` tinyint(1) DEFAULT 0,
  `off_text` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_pricing_plans`
--

INSERT INTO `compro_pricing_plans` (`id`, `pricing_id`, `name`, `icon`, `price`, `period`, `description`, `button_text`, `button_url`, `is_popular`, `off_text`, `sort_order`) VALUES
(13, 1, 'Starter POS', '/assets/img/must-have.png', '999k', 'month', '\r\n                \r\n                \r\n                \r\n                Perfect for single-store retailers.                                                ', 'Start Trial', '', 0, '\r\n                \r\n                \r\n                \r\n                                            ', 0),
(14, 1, 'Professional ERP', '/assets/img/crown.png', '2499k', 'month', '\r\n                \r\n                \r\n                \r\n                Complete ERP &amp; POS for growing businesses.                                                ', 'Choose Pro', '', 1, 'Popular', 1),
(15, 1, 'Enterprise', '/assets/img/enterprise.png', '7999k', 'month', '\r\n                \r\n                \r\n                \r\n                Tailored solutions for large organizations.                                                ', 'Contact Sales', '', 0, '\r\n                \r\n                \r\n                \r\n                                            ', 2);

-- --------------------------------------------------------

--
-- Table structure for table `compro_products`
--

CREATE TABLE `compro_products` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'products',
  `header_slogan` text DEFAULT NULL,
  `header_title` text DEFAULT NULL,
  `header_desc` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_products`
--

INSERT INTO `compro_products` (`id`, `anchor_id`, `header_slogan`, `header_title`, `header_desc`, `updated_at`) VALUES
(1, 'products', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Core Offerings                                                                        ', '\r\n                \r\n                \r\n                Unified Solutions for <span>Retail &amp; Management</span>                                                                        ', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Discover our core modules designed to handle everything from front-desk sales to back-office accounting.                                                                        ', '2026-02-23 13:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `compro_product_features`
--

CREATE TABLE `compro_product_features` (
  `id` int(11) NOT NULL,
  `tab_id` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_product_features`
--

INSERT INTO `compro_product_features` (`id`, `tab_id`, `icon`, `text`, `sort_order`) VALUES
(37, 13, 'bi-bag-fill', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Automated accounting and tax calculation                                                                        ', 0),
(38, 13, 'bi-cart', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Multi-level warehouse and stock management                                                                        ', 1),
(39, 13, 'bi-credit-card', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Payroll processing and HR management                                                                        ', 2),
(40, 14, 'bi-phone', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Fast, intuitive touchscreen interface                                                                        ', 0),
(41, 14, 'bi-printer', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Barcode scanning and receipt printing                                                                        ', 1),
(42, 14, 'bi-cash-stack', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Customer loyalty and reward programs                                                                        ', 2);

-- --------------------------------------------------------

--
-- Table structure for table `compro_product_tabs`
--

CREATE TABLE `compro_product_tabs` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT 1,
  `nav_label` varchar(255) DEFAULT NULL,
  `nav_icon` varchar(100) DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `side_slogan` text DEFAULT NULL,
  `side_title` text DEFAULT NULL,
  `side_desc` text DEFAULT NULL,
  `btn_text` varchar(100) DEFAULT NULL,
  `btn_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_product_tabs`
--

INSERT INTO `compro_product_tabs` (`id`, `product_id`, `nav_label`, `nav_icon`, `main_image`, `side_slogan`, `side_title`, `side_desc`, `btn_text`, `btn_url`, `sort_order`) VALUES
(13, 1, 'Cloud ERP', 'bi-kanban', '/assets/img/erp.jpg', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Back-Office Mastery                                                                        ', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Complete Control Over Your Enterprise                                                                        ', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Our cloud ERP seamlessly connects your finance, inventory, and human resources into a single, reliable database.                                                                        ', 'Explore ERP', '', 0),
(14, 1, 'Smart POS', 'bi-gpu-card', '/assets/img/pos.jpg', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Front-End Excellence                                                                        ', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Lightning Fast Transactions                                                                        ', '\r\n                \r\n                \r\n                \r\n                \r\n                \r\n                Empower your cashiers with a responsive, easy-to-learn Point of Sale system built for high-volume retail environments.                                                                        ', 'Explore POS', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `compro_roles`
--

CREATE TABLE `compro_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_roles`
--

INSERT INTO `compro_roles` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Full access to all settings and content.'),
(2, 'Editor', 'Can edit content but cannot manage users or settings.');

-- --------------------------------------------------------

--
-- Table structure for table `compro_screenshots`
--

CREATE TABLE `compro_screenshots` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'screenshots',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_screenshots`
--

INSERT INTO `compro_screenshots` (`id`, `anchor_id`, `updated_at`) VALUES
(1, 'screenshots', '2026-02-23 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `compro_screenshots_items`
--

CREATE TABLE `compro_screenshots_items` (
  `id` int(11) NOT NULL,
  `screenshot_id` int(11) DEFAULT 1,
  `image_path` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_screenshots_items`
--

INSERT INTO `compro_screenshots_items` (`id`, `screenshot_id`, `image_path`, `sort_order`) VALUES
(5, 1, '/assets/img/Screenshot_20260223-123212_Brave.jpg', 0),
(6, 1, '/assets/img/Screenshot_20260223-123222_Settings.jpg', 1),
(7, 1, '/assets/img/Screenshot_20260223-123254_Drive.jpg', 2),
(8, 1, '/assets/img/Screenshot_20260223-123303_Google Play Store.jpg', 3),
(9, 1, '/assets/img/Screenshot_20260223-123339_YouTube.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `compro_security`
--

CREATE TABLE `compro_security` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'security',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `btn_url` varchar(255) DEFAULT NULL,
  `btn_label` varchar(100) DEFAULT NULL,
  `btn_small` varchar(255) DEFAULT NULL,
  `show_btn` tinyint(1) DEFAULT 1,
  `btn_icon` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_security`
--

INSERT INTO `compro_security` (`id`, `anchor_id`, `tagline`, `title`, `description`, `btn_url`, `btn_label`, `btn_small`, `show_btn`, `btn_icon`, `updated_at`) VALUES
(1, 'security', '\r\n                \r\n                Bank-Grade Protection                        ', '\r\n                \r\n                Your Business Data <span>Secured</span>                        ', 'We employ state-of-the-art security protocols to ensure your financial records, inventory data, and customer information are safe from unauthorized access.', '', 'View Security Docs', 'Read more in our', 1, '/assets/img/fav.png', '2026-02-23 13:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `compro_security_items`
--

CREATE TABLE `compro_security_items` (
  `id` int(11) NOT NULL,
  `security_id` int(11) DEFAULT 1,
  `title` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_security_items`
--

INSERT INTO `compro_security_items` (`id`, `security_id`, `title`, `content`, `sort_order`) VALUES
(7, 1, 'Role-Based Access', 'Assign precise permissions to your staff, ensuring they only see what they need.', 0),
(8, 1, 'Automated Backups', 'Your database is backed up daily to secure cloud servers to prevent data loss.', 0),
(9, 1, 'Compliance Standards', 'Designed to meet local and international accounting and data privacy regulations.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `compro_settings`
--

CREATE TABLE `compro_settings` (
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_settings`
--

INSERT INTO `compro_settings` (`key`, `value`) VALUES
('from_email', ''),
('from_name', ''),
('site_favicon', '/assets/img/mayzar.png'),
('site_logo', '/assets/img/cms/1771850975_mayzar landscape.png'),
('site_name', 'Mayzar'),
('site_tagline', 'Enterprise ERP & POS Solutions'),
('smtp_encryption', 'tls'),
('smtp_host', ''),
('smtp_pass', ''),
('smtp_port', '587'),
('smtp_user', '');

-- --------------------------------------------------------

--
-- Table structure for table `compro_testimonials`
--

CREATE TABLE `compro_testimonials` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'testimonials',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_testimonials`
--

INSERT INTO `compro_testimonials` (`id`, `anchor_id`, `tagline`, `title`, `description`, `updated_at`) VALUES
(1, 'testimonials', '\r\n                \r\n                Client Success Stories                        ', '\r\n                \r\n                Trusted by <span>Industry Leaders</span>                        ', '\r\n                \r\n                See how Mayzar ERP &amp; POS has helped businesses optimize operations and multiply their revenue.                        ', '2026-02-23 05:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `compro_testimonial_list`
--

CREATE TABLE `compro_testimonial_list` (
  `id` int(11) NOT NULL,
  `testimonials_id` int(11) DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `stars` int(11) DEFAULT 5,
  `quote` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_testimonial_list`
--

INSERT INTO `compro_testimonial_list` (`id`, `testimonials_id`, `image`, `stars`, `quote`, `name`, `position`, `sort_order`) VALUES
(7, 1, '/assets/img/david.jpg', 5, '\r\n                \r\n                Switching to Mayzar ERP eliminated our inventory discrepancies entirely. The real-time syncing between our warehouse and 5 retail branches is flawless.                        ', '\r\n                \r\n                David Thompson                        ', '\r\n                \r\n                Operations Manager, RetailCo                        ', 0),
(8, 1, '/assets/img/sarah.jpg', 5, '\r\n                \r\n                The POS interface is so intuitive that new cashiers learn it in under 10 minutes. It has drastically reduced our checkout queues.                        ', '\r\n                \r\n                Sarah Jenkins                        ', '\r\n                \r\n                Store Owner, FreshMart                        ', 1),
(9, 1, '/assets/img/chang.jpg', 5, '\r\n                \r\n                Having accounting, HR, and sales data in one platform saves our finance team over 20 hours a week in manual data entry.                        ', '\r\n                \r\n                Michael Chang                        ', '\r\n                \r\n                CFO, BuildRight Supplies                        ', 2);

-- --------------------------------------------------------

--
-- Table structure for table `compro_testimonial_stats`
--

CREATE TABLE `compro_testimonial_stats` (
  `id` int(11) NOT NULL,
  `testimonials_id` int(11) DEFAULT 1,
  `icon` varchar(255) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `show_stars` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_testimonial_stats`
--

INSERT INTO `compro_testimonial_stats` (`id`, `testimonials_id`, `icon`, `value`, `label`, `show_stars`, `sort_order`) VALUES
(5, 1, '/assets/img/investment.png', '5,000+', 'Active Businesses', 0, 0),
(6, 1, '/assets/img/report.png', '$2B+', 'Transactions Processed', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `compro_themes`
--

CREATE TABLE `compro_themes` (
  `id` int(11) NOT NULL DEFAULT 1,
  `anchor_id` varchar(50) DEFAULT 'themes',
  `tagline` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `btn_text` varchar(100) DEFAULT NULL,
  `btn_url` varchar(255) DEFAULT NULL,
  `btn_color` varchar(20) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_themes`
--

INSERT INTO `compro_themes` (`id`, `anchor_id`, `tagline`, `title`, `description`, `main_image`, `btn_text`, `btn_url`, `btn_color`, `updated_at`) VALUES
(1, 'themes', '\r\n                \r\n                Highly Customizable                        ', '\r\n                \r\n                Dashboards Built <span>For You</span>                        ', '\r\n                \r\n                Customize your analytics dashboards to highlight the metrics that matter most to your specific role, whether you are in sales, HR, or finance.                        ', '/assets/img/unnamed.jpg', 'View Dashboard Types', '', '#1b4d82', '2026-02-23 13:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `compro_themes_bullets`
--

CREATE TABLE `compro_themes_bullets` (
  `id` int(11) NOT NULL,
  `theme_id` int(11) DEFAULT 1,
  `text` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_themes_bullets`
--

INSERT INTO `compro_themes_bullets` (`id`, `theme_id`, `text`, `sort_order`) VALUES
(9, 1, '\r\n                \r\n                Drag-and-drop widget placement                        ', 0),
(10, 1, '\r\n                \r\n                Role-specific preset templates                        ', 1),
(11, 1, '\r\n                \r\n                Export data to PDF or Excel instantly                        ', 2),
(12, 1, '\r\n                \r\n                Dark mode support for back-office comfort                        ', 3);

-- --------------------------------------------------------

--
-- Table structure for table `compro_users`
--

CREATE TABLE `compro_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_users`
--

INSERT INTO `compro_users` (`id`, `username`, `password_hash`, `role_id`, `created_at`) VALUES
(1, 'admin', '$2y$10$8JoTjeAUbuthSWABWSh.Oe2NiXyPYt7sFAgVFCqZ.pTiN7XokznwG', 1, '2026-02-18 07:35:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compro_clients`
--
ALTER TABLE `compro_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_clients_logos`
--
ALTER TABLE `compro_clients_logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_community`
--
ALTER TABLE `compro_community`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_community_list`
--
ALTER TABLE `compro_community_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_download`
--
ALTER TABLE `compro_download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_download_buttons`
--
ALTER TABLE `compro_download_buttons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_faq`
--
ALTER TABLE `compro_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_faq_list`
--
ALTER TABLE `compro_faq_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_features`
--
ALTER TABLE `compro_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_features_items`
--
ALTER TABLE `compro_features_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_footer`
--
ALTER TABLE `compro_footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_footer_links`
--
ALTER TABLE `compro_footer_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_header`
--
ALTER TABLE `compro_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_header_nav_links`
--
ALTER TABLE `compro_header_nav_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_hero`
--
ALTER TABLE `compro_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_hero_features`
--
ALTER TABLE `compro_hero_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_integrations`
--
ALTER TABLE `compro_integrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_integrations_items`
--
ALTER TABLE `compro_integrations_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_modules`
--
ALTER TABLE `compro_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_pages`
--
ALTER TABLE `compro_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `compro_pricing`
--
ALTER TABLE `compro_pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_pricing_features`
--
ALTER TABLE `compro_pricing_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_pricing_plans`
--
ALTER TABLE `compro_pricing_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_products`
--
ALTER TABLE `compro_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_product_features`
--
ALTER TABLE `compro_product_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_product_tabs`
--
ALTER TABLE `compro_product_tabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_roles`
--
ALTER TABLE `compro_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_screenshots`
--
ALTER TABLE `compro_screenshots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_screenshots_items`
--
ALTER TABLE `compro_screenshots_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_security`
--
ALTER TABLE `compro_security`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_security_items`
--
ALTER TABLE `compro_security_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_settings`
--
ALTER TABLE `compro_settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `compro_testimonials`
--
ALTER TABLE `compro_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_testimonial_list`
--
ALTER TABLE `compro_testimonial_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_testimonial_stats`
--
ALTER TABLE `compro_testimonial_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_themes`
--
ALTER TABLE `compro_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_themes_bullets`
--
ALTER TABLE `compro_themes_bullets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compro_users`
--
ALTER TABLE `compro_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compro_clients`
--
ALTER TABLE `compro_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compro_clients_logos`
--
ALTER TABLE `compro_clients_logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `compro_community_list`
--
ALTER TABLE `compro_community_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `compro_download_buttons`
--
ALTER TABLE `compro_download_buttons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `compro_faq_list`
--
ALTER TABLE `compro_faq_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `compro_features`
--
ALTER TABLE `compro_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compro_features_items`
--
ALTER TABLE `compro_features_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `compro_footer_links`
--
ALTER TABLE `compro_footer_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `compro_header_nav_links`
--
ALTER TABLE `compro_header_nav_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `compro_hero`
--
ALTER TABLE `compro_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compro_hero_features`
--
ALTER TABLE `compro_hero_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `compro_integrations`
--
ALTER TABLE `compro_integrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compro_integrations_items`
--
ALTER TABLE `compro_integrations_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `compro_modules`
--
ALTER TABLE `compro_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `compro_pages`
--
ALTER TABLE `compro_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `compro_pricing_features`
--
ALTER TABLE `compro_pricing_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `compro_pricing_plans`
--
ALTER TABLE `compro_pricing_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `compro_product_features`
--
ALTER TABLE `compro_product_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `compro_product_tabs`
--
ALTER TABLE `compro_product_tabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `compro_roles`
--
ALTER TABLE `compro_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `compro_screenshots_items`
--
ALTER TABLE `compro_screenshots_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `compro_security_items`
--
ALTER TABLE `compro_security_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `compro_testimonial_list`
--
ALTER TABLE `compro_testimonial_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `compro_testimonial_stats`
--
ALTER TABLE `compro_testimonial_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `compro_themes_bullets`
--
ALTER TABLE `compro_themes_bullets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `compro_users`
--
ALTER TABLE `compro_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `compro_users`
--
ALTER TABLE `compro_users`
  ADD CONSTRAINT `compro_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `compro_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
