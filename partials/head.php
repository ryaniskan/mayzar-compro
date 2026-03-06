<?php
if (!isset($settings)) {
    require_once __DIR__ . '/../db.php';
    $settings = db_get_flat('settings');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="<?php echo htmlspecialchars($settings['site_name']); ?>, App Landing Page" />
    <meta name="description" content="<?php echo htmlspecialchars($settings['site_tagline'] ?? ''); ?>" />
    <meta name="author" content="" />

    <title><?php echo htmlspecialchars($settings['site_name']); ?> - App Landing</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/lib/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/lib/all.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/lib/animate.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/lib/swiper.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/lib/lity.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
    <link rel="shortcut icon" href="<?php echo BASE_URL . '/' . ltrim($settings['site_favicon'], '/'); ?>"
        title="Favicon" sizes="16x16" />

    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;500;600;700&display=swap" />

    <!-- Custom Sticky Navbar CSS -->
    <style>
        .navbar.style-4 {
            transition: all 0.3s ease-in-out;
        }

        .navbar.style-4.nav-scroll {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }

            to {
                transform: translateY(0);
            }
        }

        /* Add padding to body when navbar is sticky to prevent content jump */
        body.navbar-sticky {
            padding-top: 80px;
        }

        /* Custom Tab Styles */
        .nav-pills .nav-link {
            background-color: #f8f9fa;
            color: #666;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link:hover {
            background-color: #e9ecef;
            color: #333;
            transform: translateY(-2px);
        }

        .nav-pills .nav-link.active {
            background-color: #5842bc;
            color: #fff;
            box-shadow: 0 4px 15px rgba(88, 66, 188, 0.3);
        }

        .tab-content {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Screenshot Slider Styles - Original from style.css */
        .screenshots.style-4 {
            background-color: #f0eff5;
            overflow: hidden;
            padding-top: 100px;
            position: relative;
            height: 700px;
        }

        .screenshots.style-4::after {
            position: absolute;
            content: "";
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 30px;
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            background-color: #fff;
            z-index: 10;
        }

        .screenshots.style-4 .screenshots-slider {
            position: absolute;
            top: 110px;
            width: calc(100% + 120px);
            left: -60px;
        }

        .screenshots.style-4 .screenshots-slider .img {
            margin: 0 auto;
            height: 420px;
            width: 190px;
        }

        .screenshots.style-4 .screenshots-slider .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .screenshots.style-4 .mob-hand {
            pointer-events: none;
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-33%);
            height: 600px;
            z-index: 10;
        }

        /* Swiper specific styles for centered slides */
        .screenshots-swiper .swiper-slide {
            opacity: 0.4;
            transform: scale(0.8);
            transition: all 0.3s ease;
        }

        .screenshots-swiper .swiper-slide-active {
            opacity: 1;
            transform: scale(1);
        }

        /* Fix for hidden top bar */
        .navbar.style-4.no-top-bar {
            margin-top: 0 !important;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body>