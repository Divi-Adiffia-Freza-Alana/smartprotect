

<style type="text/css">
/*animasi gambar berputar*/
.metric span.icon {
  -webkit-transition: -webkit-transform 1.1s ease-in-out;
  transition: transform 1.1s ease-in-out;
}
.metric span.icon:hover {
  -webkit-transform: rotate(360deg);
  transform: rotate(360deg);
}
.searchbtn{
	margin-top: 30px;
border: none;
background-color: #1572A1;
color: #FFF;
padding: 5px 20px;  
}
</style>

<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Dashboard</h3>
							<div class="row">
								<form name="form" action="" method="post">
								<div class="col-md-6">
									<div class="form-group">
									<label class="control-label" for="tgl">tanggal</label>
									<input type="date" name="tgl" class="form-control" placeholder="Pilih tanggal" id="tgl" value= $result>
									</div>
								</div>
								<div class="col-md-6">
								<input type="submit" name="a" value="Cari" class="searchbtn">
								</div>

								</form>	
							</div>
							<!-- <p class="panel-subtitle">Selamat Datang, Admin</p> -->

		
							<?php

								$datechoose = 0; 						

								if(isset($_POST['a']))
								{
								$datechoose = date('Y-m-d', strtotime($_POST['tgl']));
								$result =  strval($datechoose );

								}
							// koneksi database
							$koneksi = mysqli_connect("128.199.237.241","root","pwd9023bae1976b3dd39c202f574750d289023bae1976b3dd39c202f574750d28","smartprotec");
						
							// mengambil data pengguna
							$data_pengguna = mysqli_query($koneksi,"SELECT * FROM user");
								// menghitung data pengguna
								$jumlah_pengguna = mysqli_num_rows($data_pengguna);		
							// mengambil data pengunjung
							$data_pgnjng = mysqli_query($koneksi,"SELECT * FROM pengunjung  WHERE Date(tanggal) = '$datechoose' ");
							// menghitung data pengunjung
							$jumlah_pgnjng = mysqli_num_rows($data_pgnjng);
						
							// mengambil data masker
							$data_mskr = mysqli_query($koneksi,"SELECT * FROM pengunjung WHERE masker = 'ya' AND Date(tanggal) = '$datechoose'");
							// menghitung data masker
							$jumlah_mskr = mysqli_num_rows($data_mskr);
						
							// mengambil data suhu
							$data_suhu = mysqli_query($koneksi,"SELECT * FROM pengunjung WHERE suhu < '38' AND Date(tanggal) = '$datechoose'");
							// menghitung data suhu
							$jumlah_suhu = mysqli_num_rows($data_suhu);
						
						
						
						
						?>
							
							<!-- <?php
								// $tgl=date('l, d-m-Y');
								// echo $tgl;

								// date_default_timezone_set("Asia/Jakarta");
								// $b = time();
								// $hour = date("G",$b);

								// if ($hour>=0 && $hour<=11) {
								// 	$sapaan = "Selamat Pagi";
								// }
								// elseif ($hour >=12 && $hour<=14) {
								// 	$sapaan = "Selamat Siang";
								// }
								// elseif ($hour >=15 && $hour<=17) {
								// 	$sapaan = "Selamat Sore";
								// }
								// elseif ($hour >=17 && $hour<=18) {
								// 	$sapaan = "Selamat Petang";
								// }
								// elseif ($hour >=19 && $hour<=23) {
								// 	$sapaan = "Selamat Malam";
								// }
							?> -->
							<!-- <p class="panel-subtitle"><?php echo $sapaan; ?>, Admin</p> -->
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fas fa-user-friends"></i></span>
										<p>
											<span class="number"><?php echo $jumlah_pengguna; ?></span>
											<span class="title">Pengguna</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fas fa-box"></i></span>
										<p>
											<span class="number"><?php echo $jumlah_pgnjng; ?></span>
											<span class="title">Jumlah Pengunjung</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fas fa-user"></i></span>
										<p>
											<span class="number"><?php echo $jumlah_mskr; ?></span> 
											<span class="title">Memakai masker</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fas fa-exchange-alt"></i></span>
										<p>
											<span class="number"><?php echo $jumlah_suhu; ?></span> 
											<span class="title">Suhu normal</span>
										</p>
									</div>
								</div>
							</div>
							<!-- <div class="row">
								<div class="col-md-9">
									<div id="headline-chart" class="ct-chart"></div>
								</div>
								<div class="col-md-3">
									<div class="weekly-summary text-right">
										<span class="number">2,315</span> <span class="percentage"><i class="fa fa-caret-up text-success"></i> 12%</span>
										<span class="info-label">Total Sales</span>
									</div>
									<div class="weekly-summary text-right">
										<span class="number">$5,758</span> <span class="percentage"><i class="fa fa-caret-up text-success"></i> 23%</span>
										<span class="info-label">Monthly Income</span>
									</div>
									<div class="weekly-summary text-right">
										<span class="number">$65,938</span> <span class="percentage"><i class="fa fa-caret-down text-danger"></i> 8%</span>
										<span class="info-label">Total Income</span>
									</div>
								</div>
							</div> -->
							<!-- <div class="row">
								<div class="col-md-9">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63419.61867940638!2d107.73012183565163!3d-6.556212036033797!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e693c919ece3ed5%3A0x630f121657291f0!2sSubang%2C%20Subang%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1592751006585!5m2!1sen!2sid" width="990" height="280" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
								</div>
							</div> -->
						</div>
					</div>
					<!-- END OVERVIEW -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
<!-- END MAIN -->
