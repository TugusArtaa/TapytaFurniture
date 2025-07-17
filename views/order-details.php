<?php

// Memasukkan file header.php dan db.php
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['name'])) {
    header('Location: /login');
}

// Memeriksa apakah parameter id tersedia dalam URL
if (!isset($_GET['id'])) {
    header('Location: /profile');
}

// Variabel untuk menyimpan detail transaksi
$details;

// Mengeksekusi query untuk mendapatkan detail transaksi berdasarkan id dan email pengguna
$statement = $pdo->prepare("SELECT * FROM transactions WHERE id=? AND email=?");
$statement->execute(array(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT), $_SESSION['email']));

// Memeriksa apakah transaksi ditemukan
if ($statement->rowCount() > 0) {
    $transaction = $statement->fetchAll(PDO::FETCH_ASSOC);
    $details = unserialize($transaction[0]['details']);
}
?>

<?php if (isset($details)): ?>
    <!-- Bagian untuk menampilkan detail transaksi jika ditemukan -->
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="dashboard-wrapper user-dashboard">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Item Price</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($details as $detail): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($detail['title']) ?>
                                        </td>
                                        <td>Rp
                                            <?= number_format($detail['price'], 2) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($detail['quantity']) ?>
                                        </td>
                                        <td>
                                            <?= number_format($detail['price'] * $detail['quantity'], 2) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>Rp
                                            <?php
                                            $total = 0;
                                            foreach ($details as $detail) {
                                                $total += $detail['price'] * $detail['quantity'];
                                            }
                                            echo number_format($total, 2);
                                            ?>
                                        </b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <!-- Bagian untuk menampilkan pesan jika transaksi tidak ditemukan -->
    <section class="empty-cart page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <h2 class="text-center">Transaction not found.</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>

<?php require __DIR__ . '/footer.php'; ?>