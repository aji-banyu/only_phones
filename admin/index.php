<?php
session_start();
include '../koneksi.php';

// Cek Login Admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header("Location: ../login.php");
  exit;
}

// 1. Hitung Total Produk
$resProduk = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$rowProduk = mysqli_fetch_assoc($resProduk);

// 2. Hitung Total Transaksi (TETAP BERSIH)
// Kita pakai WHERE status != 'batal' agar angka di kartu statistik tidak menghitung yang gagal.
$resTrans = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions WHERE status != 'batal'");
$rowTrans = mysqli_fetch_assoc($resTrans);

// 3. Hitung Total Pendapatan (HANYA YANG LUNAS)
$resIncome = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transactions WHERE status = 'lunas'");
$rowIncome = mysqli_fetch_assoc($resIncome);
$totalPendapatan = $rowIncome['total'] ?? 0;

// 4. Ambil Riwayat Transaksi Terakhir (SEMUA MUNCUL)
// SAYA MENGHAPUS "WHERE status != 'batal'" DISINI.
// Jadi, transaksi 'batal' akan TETAP MUNCUL di tabel untuk arsip admin.
$queryHistory = "SELECT t.id_transaksi, u.nama, t.tanggal_transaksi, t.total_harga, t.status,
                (SELECT p.nama_produk FROM transactions_details td 
                 JOIN products p ON td.id_produk = p.id_produk 
                 WHERE td.id_transaksi = t.id_transaksi LIMIT 1) as nama_produk
                 FROM transactions t
                 JOIN users u ON t.id_user = u.id_user
                 ORDER BY t.tanggal_transaksi DESC LIMIT 5";

$resHistory = mysqli_query($conn, $queryHistory);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Dashboard Admin</title>

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../assets/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-bg-main font-[Poppins] antialiased text-slate-800">

  <div class="flex h-screen overflow-hidden">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">

      <header class="px-8 py-8 flex items-center justify-between sticky top-0 z-40 bg-bg-main">
        <div class="flex items-center gap-4">
          <button class="md:hidden text-blue-dark text-xl">
            <i class="fas fa-bars"></i>
          </button>
          <div>
            <h1 class="text-3xl font-bold text-blue-dark">Dashboard</h1>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="text-right hidden sm:block">
            <p class="text-sm font-bold text-blue-dark"><?= $_SESSION['user']['nama']; ?></p>
            <p class="text-xs text-gray-500">Administrator</p>
          </div>
          <div class="w-10 h-10 bg-white border border-gray-200 shadow-sm rounded-full flex items-center justify-center text-gray-500 cursor-pointer hover:bg-gray-50 transition">
            <i class='bx bxs-user-circle text-5xl'></i>
          </div>
        </div>
      </header>

      <div class="px-8 pb-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

          <div class="bg-white p-8 rounded-[24px] shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition-all group">
            <div>
              <p class="text-gray-500 font-medium mb-1">Total Transaksi (Sukses/Proses)</p>
              <h2 class="text-4xl font-bold text-blue-dark"><?= $rowTrans['total']; ?></h2>
              <p class="text-xs text-green-500 font-bold mt-2 bg-green-50 w-fit px-2 py-1 rounded">Pesanan Valid</p>
            </div>
            <div class="w-16 h-16 bg-blue-soft rounded-2xl flex items-center justify-center text-blue-main group-hover:scale-110 transition-transform">
              <i class='bx bxs-shopping-bag-alt text-4xl'></i>
            </div>
          </div>

          <div class="bg-gradient-to-r from-blue-main to-blue-dark text-white p-8 rounded-[24px] shadow-lg shadow-blue-200/50 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
            <div class="relative z-10">
              <p class="text-blue-100 font-medium mb-1">Total Pendapatan (Real)</p>
              <h2 class="text-4xl font-bold">Rp <?= number_format($totalPendapatan, 0, ',', '.'); ?></h2>
              <p class="text-xs text-white/80 font-bold mt-2 bg-white/20 w-fit px-2 py-1 rounded">Uang Masuk</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm relative z-10">
              <i class='bx bxs-wallet-alt text-4xl'></i>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-blue-dark">Riwayat Transaksi Terbaru</h3>
            <a href="pesanan_masuk.php" class="text-sm text-blue-500 font-bold hover:underline">Lihat Semua</a>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                  <th class="py-4 font-bold pl-2">ID Transaksi</th>
                  <th class="py-4 font-bold">Customer</th>
                  <th class="py-4 font-bold">Produk (Contoh)</th>
                  <th class="py-4 font-bold">Tanggal</th>
                  <th class="py-4 font-bold">Total</th>
                  <th class="py-4 font-bold">Status</th>
                </tr>
              </thead>
              <tbody class="text-sm divide-y divide-gray-50">

                <?php if (mysqli_num_rows($resHistory) > 0): ?>
                  <?php while ($row = mysqli_fetch_assoc($resHistory)): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                      <td class="py-4 font-bold pl-2 <?= $row['status'] == 'batal' ? 'text-red-300 line-through' : 'text-blue-main' ?>">
                        #TRX-<?= $row['id_transaksi']; ?>
                      </td>
                      <td class="py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs uppercase">
                            <?= substr($row['nama'], 0, 1); ?>
                          </div>
                          <span class="font-semibold <?= $row['status'] == 'batal' ? 'text-gray-400' : 'text-gray-700' ?>"><?= $row['nama']; ?></span>
                        </div>
                      </td>
                      <td class="py-4 text-gray-500"><?= $row['nama_produk']; ?>...</td>
                      <td class="py-4 text-gray-400"><?= date('d M Y', strtotime($row['tanggal_transaksi'])); ?></td>
                      <td class="py-4 font-bold text-gray-700">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                      <td class="py-4">
                        <?php
                        $st = $row['status'];
                        $cls = 'bg-gray-100 text-gray-500'; // Default (Pending)
                        if ($st == 'lunas') $cls = 'bg-green-100 text-green-600';
                        if ($st == 'menunggu_konfirmasi') $cls = 'bg-yellow-100 text-yellow-600';
                        if ($st == 'batal') $cls = 'bg-red-100 text-red-500'; // Merah untuk batal
                        ?>
                        <span class="px-2 py-1 rounded text-xs font-bold <?= $cls ?>">
                          <?= ucfirst($st) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="py-6 text-center text-gray-400 italic">Belum ada riwayat transaksi</td>
                  </tr>
                <?php endif; ?>

              </tbody>
            </table>
          </div>

        </div>

      </div>
    </main>
  </div>

</body>

</html>