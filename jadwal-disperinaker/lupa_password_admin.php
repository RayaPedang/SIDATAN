<?php 
include_once 'db.php';
$not = false;

if(isset($_POST['reset'])){
    $id = $_GET['id'];
    $token = $_POST['Token'];
    if($token == "3EZ9ORFYLT"){
        header('Location: reset_password.php?id='.$id);
    } elseif($token == "U8UXZX06X6"){
        header('Location: reset_password.php?id='.$id);
    } elseif($token == "84J32GNPN7"){
        header('Location: reset_password.php?id='.$id);
    } elseif($token == "W3375E6TK3"){
        header('Location: reset_password.php?id='.$id);
    } else{
        $not = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="loginstyle.css"> 
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <img src="logo_disperinaker.png" alt="Logo Disperinaker" class="logo">
            <h1>Atur Ulang Password Anda</h1>
            <p>Masukkan token yang ada di buku panduan yang diberikan.</p>
            <?php if($not):?>
                <p style="color: red;">Token yang dimasukan salah.</p>
            <?php endif?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="Token">Token</label>
                    <input type="text" id="Token" name="Token" placeholder="Token" required>
                </div>
                <button type="submit" name="reset" class="login-button">KIRIM</button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>
