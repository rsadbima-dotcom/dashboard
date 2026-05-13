<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

/* ================= KONEKSI ================= */
$koneksi = mysqli_connect("localhost","root","","rs_dashboard");

if(!$koneksi){
    die("Koneksi gagal : ".mysqli_connect_error());
}

mysqli_set_charset($koneksi,"utf8");

/* ================= HAPUS / PULANG ================= */
if(isset($_GET['hapus'])){

    $id = intval($_GET['hapus']);

    mysqli_query($koneksi,"
        DELETE FROM pasien
        WHERE id='$id'
    ");

    echo "
    <script>
        alert('Pasien berhasil dipulangkan');
        location='input_pasien.php';
    </script>";
}

/* ================= EDIT ================= */
$edit = null;

if(isset($_GET['edit'])){

    $id = intval($_GET['edit']);

    $edit = mysqli_fetch_assoc(mysqli_query($koneksi,"
        SELECT * FROM pasien
        WHERE id='$id'
    "));
}

/* ================= UPDATE ================= */
if(isset($_POST['update'])){

    $id       = intval($_POST['id']);
    $no_rm    = mysqli_real_escape_string($koneksi,$_POST['no_rm']);
    $nama     = mysqli_real_escape_string($koneksi,$_POST['nama']);
    $layanan  = mysqli_real_escape_string($koneksi,$_POST['layanan']);
    $poli     = mysqli_real_escape_string($koneksi,$_POST['poli']);
    $dokter   = mysqli_real_escape_string($koneksi,$_POST['dokter']);
    $tanggal  = mysqli_real_escape_string($koneksi,$_POST['tanggal']);

    mysqli_query($koneksi,"
        UPDATE pasien SET
        no_rm='$no_rm',
        nama='$nama',
        layanan='$layanan',
        poli='$poli',
        dokter='$dokter',
        tanggal='$tanggal'
        WHERE id='$id'
    ");

    echo "
    <script>
        alert('Data pasien berhasil diupdate');
        location='input_pasien.php';
    </script>";
}

/* ================= SIMPAN ================= */
if(isset($_POST['simpan'])){

    $no_rm    = mysqli_real_escape_string($koneksi,$_POST['no_rm']);
    $nama     = mysqli_real_escape_string($koneksi,$_POST['nama']);
    $layanan  = mysqli_real_escape_string($koneksi,$_POST['layanan']);
    $poli     = mysqli_real_escape_string($koneksi,$_POST['poli']);
    $dokter   = mysqli_real_escape_string($koneksi,$_POST['dokter']);
    $tanggal  = mysqli_real_escape_string($koneksi,$_POST['tanggal']);

    mysqli_query($koneksi,"
        INSERT INTO pasien
        (
            no_rm,
            nama,
            layanan,
            poli,
            dokter,
            tanggal
        )
        VALUES
        (
            '$no_rm',
            '$nama',
            '$layanan',
            '$poli',
            '$dokter',
            '$tanggal'
        )
    ");

    echo "
    <script>
        alert('Data pasien berhasil disimpan');
        location='input_pasien.php';
    </script>";
}

/* ================= DATA PASIEN ================= */
$data = mysqli_query($koneksi,"
    SELECT * FROM pasien
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Input Pasien RS</title>

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

/* ================= JUDUL ================= */

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
    color:#333;
    font-weight:bold;
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
    width:100%;
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

/* ================= AKSI ================= */

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

/* ================= RESPONSIVE TABLET ================= */

@media(max-width:992px){

    .title h1{
        font-size:24px;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:auto;
    }
}

/* ================= RESPONSIVE HP ================= */

@media(max-width:768px){

    body{
        padding:10px;
    }

    .header{
        flex-direction:column;
        text-align:center;
    }

    .logo{
        width:65px;
        height:65px;
    }

    .title h1{
        font-size:20px;
    }

    .title p{
        font-size:14px;
    }

    .card{
        padding:18px;
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
        font-size:16px;
    }

    table{
        min-width:800px;
    }
}

/* ================= RESPONSIVE TV ================= */

@media(min-width:1600px){

    .container{
        max-width:1800px;
    }

    .title h1{
        font-size:42px;
    }

    .title p{
        font-size:22px;
    }

    h2{
        font-size:36px;
    }

    input,
    select{
        padding:18px;
        font-size:20px;
    }

    button{
        padding:18px;
        font-size:22px;
    }

    th{
        font-size:20px;
    }

    td{
        font-size:18px;
    }

    .btn{
        font-size:16px;
        padding:10px 18px;
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
        <p>Sistem Input dan Data Pasien Rumah Sakit</p>
    </div>

    <img src="wirasakti.jpeg" class="logo">

</div>

<!-- ================= FORM ================= -->

<div class="card">

<h2>
<?= $edit ? 'EDIT DATA PASIEN' : 'INPUT DATA PASIEN'; ?>
</h2>

<form method="POST">

<input
type="hidden"
name="id"
value="<?= $edit['id'] ?? '' ?>"
>

<div class="form-grid">

<div>
<label>No RM</label>

<input
type="text"
name="no_rm"
placeholder="Masukkan No RM"
value="<?= $edit['no_rm'] ?? '' ?>"
required
>
</div>

<div>
<label>Nama Pasien</label>

<input
type="text"
name="nama"
placeholder="Masukkan Nama Pasien"
value="<?= $edit['nama'] ?? '' ?>"
required
>
</div>

<div>
<label>Layanan</label>

<select name="layanan" id="layanan" required>

<option value="">Pilih Layanan</option>

<option value="Rajal"
<?= (($edit['layanan'] ?? '') == 'Rajal') ? 'selected' : ''; ?>>
Rajal
</option>

<option value="Ranap"
<?= (($edit['layanan'] ?? '') == 'Ranap') ? 'selected' : ''; ?>>
Ranap
</option>

</select>
</div>

<div>
<label id="label_poli">
<?= (($edit['layanan'] ?? '') == 'Ranap') ? 'Nama Kamar' : 'Poli / IGD'; ?>
</label>

<input
type="text"
name="poli"
id="poli"
placeholder="Masukkan Poli / IGD"
value="<?= $edit['poli'] ?? '' ?>"
>
</div>

<div>
<label>Dokter</label>

<input
type="text"
name="dokter"
placeholder="Masukkan Nama Dokter"
value="<?= $edit['dokter'] ?? '' ?>"
>
</div>

<div>
<label>Tanggal</label>

<input
type="date"
name="tanggal"
value="<?= $edit['tanggal'] ?? date('Y-m-d'); ?>"
required
>
</div>

<div class="full">

<?php if($edit){ ?>

<button type="submit" name="update">
UPDATE PASIEN
</button>

<?php } else { ?>

<button type="submit" name="simpan">
SIMPAN PASIEN
</button>

<?php } ?>

</div>

</div>

</form>

</div>

<!-- ================= DATA PASIEN ================= -->

<div class="card">

<h2>DATA PASIEN</h2>

<div class="table-wrap">

<table>

<tr>
<th>No RM</th>
<th>Nama Pasien</th>
<th>Layanan</th>
<th>Poli / Kamar</th>
<th>Dokter</th>
<th>Tanggal</th>
<th>Aksi</th>
</tr>

<?php while($p=mysqli_fetch_assoc($data)){ ?>

<tr>

<td><?= $p['no_rm']; ?></td>

<td><?= $p['nama']; ?></td>

<td><?= $p['layanan']; ?></td>

<td><?= $p['poli']; ?></td>

<td><?= $p['dokter']; ?></td>

<td><?= $p['tanggal']; ?></td>

<td>

<div class="aksi">

<a
href="?edit=<?= $p['id']; ?>"
class="btn edit"
>
Edit
</a>

<a
href="?hapus=<?= $p['id']; ?>"
class="btn hapus"
onclick="return confirm('Pulangkan pasien ini?')"
>
Pulang
</a>

</div>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

<script>

const layanan = document.getElementById('layanan');
const labelPoli = document.getElementById('label_poli');
const poliInput = document.getElementById('poli');

function ubahLabel(){

    if(layanan.value === 'Ranap'){

        labelPoli.innerHTML = 'Nama Kamar';
        poliInput.placeholder = 'Masukkan Nama Kamar';

    }else{

        labelPoli.innerHTML = 'Poli / IGD';
        poliInput.placeholder = 'Masukkan Poli / IGD';
    }
}

layanan.addEventListener('change', ubahLabel);

ubahLabel();

</script>

</body>
</html>
