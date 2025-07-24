<?php 
include_once 'db.php';
session_start();

$notlogin = false;

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']); 
    $password = $_POST['password'];
    $query = "SELECT * FROM Pengguna WHERE username = '$username'";
    $data = mysqli_query($conn, $query);

    if ($data && mysqli_num_rows($data) > 0) {
        $login = mysqli_fetch_assoc($data);
        if ($password ==  $login['password']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $login['role'];

            if ($login['role'] == 'Admin') {
                header("Location: Admin/html/index.php");
                exit;
            } else {
                header("Location: dashboard.php");
                exit;
            }
        } else {
            $notlogin = true;
        }
    } else {
        $notlogin = true;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Disperinaker</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <img src="logo_disperinaker.png" alt="Logo Disperinaker" class="logo">
            <h1>SIDATAN</h1>
            <h3>Informasi Agenda Kegiatan</h3>
            <?php if($notlogin):?>
            <h4 style="color: red;">
                Username atau password salah!
            </h4>
            <?php endif;?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <a href="lupa_password.php" class="forgot-password">Lupa password?</a>
                <button type="submit" name="login" class="login-button">MASUK</button>
            </form>
        </div>
    </div>
</body>
</html>
