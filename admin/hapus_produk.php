<?php
include '../koneksi.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "DELETE FROM products WHERE id_produk = '$id'");
if ($result) {
  echo "
    <script>
      alert('berhasil menghapus produk')
      window.location.href = 'kelola_produk.php'
    </script>
  ";
}
