<?php
// Memulai sesi PHP
session_start();

// Memasukkan file koneksi ke database (db.php)
require __DIR__ . '/db.php';

// Memeriksa apakah pengguna sudah login, jika iya, redirect ke halaman utama
if (isset($_SESSION['name'])) {
    header('Location: /');
}

// Inisialisasi variabel kesalahan
$error = false;

// Memproses formulir login ketika dikirim
if (isset($_POST['login'])) {
    // Membersihkan dan mendapatkan data inputan
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password');

    // Mengeksekusi query untuk mendapatkan informasi pengguna berdasarkan alamat email
    $statement = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $statement->execute(array($email));

    // Memeriksa apakah ada baris yang ditemukan
    if ($statement->rowCount() > 0) {
        // Mengambil hasil query sebagai array asosiatif
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Memeriksa apakah password yang dimasukkan sesuai dengan hash password di database
        if (password_verify($password, $result[0]['password'])) {
            // Jika sesuai, menyimpan informasi pengguna ke sesi dan redirect ke halaman utama
            $_SESSION['name'] = $result[0]['lastname'] . ' ' . $result[0]['firstname'];
            $_SESSION['email'] = $result[0]['email'];
            $_SESSION['phone'] = $result[0]['phone'];
            $_SESSION['address'] = $result[0]['address'];
            $_SESSION['created-time'] = $result[0]['created'];
            header('Location: /');
        }
        // Jika password tidak sesuai, set variabel kesalahan menjadi true
        $error = true;
    }
    // Jika email tidak ditemukan, set variabel kesalahan menjadi true
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Kebutuhan Halaman Dasar -->
    <meta charset="utf-8">
    <title>Tapyta Furniture</title>

    <!-- Meta Khusus Seluler -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Tapyta Furniture Shop">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="Tapyta">
    <meta name="generator" content="Tapyta Furniture Shop">
    <link rel="stylesheet" href="views/css/stylelogin.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Login | Page</title>
</head>

<body>
    <div class="box">
        <video id="bg-video" src="views/images/bgVideo.mp4" loop muted autoplay></video>

        <!-- Menampilkan pesan kesalahan jika login gagal -->
        <?php if ($error): ?>
            <div class="row mt-30">
                <div class="col-xs-12">
                    <div class="alertPart">
                        <div class="alert alert-danger alert-common" role="alert">
                            <i class="tf-ion-close-circled"></i><span>Login Failed!</span> Invalid username/password
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <div class="container">
            <div class="top">
                <span>Welcome to Tapyta Furniture</span>
                <header>Login</header>
            </div>
            <!-- Formulir login -->
            <form class="text-left clearfix" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                <div class="input-field">
                    <input type="email" name="email" class="form-control" placeholder="Email" />
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-field">
                    <input type="password" name="password" class="form-control" placeholder="Password" />
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-field">
                    <button name="login" type="submit" class="submit">Login</button>
                </div>
            </form>
            <div class="register">
                <div class="regis">
                    <label>
                        <p>
                            Don't have an account ?<a href="/register">
                                Create New Account</a>
                        </p>
                    </label>
                </div>
            </div>
        </div>
    </div>
</body>

</html>