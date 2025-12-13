<?php
session_start();
include 'koneksi.php';

// PROSES LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// PROSES LOGIN
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pegawai = mysqli_real_escape_string($conn, $_POST['nama_pegawai']);
    $id_pegawai = mysqli_real_escape_string($conn, $_POST['id_pegawai']);

    $q = mysqli_query($conn, "SELECT * FROM pegawai WHERE nama_pegawai='$nama_pegawai' AND id_pegawai='$id_pegawai'");
    $data = mysqli_fetch_assoc($q);

    if ($data) {
        $_SESSION['id_pegawai'] = $data['id_pegawai'];
        $_SESSION['nama_pegawai'] = $data['nama_pegawai'];
        $_SESSION['jabatan'] = $data['jabatan'];

        header("Location: home.php");
        exit;
    } else {
        $error = "Nama pegawai atau ID pegawai salah!";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
      html, body { height: 100%; overflow: hidden; }
      .js-fullheight { height: 100%; }
      .ftco-section { height: 100%; display: flex; align-items: center; }
      .social a { display: inline-block; width: 100%; margin-bottom: 10px; }
      .social a span { margin-right: 10px; }
    </style>
  </head>
  <body class="img js-fullheight" style="background-image: url(images/bengkel.png);">
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">Login</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-0">
              <h3 class="mb-4 text-center">Masuk ke akun Anda</h3>

              <?php if (isset($error)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?= htmlspecialchars($error) ?>
                </div>
              <?php endif; ?>

              <form action="" method="post" class="signin-form">
                <div class="form-group">
                  <input name="nama_pegawai" type="text" class="form-control" placeholder="Nama Pegawai" required>
                </div>
                <div class="form-group">
                  <input name="id_pegawai" type="password" class="form-control" placeholder="ID Pegawai" required>
                </div>
                <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary submit px-3 py-3">Sign In</button>
                </div>
              </form>

              <p class="w-100 text-center">&mdash; Atau masuk dengan &mdash;</p>
              <div class="social d-flex text-center">
                <a href="#" onclick="alert('Fitur login sosial belum tersedia')" class="px-2 py-2 mr-md-1 rounded">
                  <span class="fa fa-facebook mr-2"></span> Facebook
                </a>
                <a href="#" onclick="alert('Fitur login sosial belum tersedia')" class="px-2 py-2 ml-md-1 rounded">
                  <span class="fa fa-google mr-2"></span> Google
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="js2/jquery.min.js"></script>
    <script src="js2/popper.js"></script>
    <script src="js2/bootstrap.min.js"></script>
    <script src="js2/main.js"></script>
  </body>
</html>
