<?php
// Memulai sesi PHP
session_start();

// Memeriksa apakah halaman sebelumnya merupakan halaman checkout
if (str_contains($_SERVER['HTTP_REFERER'], '/checkout-process')) {
  // Jika ya, unset (hapus) data keranjang dari sesi
  unset($_SESSION['cart']);
} else {
  // Jika tidak, redirect ke halaman produk
  header('Location: /products');
}

// Memasukkan file header untuk tata letak halaman
require __DIR__ . '/header.php';
?>

<!-- Bagian HTML untuk menampilkan pesan keberhasilan -->
<section class="page-wrapper success-msg">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <i class="tf-ion-android-checkmark-circle"></i>
          <h2 class="text-center">Thank you for shopping with us, Love Tapyta</h2>
          <a href="/products" class="btn btn-main mt-20">Continue Shopping</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
// Memasukkan file footer untuk menyelesaikan halaman
require __DIR__ . '/footer.php';
?>