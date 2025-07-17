<?php
// Memulai sesi PHP
session_start();

// Menghapus variabel 'admin' dari sesi (logout)
unset($_SESSION['admin']);

// Mengarahkan pengguna ke halaman login di direktori '/admin'
header('Location: /admin/login');
?>
