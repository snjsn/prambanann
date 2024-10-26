<?php
session_start();
include 'php/config.php';

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['prambanan_dewasa'])) {
    $_SESSION['prambanan_dewasa'] = 0;
}

if (!isset($_SESSION['prambanan_anak'])) {
    $_SESSION['prambanan_anak'] = 0;
}

if (isset($_POST['tiket_type']) && isset($_POST['tipe_pengunjung'])) {
    $tiket_type = $_POST['tiket_type'];
    $action = $_POST['action'];
    $tipe_pengunjung = $_POST['tipe_pengunjung'];

    $dewasa_harga = ($tipe_pengunjung == 'mancanegara') ? 500000 : 50000;
    $anak_harga = ($tipe_pengunjung == 'mancanegara') ? 250000 : 25000;

    if ($action == 'tambah') {
        if ($tiket_type == 'prambanan_dewasa') {
            $_SESSION['prambanan_dewasa']++;
        } elseif ($tiket_type == 'prambanan_anak') {
            $_SESSION['prambanan_anak']++;
        }
    } elseif ($action == 'kurang') {
        if ($tiket_type == 'prambanan_dewasa' && $_SESSION['prambanan_dewasa'] > 0) {
            $_SESSION['prambanan_dewasa']--;
        } elseif ($tiket_type == 'prambanan_anak' && $_SESSION['prambanan_anak'] > 0) {
            $_SESSION['prambanan_anak']--;
        }
    }

    $subtotal = ($_SESSION['prambanan_dewasa'] * $dewasa_harga) + ($_SESSION['prambanan_anak'] * $anak_harga);
    $total_tiket = $_SESSION['prambanan_dewasa'] + $_SESSION['prambanan_anak'];

    echo json_encode([
        'dewasa' => $_SESSION['prambanan_dewasa'],
        'anak' => $_SESSION['prambanan_anak'],
        'subtotal' => $subtotal,
        'total_tiket' => $total_tiket
    ]);
} elseif (isset($_POST['tanggal']) && isset($_POST['tipe_pengunjung']) && isset($_POST['metode_pembayaran'])) {
    $tanggal = mysqli_real_escape_string($con, $_POST['tanggal']);
    $tipe_pengunjung = mysqli_real_escape_string($con, $_POST['tipe_pengunjung']);
    $prambanan_dewasa = intval($_POST['prambanan_dewasa']);
    $prambanan_anak = intval($_POST['prambanan_anak']);
    $subtotal = intval($_POST['subtotal']);
    $metode_pembayaran = mysqli_real_escape_string($con, $_POST['metode_pembayaran']);

    $query = "INSERT INTO orders (id_users, tanggal, tipe_pengunjung, prambanan_dewasa, prambanan_anak, subtotal, metode_pembayaran) VALUES ('$user_id', '$tanggal', '$tipe_pengunjung', '$prambanan_dewasa', '$prambanan_anak', '$subtotal', '$metode_pembayaran')";
    if (mysqli_query($con, $query)) {
        $_SESSION['order_id'] = mysqli_insert_id($con);
        
        // Reset jumlah tiket setelah pesanan berhasil disimpan
        $_SESSION['prambanan_dewasa'] = 0;
        $_SESSION['prambanan_anak'] = 0;
        
        header("Location: detail_pesanan.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}
?>
