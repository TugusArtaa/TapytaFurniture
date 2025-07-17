<?php

// Memasukkan file db.php yang berisi koneksi ke database
require __DIR__ . '/../db.php';

// Inisialisasi array untuk menyimpan data grafik
$days = array();
$orders = array();
$revenue = array();

// Mendapatkan tanggal untuk 7 hari ke belakang
$now = new DateTime("7 days ago");
$interval = new DateInterval('P1D');
$period = new DatePeriod($now, $interval, 7);
foreach ($period as $day) {
    $days[] = $day->format('M d');
}

// Looping untuk mengumpulkan data pesanan dan pendapatan setiap hari
for ($i = 6; $i >= 0; $i--) {
    $time = time();
    $dateRange = array(
        gmdate('Y-m-d', $time - ($i * 24 * 60 * 60)) . ' 00:00:00 GMT',
        gmdate('Y-m-d', $time - ($i * 24 * 60 * 60)) . ' 22:59:59 GMT',
    );

    // Menghitung jumlah pesanan pada hari tersebut
    $statement = $pdo->query("SELECT count(*) FROM transactions WHERE timestamp >= '$dateRange[0]' AND timestamp <= '$dateRange[1]'");
    $orders[] = $statement->fetchColumn();

    // Mengambil data transaksi pada hari tersebut
    $statement = $pdo->prepare("SELECT * FROM transactions WHERE timestamp >= '$dateRange[0]' AND timestamp <= '$dateRange[1]'");
    $statement->execute();
    $transactions = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Menghitung total pendapatan dari transaksi pada hari tersebut
    $transactionRevenue = 0;
    foreach ($transactions as $transaction) {
        $details = unserialize($transaction['details']);
        foreach ($details as $detail) {
            $transactionRevenue += $detail['price'] * $detail['quantity'];
        }
    }
    $revenue[] = $transactionRevenue;
}

// Menghasilkan output JSON berisi data untuk grafik
echo json_encode(array($days, $orders, $revenue));
