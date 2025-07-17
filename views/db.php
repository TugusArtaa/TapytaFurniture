<?php

// Informasi koneksi database
$host = 'localhost';
// Nama database
$name = 'db_TapytaFurniture2';
// Nama pengguna database
$user = 'root';
// Kata sandi pengguna database
$password = '';

try {
	// Membuat objek PDO untuk koneksi ke database
	$pdo = new PDO("mysql:host=$host;dbname=$name", $user, $password);

	// Mengatur mode penanganan kesalahan untuk PDO menjadi mode penanganan kesalahan pengecualian
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
	// Menangkap dan menampilkan pesan kesalahan jika terjadi kesalahan koneksi
	echo "Connection error :" . $exception->getMessage();
}
?>