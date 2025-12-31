<?php
session_start();
include '../koneksi.php';

$query = "SELECT 
            p.id_produk,
            p.nama_produk,
            b.nama_brand,  
            p.harga,
            p.stok,
            p.foto
          FROM 
            products p
          JOIN 
            brands_category b ON p.id_brand = b.id_brand";

$result = $conn->query($query)
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Produk - Only Phones</title>

  <link rel="stylesheet" href="../assets/css/output.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body class="bg-bg-main font-[Poppins] antialiased text-slate-800">
  <div class="flex h-screen overflow-hidden">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">
      <header class="px-8 py-8 bg-bg-main sticky top-0 z-40">
        <h1 class="text-3xl font-bold text-blue-dark">Kelola Produk</h1>
      </header>

      <div class="px-8 pb-8">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
          <div class="flex justify-between items-center mb-8">
            <h3 class="text-xl font-bold text-blue-dark">Daftar Produk</h3>
            <a href="tambah_produk.php" class="bg-blue-main hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-lg transition-all flex items-center gap-2">
              <i class="fas fa-plus"></i> Tambah Produk
            </a>
          </div>

          <?php include "list_produk.php" ?>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                  <th class="py-4 font-bold pl-2">Produk</th>
                  <th class="py-4 font-bold">Kategori</th>
                  <th class="py-4 font-bold">Harga</th>
                  <th class="py-4 font-bold">Stok</th>
                  <th class="py-4 font-bold text-right pr-2">Aksi</th>
                </tr>
              </thead>
              <tbody class="text-sm divide-y divide-gray-50">

                <?php if (!isset($_GET['brand_id'])) : ?>

                  <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                      <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4">
                          <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                              <?php if ($row['foto']): ?>
                                <img src="../uploads/foto_produk/<?= $row['foto']; ?>" class="w-full h-full object-cover">
                              <?php else: ?>
                                <i class="fas fa-image text-gray-400"></i>
                              <?php endif; ?>
                            </div>
                            <div>
                              <p class="font-bold text-gray-700"><?= $row['nama_produk']; ?></p>
                            </div>
                          </div>
                        </td>
                        <td class="py-4"><span class="bg-blue-50 text-blue-main px-3 py-1 rounded-full text-xs font-bold"><?= $row['nama_brand']; ?></span></td>
                        <td class="py-4 font-semibold text-gray-700">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td class="py-4">
                          <span class="<?= $row['stok'] > 0 ? 'text-green-600' : 'text-red-500'; ?> font-bold"><?= $row['stok']; ?></span> Unit
                        </td>
                        <td class="py-4 text-right flex justify-end pr-2">
                          <div class="flex justify-between items-center gap-2 w-max">
                            <a href="update_produk.php?id=<?= $row['id_produk'] ?>" class="w-8 h-8 rounded-lg text-green-400 hover:bg-green-100 inline-flex items-center justify-center transition-colors"><i class=" fa-solid fa-pen"></i></a>
                            <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>" onclick="return confirm('Yakin hapus?')" class="w-8 h-8 rounded-lg text-red-400 hover:bg-red-100 inline-flex items-center justify-center transition-colors"><i class="fas fa-trash"></i></a>
                          </div>
                        </td>
                      </tr>
                    <?php endwhile; ?>

                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="py-6 text-center text-gray-400 italic">Gudang Kosong</td>
                    </tr>
                  <?php endif ?>

                <?php else : ?>

                  <?php
                  $brand_id = $_GET['brand_id'];
                  $query_brand = "SELECT 
                                    p.*, 
                                    b.nama_brand  
                                  FROM products p 
                                  JOIN brands_category b ON p.id_brand = b.id_brand 
                                  WHERE p.id_brand = '$brand_id'";

                  $produk_per_brand = $conn->query($query_brand);
                  ?>

                  <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($produk_per_brand)): ?>
                      <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4">
                          <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                              <?php if ($row['foto']): ?>
                                <img src="../uploads/foto_produk/<?= $row['foto']; ?>" class="w-full h-full object-cover">
                              <?php else: ?>
                                <i class="fas fa-image text-gray-400"></i>
                              <?php endif; ?>
                            </div>
                            <div>
                              <p class="font-bold text-gray-700"><?= $row['nama_produk']; ?></p>
                            </div>
                          </div>
                        </td>
                        <td class="py-4"><span class="bg-blue-50 text-blue-main px-3 py-1 rounded-full text-xs font-bold"><?= $row['nama_brand']; ?></span></td>
                        <td class="py-4 font-semibold text-gray-700">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td class="py-4">
                          <span class="<?= $row['stok'] > 0 ? 'text-green-600' : 'text-red-500'; ?> font-bold"><?= $row['stok']; ?></span> Unit
                        </td>
                        <td class="py-4 text-right pr-2">
                          <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>" onclick="return confirm('Yakin hapus?')" class="w-8 h-8 rounded-lg text-red-400 hover:bg-red-50 inline-flex items-center justify-center transition-colors"><i class="fas fa-trash"></i></a>
                        </td>
                      </tr>
                    <?php endwhile; ?>

                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="py-6 text-center text-gray-400 italic">Gudang Kosong</td>
                    </tr>
                  <?php endif ?>

                <?php endif ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>