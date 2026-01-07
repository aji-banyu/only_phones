<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

// Ambil data lama
$ambil = $conn->query("SELECT * FROM users WHERE id_user = '$id'");
$data = $ambil->fetch_assoc();

if (isset($_POST['update'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  $password_input = $_POST['password'];

  // Logika Password: Cek apakah diisi atau kosong
  if (empty($password_input)) {
    // Jika kosong, pakai password lama (jangan diubah)
    $query = "UPDATE users SET nama='$nama', email='$email', role='$role' WHERE id_user='$id'";
  } else {
    // Jika diisi, encrypt password baru
    $password_baru = md5($password_input);
    $query = "UPDATE users SET nama='$nama', email='$email', password='$password_baru', role='$role' WHERE id_user='$id'";
  }

  if ($conn->query($query)) {
    echo "
        <script>
            alert('Data user berhasil diupdate');
            window.location.href = 'kelola_user.php?role=$role'; 
        </script>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User - Only Phones</title>
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
            <h2 class="text-2xl font-bold text-blue-dark">Edit User</h2>
            <a href="kelola_user.php?role=<?= $data['role'] ?>" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></a>
          </div>

          <form action="" method="POST">
            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
              <input type="text" name="nama" value="<?= $data['nama'] ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
              <input type="email" name="email" value="<?= $data['email'] ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" placeholder="Kosongkan jika tidak diganti">
                <p class="text-xs text-gray-400 mt-1">*Biarkan kosong jika password tetap sama</p>
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Role (Peran)</label>
                <select name="role" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
                  <option value="user" <?= ($data['role'] == 'user') ? 'selected' : '' ?>>User / Customer</option>
                  <option value="admin" <?= ($data['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                </select>
              </div>
            </div>

            <button type="submit" name="update" class="w-full bg-blue-main text-white font-bold py-3 rounded-xl cursor-pointer hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
              Update User
            </button>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>

</html>