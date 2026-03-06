<head>
    <script>
        window.CONFIG = {
            BASE_URL: '<?php echo BASE_URL; ?>',
            CSRF_TOKEN: '<?php echo get_csrf_token(); ?>'
        };

        // Immediate sidebar state restoration to prevent FOUC
        (function () {
            const sidebarState = localStorage.getItem('sidebar-collapse');
            if (sidebarState === 'true') {
                document.documentElement.classList.add('sidebar-collapse');
                // Also apply to body when it becomes available
                window.addEventListener('DOMContentLoaded', () => {
                    document.body.classList.add('sidebar-collapse');
                });
            }
        })();
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if (!isset($settings)) {
        require_once __DIR__ . '/../../db.php';
        $settings = db_get_flat('settings');
    }
    ?>
    <title>
        <?php echo $page_title ?? __('Admin'); ?> | <?php echo htmlspecialchars($settings['site_name'] ?? 'Admin'); ?>
    </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
        .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #5842bc;
        }

        .btn-primary {
            background-color: #5842bc;
            border-color: #5842bc;
        }

        .btn-primary:hover {
            background-color: #46349a;
            border-color: #46349a;
        }
    </style>
</head>