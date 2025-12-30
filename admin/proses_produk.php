<?php
include '../koneksi.php';

$aksi = $_REQUEST['aksi'];

if ($aksi == 'tambah') {
  $nama = $_POST['nama_produk'];
  $brand = $_POST['id_brand'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  $deskripsi = $_POST['deskripsi'];

  // 1. Insert ke tabel products dulu
  $query = "INSERT INTO products (id_brand, nama_produk, harga, stok, deskripsi) VALUES ('$brand', '$nama', '$harga', '$stok', '$deskripsi')";

  if (mysqli_query($conn, $query)) {
    $id_produk = mysqli_insert_id($conn); // Ambil ID produk yang barusan dibuat

    // 2. Proses Upload Foto
    if (!empty($_FILES['foto']['name'])) {
      $namaFile = time() . '_' . $_FILES['foto']['name']; // Rename biar unik
      $tmpName = $_FILES['foto']['tmp_name'];
      $folder = "../uploads/foto_produk/";

      // Pastikan folder ada
      if (!is_dir($folder)) mkdir($folder, 0777, true);

      if (move_uploaded_file($tmpName, $folder . $namaFile)) {
        // Insert ke tabel product_images
        mysqli_query($conn, "INSERT INTO product_images (id_produk, image_path) VALUES ('$id_produk', '$namaFile')");
      }
    }

    echo "<script>alert('Produk berhasil ditambahkan!'); window.location='kelola_produk.php';</script>";
  } else {
    echo "Error: " . mysqli_error($conn);
  }
} elseif ($aksi == 'hapus') {
  $id = $_GET['id'];

  // Hapus data (Otomatis hapus gambar di DB karena CASCADE, tapi file fisiknya perlu dihapus manual jika mau bersih)
  // Disini kita hapus DB saja biar simpel sesuai prototype
  mysqli_query($conn, "DELETE FROM products WHERE id_produk = '$id'");

  header("Location: kelola_produk.php");
}
