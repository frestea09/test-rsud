<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
    <h2>Dashboard</h2>
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Tambah User</button>
    </form>

    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" style="background-color: red; color: white; border: none; padding: 10px 20px; cursor: pointer;">Logout</button>
    </form>

    <h3>Daftar Pengguna</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button onclick="editUser ({{ $user->id }})">Edit</button>
                                                <button onclick="generatePDF({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">Print PDF</button>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function editUser (id) {
            fetch(`/users/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.name;
                    document.getElementById('email').value = data.email;
                    document.querySelector('form').action = `/users/${id}`;
                    document.querySelector('form').method = 'POST';
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = '_method';
                    input.value = 'PUT';
                    document.querySelector('form').appendChild(input);
                });
        }
function generatePDF(id, name, email) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

   doc.setFontSize(12);
    doc.text('PEMERINTAH KABUPATEN BANDUNG', 10, 10);
    doc.setFontSize(10);
    doc.text('DINAS XYZ', 10, 15); 
    doc.text('Alamat: Jl. Contoh No. 123, Bandung', 10, 20); 
    doc.text('Telepon: (022) 1234567', 10, 25); 
    doc.line(10, 27, 200, 27); 

    doc.setFontSize(14);
    doc.text('SURAT PERINTAH', 10, 35);
    doc.setFontSize(12);
    doc.text('Nomor: 123/XYZ/2023', 10, 40); 
    doc.line(10, 42, 200, 42);
    doc.setFontSize(12);
    doc.text('Dengan ini, kami memberitahukan bahwa:', 10, 50);
    doc.text(`Nama: ${name}`, 10, 60);
    doc.text(`Email: ${email}`, 10, 65);
    doc.text(`ID Pengguna: ${id}`, 10, 70);
    doc.text('adalah pengguna yang terdaftar.', 10, 75);

    doc.setFontSize(10);
    doc.text('Bandung, ' + new Date().toLocaleDateString(), 10, 90); 
    doc.text('Kepala Dinas XYZ', 10, 95); 
    doc.text('_____________________', 10, 100);

    doc.save(`user_${id}.pdf`);
}
    </script>
</body>
</html>