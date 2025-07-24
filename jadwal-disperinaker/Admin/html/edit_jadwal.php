<?php 
session_start();
include_once '../../db.php';
if(!isset($_SESSION['login'])){
  header("Location: ../../login.php");
} else if ($_SESSION['role'] != 'Admin'){
  header("location: ../../dashboard.php");
}
$id = $_GET['id'];
$query = "SELECT * FROM Jadwal_Kegiatan WHERE id = '$id'";
$data = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($data);

if(isset($_POST['input_jadwal'])){
  $jenis_kegiatan = $_POST['jenis_kegiatan'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $tanggal_selesai = $_POST['tanggal_selesai'];
  $waktu = $_POST['waktu_kegiatan'];
  $tempat = $_POST['tempat_kegiatan'];
  $agenda = $_POST['agenda_kegiatan'];
  $keterangan = $_POST['deskripsi'];

  $query = " UPDATE Jadwal_Kegiatan SET 
        Jenis_Kegiatan = '$jenis_kegiatan',
        Tanggal_Mulai = '$tanggal_mulai',
        Tanggal_Selesai = '$tanggal_selesai',
        Waktu = '$waktu',
        Tempat = '$tempat',
        Agenda = '$agenda',
        Keterangan = '$keterangan'
        WHERE id = '$id'; ";
  $data = mysqli_query($conn, $query);
  if($data){
    header("Location: index.php?edit=0");
  }else{
      header("Location: index.php?edit=1");
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
            <h1 class="text-center fw-bold">UBAH JADWAL KEGIATAN</h1>
          </div>
          <form method="post" class="row g-3">
            <div class="col-12">
              <label for="jenis_kegiatan" class="form-label"
                >Jenis Kegiatan</label
              >
              <select
                class="form-select"
                name="jenis_kegiatan"
                aria-label="Default select example">
                <option value="<?= $row['Jenis_Kegiatan'] ?>" selected><?= $row['Jenis_Kegiatan'] ?></option>
                <option value="Internal">Internal</option>
                <option value="Eksternal">Eksternal</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="tanggal_mulai" class="form-label"
                >Tanggal Mulai</label
              >
              <input
              value="<?= $row['Tanggal_Mulai'] ?>"
              type="date"
              class="form-control"
              name="tanggal_mulai"
              id="tanggal_mulai" />
            </div>
            <div class="col-md-6">
              <label for="tanggal_selesai" class="form-label"
                >Tanggal Selesai</label
              >
              <input
              value="<?= $row['Tanggal_Selesai']?>"
              type="date"
              class="form-control"
              name="tanggal_selesai"
              id="tanggal_selesai" />
            </div>
            <div class="col-12">
              <label for="waktu_kegiatan" class="form-label"
                >Waktu Kegiatan</label
              >
              <input
              value="<?= $row['Waktu']?>"
              type="time"
              class="form-control"
              name="waktu_kegiatan"
              id="waktu_kegiatan" />
            </div>
            <div class="col-md-6">
              <label for="tempat_kegiatan" class="form-label"
                >Tempat Kegiatan</label
              >
              <input
              type="text"
              class="form-control"
              id="tempat_kegiatan"
              value="<?= $row['Tempat']?>"
              name="tempat_kegiatan" />
            </div>
            <div class="col-md-6">
              <label for="agenda_kegiatan" class="form-label"
                >Agenda Kegiatan</label
              >
              <input
              type="text"
              class="form-control"
              id="agenda_kegiatan"
              value="<?= $row['Agenda']?>"
              name="agenda_kegiatan" />
            </div>
            <div class="col-md-12">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea
                class="form-control"
                id="deskripsi"
                name="deskripsi"
                rows="3"><?= $row['Keterangan']?></textarea>
            </div>
            <div class="col-12 text-end">
              <button type="submit" name="input_jadwal" class="btn btn-success">Simpan</button>
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
