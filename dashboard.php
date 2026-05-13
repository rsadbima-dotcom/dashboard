<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors',1);

/* ================= KONEKSI ================= */
$koneksi = mysqli_connect("localhost","root","","rs_dashboard");

if(!$koneksi){
    die("Koneksi gagal: ".mysqli_connect_error());
}

mysqli_set_charset($koneksi,"utf8");

/* ================= HARI ================= */
$hari = date("l");

$hari_indonesia = [
    "Sunday"=>"Minggu",
    "Monday"=>"Senin",
    "Tuesday"=>"Selasa",
    "Wednesday"=>"Rabu",
    "Thursday"=>"Kamis",
    "Friday"=>"Jumat",
    "Saturday"=>"Sabtu"
];

$hari_ini = $hari_indonesia[$hari];

/* ================= JADWAL ================= */
$jadwal = mysqli_query($koneksi,"
    SELECT * FROM jadwal_dokter
    WHERE hari_kerja='$hari_ini'
");

/* ================= PASIEN ================= */
$total_pasien = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT COUNT(*) as total FROM pasien
"))['total'];

$rajal = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT COUNT(*) as total 
    FROM pasien 
    WHERE layanan='Rajal'
"))['total'];

$ranap = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT COUNT(*) as total 
    FROM pasien 
    WHERE layanan='Ranap'
"))['total'];

/* ================= KAMAR ================= */
$total_kamar = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT COUNT(*) as total FROM kamar
"))['total'];

$kamar_kosong = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT COUNT(*) as total 
    FROM kamar 
    WHERE status='Kosong'
"))['total'];

$kamar_terisi = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT COUNT(*) as total 
    FROM kamar 
    WHERE status='Terisi'
"))['total'];

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard RS</title>

<style>

/* ================= RESET ================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

/* ================= BODY ================= */

body{
    background:#eef2f5;
    color:#333;
}

/* ================= HEADER ================= */

header{
    background:#0b8457;
    color:white;
    padding:18px;
    position:relative;
}

.header-title{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
    text-align:center;
}

.header-title img{
    width:65px;
    height:65px;
    object-fit:contain;
}

.header-text h1{
    font-size:24px;
}

.header-text p{
    margin-top:5px;
    font-size:14px;
}

/* ================= LOGIN ADMIN ================= */

.login-admin{
    position:absolute;
    top:18px;
    right:20px;
}

.login-admin a{
    background:white;
    color:#0b8457;
    text-decoration:none;
    padding:10px 18px;
    border-radius:10px;
    font-weight:bold;
    box-shadow:0 3px 8px rgba(0,0,0,0.2);
    transition:0.3s;
    display:inline-block;
}

.login-admin a:hover{
    background:#066645;
    color:white;
}

/* ================= MENU ================= */

nav{
    background:#066645;
    padding:12px;
    display:flex;
    justify-content:center;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    position:sticky;
    top:0;
    z-index:999;
}

nav a{
    color:white;
    text-decoration:none;
    padding:10px 16px;
    border-radius:8px;
    font-weight:bold;
    transition:0.3s;
}

nav a:hover{
    background:#0b8457;
}

/* ===== MENU ADMIN DI SAMPING KONTAK ===== */

.admin-menu{
    background:#ffffff;
    color:#0b8457 !important;
    border-radius:8px;
    padding:10px 16px;
    font-weight:bold;
}

.admin-menu:hover{
    background:#dff5ea !important;
    color:#066645 !important;
}

/* ================= SECTION ================= */

section{
    width:95%;
    margin:auto;
    padding:22px 0;
}

/* ================= BOX ================= */

.box{
    background:white;
    border-radius:14px;
    padding:22px;
    box-shadow:0 4px 14px rgba(0,0,0,0.1);
}

/* ================= HERO ================= */

.hero{
    background:url('wallpaper.jpg') center/cover no-repeat;
    padding:120px 20px;
    border-radius:14px;
    position:relative;
    text-align:center;
    color:white;
    overflow:hidden;
}

.hero::before{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.5);
}

.hero h2,
.hero p{
    position:relative;
    z-index:2;
}

.hero h2{
    font-size:38px;
    margin-bottom:10px;
}

/* ================= TITLE ================= */

h2{
    color:#0b8457;
    margin-bottom:15px;
}

/* ================= STAT ================= */

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
}

