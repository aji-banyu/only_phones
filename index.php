<?php
session_start();
include "koneksi.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OnlyPhones</title>
  <link rel="stylesheet" href="assets/css/output.css">
  <link rel="stylesheet" href="assets/css/custom.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <!-- boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- animate css -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- aos js -->
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

  <link rel="icon" type="image/png" href="assets/images/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg" />
  <link rel="shortcut icon" href="assets/images/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png" />
  <link rel="manifest" href="assets/images/site.webmanifest" />
</head>

<style>
  .hide-scroll::-webkit-scrollbar {
    display: none;
  }
</style>

<body class="font-['Roboto']">

  <div class="container mx-auto">

    <?php include "header.php" ?>

    <!-- HERO SECTION -->
    <div id="hero_section" class="hero mt-28 flex justify-between items-center min-h-[calc(100vh-300px)] bg-linear-to-b from-gray-300 to-white rounded-t-[60px] px-12 overflow-hidden">
      <div class="flex justify-between items-start flex-col gap-6">
        <p class="animate__animated animate__fadeInLeft animate__delay-1s font-bold text-4xl">YOUR GADGET SOLUTION</p>
        <h2 class="animate__animated animate__fadeInLeft animate__slow font-normal text-8xl text-blue-800">ONLY PHONES</h2>
        <P class="animate__animated animate__fadeInLeft animate__delay-1s text-3xl font-light">- SALE UP TO 70% ALL PRODUCTS -</P>
        <a href="#shopping" class="px-6 py-3 mt-3 bg-gray-800 text-white font-semibold text-2xl shadow-2xl cursor-pointer hover:bg-gray-600 rounded-md transition-all">Shopping Now</a>
      </div>
      <div class="animate__animated animate__fadeInRight animate__slower hero-img flex justify-center items-center">
        <img src="assets/images/hero3.png" width="550px" class="translate-y-46 drop-shadow-[-10px_20px_10px_rgba(0,0,0,0.5)]">
      </div>
    </div>

    <!-- carousel -->
    <div class="slide-container relative w-full h-87.5 mt-10">

      <div class="slides w-full h-full relative overflow-hidden">
        <img src="assets/images/banners/4.png" class="active">
        <img src="assets/images/brands/apple.png">
        <img src="assets/images/banners/banner ip 17 pro.png">
        <img src="assets/images/brands/samsung.png">
        <img src="assets/images/banners/banner realme.png">
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
    $list_brand = $conn->query("SELECT * FROM brands_category ORDER BY id_brand");
    $total_brand = $list_brand->num_rows;

    $counter = 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 3;
    $last_brand_id = null;

    if (isset($_GET['limit'])) {
      $limit = $_GET['limit'];
    }
    ?>
    <?php while ($brand_category_row = mysqli_fetch_assoc($list_brand)) : ?>

      <?php
      // Jika penghitung sudah sama dengan limit, hentikan loop
      if ($counter >= $limit) {
        break;
      }
      ?>

      <div id="<?= $brand_category_row['id_brand'] ?>" class="border-t border-b border-gray-300 py-10">

        <h2 class="font-medium text-4xl text-black mb-6 px-4"><?= $brand_category_row['nama_brand'] ?></h2>

        <div class="brands-card flex overflow-x-auto gap-5 pb-8 px-10 snap-x hide-scroll">

          <?php
          $id_brand = $brand_category_row['id_brand'];
          $products = $conn->query("SELECT * FROM products WHERE id_brand = $id_brand");
          ?>

          <?php while ($p = mysqli_fetch_assoc($products)) : ?>

            <div class="card flex-none w-64 md:w-72 lg:w-92 snap-center flex flex-col bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300">

              <a href="detail_produk.php?id=<?= $p['id_produk'] ?>" class="block w-full h-64 bg-gray-50 p-4 relative group">
                <img src="uploads/foto_produk/<?= $p['foto']; ?>" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-300 group-hover:scale-110">
              </a>

              <div class="p-5 flex flex-col grow">
                <h4 class="font-semibold text-lg text-gray-800 line-clamp-2 leading-tight mb-2 min-h-12">
                  <?= $p['nama_produk'] ?>
                </h4>

                <span class="block font-medium text-xl text-black">
                  Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                </span>
              </div>

              <div class="p-5 pt-0 mt-auto flex items-center justify-between">
                <a href="detail_produk.php?id=<?= $p['id_produk'] ?>" class="text-sm font-semibold underline hover:text-blue-600 transition-colors">
                  Lihat Detail
                </a>

                <a href="beli.php?id=<?= $p['id_produk'] ?>" class="flex justify-center items-center w-10 h-10 text-white bg-black rounded-full hover:bg-gray-800 transition-colors shadow-md active:scale-90">
                  <i class='bx bx-cart text-xl'></i>
                </a>
              </div>

            </div>
          <?php endwhile ?>

        </div>

      </div>

      <?php
      $last_brand_id = $brand_category_row['id_brand'];
      $counter++ ?>
    <?php endwhile ?>

    <div class="w-full flex justify-center py-8">
      <?php $newLimit = $limit + 3; ?>

      <?php if ($limit < $total_brand) : ?>
        <a href="index.php?limit=<?= $newLimit ?>#<?= $last_brand_id ?>"
          class="px-8 py-3 bg-white border border-black text-black font-semibold rounded-full hover:bg-black hover:text-white transition-all shadow-lg flex items-center gap-2 cursor-pointer">
          <span>Lihat Brand Lainnya</span>
          <i class='bx bx-chevron-down text-xl'></i>
        </a>
      <?php else : ?>
        <span>Semua Produk Sudah Ditampilkan</span>
      <?php endif ?>

    </div>

    <!-- ABOUT SECTION -->
    <div id="about" class="about-container px-28 pt-24">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-blue-900 mb-4">Tentang Kami</h2>
      </div>

      <div class="flex w-full  my-8 rounded-md overflow-hidden">
        <div
          data-aos="fade-up"
          data-aos-duration="3000"
          class="flex-1 flex h-96 bg-[#D8DAD7]">
          <img src="assets/images/about/1.jpeg" class="w-1/2 h-full object-cover">
          <img src="assets/images/about/8.jpeg" class="w-1/2 h-full object-cover">
        </div>
        <div class="flex-1 flex flex-col gap-3 justify-center items-center h-96 bg-[#F7F7F7]">
          <h3 class="font-bold text-3xl">Only Phones</h3>
        </div>
      </div>

      <div class="flex flex-row-reverse w-full  my-8 rounded-md overflow-hidden">
        <div
          data-aos="fade-up"
          data-aos-duration="3000"
          class="flex-1 h-96 bg-[#D8DAD7]">
          <img src="assets/images/about/2.jpeg" class="w-full h-full object-cover">
        </div>
        <div class="flex-1 flex flex-col gap-3 justify-center items-center h-96 bg-[#F7F7F7]">
          <p class="font-light px-40 text-center">Dokumentasi ini menunjukkan pengerjaan proyek UAS Pemrograman Web Lanjut secara kolaboratif dengan laptop dan monitor eksternal dalam pengembangan website e-commerce “Only Phones”. </p>
        </div>
      </div>

      <div class="flex w-full  my-8 rounded-md overflow-hidden">
        <div
          data-aos="fade-up"
          data-aos-duration="3000"
          class="flex-1 h-96 bg-[#D8DAD7]">
          <img src="assets/images/about/10.jpeg" class="w-full h-full object-cover">
        </div>
        <div class="flex-1 flex flex-col gap-3 justify-center items-center h-96 bg-[#F7F7F7]">
          <p class="font-light px-40 text-center">Dokumentasi ini menampilkan pengerjaan proyek UAS Pemrograman Web Lanjut secara kolaboratif menggunakan dua laptop untuk pengembangan dan pengujian website e-commerce “Only Phones”.</p>
        </div>
      </div>

    </div>
  </div>

  <!-- Contact -->

  <section id="contact" class="py-20 bg-white">
    <div class="container mx-auto px-4">

      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-blue-900 mb-4">Hubungi Kami</h2>
        <!-- <p class="text-gray-500 max-w-2xl mx-auto">Punya pertanyaan seputar gadget atau pesananmu? Tim kami siap membantu 24/7.</p> -->
      </div>

      <div class="flex flex-col lg:flex-row gap-12 items-start px-28 max-w- mx-auto">

        <div class="flex-1 w-full">
          <div class="bg-blue-50 rounded-[32px] p-10">
            <h3 class="text-2xl font-bold text-blue-900 mb-6">Informasi Kontak</h3>

            <div class="space-y-6">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                  <i class='bx bxs-map text-2xl'></i>
                </div>
                <div>
                  <h4 class="font-bold text-lg text-slate-800">Lokasi Toko</h4>
                  <p class="text-gray-600">Jl. Raden Saleh No.7, Potrobangsan, Kec. Magelang Utara, Kota Magelang, Jawa Tengah 56116</p>
                </div>
              </div>

              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                  <i class='bx bxs-phone text-2xl'></i>
                </div>
                <div>
                  <h4 class="font-bold text-lg text-slate-800">Telepon / WhatsApp</h4>
                  <p class="text-gray-600">+62 812-3456-7890</p>
                </div>
              </div>

              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                  <i class='bx bxs-envelope text-2xl'></i>
                </div>
                <div>
                  <h4 class="font-bold text-lg text-slate-800">Email Support</h4>
                  <p class="text-gray-600">onlyphones@gmail.com</p>
                </div>
              </div>
            </div>

            <div class="mt-10">
              <h4 class="font-bold text-slate-800 mb-4">Ikuti Kami</h4>
              <div class="flex gap-4">
                <a href="https://www.instagram.com/404team_a/" target="_blank" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition"><i class='bx bxl-instagram text-xl'></i></a>
                <a href="#" target="_blank" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition"><i class='bx bxl-facebook text-xl'></i></a>
                <a href="#" target="_blank" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition"><i class='bx bxl-twitter text-xl'></i></a>
              </div>
            </div>

          </div>
        </div>

        <div class="flex-1 w-full bg-white border border-gray-100 p-8 rounded-[32px] shadow-lg shadow-blue-100">
          <h3 class="text-2xl font-bold text-slate-800 mb-6">Kirim Pesan</h3>
          <form id="formPesan" action="" onsubmit="submitForm(event)">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kamu</label>
                <input type="text" id="nama" placeholder="John Doe" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-50">
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                <input type="email" id="email" placeholder="email@kamu.com" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-50">
              </div>
            </div>
            <div class="mb-6">
              <label class="block text-sm font-bold text-gray-700 mb-2">Pesan</label>
              <textarea rows="4" id="pesanForm" placeholder="Tulis pesanmu disini..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-50"></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
              Kirim Sekarang
            </button>
          </form>
        </div>

      </div>
    </div>
  </section>


  <footer class="relative bg-blue-dark text-white pt-20 pb-10">
    <div class="container mx-auto px-4">

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

        <div>
          <h2 class="text-2xl font-bold mb-6 text-blue-400">ONLY PHONES.</h2>
          <p class="text-blue-100 leading-relaxed mb-6">
            Destinasi terbaik untuk menemukan smartphone impianmu dengan harga jujur dan garansi resmi terpercaya.
          </p>
        </div>

        <div>
          <h3 class="text-lg font-bold mb-6">Menu Cepat</h3>
          <ul class="space-y-4 text-blue-100">
            <li><a href="index.php" class="hover:text-blue-400 transition">Home</a></li>
            <li><a href="#shopping" class="hover:text-blue-400 transition">Produk Terbaru</a></li>
            <li><a href="#contact" class="hover:text-blue-400 transition">Hubungi Kami</a></li>
            <li><a href="riwayat.php" class="hover:text-blue-400 transition">Cek Pesanan</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-lg font-bold mb-6">Tetap Terhubung</h3>
          <p class="text-blue-100 mb-4">Dapatkan info promo terbaru langsung ke whatsapp.</p>
          <div class="flex items-center">
            <div class="flex items-center bg-blue-900/50 p-2 rounded-xl border border-blue-800">
              <i class="fa-brands fa-whatsapp text-3xl"></i>
              <input id="pesan" type="text" placeholder="Pesan kamu..." class="bg-transparent w-full px-3 text-white outline-none placeholder-blue-300">
              <button id="kirimPesan" class="bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-400 transition">
                <i class='bx bx-send'></i>
              </button>
            </div>
          </div>
        </div>

      </div>

      <div class="border-t border-blue-800 pt-8 text-center text-blue-300 text-sm">
        <p>&copy; 2024 Only Phones. All rights reserved.</p>
      </div>

    </div>
    <a href="#" class="absolute right-6 bottom-6 flex justify-center items-center w-12 h-12 z-50 bg-blue-400 rounded-full shadow-lg hover:bg-blue-500 hover:-translate-y-1 transition-all">
      <i class="fa-solid fa-arrow-up text-xl text-white"></i>
    </a>
  </footer>

  <script src="assets/js/slides.js"></script>

  <!-- aos js -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();


    function submitForm(event) {
      event.preventDefault()

      const form = document.querySelector('#formPesan')
      const nama = form.querySelector('#nama').value
      const email = form.querySelector('#email').value
      const pesan = form.querySelector('#pesanForm').value

      const text = encodeURIComponent(
        `Nama: ${nama}\nEmail: ${email}\nPesan: ${pesan}`
      )

      window.location.href = `https://wa.me/6289669682132?text=${text}`
    }

    const btnkirimPesan = document.querySelector('#kirimPesan')
    btnkirimPesan.addEventListener('click', function() {
      const pesan = document.querySelector('#pesan')
      const isiPesan = encodeURIComponent(pesan.value)
      window.location.href = `https://wa.me/6289669682132?text=${isiPesan}`
    })
  </script>

</body>



</html>