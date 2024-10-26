<?php
session_start();
include("php/config.php");

// Pastikan pengguna telah login
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit;
}

// Ambil email dari sesi
$email = $_SESSION['valid'];

// Ambil data pengguna dari database
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($con, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Error fetching user data: " . mysqli_error($con);
    exit;
}

// Ambil pesan dari session jika ada
$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Jika ada permintaan penghapusan transaksi
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query_delete = "DELETE FROM orders WHERE id='$delete_id' AND id_users='{$user['id_users']}'";
    if (mysqli_query($con, $query_delete)) {
        $_SESSION['message'] = "Transaksi berhasil dihapus.";
        header("Location: profile.php");
        exit;
    } else {
        $message = "Gagal menghapus transaksi: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="css/profilee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="profile-box">
                <div class="back-button">
                    <a href="home-profile.php"><i class="bi bi-chevron-left"></i> Kembali</a>
                </div>
                <h2>Profil Pengguna</h2>
                <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
                <div class="profile-picture">
                    <img src="gallery/profil.png" alt="Foto Profil">
                </div>
                <div class="profile-info">
                    <div class="info-item">
                        <span>Nama</span>
                        <p><b>:</b> <?php echo $user['nama']; ?></p>
                    </div>
                    <div class="info-item">
                        <span>No HP</span>
                        <p><b>:</b> <?php echo $user['no_hp']; ?></p>
                    </div>
                    <div class="info-item">
                        <span>Email</span>
                        <p><b>:</b> <?php echo $user['email']; ?></p>
                    </div>
                    <div class="info-item">
                        <span>Jenis Kelamin</span>
                        <p><b>:</b> <?php echo $user['jenis_kelamin']; ?></p>
                    </div>
                    <div class="info-item">
                        <span>Usia</span>
                        <p><b>:</b> <?php echo $user['usia']; ?></p>
                    </div>
                </div>
                <div class="profile-actions">
                    <button onclick="window.location.href='edit_profile.php'"><i class="bi bi-pencil-square"></i> Edit</button>
                    <button onclick="confirmLogout()">LogOut <i class="bi bi-box-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="transaction-container">
            <h2 align="center">Riwayat Transaksi</h2>
            <div class="transaction-history">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <th>Total Tiket</th>
                            <th>Tipe Pengunjung</th>
                            <th>Metode Pembayaran</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ambil riwayat transaksi pengguna dari database
                        $id_users = $user['id_users']; // Ambil id_users dari pengguna yang sedang login
                        $query_transaksi = "SELECT * FROM orders WHERE id_users='$id_users' ORDER BY tanggal DESC";
                        $result_transaksi = mysqli_query($con, $query_transaksi);

                        if (mysqli_num_rows($result_transaksi) > 0) {
                            while ($transaksi = mysqli_fetch_assoc($result_transaksi)) {
                                echo "<tr>";
                                echo "<td>" . $transaksi['tanggal'] . "</td>";
                                echo "<td>" . ($transaksi['prambanan_dewasa'] + $transaksi['prambanan_anak']) . "</td>";
                                echo "<td>" . $transaksi['tipe_pengunjung'] . "</td>";
                                echo "<td>" . $transaksi['metode_pembayaran'] . "</td>";
                                echo "<td>IDR " . number_format($transaksi['subtotal'], 0, ',', '.') . "</td>";
                                echo "<td><button onclick=\"confirmDelete(" . $transaksi['id'] . ")\"><i class='bi bi-trash'></i></button></td>";                                
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada riwayat transaksi.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = "logout.php";
            }
        }

        function confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus transaksi ini?")) {
                window.location.href = "profile.php?delete_id=" + id;
            }
        }
    </script>
</body>
</html>
