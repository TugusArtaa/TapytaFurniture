<?php

// Memasukkan file header.php dan db.php
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['name'])) {
    header('Location: /login');
}

// Variabel untuk menyimpan data pesanan
$orders;

// Mengeksekusi query untuk mendapatkan semua transaksi pengguna berdasarkan email, diurutkan berdasarkan ID secara descending
$statement = $pdo->prepare("SELECT * FROM transactions WHERE email=? ORDER BY id DESC");
$statement->execute(array($_SESSION['email']));

// Mengambil hasil query dan menyimpannya dalam variabel $orders
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<section class="user-dashboard page-wrapper animate__animated" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Navigasi tab untuk menuju halaman profil dan daftar pesanan -->
                <ul class="nav nav-pills text-center">
                    <li><a href="/profile">Profile Details</a></li>
                    <li class="active"><a href="/orders"
                            style="background-color: #000; color: #fff; border: 1px solid #000;">Orders</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <!-- Tabel untuk menampilkan daftar pesanan -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <!-- Kolom untuk menampilkan tanggal pesanan -->
                                            <td>
                                                <?= htmlspecialchars($order['timestamp']) ?>
                                            </td>

                                            <!-- Kolom untuk menampilkan total harga pesanan -->
                                            <td>Rp
                                                <?php
                                                // Menghitung total harga pesanan
                                                $details = unserialize($order['details']);
                                                $total = 0;
                                                foreach ($details as $detail) {
                                                    $total += $detail['price'] * $detail['quantity'];
                                                }
                                                echo number_format($total, 0, ',', '.');
                                                ?>
                                            </td>

                                            <!-- Kolom untuk menampilkan status pesanan -->
                                            <td>
                                                <?php
                                                $orderStatus = "Success";
                                                echo "<span style='color: green;'>$orderStatus</span>";
                                                ?>
                                            </td>

                                            <!-- Kolom untuk menampilkan tombol "Lihat" yang mengarah ke halaman detail pesanan -->
                                            <td><a href="/order-details?id=<?= htmlspecialchars($order['id']) ?>"
                                                    class="btn btn-default"
                                                    style="background-color: #000; color: #fff; border: 1px solid #000;">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>
<script>
    AOS.init({
        duration: 1000,
        offset: 200,
        once: true
    });
</script>