<?php

// Memulai output buffering dan session
ob_start();
session_start();

// Memeriksa apakah pengguna telah login sebagai admin
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Pengaturan awal halaman HTML -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Tapyta Furniture | Dashboard</title>

    <!-- Menambahkan stylesheet -->
    <link href="/views/admin/assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="/views/admin/assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="/views/admin/assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/views/admin/assets/css/master.css" rel="stylesheet">
    <link href="/views/admin/assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="/views/admin/assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
</head>

<body>
    <!-- Wrapper utama untuk layout -->
    <div class="wrapper">
        <!-- Sidebar navigasi -->
        <nav id="sidebar" class="active">
            <ul class="list-unstyled components text-secondary">
                <!-- Menu sidebar -->
                <li>
                    <a href="/admin/home"><i class="fas fa-home"></i>Home</a>
                </li>
                <li>
                    <a href="/admin/products"><i class="fas fa-shopping-cart"></i>Products</a>
                </li>
                <li>
                    <a href="/admin/customers"><i class="fas fa-user"></i></i>Customers</a>
                </li>
                <li>
                    <a href="/admin/orders"><i class="fas fa-file"></i>Orders</a>
                </li>
                <li>
                    <a href="/admin/faq"><i class="fas fa-info-circle"></i>Faq</a>
                </li>
                <li>
                    <a href="/admin/settings"><i class="fas fa-cog"></i>Settings</a>
                </li>
            </ul>
        </nav>

        <!-- Konten utama -->
        <div id="body" class="active">
            <!-- Navbar navigasi -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                        <!-- Dropdown menu untuk nama pengguna -->
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span>
                                        <?= $_SESSION['admin'] ?>
                                    </span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <!-- Isi dropdown menu -->
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="/admin/logout" class="dropdown-item"><i
                                                    class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Akhir navigasi navbar -->
            <!-- Konten halaman -->
            <div class="content">
