<?php
require 'function.php';

// Query untuk mengambil semua data dari tabel item
$dataBengkel = mysqli_query($conn, "SELECT * FROM peminjaman_header ORDER BY id");

$data = array();

// Mengambil setiap baris hasil query dan menambahkannya ke array
while ($row = mysqli_fetch_assoc($dataBengkel)) {
    $data[] = $row;
}

// Mengembalikan data dalam format JSON
echo json_encode($data);
