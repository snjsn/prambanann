<?php include 'php/header.php'; ?>
<?php include 'php/config.php'; ?>

<?php
session_start();

// Inisialisasi jumlah tiket jika belum ada
if (!isset($_SESSION['prambanan_dewasa'])) {
    $_SESSION['prambanan_dewasa'] = 0;
}

if (!isset($_SESSION['prambanan_anak'])) {
    $_SESSION['prambanan_anak'] = 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Candi Prambanan</title>
    <link rel="stylesheet" href="css/tiket.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
<main>
    <div class="container">
        <div class="box form-box">
            <h2>Checkout Tiket</h2>

            <div class="checkout-info">
                <div class="checkout-item">
                    <label for="tanggal">Pilih Tanggal:</label>
                    <input type="date" id="tanggal" value="">
                </div>
                <div class="checkout-item">
                    <label for="tipe-pengunjung">Tipe Pengunjung:</label>
                    <select id="tipe-pengunjung">
                        <option value="domestik">Domestik</option>
                        <option value="mancanegara">Mancanegara</option>
                    </select>
                </div>
            </div>

            <div class="tiket-list">
                <div class="tiket-item" id="dewasa-item">
                    <h3>Prambanan Dewasa</h3>
                    <p><b class="date">Tanggal Kunjungan</b>, 06.30-17.00 WIB</p>
                    <ul class="syarat-ketentuan">
                        <li>Tiket Berlaku sesuai tanggal Kunjungan yang dipilih</li>
                        <li>Tiket tidak dapat dikembalikan (non-refundable)</li>
                        <li>Lihat lebih</li>
                    </ul>
                    <p class="harga" id="harga-dewasa">IDR 50.000</p>
                    <div>
                        <button type="button" class="tambah-tiket" data-tiket-type="prambanan_dewasa"><i class="bi bi-plus-lg"></i></button>
                        <p class="jumlah-tiket" id="jumlah-tiket-dewasa"><?php echo $_SESSION['prambanan_dewasa']; ?></p>
                        <button type="button" class="kurang-tiket" data-tiket-type="prambanan_dewasa"><i class="bi bi-dash-lg"></i></button>
                    </div>
                </div>

                <div class="tiket-item" id="anak-item">
                    <h3>Prambanan Anak</h3>
                    <p><b class="date">Tanggal Kunjungan</b>, 06.30-17.00 WIB</p>
                    <ul class="syarat-ketentuan">
                        <li>Tiket Berlaku sesuai tanggal Kunjungan yang dipilih</li>
                        <li>Tiket tidak dapat dikembalikan (non-refundable)</li>
                        <li>Lihat lebih</li>
                    </ul>
                    <p class="harga" id="harga-anak">IDR 25.000</p>
                    <div>
                        <button type="button" class="tambah-tiket" data-tiket-type="prambanan_anak"><i class="bi bi-plus-lg"></i></button>
                        <p class="jumlah-tiket" id="jumlah-tiket-anak"><?php echo $_SESSION['prambanan_anak']; ?></p>
                        <button type="button" class="kurang-tiket" data-tiket-type="prambanan_anak"><i class="bi bi-dash-lg"></i></button>
                    </div>
                </div>

                <div class="checkout-item">
                    <label>Metode Pembayaran:</label>
                    <div>
                        <input type="radio" id="transfer" name="metode-pembayaran" value="transfer">
                        <label for="transfer"><i class="bi bi-bank"></i> Transfer Bank</label>
                    </div>
                    <div>
                        <input type="radio" id="credit" name="metode-pembayaran" value="credit">
                        <label for="credit"><i class="bi bi-credit-card"></i> Kartu Kredit</label>
                    </div>
                    <div>
                        <input type="radio" id="ewallet" name="metode-pembayaran" value="ewallet">
                        <label for="ewallet"><i class="bi bi-wallet2"></i> E-Wallet</label>
                    </div>
                </div>
            </div>

            <div class="subtotal">
                <p>Subtotal (<span id="total-tiket"><?php echo $_SESSION['prambanan_dewasa'] + $_SESSION['prambanan_anak']; ?></span> tiket): IDR <span id="subtotal"><?php echo ($_SESSION['prambanan_dewasa'] * 50000) + ($_SESSION['prambanan_anak'] * 25000); ?></span></p>
                <form id="checkout-form" action="update_tiket.php" method="post">
                    <input type="hidden" name="tanggal" id="hidden-tanggal">
                    <input type="hidden" name="tipe_pengunjung" id="hidden-tipe-pengunjung">
                    <input type="hidden" name="prambanan_dewasa" id="hidden-prambanan-dewasa">
                    <input type="hidden" name="prambanan_anak" id="hidden-prambanan-anak">
                    <input type="hidden" name="metode_pembayaran" id="hidden-metode-pembayaran">
                    <input type="hidden" name="subtotal" id="hidden-subtotal">
                    <button type="submit" class="btn-pilih-tiket" disabled>Pesan</button>
                </form>
            </div>
        </div>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; 2024 Powered by Prambanan</p>
    </div>
</footer>

<script>
    // Fungsi untuk memperbarui harga dan teks berdasarkan tipe pengunjung
    function updatePricesAndText() {
        var tipePengunjung = document.getElementById('tipe-pengunjung').value;
        var hargaDewasa = (tipePengunjung == 'mancanegara') ? 500000 : 50000;
        var hargaAnak = (tipePengunjung == 'mancanegara') ? 250000 : 25000;

        // Perbarui teks dan harga untuk dewasa
        var dewasaItem = document.getElementById('dewasa-item');
        dewasaItem.querySelector('h3').textContent = (tipePengunjung == 'mancanegara') ? 'Prambanan Adult' : 'Prambanan Dewasa';
        document.getElementById('harga-dewasa').textContent = 'IDR ' + hargaDewasa.toLocaleString();

        // Perbarui teks dan harga untuk anak
        var anakItem = document.getElementById('anak-item');
        anakItem.querySelector('h3').textContent = (tipePengunjung == 'mancanegara') ? 'Prambanan Child' : 'Prambanan Anak';
        document.getElementById('harga-anak').textContent = 'IDR ' + hargaAnak.toLocaleString();
        
        // Perbarui subtotal
        updateSubtotal();
        checkFormCompletion();
    }

    // Fungsi untuk memperbarui subtotal
    function updateSubtotal() {
        var tipePengunjung = document.getElementById('tipe-pengunjung').value;
        var hargaDewasa = (tipePengunjung == 'mancanegara') ? 500000 : 50000;
        var hargaAnak = (tipePengunjung == 'mancanegara') ? 250000 : 25000;

        var jumlahDewasa = parseInt(document.getElementById('jumlah-tiket-dewasa').textContent);
        var jumlahAnak = parseInt(document.getElementById('jumlah-tiket-anak').textContent);

        var subtotal = (jumlahDewasa * hargaDewasa) + (jumlahAnak * hargaAnak);
        document.getElementById('subtotal').textContent = subtotal.toLocaleString();
    }

    function checkFormCompletion() {
        var tanggal = document.getElementById('tanggal').value;
        var tipePengunjung = document.getElementById('tipe-pengunjung').value;
        var jumlahDewasa = parseInt(document.getElementById('jumlah-tiket-dewasa').textContent);
        var jumlahAnak = parseInt(document.getElementById('jumlah-tiket-anak').textContent);
        var metodePembayaran = document.querySelector('input[name="metode-pembayaran"]:checked');

        var isFormComplete = tanggal && tipePengunjung && (jumlahDewasa > 0 || jumlahAnak > 0) && metodePembayaran;
        document.querySelector('.btn-pilih-tiket').disabled = !isFormComplete;
    }

    document.querySelectorAll('.tambah-tiket, .kurang-tiket').forEach(function(button) {
        button.addEventListener('click', function() {
            var tiketType = this.getAttribute('data-tiket-type');
            var action = this.classList.contains('tambah-tiket') ? 'tambah' : 'kurang';
            var tipePengunjung = document.getElementById('tipe-pengunjung').value;
            
            // Lakukan permintaan AJAX ke update_tiket.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_tiket.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('jumlah-tiket-dewasa').textContent = response.dewasa;
                    document.getElementById('jumlah-tiket-anak').textContent = response.anak;
                    document.getElementById('subtotal').textContent = response.subtotal.toLocaleString();
                    document.getElementById('total-tiket').textContent = response.total_tiket;
                    checkFormCompletion();
                }
            };
            xhr.send('tiket_type=' + tiketType + '&action=' + action + '&tipe_pengunjung=' + tipePengunjung );
        });
    });

    document.getElementById('tipe-pengunjung').addEventListener('change', function() {
        updatePricesAndText();
        checkFormCompletion();
    });

    document.getElementById('tanggal').addEventListener('change', function() {
        var selectedDate = this.value;
        var dateElements = document.querySelectorAll('.date');
        dateElements.forEach(function(element) {
            element.textContent = selectedDate;
        });
        checkFormCompletion();
    });

    document.querySelectorAll('input[name="metode-pembayaran"]').forEach(function(radio) {
        radio.addEventListener('change', checkFormCompletion);
    });

    // Update hidden fields before submitting the form
    document.querySelector('.btn-pilih-tiket').addEventListener('click', function() {
        document.getElementById('hidden-tanggal').value = document.getElementById('tanggal').value;
        document.getElementById('hidden-tipe-pengunjung').value = document.getElementById('tipe-pengunjung').value;
        document.getElementById('hidden-prambanan-dewasa').value = document.getElementById('jumlah-tiket-dewasa').textContent;
        document.getElementById('hidden-prambanan-anak').value = document.getElementById('jumlah-tiket-anak').textContent;
        document.getElementById('hidden-subtotal').value = document.getElementById('subtotal').textContent.replace(/,/g, '');
        
        // Get the selected payment method
        var selectedPaymentMethod = document.querySelector('input[name="metode-pembayaran"]:checked').value;
        document.getElementById('hidden-metode-pembayaran').value = selectedPaymentMethod;
        
        document.getElementById('checkout-form').submit();
    });

    // Initial check on page load
    checkFormCompletion();
</script>
</body>
</html>
