<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? '';

if ($id === '' || !is_numeric($id)) {

    $_SESSION['error'] = 'ID penonton tidak valid.';

    header('Location: list.php');

    exit;
}

try {

    $stmt = $pdo->prepare(
        "DELETE FROM penonton WHERE id = :id"
    );

    $stmt->execute([
        ':id' => (int)$id
    ]);

    $_SESSION['success'] = 'Penonton berhasil dihapus.';

    header('Location: list.php');

    exit;

} catch (PDOException $e) {

    $_SESSION['error'] =
        'Penonton gagal dihapus: ' . $e->getMessage();

    header('Location: list.php');

    exit;
}

?>