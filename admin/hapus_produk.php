<?php
include '../koneksi.php';

$id = $_GET['id'];

// Hapus data (Otomatis hapus gambar di DB karena CASCADE, tapi file fisiknya perlu dihapus manual jika mau bersih)
// Disini kita hapus DB saja biar simpel sesuai prototype
$result = mysqli_query($conn, "DELETE FROM products WHERE id_produk = '$id'");
if ($result) {
  echo "
    <script>
      alert('berhasil menghapus produk')
      window.location.href = 'kelola_produk.php'
    </script>
  ";
}
