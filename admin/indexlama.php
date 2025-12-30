<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header("Location: ../login.php");
  exit;
}

include '../koneksi.php';
?>

<!DOCTYPE html>
<html>

<head>
  <title>Dashboard Admin</title>

  <!-- boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../assets/css/output.css">

</head>

<body>

  <h2>Dashboard Admin</h2>

  <p>
    Selamat datang, <b><?= $_SESSION['user']['nama']; ?></b>
    | <a href="../logout.php">Logout</a>
  </p>

  <hr>

  <a href="tambah.php">+ Tambah Produk</a>

  <br><br>

  <table border="1" cellpadding="8">
    <tr>
      <th>No</th>
      <th>Nama Produk</th>
      <th>Harga</th>
      <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $ambil = $conn->query("SELECT * FROM products");

    while ($data = $ambil->fetch_assoc()) {
    ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $data['product_name']; ?></td>
        <td><?= $data['price']; ?></td>
        <td>
          <a href="edit.php?id=<?= $data['id_product']; ?>">Edit</a> |
          <a href="hapus.php?id=<?= $data['id_product']; ?>" onclick="return confirm('Yakin hapus data?')"> Hapus</a>
        </td>
      </tr>
    <?php } ?>

  </table>



  <div class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-white shadow-xl z-50 hidden md:flex flex-col h-full transition-all duration-300">
      <div class="p-6 flex items-center gap-3 mb-2">
        <!-- <div class="bg-blue-main text-white p-2 rounded-lg">
          <i class="fas fa-mobile-alt text-xl"></i>
        </div>
        <h2 class="text-blue-dark font-bold text-xl tracking-tight">Only Phones</h2> -->
        <img src="../assets/images/Only Phones.png" alt="">
      </div>

      <nav class="flex-1 px-4 space-y-3">
        <a href="dashboard.html" class="flex items-center gap-3 px-4 py-3 bg-blue-soft text-blue-main rounded-xl font-semibold transition-colors">
          <i class="fas fa-th-large w-5"></i>
          Dashboard
        </a>

        <a href="kelola-produk.html" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-blue-soft hover:text-blue-main rounded-xl font-semibold transition-colors">
          <i class="fas fa-box-open w-5"></i>
          Kelola Produk
        </a>

        <a href="kelola-user.html" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-blue-soft hover:text-blue-main rounded-xl font-semibold transition-colors">
          <i class="fas fa-users w-5"></i>
          Kelola User
        </a>
      </nav>

      <div class="p-4 mt-auto border-t border-gray-50">
        <a href="../logout.php" class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-semibold transition-colors">
          <i class="fas fa-sign-out-alt w-5"></i>
          Logout
        </a>
      </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">

      <header class="px-8 py-8 flex items-center justify-between sticky top-0 z-40 bg-[bg-main]">
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
            <p class="text-xs text-gray-500">Super Mimin</p>
          </div>
          <div class="w-10 h-10 bg-white border border-gray-200 shadow-sm rounded-full flex items-center justify-center text-gray-500 cursor-pointer hover:bg-gray-50 transition">
            <i class='bx  bxs-user-circle text-5xl'></i>
          </div>
        </div>
      </header>

      <div class="px-8 pb-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

          <div class="bg-white p-8 rounded-[24px] shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition-all group">
            <div>
              <p class="text-gray-500 font-medium mb-1">Total Transaksi</p>
              <h2 class="text-4xl font-bold text-blue-dark">120</h2>
              <p class="text-xs text-green-500 font-bold mt-2 bg-green-50 w-fit px-2 py-1 rounded">+12% Bulan ini</p>
            </div>
            <div class="w-16 h-16 bg-blue-soft rounded-2xl flex items-center justify-center text-blue-main group-hover:scale-110 transition-transform">
              <i class='bx  bxs-shopping-bag-alt text-4xl'></i>
            </div>
          </div>

          <div class="bg-gradient-to-r from-blue-main to-blue-dark text-white p-8 rounded-[24px] shadow-lg shadow-blue-200/50 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
            <div class="relative z-10">
              <p class="text-blue-100 font-medium mb-1">Total Pendapatan</p>
              <h2 class="text-4xl font-bold">Rp 75.000.000</h2>
              <p class="text-xs text-white/80 font-bold mt-2 bg-white/20 w-fit px-2 py-1 rounded">Target Tercapai</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm relative z-10">
              <i class='bx  bxs-wallet-alt text-4xl'></i>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-blue-dark">Riwayat Transaksi</h3>

            <div class="relative">
              <input type="text" placeholder="Cari ID/Nama..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-main/50">
              <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                  <th class="py-4 font-bold pl-2">ID Transaksi</th>
                  <th class="py-4 font-bold">Customer</th>
                  <th class="py-4 font-bold">Produk</th>
                  <th class="py-4 font-bold">Tanggal</th>
                  <th class="py-4 font-bold">Total</th>
                </tr>
              </thead>
              <tbody class="text-sm divide-y divide-gray-50">
                <tr class="hover:bg-gray-50 transition-colors group">
                  <td class="py-4 font-bold text-blue-main pl-2">#TRX-8821</td>
                  <td class="py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">AS</div>
                      <span class="font-semibold text-gray-700">Andi Saputra</span>
                    </div>
                  </td>
                  <td class="py-4 text-gray-500">iPhone 13 Pro</td>
                  <td class="py-4 text-gray-400">23 Des 2025</td>
                  <td class="py-4 font-bold text-gray-700">Rp 18.500.000</td>
                </tr>

                <tr class="hover:bg-gray-50 transition-colors group">
                  <td class="py-4 font-bold text-blue-main pl-2">#TRX-8822</td>
                  <td class="py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xs">SA</div>
                      <span class="font-semibold text-gray-700">Siti Aminah</span>
                    </div>
                  </td>
                  <td class="py-4 text-gray-500">Samsung S23 Ultra</td>
                  <td class="py-4 text-gray-400">23 Des 2025</td>
                  <td class="py-4 font-bold text-gray-700">Rp 19.200.000</td>
                </tr>

                <tr class="hover:bg-gray-50 transition-colors group">
                  <td class="py-4 font-bold text-blue-main pl-2">#TRX-8823</td>
                  <td class="py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs">BS</div>
                      <span class="font-semibold text-gray-700">Budi Santoso</span>
                    </div>
                  </td>
                  <td class="py-4 text-gray-500">Xiaomi 13T</td>
                  <td class="py-4 text-gray-400">22 Des 2025</td>
                  <td class="py-4 font-bold text-gray-700">Rp 6.499.000</td>
                </tr>

                <tr class="hover:bg-gray-50 transition-colors group">
                  <td class="py-4 font-bold text-blue-main pl-2">#TRX-8824</td>
                  <td class="py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs">RW</div>
                      <span class="font-semibold text-gray-700">Rina Wati</span>
                    </div>
                  </td>
                  <td class="py-4 text-gray-500">Oppo Reno 10</td>
                  <td class="py-4 text-gray-400">21 Des 2025</td>
                  <td class="py-4 font-bold text-gray-700">Rp 5.999.000</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- <div class="flex justify-end mt-6">
            <div class="flex gap-2">
              <button class="w-8 h-8 border rounded hover:bg-gray-50 flex items-center justify-center"><i class="fas fa-chevron-left text-xs"></i></button>
              <button class="w-8 h-8 bg-blue-main text-white rounded flex items-center justify-center font-bold text-sm">1</button>
              <button class="w-8 h-8 border rounded hover:bg-gray-50 flex items-center justify-center text-sm">2</button>
              <button class="w-8 h-8 border rounded hover:bg-gray-50 flex items-center justify-center"><i class="fas fa-chevron-right text-xs"></i></button>
            </div>
          </div> -->

        </div>

      </div>
    </main>
  </div>

</body>

</html>