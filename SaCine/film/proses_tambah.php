<?php
session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$judul = trim($_POST['judul'] ?? '');
$sutradara = trim($_POST['sutradara'] ?? '');
$genre = trim($_POST['genre'] ?? '');
$tahun = trim($_POST['tahun'] ?? '');
$salinan = trim($_POST['salinan'] ?? '');

$errors = [];

if ($judul === '') {
    $errors[] = 'Judul film wajib diisi.';
}

if ($sutradara === '') {
    $errors[] = 'Sutradara wajib diisi.';
}

if ($genre === '') {
    $errors[] = 'Genre wajib dipilih.';
}

if ($tahun === '' || !is_numeric($tahun)) {
    $errors[] = 'Tahun rilis harus berupa angka.';
} elseif ((int)$tahun < 1900 || (int)$tahun > 2026) {
    $errors[] = 'Tahun rilis harus berada di antara 1900-2026.';
}

if ($salinan === '' || !is_numeric($salinan)) {
    $errors[] = 'Jumlah salinan harus berupa angka.';
} elseif ((int)$salinan < 0) {
    $errors[] = 'Jumlah salinan tidak boleh negatif.';
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    header('Location: tambah.php');
    exit;
}

try {
    $sql = "INSERT INTO film
            (judul, sutradara, genre, tahun, salinan)
            VALUES
            (:judul, :sutradara, :genre, :tahun, :salinan)
            RETURNING id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':judul' => $judul,
        ':sutradara' => $sutradara,
        ':genre' => $genre,
        ':tahun' => (int)$tahun,
        ':salinan' => (int)$salinan
    ]);

    $idFilm = $stmt->fetchColumn();

    $_SESSION['success'] = 'Film berhasil ditambahkan. ID Film: ' . $idFilm;

    header('Location: list.php');
    exit;

} catch (PDOException $e) {

    $_SESSION['error'] = 'Gagal menyimpan film: ' . $e->getMessage();

    header('Location: tambah.php');
    exit;
}
?>