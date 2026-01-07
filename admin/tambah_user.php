<?php
session_start();
include '../koneksi.php';

if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password = md5($_POST['password']); // Enkripsi MD5 sesuai login.php
  $role = $_POST['role'];

  // Cek email duplikat
  $cek_email = $conn->query("SELECT email FROM users WHERE email = '$email'");
  if ($cek_email->num_rows > 0) {
    echo "<script>alert('Email sudah terdaftar!');</script>";
  } else {
    $query = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";

    if ($conn->query($query)) {
      echo "
            <script>
                alert('Berhasil menambah user baru');
                window.location.href = 'kelola_user.php?role=$role'; 
            </script>";
    } else {
      echo "Error: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah User - Only Phones</title>
  <link rel="stylesheet" href="../assets/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-bg-main font-[Poppins] antialiased text-slate-800">
  <div class="flex h-screen overflow-hidden">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 flex justify-center items-center flex-col h-screen overflow-y-auto relative">
      <div class="p-8 w-full max-w-2xl">
        <div class="bg-white rounded-[24px] p-8 shadow-sm border border-slate-100">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-dark">Tambah User Baru</h2>
            <a href="kelola_user.php?role=admin" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></a>
          </div>

          <form action="" method="POST">
            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
              <input type="text" name="nama" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required placeholder="Contoh: Asep Knalpot">
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
              <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required placeholder="nama@email.com">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required placeholder="********">
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Role (Peran)</label>
                <select name="role" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
                  <option value="user">User / Customer</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>

            <button type="submit" name="simpan" class="w-full bg-blue-main text-white font-bold py-3 rounded-xl cursor-pointer hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
              Simpan User
            </button>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>

</html>