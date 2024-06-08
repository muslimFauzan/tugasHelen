<?php
$conn = mysqli_connect('localhost', 'root', '', 'rent');

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
}


if (isset($_POST['submitItem'])) {
    $nama_item = $_POST['nama_item'];
    $jenis_item = $_POST['jenis_item'];
    $author = $_POST['author'];
    $terbit = $_POST['terbit'];
    $jumlah = $_POST['jumlah'];
    $rak = $_POST['rak'];
    $biaya = $_POST['biaya'];

    $trimCodeItem = str_replace(' ', '-', $nama_item);
    $kode_item = strtoupper($trimCodeItem);

    if ($jenis_item == '1') {
        $jenis = 'CD';
    } else {
        $jenis = 'VCD';
    }

    $query = "INSERT INTO
                    item
                    VALUES 
                ('', '$kode_item', '$nama_item', '$jenis_item', '$terbit', '$author', '$rak', '$jumlah', '$biaya')";

    mysqli_query($conn, $query);
    // if (mysqli_affected_rows($conn) > 0) {
    //     echo "<script type='text/javascript'> 
    //     alert('Tambah Item Berhasil!') 
    // </script>";
    // }
}

if (isset($_POST['editItem'])) {
    $kode_item = $_POST['kode_item'];
    $nama_item = $_POST['nama_item'];
    $jenis_item = $_POST['jenis_item'];
    $author = $_POST['author'];
    $terbit = $_POST['terbit'];
    $jumlah = $_POST['jumlah'];
    $rak = $_POST['rak'];
    $biaya = $_POST['biaya'];


    $query = "UPDATE item SET nama_item = '$nama_item', jenis_item = '$jenis_item', tahun_terbit = '$terbit', author = '$author', rak = '$rak', jumlah_copy = '$jumlah', biaya_pinjaman = '$biaya' WHERE kode_item = '$kode_item'";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapusItem($kode_item)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM item WHERE kode_item = '$kode_item'");

    return mysqli_affected_rows($conn);
}

if (isset($_POST['submitPinjam'])) {
    global $conn;

    $nama_peminjam = $_POST['nama_peminjam'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $item = $_POST['item'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    $getPrice = "SELECT * FROM item WHERE kode_item = '$item'";
    $resGetPrice = mysqli_query($conn, $getPrice);
    foreach ($resGetPrice as $prc) {
        $price = $prc['biaya_pinjaman'];
        $nama_item = $prc['nama_item'];
    }

    $gTotal = $jumlah * $price;

    $getCode = "SELECT * FROM peminjaman_header ORDER BY id DESC LIMIT 1";
    $resGetCode = mysqli_query($conn, $getCode);
    if ($resGetCode == null) {
        $kode_pinjam = 'TRPJ00001';
    } else {

        foreach ($resGetCode as $gc) {
            $lastCode = $gc['kode_transaksi'];
        }

        preg_match('/\d+$/', $lastCode, $matches);
        $numeric_part = (int)$matches[0];

        $numberCode = $numeric_part + 1;
        $paddedSerial = str_pad($numberCode, 5, '0', STR_PAD_LEFT);
        $kode_pinjam = 'TRPJ' . $paddedSerial;
    }

    $getID = "SELECT id FROM peminjaman_header ORDER BY id DESC LIMIT 1";
    $resGetId = mysqli_query($conn, $getID);
    foreach ($resGetId as $rowId) {
        $id = intval($rowId['id']);
    }
    $newId = $id + 1;

    $query = "INSERT INTO
                    peminjaman_header
                    VALUES 
                ('$newId', '$kode_pinjam', '$nama_peminjam', '$item', '$nama_item', '$jumlah', '$tanggal_pinjam', '$tanggal_kembali', '$gTotal', '$deskripsi')";

    mysqli_query($conn, $query);
}

if (isset($_POST['editPinjam'])) {
    $kode_pinjam = $_POST['kode_pinjam'];
    $nama_peminjam = $_POST['nama_peminjam'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $item = $_POST['item'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    $getPrice = "SELECT * FROM item WHERE kode_item = '$item'";
    $resGetPrice = mysqli_query($conn, $getPrice);
    foreach ($resGetPrice as $prc) {
        $price = $prc['biaya_pinjaman'];
        $nama_item = $prc['nama_item'];
    }

    $gTotal = $jumlah * $price;

    $query = "UPDATE peminjaman_header SET kode_transaksi = '$kode_pinjam', nama_peminjam = '$nama_peminjam', kode_item = '$item', nama_item = '$nama_item', jumlah_item = '$jumlah', tanggal_pinjam = '$tanggal_pinjam', tanggal_kembali = '$tanggal_kembali', biaya_total = '$gTotal', deskripsi = '$deskripsi' WHERE kode_transaksi = '$kode_pinjam'";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function hapusPinjaman($kode_item)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM peminjaman_header WHERE kode_transaksi = '$kode_item'");

    // return mysqli_affected_rows($conn);
    return ("DELETE FROM pinjaman_header WHERE kode_transaksi = '$kode_item'");
}
