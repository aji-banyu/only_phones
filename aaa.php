<?php
include 'koneksi.php';

// 1. LOGIC PENCARIAN BRAND
$keyword = "";
$query_brand_sql = "SELECT * FROM brands_category";

if (isset($_GET['search']) && !empty($_GET['search'])) {
  $keyword = mysqli_real_escape_string($conn, $_GET['search']);
  $query_brand_sql .= " WHERE nama_brand LIKE '%$keyword%'";
}

$query_brand_sql .= " ORDER BY id_brand ASC";
$list_brand = $conn->query($query_brand_sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katalog Lengkap</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-gray-50 text-gray-800 font-sans pb-20">

  <!-- <?php include 'header.php' ?> -->

  <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center gap-4">
          <a href="index.php" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
            <i class='bx bx-arrow-back text-2xl'></i>
          </a>
          <h1 class="font-bold text-xl tracking-tight">Katalog Produk</h1>
        </div>
      </div>
    </div>
  </nav>

  <div class="bg-white border-b border-gray-200 pt-6 pb-8 px-4 sticky top-16 z-30 shadow-sm">
    <div class="max-w-3xl mx-auto">
      <form action="" method="GET" class="relative group">
        <input type="text" name="search" value="<?= htmlspecialchars($keyword) ?>"
          placeholder="Cari Brand (contoh: Nike)..."
          class="w-full pl-12 pr-4 py-3 bg-gray-100 border-transparent focus:bg-white focus:border-black focus:ring-1 focus:ring-black rounded-xl outline-none transition-all duration-300 shadow-inner group-hover:shadow-md">
        <i class='bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl'></i>

        <?php if ($keyword): ?>
          <a href="semua_brand.php" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500">
            <i class='bx bxs-x-circle text-xl'></i>
          </a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <?php if (mysqli_num_rows($list_brand) > 0) : ?>

      <?php while ($brand = mysqli_fetch_assoc($list_brand)) : ?>
        <?php
        $id_brand = $brand['id_brand'];

        // Hitung total produk dulu untuk logic tombol "Lihat Semua"
        $count_query = $conn->query("SELECT COUNT(*) as total FROM products WHERE id_brand = $id_brand");
        $total_produk = mysqli_fetch_assoc($count_query)['total'];
        ?>

        <?php if ($total_produk > 0): ?>

          <div class="mb-16 border-b border-gray-200 pb-12 last:border-0">

            <div class="flex justify-between items-end mb-6">
              <div>
                <h2 class="font-bold text-3xl text-black"><?= $brand['nama_brand'] ?></h2>
                <p class="text-sm text-gray-500 mt-1"><?= $total_produk ?> Produk Tersedia</p>
              </div>

              <a href="kategori_brand.php?id=<?= $id_brand ?>" class="hidden md:flex items-center gap-1 text-sm font-semibold text-gray-600 hover:text-black transition-colors">
                Lihat Semua <?= $brand['nama_brand'] ?> <i class='bx bx-right-arrow-alt'></i>
              </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">

              <?php
              $products = $conn->query("SELECT * FROM products WHERE id_brand = $id_brand LIMIT 8");
              ?>

              <?php while ($p = mysqli_fetch_assoc($products)) : ?>
                <div class="card group flex flex-col bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl hover:border-gray-300 transition-all duration-300">

                  <a href="detail_produk.php?id=<?= $p['id_produk'] ?>" class="block w-full h-48 md:h-56 bg-gray-50 p-4 relative">
                    <img src="uploads/foto_produk/<?= $p['foto']; ?>" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-300">
                  </a>

                  <div class="p-4 flex flex-col flex-grow">
                    <h4 class="font-medium text-gray-900 line-clamp-2 text-sm md:text-base mb-2 min-h-[2.5rem]">
                      <a href="detail_produk.php?id=<?= $p['id_produk'] ?>">
                        <?= $p['nama_produk'] ?>
                      </a>
                    </h4>

                    <div class="mt-auto pt-2 flex justify-between items-center border-t border-gray-50">
                      <span class="font-bold text-base md:text-lg text-black">
                        Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                      </span>

                      <a href="beli.php?id=<?= $p['id_produk'] ?>" class="w-8 h-8 flex items-center justify-center rounded-full bg-black text-white hover:bg-gray-800 transition-colors">
                        <i class='bx bx-plus'></i>
                      </a>
                    </div>
                  </div>
                </div>
              <?php endwhile ?>

            </div>

            <?php if ($total_produk > 8): ?>
              <div class="mt-8 text-center">
                <a href="kategori_brand.php?id=<?= $id_brand ?>" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-black transition-all">
                  Lihat <?= $total_produk - 8 ?> produk lainnya dari <?= $brand['nama_brand'] ?>
                </a>
              </div>
            <?php endif; ?>

          </div>

        <?php endif; // End If Total Produk > 0 
        ?>

      <?php endwhile ?>

    <?php else : ?>

      <div class="text-center py-20">
        <i class='bx bx-search text-5xl text-gray-300 mb-4'></i>
        <h3 class="text-xl font-bold text-gray-900">Brand tidak ditemukan</h3>
        <p class="text-gray-500">Coba kata kunci lain.</p>
        <a href="semua_brand.php" class="mt-4 inline-block text-blue-600 underline">Reset</a>
      </div>

    <?php endif; ?>

  </div>

</body>

</html>