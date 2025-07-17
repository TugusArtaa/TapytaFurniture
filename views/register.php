<?php
// Memulai sesi
session_start();
// Memasukkan file db.php
require __DIR__ . '/db.php';

// Memeriksa apakah pengguna telah login, jika iya, redirect ke halaman utama
if (isset($_SESSION['name'])) {
    header('Location: /');
}

// Inisialisasi variabel error
$error = false;
$error_message = '';

// Memeriksa apakah form pendaftaran telah dikirim
if (isset($_POST['register'])) {
    // Mengambil dan membersihkan data dari form
    $lastname = filter_input(INPUT_POST, 'lastname');
    $firstname = filter_input(INPUT_POST, 'firstname');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone');
    $address = filter_input(INPUT_POST, 'address');
    $password = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT);
    $createdTime = time();

    // Validasi input
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($address) || empty($_POST['password'])) {
        $error = true;
        $error_message = 'All fields are required';
    } else {
        // Memeriksa apakah email sudah terdaftar
        $statement = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $statement->execute(array($email));

        // Jika email sudah terdaftar, set variabel error menjadi true
        if ($statement->rowCount() > 0) {
            $error = true;
            $error_message = 'Email already registered';
        } else {
            // Jika email belum terdaftar, tambahkan pengguna baru ke database
            $statement = $pdo->prepare("INSERT INTO users (firstname, lastname, email, phone, address, password, created) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $statement->execute(array($firstname, $lastname, $email, $phone, $address, $password, $createdTime));

            // Set session untuk pengguna yang baru terdaftar
            $_SESSION['name'] = $lastname . ' ' . $firstname;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['address'] = $address;
            $_SESSION['created-time'] = $createdTime;

            // Redirect ke halaman utama setelah pendaftaran berhasil
            header('Location: /');
        }
    }
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
    <link rel="stylesheet" href="views/css/styleregis.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Registration | Page</title>
</head>

<body>
    <div class="box">
        <video id="bg-video" src="views/images/bgVideo.mp4" loop muted autoplay></video>

        <?php if ($error): ?>
            <!-- Tampilkan pesan error jika registrasi gagal -->
            <div class="row mt-30">
                <div class="col-xs-12">
                    <div class="alertPart">
                        <div class="alert alert-danger alert-common" role="alert"><i
                                class="tf-ion-close-circled"></i><span>Registration Failed!</span> Email already
                            registered</div>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <div class="container">
            <div class="top">
                <header>Register</header>
            </div>
            <!-- Formulir pendaftaran pengguna baru -->
            <form class="text-left clearfix" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                <div class="input-field">
                    <input type="text" name="firstname" class="form-control" placeholder="Firstname" />
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-field">
                    <input type="text" name="lastname" class="form-control" placeholder="Lastname" />
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-field">
                    <input type="email" name="email" class="form-control" placeholder="Email" />
                    <i class='bx bx-envelope'></i>
                </div>
                <div class="input-field">
                    <input type="tel" name="phone" class="form-control" placeholder="Phone" />
                    <i class='bx bx-phone'></i>
                </div>
                <div class="input-field">
                    <input type="text" name="address" class="form-control" placeholder="Address" />
                    <i class='bx bx-home'></i>
                </div>
                <div class="input-field">
                    <input type="password" name="password" class="password" placeholder="Password" />
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-field">
                    <button name="register" type="submit" class="submit">
                        Registrasi
                    </button>
                </div>
                <div class="register">
                    <div class="regis">
                        <label>
                            <p>You have an account ?<a href="/login"> Login</a></p>
                        </label>
                    </div>
                </div>
        </div>
    </div>
</body>

</html>