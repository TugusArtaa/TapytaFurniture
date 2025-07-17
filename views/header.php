<?php
// Memulai output buffering dan memeriksa status sesi
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="views/images/Favicon.png" />
    <!-- Stylesheet Eksternal -->
    <link rel="stylesheet" href="views/plugins/themefisher-font/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="views/plugins/bootstrap/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animasi CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" />
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="views/css/style.css">
</head>

<body id="body">
    <!-- Bagian Header Atas -->
    <section class="top-header bg-gray">
        <div class="container">
            <div class="row">
                <!-- Informasi Kontak -->
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="contact-number">
                        <i class="tf-ion-ios-telephone"></i>
                        <span>+62-853-6254-1426</span>
                    </div>
                </div>
                <!-- Logo Situs -->
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="logo text-center">
                        <a href="home.php">
                            <!-- Logo TAPYTA -->
                            <svg width="250px" height="29px" viewBox="0 0 155 29" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                    font-size="40" font-family="AustinBold, Austin" font-weight="bold">
                                    <g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
                                        <text id="AVIATO">
                                            <tspan x="108.94" y="325">TAPYTA</tspan>
                                        </text>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <!-- Cart -->
                    <ul class="top-menu text-right list-inline">
                        <li class="dropdown cart-nav dropdown-slide">
                            <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i
                                    class="tf-ion-android-cart"></i>Cart</a>
                            <div class="dropdown-menu cart-dropdown">

                                <?php if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0): ?>
                                    <!-- Menampilkan pesan ketika keranjang kosong -->
                                    <div class="media">
                                        <div class="media-body">
                                            <h4 class="media-heading text-center">Cart is empty</h4>
                                        </div>
                                    </div>

                                    <!-- Menampilkan total harga ketika keranjang kosong -->
                                    <div class="cart-summary">
                                        <span>Total</span>
                                        <span class="total-price">Rp 0.00</span>
                                    </div>

                                    <!-- Tombol untuk melihat keranjang -->
                                    <ul class="text-center cart-buttons">
                                        <li><a href="/cart" class="btn btn-small">View Cart</a></li>
                                    </ul>

                                <?php else: ?>
                                    <!-- Menampilkan detail setiap item dalam keranjang -->
                                    <?php foreach ($_SESSION['cart'] as $item): ?>
                                        <div class="media">
                                            <a class="pull-left" href="#!">
                                                <img class="media-object" src="<?= htmlspecialchars($item['image']) ?>"
                                                    alt="image" />
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="">
                                                        <?= htmlspecialchars($item['title']) ?>
                                                    </a></h4>
                                                <div class="cart-price">
                                                    <span>
                                                        <?= htmlspecialchars($item['quantity']) ?> x
                                                    </span>
                                                    <span>
                                                        <?= number_format($item['price'], 2) ?>
                                                    </span>
                                                </div>
                                                <h5><strong>Rp
                                                        <?= number_format($item['quantity'] * $item['price'], 2) ?>
                                                    </strong></h5>
                                            </div>
                                            <!-- Tombol untuk menghapus item dari keranjang -->
                                            <a href="/cart-remove-item?id=<?= htmlspecialchars($item['id']) ?>"><i
                                                    class="tf-ion-close"></i></a>
                                        </div>
                                    <?php endforeach; ?>

                                    <!-- Menampilkan total harga semua item dalam keranjang -->
                                    <div class="cart-summary">
                                        <span>Total</span>
                                        <span class="total-price">Rp
                                            <?php
                                            $total = 0;
                                            foreach ($_SESSION['cart'] as $item) {
                                                $total += $item['price'] * $item['quantity'];
                                            }
                                            echo number_format($total, 2);
                                            ?>
                                        </span>
                                    </div>

                                    <!-- Tombol untuk melihat keranjang -->
                                    <ul class="text-center cart-buttons">
                                        <li><a href="/cart" class="btn btn-small" data-link>View Cart</a></li>
                                    </ul>
                                <?php endif ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Menu Section -->
    <section class="menu bg-gray">
        <nav class="navbar navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Navbar Links -->
                <div id="navbar" class="navbar-collapse collapse text-center">
                    <ul class="nav navbar-nav">

                        <!-- Home -->
                        <li class="dropdown ">
                            <a href="/" data-link>Home</a>
                        </li>

                        <!-- Shop -->
                        <li class="dropdown ">
                            <a href="/products" data-link>Shop</a>
                        </li>

                        <!--  About -->
                        <li class="dropdown ">
                            <a href="/about" data-link>About</a>
                        </li>

                        <?php if (isset($_SESSION['name'])): ?>
                            <li class="dropdown dropdown-slide">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                    data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?php echo htmlspecialchars($_SESSION['name']); ?><span
                                        class="tf-ion-ios-arrow-down"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/profile">Profile</a></li>
                                    <li><a href="/logout">Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="dropdown dropdown-slide">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                    data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Account <span
                                        class="tf-ion-ios-arrow-down"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/login">Login</a></li>
                                    <li><a href="/register">Register</a></li>
                                </ul>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </section>
</body>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>

</html>