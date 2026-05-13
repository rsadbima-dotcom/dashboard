<?php
include "koneksi.php";

$query = mysqli_query($koneksi,"
SELECT
    dokter.nm_dokter,
    poliklinik.nm_poli,
    jadwal.hari_kerja,
    jadwal.jam_mulai,
    jadwal.jam_selesai
FROM jadwal
JOIN dokter 
    ON jadwal.kd_dokter=dokter.kd_dokter
JOIN poliklinik 
    ON jadwal.kd_poli=poliklinik.kd_poli
WHERE dokter.status='1'
ORDER BY dokter.nm_dokter ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Jadwal Dokter</title>

<style>

body{
    font-family:Arial;
    background:#eef2f7;
    padding:20px;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
}

th{
    background:#198754;
    color:white;
    padding:12px;
}

td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

</style>

</head>
<body>

<h2>Jadwal Dokter Realtime SIMRS Khanza</h2>

<table>

<tr>
    <th>Dokter</th>
    <th>Poli</th>
    <th>Hari</th>
    <th>Jam Mulai</th>
    <th>Jam Selesai</th>
</tr>

<?php while($d=mysqli_fetch_assoc($query)){ ?>

<tr>
    <td><?= $d['nm_dokter']; ?></td>
    <td><?= $d['nm_poli']; ?></td>
    <td><?= $d['hari_kerja']; ?></td>
    <td><?= $d['jam_mulai']; ?></td>
    <td><?= $d['jam_selesai']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>
