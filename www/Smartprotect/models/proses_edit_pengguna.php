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
	// include models/model_pengguna.php
	include "../models/model_pengguna.php";
	$pengguna = new pengguna($connection);

	$id_user = $_POST['id_user'];
	$nama = $connection->conn->real_escape_string($_POST['nama']);
	$username = $connection->conn->real_escape_string($_POST['username']);
	$password = $connection->conn->real_escape_string($_POST['password']);
	$role = $connection->conn->real_escape_string($_POST['role']);

	$pengguna->edit("UPDATE user SET nama = '$nama', username = '$username', password = '$password', role = '$role' WHERE id_user = '$id_user'");
	// redirect
	echo "<script>window.location='?page=pengguna';</script>";
?>
