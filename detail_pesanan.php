<?php
session_start();
include 'php/config.php';

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['order_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = $_SESSION['order_id'];

// Ambil detail pesanan dari database
$query = "SELECT * FROM orders WHERE id = '$order_id' AND id_users = '$user_id'";
$result = mysqli_query($con, $query);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

// Ambil detail pengguna dari database
$query_user = "SELECT * FROM users WHERE id_users = '$user_id'";
$result_user = mysqli_query($con, $query_user);
$user = mysqli_fetch_assoc($result_user);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="css/detail.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
    <div class="back-button">
        <a href="home-profile.php"><i class="bi bi-chevron-left"></i> Kembali</a>
    </div>
    <div class="container">
    <div class="ticket">
            <div class="ticket-header">
                <div class="ticket-title">Detail Pesanan</div>
                <div class="ticket-info">
                    <span>ID Pesanan: <?php echo $order['id']; ?></span>
                    <span>Nama: <?php echo $user['nama']; ?></span>
                    <span><?php echo $user['email']; ?></span>
                </div>
            </div>
            <div class="ticket-body">
                <div class="ticket-section">
                    <span class="label">Tanggal Kunjungan</span>
                    <span class="value"><?php echo $order['tanggal']; ?></span>
                </div>
                <div class="ticket-section">
                    <span class="label">Tipe Pengunjung</span>
                    <span class="value"><?php echo $order['tipe_pengunjung']; ?></span>
                </div>
                <div class="ticket-section">
                    <span class="label">Jumlah Tiket Dewasa</span>
                    <span class="value"><?php echo $order['prambanan_dewasa']; ?></span>
                </div>
                <div class="ticket-section">
                    <span class="label">Jumlah Tiket Anak</span>
                    <span class="value"><?php echo $order['prambanan_anak']; ?></span>
                </div>
                <div class="ticket-section">
                    <span class="label">Metode Pembayaran</span>
                    <span class="value"><?php echo ucfirst($order['metode_pembayaran']); ?></span>
                </div>
                <div class="ticket-section">
                    <span class="label">Subtotal</span>
                    <span class="value">IDR <?php echo number_format($order['subtotal'], 0, ',', '.'); ?></span>
                </div>
            </div>
            <div class="ticket-footer">
                <img src="gallery/barcode.png" alt="Barcode" class="barcode">
                <span class="contact-info">021-80187116</span>
            </div>
        </div>
    </div>
</body>
</html>
