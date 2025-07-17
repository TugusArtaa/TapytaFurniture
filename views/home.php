<?php

require __DIR__ . '/header.php';
require __DIR__ . '/db.php';
?>

<link rel="stylesheet" href="views/css/welcomestyle.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
	integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous" />

<?php
$items;
$statement = $pdo->prepare("SELECT * FROM products ORDER BY rand() LIMIT 9");
$statement->execute();
if ($statement->rowCount() > 0) {
	$items = $statement->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!-- Bagian HTML untuk welcome section -->
<section class="welcome-section animate__animated" data-aos="fade-up">
	<div class="img-section-welcome">
		<div class="img-box-welcome">
			<div class="social-icon-welcome">
				<ul class="social-menu-welcome">
					<li class="icon-list text-welcome">Social Media</li>
					<li class="icon-list-welcome">
						<a href="https://www.facebook.com/<?= $fb ?>">
							<i class="tf-ion-social-facebook"></i>
						</a>
					</li>
					<li class="icon-list-welcome">
						<a href="https://www.instagram.com/<?= $ig ?>">
							<i class="tf-ion-social-instagram"></i>
						</a>
					</li>
					<li class="icon-list-welcome">
						<a href="https://www.twitter.com/<?= $tw ?>">
							<i class="tf-ion-social-twitter"></i>
						</a>
					</li>
				</ul>
			</div>
			<img src="views/images/Asik.png" alt="" />
		</div>
	</div>
	<div class="text-content-welcome">
		<h1>WELCOME</h1>
		<h2>to Tapyta Furniture</h2>
		<h4>Hello, this is a Best Furniture Website</h4>
		<p>
			We are a platform that encourages exploration, presenting unique furniture that not only meets practical
			needs, but also creates a special atmosphere that celebrates beauty and comfort.
		</p>
		<button onclick="redirectToProducts()">Shop Now</button>
	</div>
</section>
<!-- Bagian HTML untuk banner image slider -->
<section class="banner-slider bg-gray section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="row">
					<div class="title text-center animate__animated" data-aos="fade-up">
						<h2 style="font-size: 30px; font-weight: bold;">What a New Today?</h2>
						<hr class="my-4">
					</div>
				</div>
				<!-- Carousel -->
				<div id="bannerCarousel" class="carousel slide animate__animated" data-aos="zoom-in"
					data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<a href="/products" data-link>
								<img src="views/images/slider/tapyta-1.jpg" alt="Slide 1">
							</a>
						</div>
						<div class="item">
							<a href="/products" data-link>
								<img src="views/images/slider/tapyta-2.jpg" alt="Slide 2">
							</a>
						</div>
						<div class="item">
							<a href="/products" data-link>
								<img src="views/images/slider/tapyta-3.jpg" alt="Slide 3">
							</a>
						</div>
						<div class="item">
							<a href="/products" data-link>
								<img src="views/images/slider/tapyta-4.jpg" alt="Slide 4">
							</a>
						</div>
					</div>


					<!-- Tombol navigasi kiri dan kanan -->
					<a class="left carousel-control" href="#bannerCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#bannerCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Bagian HTML untuk menampilkan produk -->
<section class="products section bg-gray">
	<div class="container">
		<div class="row">
			<div class="title text-center animate__animated" data-aos="fade-up">
				<h2 style="font-size: 30px; font-weight: bold;">What would you like today?</h2>
				<hr class="my-4">
			</div>
		</div>
		<div class="row">
			<?php if (isset($items)): ?>
				<?php foreach ($items as $index => $item): ?>
					<!-- Mengulang melalui setiap item dan menampilkan dalam kolom Bootstrap -->
					<div class="col-md-4 animate__animated" data-aos="fade-up">
						<div class="product-item fixed">
							<div class="product-thumb">
								<!-- Menampilkan gambar produk -->
								<img class="img-responsive" src="<?= htmlspecialchars(unserialize($item['images'])[0]) ?>"
									alt="<?= htmlspecialchars($item['title']) ?>" />
							</div>
							<div class="product-content">
								<!-- Menampilkan judul dan harga produk -->
								<h4><a href="/item?id=<?= htmlspecialchars($item['id']) ?>">
										<?= htmlspecialchars($item['title']) ?>
									</a></h4>
								<p class="price">Rp
									<?= number_format($item['price'], 2) ?>
								</p>
							</div>
						</div>
					</div>
					<!-- Setelah setiap 3 item, tambahkan elemen clearfix untuk membersihkan float -->
					<?php if (($index + 1) % 3 === 0): ?>
						<div class="clearfix"></div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- MULAI BAGIAN LAYANAN -->
<section class="section-services-tapyta">
	<div class="container">
		<div class="row">
			<div class="title text-center animate__animated" data-aos="fade-up">
				<h2 style="font-size: 30px; font-weight: bold;">Our Service Tapyta</h2>
				<hr class="my-4">
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-lg-4">
				<div class="single-service-tapyta animate__animated" data-aos="fade-up">
					<div class="content-tapyta">
						<span class="icon-tapyta">
							<i class="fas fa-bullhorn"></i>
						</span>
						<h3 class="title-tapyta">Harga Terjangkau</h3>
						<p class="description-tapyta">
							Koleksi furnitur berkualitas dengan harga yang terjangkau dan
							Penawaran khusus dan diskon untuk memberikan nilai tambah
							kepada pelanggan yang mencari solusi furnitur murah.
						</p>
					</div>
					<span class="circle-before-tapyta"></span>
				</div>
			</div>
			<div class="col-md-6 col-lg-4">
				<div class="single-service-tapyta animate__animated" data-aos="fade-up">
					<div class="content-tapyta">
						<span class="icon-tapyta">
							<i class="fas fa-heart"></i>
						</span>
						<h3 class="title-tapyta">Pelayanan 24 Jam</h3>
						<p class="description-tapyta">
							Layanan pelanggan yang tersedia 24 jam sehari, 7 hari seminggu
							untuk memberikan bantuan dan jawaban atas pertanyaan pelanggan
							kapan pun dibutuhkan serta memproses pesanan.
						</p>
					</div>
					<span class="circle-before-tapyta"></span>
				</div>
			</div>
			<div class="col-md-6 col-lg-4">
				<div class="single-service-tapyta animate__animated" data-aos="fade-up">
					<div class="content-tapyta">
						<span class="icon-tapyta">
							<i class="fas fa-star"></i>
						</span>
						<h3 class="title-tapyta">Garansi 3 Bulan</h3>
						<p class="description-tapyta">
							Garansi produk selama 3 bulan untuk memberikan kepercayaan
							kepada pelanggan terkait kualitas furnitur yang dibeli, serta
							proses klaim garansi yang mudah dan cepat.
						</p>
					</div>
					<span class="circle-before-tapyta"></span>
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
<script>
	function redirectToProducts() {
		window.location.href = "/products";
	}
</script>