<?php

// Memasukkan file header.php dan db.php
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';

// Mempersiapkan dan mengeksekusi query untuk mendapatkan data dari tabel policy
$statement = $pdo->prepare("SELECT * FROM policy");
$statement->execute();

// Mengambil hasil query dan menyimpannya dalam variabel $data sebagai array asosiatif
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<section class="about section">
	<div class="container animate__animated" data-aos="fade-up">
		<div class="row">
			<div class="col-md-12" d-flex align-items-center justify-content-center">
				<!-- Bagian konten "About" -->
				<div class="about-content text-center">
					<!-- Judul dari bagian "Privacy Policy" -->
					<h2 class="section-title">Privacy Policy</h2>
					<hr class="my-4">
					<br><br>
					<!-- Deskripsi atau isi dari kebijakan privasi -->
					<p class="section-description text-justify">
						<?= nl2br(htmlspecialchars($data[0]['policy'])) ?>
					</p>
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