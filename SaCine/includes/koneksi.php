<?php

$host = "localhost";
$db = "sacine";
$user = "postgres";
$pass = "sasa123";

try {
    $pdo = new PDO(
        "pgsql:host=$host;dbname=$db",
        $user,
        $pass
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
