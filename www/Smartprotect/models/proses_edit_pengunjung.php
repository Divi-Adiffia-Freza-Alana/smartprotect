<?php
	// jquery ajax memerlukan pemanggilan semua koneksi
	// index.php
	// mencegah error saat redirect dengan fungsi header(location)
	ob_start();
	// include sekali controllers/koneksi.php dan models/database.php
	require_once('../controllers/koneksi.php');
	require_once('../models/database.php');
	$connection = new Database($host, $user, $pass, $database);

	// pelanggan.php
	// include models/model_barang.php
	include "../models/model_pengunjung.php";
	$pngnjng = new Pengunjung ($connection);

	$id_pengunjung = $_POST['id_pengunjung'];
	$masker = $connection->conn->real_escape_string($_POST['masker']);
	$suhu = $connection->conn->real_escape_string($_POST['suhu']);
	$handsanitizer = $connection->conn->real_escape_string($_POST['handsanitizer']);
	$pict = $_FILES['gambar']['name'];
	$extensi = explode(".", $_FILES['gambar']['name']);
	$gambar = "org-".round(microtime(true)).".".end($extensi);
	$sumber = $_FILES['gambar']['tmp_name'];

	if($pict == ''){
		$pngnjng->edit("UPDATE pengunjung SET masker = '$masker', suhu = '$suhu', handsanitizer = '$handsanitizer' WHERE id_pengunjung = '$id_pengunjung'");
		echo "<script>window.location='?page=pengunjung';</script>";

	}else{
		$gbr_awal = $pngnjng->tampil($id_pengunjung)->fetch_object()->gambar;
		unlink("../assets/img/barang/".$gbr_awal);
		$upload = move_uploaded_file($sumber, "../assets/img/barang/".$gambar);
		if($upload) {
			$pngnjng->edit("UPDATE pengunjung SET gambar = '$gambar', masker = '$masker', suhu = '$suhu', handsanitizer = '$handsanitizer' WHERE id_pengunjung = '$id_pengunjung'");
		echo "<script>window.location='?page=pengunjung';</script>";
		} else {
			echo "<script>alert('Upload gambar gagal')</script>";
		}

	}

	
	
?>
