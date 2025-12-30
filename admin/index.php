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

// 2. Hitung Total Transaksi
$resTrans = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions");
$rowTrans = mysqli_fetch_assoc($resTrans);

// 3. Hitung Total Pendapatan (PERBAIKAN DISINI)
$resIncome = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transactions");
$rowIncome = mysqli_fetch_assoc($resIncome);
// Jika null (belum ada transaksi), ubah jadi 0
$totalPendapatan = $rowIncome['total'] ?? 0;

// 4. Ambil Riwayat Transaksi Terakhir
$queryHistory = "SELECT t.id_transaksi, u.nama, t.tanggal_transaksi, t.total_harga,
                (SELECT p.nama_produk FROM transactions_details td 
                 JOIN products p ON td.id_produk = p.id_produk 
                 WHERE td.id_transaksi = t.id_transaksi LIMIT 1) as nama_produk
                 FROM transactions t
                 JOIN users u ON t.id_user = u.id_user
                 ORDER BY t.tanggal_transaksi DESC LIMIT 5";
$resHistory = mysqli_query($conn, $queryHistory);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Only Phones</title>

  <link rel="stylesheet" href="../assets/css/output.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body class="bg-bg-main font-[Poppins] antialiased text-slate-800">

  <div class="flex h-screen overflow-hidden">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">

      <header class="px-8 py-8 flex items-center justify-between sticky top-0 z-40 bg-bg-main">
        <h1 class="text-3xl font-bold text-blue-dark">Dashboard</h1>
        <div class="flex items-center gap-3">
          <div class="text-right hidden sm:block">
            <p class="text-sm font-bold text-blue-dark"><?php echo $_SESSION['nama'] ?? 'Admin'; ?></p>
            <p class="text-xs text-gray-500">Administrator</p>
          </div>
          <div class="w-10 h-10 bg-white border border-gray-200 shadow-sm rounded-full flex items-center justify-center text-gray-500">
            <i class="fas fa-user"></i>
          </div>
        </div>
      </header>

      <div class="px-8 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          <div class="bg-white p-8 rounded-[24px] shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition-all group">
            <div>
              <p class="text-gray-500 font-medium mb-1">Total Transaksi</p>
              <h2 class="text-4xl font-bold text-blue-dark"><?php echo number_format($rowTrans['total']); ?></h2>
              <p class="text-xs text-green-500 font-bold mt-2 bg-green-50 w-fit px-2 py-1 rounded">Data Realtime</p>
            </div>
            <div class="w-16 h-16 bg-blue-soft rounded-2xl flex items-center justify-center text-blue-main group-hover:scale-110 transition-transform">
              <i class="fas fa-shopping-bag text-3xl"></i>
            </div>
          </div>

          <div class="bg-gradient-to-r from-blue-main to-blue-dark text-white p-8 rounded-[24px] shadow-lg shadow-blue-200/50 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
            <div class="relative z-10">
              <p class="text-blue-100 font-medium mb-1">Total Pendapatan</p>
              <h2 class="text-4xl font-bold">Rp <?php echo number_format($totalPendapatan, 0, ',', '.'); ?></h2>
              <p class="text-xs text-white/80 font-bold mt-2 bg-white/20 w-fit px-2 py-1 rounded">Semua Lunas</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm relative z-10">
              <i class="fas fa-wallet text-3xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
          <h3 class="text-xl font-bold text-blue-dark mb-6">Riwayat Transaksi Terbaru</h3>
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                  <th class="py-4 font-bold pl-2">ID</th>
                  <th class="py-4 font-bold">Customer</th>
                  <th class="py-4 font-bold">Produk (Info)</th>
                  <th class="py-4 font-bold">Tanggal</th>
                  <th class="py-4 font-bold">Total</th>
                </tr>
              </thead>
              <tbody class="text-sm divide-y divide-gray-50">
                <?php if (mysqli_num_rows($resHistory) > 0): ?>
                  <?php while ($row = mysqli_fetch_assoc($resHistory)): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                      <td class="py-4 font-bold text-blue-main pl-2">#TRX-<?php echo $row['id_transaksi']; ?></td>
                      <td class="py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                            <?php echo substr($row['nama'], 0, 1); ?>
                          </div>
                          <span class="font-semibold text-gray-700"><?php echo $row['nama']; ?></span>
                        </div>
                      </td>
                      <td class="py-4 text-gray-500"><?php echo $row['nama_produk'] . " ..."; ?></td>
                      <td class="py-4 text-gray-400"><?php echo date('d M Y', strtotime($row['tanggal_transaksi'])); ?></td>
                      <td class="py-4 font-bold text-gray-700">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="py-6 text-center text-gray-400 italic">Belum ada transaksi</td>
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