<?php
require 'function.php';

$task = 'submitPinjam';

if (isset($_GET['kode_transaksi'])) {
    $kode_transaksi = $_GET['kode_transaksi'];

    $getDetail = mysqli_query($conn, "SELECT * FROM peminjaman_header WHERE kode_transaksi = '$kode_transaksi'");
    foreach ($getDetail as $row) {
        $nama_peminjam = $row['nama_peminjam'];
        $kode_item = $row['kode_item'];
        $jumlah_item = $row['jumlah_item'];
        $tanggal_pinjam = $row['tanggal_pinjam'];
        $tanggal_kembali = $row['tanggal_kembali'];
        $biaya_total = $row['biaya_total'];
        $deskripsi = $row['deskripsi'];
    }

    $task = 'editPinjam';
}
?>
<div class="container">
    <div class="backBtn" onclick="backToTable()">Kembali</div>
    <div style="text-align: center;">
        <h2>Form Tambah Data</h2>
    </div>
    <div class="wrapper-form">
        <div class="form-container">
            <form action="" method="post" onsubmit="handleSubmit()">
                <div class="input-form">
                    <label for="kode_pinjam">Kode Pinjaman</label>
                    <input type="text" name="kode_pinjam" readonly class="input-kolom" value="<?= $kode_transaksi ?>">
                </div>
                <div class="input-form">
                    <label for="nama_peminjam">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="input-kolom" value="<?= $nama_peminjam ?>" required>
                </div>
                <div class="input-form">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="input-kolom" value="<?= $tanggal_pinjam ?>" required>
                </div>
                <div class="input-form">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="input-kolom" value="<?= $tanggal_kembali ?>" required>
                </div>
                <div class="input-form">
                    <label for="item">Pilih Item</label>
                    <select name="item" id="item" class="input-kolom" required>
                        <?php
                        global $conn;
                        $getItem = mysqli_query($conn, "SELECT * FROM item");
                        foreach ($getItem as $row) {
                        ?>
                            <option value="<?= $row['kode_item'] ?>" <?= $sc = ($row['kode_item'] == $kode_item ? 'selected' : '') ?>><?= $row['nama_item'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="input-form">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="input-kolom" value="<?= $jumlah_item ?>" max="" required>
                </div>
                <div class="input-form">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"><?= $deskripsi ?></textarea>
                </div>
                <button type="submit" name="<?= $task ?>">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    function handleSubmit() {
        Swal.fire({
            title: "Berhasil",
            text: "Berhasil disubmit!",
            icon: "success"
        });
    }
</script>