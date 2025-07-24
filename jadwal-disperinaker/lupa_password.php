<?php 
include_once 'db.php';

if(isset($_POST['reset'])){
    $username = $_POST['username'];
    $query = "SELECT * FROM Pengguna WHERE username = '$username' ";
    $data = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($data);
    if($row['role'] == 'Admin'){
        header('Location: lupa_password_admin.php?id='.$row['id']);
    } else {
        header('Location: informasi_resetpw.php');
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
            <p>Masukkan username Anda untuk mendapatkan informasi lebih lanjut.</p>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <button type="submit" name="reset" class="login-button">KIRIM</button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>
