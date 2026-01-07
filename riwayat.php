<?php
session_start();
include 'koneksi.php';

// Kalau belum login tendang ke login
if (!isset($_SESSION['user'])) {
  echo "<script>alert('Silakan login dulu!'); location='login.php';</script>";
  exit();
}

$id_user = $_SESSION['user']['id_user'];

// Ambil semua transaksi user ini, urutkan dari yang terbaru
$riwayat = $conn->query("SELECT * FROM transactions WHERE id_user = '$id_user' ORDER BY tanggal_transaksi DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Belanja - Only Phones</title>

  <link rel="stylesheet" href="assets/css/output.css">

  <link rel="stylesheet" href="assets/css/custom.css">

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#f4f7ff] font-['Poppins'] text-slate-800">

  <?php include 'header.php'; ?>

  <div class="container mx-auto mt-28 px-4 mb-20 min-h-[calc(100vh-300px)]">

    <h1 class="text-3xl font-bold text-blue-900 mb-8">Riwayat Pesanan Saya</h1>

    <?php if ($riwayat->num_rows == 0): ?>

      <div class="bg-white rounded-[24px] p-12 text-center shadow-sm border border-slate-100 flex flex-col items-center justify-center">
        <div class="w-40 h-40 bg-gray-100 rounded-full flex items-center justify-center mb-6">
          <i class='bx bx-history text-6xl text-gray-400'></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-700 mb-2">Belum Ada Riwayat</h3>
        <p class="text-gray-400 mb-8">Kamu belum pernah melakukan transaksi apapun.</p>
        <a href="index.php" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
          Mulai Belanja
        </a>
      </div>

    <?php else: ?>

      <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead class="bg-blue-50 text-blue-900">
            <tr>
              <th class="p-6 font-bold">No. Pesanan</th>
              <th class="p-6 font-bold">Tanggal</th>
              <th class="p-6 font-bold">Total Bayar</th>
              <th class="p-6 font-bold">Status</th>
              <th class="p-6 font-bold text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php while ($pesanan = $riwayat->fetch_assoc()): ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="p-6 font-bold text-blue-600">
                  #TRX-<?= $pesanan['id_transaksi'] ?>
                </td>
                <td class="p-6 text-gray-600">
                  <?= date("d M Y H:i", strtotime($pesanan['tanggal_transaksi'])) ?>
                </td>
                <td class="p-6 font-bold text-slate-700">
                  Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?>
                </td>
                <td class="p-6">
                  <?php
                  $status = $pesanan['status'];
                  $warna = 'bg-gray-100 text-gray-600'; // Default

                  if ($status == 'pending') $warna = 'bg-orange-100 text-orange-600';
                  if ($status == 'menunggu_konfirmasi') $warna = 'bg-yellow-100 text-yellow-600';
                  if ($status == 'lunas') $warna = 'bg-green-100 text-green-600';
                  if ($status == 'batal') $warna = 'bg-red-100 text-red-600';

                  // Ubah _ jadi spasi (menunggu_konfirmasi -> Menunggu Konfirmasi)
                  $label = ucwords(str_replace('_', ' ', $status));
                  ?>
                  <span class="px-4 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide <?= $warna ?>">
                    <?= $label ?>
                  </span>
                </td>
                <td class="p-6 text-center">
                  <?php if ($status == 'pending'): ?>
                    <a href="kirim_bukti.php?id=<?= $pesanan['id_transaksi'] ?>" class="inline-block px-5 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-md shadow-blue-500/20 text-sm">
                      <i class='bx bx-upload mr-1'></i> Upload Bukti
                    </a>
                  <?php elseif ($status == 'lunas'): ?>
                    <span class="text-green-600 font-bold text-sm flex items-center justify-center gap-1">
                      <i class='bx bx-check-circle text-xl'></i> Selesai
                    </span>
                  <?php elseif ($status == 'batal'): ?>
                    <span class="text-red-400 font-bold text-sm">Dibatalkan</span>
                  <?php else: ?>
                    <span class="text-yellow-600 font-bold text-sm flex items-center justify-center gap-1">
                      <i class='bx bx-time'></i> Cek Admin
                    </span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    <?php endif; ?>
  </div>

</body>

</html>