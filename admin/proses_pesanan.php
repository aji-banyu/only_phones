<?php
include '../koneksi.php';

// Ambil data dari link URL
$id_pesanan = $_GET['id'];
$aksi_admin = $_GET['aksi']; // Isinya bisa 'terima' atau 'tolak'

if ($aksi_admin == 'terima') {
  // ============================================================
  // KONDISI 1: JIKA ADMIN KLIK TERIMA
  // ============================================================

  // 1. Ubah status pesanan jadi 'lunas'
  $conn->query("UPDATE transactions SET status = 'lunas' WHERE id_transaksi = '$id_pesanan'");

  // 2. KURANGI STOK BARANG (HANYA DISINI!)
  // Ambil dulu barang apa aja yang dibeli di pesanan ini
  $daftar_barang = $conn->query("SELECT * FROM transactions_details WHERE id_transaksi = '$id_pesanan'");

  while ($barang = $daftar_barang->fetch_assoc()) {
    $id_produknya = $barang['id_produk'];
    $jumlah_beli = $barang['jumlah'];

    // Kurangi stok di tabel products
    $conn->query("UPDATE products SET stok = stok - $jumlah_beli WHERE id_produk = '$id_produknya'");
  }

  echo "<script>alert('Sip! Pesanan lunas & Stok sudah dikurangi otomatis.'); location='pesanan_masuk.php';</script>";
} elseif ($aksi_admin == 'tolak') {
  // ============================================================
  // KONDISI 2: JIKA ADMIN KLIK TOLAK
  // ============================================================

  // 1. Ubah status jadi batal
  $conn->query("UPDATE transactions SET status = 'batal' WHERE id_transaksi = '$id_pesanan'");

  // PERHATIKAN: DISINI TIDAK ADA KODE PENGURANGAN STOK
  // Jadi stok barang di gudang aman, tidak akan berkurang.

  echo "<script>alert('Oke, pesanan dibatalkan. Stok aman (tidak berkurang).'); location='pesanan_masuk.php';</script>";
}
