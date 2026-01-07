<?php
// LOGIKA PHP: Hitung jumlah barang di keranjang (tanpa ganggu tampilan)
$total_barang_di_keranjang = 0;
if (isset($_SESSION['user'])) {
  $id_user_aktif = $_SESSION['user']['id_user'];
  // Hitung total jumlah barang
  $query_keranjang = $conn->query("SELECT SUM(jumlah) as total FROM keranjang WHERE id_user = '$id_user_aktif'");
  $data_keranjang = $query_keranjang->fetch_assoc();
  $total_barang_di_keranjang = $data_keranjang['total'] ? $data_keranjang['total'] : 0;
}
?>

<div class="navbar font-[Roboto] container mx-auto fixed top-0 left-0 right-0 z-50 px-0 py-4 flex justify-between items-center bg-[rgba(255,255,255,.6)] backdrop-blur-2xl">

  <a href="index.php">
    <img src="assets/images/logo.png" width="400px" class="">
  </a>

  <div class="flex items-center justify-between gap-4">
    <div class="nav-menu flex justify-between items-center gap-5">
      <a href="#" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">Home</a>
      <a href="index.php#shopping" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">Product</a>
      <a href="index.php#about" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">About</a>

      <?php if (isset($_SESSION['user'])) : ?>
        <a href="riwayat.php" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">Riwayat</a>
      <?php endif; ?>

      <a href="" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">Contact</a>
    </div>
  </div>

  <div class="flex justify-between items-center gap-5">

    <a href="keranjang.php" class="relative">
      <i class='bx bx-cart text-5xl text-blue-800'></i>

      <?php if ($total_barang_di_keranjang > 0): ?>
        <div class="absolute top-0 right-0 w-5 h-5 flex justify-center items-center text-white text-xs px-2 py-2 bg-red-500 rounded-full">
          <?= $total_barang_di_keranjang ?>
        </div>
      <?php endif; ?>
    </a>

    <div class="w-0.5 h-10 bg-blue-500"></div>

    <?php if (isset($_SESSION['user'])) : ?>
      <div class="relative flex justify-between items-center gap-3">
        <span class="font-bold text-xl">
          <?= $_SESSION['user']['nama'] ?>
        </span>

        <div id="profile-logo" class="flex justify-center items-center flex-col relative">
          <i class='bx bxs-user-circle text-5xl'></i>

          <a href="logout.php" onclick="return confirm('yakin ingin logout?')" class="logout absolute px-5 py-2.5 bg-blue-500 font-semibold text-white rounded-xl top-full whitespace-nowrap z-50">
            Logout
          </a>
        </div>
      </div>
    <?php else: ?>
      <div class="flex justify-between gap-4">
        <a href="login.php" class="block px-6 py-2 border border-blue-500 text-blue-500 font-medium rounded-xl">Masuk</a>
        <a href="register.php" class="block px-6 py-2 border border-blue-500 bg-blue-500 text-white font-medium rounded-xl">Daftar</a>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- NAVBAR -->
<!-- <div class="navbar font-[Roboto] container mx-auto fixed top-0 left-0 right-0 z-50 px-0 py-4 flex justify-between items-center bg-[rgba(255,255,255,.6)] backdrop-blur-2xl">

    <a href="index.php">
      <img src="assets/images/logo.png" width="400px" class="">
    </a>

    <div class="flex items-center justify-between gap-4">
      <div class="nav-menu flex justify-between items-center gap-5">
        <a href="#" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">Home</a>
        <a href="#shopping" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">Product</a>
        <a href="#about" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">About</a>
        <a href="" class="text-2xl font-semibold text-black hover:text-blue-500 transition-all">Contact</a>
      </div>
    </div>

    <div class="flex justify-between items-center gap-5">
      <a href="#" class="relative">
        <i class='bx  bx-cart text-5xl text-blue-800'></i>
        <div class="absolute top-0 right-0 w-5 h-5 flex justify-center items-center text-white px-2 py-2 bg-red-500 rounded-full">2</div>
      </a>

      <div class="w-0.5 h-10 bg-blue-500"></div>

      <?php if (isset($_SESSION['user'])) : ?>
        <div class="relative flex justify-between items-center gap-3">
          <span class="font-bold text-xl">
            <?= $_SESSION['user']['nama'] ?>
          </span>
          <div id="profile-logo" class="flex justify-center items-center flex-col">
            <i class='bx  bxs-user-circle text-5xl'></i>
            <a href="logout.php" onclick="return confirm('yakin ingin logout?')" class="logout absolute px-5 py-2.5 bg-blue-500 font-semibold text-white rounded-xl top-full">Logout</a>
          </div>
        </div>
      <?php else: ?>
        <div class="flex justify-between gap-4">
          <a href="login.php" class="block px-6 py-2 border border-blue-500 text-blue-500 font-medium rounded-xl">Masuk</a>
          <a href="register.php" class="block px-6 py-2 border border-blue-500 bg-blue-500 text-white font-medium rounded-xl">Daftar</a>
        </div>
      <?php endif; ?>
    </div>
  </div> -->