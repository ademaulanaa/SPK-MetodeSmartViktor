<?php require_once('includes/init.php'); ?>

<?php
$errors = array();
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if(isset($_POST['submit'])):
	
	// Validasi
	if(!$username) {
		$errors[] = 'Username tidak boleh kosong';
	}
	if(!$password) {
		$errors[] = 'Password tidak boleh kosong';
	}
	
	if(empty($errors)):
		$query = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username'");
		$cek = mysqli_num_rows($query);
		$data = mysqli_fetch_array($query);
		
		if($cek > 0){
			$hashed_password = sha1($password);
			if($data['password'] === $hashed_password) {
				$_SESSION["user_id"] = $data["id_user"];
				$_SESSION["username"] = $data["username"];
				redirect_to("dashboard.php");
			} else {
				$errors[] = 'Username atau password salah!';
			}
		} else {
			$errors[] = 'Username atau password salah!';
		}
		
	endif;

endif;	
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Sistem Pendukung Keputusan Metode SMART</title>

    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">

    <style>
        body.bg-gradient-primary {
            /* Sesuaikan gradien background jika ingin lebih modern */
            background: linear-gradient(to right,rgb(190, 194, 102) 0%,rgb(36, 42, 51) 100%);
            /* Contoh gradien biru-ungu */
        }
        .navbar.bg-white {
            background-color: rgba(255, 255, 255, 0.9) !important; /* Sedikit transparan */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .navbar-brand.text-primary {
            color:rgb(23, 24, 27) !important; /* Warna primary default sb-admin-2 */
        }
        .card.o-hidden.border-0.shadow-lg.my-5 {
            border-radius: 1rem; /* Sudut lebih melengkung */
            box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important; /* Shadow lebih menonjol */
        }
        .card.bg-none {
            /* Pastikan teks di bagian kiri tetap terbaca dengan baik */
            color: #ffffff; /* Ubah warna teks menjadi putih */
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5); /* Tambah sedikit shadow agar lebih jelas */
        }
        .card.bg-none h4 {
            font-weight: 800;
            font-size: 2.25rem; /* Ukuran font lebih besar */
            line-height: 1.2;
            margin-bottom: 1rem;
        }
        .card.bg-none p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 0;
        }
        .p-5 {
            padding: 3rem !important; /* Padding lebih banyak di dalam form */
        }
        .text-center h1.h4 {
            font-weight: 700;
            color: #34495e; /* Warna abu-abu gelap yang lebih modern */
            margin-bottom: 1.75rem !important;
        }
        .form-group {
            margin-bottom: 1.5rem; /* Jarak antar input form */
        }
        .form-control-user {
            border-radius: 0.5rem; /* Sudut input yang lebih halus */
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
        .btn-user {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
            font-weight: bold;
            transition: all 0.3s ease;
            background-color:rgb(12, 12, 12); /* Sesuaikan dengan warna primary sb-admin-2 */
            border-color:rgb(197, 190, 45);
        }
        .btn-user:hover {
            background-color:rgb(212, 218, 45); /* Sedikit lebih gelap saat hover */
            border-color:rgb(226, 226, 62);
            transform: translateY(-2px); /* Efek sedikit terangkat */
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }
        .alert {
            border-radius: 0.5rem;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <nav class="navbar navbar-expand-lg navbar-dark bg-white shadow-lg pb-3 pt-3 font-weight-bold">
        <div class="container">
            <a class="navbar-brand text-primary" style="font-weight: 900;" href="home.php"> <i
                    class="fa fa-database mr-2 rotate-n-15"></i> Sistem Pendukung Keputusan Metode SMART</a>
        </div>
    </nav>

    <div class="container">
        <div class="row d-plex justify-content-between mt-5">
            <div class="col-xl-6 col-lg-6 col-md-6 mt-5 d-flex align-items-center">
                <div class="card bg-none o-hidden border-0 my-5 text-white" style="background: none;">
                    <div class="text-justify card-body p-0">
                        <h4 style="font-weight: 800;">Sistem Pendukung Keputusan Metode SMART</h4>
                        <p class="pt-4">
                            Simple Multi Attribute Rating Technique (SMART) menggunakan linear additive model untuk
                            meramal nilai setiap alternatif. SMART adalah metode yang fleksibel dalam pengambilan
                            keputusan. Metode SMART banyak digunakan karena lebih sederhana dalam merespon semua
                            kebutuhan oleh pembuat keputusan dengan cara menganalisa respon.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-lg-5 col-md-5 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login Account</h1>
                                    </div>
                                    <?php if(!empty($errors)): ?>
                                    <?php foreach($errors as $error): ?>
                                    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>

                                    <form class="user" action="login.php" method="post">
                                        <div class="form-group">
                                            <input required autocomplete="off" type="text"
                                                value="<?php echo htmlentities($username); ?>"
                                                class="form-control form-control-user" id="exampleInputUser"
                                                placeholder="Username" name="username" />
                                        </div>
                                        <div class="form-group">
                                            <input required autocomplete="off" type="password"
                                                class="form-control form-control-user" id="exampleInputPassword"
                                                name="password" placeholder="Password" />
                                        </div>
                                        <button name="submit" type="submit"
                                            class="btn btn-primary btn-user btn-block"><i
                                                class="fas fa-fw fa-sign-in-alt mr-1"></i> Masuk</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>