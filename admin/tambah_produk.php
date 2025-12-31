<?php
session_start();
include '../koneksi.php';
// Ambil data brand untuk dropdown
$brands = mysqli_query($conn, "SELECT * FROM brands_category");

if (isset($_POST['save'])) {
  $brand = $_POST['id_brand'];
  $nama_produk = $_POST['nama_produk'];
  $stok = $_POST['stok'];
  $harga = $_POST['harga'];
  $deskripsi = $_POST['deskripsi'];

  $foto = $_FILES['foto']['name'];
  $tmp_name = $_FILES['foto']['tmp_name'];

  $query = "INSERT INTO products (id_brand, nama_produk, harga, stok, deskripsi, foto) VALUES ('$brand', '$nama_produk', '$harga', $stok, '$deskripsi', '$foto')";

  $result = $conn->query($query);

  if ($result) {
    $folderImg = "../uploads/foto_produk/";
    move_uploaded_file($tmp_name, $folderImg . $foto);

    echo "
      <script>
        alert('Produk berhasil ditambahkan')
        window.location.href = 'kelola_produk.php'
      </script>
    ";
  } else {
    echo 'Error: ' . mysqli_error($conn);
  }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Tambah Produk</title>

  <link rel="stylesheet" href="../assets/css/output.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body class="bg-bg-main antialiased text-slate-800 font-[Poppins]">
  <div class="flex h-screen overflow-hidden">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 flex justify-center items-center flex-col h-screen overflow-y-auto relative">
      <div class="p-8">
        <div class="max-w-2xl bg-white rounded-[24px] p-8 shadow-sm border border-slate-100">
          <h2 class="text-2xl font-bold text-blue-dark mb-6">Tambah Produk Baru</h2>

          <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="tambah">

            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
              <input type="text" name="nama_produk" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Brand</label>
                <select name="id_brand" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
                  <option value="">Pilih Brand</option>
                  <?php while ($b = mysqli_fetch_assoc($brands)): ?>
                    <option value="<?= $b['id_brand']; ?>"><?= $b['nama_brand']; ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                <input type="number" name="stok" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
              </div>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
              <input type="number" name="harga" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
              <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main"></textarea>
            </div>

            <div class="mb-6">
              <label class="block text-sm font-bold text-gray-700 mb-2">Foto Utama</label>
              <input type="file" name="foto" class="w-full p-2 border border-gray-200 rounded-xl" required accept="image/*">
            </div>

            <button type="submit" name="save" class="w-full bg-blue-main text-white font-bold py-3 rounded-xl cursor-pointer hover:bg-blue-700 transition">Simpan Produk</button>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>

</html>