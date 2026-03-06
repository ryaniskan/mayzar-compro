<?php
$current_page = $_SERVER['REQUEST_URI'];
if (!isset($settings)) {
    $settings = db_get_flat('settings');
}

$is_active = function ($path) use ($current_page) {
    // Strip BASE_URL from current_page if present for comparison
    $base = defined('BASE_URL') ? BASE_URL : '';
    $compare_page = $current_page;
    if ($base !== '' && strpos($compare_page, $base) === 0) {
        $compare_page = substr($compare_page, strlen($base));
    }
    return (strpos($compare_page, $path) !== false) ? 'active' : '';
};
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BASE_URL; ?>/admin/settings" class="brand-link text-center">
        <img src="<?php echo htmlspecialchars((strpos($settings['site_logo'] ?? '', 'http') === 0) ? ($settings['site_logo'] ?? BASE_URL . '/assets/img/logo_lgr.png') : BASE_URL . ($settings['site_logo'] ?? '/assets/img/logo_lgr.png')); ?>"
            alt="Logo" class="brand-image" style="opacity: .8; float: none;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['username'] ?? 'Admin'); ?>&background=5842bc&color=fff"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo htmlspecialchars($user['username'] ?? 'Admin'); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header"><?php echo __('CONFIGURATION'); ?></li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/modules"
                        class="nav-link <?php echo $is_active('/admin/modules'); ?>">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p><?php echo __('Module Manager'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/settings"
                        class="nav-link <?php echo $is_active('/admin/settings'); ?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p><?php echo __('General Settings'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/account"
                        class="nav-link <?php echo $is_active('/admin/account'); ?>">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p><?php echo __('Account Security'); ?></p>
                    </a>
                </li>

                <li class="nav-header"><?php echo __('FRONT-END SECTIONS'); ?>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/header"
                        class="nav-link <?php echo ($is_active('/admin/header') || $is_active('/admin/index') || ($compare_page ?? '') === '/admin' || ($compare_page ?? '') === '/admin/') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-heading"></i>
                        <p><?php echo __('Header Section'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/hero"
                        class="nav-link <?php echo $is_active('/admin/hero'); ?>">
                        <i class="nav-icon fas fa-image"></i>
                        <p><?php echo __('Hero Section'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/integrations"
                        class="nav-link <?php echo $is_active('/admin/integrations'); ?>">
                        <i class="nav-icon fas fa-link"></i>
                        <p><?php echo __('Integrations'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/security"
                        class="nav-link <?php echo $is_active('/admin/security'); ?>">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p><?php echo __('Security Section'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/clients"
                        class="nav-link <?php echo $is_active('/admin/clients'); ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p><?php echo __('Clients'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/features"
                        class="nav-link <?php echo $is_active('/admin/features'); ?>">
                        <i class="nav-icon fas fa-star"></i>
                        <p><?php echo __('Features'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/products"
                        class="nav-link <?php echo $is_active('/admin/products'); ?>">
                        <i class="nav-icon fas fa-box"></i>
                        <p><?php echo __('Products'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/themes"
                        class="nav-link <?php echo $is_active('/admin/themes'); ?>">
                        <i class="nav-icon fas fa-palette"></i>
                        <p><?php echo __('Themes'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/screenshots"
                        class="nav-link <?php echo $is_active('/admin/screenshots'); ?>">
                        <i class="nav-icon fas fa-mobile-alt"></i>
                        <p><?php echo __('Screenshots'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/testimonials"
                        class="nav-link <?php echo $is_active('/admin/testimonials'); ?>">
                        <i class="nav-icon fas fa-comments"></i>
                        <p><?php echo __('Testimonials'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/pricing"
                        class="nav-link <?php echo $is_active('/admin/pricing'); ?>">
                        <i class="nav-icon fas fa-tags"></i>
                        <p><?php echo __('Pricing'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/faq"
                        class="nav-link <?php echo $is_active('/admin/faq'); ?>">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p><?php echo __('FAQ'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/community"
                        class="nav-link <?php echo $is_active('/admin/community'); ?>">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p><?php echo __('Community Hub'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/download"
                        class="nav-link <?php echo $is_active('/admin/download'); ?>">
                        <i class="nav-icon fas fa-download"></i>
                        <p><?php echo __('Download'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/footer"
                        class="nav-link <?php echo $is_active('/admin/footer'); ?>">
                        <i class="nav-icon fas fa-window-maximize"></i>
                        <p><?php echo __('Footer Section'); ?></p>
                    </a>
                </li>

                <li class="nav-header"><?php echo __('INNER PAGES'); ?></li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/about"
                        class="nav-link <?php echo $is_active('/admin/about'); ?>">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p><?php echo __('About Page'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/contact"
                        class="nav-link <?php echo $is_active('/admin/contact'); ?>">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p><?php echo __('Contact Page'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/privacy"
                        class="nav-link <?php echo $is_active('/admin/privacy'); ?>">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p><?php echo __('Privacy Policy'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>/admin/terms"
                        class="nav-link <?php echo $is_active('/admin/terms'); ?>">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p><?php echo __('Terms of Service'); ?></p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>