<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$keyword = trim($_GET['keyword'] ?? '');

$perHalaman = 10;

$halaman = isset($_GET['halaman']) && is_numeric($_GET['halaman'])
    ? max(1, (int)$_GET['halaman'])
    : 1;

$offset = ($halaman - 1) * $perHalaman;

try {

    // Menghitung jumlah data
    if ($keyword !== '') {

        $stmtCount = $pdo->prepare(
            "SELECT COUNT(*)
             FROM penonton
             WHERE nama ILIKE :keyword
                OR no_penonton ILIKE :keyword"
        );

        $stmtCount->execute([
            ':keyword' => '%' . $keyword . '%'
        ]);

    } else {

        $stmtCount = $pdo->query(
            "SELECT COUNT(*) FROM penonton"
        );

    }

    $totalData = (int) $stmtCount->fetchColumn();

    // Menghitung jumlah halaman
    $totalHalaman = max(
        1,
        (int) ceil($totalData / $perHalaman)
    );

    if ($halaman > $totalHalaman) {

        $halaman = $totalHalaman;
        $offset = ($halaman - 1) * $perHalaman;

    }

    // Mengambil data penonton
    if ($keyword !== '') {

        $stmt = $pdo->prepare(
            "SELECT *
             FROM penonton
             WHERE nama ILIKE :keyword
                OR no_penonton ILIKE :keyword
             ORDER BY id DESC
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(
            ':keyword',
            '%' . $keyword . '%',
            PDO::PARAM_STR
        );

    } else {

        $stmt = $pdo->prepare(
            "SELECT *
             FROM penonton
             ORDER BY id DESC
             LIMIT :limit OFFSET :offset"
        );

    }

    $stmt->bindValue(
        ':limit',
        $perHalaman,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':offset',
        $offset,
        PDO::PARAM_INT
    );

    $stmt->execute();

    $daftarPenonton = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $daftarPenonton = [];

    $totalData = 0;

    $totalHalaman = 1;

    $error = 'Gagal mengambil data penonton: ' . $e->getMessage();

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Daftar Penonton - SaCine</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- CSS Custom -->
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

        <?php if ($success): ?>

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert">

                <?= htmlspecialchars($success) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>

        <?php if ($error): ?>

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert">

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

                <div
                    class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

                    <h2 class="mb-0">
                        Daftar Penonton
                    </h2>

                    <a
                        href="tambah.php"
                        class="btn btn-primary">

                        + Tambah Penonton

                    </a>

                </div>

                <form
                    method="get"
                    action="list.php"
                    class="mb-3">

                    <label
                        for="keyword"
                        class="form-label">
                        Cari penonton
                    </label>

                    <div class="input-group">

                        <input
                            type="text"
                            id="keyword"
                            name="keyword"
                            class="form-control"
                            placeholder="Cari nama atau nomor penonton..."
                            value="<?= htmlspecialchars($keyword) ?>"
                            autocomplete="off">

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Cari
                        </button>

                        <?php if ($keyword !== ''): ?>

                            <a
                                href="list.php"
                                class="btn btn-secondary">
                                Reset
                            </a>

                        <?php endif; ?>

                    </div>

                </form>

                <!-- Table -->
                <div class="table-responsive">
                    
                    <p class="text-secondary">
                        Menampilkan
                        <?= count($daftarPenonton) ?>
                        dari
                        <?= $totalData ?>
                        data penonton.
                    </p>

                    <table
                        class="table table-bordered table-hover" data-filter="penonton">

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
                                    <td
                                        colspan="6"
                                        class="text-center">

                                        <?php if ($keyword !== ''): ?>

                                            Penonton dengan kata kunci
                                            "<strong><?= htmlspecialchars($keyword) ?></strong>"
                                            tidak ditemukan.

                                        <?php else: ?>

                                            Belum ada data penonton.

                                        <?php endif; ?>

                                    </td>
                                </tr>

                            <?php else: ?>

                                <?php foreach ($daftarPenonton as $penonton): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars($penonton['no_penonton']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($penonton['nama']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($penonton['alamat']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($penonton['no_hp']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($penonton['email']) ?>
                                        </td>

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

                                            <form
                                                method="post"
                                                action="hapus.php"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus penonton ini?');">

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= htmlspecialchars($penonton['id']) ?>">

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                <?php if ($totalData > $perHalaman): ?>

                    <nav aria-label="Pagination">

                        <ul class="pagination justify-content-center mt-3">

                            <li
                                class="page-item <?= $halaman <= 1 ? 'disabled' : '' ?>">

                                <a
                                    class="page-link"
                                    href="?halaman=<?= $halaman - 1 ?>&keyword=<?= urlencode($keyword) ?>"

                                    Sebelumnya

                                </a>

                            </li>

                            <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>

                                <li
                                    class="page-item <?= $i === $halaman ? 'active' : '' ?>">

                                    <a
                                        class="page-link"
                                        href="?halaman=<?= $i ?>&keyword=<?= urlencode($keyword) ?>"

                                        <?= $i ?>

                                    </a>

                                </li>

                            <?php endfor; ?>

                            <li
                                class="page-item <?= $halaman >= $totalHalaman ? 'disabled' : '' ?>">

                                <a
                                    class="page-link"
                                    href="?halaman=<?= $halaman + 1 ?>&keyword=<?= urlencode($keyword) ?>"

                                    Berikutnya

                                </a>

                            </li>

                        </ul>

                    </nav>

                <?php endif; ?>

            </div>

        </div>

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
    <script src="../assets/js/app.js"></script>

</body>

</html>
