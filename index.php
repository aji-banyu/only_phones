<?php
session_start();
include "koneksi.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Only Phones</title>
  <link rel="stylesheet" href="assets/css/output.css">
  <link rel="stylesheet" href="assets/css/custom.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <!-- boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <link rel="icon" href="assets/images/Only Phones.png">
</head>

<body class="font-['Roboto']">

  <div class="container mx-auto">

    <?php include "header.php" ?>

    <!-- HERO SECTION -->
    <div id="hero_section" class="hero mt-28 flex justify-between items-center min-h-[calc(100vh-300px)] bg-linear-to-b from-gray-300 to-white rounded-t-[60px] px-12 overflow-visible">
      <div class="flex justify-between items-start flex-col gap-6">
        <p class="font-bold text-4xl">YOUR GADGET SOLUTION</p>
        <h2 class="font-normal text-8xl text-blue-800">ONLY PHONES</h2>
        <P class="text-3xl font-light">- SALE UP TO 70% ALL PRODUCTS -</P>
        <a href="#shopping" class="px-6 py-3 mt-3 bg-gray-800 text-white font-semibold text-2xl shadow-2xl cursor-pointer hover:bg-gray-600 rounded-md transition-all">Shopping Now</a>
      </div>
      <div class="hero-img flex justify-center items-center">
        <img src="assets/images/hero3.png" width="550px" class="translate-y-46 drop-shadow-[-10px_20px_10px_rgba(0,0,0,0.5)]">
      </div>
    </div>

    <!-- carousel -->
    <div class="slide-container relative w-full h-87.5 border-t border-b border-gray-300 mt-10">

      <div class="slides w-full h-full relative overflow-hidden">
        <img src="assets/images/banners/4.png" class="active">
        <img src="assets/images/banners/2.png">
        <img src="assets/images/brands/samsung.png">
        <img src="assets/images/brands/apple.png">
        <img src="assets/images/brands/realme.png">
      </div>

      <div class="buttons">
        <span class="next absolute -right-18 top-1/2 -translate-y-3/6 p-3.5 font-bold text-2xl text-black transition-all rounded-3xl select-none z-10 cursor-pointer hover:bg-[rgba(0,0,0,0.5)]">&#10095;</span>
        <span class="prev absolute -left-18 top-1/2 -translate-y-3/6 p-3.5 font-bold text-2xl text-black transition-all rounded-3xl select-none z-10 cursor-pointer hover:bg-[rgba(0,0,0,0.5)]">&#10094;</span>
      </div>

      <div class="dotsContainer absolute top-full -translate-y-3/6 z-20 left-3/6 -translate-x-1/2 flex items-center px-8 py-2.5 bg-gray-50 rounded-4xl shadow-xl">
        <div class="dot active" data-id="0"></div>
        <div class="dot" data-id="1"></div>
        <div class="dot" data-id="2"></div>
        <div class="dot" data-id="3"></div>
        <div class="dot" data-id="4"></div>
      </div>

    </div>

    <!-- brands -->
    <div id="shopping" class="brands py-6 px-0 border-t border-b border-gray-300">

      <h2 class="font-medium text-4xl text-black">Berbagai Produk Kami</h2>

      <div class="mt-8 brands-list flex justify-center items-center gap-10">

        <?php
        $brand_list = [
          'Apple',
          'Huawei',
          'Infinix',
          'Oppo',
          'Realme',
          'Samsung',
          'Vivo',
          'Xiaomi'
        ]
        ?>
        <?php for ($i = 0; $i < count($brand_list); $i++) : ?>
          <div class="flex flex-col justify-between items-center gap-3.5">
            <a href="#<?= $brand_list[$i] ?>" class="img block w-32 h-w-32">
              <img src="assets/images/brand-list/<?= $brand_list[$i] ?>.png" class="w-full h-full object-contain">
            </a>
            <p class="font-medium text-2xl"><?= $brand_list[$i] ?></p>
          </div>
        <?php endfor ?>

      </div>

    </div>

    <!-- PRODUCTS -->
    <?php
    $list_brand = $conn->query("SELECT * FROM brands_category ORDER BY id_brand")
    ?>
    <?php while ($brand_category_row = mysqli_fetch_assoc($list_brand)) : ?>

      <div id="<?= $brand_category_row['nama_brand'] ?>" class=" border-t border-b border-gray-300 py-6">

        <h2 class="font-medium text-4xl text-black"><?= $brand_category_row['nama_brand'] ?></h2>

        <div class="brands-card mt-8 flex items-center flex-wrap gap-4">

          <?php
          $id_brand = $brand_category_row['id_brand'];
          $products = $conn->query("SELECT * FROM products WHERE id_brand = $id_brand");
          ?>

          <?php while ($p = mysqli_fetch_assoc($products)) : ?>
            <div class="card relative block w-68 h-112.5 px-4 pt-7 pb-12 shadow-xl border border-gray-100 bg-white rounded-xl overflow-hidden">
              <a href="detail_produk.php?id=<?= $p['id_produk'] ?>" class="card-img block w-full h-2/3">
                <img src="uploads/foto_produk/<?= $p['foto']; ?>" class="w-full h-full object-contain">
              </a>

              <h4 class="mt-6 font-semibold text-xl"><?= $p['nama_produk'] ?></h4>
              <span class="block mt-3 font-light text-xl">Mulai Rp.<?= number_format($p['harga']) ?></span>

              <a href="detail_produk.php?id=<?= $p['id_produk'] ?>" class="absolute left-5 bottom-5 underline text-xl font-semibold hover:text-blue-500 transition-all">Lihat</a>

              <a href="beli.php?id=<?= $p['id_produk'] ?>" class="absolute w-12 h-12 right-5 bottom-5 flex justify-center items-center text-white text-4xl p-0.5 bg-black rounded-full"><i class='bx  bx-cart'></i> </a>
            </div>
          <?php endwhile ?>

        </div>

      </div>

    <?php endwhile ?>

    <!-- ABOUT SECTION -->
    <div id="about" class="about-container px-28">

      <div class="flex w-full  my-8 rounded-md overflow-hidden">
        <div class="flex-1 h-96 bg-[#D8DAD7]"></div>
        <div class="flex-1 flex flex-col gap-3 justify-center items-center h-96 bg-[#F7F7F7]">
          <h3 class="font-bold text-3xl">Butuh Bantuan?</h3>
          <p class="font-light">Dapatkan bantuan yang kamu butuhkan.</p>
          <a href="" class="px-5 py-3 font-semibold text-xl text-blue-500 border border-blue-500 rounded-4xl">Hubungi Kami</a>
        </div>
      </div>

      <div class="flex flex-row-reverse w-full  my-8 rounded-md overflow-hidden">
        <div class="flex-1 h-96 bg-[#D8DAD7]"></div>
        <div class="flex-1 flex flex-col gap-3 justify-center items-center h-96 bg-[#F7F7F7]">
          <h3 class="font-bold text-3xl">Butuh Bantuan?</h3>
          <p class="font-light">Dapatkan bantuan yang kamu butuhkan.</p>
          <a href="" class="px-5 py-3 font-semibold text-xl text-blue-500 border border-blue-500 rounded-4xl">Hubungi Kami</a>
        </div>
      </div>

      <div class="flex w-full  my-8 rounded-md overflow-hidden">
        <div class="flex-1 h-96 bg-[#D8DAD7]"></div>
        <div class="flex-1 flex flex-col gap-3 justify-center items-center h-96 bg-[#F7F7F7]">
          <h3 class="font-bold text-3xl">Butuh Bantuan?</h3>
          <p class="font-light">Dapatkan bantuan yang kamu butuhkan.</p>
          <a href="" class="px-5 py-3 font-semibold text-xl text-blue-500 border border-blue-500 rounded-4xl">Hubungi Kami</a>
        </div>
      </div>

    </div>
  </div>



  <script src="assets/js/slides.js"></script>

</body>



</html>