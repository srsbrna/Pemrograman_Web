<?php
session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$no_penonton = trim($_POST['no_penonton'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$email = trim($_POST['email'] ?? '');

$errors = [];

if ($nama === '') {
    $errors[] = 'Nama penonton wajib diisi.';
}

if ($no_penonton === '') {
    $errors[] = 'Nomor penonton wajib diisi.';
}

if ($alamat === '') {
    $errors[] = 'Alamat wajib diisi.';
}

if ($no_hp === '') {
    $errors[] = 'Nomor HP wajib diisi.';
}

if ($email === '') {
    $errors[] = 'Email wajib diisi.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    header('Location: tambah.php');
    exit;
}

try {
    $sql = "INSERT INTO penonton
            (nama, no_penonton, alamat, no_hp, email)
            VALUES
            (:nama, :no_penonton, :alamat, :no_hp, :email)
            RETURNING id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nama' => $nama,
        ':no_penonton' => $no_penonton,
        ':alamat' => $alamat,
        ':no_hp' => $no_hp,
        ':email' => $email
    ]);

    $idPenonton = $stmt->fetchColumn();

    $_SESSION['success'] =
        'Data penonton berhasil ditambahkan. ID Penonton: ' . $idPenonton;

    header('Location: list.php');
    exit;

} catch (PDOException $e) {

    $_SESSION['error'] =
        'Gagal menyimpan penonton: ' . $e->getMessage();

    header('Location: tambah.php');
    exit;
}
?>