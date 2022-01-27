<?php
	// include models/model_pelanggan.php
	include "models/model_pengguna.php";

	$pengguna = new Pengguna($connection);

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
									<h3 class="panel-title">Data Petugas</h3>
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped" id="datatables">
											<thead>
												<tr>
													<th>No.</th>
													<th>Nama Petugas</th>
													<th>Username</th>
													<th>Password</th>
													<th>Role</th>
													<th>Opsi</th>
												</tr>
											</thead>
											<tbody>
												<!-- tampil data pelanggan -->
												<?php
													$no = 1;
													$tampil = $pengguna->tampil();
													while($data = $tampil->fetch_object()) {
												?>
												<tr>
													<td><?php echo $no++."."; ?></td>
													<td><?php echo $data->nama; ?></td>
													<td><?php echo $data->username; ?></td>
													<td><?php echo $data->password; ?></td>
													<td><?php echo $data->role; ?></td>
													<td>
														<!-- button edit dengan jquery ajax -->
														<a id="edit_pengguna" data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id_user; ?>" data-nama="<?php echo $data->nama; ?>" data-username="<?php echo $data->username; ?>" data-password="<?php echo $data->password; ?>" data-role="<?php echo $data->role; ?>">
															<button class="btn btn-info btn-xs"><i class="lnr lnr-pencil"></i></button></a>
														<!-- end button edit dengan jquery ajax -->
														<!-- button hapus -->
														<a href="?page=pengguna&act=del&id=<?php echo $data->id_user; ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
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
											<h4 class="modal-title">Tambah Data Petugas</h4>
										</div>
										<form action="" method="post" enctype="multipart/form-data">
											<div class="modal-body">
												<div class="form-group">
													<label class="control-label" for="nama">Nama Petugas</label>
													<input type="text" name="nama" class="form-control" placeholder="Masukan nama lengkap" id="nama" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="username">Username</label>
													<input type="text" class="form-control" name="username" placeholder="Masukan username" id="username" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="password">Password</label>
													<input type="password" name="password" class="form-control" placeholder="Masukan password" id="password" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="role">Role</label>
													<select class="form-control" name="role" id="role" required>
														<option>-- Pilih --</option>
														<option value="admin">Admin</option>
														<option value="kasir">Kasir</option>
														<option value="penjadwalan">Penjadwalan</option>
														<option value="pengadaan">Pengadaan</option>
													</select>
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
												$nama = $connection->conn->real_escape_string($_POST['nama']);
												$username = $connection->conn->real_escape_string($_POST['username']);
												$password = $connection->conn->real_escape_string($_POST['password']);
												$role = $connection->conn->real_escape_string($_POST['role']);
												if(@$_POST['tambah']) {
													$pengguna->tambah($nama, $username, $password, $role);
													header("location: ?page=pengguna"); // redirect ke form data pelanggan
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
											<h4 class="modal-title">Edit Data Petugas</h4>
										</div>
										<form id="form" enctype="multipart/form-data">
											<div class="modal-body" id="modal-edit">
												<div class="form-group">
													<label class="control-label" for="nama_pelanggan">Nama Petugas</label>
													<!-- id setiap data user untuk parameter edit -->
													<input type="hidden" name="id_user" id="id_user">
													<input type="text" name="nama" class="form-control" placeholder="Masukan nama lengkap" id="nama" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="username">Username</label>
													<input type="text" name="username" class="form-control" placeholder="Masukan username" id="username" required>
												</div>
												<div class="form-group">
													<label class="control-label" for="password">Password</label>
													<input type="text" name="password" class="form-control" placeholder="Masukan password"id="password" required></input>
												</div>
												<div class="form-group">
													<label class="control-label" for="role">Role</label>
													<select class="form-control" name="role" id="role" required>
														<option>-- Pilih --</option>
														<option value="admin">Admin</option>
														<option value="kasir">Kasir</option>
														<option value="penjadwalan">Penjadwalan</option>
														<option value="pengadaan">Pengadaan</option>
													</select>
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
								$(document).on("click", "#edit_pengguna", function() {
									var id_user = $(this).data('id');
									var nama = $(this).data('nama');
									var username = $(this).data('username');
									var password = $(this).data('password');
									var role = $(this).data('role');
									$("#modal-edit #id_user").val(id_user);
									$("#modal-edit #nama").val(nama);
									$("#modal-edit #username").val(username);
									$("#modal-edit #password").val(password);
									$("#modal-edit #role").val(role);
								})

								// proses edit data pelanggan dengan jquery ajax
								$(document).ready(function(e) {
									$("#form").on("submit", (function(e) {
										e.preventDefault();
										$.ajax({
											url : 'models/proses_edit_pengguna.php',
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
		$pengguna->hapus($_GET['id']);
		// redirect
		header("location: ?page=pengguna");
	}
