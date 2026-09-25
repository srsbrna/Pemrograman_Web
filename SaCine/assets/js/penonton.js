// Memuat data penonton dari JSON
async function muatDaftarPenonton() {
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

        const response = await fetch("../data/penonton.json");

        if (!response.ok) {
            throw new Error(
                "Gagal mengambil data (status " + response.status + ")"
            );
        }

        const daftarPenonton = await response.json();

        if (!Array.isArray(daftarPenonton) || daftarPenonton.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada data penonton.
                    </td>
                </tr>
            `;
            return;
        }

        daftarPenonton.forEach(function (penonton) {
            const tr = document.createElement("tr");

            tr.innerHTML =
                "<td>" + penonton.no_penonton + "</td>" +
                "<td>" + penonton.nama + "</td>" +
                "<td>" + penonton.alamat + "</td>" +
                "<td>" + penonton.no_hp + "</td>" +
                "<td>" + penonton.email + "</td>" +
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
    muatDaftarPenonton
);