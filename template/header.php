<?php
require_once('includes/init.php');
cek_login(); // hanya cek session user_id
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistem Pendukung Keputusan SMART</title>
  <?php if(isset($page)) { ?>
    <title><?php echo $page; ?> - SPK SMART</title>
  <?php } else { ?>
    <title>Dashboard - SPK SMART</title>
  <?php } ?>

  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="admin-custom.css" rel="stylesheet">
  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="assets/img/favicon.ico">

  <script src="assets/vendor/jquery/jquery.min.js"></script>

  <style>
    /* Global Overrides (Optional, bisa juga di sb-admin-2.min.css custom) */
    body {
        font-family: 'Nunito', sans-serif;
        color: #5a5c69; /* Warna teks default yang lebih konsisten */
    }

    /* Sidebar Customization */
    .sidebar.bg-gradient-primary {
        background-color: #4e73df; /* Primary color default SB Admin 2 */
        background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%); /* Gradien sedikit disesuaikan */
        border-right: 1px solid rgba(255,255,255,0.1); /* Border tipis untuk pemisah */
    }
    .sidebar-brand {
        background-color: #224abe; /* Warna background untuk brand, sedikit lebih gelap dari sidebar */
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1.5rem 1rem; /* Padding lebih proporsional */
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800; /* Tebal untuk branding */
        font-size: 1.25rem;
    }
    .sidebar-brand .sidebar-brand-icon {
        color: #ffed00; /* Warna kuning cerah untuk ikon, kontras */
        font-size: 1.75rem;
    }
    .sidebar-brand .sidebar-brand-text {
        color: #fff;
    }
    .nav-item .nav-link {
        color: rgba(255,255,255,0.8); /* Warna link lebih terang */
        font-weight: 500; /* Lebih tebal sedikit */
        transition: all 0.3s ease;
    }
    .nav-item .nav-link i {
        color: rgba(255,255,255,0.6); /* Warna ikon sedikit redup */
        transition: all 0.3s ease;
    }
    .nav-item .nav-link.active,
    .nav-item .nav-link:hover {
        color: #fff; /* Warna link aktif/hover full putih */
        background-color: rgba(255,255,255,0.15); /* Background highlight */
    }
    .nav-item .nav-link:hover i {
        color: #fff; /* Warna ikon aktif/hover full putih */
    }
    .sidebar-divider {
        border-top: 1px solid rgba(255,255,255,0.1); /* Divider lebih halus */
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
    .sidebar .sidebar-heading {
        color: rgba(255,255,255,0.4); /* Warna teks heading grup menu */
        font-size: 0.75rem;
        padding: 0 1rem;
    }

    /* Topbar Customization */
    .navbar.topbar {
        background-color: #ffffff; /* Latar belakang putih */
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important; /* Shadow yang lebih bersih */
        border-bottom: 1px solid #e3e6f0; /* Border tipis di bawah */
    }
    .topbar .nav-item .nav-link {
        height: auto; /* Agar tidak terpengaruh tinggi default dropdown */
        padding: 0 0.75rem; /* Padding lebih rapi */
        display: flex;
        align-items: center;
    }
    .topbar .nav-item .nav-link:hover {
        background-color: #f6f7f9; /* Background hover yang lembut */
    }
    .topbar .dropdown-toggle::after {
        display: none; /* Hilangkan panah default dropdown untuk user */
    }
    .topbar .nav-item .dropdown-toggle .img-profile {
        height: 2.2rem; /* Ukuran gambar profile */
        width: 2.2rem;
        object-fit: cover; /* Pastikan gambar tidak terdistorsi */
        margin-left: 0.5rem;
        border: 2px solid #ddd; /* Border tipis untuk foto profil */
    }
    .topbar .dropdown-menu {
        border-radius: 0.75rem; /* Sudut lebih melengkung */
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important; /* Shadow lebih baik */
    }
    .topbar .dropdown-item {
        padding: 0.75rem 1.25rem; /* Padding dropdown item */
        transition: background-color 0.2s ease;
    }
    .topbar .dropdown-item:hover {
        background-color: #f6f7f9; /* Hover dropdown item */
        color: #4e73df; /* Warna teks saat hover */
    }
    .topbar .text-gray-600.small {
        font-weight: 600; /* Username lebih tebal */
        color: #5a5c69 !important; /* Warna yang konsisten */
    }
    .topbar .btn-link {
        color: #4e73df !important; /* Warna tombol sidebar toggle */
    }
    
    /* Content Area Adjustment */
    #content-wrapper {
        background-color: #f8f9fc; /* Latar belakang area konten */
    }
    .container-fluid {
        padding-top: 1.5rem; /* Padding di atas konten utama */
        padding-bottom: 1.5rem;
    }
    .h3.mb-0.text-gray-800 {
        color: #4e73df; /* Warna judul halaman */
        font-weight: 700;
    }
    .card {
        border-radius: 0.75rem; /* Sudut card yang lebih halus */
        border: none; /* Hilangkan border default */
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); /* Shadow lembut */
    }
    .card-header {
        background-color: #fff; /* Header card putih */
        border-bottom: 1px solid #eaecf4; /* Border bawah header card */
        color: #4e73df; /* Warna teks header card */
        font-weight: 700;
        border-radius: 0.75rem 0.75rem 0 0 !important; /* Sudut hanya atas */
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
        transform: translateY(-1px);
    }
  </style>
