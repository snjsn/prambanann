<?php
include("php/config.php");

// Inisialisasi pesan notifikasi
$notification = "";

// Pastikan ada parameter ID yang diteruskan
if (isset($_GET['id_users'])) {
    $id = $_GET['id_users'];
    
    // Ambil data user berdasarkan ID
    $user_query = "SELECT * FROM users WHERE id='$id'";
    $user_result = mysqli_query($con, $user_query);

    // Pastikan data user tersedia sebelum digunakan
    if (mysqli_num_rows($user_result) > 0) {
        $user = mysqli_fetch_assoc($user_result);

        // Proses pengeditan data user jika form disubmit
        if (isset($_POST['update'])) {
            $nama = $_POST['nama'];
            $no_hp = $_POST['no_hp'];
            $email = $_POST['email'];
            $jenis_kelamin = $_POST['jenis'];
            $usia = $_POST['usia'];

            $update_query = "UPDATE users SET nama='$nama', no_hp='$no_hp', email='$email', jenis_kelamin='$jenis_kelamin', usia='$usia' WHERE id='$id'";
            
            if (mysqli_query($con, $update_query)) {
                $notification = "User berhasil diperbarui.";
            } else {
                $notification = "ERROR: Tidak dapat mengeksekusi query: $update_query. " . mysqli_error($con);
            }
        }
    } else {
        $notification = "User tidak ditemukan.";
    }
} else {
    $notification = "Parameter ID tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edit User</title>
</head>
<body>
    <div class="container">
        <div class="box">
            <header>Edit User</header>
            
            <?php if (!empty($notification)) : ?>
            <div class="message"><?php echo $notification; ?></div>
            <?php endif; ?>

            <?php if (!empty($user)) : ?> <!-- Pastikan $user tidak kosong sebelum menampilkan form -->
            <form action="edit_user.php?id=<?php echo $user['id']; ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                <div class="field input">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="<?php echo $user['nama']; ?>" required>
                </div>

                <div class="field input">
                    <label for="no_hp">No Handphone</label>
                    <input type="text" name="no_hp" id="no_hp" value="<?php echo $user['no_hp']; ?>" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>
                </div>

                <div class="field">
                    <label for="jenis">Jenis kelamin</label>
                    <div>
                        <input type="radio" name="jenis" id="jenis_laki" value="Laki-laki" <?php echo ($user['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?> required>
                        <label for="jenis_laki">Laki-laki</label>
                    </div>
                    <div>
                        <input type="radio" name="jenis" id="jenis_perempuan" value="Perempuan" <?php echo ($user['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?>>
                        <label for="jenis_perempuan">Perempuan</label>
                    </div>
                </div>                

                <div class="field input">
                    <label for="usia">Usia</label>
                    <input type="number" name="usia" id="usia" value="<?php echo $user['usia']; ?>" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="update" value="Update User">
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
