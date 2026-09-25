<?php

session_start();

require_once __DIR__ . '/includes/koneksi.php';

try {

    $jumlahFilm = $pdo
        ->query("SELECT COUNT(*) FROM film")
        ->fetchColumn();

    $jumlahPenonton = $pdo
        ->query("SELECT COUNT(*) FROM penonton")
        ->fetchColumn();

    $filmTersedia = $pdo
        ->query("SELECT COUNT(*) FROM film WHERE salinan > 0")
        ->fetchColumn();

} catch (PDOException $e) {

    $jumlahFilm = 0;
    $jumlahPenonton = 0;
    $filmTersedia = 0;

    $error = "Gagal mengambil data dari database.";

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>SaCine - Movie Management System</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- CSS Custom -->
    <link
        rel="stylesheet"
        href="assets/css/style.css">

</head>

<body>

    <!-- Navbar -->
    <header class="navbar navbar-expand-md navbar-dark bg-primary">

        <div class="container">

            <a
                class="navbar-brand fw-bold"
                href="index.php">

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
                            class="nav-link active"
                            href="index.php">

                            Beranda

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="film/list.php">

                            Daftar Film

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="film/tambah.php">

                            Tambah Film

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="penonton/list.php">

                            Daftar Penonton

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="penonton/tambah.php">

                            Tambah Penonton

                        </a>

                    </li>

                </ul>

            </nav>

        </div>

    </header>


    <!-- Main Content -->
    <main class="container my-4">

        <?php if (isset($error)): ?>

            <div
                class="alert alert-danger"
                role="alert">

                <?= htmlspecialchars($error) ?>

            </div>

        <?php endif; ?>


        <!-- Hero -->
        <section class="text-center mb-4">

            <h1 class="fw-bold">
                Selamat Datang di SaCine
            </h1>

            <p class="text-muted">
                Movie Management System
            </p>

        </section>


        <!-- Statistik -->
        <section>

            <div class="row g-4">

                <!-- Total Film -->
                <div class="col-md-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body text-center">

                            <h5 class="card-title">
                                Total Film
                            </h5>

                            <p class="display-5 fw-bold">
                                <?= htmlspecialchars($jumlahFilm) ?>
                            </p>

                            <a
                                href="film/list.php"
                                class="btn btn-primary">

                                Lihat Film

                            </a>

                        </div>

                    </div>

                </div>


                <!-- Total Penonton -->
                <div class="col-md-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body text-center">

                            <h5 class="card-title">
                                Total Penonton
                            </h5>

                            <p class="display-5 fw-bold">
                                <?= htmlspecialchars($jumlahPenonton) ?>
                            </p>

                            <a
                                href="penonton/list.php"
                                class="btn btn-primary">

                                Lihat Penonton

                            </a>

                        </div>

                    </div>

                </div>


                <!-- Film Tersedia -->
                <div class="col-md-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body text-center">

                            <h5 class="card-title">
                                Film Tersedia
                            </h5>

                            <p class="display-5 fw-bold">
                                <?= htmlspecialchars($filmTersedia) ?>
                            </p>

                            <a
                                href="film/list.php"
                                class="btn btn-primary">

                                Lihat Koleksi

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- Informasi -->
        <section class="mt-5">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h4 class="card-title">
                        Tentang SaCine
                    </h4>

                    <p class="card-text">

                        SaCine merupakan sistem informasi
                        pengelolaan film yang digunakan untuk
                        mengelola data film dan penonton.
                        Data pada sistem disimpan menggunakan
                        database PostgreSQL.

                    </p>

                </div>

            </div>

        </section>

    </main>


    <!-- Footer -->
    <footer class="text-center py-3">

        <p class="mb-0">

            &copy; 2026 SaCine — Movie Management System

        </p>

    </footer>


    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <!-- JavaScript utama -->
    <script src="assets/js/app.js"></script>

</body>

</html>