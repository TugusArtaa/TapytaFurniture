<?php
// Memasukkan file header.php dan db.php
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';

// Memeriksa apakah pengguna telah login, jika tidak, redirect ke halaman login
if (!isset($_SESSION['name'])) {
  header('Location: /login');
}

// Memproses pembaruan detail profil pengguna jika ada data yang dikirim melalui POST
if (isset($_POST['update'])) {
  // Memeriksa dan memperbarui firstname pengguna
  if (isset($_POST['firstname'])) {
    $firstname = filter_input(INPUT_POST, 'firstname');
    $statement = $pdo->prepare("UPDATE users SET firstname=? WHERE email=?");
    $statement->execute(array($firstname, $_SESSION['email']));
    $_SESSION['name'] = explode(' ', $_SESSION['name'])[0] . ' ' . $firstname;
  }
  // Memeriksa dan memperbarui lastname pengguna
  if (isset($_POST['lastname'])) {
    $lastname = filter_input(INPUT_POST, 'lastname');
    $statement = $pdo->prepare("UPDATE users SET lastname=? WHERE email=?");
    $statement->execute(array($lastname, $_SESSION['email']));
    $_SESSION['name'] = $lastname . ' ' . explode(' ', $_SESSION['name'])[1];
  }
  // Memeriksa dan memperbarui address pengguna
  if (isset($_POST['address'])) {
    $address = filter_input(INPUT_POST, 'address');
    $statement = $pdo->prepare("UPDATE users SET address=? WHERE email=?");
    $statement->execute(array($address, $_SESSION['email']));
    $_SESSION['address'] = $address;
  }
  // Memeriksa dan memperbarui phone pengguna
  if (isset($_POST['phone'])) {
    $phone = filter_input(INPUT_POST, 'phone');
    $statement = $pdo->prepare("UPDATE users SET phone=? WHERE email=?");
    $statement->execute(array($phone, $_SESSION['email']));
    $_SESSION['phone'] = $phone;
  }
}
?>

<section class="user-dashboard page-wrapper animate__animated" data-aos="fade-up">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <!-- Menu navigasi dashboard pengguna -->
        <ul class="nav nav-pills text-center">
          <li class="active"><a href="/profile"
              style="background-color: #000; color: #fff; border: 1px solid #000;">Profile Details</a></li>
          <li><a href="/orders">Orders</a></li>
        </ul>
        <div class="panel panel-default">
          <div class="panel-body">
            <!-- Formulir untuk memperbarui detail profil pengguna -->
            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
              <div class="form-group">
                <label for="firstname" style="color: #000;">Firstname:</label>
                <input type="text" class="form-control" name="firstname"
                  value="<?= htmlspecialchars(explode(' ', $_SESSION['name'])[1]) ?>">
              </div>
              <div class="form-group">
                <label for="lastname" style="color: #000;">Lastname:</label>
                <input type="text" class="form-control" name="lastname"
                  value="<?= htmlspecialchars(explode(' ', $_SESSION['name'])[0]) ?>">
              </div>
              <div class="form-group">
                <label for="address" style="color: #000;">Address:</label>
                <input type="text" class="form-control" name="address"
                  value="<?= htmlspecialchars($_SESSION['address']) ?>">
              </div>
              <div class="form-group">
                <label for="phone" style="color: #000;">Phone:</label>
                <input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($_SESSION['phone']) ?>">
              </div>
              <button class="btn btn-primary" type="submit" name="update"
                style="background-color: #000; color: #fff; border: 1px solid #000;">Update</button>
            </form>
          </div>
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