<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
  header("location:login.php");
}

$id_pembeli = $_SESSION['user']['id_user'];

// 1. Cek keranjangnya kosong gak?
$cek_isi = $conn->query("SELECT * FROM keranjang WHERE id_user = '$id_pembeli'");
if ($cek_isi->num_rows == 0) {
  echo "<script>alert('Keranjang kosong bos, belanja dulu!'); location='index.php';</script>";
  exit();
}

// 2. Hitung total belanjaan
$query_total = $conn->query("SELECT SUM(k.jumlah * p.harga) as total_duit 
                             FROM keranjang k JOIN products p ON k.id_produk = p.id_produk 
                             WHERE k.id_user = '$id_pembeli'");
$hasil_total = $query_total->fetch_assoc();
$total_bayar = $hasil_total['total_duit'];
$tanggal_sekarang = date("Y-m-d H:i:s");

// 3. Simpan data utama ke tabel TRANSACTIONS (Status awal: Pending)
$conn->query("INSERT INTO transactions (id_user, tanggal_transaksi, total_harga, status) 
              VALUES ('$id_pembeli', '$tanggal_sekarang', '$total_bayar', 'pending')");

// Ambil ID transaksi yang barusan dibuat (biar nyambung sama detailnya)
$id_transaksi_baru = $conn->insert_id;

// 4. Pindahkan isi keranjang ke tabel TRANSACTIONS_DETAILS
$ambil_barang = $conn->query("SELECT k.*, p.harga FROM keranjang k JOIN products p ON k.id_produk = p.id_produk WHERE k.id_user = '$id_pembeli'");

while ($item = $ambil_barang->fetch_assoc()) {
  $id_produk = $item['id_produk'];
  $jumlah = $item['jumlah'];
  $subtotal = $item['harga'] * $jumlah;

  // Masukkan ke tabel detail transaksi
  $conn->query("INSERT INTO transactions_details (id_transaksi, id_produk, jumlah, subtotal) 
                  VALUES ('$id_transaksi_baru', '$id_produk', '$jumlah', '$subtotal')");
}

// 5. Kosongkan keranjang si pembeli (karena sudah masuk pesanan)
$conn->query("DELETE FROM keranjang WHERE id_user = '$id_pembeli'");

// 6. Selesai, suruh bayar
echo "<script>alert('Pesanan berhasil! Silakan upload bukti bayar.'); location='kirim_bukti.php?id=$id_transaksi_baru';</script>";
