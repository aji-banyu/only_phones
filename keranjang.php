<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['user'])) {
  echo "<script>alert('Silakan login dulu!'); location='login.php';</script>";
  exit();
}

// ==========================================================
// 1. LOGIKA HAPUS BARANG (Disini letak rahasianya)
// ==========================================================
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
  $id_hapus = $_GET['id'];

  // Hapus dari database
  $conn->query("DELETE FROM keranjang WHERE id_keranjang = '$id_hapus'");

  // Refresh halaman biar barangnya hilang dari daftar
  echo "<script>alert('Barang berhasil dihapus!'); location='keranjang.php';</script>";
  exit(); // Stop kode biar gak lanjut ke bawah
}
// ==========================================================


$id_pembeli = $_SESSION['user']['id_user'];

// Ambil data keranjang (Urut dari yang terbaru)
$daftar_belanja = $conn->query("SELECT k.*, p.nama_produk, p.harga, p.foto 
                                FROM keranjang k 
                                JOIN products p ON k.id_produk = p.id_produk 
                                WHERE k.id_user = '$id_pembeli'
                                ORDER BY k.id_keranjang DESC");

$jumlah_item = $daftar_belanja->num_rows;
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja - Only Phones</title>

  <link rel="stylesheet" href="assets/css/output.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#f4f7ff] font-['Poppins'] text-slate-800">

  <?php include 'header.php'; ?>

  <div class="container mx-auto mt-28 px-4 mb-20 min-h-[calc(100vh-300px)]">

    <h1 class="text-3xl font-bold text-blue-900 mb-8">Keranjang Belanja</h1>

    <?php if ($jumlah_item == 0): ?>

      <div class="bg-white rounded-[24px] p-12 text-center shadow-sm border border-slate-100 flex flex-col items-center justify-center">
        <div class="w-40 h-40 bg-blue-50 rounded-full flex items-center justify-center mb-6">
          <i class='bx bx-cart-alt text-6xl text-blue-300'></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-700 mb-2">Keranjangmu Kosong</h3>
        <p class="text-gray-400 mb-8">Sepertinya kamu belum menambahkan gadget impianmu.</p>
        <a href="index.php" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
          Mulai Belanja
        </a>
      </div>

    <?php else: ?>

      <div class="flex flex-col lg:flex-row gap-8">

        <div class="flex-1">
          <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
              <thead class="bg-blue-50 text-blue-900">
                <tr>
                  <th class="p-6 font-bold">Produk</th>
                  <th class="p-6 font-bold">Harga</th>
                  <th class="p-6 font-bold text-center">Jumlah</th>
                  <th class="p-6 font-bold text-right">Total</th>
                  <th class="p-6 font-bold text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <?php
                $total_semua = 0;
                while ($barang = $daftar_belanja->fetch_assoc()):
                  $subharga = $barang['harga'] * $barang['jumlah'];
                  $total_semua += $subharga;
                ?>
                  <tr class="hover:bg-gray-50 transition">
                    <td class="p-6">
                      <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center p-2">
                          <img src="uploads/foto_produk/<?= $barang['foto'] ?>" class="w-full h-full object-contain">
                        </div>
                        <div>
                          <h4 class="font-bold text-lg text-slate-700"><?= $barang['nama_produk'] ?></h4>
                        </div>
                      </div>
                    </td>
                    <td class="p-6 text-gray-600 font-medium">
                      Rp <?= number_format($barang['harga'], 0, ',', '.') ?>
                    </td>
                    <td class="p-6 text-center">
                      <span class="bg-gray-100 px-4 py-1 rounded-lg font-bold text-slate-700">
                        <?= $barang['jumlah'] ?> Unit
                      </span>
                    </td>
                    <td class="p-6 text-right font-bold text-blue-600 text-lg">
                      Rp <?= number_format($subharga, 0, ',', '.') ?>
                    </td>
                    <td class="p-6 text-center">

                      <a href="keranjang.php?aksi=hapus&id=<?= $barang['id_keranjang'] ?>"
                        class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white inline-flex items-center justify-center transition"
                        onclick="return confirm('Yakin mau buang barang ini?')">
                        <i class='bx bx-trash text-xl'></i>
                      </a>

                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="w-full lg:w-96">
          <div class="bg-white rounded-[24px] p-8 shadow-sm border border-slate-100 sticky top-32">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Ringkasan Belanja</h3>

            <div class="flex justify-between items-center mb-4 text-gray-500">
              <span>Total Barang</span>
              <span class="font-medium text-slate-700"><?= $jumlah_item ?> Item</span>
            </div>

            <div class="border-t border-dashed border-gray-200 my-4"></div>

            <div class="flex justify-between items-center mb-8">
              <span class="text-lg font-bold text-slate-800">Total Harga</span>
              <span class="text-2xl font-bold text-blue-600">Rp <?= number_format($total_semua, 0, ',', '.') ?></span>
            </div>

            <a href="checkout.php" class="block w-full bg-blue-600 text-white text-center py-4 rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-500/30 mb-3">
              Checkout Sekarang
            </a>

            <a href="index.php" class="block w-full bg-white border border-gray-200 text-slate-600 text-center py-4 rounded-xl font-bold hover:bg-gray-50 transition">
              Lanjut Belanja
            </a>
          </div>
        </div>

      </div>
    <?php endif; ?>

  </div>

</body>

</html>