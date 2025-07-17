<?php
// Memasukkan file header.php dan db.php untuk digunakan
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';

// Mengambil data dari tabel about
$statement = $pdo->prepare("SELECT * FROM about");
$statement->execute();
$about = $statement->fetchAll(PDO::FETCH_ASSOC);

// Mengambil data kontak dari tabel contact berdasarkan nama
$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('facebook'));
$fb = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('twitter'));
$tw = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('instagram'));
$ig = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('phone'));
$phone = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('address'));
$address = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('email'));
$email = $statement->fetchColumn();
?>

<section class="about section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-20 animate__animated" data-aos="zoom-in">
                <!-- Menampilkan gambar about us -->
                <img class="img-responsive" src="views/images/About.jpg">
            </div>
            <div class="col-md-6 animate__animated" data-aos="fade-up">
                <h2>About Our Shop</h2>
                <!-- Menampilkan deskripsi tentang toko -->
                <p>
                    <?= htmlspecialchars($about[0]['about']) ?>
                </p>
            </div>
        </div>
        <div class="row mt-40">
            <div class="contact-details col-md-6 animate__animated" data-aos="fade-up">
                <!-- Menampilkan informasi kontak seperti alamat, nomor telepon, dan email -->
                <ul class="contact-short-info">
                    <li>
                        <i class="tf-ion-ios-home"></i>
                        <span>
                            <?= htmlspecialchars($address) ?>
                        </span>
                    </li>
                    <li>
                        <i class="tf-ion-android-phone-portrait"></i>
                        <span>Phone:
                            <?= htmlspecialchars($phone) ?>
                        </span>
                    </li>
                    <li>
                        <i class="tf-ion-android-mail"></i>
                        <span>Email:
                            <?= htmlspecialchars($email) ?>
                        </span>
                    </li>
                </ul>
                <!-- Menampilkan ikon media sosial dan link ke halaman sosial media -->
                <div class="social-icon">
                    <ul>
                        <li><a class="fb-icon" href="https://facebook.com/<?= $fb ?>"><i
                                    class="tf-ion-social-facebook"></i></a></li>
                        <li><a href="https://twitter.com/<?= $tw ?>"><i class="tf-ion-social-twitter"></i></a></li>
                        <li>
                            <a href="https://www.instagram.com/<?= $ig ?>">
                                <i class="tf-ion-social-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Memasukkan file footer.php untuk menyelesaikan halaman
require __DIR__ . '/footer.php';
?>
<script>
    AOS.init({
        duration: 1000,
        offset: 200,
        once: true
    });
</script>