<?php
if (!isset($settings)) {
    require_once __DIR__ . '/../../db.php';
    $settings = db_get_flat('settings');
}
?>
<footer class="main-footer">
    <strong>Copyright &copy;
        <?php echo date('Y'); ?> <a href="#">
            <?php echo htmlspecialchars($settings['site_name'] ?? 'Admin'); ?>
        </a>.
    </strong>
    <?php echo __('All rights reserved.'); ?>
    <div class="float-right d-none d-sm-inline-block">
        <b><?php echo __('Version'); ?></b> 1.0.0
    </div>
</footer>