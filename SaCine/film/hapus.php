<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? '';

if ($id === '' || !is_numeric($id)) {
    $_SESSION['error'] = 'ID film tidak valid.';
    header('Location: list.php');
    exit;
}

try {

    $sql = "DELETE FROM film WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => (int)$id
    ]);

    $_SESSION['success'] = 'Film berhasil dihapus.';

    header('Location: list.php');
    exit;

} catch (PDOException $e) {

    $_SESSION['error'] = 'Gagal menghapus film: ' . $e->getMessage();

    header('Location: list.php');
    exit;
}
?>