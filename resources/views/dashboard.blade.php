<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
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

                    // Update form action to point to the update route
                    document.querySelector('form').action = `/users/${id}`;
                    // Change the method to PUT
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

            doc.text(`User  ID: ${id}`, 10, 10);
            doc.text(`Name: ${name}`, 10, 20);
            doc.text(`Email: ${email}`, 10, 30);

            doc.save(`user_${id}.pdf`);
        }
    </script>
</body>
</html>