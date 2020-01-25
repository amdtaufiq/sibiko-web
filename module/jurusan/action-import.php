<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->

<?php 
include_once("../../function/koneksi.php");
include_once("../../function/helper.php");
include_once("../../function/excel_reader2.php");
?>

<?php
// upload file xls
$target = basename($_FILES['data']['name']) ;
move_uploaded_file($_FILES['data']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
chmod($_FILES['data']['name'],0777);

// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['data']['name'],false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);

// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){

	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
	$kode_jurusan     = $data->val($i, 1);
	$nama_jurusan     = $data->val($i, 2);

        // input data ke database (table data_pegawai)
        mysqli_query($koneksi , "INSERT INTO jurusan (kode_jurusan, nama_jurusan) VALUES ('$kode_jurusan', '$nama_jurusan')");
		// $berhasil++;
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['data']['name']);

// alihkan halaman ke index.php
// header("location:index.php?berhasil=$berhasil");
header("location: ".BASE_URL."index.php?page=jurusan-list");

?>