<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

// Join table produk dan brand
$query = "SELECT p.*, b.nama_brand 
          FROM products p 
          JOIN brands_category b ON p.id_brand = b.id_brand 
          WHERE p.id_produk = '$id'";

$result = $conn->query($query);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Detail Produk - <?= $data['nama_produk'] ?></title>
  <link rel="stylesheet" href="../assets/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-bg-main font-[Poppins] antialiased text-slate-800">
  <div class="flex h-screen overflow-hidden">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">
      <header class="px-8 py-6 bg-white border-b border-gray-100 flex justify-between items-center sticky top-0 z-40">
        <h1 class="text-2xl font-bold text-blue-dark">Detail Produk</h1>
        <div class="flex gap-3">
          <a href="update_produk.php?id=<?= $data['id_produk'] ?>" class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-xl font-bold hover:bg-yellow-200 transition">
            <i class="fas fa-edit mr-1"></i> Edit
          </a>
          <a href="kelola_produk.php" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl font-bold hover:bg-gray-200 transition">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
          </a>
        </div>
      </header>

      <div class="p-8 max-w-5xl mx-auto w-full">
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            <div class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100">
              <?php if ($data['foto']): ?>
                <img src="../uploads/foto_produk/<?= $data['foto'] ?>" class="max-h-96 w-auto object-contain drop-shadow-xl hover:scale-105 transition-transform duration-300">
              <?php else: ?>
                <div class="text-gray-400 flex flex-col items-center">
                  <i class="fas fa-image text-6xl mb-2"></i>
                  <span>Tidak ada foto</span>
                </div>
              <?php endif; ?>
            </div>

            <div class="flex flex-col justify-center">
              <div class="mb-2">
                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-bold tracking-wide">
                  <?= $data['nama_brand'] ?>
                </span>
              </div>

              <h2 class="text-4xl font-bold text-slate-800 mb-4 leading-tight"><?= $data['nama_produk'] ?></h2>

              <div class="flex items-center gap-4 mb-6">
                <div class="text-3xl font-bold text-blue-main">
                  Rp <?= number_format($data['harga'], 0, ',', '.') ?>
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                  <p class="text-xs text-gray-500 font-bold uppercase mb-1">Stok Tersedia</p>
                  <p class="text-2xl font-bold <?= $data['stok'] > 0 ? 'text-green-500' : 'text-red-500' ?>">
                    <?= $data['stok'] ?> <span class="text-sm text-gray-400 font-normal">Unit</span>
                  </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                  <p class="text-xs text-gray-500 font-bold uppercase mb-1">ID Produk</p>
                  <p class="text-2xl font-bold text-gray-700">#<?= $data['id_produk'] ?></p>
                </div>
              </div>

              <div>
                <h3 class="font-bold text-lg mb-2">Deskripsi Produk</h3>
                <p class="text-gray-600 leading-relaxed text-justify">
                  <?= nl2br($data['deskripsi']) ?>
                </p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>