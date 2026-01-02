<?php
include '../koneksi.php';

$id = $_GET['id'];

$user = $conn->query("SELECT role FROM users WHERE id_user = $id");
$data = $user->fetch_assoc();

$role = $data['role'];

$result = mysqli_query($conn, "DELETE FROM users WHERE id_user = '$id'");

if ($result) {
  echo "
        <script>
            alert('Berhasil menghapus User');
            window.location.href = 'kelola_user.php?role=" . $role . "';
        </script>
        ";
}
