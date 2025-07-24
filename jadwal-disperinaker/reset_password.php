<?php 
include_once 'db.php';

$id = $_GET['id'];
$not = false;
if(isset($_POST['reset'])){
    $newPass = $_POST['newPass'];
    $confirmPass = $_POST['confirmPass'];
    if ($newPass == $confirmPass){
        $query = "UPDATE Pengguna SET password = '$newPass' WHERE id = '$id'";
        $data = mysqli_query($conn, $query);
        if($data){
            echo "<script> alert('Password berhasil diubah.');</script>";
            header('Location: login.php');
        } else {
            echo "<script> alert('Password gagal diubah.');</script>";
        }
    } else {
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
            <?php if($not):?>
                <p style="color: red;">Password yang dimasukan tidak sama.</p>
            <?php endif?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="newPass">Masukkan Password Baru</label>
                    <input type="password" id="newPass" name="newPass" placeholder="Password Baru" required>
                </div>
                <div class="form-group">
                    <label for="confirmPass">Ulangi Password Baru</label>
                    <input type="password" id="confirmPass" name="confirmPass" placeholder="Password Baru" required>
                </div>
                <button type="submit" name="reset" class="login-button">Ubah Password</button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>
