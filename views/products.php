<?php
// Memasukkan file header.php dan db.php
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';

// Inisialisasi variabel-variabel yang akan digunakan
$products;
$searchEmpty = false;
$page = 1;
$results_per_page = 9;
$page_first_result;
$number_of_pages;

// Mempersiapkan query untuk mendapatkan data dari tabel categories
$statement = $pdo->prepare("SELECT * FROM categories ORDER BY title");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

// Mendapatkan nilai halaman dari query string jika tersedia
if (!isset($_GET['p'])) {
	$page = 1;
} else {
	$page = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
}

// Menangani pencarian produk berdasarkan kategori dan kata kunci
if (isset($_POST['q']) && isset($_GET['c'])) {
	$query = filter_input(INPUT_POST, 'q');
	$category = filter_input(INPUT_GET, 'c');
	$statement = $pdo->prepare("SELECT * FROM products WHERE category='$category' AND CONCAT(`title`, `price`, `description`, `category`) LIKE '%$query%'");
	$statement->execute();
	if ($statement->rowCount() > 0) {
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	} else {
		$searchEmpty = true;
	}
} elseif (isset($_POST['q'])) {
	$query = filter_input(INPUT_POST, 'q');
	$statement = $pdo->prepare("SELECT * FROM products WHERE CONCAT(`title`, `price`, `description`, `category`) LIKE '%$query%'");
	$statement->execute();
	if ($statement->rowCount() > 0) {
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	} else {
		$searchEmpty = true;
	}
} elseif (isset($_GET['c'])) {
	// Menangani halaman produk berdasarkan kategori
	$page_first_result = ($page - 1) * $results_per_page;
	$statement = $pdo->prepare("SELECT count(*) FROM products WHERE category=?");
	$statement->execute(array(filter_input(INPUT_GET, 'c')));
	$number_of_result = $statement->fetchColumn();
	$number_of_pages = ceil($number_of_result / $results_per_page);

	$statement = $pdo->prepare("SELECT * FROM products WHERE category=? LIMIT $page_first_result, $results_per_page");
	$statement->execute(array(filter_input(INPUT_GET, 'c')));
	if ($statement->rowCount() > 0) {
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	}
} else {
	// Menangani halaman produk tanpa kategori
	$page_first_result = ($page - 1) * $results_per_page;
	$statement = $pdo->prepare("SELECT count(*) FROM products");
	$statement->execute();
	$number_of_result = $statement->fetchColumn();
	$number_of_pages = ceil($number_of_result / $results_per_page);
	$statement = $pdo->prepare("SELECT * FROM products LIMIT $page_first_result, $results_per_page");
	$statement->execute();
	if ($statement->rowCount() > 0) {
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>

<section class="products section">
	<div class="container">
		<div class="row">
			<!-- Bagian Kategori Produk -->
			<div class="col-md-3 animate__animated" data-aos="fade-up">
				<!-- Widget Kategori Produk -->
				<div class="widget product-category">
					<h4 class="widget-title">Categories</h4>
					<!-- Panel Kategori Produk -->
					<div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
								aria-labelledby="headingOne">
								<div class="panel-body">
									<ul>
										<!-- Menampilkan kategori "All" -->
										<li><a href="/products">All</a></li>
										<!-- Menampilkan kategori-kategori lainnya -->
										<?php foreach ($categories as $category): ?>
											<li><a href="/products?c=<?= htmlspecialchars($category['title']); ?>">
													<?= htmlspecialchars($category['title']); ?>
												</a></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
						<br>
						<!-- Form Pencarian Produk berdasarkan Kategori -->
						<?php if (isset($_GET['c'])): ?>
							<form action="/products?c=<?= filter_input(INPUT_GET, 'c') ?>" method="post">
								<div class="form-group">
									<input name="q" type="search" class="form-control" placeholder="Search...">
								</div>
								<div class="text-center">
									<button name="search" type="submit" class="btn btn-main btn-small">Search</button>
								</div>
							</form>
						<?php else: ?>
							<!-- Form Pencarian Produk secara Umum -->
							<form action="/products" method="post">
								<div class="form-group">
									<input name="q" type="search" class="form-control" placeholder="Search...">
								</div>
								<div class="text-center">
									<button name="search" type="submit" class="btn btn-main btn-small">Search</button>
								</div>
							</form>
						<?php endif ?>
					</div>
				</div>
			</div>
			<!-- Bagian Produk -->
			<div class="col-md-9">
				<div class="row">
					<?php if (!$searchEmpty): ?>
						<?php $count = 0; ?>
						<?php foreach ($products as $product): ?>
							<!-- Menampilkan produk dalam bentuk kartu -->
							<div class="col-md-4 animate__animated" data-aos="fade-up">
								<div class="product-item">
									<div class="product-thumb">
										<img class="img-responsive"
											src="<?= htmlspecialchars(unserialize($product['images'])[0]) ?>"
											alt="product-img" />
									</div>
									<div class="product-content">
										<h4><a href="/item?id=<?= htmlspecialchars($product['id']) ?>">
												<?= htmlspecialchars($product['title']) ?>
											</a></h4>
										<p class="price">Rp
											<?= number_format($product['price'], 2) ?>
										</p>
									</div>
								</div>
							</div>
							<?php $count++; ?>
							<?php if ($count % 3 === 0): ?>
							</div>
							<div class="row">
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else: ?>
						<!-- Menampilkan pesan jika tidak ada hasil pencarian -->
						<div class="col-md-6 col-md-offset-3">
							<div class="block text-center">
								<i class="tf-ion-ios-cart-outline"></i>
								<h2 class="text-center">No items found.</h2>
								<a href="/products" class="btn btn-main mt-20">Return to shop</a>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php if (!isset($_POST['q'])): ?>
				<!-- Bagian Pagination untuk hasil pencarian produk berdasarkan kategori -->
				<div class="row">
					<div class="col-sm-12 text-center">
						<?php
						function generatePaginationLink($page, $category = null)
						{
							return "/products" . ($category ? "?c=$category&" : "?") . "p=$page";
						}

						echo '<div class="pagination">';

						for ($i = max(1, $page - 1); $i <= min($number_of_pages, $page + 1); $i++) {
							echo '<a class="page-link" href="' . generatePaginationLink($i, filter_input(INPUT_GET, 'c')) . '">' . $i . '</a>';

							if ($i < min($number_of_pages, $page + 1)) {
								echo ' <span class="pagination-space">   |   </span> ';
							}
						}
						echo '</div>';
						?>
					</div>
				</div>
			<?php endif ?>
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