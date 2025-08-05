<?php
require_once('includes/init.php'); // Mulai session, koneksi DB, dan fungsi umum
cek_login(); // Pastikan user sudah login sebelum mengakses dashboard

$page = "Dashboard";
require_once('template/header.php'); // Header UI dan gaya sudah dimodifikasi

?>

<div class="mb-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-home"></i> Dashboard</h1>
    </div>

    <div class="alert alert-success alert-dismissible fade show animated--grow-in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        Selamat datang <span class="text-uppercase"><b><?php echo htmlspecialchars($_SESSION['username']); ?>!</b></span> Anda bisa
        mengoperasikan sistem melalui menu di bawah.
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Data Master
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="list-kriteria.php" class="stretched-link text-decoration-none">
                                    Data Kriteria
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cube fa-2x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Data Master
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="list-sub-kriteria.php" class="stretched-link text-decoration-none">
                                    Data Sub Kriteria
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cubes fa-2x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Data Master
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="list-alternatif.php" class="stretched-link text-decoration-none">
                                    Data Alternatif
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Proses Data
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="list-penilaian.php" class="stretched-link text-decoration-none">
                                    Data Penilaian
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Proses Data
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="perhitungan.php" class="stretched-link text-decoration-none">
                                    Data Perhitungan
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Hasil Analisis
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="hasil.php" class="stretched-link text-decoration-none">
                                    Data Hasil Akhir
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-area fa-2x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('template/footer.php');
?>