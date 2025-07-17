<?php

// Menggunakan file db.php yang berisi koneksi ke database
require __DIR__ . '/db.php';

// Mengambil nilai Facebook dari tabel contact
$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('facebook'));
$fb = $statement->fetchColumn();

// Mengambil nilai Twitter dari tabel contact
$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('twitter'));
$tw = $statement->fetchColumn();

// Mengambil nilai Instagram dari tabel contact
$statement = $pdo->prepare("SELECT value FROM contact WHERE name=?");
$statement->execute(array('instagram'));
$ig = $statement->fetchColumn();
?>

<!-- Bagian Footer -->
<footer class="footer section text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Social Media Icons -->
                <ul class="social-media">
                    <li>
                        <a href="https://www.facebook.com/<?= $fb ?>">
                            <i class="tf-ion-social-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/<?= $ig ?>">
                            <i class="tf-ion-social-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.twitter.com/<?= $tw ?>">
                            <i class="tf-ion-social-twitter"></i>
                        </a>
                    </li>
                </ul>

                <!-- Footer Menu -->
                <ul class="footer-menu text-uppercase">
                    <li>
                        <a href="/contact">CONTACT</a>
                    </li>
                    <li>
                        <a href="/products">SHOP</a>
                    </li>
                    <li>
                        <a href="/privacy-policy">PRIVACY POLICY</a>
                    </li>
                    <li>
                        <a href="/faq">FAQ</a>
                    </li>
                </ul>

                <!-- Copyright Text -->
                <p class="copyright-text">Copyright Tapyta Furniture &copy;
                    <script>document.write(new Date().getFullYear());</script>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Main jQuery -->
<script src="views/plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.1 -->
<script src="views/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- Main Js File -->
<script src="views/js/script.js"></script>

</body>

</html>