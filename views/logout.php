<?php

// Memulai sesi PHP
session_start();

// Menghapus variabel-variabel tertentu dari sesi
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['phone']);
unset($_SESSION['address']);
unset($_SESSION['created-time']);

// Mengarahkan pengguna kembali ke halaman utama
header('Location: /');