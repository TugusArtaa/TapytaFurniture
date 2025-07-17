<?php
// Memulai output buffering
ob_start();

// Memulai sesi PHP jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Memasukkan file koneksi database
require __DIR__ . '/db.php';

// Autoload Composer untuk memuat kelas Midtrans
require __DIR__ . '/../vendor/autoload.php';

// Simpan detail belanja ke dalam database
$details = serialize($_SESSION['cart']);
$timestamp = gmdate('Y-m-d h:i:s');
$statement = $pdo->prepare("INSERT INTO transactions (name, email, address, details, timestamp) VALUES (?, ?, ?, ?, ?)");
$statement->execute(array($_SESSION['name'], $_SESSION['email'], $_SESSION['address'], $details, $timestamp));

// Set kredensial Midtrans dari .env atau nilai tetap
$merchant_id = 'G153451166';
$client_key = 'SB-Mid-client-hvoJiLrKWjGDTPjk';
$server_key = 'SB-Mid-server-iMxpu3Ki6sKDkMKAW7RsVpqZ';

// Konfigurasi kredensial Midtrans
Midtrans\Config::$serverKey = $server_key;
Midtrans\Config::$clientKey = $client_key;

// Proses pembayaran menggunakan Midtrans
$transaction_details = [
    'order_id' => uniqid(),
    'gross_amount' => calculateTotalAmount($_SESSION['cart']),
];

$item_details = generateItemDetails($_SESSION['cart']);

$customer_details = [
    'first_name' => $_SESSION['name'],
    'email' => $_SESSION['email'],
];

$transaction = [
    'enabled_payments' => [
        'credit_card',
        'cimb_clicks',
        'mandiri_clickpay',
        'echannel',
        'alfamart',
        'indomaret',
        'akulaku',
        'gopay',
        'qris',
    ],
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
];

try {
    // Mendapatkan token Snap dari Midtrans
    $snapToken = Midtrans\Snap::getSnapToken($transaction);
} catch (Exception $e) {
    // Menangani kesalahan saat memproses pembayaran
    echo "Error saat memproses pembayaran: " . $e->getMessage();
    exit;
}

// Fungsi bantu untuk menghitung total jumlah pembelian
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
    $item_details = [];
    foreach ($cart as $item) {
        $item_details[] = [
            'id' => $item['id'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'name' => $item['title'],
        ];
    }
    return $item_details;
}
?>

<body onload="payFunction()">

    <!-- Input field tersembunyi untuk menyimpan URL pengalihan -->
    <input type="hidden" id="redirect-url" value="/confirmation">

    <!-- Bagian script untuk mengintegrasikan Midtrans -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $client_key; ?>"></script>
    <script type="text/javascript">
        function payFunction() {
            snap.pay('<?= $snapToken ?>', {
                onSuccess: function (result) {
                    // Arahkan ke confirmation.php setelah pembayaran berhasil
                    var redirectUrl = document.getElementById('redirect-url').value;
                    window.location.href = redirectUrl;

                    // Anda juga dapat menampilkan hasil jika diperlukan
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onPending: function (result) {
                    // Tampilkan hasil pembayaran tertunda
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onError: function (result) {
                    // Tampilkan pesan kesalahan pembayaran
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        }
    </script>