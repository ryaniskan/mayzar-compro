<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/csrf_helper.php';
check_auth();

$current_page = 'account';
$page_title = __('Account Security');
?>
<!DOCTYPE html>
<html lang="en">

<?php include __DIR__ . '/partials/head.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include __DIR__ . '/partials/navbar.php'; ?>
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php echo __('Account Security'); ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline shadow-sm">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold"><?php echo __('Change Password'); ?></h3>
                                </div>
                                <form action="account_handler" method="POST">
                                    <?php render_csrf_input(); ?>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label
                                                class="small font-weight-bold"><?php echo __('Current Password'); ?></label>
                                            <input type="password" name="current_password" class="form-control"
                                                required>
                                        </div>
                                        <hr>
                                        <div class="form-group mb-3">
                                            <label
                                                class="small font-weight-bold"><?php echo __('New Password'); ?></label>
                                            <input type="password" name="new_password" class="form-control" required
                                                minlength="6">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label
                                                class="small font-weight-bold"><?php echo __('Confirm New Password'); ?></label>
                                            <input type="password" name="confirm_password" class="form-control" required
                                                minlength="6">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-lock mr-2"></i> <?php echo __('Update Password'); ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-info card-outline shadow-sm">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold"><?php echo __('Security Tips'); ?></h3>
                                </div>
                                <div class="card-body">
                                    <ul class="pl-3">
                                        <li class="mb-2">
                                            <?php echo __('Use at least 8 characters with a mix of letters, numbers, and symbols.'); ?>
                                        </li>
                                        <li class="mb-2">
                                            <?php echo __('Avoid using common passwords or personal information.'); ?>
                                        </li>
                                        <li class="mb-2"><?php echo __("Don't reuse passwords from other sites."); ?>
                                        </li>
                                        <li><?php echo __('Logout after your session to prevent unauthorized access.'); ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>

    <?php include __DIR__ . '/partials/scripts.php'; ?>
</body>

</html>