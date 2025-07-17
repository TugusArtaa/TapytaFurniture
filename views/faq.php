<?php
// Memasukkan file header untuk tata letak halaman
require __DIR__ . '/header.php';
// Memasukkan file koneksi database
require __DIR__ . '/db.php';
?>

<link rel="stylesheet" href="views/css/tailwind.css" />
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<?php
// Menyiapkan dan mengeksekusi query SQL untuk mengambil pertanyaan dan jawaban FAQ dari database
$statement = $pdo->prepare("SELECT * FROM faq");
$statement->execute();
$faq = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Bagian HTML untuk menampilkan halaman FAQ -->
<section x-data="<?= generateOpenFaqData(count($faq)) ?>"
	class="relative z-20 overflow-hidden bg-white pb-12 pt-20 dark:bg-dark lg:pb-[90px] lg:pt-[120px] animate__animated"
	data-aos="fade-up">
	<div class="container mx-auto">
		<div class="-mx-4 flex flex-wrap">
			<div class="w-full px-4">
				<div class="mx-auto mb-[60px] max-w-[520px] text-center lg:mb-20">
					<h2 class="mb-4 text-3xl font-bold text-dark dark:text-white sm:text-[40px]/[48px]">
						Any Questions? Look Here
					</h2>
					<p class="text-3xl text-body-color dark:text-dark-6">
						There are some frequently asked questions about our store, such as the one below.
					</p>
				</div>
			</div>
		</div>

		<div class="-mx-4 flex flex-wrap">
			<?php foreach ($faq as $index => $data): ?>
				<div class="w-full px-4 lg:w-1/2">
					<div
						class="mb-8 w-full rounded-lg bg-white p-4 shadow-[0px_20px_95px_0px_rgba(201,203,204,0.30)] dark:bg-dark-2 dark:shadow-[0px_20px_95px_0px_rgba(0,0,0,0.30)] sm:p-8 lg:px-6 xl:px-8">
						<button class="faq-btn flex w-full text-left"
							@click="openFaq<?= $index + 1 ?> = !openFaq<?= $index + 1 ?>">
							<div
								class="mr-5 flex h-10 w-full max-w-[40px] items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
								<svg :class="openFaq<?= $index + 1 ?> && 'rotate-180'" width="22" height="22"
									viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path
										d="M11 15.675C10.7937 15.675 10.6219 15.6062 10.45 15.4687L2.54374 7.69998C2.23436 7.3906 2.23436 6.90935 2.54374 6.59998C2.85311 6.2906 3.33436 6.2906 3.64374 6.59998L11 13.7844L18.3562 6.53123C18.6656 6.22185 19.1469 6.22185 19.4562 6.53123C19.7656 6.8406 19.7656 7.32185 19.4562 7.63123L11.55 15.4C11.3781 15.5719 11.2062 15.675 11 15.675Z"
										fill="black" />
								</svg>
							</div>
							<div class="w-full">
								<h4 class="mt-1 text-4xl font-semibold text-dark dark:text-white">
									<?= htmlspecialchars($data['question']) ?>
								</h4>
							</div>
						</button>
						<div x-show.transition="openFaq<?= $index + 1 ?>" class="faq-content pl-[62px]">
							<p class="py-3 text-3xl leading-relaxed text-body-color dark:text-dark-6">
								<?= htmlspecialchars($data['answer']) ?>
							</p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
// Memasukkan file footer untuk menyelesaikan halaman
require __DIR__ . '/footer.php';
?>

<script>
	// Fungsi PHP untuk menghasilkan data x-data dinamis
	<?php
	function generateOpenFaqData($count)
	{
		$openFaqData = '{';
		for ($i = 1; $i <= $count; $i++) {
			$openFaqData .= "openFaq$i: false, ";
		}
		$openFaqData = rtrim($openFaqData, ', ');
		$openFaqData .= '}';
		return $openFaqData;
	}
	?>
</script>
<script>
	AOS.init({
		duration: 1000,
		offset: 200,
		once: true
	});
</script>