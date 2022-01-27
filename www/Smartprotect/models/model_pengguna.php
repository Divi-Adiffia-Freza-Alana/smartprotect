<?php
	class Pengguna {
		// deklasrasi objek/variabel
		private $mysqli;

		// fungsi yang otomatis diload pertama kali oleh kelas
		function __construct($conn) {
			$this->mysqli = $conn;
		}

		// fungsi tampil data pengguna
		public function tampil($id = null) {
			$db = $this->mysqli->conn;
			$sql = "SELECT * FROM user";
			if($id != null) {
				$sql .= " WHERE id_user = $id";
			}
			$query = $db->query($sql) or die ($db->error);
			return $query;
		}

		// fungsi tambah data pengguna
		public function tambah($nama, $username, $password, $role) {
			$db = $this->mysqli->conn;
			$db->query("INSERT INTO user VALUES('', '$nama', '$username', '$password', '$role')") or die ($db->error);
		}

		// fungsi edit data pengguna
		public function edit($sql) {
			$db = $this->mysqli->conn;
			$db->query($sql) or die ($db->error);
		}

		// fungsi hapus data pengguna
		public function hapus($id) {
			$db = $this->mysqli->conn;
			$db->query("DELETE FROM user WHERE id_user = '$id'") or die ($db->error);
		}

		// fungsi yang otomatis dipanggil terakhir kali setelah semua fungsi dalam kelas dijalankan / penutup koneksi
		function __destruct() {
			$db = $this->mysqli->conn;
			$db->close();
		}
	}
?>
