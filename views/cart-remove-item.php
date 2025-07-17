<?php
// Memulai sesi PHP untuk penggunaan session
session_start();

// Memeriksa apakah parameter 'id' ada dalam URL
if (isset($_GET['id'])) {
    // Mengambil nilai 'id' dari URL dan membersihkannya
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Menghapus item dengan id tertentu dari session 'cart'
    unset($_SESSION['cart'][$id]);
}

// Mengarahkan pengguna kembali ke halaman cart setelah penghapusan
header('Location: /cart');