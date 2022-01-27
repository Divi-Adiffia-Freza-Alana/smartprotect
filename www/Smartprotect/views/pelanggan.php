<?php
	// include models/model_pelanggan.php
	include "models/model_pelanggan.php";

	$plgn = new Pelanggan ($connection);

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
									<h3 class="panel-title">Data Pelanggan</h3>
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped" id="datatables">
											<thead>
												<tr>
													<th>No.</th>
													<th>Nama Pelanggan</th>
													<th>Alamat</th>
													<th>Opsi</th>
												</tr>
											</thead>
											<tbody>
												<!-- tampil data pelanggan -->
												<?php
													$no = 1;
													$tampil = $plgn->tampil();
													while($data = $tampil->fetch_object()) {
												?>
												<tr>
													<td><?php echo $no++."."; ?></td>
													<td><?php echo $data->nama_pelanggan; ?></td>
													<td><?php echo $data->Alamat; ?></td>
													<td>
														<!-- button edit dengan jquery ajax -->
														<a id="edit_pelanggan" data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id_pelanggan; ?>" data-nama_pelanggan="<?php echo $data->nama_pelanggan; ?>" data-Alamat="<?php echo $data->Alamat; ?>">
															<button class="btn btn-info btn-xs"><i class="lnr lnr-pencil"></i></button></a>
														<!-- end button edit dengan jquery ajax -->
														<!-- button hapus -->
														<a href="?page=pelanggan&act=del&id=<?php echo $data->id_pelanggan; ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
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
											<h4 class="modal-title">Tambah Data Pelanggan</h4>
										</div>
										<form action="" method="post" enctype="multipart/form-data">
											<div class="modal-body">
												<div class="form-group">
													<label class="control-label" for="nama_pelanggan">Nama Pelanggan</label>
													<input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukan nama lengkap" id="nama_pelanggan" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="Alamat">Alamat</label>
													<input type="text" class="form-control" name="Alamat" placeholder="Masukan Alamat" id="Alamat" required>
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
												$nama_pelanggan = $connection->conn->real_escape_string($_POST['nama_pelanggan']);
												$Alamat = $connection->conn->real_escape_string($_POST['Alamat']);;
												if(@$_POST['tambah']) {
													$plgn->tambah($nama_pelanggan, $Alamat);
													header("location: ?page=pelanggan"); // redirect ke form data pelanggan
												} else {
													echo "<script>alert('Tambah data pelanggan gagal!')</script>";
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
											<h4 class="modal-title">Edit Data Pelanggan</h4>
										</div>
										<form id="form" enctype="multipart/form-data">
											<div class="modal-body" id="modal-edit">
												<div class="form-group">
													<label class="control-label" for="nama_pelanggan">Nama Pelanggan</label>
													<!-- id setiap data user untuk parameter edit -->
													<input type="hidden" name="id_pelanggan" id="id_pelanggan">
													<input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukan nama lengkap" id="nama_pelanggan" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="Alamat">Alamat</label>
													<textarea type="text" name="Alamat" class="form-control" placeholder="Masukan Alamat" id="Alamat" required> </textarea>
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
								$(document).on("click", "#edit_pelanggan", function() {
									var id_pelanggan = $(this).data('id');
									var nama_pelanggan = $(this).data('nama_pelanggan');
									var Alamat = $(this).data('Alamat');
									$("#modal-edit #id_pelanggan").val(id_pelanggan);
									$("#modal-edit #nama_pelanggan").val(nama_pelanggan);
									$("#modal-edit #Alamat").val(Alamat);
								})

								// proses edit data pelanggan dengan jquery ajax
								$(document).ready(function(e) {
									$("#form").on("submit", (function(e) {
										e.preventDefault();
										$.ajax({
											url : 'models/proses_edit_pelanggan.php',
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
		// echo "proses delete untuk id : ".$_GET['id'];
		$plgn->hapus($_GET['id']);
		// redirect
		header("location: ?page=pelanggan");
	}
