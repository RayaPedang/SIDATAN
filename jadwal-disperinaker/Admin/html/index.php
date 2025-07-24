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
$query = "SELECT * FROM Jadwal_Kegiatan WHERE DATE(Tanggal_Mulai) = '$today' ORDER BY Tanggal_Mulai ASC, Waktu ASC";
$data = mysqli_query($conn, $query);

if(isset($_POST['tanggal'])){
  $filter = $_POST['tanggal'];
  $query = "SELECT * FROM Jadwal_Kegiatan WHERE DATE(Tanggal_Mulai) = '$filter' ORDER BY Tanggal_Mulai ASC, Waktu ASC";
  $data = mysqli_query($conn, $query);
}

if(isset($_POST['all'])){
  $query = "SELECT * FROM Jadwal_Kegiatan 
            WHERE DATE(Tanggal_Selesai) >= CURDATE() 
            ORDER BY Tanggal_Mulai ASC, Waktu ASC";
  $data = mysqli_query($conn, $query);
} 

if(isset($_GET['tambah'])){
  $berhasil = $_GET['tambah'];
} elseif (isset($_GET['hapus'])){
  $berhasil = $_GET['hapus'];
} elseif (isset($_GET['edit'])){
  $berhasil = $_GET['edit'];
}

function formatTanggalIndonesiaTanpaHari($tanggal) {
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
    $tanggal_hari = date("d", strtotime($tanggal));
    $bulan = date("F", strtotime($tanggal)); 
    $tahun = date("Y", strtotime($tanggal)); 
    return $tanggal_hari . " " . $bulan_indonesia[$bulan] . " " . $tahun;
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
    <title>Dashboard Kegiatan Dinas</title>
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
      <!--  Header Start -->
      <!--  Header End -->
      <div class="container-fluid">
        <div class="row">
            <h1 class="text-center fw-bold">SIDATAN</h1>
        </div>
        <div class="row">
          <h3 class="text-center">Informasi Agenda Kegiatan</h3>
        </div>
          <!--  Row 1 -->
          <div class="row">
            <div class="col-lg-4">
              <div class="card overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title mb-9 fw-semibold">
                    Total Kegiatan
                  </h5>
                  <div class="row align-items-center">
                    <div class="col-8">
                      <h4 class="fw-semibold mb-3"><?= mysqli_num_rows($data); ?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title mb-9 fw-semibold">Tanggal Hari Ini</h5>
                  <div class="row align-items-center">
                    <div class="col-8">
                      <h4 class="fw-semibold mb-3"><?= formatTanggalIndonesiaTanpaHari($today)?></h4>
                    </div>
                  </div>
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
                          <input type="date" class="form-control" name="tanggal" value="<?= $filter; ?>" aria-label="date" aria-describedby="button-addon2" required>
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

          <div class="row mb-4">
            <div class="col-10">
            <?php if(isset($_GET['tambah'])):?>
              <?php if($berhasil == 0):?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                  Jadwal berhasil ditambahkan!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php elseif($berhasil == 1): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>
                  Jadwal gagal ditambahkan!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif;?>
            <?php elseif(isset($_GET['hapus'])):?>
              <?php if($berhasil == 0):?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                  Jadwal berhasil dihapus!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php elseif($berhasil == 1): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>
                  Jadwal gagal dihapus!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif;?>
            <?php elseif(isset($_GET['edit'])):?>
              <?php if($berhasil == 0):?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                  Jadwal berhasil diubah!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php elseif($berhasil == 1): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>
                  Jadwal gagal diubah!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif;?>
            <?php endif;?>
            </div>
            <div class="col text-end">
              <a href="input_jadwal.php" class="btn btn-success m-1">Tambah</a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">No</h6>
                          </th>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Jenis Kegiatan</h6>
                          </th>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Hari, Tanggal</h6>
                          </th>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Waktu</h6>
                          </th>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Tempat</h6>
                          </th>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Agenda</h6>
                          </th>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Keterangan</h6>
                          </th>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Aksi</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $a = 1;
                        while ($row = mysqli_fetch_assoc($data)) :
                        ?>
                        <tr>
                          <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0"><?= $a++?></h6>
                          </td>
                          <td class="border-bottom-0 text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                              <?php if($row['Jenis_Kegiatan'] == "Eksternal"){
                                echo'<span
                                class="badge bg-danger rounded-3 fw-semibold"
                                >Eksternal</span>';
                                } else {
                                  echo'<span
                                class="badge bg-primary rounded-3 fw-semibold"
                                >Internal</span>';
                                }
                                ?>
                            </div>
                          </td>
                          <td class="border-bottom-0 text-center">
                            <?php if($row['Tanggal_Mulai'] == $row['Tanggal_Selesai']):
                              ?>
                            <h6 class="fw-semibold mb-1"><?= formatTanggalIndonesia($row['Tanggal_Mulai']); ?></h6>
                            <?php else: ?>
                            <h6 class="fw-semibold mb-1"><?= formatTanggalIndonesia($row['Tanggal_Mulai']); ?> - </h6>
                            <h6 class="fw-semibold mb-1"><?= formatTanggalIndonesia($row['Tanggal_Selesai']); ?></h6>
                            <?php endif; ?>
                          </td>
                          <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0"><?= date("H:i", strtotime($row['Waktu'])); ?></h6>
                          </td>
                          <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0"><?= $row['Tempat']?></h6>
                          </td>
                          <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0"><?= $row['Agenda']?></h6>
                          </td>
                          <td class="border-bottom-0 text center">
                            <h6 class="fw-semibold mb-0"><?= $row['Keterangan']?></h6>
                          </td>
                          <td class="border-bottom-0 text-center">
                            <a class="btn btn-warning" href="edit_jadwal.php?id=<?= $row['id']?>"><span class="ti ti-edit"></span></a> 
                            <button
                              type="button"
                              class="btn btn-danger"
                              data-bs-toggle="modal"
                              data-bs-target="#<?= $a?>"
                            >
                              <span class="ti ti-trash"></span>
                            </button>
                            
                            <!-- Modal -->
                            <div
                              class="modal fade"
                              id="<?= $a?>"
                              tabindex="-1"
                              role="dialog"
                              aria-labelledby="modalTitleId"
                              aria-hidden="true"
                            >
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">
                                      Hapus Pengguna
                                    </h5>
                                    <button
                                      type="button"
                                      class="btn-close"
                                      data-bs-dismiss="modal"
                                      aria-label="Close"
                                    ></button>
                                  </div>
                                  <div class="modal-body text-start">
                                    <div class="container-fluid">Apakah anda yakin menghapus agenda <b><?= $row['Agenda']?></b>?</div>
                                  </div>
                                  <div class="modal-footer">
                                    <button
                                      type="button"
                                      class="btn btn-secondary"
                                      data-bs-dismiss="modal"
                                    >
                                      Cancel
                                    </button>
                                    <a type="button" href="hapus_jadwal.php?id=<?= $row['id']?>" class="btn btn-danger">Ya</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
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
      var modalId = document.getElementById('modalId');
      modalId.addEventListener('show.bs.modal', function (event) {
          let button = event.relatedTarget;
          let recipient = button.getAttribute('data-bs-whatever');
      });
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
  </body>
</html>
