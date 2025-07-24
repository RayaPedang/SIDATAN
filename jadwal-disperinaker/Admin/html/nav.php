<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="../../logo_disperinaker.png" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Navigasi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./index.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Penjadwalan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./input_jadwal.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-article"></i>
                        </span>
                        <span class="hide-menu">Input Agenda Kegiatan</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Riwayat Kegiatan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./riwayat_kegiatan.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="hide-menu">Riwayat Kegiatan</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengguna</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./data_pengguna.php" aria-expanded="false">
                        <span>
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">Data Pengguna</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a onclick="openModal()" class="sidebar-link">
                        <span>
                            <i class="ti ti-logout"></i>
                        </span>
                        <span class="hide-menu">Keluar</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

<!-- Modal -->
<div id="logoutModal1" class="modal-logout">
    <div class="modal-content-logout">
        <h2>Konfirmasi Logout</h2>
        <p>Apakah anda yakin ingin keluar?</p>
        <div class="modal-buttons-logout">
            <button onclick="closeModal()" class="btn btn-secondary">Batal</button>
            <button onclick="logout()" class="btn btn-danger">Keluar</button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function openModal() {
        document.getElementById('logoutModal1').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('logoutModal1').style.display = 'none';
    }

    function logout() {
        window.location.href = '../../logout.php';
        closeModal();
    }
</script>

<!-- CSS for Modal -->
<style>
    .modal-logout {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); 
        justify-content: center;
        align-items: center;
        z-index: 1050; 
    }

    .modal-content-logout {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        width: 300px;
        text-align: center;
    }

    .modal-buttons-logout {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
