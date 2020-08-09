<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "pweb");
$act = $_GET['act'];
$nrplogin = $_SESSION['nrp'];

switch ($act) {
	case "loginMahasiswa":
		$nrp = $_POST['nrp'];
		$password = $_POST['upass'];

		$sql = "Select * from mahasiswa where nrp = '" . $nrp . "' AND password ='" . $password . "'";
		//echo "sql : " . $sql;
		$result = mysqli_query($link, $sql);

		$cek = mysqli_num_rows($result);
		if ($cek > 0) {
			session_start();
			$_SESSION['nrp'] = $nrp;
			$_SESSION['status'] = "login";
			//echo "session : " . $nrp;
			header("location:frmMahasiswaHome.php");
		} else {
			header("location:home.php?pesan=gagal");
			//header("location:home.php");	
		}
		break;

	case "logout":
		session_start();
		session_destroy();
		header("location:home.php");
		break;

	case "detailmk":
		if (isset($_POST["idmk"])) {
			//$kode_mk = $_POST['idmk'];
			$sql = mysqli_query($link, "SELECT k.nama_kelas as nama, k.kapasitas as kapasitas
										FROM 
										kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
										INNER JOIN periode p ON k.kode_periode = p.kode where m.kode_mk = '" . $_POST["idmk"] . "'");
?>
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel" style="text-align: center">DAFTAR KELAS YANG TERSEDIA</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
			</div>

			<!-- Modal Body -->
			<div class="container">
				<table class="table" style="margin-top: 20px; text-align: center;">
					<thead class="thead-light">
						<tr>
							<th scope="col">No</th>
							<th scope="col">KP</th>
							<th scope="col">Kapasitas</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						while ($row = mysqli_fetch_array($sql)) {
							echo "<tr>";
							echo "<td>" . $no++ . "</td>";
							echo "<td>" . $row["nama"] . "</td>";
							echo "<td>" . $row["kapasitas"] . "</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<!-- Modal -->

		<?php
		}
		break;

	case "deskripsiMK":
		if (isset($_POST["deskmk"])) {
			//$kode_mk = $_POST['idmk'];
			$sql = mysqli_query($link, "SELECT m.deskripsi as deskripsi FROM kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
					WHERE m.kode_mk = '" . $_POST["deskmk"] . "' LIMIT 1");
		?>
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel" style="text-align: center">Informasi Matakuliah</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
			</div>

			<!-- Modal Body -->
			<div class="container" style="margin-top: 20px; margin-bottom: 20px;">

				<?php
				$no = 1;
				while ($row = mysqli_fetch_array($sql)) {
					echo "<tr>";
					echo "<td>" . $row["deskripsi"] . "</td>";
					echo "</tr>";
				}
				?>
			</div>
			<!-- Modal -->
<?php
		}
		break;

	case "tambahCart":
		$kodeMK = $_POST['kodeMK'];
		$namaKP = $_POST['namaKP'];

		// echo "KODE MK : " . $_POST['kodeMK'] . "</br>";
		// echo "KELAS KP : " . $_POST['namaKP'] . "</br>";

		//cek kapasitas
		// $sql = ("SELECT m.kode_mk, m.nama, k.nama_kelas, k.kapasitas, m.jumlah_sks AS sksM FROM kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk WHERE k.nama_kelas = $namaKP AND m.kode_mk = $kodeMK");
		// $res=mysqli_query($link,$sql);
		// //$sks=mysqli_fetch_array($res);

		// ambil kode kelas
		$q = "SELECT k.kode_kelas AS kodeKLS, m.jumlah_sks AS sksInput, m.kode_mk AS kodeMk
				FROM kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
				WHERE k.nama_kelas = '$namaKP' AND m.kode_mk = $kodeMK";
		$reskelas = mysqli_query($link, $q);
		$res1 = $reskelas->fetch_assoc();
		$kodemk = $res1["kodeMk"];
		//echo "KODE MK : " . $kodemk . "</br>";

		$query = "SELECT SUM(m.jumlah_sks) AS total, mh.jatah_sks AS jatah_sks, k.kode_mk AS kodeMk
				FROM kelas k 
				INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
				INNER JOIN cart c ON c.kode_kelas = k.kode_kelas
				INNER JOIN mahasiswa mh ON mh.nrp = c.nrp
				WHERE c.nrp = $nrplogin";
		//echo $query . "</br>";
		$result = mysqli_query($link, $query);
		$row2 = $result->fetch_assoc();




		$queryKode = "SELECT k.kode_mk AS kodeMk
				FROM kelas k 
				INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
				INNER JOIN cart c ON c.kode_kelas = k.kode_kelas
				INNER JOIN mahasiswa mh ON mh.nrp = c.nrp
				WHERE c.nrp = $nrplogin AND k.kode_mk = $kodeMK";
		echo "query kode :: " . $queryKode . "</br>";
		$result = mysqli_query($link, $queryKode);
		$row3 = $result->fetch_assoc();


		$kodemkCart = $row3["kodeMk"];

		// echo "KODE MK yang diinput : " . $kodeMK . "</br>";
		// echo "KODE MK dari cart : " . $kodemkCart . "</br>";


		
		$prosescek = mysqli_query($link, $queryKode);
		echo "cek berapa data : " . mysqli_num_rows($prosescek). "</br>";

		if (mysqli_num_rows($prosescek) <= 0) {
			$reskelas = mysqli_query($link, $q);
			$res1 = $reskelas->fetch_assoc();
			echo "lolos pengecekan kode mk </br>";
			$cek = mysqli_num_rows($reskelas);
			echo "ceknya ada  : " . $cek . "</br>";
			if ($cek > 0) {
				$reskelas1 = mysqli_query($link, $q);
				echo "lolos pengecekan ada isinya </br>";
				while ($rowkelas =  mysqli_fetch_object($reskelas1)) {
					echo "lolos pengecekan ada isinya bag 2</br>";
					$res = mysqli_query($link, $q);
					$row = mysqli_fetch_array($res);
					$sksInput = $row["sksInput"];

					$sksCart = $row2["total"];
					$jatah = $row2["jatah_sks"];

					echo "sks yang Input " . $sksInput . "</br>";

					$totalsks = 0;
					$totalsks = (int) $sksCart + (int) $sksInput;
					echo "total sks : " . $totalsks . "</br>";

					echo "SUM jumlahsks (total) : " . $sksCart . "</br>";
					echo "jatah sks : " . $jatah . "</br>";
					echo "sum + sks yang diinput = " . $sksCart . "+" . $sksInput . "=" . $totalsks . "</br>";

					if ($totalsks <= $jatah) {
						$sql2 = "insert into cart (kode_kelas, nrp) VALUES ('" . $rowkelas->kodeKLS . "','" . $nrplogin . "')";
						$result = mysqli_query($link, $sql2);
						if ($res) {
							echo "Tambah MK berhasil";
							header("location:test.php");
						} else {
							die("Error");
						}
						echo "masuk if masih bisa input " . "</br>";
					} else {
						header("location:Test.php?pesan=sksLebih");
						echo "udah maksimal " . "</br>";
					}

					echo "sks cart : " . $sksCart . "</br>";
					echo "jatah : " . $jatah . "</br>";
				}
				echo "keluar while </br>";
			} else {
				echo "gagal lolos pengecekan ada isinya </br>";
				header("location:Test.php?pesan=tidakTersedia");
				echo "salah satu input kelas tidak tersedia. ";
			}
		} else {
			echo "gagal lolos pengecekan kode mk </br>";
			header("location:Test.php?pesan=mkSama");
			//echo "KODE MKNYA SAMA GA BISA. !!!";
		}
		break;

	case "deleteCart":
		$getKodeKls = $_POST['kodeKls'];
		$getNrp = $_POST['nrp'];
		echo "kode kelas " . $getKodeKls;
		echo "kode nrp " . $getNrp;


		$sql = "DELETE from cart where kode_kelas=" . $getKodeKls . " AND " . "nrp=" . $getNrp;
		//echo "query delete : " . $sql;
		$result =  mysqli_query($link, $sql);

		if ($result) {
			echo "sukses";
			echo $sql;
		} else {
			echo "fail";
			echo $sql;
		}
		break;

	case "konfirmasiCart":
		$q = "SELECT c.kode_kelas AS kodeKelas, c.nrp AS nrp
				FROM kelas k 
				INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
				INNER JOIN cart c ON c.kode_kelas = k.kode_kelas
				INNER JOIN mahasiswa mh ON mh.nrp = c.nrp
				WHERE c.nrp = $nrplogin";
		//echo "query kode :: " . $q . "</br>";
		$result = mysqli_query($link, $q);
		$no = 1;
		echo "<div id='dataPenuh' class='alert alert-danger' role='alert'> Matakuliah Yang Sudah Penuh : ";
		$urutan = 0;
		while ($row = mysqli_fetch_array($result)) {
			// echo $no++ . ". " . $row["kodeKelas"] . "</br>";
			// echo $no++ . ". " . $row["nrp"] . "</br>";
			// echo "------------------------------------" . "</br>";

			$kodeKelas = $row["kodeKelas"];
			$nrp = $row["nrp"];
			// echo "cek kode : " . $kodeKelas . "</br>";
			// echo "cek nrp : " . $nrp . "</br>";
			// echo "------------------------------------" . "</br>";
			
			
			
			$kodeKelas = $row["kodeKelas"];
			$qKel = "SELECT mk.kode_kelas, COUNT(mk.kode_kelas) AS kelasTerisi, k.kapasitas AS MaxKapasitas 
			FROM kelas k INNER JOIN mahasiswa_kelas mk ON k.kode_kelas = mk.kode_kelas
			WHERE mk.kode_kelas= $kodeKelas";
			$res = mysqli_query($link, $qKel);
			$row = $res->fetch_assoc();
			$isiKelas = $row["kelasTerisi"];
			//echo "Cek Isi Kelas : " . $isiKelas . "</br>";
			$kapasitas = $row["MaxKapasitas"];
			//echo "Cek kapasitasnya : " . $kapasitas . "</br>";

			//echo "=============================BATAS====================================== </BR>";
			if($isiKelas<$kapasitas)
			{
				//echo "ini bisa masuk";	
				
				$q2 = "insert into mahasiswa_kelas (nrp, kode_kelas) VALUES ('" . $nrp . "','" . $kodeKelas . "')";
				$resInsert = mysqli_query($link, $q2);
				//buat deletenyya kurang ambil nrp
				$sql = "DELETE from cart where kode_kelas=" . $kodeKelas . " AND " . "nrp=" . $nrp;
				$resDelete =  mysqli_query($link, $sql);
				// if ($resInsert && $resDelete) {
				// 	echo "pindah tabel berhasil";
				// 	//header("location:test.php");
				// } else {
				// 	die("Error");
				// }
			} else {
				//die("Error");
				//$_SESSION['kdKelas'] = $kodeKelas;
				//echo "kelas penuh </br>";
				//echo "kelas yg penuh " . $_SESSION['kdKelas'] . "</br>";
				//header("location:Test.php?pesan=kelasPenuh".$kodeKelas);
				//echo "qkel : " . $qKel . "</br>";
				
				//header("location:Test.php?pesan=kelasPenuh");
				//echo "kode kelas yang penuh = " . $kodeKelas . "</br>"; 

				//pass variable kalo bisa pake session
				//$kode=$_POST['kodeKelas'];

				$link = mysqli_connect("localhost", "root", "", "pweb");
				$SqlPenuh = mysqli_query($link, "SELECT mk.nama AS namaMK
					FROM kelas k INNER JOIN matakuliah mk ON k.kode_mk = mk.kode_mk 
					WHERE k.kode_kelas = $kodeKelas");
				$querycekpenuh = "SELECT mk.nama AS namaMK
				FROM kelas k INNER JOIN matakuliah mk ON k.kode_mk = mk.kode_mk 
				WHERE k.kode_kelas = $kodeKelas";
				//echo "query cek penuh : " . $querycekpenuh;
				
				while ($row = mysqli_fetch_object($SqlPenuh)) {
					//echo "namamknya". $row->namaMK . "</br>";
					$urutan++;
					
					//echo "session nrp while : " . $kodeKelas;
					echo "<p>" . $urutan . ". Matakuliah : " . $row->namaMK . "</p>";
					
				}
				
			}
			
		}
		echo "</div>";
		break;

		

		
	case "ajax_timestamp.php":
		date_default_timezone_set('Asia/Jakarta');//Menyesuaikan waktu dengan tempat kita tinggal
		echo $timestamp = date('H:i:s');//Menampilkan Jam Sekarang
		break;
}
?>