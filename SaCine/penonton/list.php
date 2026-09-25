<?php
session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

try {
    $stmt = $pdo->query("SELECT * FROM penonton ORDER BY id DESC");
    $daftarPenonton = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $daftarPenonton = [];
    $error = 'Gagal mengambil data penonton: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penonton - SaCine</title>

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
                        <a class="nav-link active" href="list.php">
                            Daftar Penonton
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="tambah.php">
                            Tambah Penonton
                        </a>
                    </li>

                </ul>
            </nav>

        </div>
    </header>

    <main class="container my-4">

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        <?php endif; ?>

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

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

                    <h2 class="mb-0">
                        Daftar Penonton
                    </h2>

                    <a href="tambah.php" class="btn btn-primary">
                        + Tambah Penonton
                    </a>

                </div>

                <div class="mb-3">

                    <label for="search-input" class="form-label">
                        Cari penonton
                    </label>

                    <input
                        type="text"
                        id="search-input"
                        class="form-control"
                        placeholder="Cari nama penonton..."
                        autocomplete="off">

                </div>

                <div class="table-responsive">

                    <table
                        class="table table-striped table-bordered table-hover align-middle"
                        data-filter="penonton">

                        <thead class="table-primary">

                            <tr>
                                <th>No. Penonton</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. HP</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>
                                <?php if (empty($daftarPenonton)): ?>

                                    <tr>
                                        <td colspan="6" class="text-center">
                                            Belum ada data penonton.
                                        </td>
                                    </tr>

                                <?php else: ?>

                                    <?php foreach ($daftarPenonton as $penonton): ?>

                                        <tr>
                                            <td><?= htmlspecialchars($penonton['no_penonton']) ?></td>
                                            <td><?= htmlspecialchars($penonton['nama']) ?></td>
                                            <td><?= htmlspecialchars($penonton['alamat']) ?></td>
                                            <td><?= htmlspecialchars($penonton['no_hp']) ?></td>
                                            <td><?= htmlspecialchars($penonton['email']) ?></td>
                                            <td>
                                                <a
                                                    href="edit.php?id=<?= htmlspecialchars($penonton['id']) ?>"
                                                    class="btn btn-sm btn-warning">

                                                    Edit

                                                </a>

                                                <a
                                                    href="detail.php?id=<?= htmlspecialchars($penonton['id']) ?>"
                                                    class="btn btn-sm btn-info">

                                                    Detail

                                                </a>

                                                <a
                                                    href="proses_hapus.php?id=<?= htmlspecialchars($penonton['id']) ?>"
                                                    class="btn btn-sm btn-danger btn-hapus">

                                                    Hapus

                                                </a>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>

                                <?php endif; ?>
                            </tbody>

                    </table>

                </div>

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