</head>

<body id="page-top">
<div id="wrapper">

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-flask"></i> </div>
    <div class="sidebar-brand-text mx-3">SPK SMART</div>
  </a>

  <hr class="sidebar-divider my-0">

  <li class="nav-item <?php if($page == "Dashboard"){ echo "active"; } ?>">
    <a class="nav-link" href="dashboard.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Master Data
  </div>

  <li class="nav-item <?php if($page == "Alternatif"){ echo "active"; } ?>">
    <a class="nav-link" href="list-alternatif.php">
      <i class="fas fa-fw fa-cube"></i>
      <span>Data Alternatif</span></a>
  </li>
  
  <li class="nav-item <?php if($page == "Kriteria"){ echo "active"; } ?>">
    <a class="nav-link" href="list-kriteria.php">
      <i class="fas fa-fw fa-cubes"></i>
      <span>Data Kriteria</span></a>
  </li>
  <li class="nav-item <?php if($page == "Penilaian"){ echo "active"; } ?>">
    <a class="nav-link" href="list-sub-kriteria.php">
      <i class="fas fa-fw fa-puzzle-piece"></i>
      <span>Data Sub Kriteria</span></a>
  </li>
  
  <li class="nav-item <?php if($page == "Penilaian"){ echo "active"; } ?>">
    <a class="nav-link" href="list-penilaian.php">
      <i class="fas fa-fw fa-edit"></i>
      <span>Data Penilaian</span></a>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Perhitungan
  </div>

  <li class="nav-item <?php if($page == "Perhitungan"){ echo "active"; } ?>">
    <a class="nav-link" href="perhitungan.php">
      <i class="fas fa-fw fa-calculator"></i>
      <span>Data Perhitungan</span></a>
  </li>
  
  <li class="nav-item <?php if($page == "Hasil"){ echo "active"; } ?>">
    <a class="nav-link" href="hasil.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Data Hasil Akhir</span></a>
  </li>
  
  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Pengaturan
  </div>

  <li class="nav-item <?php if($page == "User"){ echo "active"; } ?>">
    <a class="nav-link" href="list-user.php">
      <i class="fas fa-fw fa-users"></i>
      <span>Data User</span></a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
      <i class="fas fa-fw fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 text-uppercase d-none d-lg-inline text-gray-600 small">
          <?php echo htmlentities($_SESSION['username']); ?>
        </span>
        <img class="img-profile rounded-circle" src="assets/img/user.png">
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="list-profile.php">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profile
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
      </div>
    </li>

  </ul>

</nav>
<div class="container-fluid">