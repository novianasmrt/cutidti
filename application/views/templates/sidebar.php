<aside class="sidebar">
    <div class="sidebar-header">
        <img src="https://simaster.ugm.ac.id/ugmfw-assets/images/maskot-simaster.png" alt="Logo UGM" style="height: 40px;">

        <h2>
            <?php echo (in_array($this->session->userdata('role_id_active'), [1, 3, 4, 5])) ? 'ADMIN' : 'PEGAWAI'; ?>
        </h2>
    </div>

    <nav class="sidebar-menu">

        <?php
        // 1. AMBIL ROLE YANG SEDANG AKTIF
        $role_id = $this->session->userdata('role_id_active') ?? $this->session->userdata('role_id') ?? 2;

        // Tentukan link dashboard
        if (in_array($role_id, [1, 3, 4, 5])) {
            $link_dashboard = 'admin/index';
        } else {
            $link_dashboard = 'user/index';
        }
        ?>

        <a href="<?= base_url($link_dashboard); ?>" class="nav-link <?= ($title == 'Dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <?php if ($role_id == 2): ?>

            <div class="menu-category">CUTI PRIBADI</div>

            <a href="<?= base_url('cuti/pengajuan'); ?>" class="nav-link <?= ($this->session->userdata('subtitle') == 'Pengajuan' || $subtitle == 'Pengajuan') ? 'active' : ''; ?>">
                <i class="fas fa-plus-circle"></i>
                <span>Pengajuan</span>
            </a>

            <a href="<?= base_url('cuti/riwayat'); ?>" class="nav-link <?= ($this->session->userdata('subtitle') == 'Riwayat' || $subtitle == 'Riwayat') ? 'active' : ''; ?>">
                <i class="fas fa-history"></i>
                <span>Riwayat</span>
            </a>

        <?php endif; ?>

        <?php if (in_array($role_id, [1, 3, 4])): ?>
            <div class="menu-category">APPROVAL</div>

            <a href="<?= base_url('cuti/approval'); ?>" class="nav-link <?= ($subtitle == 'Approval') ? 'active' : ''; ?>">
                <i class="fas fa-check-double"></i>
                <span>Persetujuan</span>
            </a>
        <?php endif; ?>


        <?php if (in_array($role_id, [1, 3, 4, 5])): ?>

            <div class="menu-category">ADMINISTRATION</div>

            <a href="<?= base_url('admin/datastaff'); ?>" class="nav-link <?= ($subtitle == 'Data Staff') ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                <span>Data Staff</span>
            </a>

            <a href="<?= base_url('admin/datacuti'); ?>" class="nav-link <?= ($subtitle == 'Data Cuti') ? 'active' : ''; ?>">
                <i class="fas fa-calendar-alt"></i>
                <span>Data Cuti</span>
            </a>

            <a href="<?= base_url('admin/datalibur'); ?>" class="nav-link <?= ($subtitle == 'Kalender Libur') ? 'active' : ''; ?>">
                <i class="fas fa-calendar-day"></i>
                <span>Kalender Libur</span>
            </a>

            <a href="<?= base_url('admin/laporan'); ?>" class="nav-link <?= ($subtitle == 'Laporan') ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i>
                <span>Laporan</span>
            </a>

        <?php endif; ?>

    </nav>

    <div class="sidebar-footer">
        <a href="<?= base_url('auth/logout'); ?>"
            class="nav-link <?= ($title == 'Logout') ? 'active' : ''; ?>"
            data-toggle="modal"
            data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>
</aside>