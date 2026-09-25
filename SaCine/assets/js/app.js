// Hamburger menu
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.getElementById("navMenu");

    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");

        const terbuka = nav.classList.contains("nav-open");
        toggleBtn.setAttribute("aria-expanded", terbuka);
    });
}

// Konfirmasi hapus
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");

        if (!btn) return;

        const row = btn.closest("tr");

        const nama = row
            ? row.querySelector("td")?.textContent.trim()
            : "data ini";

        const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');

        if (yakin && row) {
            row.remove();
        }
    });
}

// Filter tabel
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");

    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase().trim();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            const cells = row.querySelectorAll("td");

            if (cells.length === 0) return;

            let teks = row.textContent;

            if (table.dataset.filter === "film") {
                teks = cells[0].textContent;
            }

            if (table.dataset.filter === "penonton") {
                teks = cells[1].textContent;
            }

            row.style.display =
                teks.toLowerCase().includes(keyword) ? "" : "none";
        });
    });
}

// Tampilkan error
function tampilkanError(input, pesan) {
    hapusError(input);

    const span = document.createElement("span");

    span.classList.add("error");
    span.textContent = pesan;

    input.insertAdjacentElement("afterend", span);
}

// Hapus error
function hapusError(input) {
    const next = input.nextElementSibling;

    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

// Cek input wajib
function cekWajib(form, selector, pesan) {
    const input = form.querySelector(selector);

    if (!input) return true;

    if (input.value.trim() === "") {
        tampilkanError(input, pesan);
        return false;
    }

    hapusError(input);
    return true;
}

// Validasi form
function initValidasiForm() {
    const form = document.getElementById("form-tambah");

    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        if (!cekWajib(
            form,
            "[name='judul']",
            "Judul film wajib diisi."
        )) valid = false;

        if (!cekWajib(
            form,
            "[name='sutradara']",
            "Sutradara wajib diisi."
        )) valid = false;

        if (!cekWajib(
            form,
            "[name='nama']",
            "Nama penonton wajib diisi."
        )) valid = false;

        if (!cekWajib(
            form,
            "[name='no_penonton']",
            "Nomor penonton wajib diisi."
        )) valid = false;

        if (!cekWajib(
            form,
            "[name='alamat']",
            "Alamat wajib diisi."
        )) valid = false;

        if (!cekWajib(
            form,
            "[name='no_hp']",
            "Nomor HP wajib diisi."
        )) valid = false;

        if (!cekWajib(
            form,
            "[name='email']",
            "Email wajib diisi."
        )) valid = false;

        const tahun = form.querySelector("[name='tahun']");

        if (tahun) {
            const nilai = parseInt(tahun.value, 10);

            if (
                tahun.value.trim() === "" ||
                isNaN(nilai) ||
                nilai < 1900 ||
                nilai > 2026
            ) {
                tampilkanError(
                    tahun,
                    "Tahun harus di antara 1900-2026."
                );

                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        const salinan = form.querySelector("[name='salinan']");

        if (salinan) {
            const nilai = parseInt(salinan.value, 10);

            if (
                salinan.value.trim() === "" ||
                isNaN(nilai) ||
                nilai < 0
            ) {
                tampilkanError(
                    salinan,
                    "Jumlah salinan wajib diisi dan tidak boleh negatif."
                );

                valid = false;
            } else {
                hapusError(salinan);
            }
        }

        const genre = form.querySelector("[name='genre']");

        if (genre && genre.value === "") {
            tampilkanError(
                genre,
                "Genre wajib dipilih."
            );

            valid = false;
        } else if (genre) {
            hapusError(genre);
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});