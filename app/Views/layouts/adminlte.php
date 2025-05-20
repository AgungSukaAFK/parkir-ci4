<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'AdminLTE Page' ?></title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <?= $this->include('layouts/navbar') ?>

        <!-- Sidebar -->
        <?= $this->include('layouts/sidebar') ?>

        <!-- Content -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>

        <!-- Footer -->
        <?= $this->include('layouts/footer') ?>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>

</html>