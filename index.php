<?php

// Memasukkan file router.php yang berisi kelas Route
require __DIR__ . '/router.php';

// Menambahkan route untuk halaman utama
Route::add('/', function () {
    require __DIR__ . '/views/home.php';
});

// Menambahkan route untuk halaman login
Route::add('/login', function () {
    require __DIR__ . '/views/login.php';
});

// Menambahkan route untuk halaman registrasi
Route::add('/register', function () {
    require __DIR__ . '/views/register.php';
});

// Menambahkan route untuk halaman logout
Route::add('/logout', function () {
    require __DIR__ . '/views/logout.php';
});

// Menambahkan route untuk halaman item
Route::add('/item', function () {
    require __DIR__ . '/views/item.php';
});

// Menambahkan route untuk halaman produk
Route::add('/products', function () {
    require __DIR__ . '/views/products.php';
});

// Menambahkan route untuk halaman profil pengguna
Route::add('/profile', function () {
    require __DIR__ . '/views/profile.php';
});

// Menambahkan route untuk halaman pesanan
Route::add('/orders', function () {
    require __DIR__ . '/views/orders.php';
});

// Menambahkan route untuk halaman detail pesanan
Route::add('/order-details', function () {
    require __DIR__ . '/views/order-details.php';
});

// Menambahkan route untuk halaman keranjang belanja
Route::add('/cart', function () {
    require __DIR__ . '/views/cart.php';
});

// Menambahkan route untuk halaman menghapus item dari keranjang
Route::add('/cart-remove-item', function () {
    require __DIR__ . '/views/cart-remove-item.php';
});

// Menambahkan route untuk halaman konfirmasi pembelian
Route::add('/confirmation', function () {
    require __DIR__ . '/views/confirmation.php';
});

// Menambahkan route untuk halaman FAQ
Route::add('/faq', function () {
    require __DIR__ . '/views/faq.php';
});

// Menambahkan route untuk halaman about us
Route::add('/about', function () {
    require __DIR__ . '/views/about.php';
});

// Menambahkan route untuk halaman about us
Route::add('/contact', function () {
    require __DIR__ . '/views/contact.php';
});

// Menambahkan route untuk halaman kebijakan privasi
Route::add('/privacy-policy', function () {
    require __DIR__ . '/views/privacy-policy.php';
});

// Menambahkan route untuk halaman error 400
Route::add('/400', function () {
    require __DIR__ . '/views/400.php';
});

// Menambahkan route untuk halaman admin home
Route::add('/admin/home', function () {
    require __DIR__ . '/views/admin/home.php';
});

// Menambahkan route untuk halaman login admin
Route::add('/admin/login', function () {
    require __DIR__ . '/views/admin/login.php';
});

// Menambahkan route untuk halaman logout admin
Route::add('/admin/logout', function () {
    require __DIR__ . '/views/admin/logout.php';
});

// Menambahkan route untuk halaman produk admin
Route::add('/admin/products', function () {
    require __DIR__ . '/views/admin/products.php';
});

// Menambahkan route untuk halaman pelanggan admin
Route::add('/admin/customers', function () {
    require __DIR__ . '/views/admin/customers.php';
});

// Menambahkan route untuk halaman pesanan admin
Route::add('/admin/orders', function () {
    require __DIR__ . '/views/admin/orders.php';
});

// Menambahkan route untuk halaman FAQ admin
Route::add('/admin/faq', function () {
    require __DIR__ . '/views/admin/faq.php';
});

// Menambahkan route untuk halaman pengaturan admin
Route::add('/admin/settings', function () {
    require __DIR__ . '/views/admin/settings.php';
});

// Menambahkan route untuk halaman membuat produk admin
Route::add('/admin/products/create', function () {
    require __DIR__ . '/views/admin/create-product.php';
});

// Menambahkan route untuk halaman membuat pelanggan admin
Route::add('/admin/customers/create', function () {
    require __DIR__ . '/views/admin/create-customer.php';
});

// Menambahkan route untuk halaman membuat FAQ admin
Route::add('/admin/faq/create', function () {
    require __DIR__ . '/views/admin/create-faq.php';
});

// Menambahkan route untuk halaman statistik admin
Route::add('/admin/stats', function () {
    require __DIR__ . '/views/admin/stats.php';
});

// Menjalankan fungsi untuk menangani rute yang sesuai
Route::submit();