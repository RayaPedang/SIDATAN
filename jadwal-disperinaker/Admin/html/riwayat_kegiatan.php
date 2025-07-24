<?php 
session_start();
include_once '../../db.php';
if(!isset($_SESSION['login'])){
  header("Location: ../../login.php");
} else if ($_SESSION['role'] != 'Admin'){
  header("location: ../../dashboard.php");
}

date_default_timezone_set("Asia/Jakarta");
$today = date("Y-m-d");

// Default query to get today's activities
$query = "SELECT * FROM Jadwal_Kegiatan WHERE DATE(Tanggal_Mulai) = '$today' ORDER BY Tanggal_Mulai ASC, Waktu ASC";
$data = mysqli_query($conn, $query);

// Filter by specific month/year
if(isset($_POST['tanggal'])){
    $filter = $_POST['tanggal'];
    $query = "SELECT * FROM Jadwal_Kegiatan WHERE DATE(Tanggal_Mulai) = '$filter' ORDER BY Tanggal_Mulai ASC, Waktu ASC";
    $data = mysqli_query($conn, $query);
} elseif (isset($_POST['month_year'])) {
    $month_year = $_POST['month_year'];
    $query = "SELECT * FROM Jadwal_Kegiatan WHERE DATE_FORMAT(Tanggal_Mulai, '%Y-%m') = '$month_year' ORDER BY Tanggal_Mulai ASC, Waktu ASC";
    $data = mysqli_query($conn, $query);
}

// Filter all activities
if(isset($_POST['all'])){
    $query = "SELECT * FROM Jadwal_Kegiatan 
              WHERE DATE(Tanggal_Selesai) ORDER BY Tanggal_Mulai ASC, Waktu ASC";
    $data = mysqli_query($conn, $query);
}

function formatTanggalIndonesia($tanggal) {
    $hari_indonesia = [
        "Sunday" => "Minggu",
        "Monday" => "Senin",
        "Tuesday" => "Selasa",
        "Wednesday" => "Rabu",
        "Thursday" => "Kamis",
        "Friday" => "Jumat",
        "Saturday" => "Sabtu"
    ];

    $bulan_indonesia = [
        "January" => "Januari",
        "February" => "Februari",
        "March" => "Maret",
        "April" => "April",
        "May" => "Mei",
        "June" => "Juni",
        "July" => "Juli",
        "August" => "Agustus",
        "September" => "September",
        "October" => "Oktober",
        "November" => "November",
        "December" => "Desember"
    ];
    $nama_hari = date("l", strtotime($tanggal)); 
    $tanggal_hari = date("d", strtotime($tanggal));
    $bulan = date("F", strtotime($tanggal)); 
    $tahun = date("Y", strtotime($tanggal)); 
    return $hari_indonesia[$nama_hari] . ", " . $tanggal_hari . " " . $bulan_indonesia[$bulan] . " " . $tahun;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Riwayat Kegiatan Dinas</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="colors.css" />
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/app.min.js"></script>
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
      <!--  Header Start -->
      <!--  Header End -->
      <div class="container-fluid">
        <div class="row">
            <h1 class="text-center fw-bold">RIWAYAT AGENDA KEGIATAN</h1>
          </div>
          <div class="row">
            <div class="col-lg-4">
              <div class="card overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title mb-9 fw-semibold">Total Kegiatan</h5>
                  <h4 class="fw-semibold mb-3"><?= mysqli_num_rows($data); ?></h4>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title mb-9 fw-semibold">Tanggal Hari Ini</h5>
                  <h4 class="fw-semibold mb-3"><?= formatTanggalIndonesia($today)?></h4>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title mb-9 fw-semibold">Filter</h5>
                  <div class="row align-items-center">
                    <div class="col-8">
                      <form method="post">
                        <div class="input-group">
                          <input type="month" class="form-control" name="month_year" value="<?= $month_year; ?>" aria-label="month_year" aria-describedby="button-addon2" required>
                          <button class="btn btn-primary" type="submit" id="button-addon2">Lihat</button>
                        </div>
                      </form>
                    </div>
                    <div class="col">
                      <form method="post">
                          <button class="btn btn-primary" type="submit" name="all">Semua</button>                     
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <div class="print-button-container d-flex justify-content-end">
                    <button class="btn btn-success" id="printButton">Cetak Riwayat</button>
                  </div>

                  <div class="table-responsive" id="tableContent">
                    <table class="table text-nowrap mb-0 align-middle">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="text-center">No</th>
                          <th class="text-center">Jenis Kegiatan</th>
                          <th class="text-center">Hari, Tanggal</th>
                          <th class="text-center">Waktu</th>
                          <th class="text-center">Tempat</th>
                          <th class="text-center">Agenda</th>
                          <th class="text-center">Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $a = 1;
                        while ($row = mysqli_fetch_assoc($data)) :
                        ?>
                        <tr>
                          <td class="text-center"><?= $a++ ?></td>
                          <td class="text-center">
                            <?php 
                            if($row['Jenis_Kegiatan'] == "Eksternal") {
                                echo '<span class="badge bg-danger">Eksternal</span>';
                            } else {
                                echo '<span class="badge bg-primary">Internal</span>';
                            }
                            ?>
                          </td>
                          <td class="text-center">
                            <?= formatTanggalIndonesia($row['Tanggal_Mulai']); ?>
                          </td>
                          <td class="text-center"><?= date("H:i", strtotime($row['Waktu'])); ?></td>
                          <td class="text-center"><?= $row['Tempat']?></td>
                          <td class="text-center"><?= $row['Agenda']?></td>
                          <td class="text-center"><?= $row['Keterangan']?></td>
                        </tr>
                        <?php endwhile; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Function print table content
    document.getElementById("printButton").onclick = function() {
     var printContent = document.getElementById("tableContent").innerHTML;
     var title = "<h3 class='text-center'>Jadwal Kegiatan Dinas</h3>";
     var originalContent = document.body.innerHTML;
  
     document.body.innerHTML = title + printContent;
     window.print();
     document.body.innerHTML = originalContent;
    }
    </script>

    <script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    </script>
  </body>
</html>
