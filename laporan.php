<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

include "koneksi.php";
?>
<?php
include "koneksi.php";

$bulan = date('m');

$data = mysqli_query($koneksi,"
SELECT * FROM pasien
WHERE MONTH(tanggal)='$bulan'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Laporan Bulanan</title>

<style>

body{
    font-family:Arial;
}

h2{
    text-align:center;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,table td{
    border:1px solid black;
    padding:10px;
}

table th{
    background:green;
    color:white;
}

</style>

</head>
<body>

<h2>LAPORAN PASIEN BULAN INI</h2>

<table>

<tr>
<th>No</th>
<th>No RM</th>
<th>Nama</th>
<th>Layanan</th>
<th>Poli</th>
<th>Dokter</th>
<th>Tanggal</th>
</tr>

<?php
$no=1;
while($d=mysqli_fetch_assoc($data)){
?>

<tr>
<td><?= $no++ ?></td>
<td><?= $d['no_rm'] ?></td>
<td><?= $d['nama'] ?></td>
<td><?= $d['layanan'] ?></td>
<td><?= $d['poli'] ?></td>
<td><?= $d['dokter'] ?></td>
<td><?= $d['tanggal'] ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>
