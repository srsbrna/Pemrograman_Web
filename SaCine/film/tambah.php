<?php
session_start();

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Film - SaCine</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">

            <a class="navbar-brand fw-bold" href="../index.php">
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
                        <a class="nav-link" href="../index.php">
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="list.php">
                            Daftar Film
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="tambah.php">
                            Tambah Film
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../penonton/list.php">
                            Daftar Penonton
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../penonton/tambah.php">
                            Tambah Penonton
                        </a>
                    </li>

                </ul>
            </nav>

        </div>
    </header>

    <main class="container my-4">

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm form-card">

            <div class="card-body">

                <h2 class="text-center mb-4">
                    Tambah Film
                </h2>

                <form
                    id="form-tambah"
                    class="form-tambah"
                    method="post"
                    action="proses_tambah.php"
                    novalidate>

                    <div class="mb-3">

                        <label for="judul" class="form-label">
                            Judul Film
                        </label>

                        <input
                            type="text"
                            id="judul"
                            name="judul"
                            class="form-control"
                            placeholder="Masukkan judul film">

                    </div>

                    <div class="mb-3">

                        <label for="sutradara" class="form-label">
                            Sutradara
                        </label>

                        <input
                            type="text"
                            id="sutradara"
                            name="sutradara"
                            class="form-control"
                            placeholder="Masukkan nama sutradara">

                    </div>

                    <div class="mb-3">

                        <label for="genre" class="form-label">
                            Genre
                        </label>

                        <select
                            id="genre"
                            name="genre"
                            class="form-select">

                            <option value="">
                                -- Pilih Genre --
                            </option>

                            <option value="Action">
                                Action
                            </option>

                            <option value="Comedy">
                                Comedy
                            </option>

                            <option value="Drama">
                                Drama
                            </option>

                            <option value="Horror">
                                Horror
                            </option>

                            <option value="Romance">
                                Romance
                            </option>

                            <option value="Thriller">
                                Thriller
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label for="tahun" class="form-label">
                            Tahun Rilis
                        </label>

                        <input
                            type="number"
                            id="tahun"
                            name="tahun"
                            class="form-control"
                            min="1900"
                            max="2026"
                            placeholder="Contoh: 2024">

                    </div>

                    <div class="mb-3">

                        <label for="durasi" class="form-label">
                            Durasi (menit)
                        </label>

                        <input
                            type="number"
                            id="durasi"
                            name="durasi"
                            class="form-control"
                            min="1"
                            placeholder="Contoh: 120">

                    </div>

                    <div class="mb-3">

                        <label for="salinan" class="form-label">
                            Jumlah Salinan
                        </label>

                        <input
                            type="number"
                            id="salinan"
                            name="salinan"
                            class="form-control"
                            min="0"
                            placeholder="Contoh: 3">

                    </div>

                    <div class="form-buttons">

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Simpan
                        </button>

                        <a
                            href="list.php"
                            class="btn btn-secondary">
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </main>

    <footer class="text-center py-3">

        <p class="mb-0">
            &copy; 2026 SaCine — Movie Management System
        </p>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/app.js"></script>

</body>

</html>