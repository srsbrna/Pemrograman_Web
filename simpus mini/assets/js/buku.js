// Mengambil & menampilkan Daftar Buku secara asinkron dari data/buku.json
async function muatDaftarBuku() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // Simulasi delay jaringan agar loading indicator terlihat.
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/buku.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        const daftarBuku = await res.json();

        daftarBuku.forEach(function (buku) {
            const tr = document.createElement("tr");
            const badgeClass = buku.stok > 0 ? "bg-success" : "bg-danger";

            tr.innerHTML =
                "<td>" + buku.judul + "</td>" +
                "<td>" + buku.pengarang + "</td>" +
                "<td>" + buku.tahun + "</td>" +
                "<td><span class=\"badge " + badgeClass + "\">" + buku.stok + "</span></td>" +
                "<td>" +
                "<button type=\"button\" class=\"btn btn-sm btn-warning\">Edit</button> " +
                "<button type=\"button\" class=\"btn btn-sm btn-info\">Detail</button> " +
                "<button type=\"button\" class=\"btn btn-sm btn-danger btn-hapus\">Hapus</button>" +
                "</td>";

            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarBuku);
