<?php
session_start();
include 'koneksi.php';

// 1. Cek dulu, yang beli sudah login belum?
if (!isset($_SESSION['user'])) {
  echo "<script>alert('Silakan login dulu!'); location='login.php';</script>";
  exit();
}

// 2. Ambil id produk dari link (URL)
$id_barang = $_GET['id'];
$id_pembeli = $_SESSION['user']['id_user'];

// 3. Cek stok di gudang (tabel products)
$cek_stok = $conn->query("SELECT stok FROM products WHERE id_produk = '$id_barang'");
$data_barang = $cek_stok->fetch_assoc();

// Kalau stok habis, tolak
if ($data_barang['stok'] < 1) {
  echo "<script>alert('Yah, stoknya habis bos!'); location='index.php';</script>";
  exit();
}

// 4. Cek apakah barang ini sudah ada di keranjang si pembeli?
$cek_keranjang = $conn->query("SELECT * FROM keranjang WHERE id_user = '$id_pembeli' AND id_produk = '$id_barang'");
$isi_keranjang = $cek_keranjang->fetch_assoc();

if ($isi_keranjang) {
  // Kalau sudah ada, kita tambah jumlahnya saja (+1)
  $id_keranjang_nya = $isi_keranjang['id_keranjang'];
  $conn->query("UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_keranjang = '$id_keranjang_nya'");
} else {
  // Kalau belum ada, masukkan baru ke tabel keranjang
  $conn->query("INSERT INTO keranjang (id_user, id_produk, jumlah) VALUES ('$id_pembeli', '$id_barang', 1)");
}

// Balikin ke halaman keranjang
echo "<script>alert('Barang masuk keranjang!'); location='keranjang.php';</script>";
