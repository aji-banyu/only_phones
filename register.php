<?php
include 'koneksi.php';


if (isset($_POST['daftar'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password1 = $_POST['password'];
  $password2 = $_POST['password2'];

  if ($nama && $email && $password1 && $password2) {
    $isDuplikat = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($isDuplikat->fetch_assoc()) {
      echo "email sudah ada";
    } else {
      // echo "email belum ada";

      if ($password1 != $password2) {
        echo "
      <script>alert('konfirmasi password tidak sesuai')</script>
      ";
      } else {
        $password = md5($password1);
        $result = $conn->query("INSERT INTO users (nama, email, password, role) values ('$nama', '$email', '$password', 'user')");
        if ($result) {
          echo "
          <script>
            alert('berhasil menambah user')
            window.location.href = 'login.php'
          </script>
          ";
        } else {
          echo mysqli_error($conn);
        }
      }
    }
  } else {
    echo "
      <script>alert('Masukkan semua input dengan benar!')</script>
    ";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi</title>
</head>

<body>
  <h1>Registrasi</h1>

  <!DOCTYPE html>
  <html>

  <head>
    <title>Register</title>
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
          <h2 class="text-4xl font-bold text-white">Register</h2>
          <!-- <p class="text-sm text-gray-500 mt-1">Welcome !</p> -->
        </div>

        <form action="" method="post">

          <div class="mb-5">
            <label for="email" class="block text-[22px] font-semibold text-white mb-2">Name</label>
            <input type="text" id="email" name="nama" placeholder="Enter your Name"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-400">
          </div>

          <div class="mb-5">
            <label for="email" class="block text-[22px] font-semibold text-white mb-2">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-400">
          </div>

          <div class="mb-6 relative">
            <label for="password" class="block text-[22px] font-semibold text-white mb-2">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" placeholder="Enter password"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-400 pr-10">

              <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600">
                <i id="showpass" class='bx  bx-eye text-white text-2xl'></i>
              </div>
            </div>
          </div>

          <div class="mb-6 relative">
            <label for="password2" class="block text-[22px] font-semibold text-white mb-2">Password</label>
            <div class="relative">
              <input type="password" id="password2" name="password2" placeholder="Enter password"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-400 pr-10">

              <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-gray-600">
                <i id="showpass2" class='bx  bx-eye text-white text-2xl'></i>
              </div>
            </div>
          </div>

          <button type="submit" name="daftar"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-500/30 transition duration-300 transform active:scale-95">
            Register
          </button>
        </form>

        <div class="mt-6 text-center">
          <p class="text-sm text-white">
            Already have an account?
            <a href="login.php" class="text-blue-600 font-bold hover:underline">Log in now</a>
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