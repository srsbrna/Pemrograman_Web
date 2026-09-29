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
        "SELECT * FROM penonton WHERE id = :id"
    );

    $stmt->execute([
        ':id' => $id
    ]);

    $penonton = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penonton) {

        $_SESSION['error'] = 'Data penonton tidak ditemukan.';

        header('Location: list.php');

        exit;
    }

} catch (PDOException $e) {

    $_SESSION['error'] = 'Gagal mengambil data penonton.';

    header('Location: list.php');

    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Detail Penonton - SaCine</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="../assets/css/style.css">

</head>

<body>

    <!-- Navbar -->
    <header class="navbar navbar-expand-md navbar-dark bg-primary">

        <div class="container">

            <a
                class="navbar-brand fw-bold"
                href="../index.php">

                SaCine

            </a>

            <button
                class="navbar-toggler"
                type="button"
                id="nav-toggle-btn"
                aria-controls="navMenu"
                aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <nav id="navMenu">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="../index.php">

                            Beranda

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="../film/list.php">

                            Daftar Film

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="../film/tambah.php">

                            Tambah Film

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link active"
                            href="list.php">

                            Daftar Penonton

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="tambah.php">

                            Tambah Penonton

                        </a>

                    </li>

                </ul>

            </nav>

        </div>

    </header>


    <!-- Main Content -->
    <main class="container my-4">

        <div class="card shadow-sm">

            <div class="card-body">

                <h2 class="mb-4">
                    Detail Penonton
                </h2>


                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        No. Penonton
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($penonton['no_penonton']) ?>
                    </div>

                </div>


                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Nama
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($penonton['nama']) ?>
                    </div>

                </div>


                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Alamat
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($penonton['alamat']) ?>
                    </div>

                </div>


                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        No. HP
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($penonton['no_hp']) ?>
                    </div>

                </div>


                <div class="row mb-4">

                    <div class="col-md-3 fw-bold">
                        Email
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($penonton['email']) ?>
                    </div>

                </div>


                <div class="d-flex gap-2">

                    <a
                        href="edit.php?id=<?= htmlspecialchars($penonton['id']) ?>"
                        class="btn btn-warning">

                        Edit

                    </a>

                    <a
                        href="list.php"
                        class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </div>

        </div>

    </main>


    <!-- Footer -->
    <footer class="text-center py-3">

        <p class="mb-0">
            &copy; 2026 SaCine — Movie Management System
        </p>

    </footer>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <script src="../assets/js/app.js"></script>

</body>

</html>