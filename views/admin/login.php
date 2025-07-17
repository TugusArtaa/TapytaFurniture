<?php
// Memulai sesi PHP
session_start();

// Memerlukan file database
require __DIR__ . '/../db.php';

// Inisialisasi variabel error
$error = false;

// Memeriksa apakah formulir login telah disubmit
if (isset($_POST['submit'])) {
    // Mengambil nilai username dan password dari formulir
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    // Mempersiapkan dan menjalankan query untuk mendapatkan data admin dengan username yang sesuai
    $statement = $pdo->prepare("SELECT * FROM admin WHERE username=?");
    $statement->execute(array($username));

    // Memeriksa apakah ada hasil yang ditemukan
    if ($statement->rowCount() > 0) {
        // Mengambil hasil query
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Memeriksa apakah password yang dimasukkan sesuai dengan hash yang disimpan di database
        if (password_verify($password, $result[0]['password'])) {
            // Jika cocok, mengeset variabel sesi 'admin' dan mengarahkan ke halaman admin
            $_SESSION['admin'] = 'admin';
            header('Location: /admin/home');
        }

        // Mengeset variabel error karena password tidak sesuai
        $error = true;
    }

    // Mengeset variabel error jika tidak ada hasil dari query
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tapyta Furniture | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/views/admin/assets/css/auth.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="views/images/Favicon.png" />
</head>

<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <?php if ($error): ?>
                        <!-- Menampilkan pesan kesalahan jika login gagal -->
                        <div class="alert alert-danger" role="alert">Login Failed, Incorrect Username/Password</div>
                    <?php endif ?>
                    <h6 class="mb-4 text-muted">Login Admin Tapyta Furniture</h6>
                    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                        <div class="mb-3 text-start">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3 text-start">
                            <div class="form-check">
                                <input class="form-check-input" name="remember" type="checkbox" value="" id="check1">
                                <label class="form-check-label" for="check1">
                                    Remember me on this device
                                </label>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary shadow-2 mb-4">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/views/admin/assets/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
        crossorigin="anonymous"></script>
</body>

</html>