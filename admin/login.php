<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';

// Apply security headers
apply_security_headers();

// Verify CSRF on login attempt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
}

$error = '';

$settings = db_get_flat('settings');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $users = db_get_all('users');

    $authenticated = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_user'] = $user;
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        header("Location: " . BASE_URL . "/admin/settings");
        exit;
    } else {
        $error = __('Invalid username or password');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($settings['site_name'] ?? 'Admin'); ?> | <?php echo __('Log in'); ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <style>
        :root {
            --primary-color: #5842bc;
        }

        .login-page {
            background-color: #f4f6f9;
        }

        .card-primary.card-outline {
            border-top: 3px solid var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #4735a1;
            border-color: #4735a1;
        }

        .login-logo img {
            max-width: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo BASE_URL; ?>/">
                <img src="<?php echo htmlspecialchars($settings['site_logo']); ?>" alt="Logo"><br>
                <b><?php echo htmlspecialchars($settings['site_name'] ?? 'Admin'); ?></b>
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card card-outline card-primary shadow-lg">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><?php echo __('Sign in to start your session'); ?></p>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-ban"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <?php render_csrf_input(); ?>
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control"
                            placeholder="<?php echo __('Username'); ?>" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control"
                            placeholder="<?php echo __('Password'); ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    <?php echo __('Remember Me'); ?>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit"
                                class="btn btn-primary btn-block"><?php echo __('Sign In'); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
</body>

</html>