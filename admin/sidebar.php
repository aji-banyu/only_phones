<aside class="w-72 bg-white shadow-xl z-50 hidden md:flex flex-col h-full transition-all duration-300">
  <div class="p-6 flex items-center gap-3 mb-2">
    <img src="../assets/images/Only Phones.png" alt="">
  </div>

  <nav class="flex-1 px-4 space-y-3">
    <a href="index.php" class="flex items-center gap-3 px-4 py-3 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-blue-soft text-blue-main' : 'text-gray-600 hover:bg-blue-soft hover:text-blue-main'; ?> rounded-xl text-xl font-semibold transition-colors">
      <i class="fas fa-th-large w-5"></i>
      Dashboard
    </a>

    <a href="kelola_produk.php" class="flex items-center gap-3 px-4 py-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'kelola_produk.php' || basename($_SERVER['PHP_SELF']) == 'tambah_produk.php') ? 'bg-blue-soft text-blue-main' : 'text-gray-600 hover:bg-blue-soft hover:text-blue-main'; ?> rounded-xl text-xl font-semibold transition-colors">
      <i class="fas fa-box-open w-5"></i>
      Kelola Produk
    </a>

    <a href="kelola_user.php?role=admin" class="flex items-center gap-3 px-4 py-3 <?php echo basename($_SERVER['PHP_SELF']) == 'kelola_user.php' ? 'bg-blue-soft text-blue-main' : 'text-gray-600 hover:bg-blue-soft hover:text-blue-main'; ?> rounded-xl text-xl font-semibold transition-colors">
      <i class="fas fa-users w-5"></i>
      Kelola User
    </a>

    <div class="mt-auto border-t border-gray-50">
      <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')" class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl text-xl font-semibold transition-colors">
        <i class="fas fa-sign-out-alt w-5"></i>
        Logout
      </a>
    </div>
  </nav>
</aside>