<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

/* ================= KONEKSI ================= */

$koneksi = mysqli_connect("localhost","root","","rs_dashboard");

if(!$koneksi){
    die("Koneksi gagal : ".mysqli_connect_error());
}

mysqli_set_charset($koneksi,"utf8");

/* ================= HAPUS ================= */

if(isset($_GET['hapus'])){

    $id = intval($_GET['hapus']);

    mysqli_query($koneksi,"
        DELETE FROM jadwal_dokter
        WHERE id='$id'
    ");

    echo "
    <script>
        alert('Data dokter berhasil dihapus');
        location='input_dokter.php';
    </script>";
}

/* ================= EDIT ================= */

$edit = null;

if(isset($_GET['edit'])){

    $id = intval($_GET['edit']);

    $edit = mysqli_fetch_assoc(mysqli_query($koneksi,"
        SELECT * FROM jadwal_dokter
        WHERE id='$id'
    "));
}

/* ================= UPDATE ================= */

if(isset($_POST['update'])){

    $id          = intval($_POST['id']);
    $nm_dokter   = mysqli_real_escape_string($koneksi,$_POST['nm_dokter']);
    $nm_poli     = mysqli_real_escape_string($koneksi,$_POST['nm_poli']);
    $hari_kerja  = mysqli_real_escape_string($koneksi,$_POST['hari_kerja']);
    $jam_mulai   = mysqli_real_escape_string($koneksi,$_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($koneksi,$_POST['jam_selesai']);

    mysqli_query($koneksi,"
        UPDATE jadwal_dokter SET
        nm_dokter='$nm_dokter',
        nm_poli='$nm_poli',
        hari_kerja='$hari_kerja',
        jam_mulai='$jam_mulai',
        jam_selesai='$jam_selesai'
        WHERE id='$id'
    ");

    echo "
    <script>
        alert('Data dokter berhasil diupdate');
        location='input_dokter.php';
    </script>";
}

/* ================= SIMPAN ================= */

if(isset($_POST['simpan'])){

    $nm_dokter   = mysqli_real_escape_string($koneksi,$_POST['nm_dokter']);
    $nm_poli     = mysqli_real_escape_string($koneksi,$_POST['nm_poli']);
    $hari_kerja  = mysqli_real_escape_string($koneksi,$_POST['hari_kerja']);
    $jam_mulai   = mysqli_real_escape_string($koneksi,$_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($koneksi,$_POST['jam_selesai']);

    mysqli_query($koneksi,"
        INSERT INTO jadwal_dokter
        (
            nm_dokter,
            nm_poli,
            hari_kerja,
            jam_mulai,
            jam_selesai
        )
        VALUES
        (
            '$nm_dokter',
            '$nm_poli',
            '$hari_kerja',
            '$jam_mulai',
            '$jam_selesai'
        )
    ");

    echo "
    <script>
        alert('Data dokter berhasil disimpan');
        location='input_dokter.php';
    </script>";
}

/* ================= DATA ================= */

$data = mysqli_query($koneksi,"
    SELECT * FROM jadwal_dokter
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Input Dokter</title>

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

    background:
    linear-gradient(
        rgba(11,132,87,0.92),
        rgba(6,102,69,0.92)
    ),
    url('wallpaper.jpg');

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    min-height:100vh;
    padding:20px;
}

/* ================= CONTAINER ================= */

.container{
    max-width:1400px;
    margin:auto;
}

/* ================= HEADER ================= */

.header{

    background:white;
    border-radius:20px;
    padding:20px;

    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;

    margin-bottom:20px;

    box-shadow:0 5px 20px rgba(0,0,0,0.15);
}

.logo{
    width:80px;
    height:80px;
    object-fit:contain;
}

.title{
    text-align:center;
    flex:1;
}

.title h1{
    color:#0b8457;
    font-size:32px;
    margin-bottom:5px;
}

.title p{
    color:#555;
    font-size:16px;
}

/* ================= CARD ================= */

.card{

    background:white;
    border-radius:20px;
    padding:25px;
    margin-bottom:20px;

    box-shadow:0 5px 20px rgba(0,0,0,0.15);
}

/* ================= TITLE ================= */

h2{
    text-align:center;
    color:#0b8457;
    margin-bottom:25px;
    font-size:28px;
}

/* ================= FORM ================= */

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:18px;
}

.full{
    grid-column:1 / -1;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
    color:#333;
}

input,
select{

    width:100%;
    padding:14px;

    border:1px solid #ccc;
    border-radius:12px;

    font-size:15px;

    transition:0.3s;
}

input:focus,
select:focus{

    border-color:#0b8457;
    outline:none;

    box-shadow:0 0 10px rgba(11,132,87,0.2);
}

/* ================= BUTTON ================= */

button{

    width:100%;
    padding:15px;

    border:none;
    border-radius:12px;

    background:#0b8457;
    color:white;

    font-size:18px;
    font-weight:bold;

    cursor:pointer;

    transition:0.3s;
}

button:hover{
    background:#066645;
    transform:translateY(-2px);
}

/* ================= TABLE ================= */

.table-wrap{
    overflow-x:auto;
}

table{

    width:100%;
    min-width:900px;

    border-collapse:collapse;
}

th{

    background:#0b8457;
    color:white;

    padding:15px;

    font-size:15px;
}

td{

    padding:14px;

    border-bottom:1px solid #eee;

    text-align:center;

    font-size:14px;
}

tr:nth-child(even){
    background:#f9f9f9;
}

tr:hover{
    background:#eefaf4;
}

/* ================= BUTTON AKSI ================= */

.aksi{
    display:flex;
    justify-content:center;
    gap:8px;
    flex-wrap:wrap;
}

.btn{

    padding:8px 14px;

    border-radius:8px;

    text-decoration:none;
    color:white;

    font-size:13px;
    font-weight:bold;
}

.edit{
    background:#ff9800;
}

.hapus{
    background:#e53935;
}

.edit:hover{
    background:#e68900;
}

.hapus:hover{
    background:#c62828;
}

/* ================= RESPONSIVE TV ================= */

@media screen and (min-width:1600px){

    body{
        padding:30px;
    }

    .container{
        max-width:1800px;
    }

    .header{
        padding:30px;
    }

    .logo{
        width:110px;
        height:110px;
    }

    .title h1{
        font-size:46px;
    }

    .title p{
        font-size:24px;
    }

    .card{
        padding:35px;
    }

    h2{
        font-size:38px;
    }

    label{
        font-size:22px;
    }

    input,
    select{
        padding:20px;
        font-size:22px;
    }

    button{
        padding:20px;
        font-size:24px;
    }

    th{
        font-size:22px;
    }

    td{
        font-size:20px;
    }

    .btn{
        font-size:16px;
        padding:12px 20px;
    }
}

/* ================= RESPONSIVE TABLET ================= */

@media screen and (max-width:992px){

    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:auto;
    }

    .title h1{
        font-size:24px;
    }

    table{
        min-width:800px;
    }
}

/* ================= RESPONSIVE HP ================= */

@media screen and (max-width:768px){

    body{
        padding:10px;
    }

    .header{
        flex-direction:column;
        text-align:center;
        gap:15px;
    }

    .logo{
        width:60px;
        height:60px;
    }

    .title h1{
        font-size:20px;
        line-height:1.5;
    }

    .title p{
        font-size:13px;
    }

    .card{
        padding:15px;
    }

    h2{
        font-size:22px;
    }

    input,
    select{
        padding:12px;
        font-size:14px;
    }

    button{
        padding:13px;
        font-size:16px;
    }

    table{
        min-width:750px;
    }

    th{
        font-size:13px;
    }

    td{
        font-size:13px;
    }

    .aksi{
        flex-direction:column;
    }

    .btn{
        width:100%;
        text-align:center;
    }
}

/* ================= RESPONSIVE HP KECIL ================= */

@media screen and (max-width:480px){

    .title h1{
        font-size:18px;
    }

    .title p{
        font-size:12px;
    }

    h2{
        font-size:20px;
    }

    input,
    select{
        font-size:13px;
    }

    button{
        font-size:15px;
    }
}

</style>

</head>

<body>

<div class="container">

<!-- ================= HEADER ================= -->

<div class="header">

    <img src="udayana.png" class="logo">

    <div class="title">
        <h1>RS TK.IV 09.07.05 Sultan Abdul Kahir II Bima</h1>
        <p>Sistem Input Jadwal Dokter</p>
    </div>

    <img src="wirasakti.jpeg" class="logo">

</div>

<!-- ================= FORM ================= -->

<div class="card">

<h2>
<?= $edit ? 'EDIT JADWAL DOKTER' : 'INPUT JADWAL DOKTER'; ?>
</h2>

<form method="POST">

<input
type="hidden"
name="id"
value="<?= $edit['id'] ?? '' ?>"
>

<div class="form-grid">

<div>
<label>Nama Dokter</label>

<input
type="text"
name="nm_dokter"
placeholder="Masukkan Nama Dokter"
value="<?= $edit['nm_dokter'] ?? '' ?>"
required
>
</div>

<div>
<label>Nama Poli</label>

<input
type="text"
name="nm_poli"
placeholder="Masukkan Nama Poli"
value="<?= $edit['nm_poli'] ?? '' ?>"
required
>
</div>

<div>
<label>Hari Praktik</label>

<select name="hari_kerja" required>

<option value="">Pilih Hari</option>

<?php
$hari = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];

foreach($hari as $h){
?>

<option
value="<?= $h; ?>"
<?= (($edit['hari_kerja'] ?? '') == $h) ? 'selected' : ''; ?>
>
<?= $h; ?>
</option>

<?php } ?>

</select>
</div>

<div>
<label>Jam Mulai</label>

<input
type="time"
name="jam_mulai"
value="<?= $edit['jam_mulai'] ?? '' ?>"
required
>
</div>

<div>
<label>Jam Selesai</label>

<input
type="time"
name="jam_selesai"
value="<?= $edit['jam_selesai'] ?? '' ?>"
required
>
</div>

<div class="full">

<?php if($edit){ ?>

<button type="submit" name="update">
UPDATE JADWAL DOKTER
</button>

<?php } else { ?>

<button type="submit" name="simpan">
SIMPAN JADWAL DOKTER
</button>

<?php } ?>

</div>

</div>

</form>

</div>

<!-- ================= DATA ================= -->

<div class="card">

<h2>DATA JADWAL DOKTER</h2>

<div class="table-wrap">

<table>

<tr>
<th>Nama Dokter</th>
<th>Poli</th>
<th>Hari</th>
<th>Jam Mulai</th>
<th>Jam Selesai</th>
<th>Aksi</th>
</tr>

<?php while($d=mysqli_fetch_assoc($data)){ ?>

<tr>

<td><?= $d['nm_dokter']; ?></td>

<td><?= $d['nm_poli']; ?></td>

<td><?= $d['hari_kerja']; ?></td>

<td><?= $d['jam_mulai']; ?></td>

<td><?= $d['jam_selesai']; ?></td>

<td>

<div class="aksi">

<a
href="?edit=<?= $d['id']; ?>"
class="btn edit"
>
Edit
</a>

<a
href="?hapus=<?= $d['id']; ?>"
class="btn hapus"
onclick="return confirm('Hapus data dokter ini?')"
>
Hapus
</a>

</div>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>
