<?php 
session_start();
include_once '../../db.php';
if(!isset($_SESSION['login'])){
  header("Location: ../../login.php");
} else if ($_SESSION['role'] != 'Admin'){
  header("location: ../../dashboard.php");
}
$query = "SELECT * FROM Pengguna";
$data = mysqli_query($conn, $query);
$berhasil="";
if(isset($_GET['tambah'])){
  $berhasil = $_GET['tambah'];
} elseif (isset($_GET['hapus'])){
  $berhasil = $_GET['hapus'];
} elseif (isset($_GET['edit'])){
  $berhasil = $_GET['edit'];
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Data Pengguna</title>
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
            <h1 class="text-center fw-bold">DATA PENGGUNA</h1>
          </div>
          <div class="row mb-4 mt-2">
            <div class="col-10">
            <?php if(isset($_GET['tambah'])):?>
              <?php if($berhasil == 0):?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                  Pengguna berhasil ditambahkan!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php elseif($berhasil == 1): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>
                  Pengguna gagal ditambahkan!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif;?>
            <?php elseif(isset($_GET['hapus'])):?>
              <?php if($berhasil == 0):?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                  Pengguna berhasil dihapus!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php elseif($berhasil == 1): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>
                  Pengguna gagal dihapus!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif;?>
            <?php elseif(isset($_GET['edit'])):?>
              <?php if($berhasil == 0):?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                  Pengguna berhasil diubah!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php elseif($berhasil == 1): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>
                  Pengguna gagal diubah!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif;?>
            <?php endif;?>
            </div>
            <div class="col text-end">
              <a href="tambah_pengguna.php" class="btn btn-success m-1">Tambah</a>
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
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">No</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Username</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Password</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Role</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Aksi</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $a = 0;
                        while ($row = mysqli_fetch_assoc($data)) :
                        $a++
                        ?>
                        <tr>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?= $a?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1"><?= $row['username']?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?= $row['password']?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?= $row['role']?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <a class="btn btn-warning" href="edit_pengguna.php?id=<?= $row['id']?>"><span class="ti ti-edit"></span></a> 
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
                                    <div class="container-fluid">Apakah anda yakin menghapus pengguna <b><?= $row['username']?></b>?</div>
                                  </div>
                                  <div class="modal-footer">
                                    <button
                                      type="button"
                                      class="btn btn-secondary"
                                      data-bs-dismiss="modal"
                                    >
                                      Cancel
                                    </button>
                                    <a type="button" href="hapus_pengguna.php?id=<?= $row['id']?>" class="btn btn-danger">Ya</a>
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
