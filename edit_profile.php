<?php
session_start();
include("php/config.php");

// Pastikan pengguna telah login
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit;
}

// Ambil email pengguna dari sesi
$email = $_SESSION['valid'];

// Inisialisasi variabel pesan
$message = "";

// Proses pembaruan data pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $new_email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $usia = $_POST['usia'];

    // Update data pengguna di basis data
    $query = "UPDATE users SET nama='$nama', no_hp='$no_hp', email='$new_email', jenis_kelamin='$jenis_kelamin', usia='$usia' WHERE email='$email'";
    
    if (mysqli_query($con, $query)) {
        // Perbarui email dalam sesi jika email diperbarui
        $_SESSION['valid'] = $new_email;
        $_SESSION['message'] = "Profil berhasil diperbarui.";
        header("Location: profile.php");
        exit;
    } else {
        $message = "Terjadi kesalahan saat memperbarui profil: " . mysqli_error($con);
    }
}

// Ambil data pengguna dari database
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($con, $query);

// Periksa apakah query berhasil dan data pengguna ditemukan
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Jika data pengguna tidak ditemukan, lakukan penanganan kesalahan
    echo "Data pengguna tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Pengguna</title>
    <link rel="stylesheet" href="css/profilee.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="edit-profile-box">
                <h2>Edit Profil Pengguna</h2>
                <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>
                <form action="edit_profile.php" method="post">
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" id="nama" name="nama" value="<?php echo isset($user['nama']) ? $user['nama'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP:</label>
                        <input type="text" id="no_hp" name="no_hp" value="<?php echo isset($user['no_hp']) ? $user['no_hp'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin:</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki" <?php if(isset($user['jenis_kelamin']) && $user['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php if(isset($user['jenis_kelamin']) && $user['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="usia">Usia:</label>
                        <input type="number" id="usia" name="usia" value="<?php echo isset($user['usia']) ? $user['usia'] : ''; ?>" required>
                    </div>
                    <div class="profile-actions">
                        <button type="submit">Simpan Perubahan</button>
                        <button type="button" onclick="window.location.href='profile.php'">Kembali</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
