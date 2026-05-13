<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

/* ================= KONEKSI ================= */
include "koneksi.php";

if(!$koneksi){
    die("Koneksi gagal : ".mysqli_connect_error());
}

/* ================= LOGIN ================= */
if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($koneksi,$_POST['username']);
    $password = mysqli_real_escape_string($koneksi,$_POST['password']);

    $query = mysqli_query($koneksi,"
        SELECT * FROM admin
        WHERE username='$username'
        AND password='$password'
    ");

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];

        header("Location: dashboard.php");
        exit;

    }else{
        $error = "Username atau Password Salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Admin RS</title>

<style>

/* ===== RESET ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

/* ===== BODY ===== */
body{
    background:#0b8457;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

/* ===== CONTAINER ===== */
.login-container{
    width:100%;
    max-width:430px;
}

/* ===== CARD ===== */
.login-card{
    background:white;
    border-radius:20px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

/* ===== HEADER ===== */
.header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:25px;
    gap:10px;
}

.logo{
    width:70px;
    height:70px;
    object-fit:contain;
}

.title{
    text-align:center;
    flex:1;
}

.title h1{
    color:#0b8457;
    font-size:22px;
    margin-bottom:5px;
}

.title p{
    color:#555;
    font-size:13px;
}

/* ===== FORM ===== */
.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:8px;
    color:#333;
    font-weight:bold;
}

input{
    width:100%;
    padding:14px;
    border:1px solid #ccc;
    border-radius:12px;
    font-size:15px;
    transition:0.3s;
}

input:focus{
    border-color:#0b8457;
    outline:none;
    box-shadow:0 0 5px rgba(11,132,87,0.3);
}

/* ===== BUTTON ===== */
button{
    width:100%;
    padding:14px;
    background:#0b8457;
    border:none;
    color:white;
    border-radius:12px;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#066645;
}

/* ===== ERROR ===== */
.error{
    background:#ffe5e5;
    color:#d8000c;
    padding:12px;
    border-radius:10px;
    margin-bottom:18px;
    text-align:center;
    font-size:14px;
}

/* ===== FOOTER ===== */
.footer{
    text-align:center;
    margin-top:20px;
    color:#777;
    font-size:13px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){

    .login-card{
        padding:25px;
    }

    .logo{
        width:55px;
        height:55px;
    }

    .title h1{
        font-size:18px;
    }

    .title p{
        font-size:12px;
    }

}

@media(max-width:480px){

    .header{
        flex-direction:column;
    }

    .title{
        margin-top:10px;
    }

    .title h1{
        font-size:17px;
    }

    input{
        padding:12px;
    }

    button{
        padding:12px;
        font-size:15px;
    }

}

</style>

</head>
<body>

<div class="login-container">

<div class="login-card">

    <!-- HEADER -->
    <div class="header">

        <!-- LOGO KIRI -->
        <img src="udayana.png" class="logo">

        <!-- JUDUL -->
        <div class="title">
            <h1>LOGIN ADMIN RS</h1>
            <p>RS TK.IV 09.07.05 Sultan Abdul Kahir II Bima</p>
        </div>

        <!-- LOGO KANAN -->
        <img src="wirasakti.jpeg" class="logo">

    </div>

    <!-- ERROR -->
    <?php if(isset($error)){ ?>
    <div class="error">
        <?= $error ?>
    </div>
    <?php } ?>

    <!-- FORM -->
    <form method="POST">

        <div class="form-group">
            <label>Username</label>
            <input 
                type="text" 
                name="username" 
                placeholder="Masukkan Username"
                required
            >
        </div>

        <div class="form-group">
            <label>Password</label>
            <input 
                type="password" 
                name="password" 
                placeholder="Masukkan Password"
                required
            >
        </div>

        <button type="submit" name="login">
            LOGIN
        </button>

    </form>

    <!-- FOOTER -->
    <div class="footer">
        Sistem Informasi Rumah Sakit
    </div>

</div>

</div>

</body>
</html>
