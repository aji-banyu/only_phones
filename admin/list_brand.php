<?php
include "../koneksi.php";
$q = "SELECT * FROM brands_category ORDER BY id_brand";
$brands = $conn->query($q);

$brand_active = isset($_GET['brand']) ? $_GET['brand'] : '';
?>

<div class="mb-2 border-b border-gray-400 pb-2">
  <div class="flex gap-4 overflow-x-auto no-scrollbar" id="tabContainer">
    <a href="kelola_produk.php?" class="pb-3 px-2 text-xl font-semibold whitespace-nowrap transition-all relative border-b-2 <?= ($brand_active == '') ? 'text-blue-500 border-blue-500' : 'text-gray-400 border-transparent' ?> hover:text-gray-600 hover:border-gray-200 cursor-pointer">
      Semua Produk
    </a>
    <?php while ($row = mysqli_fetch_assoc($brands)) : ?>
      <a href="kelola_produk.php?brand=<?= $row['nama_brand'] ?>" class="pb-3 px-2 text-xl font-semibold whitespace-nowrap transition-all relative border-b-2 <?= ($brand_active == $row['nama_brand']) ? 'text-blue-500 border-blue-500' : 'text-gray-400  border-transparent' ?> hover:text-gray-600 hover:border-gray-200 cursor-pointer">
        <?= $row['nama_brand'] ?>
      </a>
    <?php endwhile ?>
  </div>
</div>