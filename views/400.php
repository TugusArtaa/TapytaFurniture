<?php
// Memulai sesi PHP untuk penggunaan session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Pengaturan karakter set dan judul halaman -->
  <meta charset="utf-8">
  <title>Tapyta Furniture</title>

  <!-- Meta Khusus Seluler -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Tapyta Furniture Shop">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Tapyta">
  <meta name="generator" content="Tapyta Furniture Shop">
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="views/images/Favicon.png" />
  <!-- Font styles -->
  <link rel="stylesheet" href="views/plugins/themefisher-font/style.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="views/plugins/bootstrap/css/bootstrap.min.css">
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="views/css/style.css">
</head>

<body id="body">

  <!-- Bagian Halaman 404 (Error Page) -->
  <section class="page-404">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <!-- Logo Tapyta dengan link ke halaman utama -->
          <a href="index.html">
            <img src="views/images/Favicon.png" alt="site logo" width="100" height="100" />
          </a>
          <!-- Judul dan keterangan error -->
          <h1>400</h1>
          <h2>Bad Request</h2>
          <!-- Tombol untuk kembali ke halaman utama -->
          <a href="/" class="btn btn-main"><i class="tf-ion-android-arrow-back"></i> Go Home</a>
          <!-- Teks hak cipta -->
          <p class="copyright-text">Copyright Tapyta Furniture &copy;
            <script>document.write(new Date().getFullYear());</script>
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- Main Js File -->
  <script src="/views/js/script.js"></script>
</body>

</html>