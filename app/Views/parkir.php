<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url() ?>/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">Parkir App</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="/" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/penghasilan" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Penghasilan
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <!-- Main content -->
            <section class="content">
    <div class="container-fluid">

        <!-- Alert -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Form Input/Keluar -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?= base_url('parkir/simpan') ?>" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-control" onchange="updateHarga()">
                                <option value="Motor" data-harga="3000">Motor</option>
                                <option value="Mini Bus" data-harga="5000">Mini Bus</option>
                                <option value="Truck" data-harga="7000">Truck</option>
                                <option value="Bus" data-harga="10000">Bus</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="harga">Harga per Jam</label>
                            <input type="text" class="form-control" id="harga" name="harga" readonly>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <label for="no_polisi">No Polisi</label>
                        <input type="text" id="no_polisi" name="no_polisi" class="form-control form-control-lg text-center" placeholder="Contoh: B1234XYZ" required>
                        <button type="submit" class="btn btn-primary mt-3">Simpan / Keluar</button>
                        <p class="text-muted mt-2">*Isi No Polisi lalu klik tombol. Sistem akan mendeteksi apakah kendaraan masuk atau keluar.</p>
                    </div>
                </form>

                <script>
                    function updateHarga() {
                        const select = document.getElementById("jenis_kendaraan");
                        const harga = select.options[select.selectedIndex].getAttribute("data-harga");
                        document.getElementById("harga").value = harga;
                    }
                    window.onload = updateHarga;
                </script>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Kendaraan</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No Polisi</th>
                            <th>Jenis</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Status</th>
                            <th>Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($riwayat as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($k['no_polisi']) ?></td>
                                <td><?= esc($k['jenis_kendaraan']) ?></td>
                                <td><?= esc($k['waktu']) ?></td>
                                <td><?= $k['waktu_keluar'] ?? '-' ?></td>
                                <td>
                                    <span class="badge <?= $k['status'] == 'MASUK' ? 'badge-success' : 'badge-danger' ?>">
                                        <?= $k['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $k['total_bayar'] ? 'Rp ' . number_format($k['total_bayar'], 0, ',', '.') : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

            <!-- /.content -->

        </div>

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2025 <a target="_blank" href="https://github.com/AgungSukaAFK">AgungSukaAFK</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url() ?>/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= base_url() ?>/adminlte/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= base_url() ?>/adminlte/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?= base_url() ?>/adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= base_url() ?>/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= base_url() ?>/adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url() ?>/adminlte/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url() ?>/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= base_url() ?>/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url() ?>/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/adminlte/dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= base_url() ?>/adminlte/dist/js/pages/dashboard.js"></script>
</body>

</html>