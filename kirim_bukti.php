<?php
session_start();
include 'koneksi.php';

$id_pesanan = $_GET['id'];

if (isset($_POST['kirim_bukti'])) {
  // Ambil info file
  $nama_foto = time() . "_" . $_FILES['foto_bukti']['name']; // Kasih waktu biar namanya gak kembar
  $lokasi_foto = $_FILES['foto_bukti']['tmp_name'];

  // Buat folder kalau belum ada
  if (!is_dir("uploads/bukti_bayar")) mkdir("uploads/bukti_bayar", 0777, true);

  // Pindahkan foto ke folder
  move_uploaded_file($lokasi_foto, "uploads/bukti_bayar/" . $nama_foto);

  // Update database: Status jadi 'menunggu_konfirmasi'
  $conn->query("UPDATE transactions SET bukti_bayar = '$nama_foto', status = 'menunggu_konfirmasi' WHERE id_transaksi = '$id_pesanan'");

  echo "<script>alert('Mantap! Bukti sudah terkirim. Tunggu admin cek ya.'); location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="assets/css/output.css">
</head>

<body class="flex justify-center items-center h-screen bg-gray-100 font-['Roboto']">
  <div class="bg-white p-8 rounded-xl shadow-lg w-96 text-center">
    <h3 class="text-xl font-bold mb-4">Kirim Bukti Transfer</h3>
    <p class="mb-6 text-sm text-gray-500">Nomor Pesanan: #TRX-<?= $id_pesanan ?></p>

    <form method="post" enctype="multipart/form-data">
      <label class="block text-left font-bold mb-2">Pilih Foto:</label>
      <input type="file" name="foto_bukti" class="w-full border p-2 mb-6 rounded" required accept="image/*">

      <button name="kirim_bukti" class="w-full bg-blue-main text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
        Kirim Sekarang
      </button>
    </form>
    <a href="index.php" class="block mt-4 text-gray-400 text-sm">Kembali ke Home</a>
  </div>
</body>

</html>