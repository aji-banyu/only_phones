<?php
session_start();
include "koneksi.php";

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id_produk = $id";

$result = $conn->query($query);
$produk = mysqli_fetch_assoc($result);

$id_brand = $produk['id_brand'];
$brand = mysqli_fetch_assoc($conn->query("SELECT * FROM brands_category WHERE id_brand = $id_brand"));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produk['nama_produk'] ?></title>

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

    </head>

<body class="bg-gray-50 font-[Poppins]">
    <?php include "header.php" ?>


    <main class="max-w-7xl mx-auto mt-28 px-4 sm:px-6 lg:px-8 py-6">

        <nav class="flex mb-6 text-sm text-gray-500">
            <ol class="flex items-center space-x-2">
                <li><a href="#" class="hover:text-primary">Home</a></li>
                <li><span class="text-gray-300">/</span></li>
                <li><a href="#" class="hover:text-primary"><?= $brand['nama_brand'] ?></a></li>
                <li><span class="text-gray-300">/</span></li>
                <li class="text-gray-900 font-medium"><?= $produk['nama_produk'] ?></li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">

            <div class="lg:col-span-7 flex flex-col items-center justify-center bg-gray-50 rounded-xl p-8 relative overflow-hidden group">
                <div class="absolute z-10 top-4 left-4 bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                    Stok Terbatas
                </div>

                <img src="./uploads/foto_produk/<?= $produk['foto'] ?>" alt="Samsung Galaxy Z Fold7" class="w-full h-auto max-w-md object-contain transform transition duration-500 group-hover:scale-105">

                <div class="absolute top-10 right-10 text-yellow-400 animate-pulse">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col">

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-2">
                    <?= $produk['nama_produk'] ?>
                </h1>

                <div class="flex items-center gap-2 mb-6">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Bebas Ongkir
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-main/10 text-primary">
                        Produk Resmi
                    </span>
                </div>

                <div class="mb-6">
                    <div class="flex items-end gap-3 mb-1">
                        <span class="text-3xl font-bold text-gray-900">Rp <?= number_format($produk['harga']) ?></span>
                    </div>
                    <p class="text-gray-600 text-sm"><?= $produk['deskripsi'] ?></p>
                </div>

                <div class="mb-8">
                    <p class="text-sm font-medium text-gray-900 mb-3">Pilih Warna</p>
                    <div class="flex gap-3">
                        <button class="w-10 h-10 rounded-full bg-blue-900 ring-2 ring-offset-2 ring-primary cursor-pointer focus:outline-none"></button>
                        <button class="w-10 h-10 rounded-full bg-gray-800 border border-gray-200 cursor-pointer hover:ring-2 hover:ring-offset-2 hover:ring-gray-300"></button>
                        <button class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200 cursor-pointer hover:ring-2 hover:ring-offset-2 hover:ring-gray-300"></button>
                    </div>
                </div>

                <div class="mt-auto border-t border-gray-100 pt-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="flex-1 bg-white border-2 border-primary text-primary font-bold py-3.5 px-6 rounded-xl hover:bg-blue-50 transition flex justify-center items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Keranjang
                        </button>
                        <button class="flex-1 bg-blue-main text-white font-bold py-3.5 px-6 rounded-xl hover:bg-blue-mainDark transition shadow-lg shadow-blue-200 flex justify-center items-center">
                            Beli Langsung
                        </button>
                    </div>
                </div>

                <div class="mt-6 bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-start gap-3">
                    <div class="bg-white p-2 rounded-full shadow-sm text-2xl">🎁</div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-800">Promo Spesial Hari Ini!</h4>
                        <p class="text-xs text-gray-600 mt-1">Dapatkan cashback hingga 500rb untuk pembayaran menggunakan PayLater.</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2025 Only Phones. All rights reserved.
        </div>
    </footer>

</body>

</html>