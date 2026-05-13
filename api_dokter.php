<?php
header('Content-Type: application/json');

include "../koneksi.php";

$data = [];

$query = mysqli_query($koneksi,"
SELECT
    kd_dokter,
    nm_dokter,
    jk
FROM dokter
WHERE status='1'
");

while($d=mysqli_fetch_assoc($query)){
    $data[] = $d;
}

echo json_encode($data,JSON_PRETTY_PRINT);
