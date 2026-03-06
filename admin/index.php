<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
check_auth();
$user = get_logged_in_user();
$settings = db_get_flat('settings');
$page_title = __('Dashboard');
?>
<!DOCTYPE html>
<html lang="en">

<?php include __DIR__ . '/partials/head.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include __DIR__ . '/partials/navbar.php'; ?>
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                <?php echo sprintf(__('Welcome back, %s!'), htmlspecialchars($user['username'])); ?>
                            </h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>3 / 12</h3>
                                    <p><?php echo __('Dynamic Sections'); ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-th"></i>
                                </div>
                                <a href="<?php echo BASE_URL; ?>/admin/modules"
                                    class="small-box-footer"><?php echo __('More info'); ?> <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-9 col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-bolt mr-1"></i>
                                        <?php echo __('Quick Actions'); ?>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?php echo BASE_URL; ?>/" target="_blank"
                                            class="btn btn-outline-primary rounded-pill btn-sm mr-2 mb-2"><?php echo __('View Site'); ?></a>
                                        <button
                                            class="btn btn-primary rounded-pill btn-sm mr-2 mb-2"><?php echo __('Edit Hero'); ?></button>
                                        <button
                                            class="btn btn-primary rounded-pill btn-sm mr-2 mb-2"><?php echo __('Edit Clients'); ?></button>
                                        <button
                                            class="btn btn-primary rounded-pill btn-sm mr-2 mb-2"><?php echo __('Edit Features'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php include __DIR__ . '/partials/footer.php'; ?>

    </div>
    <!-- ./wrapper -->

    <?php include __DIR__ . '/partials/scripts.php'; ?>
</body>

</html>