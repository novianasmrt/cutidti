<style>
    /* 1. Layout Dasar Topbar */
    .top-bar {
        height: 4.375rem;
        background-color: #fff;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        position: relative;
        z-index: 10;
    }

    /* 2. User Actions (Kanan) */
    .user-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* 3. Tombol Ikon (Lonceng & Pesan) */
    .icon-btn {
        position: relative;
        /* Penting agar badge tidak lari */
        height: 40px;
        width: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #b7b9cc;
        text-decoration: none !important;
        border-radius: 50%;
        transition: all 0.2s;
    }

    .icon-btn:hover,
    .show>.icon-btn {
        background-color: #f8f9fc;
        color: #003366;
        /* Warna Biru UGM saat hover/aktif */
    }

    .icon-btn i {
        font-size: 1.1rem;
    }

    /* 4. Badge Counter (Angka Merah) */
    .badge-count {
        position: absolute;
        top: 3px;
        right: 3px;
        background-color: #e74a3b;
        color: white;
        font-size: 0.6rem;
        font-weight: bold;
        padding: 2px 5px;
        border-radius: 6px;
        border: 2px solid #fff;
        line-height: 1;
    }

    /* 5. Dropdown Notifikasi Style */
    .dropdown-list {
        width: 22rem !important;
        padding: 0;
        border: none;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .dropdown-header {
        background-color: #003366;
        /* Header Biru Tua */
        padding: 0.75rem 1.25rem;
        color: #fff;
        font-weight: 800;
        font-size: 0.8rem;
    }

    .dropdown-item {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #e3e6f0;
        display: flex;
        align-items: center;
        white-space: normal;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f8f9fc;
        text-decoration: none;
    }

    /* 6. WARNA SOFT (UGM MODERN STYLE) */
    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Biru Soft */
    .soft-blue {
        background-color: #E6F0FF;
        color: #003366;
    }

    /* Hijau Soft */
    .soft-green {
        background-color: #E6FFFA;
        color: #006644;
    }

    /* Kuning Soft */
    .soft-yellow {
        background-color: #FFF7E6;
        color: #CC8800;
    }

    /* 7. Profile Styles */
    .profile-menu {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 10px;
        text-decoration: none !important;
        cursor: pointer;
    }

    .profile-info {
        text-align: right;
        line-height: 1.2;
    }

    /* Warna teks biru saat dropdown aktif */
    .show>.profile-menu .profile-info span {
        color: #003366 !important;
    }
</style>

<main class="main-content">

    <header class="top-bar">

        <button class="menu-toggle btn btn-link d-md-none mr-3" onclick="toggleSidebar()">
            <i class="fas fa-bars" style="color: #003366;"></i>
        </button>

        <div class="page-title d-none d-sm-block">
            <?php
            // 1. DAFTAR HALAMAN YANG TIDAK BOLEH ADA KATA 'CUTI'
            $bebas_cuti = ['Profile', 'Data Staff', 'Data Cuti', 'Dashboard', 'Approval', 'Tambah Staff', 'Laporan'];

            // 2. CEK: Apakah subtitle saat ini ada di dalam daftar $bebas_cuti?
            if (in_array($subtitle, $bebas_cuti)) :
            ?>
                <h1 class="h3 mb-0 font-weight-bold" style="color: #1f2937; font-size: 1.2rem;">
                    <?= $subtitle; ?>
                </h1>
            <?php elseif (!empty($subtitle)) : ?>
                <h1 class="h3 mb-0 font-weight-bold" style="color: #1f2937; font-size: 1.2rem;">
                    <?= $subtitle; ?> Cuti
                </h1>
            <?php else : ?>
                <h1 class="h3 mb-0 font-weight-bold" style="color: #1f2937; font-size: 1.2rem;">
                    <?= $title; ?>
                </h1>
            <?php endif; ?>
        </div>

        <div class="user-actions">

            <div class="dropdown no-arrow mx-1">
                <?php
                $ci =& get_instance();
                $ci->load->model('Cuti_model');
                $ci->load->model('User_model');
                
                $email_aktif = $ci->session->userdata('email');
                $user_aktif = $ci->User_model->get_user_by_email($email_aktif);
                $role_aktif = $ci->session->userdata('role_id_active');
                
                $notifikasi = [];
                if ($user_aktif) {
                    if ($role_aktif == 1) {
                        // ADMIN: Ambil pengajuan yang masih status "Menunggu"
                        $semua = $ci->Cuti_model->get_all_cuti();
                        foreach ($semua as $c) {
                            if ($c->status == 'Menunggu') {
                                $notifikasi[] = $c;
                            }
                        }
                    } else {
                        // PEGAWAI: Ambil cuti milik sendiri yang sudah selesai diproses (Disetujui/Ditolak/dll)
                        $semua_milik_pegawai = $ci->Cuti_model->get_cuti_by_user($user_aktif->id_user);
                        foreach ($semua_milik_pegawai as $c) {
                            if ($c->status != 'Menunggu') {
                                $notifikasi[] = $c;
                            }
                        }
                    }
                }
                
                // Batasi hanya menampilkan 5 notifikasi terbaru
                $notifikasi = array_slice($notifikasi, 0, 5);
                $notif_count = count($notifikasi);
                ?>

                <a class="nav-link dropdown-toggle icon-btn" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-bell"></i>
                    <?php if ($notif_count > 0): ?>
                        <span class="badge-count"><?= $notif_count; ?></span>
                    <?php endif; ?>
                </a>

                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Pusat Notifikasi
                    </h6>

                    <?php if ($notif_count > 0): ?>
                        <?php foreach ($notifikasi as $notif): ?>
                            <?php
                            // Tentukan Ikon & Warna berdasarkan Status/Role
                            $icon_class = 'fa-file-alt';
                            $color_class = 'soft-blue';
                            $pesan = '';
                            $tgl = date('d M Y', strtotime($notif->tanggal_input ?? $notif->tanggal_mulai ?? time()));

                            if ($role_aktif == 1) {
                                // Tampilan Admin
                                $pesan = "Ada pengajuan baru dari <b>" . ($notif->nama ?? 'Pegawai') . "</b>";
                                $color_class = 'soft-yellow';
                                $icon_class = 'fa-exclamation-triangle';
                            } else {
                                // Tampilan Pegawai
                                if ($notif->status == 'Disetujui') {
                                    $color_class = 'soft-green';
                                    $icon_class = 'fa-check';
                                } elseif ($notif->status == 'Ditolak') {
                                    $color_class = 'soft-red';
                                    $icon_class = 'fa-times';
                                } else {
                                    $color_class = 'soft-blue';
                                    $icon_class = 'fa-info-circle';
                                }
                                $pesan = "Pengajuan cuti Anda telah <b>" . $notif->status . "</b>";
                            }
                            
                            $link_tujuan = ($role_aktif == 1) ? base_url('cuti/approval') : base_url('cuti/riwayat');
                            ?>
                            <a class="dropdown-item" href="<?= $link_tujuan; ?>">
                                <div class="mr-3">
                                    <div class="icon-circle <?= $color_class; ?>" <?= ($color_class == 'soft-red') ? 'style="background-color: #FFE6E6; color: #CC0000;"' : '' ?>>
                                        <i class="fas <?= $icon_class; ?>"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500"><?= $tgl; ?></div>
                                    <span style="color: #333; font-size: 0.85rem;"><?= $pesan; ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <a class="dropdown-item text-center small text-gray-500" href="#">Tidak ada notifikasi baru</a>
                    <?php endif; ?>

                    <a class="dropdown-item text-center small text-gray-500 bg-light" href="#">Tutup</a>
                </div>
            </div>

            <div style="width: 1px; height: 30px; background-color: #e3e6f0; margin: 0 5px;"></div>

            <div class="dropdown no-arrow">

                <a class="nav-link dropdown-toggle profile-menu" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <div class="profile-info text-right d-none d-md-block">
                        <span class="d-block text-gray-600 font-weight-bold" style="font-size: 0.9rem;">
                            <?= $this->session->userdata('name'); ?> </span>
                        <small class="text-muted">
                            <?= ($this->session->userdata('role_id_active') == 1) ? 'Administrator' : 'Pegawai'; ?> </small>
                    </div>
                    <img
                        src="<?= base_url('assets/img/profile/' . (!empty($user->image) ? $user->image : 'default.png')); ?>"
                        class="rounded-circle"
                        style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #e3e6f0;">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="userDropdown">

                    <?php if (in_array($this->session->userdata('role_id_original'), [1, 3, 4, 5])) : ?>

                        <?php if (in_array($this->session->userdata('role_id_active'), [1, 3, 4, 5])) : ?>
                            <a class="dropdown-item text-primary" href="<?= base_url('auth/switch_role'); ?>">
                                <i class="fas fa-random fa-sm fa-fw mr-2 text-primary"></i>
                                <b>Masuk sebagai Pegawai</b>
                            </a>

                        <?php else : ?>
                            <a class="dropdown-item text-danger" href="<?= base_url('auth/switch_role'); ?>" style="background-color: #fff3cd;">
                                <i class="fas fa-undo fa-sm fa-fw mr-2 text-danger"></i>
                                <b>Kembali ke Role Awal</b>
                            </a>
                        <?php endif; ?>

                        <div class="dropdown-divider"></div>

                    <?php endif; ?>

                    <a class="dropdown-item" href="<?= base_url('user/profile'); ?>">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profil
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </header>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Konfirmasi Keluar</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div style="margin-bottom: 15px;">
                        <div style="width: 60px; height: 60px; background: #ffeaea; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-sign-out-alt" style="font-size: 30px; color: #e74a3b;"></i>
                        </div>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Yakin ingin keluar?</h5>
                    <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                        Pilih "Logout" di bawah jika Anda ingin mengakhiri sesi Anda saat ini.
                    </p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-custom-cancel" type="button" data-dismiss="modal">
                        Batal
                    </button>
                    <a class="btn btn-custom-logout" href="<?= base_url('auth/logout'); ?>">
                        <i class="fas fa-power-off mr-2"></i>Logout
                    </a>
                </div>

            </div>
        </div>
    </div>


    <div class="content-wrapper">