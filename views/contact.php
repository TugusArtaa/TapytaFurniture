<?php
// Memasukkan file header.php dan db.php untuk digunakan
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';
?>

<link rel="stylesheet" href="views/css/contact.css">

<?php
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

<body>
    <div class="container">
        <div class="content">
            <p class="cntct animate__animated" data-aos="fade-up">CONTACT</p>
            <h2 class="animate__animated" data-aos="fade-up">CONTACT US</h2>
            <br><br>
            <div class="inside_container">
                <div class="photo animate__animated" data-aos="zoom-in">
                    <img src="views/images/contactt.png" alt="Your Photo">
                </div>
                <div class="map animate__animated" data-aos="zoom-in">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.8611265883337!2d115.15911107387386!3d-8.7991151912533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd244c13ee9d753%3A0x6c05042449b50f81!2sPoliteknik%20Negeri%20Bali!5e0!3m2!1sid!2sid!4v1683504214681!5m2!1sid!2sid"
                        width="1250px" height="602px" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="box animate__animated" data-aos="fade-up">
                    <div class="head-icons">
                        <span><i class="tf-ion-ios-home" style="font-size: 60px;"></i></span>
                        <h3 class="headings">My Address</h3>
                    </div>
                    <span>
                        <?= htmlspecialchars($address) ?>
                    </span>
                </div>
                <div class="box animate__animated" data-aos="fade-up">
                    <div class="head-icons">
                        <span><i class="tf-ion-android-phone-portrait" style="font-size: 60px;"></i></span>
                        <h3 class="headings">Phone</h3>
                    </div>
                    <span>
                        <?= htmlspecialchars($phone) ?>
                    </span>
                </div>
                <div class="box animate__animated" data-aos="fade-up">
                    <div class="head-icons">
                        <span><i class="tf-ion-android-mail" style="font-size: 60px;"></i></span>
                        <h3 class="headings">Email</h3>
                    </div>
                    <span>
                        <?= htmlspecialchars($email) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</body>
<br>
<br>
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