<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

// Ambil data user
$query_user = "SELECT * FROM users WHERE id_user = '$id'";
$result_user = $conn->query($query_user);
$user = $result_user->fetch_assoc();

// Ambil riwayat transaksi user
$query_trx = "SELECT * FROM transactions WHERE id_user = '$id' ORDER BY tanggal_transaksi DESC";
$history = $conn->query($query_trx);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Detail User - <?= $user['nama'] ?></title>
  <link rel="stylesheet" href="../assets/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-bg-main font-[Poppins] antialiased text-slate-800">
  <div class="flex h-screen overflow-hidden">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">
      <header class="px-8 py-6 bg-white border-b border-gray-100 flex justify-between items-center sticky top-0 z-40">
        <h1 class="text-2xl font-bold text-blue-dark">Detail User</h1>
        <a href="kelola_user.php?role=<?= $user['role'] ?>" class="text-gray-500 hover:text-blue-main flex items-center gap-2 font-medium">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </header>

      <div class="p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

          <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 text-center">
              <div class="w-32 h-32 bg-blue-50 rounded-full mx-auto flex items-center justify-center text-blue-main text-5xl mb-4">
                <i class="fas fa-user-circle"></i>
              </div>
              <h2 class="text-2xl font-bold text-gray-800"><?= $user['nama'] ?></h2>
              <p class="text-gray-500 font-medium mb-4"><?= $user['email'] ?></p>

              <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold <?= $user['role'] == 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' ?>">
                <?= ucfirst($user['role']) ?>
              </span>

              <div class="mt-8 border-t border-gray-100 pt-6 text-left">
                <p class="text-sm text-gray-400 mb-1">User ID</p>
                <p class="font-semibold text-gray-700">#<?= $user['id_user'] ?></p>
              </div>
            </div>
          </div>

          <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 h-full">
              <h3 class="text-xl font-bold text-blue-dark mb-6 flex items-center gap-2">
                <i class="fas fa-shopping-bag text-blue-main"></i> Riwayat Transaksi
              </h3>

              <div class="overflow-x-auto">
                <table class="w-full text-left">
                  <thead>
                    <tr class="text-sm text-gray-400 border-b border-gray-100">
                      <th class="pb-3 font-semibold">ID Transaksi</th>
                      <th class="pb-3 font-semibold">Tanggal</th>
                      <th class="pb-3 font-semibold">Total Belanja</th>
                      <th class="pb-3 font-semibold">Status</th>
                    </tr>
                  </thead>
                  <tbody class="text-sm">
                    <?php if ($history->num_rows > 0): ?>
                      <?php while ($trx = $history->fetch_assoc()): ?>
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                          <td class="py-4 font-bold text-blue-main">#TRX-<?= $trx['id_transaksi'] ?></td>
                          <td class="py-4 text-gray-600"><?= date('d M Y', strtotime($trx['tanggal_transaksi'])) ?></td>
                          <td class="py-4 font-bold text-gray-800">Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?></td>
                          <td class="py-4">
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs font-bold">Selesai</span>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="4" class="py-8 text-center text-gray-400 italic">Belum ada riwayat transaksi.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>
</body>

</html>