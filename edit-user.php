<?php require_once('includes/init.php'); ?>
<?php
$errors = array();
$sukses = false;

$ada_error = false;
$result = '';

$id_user = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(isset($_POST['submit'])):
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	$nama = $_POST['nama'];
	$email = $_POST['email'];

	if(!$nama) {
		$errors[] = 'Nama tidak boleh kosong';
	}		
	
	if(!$email) {
		$errors[] = 'Email tidak boleh kosong';
	}
	
	if(!$id_user) {
		$errors[] = 'ID User salah';
	}
	
	if($password && ($password != $password2)) {
		$errors[] = 'Password harus sama keduanya';
	}
	
	if(empty($errors)):
		if($password) {
			$pass = sha1($password);
			$update = mysqli_query($koneksi, "UPDATE user SET nama = '$nama', password = '$pass', email = '$email' WHERE id_user = '$id_user'");
		} else {
			$update = mysqli_query($koneksi, "UPDATE user SET nama = '$nama', email = '$email' WHERE id_user = '$id_user'");
		}

		if($update) {
			redirect_to('list-user.php?status=sukses-edit');
		} else {
			$errors[] = 'Data gagal diupdate';
		}
	endif;
endif;
?>

<?php
$page = "User";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users-cog"></i> Edit Data User</h1>
	<a href="list-user.php" class="btn btn-secondary btn-icon-split">
		<span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>

<?php if(!empty($errors)): ?>
	<div class="alert alert-info">
		<?php foreach($errors as $error): ?>
			<?php echo $error; ?><br>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<form action="edit-user.php?id=<?php echo $id_user; ?>" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Form Edit User</h6>
		</div>
		<?php
		if(!$id_user):
		?>
		<div class="card-body">
			<div class="alert alert-danger">Data tidak ditemukan</div>
		</div>
		<?php
		else:
			$data = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_user'");
			if(mysqli_num_rows($data) <= 0):
		?>
		<div class="card-body">
			<div class="alert alert-danger">Data tidak ditemukan</div>
		</div>
		<?php
			else:
			$d = mysqli_fetch_array($data);
		?>
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-6">
					<label class="font-weight-bold">Username</label>
					<input type="text" readonly required value="<?php echo $d['username']; ?>" class="form-control"/>
				</div>
				
				<div class="form-group col-md-6">
					<label class="font-weight-bold">Password Baru</label>
					<input type="password" name="password" class="form-control"/>
				</div>
				
				<div class="form-group col-md-6">
					<label class="font-weight-bold">Ulangi Password</label>
					<input type="password" name="password2" class="form-control"/>
				</div>
				
				<div class="form-group col-md-6">
					<label class="font-weight-bold">Nama</label>
					<input type="text" name="nama" required value="<?php echo $d['nama']; ?>" class="form-control"/>
				</div>
				
				<div class="form-group col-md-6">
					<label class="font-weight-bold">E-Mail</label>
					<input type="email" name="email" required value="<?php echo $d['email']; ?>" class="form-control"/>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button name="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
			<button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
		</div>
	</div>
	<?php endif; endif; ?>
</form>

<?php require_once('template/footer.php'); ?>
