<?php
include("php/config.php");

// Inisialisasi pesan notifikasi
$notification = "";

if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis'];
    $usia = $_POST['usia'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Konfirmasi password
    if ($password != $password_confirm) {
        $notification = "Konfirmasi password tidak cocok.";
    } else {
        // Cek apakah email sudah terpakai
        $check_query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $notification = "Email sudah terpakai. Silakan gunakan email lain.";
        } else {
            // Untuk memastikan $password benar-benar di-hash sebelum disimpan ke database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Masukkan data ke dalam database
            $query = "INSERT INTO users (nama, no_hp, email, jenis_kelamin, usia, password) 
                      VALUES ('$nama', '$no_hp', '$email', '$jenis_kelamin', '$usia', '$hashed_password')";

            // Eksekusi query dengan menggunakan koneksi database ($con)
            if(mysqli_query($con, $query)){
                // Set notifikasi sukses
                $notification = "Sign up berhasil! Silakan login.";

                // Redirect ke halaman login setelah 2 detik
                header("refresh:2; url=login.php");
            } else{
                $notification = "ERROR: Tidak dapat mengeksekusi query: $query. " . mysqli_error($con);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>
            
            <!-- Tampilkan notifikasi jika ada pesan -->
            <?php if (!empty($notification)) : ?>
            <div class="message"><?php echo $notification; ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="field input">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" required>
                </div>

                <div class="field input">
                    <label for="no_hp">No Handphone</label>
                    <input type="text" name="no_hp" id="no_hp" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="field">
                    <label for="jenis">Jenis kelamin</label>
                    <div>
                        <input type="radio" name="jenis" id="jenis_laki" value="Laki-laki" required>
                        <label for="jenis_laki">Laki-laki</label>
                    </div>
                    <div>
                        <input type="radio" name="jenis" id="jenis_perempuan" value="Perempuan">
                        <label for="jenis_perempuan">Perempuan</label>
                    </div>
                </div>                

                <div class="field input">
                    <label for="usia">Usia</label>
                    <input type="number" name="usia" id="usia" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="field input">
                    <label for="password_confirm">Ulangi Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Sign Up">
                </div>
                <div class="links">
                    Already have an account? <a href="login.php">Log In</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
