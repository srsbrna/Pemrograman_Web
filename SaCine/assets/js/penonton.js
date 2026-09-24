// Mengambil & menampilkan Daftar Penonton secara asinkron dari data/penonton.json

async function muatDaftarPenonton() {

    const tbody = document.querySelector(".table-responsive table tbody");

    const loading = document.getElementById("loading-indicator");

    if (!tbody) return;

    loading.style.display = "block";

    tbody.innerHTML = "";

    try {

        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/penonton.json");

        if (!res.ok) {

            throw new Error("Gagal mengambil data (status " + res.status + ")");

        }

        const daftarPenonton = await res.json();

        daftarPenonton.forEach(function (penonton) {

            const tr = document.createElement("tr");

            tr.innerHTML =
                "<td>" + penonton.no_penonton + "</td>" +
                "<td>" + penonton.nama + "</td>" +
                "<td>" + penonton.alamat + "</td>" +
                "<td>" + penonton.no_hp + "</td>" +
                "<td>" +
                "<button type=\"button\" class=\"btn btn-sm btn-warning\">Edit</button> " +
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

document.addEventListener("DOMContentLoaded", muatDaftarPenonton);