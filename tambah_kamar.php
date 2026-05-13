<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

$koneksi = mysqli_connect("localhost","root","","rs_dashboard");
if(!$koneksi){
    die("Koneksi gagal: ".mysqli_connect_error());
}

/* ================= TAMBAH ================= */
if(isset($_POST['simpan_kamar'])){
    mysqli_query($koneksi,"
        INSERT INTO kamar(no_kamar,nama_kamar,kelas,status)
        VALUES('$_POST[no_kamar]','$_POST[nama_kamar]','$_POST[kelas]','$_POST[status]')
    ");
    header("Location: tambah_kamar.php");
    exit;
}

/* ================= HAPUS ================= */
if(isset($_GET['hapus'])){
    mysqli_query($koneksi,"DELETE FROM kamar WHERE id='$_GET[hapus]'");
    header("Location: tambah_kamar.php");
    exit;
}

/* ================= EDIT ================= */
$edit = null;
if(isset($_GET['edit'])){
    $edit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM kamar WHERE id='$_GET[edit]'"));
}

/* ================= UPDATE ================= */
if(isset($_POST['update_kamar'])){
    mysqli_query($koneksi,"
        UPDATE kamar SET
        no_kamar='$_POST[no_kamar]',
        nama_kamar='$_POST[nama_kamar]',
        kelas='$_POST[kelas]',
        status='$_POST[status]'
        WHERE id='$_POST[id]'
    ");
    header("Location: tambah_kamar.php");
    exit;
}

/* ================= DATA ================= */
$data = mysqli_query($koneksi,"SELECT * FROM kamar ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Kamar RS</title>

<style>

/* ===== RESET ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* ===== BACKGROUND (SAMAKAN PASIEN) ===== */
body{
    background:linear-gradient(135deg,#0b8457,#0f9d58);
    padding:15px;
}

/* ===== CONTAINER ===== */
.container{
    max-width:1100px;
    margin:auto;
}

/* ===== HEADER ===== */
.header{
    background:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:15px;
    border-radius:12px;
    margin-bottom:15px;
    box-shadow:0 3px 15px rgba(0,0,0,0.2);
}

.logo{
    width:60px;
    height:60px;
    object-fit:contain;
}

.title{
    text-align:center;
    font-weight:bold;
    font-size:18px;
    color:#0b8457;
}

.title small{
    display:block;
    font-size:12px;
    font-weight:normal;
    color:#333;
}

/* ===== CARD ===== */
.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 3px 15px rgba(0,0,0,0.2);
    margin-bottom:15px;
}

/* ===== TITLE ===== */
h2{
    text-align:center;
    color:#0b8457;
    margin-bottom:15px;
}

/* ===== FORM GRID ===== */
.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

input,select{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
}

/* full */
.full{
    grid-column:span 2;
}

/* ===== BUTTON ===== */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#0b8457;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#066645;
}

/* ===== TABLE ===== */
.table-wrap{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:700px;
}

th{
    background:#0b8457;
    color:white;
    padding:10px;
}

td{
    padding:10px;
    border-bottom:1px solid #eee;
}

tr:nth-child(even){
    background:#f9f9f9;
}

tr:hover{
    background:#f1f1f1;
}

/* ===== ACTION ===== */
a{
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    color:white;
    font-size:12px;
}

.edit{background:#ff9800;}
.hapus{background:#e53935;}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }
    .full{
        grid-column:span 1;
    }
    .header{
        flex-direction:column;
        gap:10px;
        text-align:center;
    }
}

</style>
</head>

<body>

<div class="container">

<!-- HEADER -->
<div class="header">
    <img src="udayana.png" class="logo">

    <div class="title">
        RS TK.IV 09.07.05 Sultan Abdul Kahir II Bima
    </div>

    <img src="wirasakti.jpeg" class="logo">
</div>

<!-- FORM -->
<div class="card">

<h2>DATA KAMAR</h2>

<form method="POST">

<input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

<div class="form-grid">

<input type="text" name="no_kamar" placeholder="No Kamar" value="<?= $edit['no_kamar'] ?? '' ?>" required>
<input type="text" name="nama_kamar" placeholder="Nama Kamar" value="<?= $edit['nama_kamar'] ?? '' ?>" required>

<select name="kelas">
    <option>VIP</option>
    <option>Kelas 1</option>
    <option>Kelas 2</option>
    <option>Kelas 3</option>
</select>

<select name="status">
    <option>Kosong</option>
    <option>Terisi</option>
</select>

<div class="full">
<?php if($edit){ ?>
<button name="update_kamar">UPDATE KAMAR</button>
<?php }else{ ?>
<button name="simpan_kamar">SIMPAN KAMAR</button>
<?php } ?>
</div>

</div>

</form>

</div>

<!-- TABLE -->
<div class="card">

<h2>LIST KAMAR</h2>

<div class="table-wrap">

<table>
<tr>
<th>No Kamar</th>
<th>Nama Kamar</th>
<th>Kelas</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php while($k=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $k['no_kamar'] ?></td>
<td><?= $k['nama_kamar'] ?></td>
<td><?= $k['kelas'] ?></td>
<td><?= $k['status'] ?></td>
<td>
<a class="edit" href="?edit=<?= $k['id'] ?>">Edit</a>
<a class="hapus" href="?hapus=<?= $k['id'] ?>" onclick="return confirm('Hapus kamar?')">Hapus</a>
</td>
</tr>
<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>
