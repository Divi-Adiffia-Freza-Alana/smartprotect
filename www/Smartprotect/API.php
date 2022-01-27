<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include 'inc/koneksi.php';
require_once('controllers/koneksi.php');
require_once('models/database.php');

$connection = new Database($host, $user, $pass, $database);
include "models/model_pengunjung.php";
 

$pngnjng = new Pengunjung($connection);

$res = [
    "status"=> "error",
    "code"=>500,
    "message"=>""
];

if(!isset($_POST['masker'])){
    $res["message"] = "POST masker harus diisi";
}
elseif (!isset($_POST['suhu'])){
    $res["message"] = "POST suhu harus diisi"; 
}
elseif (!isset($_POST['handsanitizer'])){
    $res["message"] = "POST handsanitizer harus diisi"; 
}
elseif (!isset($_FILES['gambar'])){
    $res["message"] = "POST gambar harus diisi"; 
}
else{

    $terbaru = $pngnjng->terbaru();
    while($data_terbaru = $terbaru->fetch_object()) {
        $waktu_pengunjung = $data_terbaru->time;
        $waktu_sekarang = time();
        $selisih_waktu = $waktu_sekarang-$waktu_pengunjung;

        if($selisih_waktu >=5){

            $masker = $connection->conn->real_escape_string($_POST['masker']);
            $suhu = $connection->conn->real_escape_string($_POST['suhu']);
            $handsanitizer = $connection->conn->real_escape_string($_POST['handsanitizer']);

            $extensi = explode(".", $_FILES['gambar']['name']);
            $gambar = "org-".round(microtime(true)).".".end($extensi);
            $sumber = $_FILES['gambar']['tmp_name'];
            $upload = move_uploaded_file($sumber, "assets/img/barang/".$gambar);
            if($upload) {
                $pngnjng->tambah($gambar, $masker, $suhu, $handsanitizer,time(),date("Y-m-d"));

                $res["status"] = "success";
                $res["code"] = 200;
                
            } else {
                $res["message"] = "Gambar gagal diupload";
            }
        }
    }
}

echo json_encode($res);
?>