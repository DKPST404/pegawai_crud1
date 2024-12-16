<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
</head>
<body>
<h1>Daftar Pegawai</h1>
<a href="/pegawai/create">Tambah Pegawai</a>
<table border="1">
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Jabatan</th>
        <th>Gaji</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($pegawai as $p): ?>
        <tr>
            <td><?= $p['name']; ?></td>
            <td><?= $p['email']; ?></td>
            <td><?= $p['position']; ?></td>
            <td><?= $p['salary']; ?></td>
            <td>
                <a href="/pegawai/edit/<?= $p['id']; ?>">Edit</a>
                <form action="/pegawai/delete/<?= $p['id']; ?>" method="post" style="display:inline;">
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
