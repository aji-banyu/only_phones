<?php
session_start();
include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola User</title>

  <link rel="stylesheet" href="../assets/css/output.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-bg-main font-[Poppins] antialiased text-slate-800">
  <div class="flex h-screen overflow-hidden">
    <?php include 'sidebar.php' ?>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">
      <header class="px-8 py-8 bg-bg-main sticky top-0 z-40">
        <h1 class="text-4xl font-bold text-blue-dark">Kelola User</h1>
      </header>

      <div class="px-8 pb-8">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
          <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-bold text-blue-dark">Daftar User</h3>
            <a href="tambah_user.php" class="bg-blue-main hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-xl font-semibold shadow-lg transition-all flex items-center gap-2">
              <i class="fas fa-plus"></i> Tambah user
            </a>
          </div>

          <?php
          $role = [
            "admin",
            "user"
          ];

          $role_active = $_GET['role'];
          ?>
          <div class="mb-2 border-b border-gray-100 pb-2">
            <div class="flex gap-4 overflow-x-auto no-scrollbar" id="tabContainer">

              <?php foreach ($role as $r) : ?>
                <a href="kelola_user.php?role=<?= $r ?>"
                  class="pb-3 px-2 text-xl font-semibold whitespace-nowrap transition-all relative border-b-2 cursor-pointer 
                  <?= ($role_active == $r)
                    ? 'text-blue-600 border-blue-600' // Style saat AKTIF (Biru)
                    : 'text-gray-400 border-transparent hover:text-gray-600 hover:border-gray-200' // Style saat TIDAK AKTIF
                  ?>">
                  <?= ucfirst($r) // ucfirst agar huruf depan kapital (Admin) 
                  ?>
                </a>
              <?php endforeach ?>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-md text-gray-400 uppercase border-b border-gray-100">
                  <th class="py-4 font-bold pl-2">Id</th>
                  <th class="py-4 font-bold">Nama</th>
                  <th class="py-4 font-bold">Email</th>
                  <th class="py-4 font-bold">Role</th>
                  <th class="py-4 font-bold text-right pr-2">Aksi</th>
                </tr>
              </thead>
              <tbody class="text-sm divide-y divide-gray-50">







                <?php
                $role = $_GET['role'];

                $query_user = "SELECT * FROM users WHERE role = '$role'";

                $users = $conn->query($query_user);
                $user = $users->fetch_assoc();
                $user['nama']
                ?>

                <?php if (mysqli_num_rows($users) > 0): ?>
                  <?php while ($row = mysqli_fetch_assoc($users)): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                      <td class="py-4">
                        <div class="flex items-center gap-4">
                          <div>
                            <p class="font-bold text-gray-700 text-xl"><?= $row['id_user']; ?></p>
                          </div>
                        </div>
                      </td>
                      <td class="py-4"><span class="text-blue-main text-xl font-bold"><?= $row['nama']; ?></span></td>
                      <td class="py-4 text-xl font-semibold text-gray-700"><?= $row['email'] ?></td>
                      <td class="py-4"><span class="bg-blue-50 text-blue-main px-3 py-1 rounded-full text-xl font-semibold"><?= $row['role']; ?></span></td>
                      <td class="py-4 text-right relative pr-2">
                        <div class="flex justify-between items-center absolute right-2 top-1/2 -translate-y-3/6 gap-2 w-max">
                          <a href="update_user.php?id=<?= $row['id_user'] ?>" class="w-8 h-8 rounded-lg text-green-400 hover:bg-green-100 inline-flex items-center justify-center transition-colors"><i class=" fa-solid fa-pen"></i></a>
                          <a href="hapus_user.php?id=<?= $row['id_user']; ?>" onclick="return confirm('Yakin hapus?')" class="w-8 h-8 rounded-lg text-red-400 hover:bg-red-100 inline-flex items-center justify-center transition-colors"><i class="fas fa-trash"></i></a>
                        </div>
                      </td>
                    </tr>
                  <?php endwhile; ?>

                <?php else: ?>
                  <tr>
                    <td colspan="5" class="py-6 text-center text-gray-400 italic">Gudang Kosong</td>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>