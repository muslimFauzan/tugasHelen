<?php

require 'function.php';

$nama_item = '';
$jenis_item = '';
$tahun_terbit = '';
$author = '';
$rak = '';
$jumlah_copy = '';
$biaya = '';
$task = 'submitItem';

if (isset($_GET['kode_item'])) {
    $kode_item = $_GET['kode_item'];

    $dataBengkel = mysqli_query($conn, "SELECT * FROM item WHERE kode_item = '$kode_item'");
    foreach ($dataBengkel as $row) {
        $nama_item = $row['nama_item'];
        $jenis_item = $row['jenis_item'];
        $tahun_terbit = $row['tahun_terbit'];
        $author = $row['author'];
        $rak = $row['rak'];
        $jumlah_copy = $row['jumlah_copy'];
        $biaya = $row['biaya_pinjaman'];
    }

    $task = 'editItem';
}

?>
<div class="container">
    <div class="backBtn" onclick="toTableItem()">Kembali</div>
    <div style="text-align: center;">
        <h2>Form Tambah Item</h2>
    </div>
    <div class="wrapper-form">
        <div class="form-container">
            <form action="" method="post" onsubmit="handleSubmit()">
                <div class="input-form">
                    <label for="kode_item">Kode Item</label>
                    <input type="text" name="kode_item" readonly class="input-kolom" value="<?= $kode_item ?>">
                </div>
                <div class="input-form">
                    <label for="nama_item">Nama Item</label>
                    <input type="text" name="nama_item" id="nama_item" class="input-kolom" value="<?= $nama_item ?>" required>
                </div>
                <div class="input-form">
                    <label for="jenis_item">Jenis Item</label>
                    <select name="jenis_item" id="jenis_item" class="input-kolom" required>
                        <option value="1" <?= $opt = ($jenis_item == '1') ? 'selected' : '' ?>>CD</option>
                        <option value="2" <?= $opt = ($jenis_item == '2') ? 'selected' : '' ?>>VCD</option>
                    </select>
                </div>
                <div class="input-form">
                    <label for="author">Author</label>
                    <input type="text" name="author" id="author" class="input-kolom" value="<?= $author ?>" required>
                </div>
                <div class="input-form">
                    <label for="terbit">Tahun Terbit</label>
                    <input type="date" name="terbit" id="terbit" class="input-kolom" value="<?= $tahun_terbit ?>" required>
                </div>
                <div class="input-form">
                    <label for="jumlah">Jumlah Copy</label>
                    <input type="number" name="jumlah" id="jumlah" class="input-kolom" value="<?= $jumlah_copy ?>" min="0" required>
                </div>
                <div class="input-form">
                    <label for="rak">Nomer Rak</label>
                    <input type="number" name="rak" id="rak" class="input-kolom" value="<?= $rak ?>" min="0" required>
                </div>
                <div class="input-form">
                    <label for="biaya">Biaya Pinjaman</label>
                    <input type="number" name="biaya" id="biaya" class="input-kolom" value="<?= $biaya ?>" min="0" required>
                </div>
                <button type="submit" name="<?= $task ?>">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    $('#terbit').datepicker({
        autoclose: true,
        startDate: '+0d',
        // endDate: '+0d'
    });

    function handleSubmit() {
        Swal.fire({
            title: "Berhasil",
            text: "Berhasil disubmit!",
            icon: "success"
        });
    }
</script>