<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$id = trim($_POST['id'] ?? '');
$noPenonton = trim($_POST['no_penonton'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');
$email = trim($_POST['email'] ?? '');

$errors = [];


if ($id === '' || !is_numeric($id)) {
    $errors[] = 'ID penonton tidak valid.';
}

if ($noPenonton === '') {
    $errors[] = 'Nomor penonton wajib diisi.';
}

if ($nama === '') {
    $errors[] = 'Nama penonton wajib diisi.';
}

if ($alamat === '') {
    $errors[] = 'Alamat wajib diisi.';
}

if ($noHp === '') {
    $errors[] = 'Nomor HP wajib diisi.';
}

if ($email === '') {
    $errors[] = 'Email wajib diisi.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
}


if (!empty($errors)) {

    $_SESSION['error'] = implode(' ', $errors);

    header(
        'Location: edit.php?id=' . urlencode($id)
    );

    exit;
}


try {

    $sql = "UPDATE penonton
            SET no_penonton = :no_penonton,
                nama = :nama,
                alamat = :alamat,
                no_hp = :no_hp,
                email = :email
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':no_penonton' => $noPenonton,
        ':nama' => $nama,
        ':alamat' => $alamat,
        ':no_hp' => $noHp,
        ':email' => $email,
        ':id' => (int)$id
    ]);

    $_SESSION['success'] =
        'Data penonton berhasil diperbarui.';

    header('Location: list.php');

    exit;

} catch (PDOException $e) {

    $_SESSION['error'] =
        'Gagal memperbarui penonton: ' . $e->getMessage();

    header(
        'Location: edit.php?id=' . urlencode($id)
    );

    exit;
}

?>