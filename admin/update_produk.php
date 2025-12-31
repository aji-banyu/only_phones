<?php
session_start();
include '../koneksi.php';

// Ambil ID dari URL
$id_produk = $_GET['id'];

// Ambil data produk lama berdasarkan ID untuk ditampilkan di form
$query = "SELECT * FROM products WHERE id_produk = $id_produk";
$data_old = $conn->query($query);
$data = $data_old->fetch_assoc();

// Ambil data brand untuk dropdown
$brands = mysqli_query($conn, "SELECT * FROM brands_category");

if (isset($_POST['save'])) {
  $brand = $_POST['id_brand'];
  $nama_produk = $_POST['nama_produk'];
  $stok = $_POST['stok'];
  $harga = $_POST['harga'];
  $deskripsi = $_POST['deskripsi'];

  // LOGIKA UPDATE FOTO
  // Cek apakah user mengupload foto baru atau tidak
  // Error 4 artinya tidak ada file yang diupload
  if ($_FILES['foto']['error'] === 4) {
    $foto = $data['foto']; // Gunakan nama foto lama dari database
  } else {
    // Jika ada foto baru
    $foto = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $folderImg = "../uploads/foto_produk/";

    // Upload foto baru
    move_uploaded_file($tmp_name, $folderImg . $foto);
  }

  // QUERY UPDATE
  $query = "UPDATE products SET 
              id_brand = '$brand', 
              nama_produk = '$nama_produk', 
              harga = '$harga', 
              stok = $stok, 
              deskripsi = '$deskripsi', 
              foto = '$foto' 
              WHERE id_produk = $id_produk";

  $result = $conn->query($query);

  if ($result) {
    echo "
          <script>
            alert('Produk berhasil diupdate')
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
  <title>Update Produk</title>
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
          <h2 class="text-2xl font-bold text-blue-dark mb-6">Edit Produk</h2>

          <form action="" method="POST" enctype="multipart/form-data">

            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
              <input value="<?= htmlspecialchars($data['nama_produk']) ?>" type="text" name="nama_produk" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Brand</label>
                <select name="id_brand" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
                  <option value="">Pilih Brand</option>
                  <?php while ($b = mysqli_fetch_assoc($brands)): ?>
                    <option value="<?= $b['id_brand']; ?>" <?= ($data['id_brand'] == $b['id_brand']) ? 'selected' : '' ?>>
                      <?= $b['nama_brand']; ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                <input value="<?= htmlspecialchars($data['stok']) ?>" type="number" name="stok" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
              </div>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
              <input value="<?= htmlspecialchars($data['harga']) ?>" type="number" name="harga" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main" required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
              <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-main"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
            </div>

            <div class="mb-6">
              <label class="block text-sm font-bold text-gray-700 mb-2">Foto Utama</label>

              <div class="mb-2">
                <img src="../uploads/foto_produk/<?= $data['foto'] ?>" alt="Foto Lama" class="w-20 h-20 object-cover rounded-md border">
                <p class="text-xs text-gray-500 mt-1">*Biarkan kosong jika tidak ingin mengubah foto</p>
              </div>

              <input type="file" name="foto" class="w-full p-2 border border-gray-200 rounded-xl" accept="image/*">
            </div>

            <button type="submit" name="save" class="w-full bg-blue-main text-white font-bold py-3 rounded-xl cursor-pointer hover:bg-blue-700 transition">Update Produk</button>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>

</html>