<?php

include "koneksi.php";

$q = mysqli_query($koneksi,"
SELECT COUNT(*) as total 
FROM dokter
");

$d = mysqli_fetch_assoc($q);

echo "Total dokter : ".$d['total'];

?>
