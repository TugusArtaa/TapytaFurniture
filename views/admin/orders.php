<?php
// Memasukkan file header.php yang mungkin berisi konfigurasi halaman header
require __DIR__ . '/header.php';

// Memasukkan file db.php yang berisi koneksi ke database
require __DIR__ . '/../db.php';

// Mendefinisikan variabel $transactions
$transactions;

// Mengambil semua transaksi dari database dan mengurutkannya berdasarkan id secara descending
$statement = $pdo->prepare("SELECT * FROM transactions ORDER BY id DESC");
$statement->execute();

// Memeriksa apakah ada transaksi
if ($statement->rowCount() > 0) {
    $transactions = $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
<div class="container">
    <div class="page-title">
        <h3>Orders</h3>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <table width="100%" class="table table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Details</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($transactions)): ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td>
                                    <?= $transaction['name'] ?>
                                </td>
                                <td>
                                    <?= $transaction['email'] ?>
                                </td>
                                <td>
                                    <?= $transaction['address'] ?>
                                </td>
                                <td>
                                    <table width="100%" class="table table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Sub-Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Unserialize details from the transaction
                                            $details = unserialize($transaction['details']);
                                            $total = 0;
                                            
                                            // Loop through each detail and display it
                                            foreach ($details as $detail) {
                                                echo '<tr>';
                                                echo '<td>' . $detail['title'] . '</td>';
                                                echo '<td>Rp ' . number_format($detail['price'], 2) . '</td>';
                                                echo '<td>' . $detail['quantity'] . '</td>';
                                                echo '<td>Rp ' . number_format($detail['price'] * $detail['quantity'], 2) . '</td>';
                                                echo '</tr>';
                                                $total += $detail['price'] * $detail['quantity'];
                                            }
                                            
                                            // Display the total row
                                            echo '<tr>';
                                            echo '<td>Total</td>';
                                            echo '<td></td>';
                                            echo '<td></td>';
                                            echo '<td>Rp ' . number_format($total, 2) . '</td>';
                                            echo '</tr>';
                                            ?>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <?= $transaction['timestamp'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
// Memasukkan file footer.php yang mungkin berisi konfigurasi halaman footer
require __DIR__ . '/footer.php';
?>
