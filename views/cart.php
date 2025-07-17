<?php
// Memasukkan file header.php, db.php, dan autoload.php dari vendor
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';
require __DIR__ . '/admin/util.php';
require_once 'vendor/autoload.php';

// Set kredensial Midtrans dari file .env atau nilai tetap
$merchant_id = 'G153451166';
$client_key = 'SB-Mid-client-hvoJiLrKWjGDTPjk';
$server_key = 'SB-Mid-server-iMxpu3Ki6sKDkMKAW7RsVpqZ';

// Konfigurasi kredensial Midtrans
Midtrans\Config::$serverKey = $server_key;
Midtrans\Config::$clientKey = $client_key;

// Memproses permintaan POST untuk checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checkout'])) {
        // Memeriksa apakah pengguna sudah login
        if (!isset($_SESSION['name'])) {
            header('Location: /login');
            exit;
        }

        // Simpan detail belanja ke dalam database
        $details = serialize($_SESSION['cart']);
        $timestamp = gmdate('Y-m-d h:i:s');
        $statement = $pdo->prepare("INSERT INTO transactions (name, email, address, details, timestamp) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array($_SESSION['name'], $_SESSION['email'], $_SESSION['address'], $details, $timestamp));

        // Proses pembayaran menggunakan Midtrans
        $transaction_details = array(
            'order_id' => uniqid(),
            'gross_amount' => calculateTotalAmount($_SESSION['cart']),
        );

        $item_details = generateItemDetails($_SESSION['cart']);

        $customer_details = array(
            'first_name' => $_SESSION['name'],
            'email' => $_SESSION['email'],
        );

        $transaction = array(
            'enabled_payments' => array(
                'credit_card',
                'cimb_clicks',
                'mandiri_clickpay',
                'echannel',
                'alfamart',
                'indomaret',
                'akulaku',
                'qris',
            ),
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

        try {
            $snapToken = Midtrans\Snap::getSnapToken($transaction);
            // Redirect ke halaman pembayaran Midtrans
            header("Location: https://app.sandbox.midtrans.com/snap/snap.js?token={$snapToken}");
            exit;
        } catch (Exception $e) {
            // Tangani kesalahan, log, atau tampilkan pesan kesalahan
            echo "Error processing payment: " . $e->getMessage();
            exit;
        }
    }
}

// Bagian tampilan keranjang
?>
<?php if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0): ?>
    <!-- Jika keranjang kosong, tampilkan pesan -->
    <section class="empty-cart page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <i class="tf-ion-ios-cart-outline"></i>
                        <h2 class="text-center">Your cart is currently empty.</h2>
                        <a href="/products" class="btn btn-main mt-20">Return to shop</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <!-- Jika keranjang tidak kosong, tampilkan isi keranjang -->
    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <form action="views/checkout-process.php" method="POST">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="">Item Name</th>
                                                <th class="">Item Price</th>
                                                <th class="">Quantity</th>
                                                <th class="">Actions</th>
                                                <th class="">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                                <!-- Menampilkan detail produk dalam keranjang -->
                                                <tr class="">
                                                    <td class="">
                                                        <div class="product-info">
                                                            <img width="80" src="<?= htmlspecialchars($item['image']) ?>"
                                                                alt="" />
                                                            <a href="#!">
                                                                <?= htmlspecialchars($item['title']) ?>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td class="">Rp
                                                        <?= number_format($item['price'], 2) ?>
                                                    </td>
                                                    <td class="">
                                                        <?= htmlspecialchars($item['quantity']) ?>
                                                    </td>
                                                    <td class="">
                                                        <a href="/cart-remove-item?id=<?= $item['id'] ?>"
                                                            class="product-remove">Remove</a>
                                                    </td>
                                                    <td class="">Rp
                                                        <?= number_format($item['price'] * htmlspecialchars($item['quantity']), 2) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <!-- Menampilkan total jumlah belanja -->
                                            <tr class="">
                                                <td class="">
                                                    <div class="product-info">
                                                        <a href="#!">Total</a>
                                                    </div>
                                                </td>
                                                <td class=""></td>
                                                <td class=""></td>
                                                <td class=""></td>
                                                <td class="">Rp
                                                    <?php
                                                    if (!isset($_SESSION['cart'])) {
                                                        echo '0.00';
                                                    } else {
                                                        $total = 0;
                                                        foreach ($_SESSION['cart'] as $item) {
                                                            $total += $item['price'] * $item['quantity'];
                                                        }
                                                        echo number_format($total, 2);
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Tombol untuk checkout -->
                                    <button name="checkout" type="submit" class="btn btn-main pull-right">Checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php
// Fungsi bantu untuk menghitung total jumlah belanja
function calculateTotalAmount($cart)
{
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Fungsi bantu untuk menghasilkan detail barang untuk Midtrans
function generateItemDetails($cart)
{
    $item_details = array();
    foreach ($cart as $item) {
        $item_details[] = array(
            'id' => $item['id'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'name' => $item['title'],
        );
    }
    return $item_details;
}
?>

<?php require __DIR__ . '/footer.php'; ?>