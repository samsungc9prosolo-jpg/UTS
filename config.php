<?php
// config.php
// Tempatkan file ini di root project dan require di setiap file lain.
// Memulai session di sini agar tersedia di seluruh halaman.
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // isi jika MySQL root punya password
$DB_NAME = 'calibration_db';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
