<?php

$host = "aws-0-ap-southeast-1.pooler.supabase.com";
$db = "postgres";
$user = "postgres.dvttwvmjbqqulbecxdnz";
$pass = getenv("SUPABASE_DB_PASSWORD");
$port = "5432";

try {

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db;sslmode=require",
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