<?php 

$conn = new mysqli("localhost", "chatapp", "chatapp@db1", "chatdb");


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>
