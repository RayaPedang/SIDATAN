<?php 
include_once 'db.php';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kegiatan Dinas</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo-container">
                <img src="logo_bangga.png" alt="Logo Bangga Melayani Bangsa" class="logo">
            </div>
            <div class="logo-container">
                <img src="logo_disperinaker.png" alt="Logo Disperinaker" class="logo">
            </div>
            <div class="logo-container">
                <img src="logo_berakhlak.png" alt="Logo Berakhlak" class="logo">
            </div>
        </header>
        <main>
            <h1>SIDATAN</h1>
            <h3>Informasi Agenda Kegiatan</h3>
            <button onclick="openModal()" class="open-button">Keluar</button>

            <div id="logoutModal" class="modal">
                <div class="modal-content">
                    <h2>Konfirmasi Logout</h2>
                    <p>Apakah Anda yakin ingin keluar?</p>
                    <div class="modal-buttons">
                        <button onclick="closeModal()" class="cancel-button">Batal</button>
                        <button onclick="logout()" class="logout-button">Keluar</button>
                    </div>
                </div>
            </div>


            <div class="summary-container">
                <!-- Bagian 1: Jumlah Kegiatan Hari Ini -->
                <div class="summary-card">
                    <p>Total Kegiatan</p>
                    <h3><?= mysqli_num_rows($data); ?></h3>
                </div>
                <!-- Bagian 2: Tanggal Hari Ini -->
                <div class="summary-card">
                    <p>Tanggal Hari Ini</p>
                    <h3><?= formatTanggalIndonesia($today)?></h3>
                </div>
                <!-- Bagian 3: Button Lihat Semua Jadwal -->
                <div class="summary-card">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <br></br>
                        <form method="post">
                            <div class="input-group">
                            <input type="date" class="form-control" name="tanggal" value="<?= $filter; ?>" aria-label="date" required>
                            <button class="btn btn-primary" type="submit">Lihat</button>
                            <button class="btn btn-secondary" type="submit" name="all">Semua</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <script src="script.js"></script>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Kegiatan</th>
                        <th>Hari, Tanggal</th>
                        <th>Waktu</th>
                        <th>Tempat</th>
                        <th>Agenda</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $a = 1;
                        while ($row = mysqli_fetch_assoc($data)) :
                        ?>
                    <tr>
                        <td><?= $a++ ?></td>
                        <td>
                            <?php if($row['Jenis_Kegiatan'] == "Eksternal"){
                                echo'<span class="badge eksternal">Eksternal</span>';
                                } else {
                                  echo'<span class="badge internal">Internal</span>';
                                }
                                ?>
                        </td>
                        <td>
                            <?php if($row['Tanggal_Mulai'] == $row['Tanggal_Selesai']):
                              ?>
                            <?= formatTanggalIndonesia($row['Tanggal_Mulai']);?>
                            <?php else: ?>
                                <?= formatTanggalIndonesia($row['Tanggal_Mulai']);?> - <br> <?= formatTanggalIndonesia($row['Tanggal_Selesai']);?> 
                            <?php endif; ?>
                        </td>
                        <td><?= date("H:i", strtotime($row['Waktu']));?></td>
                        <td class="border-bottom-0 text-left"><?= $row['Tempat']?></td>
                        <td class="border-bottom-0 text-left"><?= $row['Agenda']?></td>
                        <td class="border-bottom-0 text-left"><?= $row['Keterangan']?></td>
                        
                    </tr>
                    <?php 
                    endwhile;
                    ?>
                </tbody>
            </table>
        </main>
    </div>
    <script>
    function openModal() {
        document.getElementById('logoutModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }
    
    function logout() {
        window.location.href = 'logout.php';
        closeModal();
    }
</script>
</body>
</html>
