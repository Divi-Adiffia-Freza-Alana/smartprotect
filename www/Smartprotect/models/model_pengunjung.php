<?php
	class Pengunjung {
		// deklasrasi objek/variabel
		private $mysqli;

		// fungsi yang otomatis diload pertama kali oleh kelas
		function __construct($conn) {
			$this->mysqli = $conn;
		}

		public function terbaru() {
			$db = $this->mysqli->conn;
			$sql = "SELECT * FROM `pengunjung` ORDER BY `time` DESC LIMIT 1";
			$query = $db->query($sql) or die ($db->error);
			return $query;
		}

		// fungsi tampil data Barang
		public function tampil($id = null) {
			$db = $this->mysqli->conn;
			$sql = "SELECT * FROM pengunjung";
			if($id != null) {
				$sql .= " WHERE id_pengunjung  = $id";
			}
			$query = $db->query($sql) or die ($db->error);
			return $query;
		}

		// fungsi tambah data barang
		public function tambah($gambar, $masker, $suhu, $handsanitizer,$time,$tanggal) {
			$db = $this->mysqli->conn;
			$db->query("INSERT INTO pengunjung VALUES(null, '$gambar', '$masker', '$suhu', '$handsanitizer', '$time', '$tanggal')") or die ($db->error);
		}

		// fungsi edit data Barang
		public function edit($sql) {
			$db = $this->mysqli->conn;
			$db->query($sql) or die ($db->error);
		}

		// fungsi hapus data Barang
		public function hapus($id) {
			$db = $this->mysqli->conn;
			$db->query("DELETE FROM pengunjung WHERE id_pengunjung = '$id'") or die ($db->error);
		}

		// fungsi yang otomatis dipanggil terakhir kali setelah semua fungsi dalam kelas dijalankan / penutup koneksi
		function __destruct() {
			$db = $this->mysqli->conn;
			$db->close();
		}
	}
?>
