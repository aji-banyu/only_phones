<?php
session_start();
include 'koneksi.php';

$pass_salah_message = '';
$email_salah_message = '';

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $ambil = $conn->query("SELECT * FROM users WHERE email='$email'");
  $yang_cocok = $ambil->num_rows;

  if ($yang_cocok == 1) {
    $akun = $ambil->fetch_assoc();
    $password = $akun['password'];

    global $pass_salah_message;
    global $email_salah_message;

    if (trim($password) === trim(md5($pass))) {
      global $pass_salah_message;

      // SUKSES
      $_SESSION['user'] = $akun;
      global $pass_salah_message;

      if ($akun['role'] == 'admin') {
        header("location:admin/index.php");
      } else {
        header("location:index.php");
      }
    } else {
      $pass_salah_message = "Login Gagal: Password Salah!";
    }
  } else {
    $email_salah_message = "Login Gagal: Email tidak ditemukan!";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Login </title>
  <link rel="stylesheet" href="assets/css/output.css">
  <link rel="stylesheet" href="assets/css/custom.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <!-- boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>

</head>
<style>
  body {
    background-image: url(assets/images/bg\ login.regis\ \(1\).png)
  }

  #i {
    backdrop-filter: blur(4px);
  }
</style>

<body class="container mx-auto flex justify-center items-center min-h-screen">

  <div class="absolute -z-10 w-full h-full bg-[rgba(0,0,0,.7)]"></div>

  <div class="navbar fixed top-0 left-0 w-full h-auto py-10 px-64">
    <a href="index.php" class="block bg-[rgba(255,255,255,.7)] w-max p-3 rounded-2xl">
      <img src="assets/images/Only Phones.png" class="w-80" alt="">
    </a>
  </div>

  <div class="w-max p-6">

    <div id="i" class="w-125 bg-[rgba(0,0,0,.6)]  rounded-3xl shadow-xl p-8 sm:p-10 border border-gray-100">

      <div class="mb-16 text-center">
        <h2 class="text-4xl font-bold text-white">Log in </h2>
      </div>

      <form action="" method="post">

        <div class="mb-5">
          <label for="email" class="block text-[22px] font-semibold text-white mb-2">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email"
            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-400">

          <div class="text-red-500 mt-2.5"><?= $email_salah_message ?></div>

        </div>

        <div class="relative">
          <label for="password" class="block text-[22px] font-semibold text-white mb-2">Password</label>
          <div class="relative">
            <input type="password" id="password" name="password" placeholder="Enter password"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-400 pr-10">


            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600">
              <i id="showpass" class='bx  bx-eye text-white text-2xl'></i>
            </div>
          </div>
        </div>
        <div class="mb-6 text-red-500 mt-2.5"><?= $pass_salah_message ?></div>

        <button type="submit" name="login"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-500/30 transition duration-300 transform active:scale-95">
          Log in
        </button>
      </form>

      <div class="mt-6 text-center">
        <p class="text-sm text-white">
          Don't have an account?
          <a href="register.php" class="text-blue-600 font-bold hover:underline">Sign up now</a>
        </p>
      </div>
    </div>

    <p class="text-center text-gray-400 text-xs mt-8">
      &copy; 2025 Only Phones
    </p>

  </div>

  <script src="assets/js/showpass.js"></script>
</body>

</html>