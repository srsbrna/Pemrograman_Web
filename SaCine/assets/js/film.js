// Memuat data film dari JSON
async function muatDaftarFilm() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");

    if (!tbody) return;

    if (loading) {
        loading.style.display = "block";
    }

    tbody.innerHTML = "";

    try {
        await new Promise(function (resolve) {
            setTimeout(resolve, 600);
        });

        const response = await fetch("../data/film.json");

        if (!response.ok) {
            throw new Error(
                "Gagal mengambil data (status " + response.status + ")"
            );
        }

        const daftarFilm = await response.json();

        if (!Array.isArray(daftarFilm) || daftarFilm.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada data film.
                    </td>
                </tr>
            `;
            return;
        }

        daftarFilm.forEach(function (film) {
            const tr = document.createElement("tr");

            const badgeClass =
                film.salinan > 0 ? "bg-success" : "bg-danger";

            tr.innerHTML =
                "<td>" + film.judul + "</td>" +
                "<td>" + film.sutradara + "</td>" +
                "<td>" + film.genre + "</td>" +
                "<td>" + film.tahun + "</td>" +
                "<td>" +
                "<span class=\"badge " + badgeClass + "\">" +
                film.salinan +
                "</span>" +
                "</td>" +
                "<td>" +
                "<button type=\"button\" class=\"btn btn-sm btn-warning\">" +
                "Edit" +
                "</button> " +
                "<button type=\"button\" class=\"btn btn-sm btn-info\">" +
                "Detail" +
                "</button> " +
                "<button type=\"button\" class=\"btn btn-sm btn-danger btn-hapus\">" +
                "Hapus" +
                "</button>" +
                "</td>";

            tbody.appendChild(tr);
        });

    } catch (error) {

        tbody.innerHTML =
            "<tr>" +
            "<td colspan=\"6\" class=\"text-center text-danger\">" +
            "Gagal memuat data: " +
            error.message +
            "</td>" +
            "</tr>";

    } finally {

        if (loading) {
            loading.style.display = "none";
        }

    }
}

document.addEventListener(
    "DOMContentLoaded",
    muatDaftarFilm
);