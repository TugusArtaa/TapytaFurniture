<?php
// Memulai sesi PHP
session_start();

// Memasukkan file header.php yang berisi bagian awal dari halaman HTML
require __DIR__ . '/header.php';

// Memasukkan file koneksi ke database (db.php)
require __DIR__ . '/db.php';

// Memeriksa apakah parameter 'id' telah diberikan dalam URL
if (!isset($_GET['id'])) {
    // Jika tidak, redirect ke halaman 404
    header('Location: /404');
}

// Inisialisasi variabel yang menandakan apakah produk sudah ada dalam keranjang belanja atau tidak
$inCart = false;

// Memproses formulir penambahan produk ke keranjang belanja
if (isset($_POST['cart'])) {
    $_SESSION['cart'][$_POST['id']] = array(
        'id' => $_POST['id'],
        'title' => $_POST['title'],
        'price' => $_POST['price'],
        'description' => $_POST['description'],
        'category' => $_POST['category'],
        'quantity' => $_POST['quantity'],
        'image' => $_POST['image']
    );
}

// Memeriksa apakah ada produk di dalam keranjang belanja
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if ($item['id'] == $_GET['id']) {
            $inCart = true;
            break;
        }
    }
}

// Mengambil data produk berdasarkan ID dari database
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
$statement->execute(array($id));
$item = $statement->fetchAll(PDO::FETCH_ASSOC);
$images = unserialize($item[0]['images']);

// Mengambil produk terkait berdasarkan kategori produk saat ini
$statement = $pdo->prepare("SELECT * FROM products WHERE category=? ORDER BY rand() LIMIT 4");
$statement->execute(array($item[0]['category']));
$relatedItems = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Bagian HTML untuk menampilkan informasi produk -->
<section class="single-product">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li><a href="/products">Shop</a></li>
                    <li class="active">
                        <?= htmlspecialchars($item[0]['category']); ?>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mt-20">
            <div class="col-md-5">
                <div class="single-product-slider animate__animated" data-aos="zoom-in">
                    <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
                        <div class='carousel-outer'>
                            <div class='carousel-inner '>
                                <?php if (count($images) > 1): ?>
                                    <div class='item active'>
                                        <img src='<?= htmlspecialchars($images[0]) ?>' alt=''
                                            data-zoom-image="<?= htmlspecialchars($images[0]) ?>" />
                                    </div>
                                    <?php
                                    foreach ($images as $key => $image) {
                                        if ($key == 0) {
                                            continue;
                                        }
                                        echo "<div class='item'>";
                                        echo "<img src='" . htmlspecialchars($image) . "' alt='' data-zoom-image='" . htmlspecialchars($image) . "' />";
                                        echo "</div>";
                                    }
                                    ?>
                                <?php else: ?>
                                    <div class='item active'>
                                        <img src='<?= htmlspecialchars($images[0]) ?>' alt=''
                                            data-zoom-image="<?= htmlspecialchars($images[0]) ?>" />
                                    </div>
                                <?php endif ?>
                            </div>
                            <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                                <i class="tf-ion-ios-arrow-left"></i>
                            </a>
                            <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                                <i class="tf-ion-ios-arrow-right"></i>
                            </a>
                        </div>

                        <!-- thumb -->
                        <ol class='carousel-indicators mCustomScrollbar meartlab'>
                            <?php foreach ($images as $image): ?>
                                <li data-target='#carousel-custom' data-slide-to='0' class='active'>
                                    <img src='<?= htmlspecialchars($image) ?>' alt='' />
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <form action="/item?id=<?= htmlspecialchars($item[0]['id']) ?>" method="post">
                    <div class="single-product-details animate__animated" data-aos="fade-up">
                        <h2>
                            <?= htmlspecialchars($item[0]['title']) ?>
                        </h2>
                        <input type="text" name="title" value="<?= htmlspecialchars($item[0]['title']) ?>" hidden>
                        <p class="product-price">Rp
                            <?= number_format($item[0]['price'], 2) ?>
                        </p>
                        <input type="text" name="price" value="<?= htmlspecialchars($item[0]['price']) ?>" hidden>
                        <input type="text" name="image"
                            value="<?= htmlspecialchars(unserialize($item[0]['images'])[0]) ?>" hidden>
                        <p class="product-description mt-20">
                            <?= htmlspecialchars($item[0]['description']) ?>
                            <input type="text" name="description"
                                value="<?= htmlspecialchars($item[0]['description']) ?>" hidden>
                        </p>
                        <div class="product-quantity">
                            <span>Quantity:</span>
                            <div class="product-quantity-slider">
                                <input id="product-quantity" type="number" min=1 value="1" name="quantity">
                            </div>
                        </div>
                        <div class="product-category">
                            <span>Categories:</span>
                            <ul>
                                <li><a href="/products?c=<?= htmlspecialchars($item[0]['category']) ?>">
                                        <?= htmlspecialchars($item[0]['category']) ?>
                                    </a></li>
                                <input type="text" name="category" value="<?= htmlspecialchars($item[0]['category']) ?>"
                                    hidden>
                            </ul>
                        </div>
                        <input type="text" name="id" value="<?= htmlspecialchars($item[0]['id']) ?>" hidden>
                        <?php if ($inCart): ?>
                            <button name="cart" type="submit" class="btn btn-main text-center" disabled>Add to Cart</button>
                        <?php else: ?>
                            <button name="cart" type="submit" class="btn btn-main text-center">Add to Cart</button>
                        <?php endif ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Bagian HTML untuk menampilkan produk terkait -->
<section class="products related-products section animate__animated" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="title text-center">
                <h2>Related Products</h2>
            </div>
        </div>
        <div class="row">
            <?php foreach ($relatedItems as $item): ?>
                <div class="col-md-3">
                    <div class="product-item">
                        <div class="product-thumb">
                            <img class="img-responsive" src="<?= htmlspecialchars(unserialize($item['images'])[0]) ?>"
                                alt="<?= htmlspecialchars($item['title']) ?>" />
                            <div class="preview-meta">
                                <ul>
                                    <li>
                                        <span data-toggle="modal" data-target="#product-modal">
                                            <i class="tf-ion-ios-search"></i>
                                        </span>
                                    </li>
                                    <li>
                                        <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                    </li>
                                    <li>
                                        <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4><a href="/item?id=<?= htmlspecialchars($item['id']) ?>">
                                    <?= htmlspecialchars($item['title']) ?>
                                </a></h4>
                            <p class="price">Rp
                                <?= number_format($item['price'], 2) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

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