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

    $stmt = $pdo->prepare("SELECT * FROM film WHERE id = :id");

    $stmt->execute([
        ':id' => $id
    ]);

    $film = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$film) {
        $_SESSION['error'] = 'Data film tidak ditemukan.';
        header('Location: list.php');
        exit;
    }

} catch (PDOException $e) {

    $_SESSION['error'] = 'Gagal mengambil data film.';

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

    <title>Detail Film - SaCine</title>

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
                            class="nav-link active"
                            href="list.php">

                            Daftar Film

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="tambah.php">

                            Tambah Film

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="../penonton/list.php">

                            Daftar Penonton

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="../penonton/tambah.php">

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
                    Detail Film
                </h2>

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Judul Film
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($film['judul']) ?>
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Sutradara
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($film['sutradara']) ?>
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Genre
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($film['genre']) ?>
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Tahun Rilis
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($film['tahun']) ?>
                    </div>

                </div>

                <div class="row mb-4">

                    <div class="col-md-3 fw-bold">
                        Jumlah Salinan
                    </div>

                    <div class="col-md-9">
                        <?= htmlspecialchars($film['salinan']) ?>
                    </div>

                </div>

                <div class="d-flex gap-2">

                    <a
                        href="edit.php?id=<?= htmlspecialchars($film['id']) ?>"
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