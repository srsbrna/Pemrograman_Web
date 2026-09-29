<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

/* Pencarian server-side */
$keyword = trim($_GET['keyword'] ?? '');

/* Pagination */
$perHalaman = 10;
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;

if ($halaman < 1) {
    $halaman = 1;
}

$offset = ($halaman - 1) * $perHalaman;

try {

    /* Menghitung jumlah data */
    if ($keyword !== '') {

        $stmtCount = $pdo->prepare(
            "SELECT COUNT(*)
             FROM film
             WHERE judul ILIKE :keyword"
        );

        $stmtCount->execute([
            ':keyword' => '%' . $keyword . '%'
        ]);

    } else {

        $stmtCount = $pdo->query(
            "SELECT COUNT(*) FROM film"
        );

    }

    $totalData = (int) $stmtCount->fetchColumn();

    /* Menghitung jumlah halaman */
    $totalHalaman = max(
        1,
        (int) ceil($totalData / $perHalaman)
    );

    if ($halaman > $totalHalaman) {
        $halaman = $totalHalaman;
        $offset = ($halaman - 1) * $perHalaman;
    }

    /* Mengambil data film */
    if ($keyword !== '') {

        $stmt = $pdo->prepare(
            "SELECT *
             FROM film
             WHERE judul ILIKE :keyword
             ORDER BY id DESC
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(
            ':keyword',
            '%' . $keyword . '%',
            PDO::PARAM_STR
        );

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

    } else {

        $stmt = $pdo->prepare(
            "SELECT *
             FROM film
             ORDER BY id DESC
             LIMIT :limit OFFSET :offset"
        );

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

    }

    $daftarFilm = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $daftarFilm = [];
    $totalData = 0;
    $totalHalaman = 1;

    $error = 'Gagal mengambil data film: ' . $e->getMessage();

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Daftar Film - SaCine</title>

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

                        Daftar Film

                    </h2>

                    <a
                        href="tambah.php"
                        class="btn btn-primary">

                        + Tambah Film

                    </a>

                </div>


                <!-- Pencarian server-side -->

                <form
                    method="get"
                    action="list.php"
                    class="mb-3">

                    <label
                        for="keyword"
                        class="form-label">

                        Cari film

                    </label>

                    <div class="input-group">

                        <input
                            type="text"
                            id="keyword"
                            name="keyword"
                            class="form-control"
                            placeholder="Cari judul film..."
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


                <!-- Informasi jumlah data -->

                <p class="text-secondary">

                    Menampilkan
                    <?= count($daftarFilm) ?>
                    dari
                    <?= $totalData ?>
                    data film.

                </p>


                <!-- Table -->

                <div class="table-responsive">

                    <table
                        class="table table-striped table-bordered table-hover align-middle">

                        <thead class="table-primary">

                            <tr>

                                <th>Judul</th>

                                <th>Sutradara</th>

                                <th>Genre</th>

                                <th>Tahun</th>

                                <th>Salinan</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (empty($daftarFilm)): ?>

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center">

                                        <?php if ($keyword !== ''): ?>

                                            Film dengan judul
                                            "<strong><?= htmlspecialchars($keyword) ?></strong>"
                                            tidak ditemukan.

                                        <?php else: ?>

                                            Belum ada data film.

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php else: ?>

                                <?php foreach ($daftarFilm as $film): ?>

                                    <tr>

                                        <td>

                                            <?= htmlspecialchars($film['judul']) ?>

                                        </td>

                                        <td>

                                            <?= htmlspecialchars($film['sutradara']) ?>

                                        </td>

                                        <td>

                                            <?= htmlspecialchars($film['genre']) ?>

                                        </td>

                                        <td>

                                            <?= htmlspecialchars($film['tahun']) ?>

                                        </td>

                                        <td>

                                            <?= htmlspecialchars($film['salinan']) ?>

                                        </td>

                                        <td>

                                            <a
                                                href="edit.php?id=<?= htmlspecialchars($film['id']) ?>"
                                                class="btn btn-sm btn-warning">

                                                Edit

                                            </a>

                                            <a
                                                href="detail.php?id=<?= htmlspecialchars($film['id']) ?>"
                                                class="btn btn-sm btn-info">

                                                Detail

                                            </a>

                                            <!-- Delete menggunakan POST -->

                                            <form
                                                method="post"
                                                action="hapus.php"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus film ini?');">

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= htmlspecialchars($film['id']) ?>">

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

                    <nav aria-label="Pagination film">

                        <ul class="pagination justify-content-center mt-4">

                            <!-- Sebelumnya -->

                            <li
                                class="page-item <?= $halaman <= 1 ? 'disabled' : '' ?>">

                                <?php if ($halaman > 1): ?>

                                    <a
                                        class="page-link"
                                        href="?halaman=<?= $halaman - 1 ?>&keyword=<?= urlencode($keyword) ?>">

                                        Sebelumnya

                                    </a>

                                <?php else: ?>

                                    <span class="page-link">
                                        Sebelumnya
                                    </span>

                                <?php endif; ?>

                            </li>


                            <!-- Nomor halaman -->

                            <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>

                                <li
                                    class="page-item <?= $i === $halaman ? 'active' : '' ?>">

                                    <a
                                        class="page-link"
                                        href="?halaman=<?= $i ?>&keyword=<?= urlencode($keyword) ?>">

                                        <?= $i ?>

                                    </a>

                                </li>

                            <?php endfor; ?>


                            <!-- Berikutnya -->

                            <li
                                class="page-item <?= $halaman >= $totalHalaman ? 'disabled' : '' ?>">

                                <?php if ($halaman < $totalHalaman): ?>

                                    <a
                                        class="page-link"
                                        href="?halaman=<?= $halaman + 1 ?>&keyword=<?= urlencode($keyword) ?>">

                                        Berikutnya

                                    </a>

                                <?php else: ?>

                                    <span class="page-link">
                                        Berikutnya
                                    </span>

                                <?php endif; ?>

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