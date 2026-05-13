<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

$koneksi = mysqli_connect("localhost","root","","rs_dashboard");
if(!$koneksi){
    die("Koneksi gagal: ".mysqli_connect_error());
}

mysqli_set_charset($koneksi,"utf8");

/* HARI */
$hari = date("l");

$hari_indonesia = [
    "Sunday"=>"Minggu","Monday"=>"Senin","Tuesday"=>"Selasa",
    "Wednesday"=>"Rabu","Thursday"=>"Kamis","Friday"=>"Jumat","Saturday"=>"Sabtu"
];

$hari_ini = $hari_indonesia[$hari];

/* JADWAL HARI INI */
$jadwal = mysqli_query($koneksi,"SELECT * FROM jadwal_dokter WHERE hari_kerja='$hari_ini'");

/* PASIEN */
$total_pasien = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as total FROM pasien"))['total'];
$rajal = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as total FROM pasien WHERE layanan='Rajal'"))['total'];
$ranap = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as total FROM pasien WHERE layanan='Ranap'"))['total'];

/* KAMAR */
$total_kamar = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as total FROM kamar"))['total'];
$kamar_kosong = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as total FROM kamar WHERE status='Kosong'"))['total'];
$kamar_terisi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as total FROM kamar WHERE status='Terisi'"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard RS</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* BACKGROUND */
body{
    background:#eef2f5;
}

/* HEADER */
header{
    background:#0b8457;
    color:white;
    padding:18px;
    text-align:center;
}

.header-title{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.header-title img{
    width:60px;
    height:60px;
}

header h1{
    font-size:20px;
}

/* NAV */
nav{
    background:#066645;
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:8px;
    padding:10px;
    position:sticky;
    top:0;
}

nav a{
    color:white;
    text-decoration:none;
    padding:8px 12px;
    border-radius:6px;
    font-weight:bold;
}

nav a:hover{
    background:#0b8457;
}

/* SECTION */
section{
    width:95%;
    margin:auto;
    padding:20px 0;
}

/* BOX */
.box{
    background:white;
    padding:18px;
    border-radius:12px;
    box-shadow:0 3px 12px rgba(0,0,0,0.1);
}

/* HERO */
.hero{
    background:url('wallpaper.jpg') center/cover no-repeat;
    color:white;
    padding:110px 20px;
    text-align:center;
    border-radius:12px;
    position:relative;
}

.hero::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:rgba(0,0,0,0.5);
    border-radius:12px;
}

.hero h2, .hero p{
    position:relative;
}

/* STAT */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
    gap:10px;
    margin-top:10px;
}

.stat{
    padding:14px;
    border-radius:10px;
    color:white;
    font-weight:bold;
    text-align:center;
}

/* COLORS */
.green{background:#0b8457;}
.blue{background:#007bff;}
.red{background:#dc3545;}
.orange{background:#ff9800;}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

th{
    background:#0b8457;
    color:white;
    padding:10px;
}

td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f5f5f5;
}

/* TITLE */
h2{
    margin-bottom:10px;
    color:#0b8457;
}

/* RESPONSIVE */
@media(max-width:768px){
    header h1{font-size:16px;}
    .hero{padding:80px 10px;}
}

@media(min-width:1600px){
    header h1{font-size:26px;}
    .stat{font-size:20px;padding:20px;}
    td,th{font-size:18px;}
}

</style>
</head>

<body>

<!-- HEADER -->
<header>
<div class="header-title">
    <img src="udayana.png">
    <div>
        <h1>RS TK.IV 09.07.05 Sultan Abdul Kahir II Bima</h1>
        <p>Dashboard Rumah Sakit</p>
    </div>
    <img src="wirasakti.jpeg">
</div>
</header>

<!-- MENU (TIDAK DIHILANGKAN) -->
<nav>
<a href="#beranda">Beranda</a>
<a href="#profil">Profil</a>
<a href="#layanan">Layanan</a>
<a href="#pasien">Pasien</a>
<a href="#kamar">Kamar</a>
<a href="#jadwal">Jadwal</a>
<a href="#kontak">Kontak</a>
</nav>

<!-- BERANDA -->
<section id="beranda">
<div class="hero">
    <h2>Selamat Datang</h2>
    <p>Dashboard Rumah Sakit Kami</p>
</div>
</section>

<!-- PROFIL (TETAP ADA) -->
<section id="profil">
<div class="box">
<h2>Profil Rumah Sakit</h2>
<p>Rumah sakit memberikan pelayanan kesehatan terbaik dengan tenaga medis profesional dan fasilitas lengkap.</p>
</div>
</section>

<!-- LAYANAN (TETAP ADA) -->
<section id="layanan">
<div class="box">
<h2>Layanan</h2>
<ul>
<li>UGD 24 Jam</li>
<li>Poli Umum</li>
<li>Rawat Inap</li>
<li>Laboratorium</li>
</ul>
</div>
</section>

<!-- PASIEN -->
<section id="pasien">
<div class="box">
<h2>Statistik Pasien</h2>
<div class="stats">
<div class="stat green">Total: <?= $total_pasien ?></div>
<div class="stat blue">Rajal: <?= $rajal ?></div>
<div class="stat red">Ranap: <?= $ranap ?></div>
</div>
</div>
</section>

<!-- KAMAR -->
<section id="kamar">
<div class="box">
<h2>Statistik Kamar</h2>
<div class="stats">
<div class="stat green">Total: <?= $total_kamar ?></div>
<div class="stat blue">Kosong: <?= $kamar_kosong ?></div>
<div class="stat red">Terisi: <?= $kamar_terisi ?></div>
</div>
</div>
</section>

<!-- JADWAL -->
<section id="jadwal">
<div class="box">
<h2>Jadwal Dokter Hari Ini (<?= $hari_ini ?>)</h2>

<table>
<tr>
<th>Dokter</th>
<th>Poli</th>
<th>Jam</th>
</tr>

<?php while($d=mysqli_fetch_assoc($jadwal)){ ?>
<tr>
<td><?= $d['nm_dokter'] ?></td>
<td><?= $d['nm_poli'] ?></td>
<td><?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?></td>
</tr>
<?php } ?>

</table>

</div>
</section>

<!-- KONTAK (TETAP ADA) -->
<section id="kontak">
<div class="box">
<h2>Kontak</h2>
<p>📍 Jln Jendral Sudirman No 27</p>
<p>📞 085337724002</p>
<p>✉️ rsadbima@gmail.com</p>
</div>
</section>

</body>
</html>
