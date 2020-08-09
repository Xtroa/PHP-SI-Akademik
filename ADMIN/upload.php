<?php 
$namaFile = $_POST['file'];
		
// ambil data file
$namaFile2 = $_FILES['file']['name'];
$namaSementara = $_FILES['file']['tmp_name'];

echo "namafilenya : " . $namaFile2 . "</br>";

// tentukan lokasi file akan dipindahkan
$dirUpload = "foto/";

// pindahkan file
$terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile2);

if ($terupload) {
	//echo "Upload berhasil!<br/>";
	//echo "Link: <a href='".$dirUpload.$namaFile."'>".$namaFile."</a>";
	//header("location:frmMasterMahasiswa.php");
	echo "berhasil upload";
	
} else {
	echo "Upload Gagal!";
}
?>