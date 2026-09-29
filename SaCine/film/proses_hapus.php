<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? '';

if ($id === '' || !is_numeric($id)) {

    $_SESSION['error'] = 'ID film tidak valid.';

    header('Location: list.php');

    exit;
}

try {

    $stmt = $pdo->prepare(
        "DELETE FROM film WHERE id = :id"
    );

    $stmt->execute([
        ':id' => (int)$id
    ]);

    $_SESSION['success'] = 'Film berhasil dihapus.';

    header('Location: list.php');

    exit;

} catch (PDOException $e) {

    $_SESSION['error'] =
        'Film gagal dihapus: ' . $e->getMessage();

    header('Location: list.php');

    exit;
}

?>