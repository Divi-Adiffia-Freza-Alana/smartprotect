<?php
	// include models/model_pelanggan.php
	include "models/model_pengunjung.php";

	$pngnjng = new Pengunjung($connection);

	// untuk clean dan mengamankan parameter pada link browser 
	if(@$_GET['act'] == '') {
?>
<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<!-- <div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Pengguna</h3>
							<p class="panel-subtitle">Selamat Datang, Admin</p>
						</div>
					</div> -->
							<!-- BORDERED TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Data Pengunjung</h3>
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped" id="datatables">
											<thead>
												<tr>
													<th>No.</th>
													<th>Gambar</th>
													<th>Masker</th>
													<th>Suhu</th>
													<th>Handsanitizer</th>
													<th>Tanggal</th>
													<th>Opsi</th>
												</tr>
											</thead>
											<tbody>
												<!-- tampil data pelanggan -->
												<?php
													$no = 1;
													$tampil = $pngnjng->tampil();
													while($data = $tampil->fetch_object()) {
												?>
												<tr>
													<td><?php echo $no++."."; ?></td>
													<td><img src= "assets/img/barang/<?php echo $data->gambar; ?>" width="70px">
													<td><?php echo $data->masker; ?></td>
													<td><?php echo $data->suhu; ?></td>
													<td><?php echo $data->handsanitizer; ?></td>
													<td><?php echo $data->tanggal; ?></td>
													</td>
													<td>
														<!-- button edit dengan jquery ajax -->
														<a id="edit_pengunjung" data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id_pengunjung; ?>" data-gambar="<?php echo $data->gambar; ?>" data-masker ="<?php echo $data->masker; ?>" data-suhu ="<?php echo $data->suhu; ?>" data-handsanitizer ="<?php echo $data->handsanitizer; ?>" >
															<button class="btn btn-info btn-xs"><i class="lnr lnr-pencil"></i></button></a>
														<!-- end button edit dengan jquery ajax -->
														<!-- button hapus -->
														<a href="?page=pengunjung&act=del&id=<?php echo $data->id_pengunjung; ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
															<button class="btn btn-danger btn-xs"><i class="lnr lnr-trash"></i></button></a>
														<!-- button hapus -->
													</td>
												</tr>
												<?php
													}
												?>
												<!-- end tampil data pelanggan -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- END BORDERED TABLE -->

							<!-- button dan form pop up tambah data pelanggan -->
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> Tambah Data</button>
							<!-- model pop up tambah data pelanggan -->
							<div id="tambah" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Tambah Data Pengunjung</h4>
										</div>
										<form action="" method="post" enctype="multipart/form-data">
											<div class="modal-body">
											<div class="form-group">
													<label class="control-label" for="gambar">Gambar</label>
													<input type="file" name="gambar" class="form-control" id="gambar" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="masker">masker</label>
													<input type="text" name="masker" class="form-control" id="masker" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="suhu">suhu</label>
													<input type="number" step="0.01" class="form-control" name="suhu" placeholder="Masukan suhu" id="suhu" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="handsanitizer">handsanitizer</label>
													<input type="text" name="handsanitizer" class="form-control" placeholder="Masukan handsanitizer" id="handsanitizer" required>
												</div>
										

												<!-- <div class="form-group">
													<label class="control-label" for="role">role</label>
													<label class="fancy-radio">
														<input name="role" value="admin" type="radio" id="role">
														<span><i></i>admin</span>
													</label>
													<label class="fancy-radio">
														<input name="role" value="kasir" type="radio" id="role">
														<span><i></i>kasir</span>
													</label>
													<label class="fancy-radio">
														<input name="role" value="penjadwalan" type="radio" id="role">
														<span><i></i>penjadwalan</span>
													</label>
													<label class="fancy-radio">
														<input name="role" value="pengadaan" type="radio" id="role">
														<span><i></i>pengadaan</span>
													</label>
												</div> -->
											</div>
											<div class="modal-footer">
												<button type="reset" class="btn btn-danger">Reset</button>
												<input type="submit" class="btn btn-success" name="tambah" value="Simpan">
											</div>
										</form>
										<!-- tambah data pengguna -->
										<?php
											if(@$_POST['tambah']) {
												$masker = $connection->conn->real_escape_string($_POST['masker']);
												$suhu = $connection->conn->real_escape_string($_POST['suhu']);
												$handsanitizer = $connection->conn->real_escape_string($_POST['handsanitizer']);
												
												$extensi = explode(".", $_FILES['gambar']['name']);
												$gambar = "org-".round(microtime(true)).".".end($extensi);
												$sumber = $_FILES['gambar']['tmp_name'];
												$upload = move_uploaded_file($sumber, "assets/img/barang/".$gambar);
												if($upload) {
													$pngnjng->tambah($gambar, $masker, $suhu, $handsanitizer);
													header("location: ?page=pengunjung"); // redirect ke form data pelanggan
												} else {
													echo "<script>alert('Upload gambar gagal')</script>";
												}
											}
										?>
										<!-- end tambah data pengguna -->
									</div>
								</div>
							</div>
							<!-- end button dan form pop up tambah data pengguna -->


							<!-- model pop up edit data pengguna -->
							<div id="edit" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Edit Data Barang</h4>
										</div>
										<form id="form" enctype="multipart/form-data">
											<div class="modal-body" id="modal-edit">
				
												<div class="form-group">
													<label class="control-label" for="gambar">Gambar</label>
													<input type="hidden" name="id_pengunjung" id="id_pengunjung">
													<img src="" id="pict" width="80px">
													<input type="file" name="gambar" class="form-control" id="gambar" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="masker">masker</label>
													<input type="text" name="masker" class="form-control" id="masker" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="suhu">suhu</label>
													<input type="number" step="0.01" class="form-control" name="suhu" placeholder="Masukan suhu" id="suhu" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="handsanitizer">handsanitizer</label>
													<input type="text" name="handsanitizer" class="form-control" placeholder="Masukan handsanitizer" id="handsanitizer" required>
												</div>
												<!-- <div class="form-group">
													<label class="control-label" for="role">role</label>
													<label class="fancy-radio">
														<input name="role" value="admin" type="radio" id="role">
														<span><i></i>admin</span>
													</label>
													<label class="fancy-radio">
														<input name="role" value="kasir" type="radio" id="role">
														<span><i></i>kasir</span>
													</label>
													<label class="fancy-radio">
														<input name="role" value="penjadwalan" type="radio" id="role">
														<span><i></i>penjadwalan</span>
													</label>
													<label class="fancy-radio">
														<input name="role" value="pengadaan" type="radio" id="role">
														<span><i></i>pengadaan</span>
													</label>
												</div> -->
											</div>
											<div class="modal-footer">
												<input type="submit" class="btn btn-success" name="edit" value="Simpan">
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- end model pop up edit data pelanggan -->

							<!-- get data pelanggan dengan jquery ajax -->
							<script src="assets/vendor/jquery/jquery.min.js"></script>
							<script type="text/javascript">
								// saat diklik dengan id #edit_pengguna
								$(document).on("click", "#edit_pengunjung", function() {
									var id_pengunjung = $(this).data('id');
									var gambarbru  = $(this).data('gambar');
									var masker = $(this).data('masker');
									var suhu = $(this).data('suhu');
									var handsanitizer = $(this).data('handsanitizer');
									$("#modal-edit #id_pengunjung").val(id_pengunjung);
									$("#modal-edit #masker").val(masker);
									$("#modal-edit #suhu").val(suhu);
									$("#modal-edit #handsanitizer").val(handsanitizer);
									$("#modal-edit #pict").attr("src", "assets/img/barang/"+gambarbru); 
								})

								// proses edit data pelanggan dengan jquery ajax
								$(document).ready(function(e) {
									$("#form").on("submit", (function(e) {
										e.preventDefault();
										$.ajax({
											url : 'models/proses_edit_pengunjung.php',
											type : 'POST',
											data : new FormData(this),
											contentType : false,
											cache : false,
											processData : false,
											success : function(msg) {
												$('.table').html(msg);
											}
										});
									}));
								})
							</script>

					<!-- END OVERVIEW -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<!-- END MAIN -->
<?php
	} else if(@$_GET['act'] == 'del') {
		$gbr_awal = $pngnjng->tampil($_GET['id'])->fetch_object()->gambar;
		unlink("assets/img/barang/".$gbr_awal);
		// echo "proses delete untuk id : ".$_GET['id'];
		$pngnjng->hapus($_GET['id']);
		// redirect
		header("location: ?page=pengunjung");
	}
