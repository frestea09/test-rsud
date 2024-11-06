// public/js/dashboard.js

function editUser(id) {
    fetch(`/users/${id}/edit`)
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("name").value = data.name;
            document.getElementById("email").value = data.email;
            document.querySelector("form").action = `/users/${id}`;
            document.querySelector("form").method = "POST";
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "_method";
            input.value = "PUT";
            document.querySelector("form").appendChild(input);
        });
}

function generatePDF(id, name, email) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(12);
    doc.text("PEMERINTAH KABUPATEN BANDUNG", 10, 10);
    doc.setFontSize(10);
    doc.text("DINAS XYZ", 10, 15); // Ganti dengan nama dinas yang sesuai
    doc.text("Alamat: Jl. Contoh No. 123, Bandung", 10, 20); // Ganti dengan alamat yang sesuai
    doc.text("Telepon: (022) 1234567", 10, 25); // Ganti dengan nomor telepon yang sesuai
    doc.line(10, 27, 200, 27); // Garis horizontal

    doc.setFontSize(14);
    doc.text("SURAT PERINTAH", 10, 35);
    doc.setFontSize(12);
    doc.text("Nomor: 123/XYZ/2023", 10, 40); // Ganti dengan nomor surat yang sesuai
    doc.line(10, 42, 200, 42); // Garis horizontal

    doc.setFontSize(12);
    doc.text("Dengan ini, kami memberitahukan bahwa:", 10, 50);
    doc.text(`Nama: ${name}`, 10, 60);
    doc.text(`Email: ${email}`, 10, 65);
    doc.text(`ID Pengguna: ${id}`, 10, 70);
    doc.text("adalah pengguna yang terdaftar.", 10, 75);

    doc.setFontSize(10);
    doc.text("Bandung, " + new Date().toLocaleDateString(), 10, 90); // Tanggal saat ini
    doc.text("Kepala Dinas XYZ", 10, 95); // Ganti dengan nama kepala dinas
    doc.text("_____________________", 10, 100); // Garis untuk tanda tangan

    // Menyimpan PDF
    doc.save(`user_${id}.pdf`);
}
