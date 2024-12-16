<h1>Edit Pegawai</h1>
<form action="/pegawai/update/<?= $pegawai['id']; ?>" method="post">
    <label>Nama: <input type="text" name="name" value="<?= $pegawai['name']; ?>"></label><br>
    <label>Email: <input type="email" name="email" value="<?= $pegawai['email']; ?>"></label><br>
    <label>Jabatan: <input type="text" name="position" value="<?= $pegawai['position']; ?>"></label><br>
    <label>Gaji: <input type="number" name="salary" value="<?= $pegawai['salary']; ?>"></label><br>
    <button type="submit">Simpan</button>
</form>
