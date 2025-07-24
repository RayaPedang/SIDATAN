<?php 
session_start();
include_once '../../db.php';
if(!isset($_SESSION['login'])){
  header("Location: ../../login.php");
} else if ($_SESSION['role'] != 'Admin'){
  header("location: ../../dashboard.php");
}
$id = $_GET['id'];
$query = "SELECT * FROM Pengguna WHERE id = '$id'";
$data = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($data);

if(isset($_POST['input_pengguna'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  $query = " UPDATE Pengguna SET 
        username = '$username',
        password = '$password',
        role = '$role'
        WHERE id = '$id'";
  $data = mysqli_query($conn, $query);
  if($data){
    header("Location: data_pengguna.php?edit=0");
  }else{
      header("Location: data_pengguna.php?edit=1");
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Input Jadwal Dinas</title>
    <link
      rel="shortcut icon"
      type="image/png"
      href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
  </head>

  <body>
    <!--  Body Wrapper -->
    <div
      class="page-wrapper"
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin6"
      data-sidebartype="full"
      data-sidebar-position="fixed"
      data-header-position="fixed">
      <!-- Sidebar Start -->
      <?php include 'nav.php'?>
      <!--  Sidebar End -->
      <!--  Main wrapper -->
      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="row">
            <h1 class="text-center fw-bold">UBAH DATA PENGGUNA</h1>
          </div>
          <form method="post" class="row g-3">
            <div class="col-12">
              <label for="username" class="form-label"
                >Username</label
              >
              <input
              value="<?= $row['username'] ?>"
              type="text"
              class="form-control"
              name="username"
              id="username" />
            </div>
            <div class="col-12">
              <label for="password" class="form-label"
                >Password</label
              >
              <input
              value="<?= $row['password'] ?>"
              type="text"
              class="form-control"
              name="password"
              id="password" />
            </div>
            <div class="col-12">
              <label for="role" class="form-label"
                >Role</label
              >
              <select
                class="form-select"
                name="role"
                aria-label="Default select example">
                <option value="<?= $row['role'] ?>" selected><?= $row['role'] ?></option>
                <option value="Admin">Admin</option>
                <option value="Kepala Dinas">Kepala Dinas</option>
                <option value="Sekretaris Dinas">Sekretaris Dinas</option>
                <option value="Kepala Bagian">Kepala Bagian</option>
                <option value="Kepala Bidang">Kepala Bidang</option>
              </select>
            </div>
            <div class="col-12 text-end">
              <a href="javascript:history.back()" class="btn btn-info">Kembali</a>
              <button type="submit" name="input_pengguna" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
  </body>
</html>
