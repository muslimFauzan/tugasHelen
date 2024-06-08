<?php
require 'function.php'; // Pastikan file function.php sudah di-include

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kode_item'])) {
    $kode_item = $_POST['kode_item'];

    $res = hapusPinjaman($kode_item);

    if ($res > 0) {
        echo json_encode(["status" => "success", "message" => "Item deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete item."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
