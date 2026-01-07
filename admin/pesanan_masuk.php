<?php
session_start();
include '../koneksi.php';

// Ambil data transaksi gabung sama nama user biar tau siapa yang beli
// Urutkan dari yang paling baru
$data_pesanan = $conn->query("SELECT t.*, u.nama FROM transactions t JOIN users u ON t.id_user = u.id_user ORDER BY t.tanggal_transaksi DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Pesanan Masuk</title>
  <link rel="stylesheet" href="../assets/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-bg-main font-[Poppins]">
  <div class="flex h-screen overflow-hidden">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-8 overflow-y-auto">
      <h2 class="text-3xl font-bold text-blue-dark mb-6">Daftar Pesanan Masuk</h2>

      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
          <thead class="bg-blue-main text-white">
            <tr>
              <th class="p-4">ID TRX</th>
              <th>Nama Pembeli</th>
              <th>Total Uang</th>
              <th>Bukti Transfer</th>
              <th>Status</th>
              <th>Aksi Admin</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php while ($pesanan = $data_pesanan->fetch_assoc()): ?>
              <tr class="hover:bg-gray-50">
                <td class="p-4 font-bold">#<?= $pesanan['id_transaksi'] ?></td>
                <td><?= $pesanan['nama'] ?></td>
                <td>Rp <?= number_format($pesanan['total_harga']) ?></td>
                <td>
                  <?php if ($pesanan['bukti_bayar']): ?>
                    <a href="../uploads/bukti_bayar/<?= $pesanan['bukti_bayar'] ?>" target="_blank" class="text-blue-600 underline font-bold">Lihat Foto</a>
                  <?php else: ?>
                    <span class="text-red-400 text-sm">Belum upload</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php
                  $warna = 'bg-gray-100 text-gray-500'; // Default
                  if ($pesanan['status'] == 'lunas') $warna = 'bg-green-100 text-green-600';
                  if ($pesanan['status'] == 'menunggu_konfirmasi') $warna = 'bg-yellow-100 text-yellow-600';
                  if ($pesanan['status'] == 'batal') $warna = 'bg-red-100 text-red-600';
                  ?>
                  <span class="px-3 py-1 rounded-full text-xs font-bold <?= $warna ?>">
                    <?= $pesanan['status'] ?>
                  </span>
                </td>
                <td class="p-4 flex gap-2">
                  <?php if ($pesanan['status'] == 'menunggu_konfirmasi'): ?>
                    <a href="proses_pesanan.php?id=<?= $pesanan['id_transaksi'] ?>&aksi=terima" class="bg-green-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-green-600 text-sm" onclick="return confirm('Yakin terima? Stok bakal berkurang lho!')">
                      Terima
                    </a>
                    <a href="proses_pesanan.php?id=<?= $pesanan['id_transaksi'] ?>&aksi=tolak" class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-600 text-sm" onclick="return confirm('Yakin tolak pesanan ini?')">
                      Tolak
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>

</html>