.stat{
    color:white;
    padding:22px;
    border-radius:12px;
    text-align:center;
    font-weight:bold;
    font-size:18px;
}

.green{
    background:#0b8457;
}

.blue{
    background:#007bff;
}

.red{
    background:#dc3545;
}

/* ================= TABLE ================= */

.table-wrap{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:600px;
}

th{
    background:#0b8457;
    color:white;
    padding:14px;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f5f5f5;
}

/* ================= LIST ================= */

ul{
    padding-left:20px;
}

ul li{
    margin-bottom:10px;
}

/* ================= KONTAK ================= */

.kontak p{
    margin-bottom:10px;
    font-size:16px;
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){

    .header-text h1{
        font-size:18px;
    }

    .hero{
        padding:80px 15px;
    }

    .hero h2{
        font-size:28px;
    }

    .login-admin{
        position:static;
        margin-top:15px;
        text-align:center;
    }

    nav{
        justify-content:center;
    }

}

@media(min-width:1600px){

    .hero h2{
        font-size:52px;
    }

    .hero p{
        font-size:24px;
    }

    .stat{
        font-size:24px;
        padding:30px;
    }

    th,td{
        font-size:20px;
    }

    nav a{
        font-size:20px;
    }

}

</style>

</head>
<body>

<!-- ================= HEADER ================= -->

<header>

<div class="login-admin">

<?php if(isset($_SESSION['login'])){ ?>

<a href="admin.php">
ADMIN
</a>

<?php } else { ?>

<a href="login.php">
LOGIN ADMIN
</a>

<?php } ?>

</div>

<div class="header-title">

<img src="udayana.png">

<div class="header-text">
<h1>RS TK.IV 09.07.05 Sultan Abdul Kahir II Bima</h1>
<p>Dashboard Rumah Sakit</p>
</div>

<img src="wirasakti.jpeg">

</div>

</header>

<!-- ================= MENU ================= -->

<nav>

<a href="#beranda">Beranda</a>
<a href="#profil">Profil</a>
<a href="#layanan">Layanan</a>
<a href="#pasien">Pasien</a>
<a href="#kamar">Kamar</a>
<a href="#jadwal">Jadwal</a>
<a href="#kontak">Kontak</a>

<?php if(isset($_SESSION['login'])){ ?>
<a href="admin.php" class="admin-menu">Admin</a>
<?php } ?>

</nav>

<!-- ================= BERANDA ================= -->

<section id="beranda">

<div class="hero">

<h2>Selamat Datang</h2>
<p>Dashboard Rumah Sakit Kami</p>

</div>

</section>

<!-- ================= PROFIL ================= -->

<section id="profil">

<div class="box">

<h2>Profil Rumah Sakit</h2>

<p>
Rumah sakit memberikan pelayanan kesehatan terbaik 
dengan tenaga medis profesional dan fasilitas lengkap.
</p>

</div>

</section>

<!-- ================= LAYANAN ================= -->

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

<!-- ================= PASIEN ================= -->

<section id="pasien">

<div class="box">

<h2>Statistik Pasien</h2>

<div class="stats">

<div class="stat green">
Total Pasien<br><br>
<?= $total_pasien ?>
</div>

<div class="stat blue">
Rawat Jalan<br><br>
<?= $rajal ?>
</div>

<div class="stat red">
Rawat Inap<br><br>
<?= $ranap ?>
</div>

</div>

</div>

</section>

<!-- ================= KAMAR ================= -->

<section id="kamar">

<div class="box">

<h2>Statistik Kamar</h2>

<div class="stats">

<div class="stat green">
Total Kamar<br><br>
<?= $total_kamar ?>
</div>

<div class="stat blue">
Kamar Kosong<br><br>
<?= $kamar_kosong ?>
</div>

<div class="stat red">
Kamar Terisi<br><br>
<?= $kamar_terisi ?>
</div>

</div>

</div>

</section>

<!-- ================= JADWAL ================= -->

<section id="jadwal">

<div class="box">

<h2>Jadwal Dokter Hari Ini (<?= $hari_ini ?>)</h2>

<div class="table-wrap">

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

</div>

</section>

<!-- ================= KONTAK ================= -->

<section id="kontak">

<div class="box kontak">

<h2>Kontak</h2>

<p>📍 Jln Jendral Sudirman No 27</p>
<p>📞 085337724002</p>
<p>✉️ rsadbima@gmail.com</p>

</div>

</section>

</body>
</html>
