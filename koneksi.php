<?php
$conn = new mysqli('localhost', 'root', '', 'only_phones');

if ($conn->connect_error) {
  die("Koneksi gagal : " . $conn->connect_error);
}
