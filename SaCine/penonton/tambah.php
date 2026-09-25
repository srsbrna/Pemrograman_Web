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
    <title>Tambah Penonton - SaCine</title>

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
                        <a class="nav-link" href="../film/list.php">
                            Daftar Film
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../film/tambah.php">
                            Tambah Film
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="list.php">
                            Daftar Penonton
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="tambah.php">
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
                    Tambah Penonton
                </h2>

                <form
                    id="form-tambah"
                    class="form-tambah"
                    method="post"
                    action="proses_tambah.php"
                    novalidate>

                    <div class="mb-3">

                        <label for="no_penonton" class="form-label">
                            Nomor Penonton
                        </label>

                        <input
                            type="text"
                            id="no_penonton"
                            name="no_penonton"
                            class="form-control"
                            placeholder="Contoh: P001">

                    </div>

                    <div class="mb-3">

                        <label for="nama" class="form-label">
                            Nama Penonton
                        </label>

                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="form-control"
                            placeholder="Masukkan nama penonton">

                    </div>

                    <div class="mb-3">

                        <label for="alamat" class="form-label">
                            Alamat
                        </label>

                        <textarea
                            id="alamat"
                            name="alamat"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan alamat penonton"></textarea>

                    </div>

                    <div class="mb-3">

                        <label for="no_hp" class="form-label">
                            Nomor HP
                        </label>

                        <input
                            type="text"
                            id="no_hp"
                            name="no_hp"
                            class="form-control"
                            placeholder="Contoh: 081234567890">

                    </div>

                    <div class="mb-3">

                        <label for="email" class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="Contoh: nama@email.com">

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