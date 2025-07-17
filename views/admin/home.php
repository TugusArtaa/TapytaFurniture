<?php
// Memasukkan file header.php, db.php, dan util.php
require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';
require __DIR__ . '/util.php';

// Mengekspor database jika tombol export ditekan
if (isset($_POST['export'])) {
    exportDB($host, $name, $user, $password);
}

// Mengimpor database jika tombol import ditekan
if (isset($_POST['import'])) {
    importDB($pdo);
}

// Menetapkan rentang tanggal hari ini
$dateRange = array(
    gmdate('Y-m-d') . ' 00:00:00 GMT',
    gmdate('Y-m-d') . ' 22:59:59 GMT'
);

// Menghitung jumlah pesanan pada hari ini
$statement = $pdo->query("SELECT count(*) FROM transactions WHERE timestamp >= '$dateRange[0]' AND timestamp <= '$dateRange[1]'");
$orderCount = $statement->fetchColumn();

// Menginisialisasi variabel pendapatan
$revenue = 0;

// Mengambil data transaksi pada hari ini
$statement = $pdo->prepare("SELECT * FROM transactions WHERE timestamp >= ? AND timestamp <= ?");
$statement->execute($dateRange);
$transactions = $statement->fetchAll(PDO::FETCH_ASSOC);

// Menghitung total pendapatan dari transaksi pada hari ini
foreach ($transactions as $transaction) {
    $details = unserialize($transaction['details']);
    foreach ($details as $detail) {
        $revenue += $detail['price'] * $detail['quantity'];
    }
}

// Menghitung jumlah pengguna
$userCount = $pdo->query("SELECT count(*) FROM users")->fetchColumn();
?>

<!-- Bagian HTML dan tampilan ringkasan -->
<div class="container">
    <!-- Bagian ringkasan -->
    <div class="row">
        <div class="col-md-12 page-header">
            <div class="page-pretitle">Ringkasan</div>
            <h2 class="page-title">Beranda</h2>
        </div>
    </div>

    <!-- Statistik pesanan, pendapatan, dan pengguna -->
    <div class="row">
        <!-- Statistik Pesanan -->
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <!-- Kartu Statistik -->
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="teal fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Pesanan</p>
                                <span class="number">
                                    <?= $orderCount ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Hari Ini
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pendapatan -->
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="olive fas fa-money-bill-alt"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Pendapatan</p>
                                <span class="number">Rp
                                    <?= number_format($revenue, 2) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Hari Ini
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pengguna -->
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="grey fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Pengguna</p>
                                <span class="number">
                                    <?= $userCount ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Semua
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pesanan dan Pendapatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <!-- Grafik Pesanan -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="content">
                            <div class="head">
                                <h5 class="mb-0">Gambaran Pesanan</h5>
                                <p class="text-muted">Pesanan dalam 7 hari terakhir</p>
                            </div>
                            <div class="canvas-wrapper">
                                <canvas class="chart" id="orders"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Pendapatan -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="content">
                            <div class="head">
                                <h5 class="mb-0">Gambaran Pendapatan</h5>
                                <p class="text-muted">Pendapatan dalam 7 hari terakhir</p>
                            </div>
                            <div class="canvas-wrapper">
                                <canvas class="chart" id="revenue"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require __DIR__ . '/footer.php'; ?>
