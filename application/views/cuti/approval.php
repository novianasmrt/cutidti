<div class="container-fluid" style="padding: 20px 30px;">

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert"
            style="border-radius: 15px; border: none; background-color: #d1e7dd; color: #0f5132;">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4" style="border: none; border-radius: 15px;">

        <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between"
            style="background-color: #fff; border-bottom: 2px solid #f0f1f5; border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h6 class="m-0 font-weight-bold" style="color: #003366; font-size: 1.1rem;">
                <i class="fas fa-tasks mr-2"></i> Daftar Pengajuan Menunggu Persetujuan
            </h6>
        </div>
        <style>
            .table-hover tbody tr:hover {
                background-color: #f8f9fc !important;
            }

            .table-hover tbody tr:hover td {
                color: #000000 !important;
            }

            .action-btn {
                background-color: #eaecf4;
                color: #6e707e;
                border-radius: 50%;
                width: 32px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: 0.2s;
            }

            .action-btn:hover {
                background-color: #d1d3e2;
                color: #4e73df;
            }
        </style>
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover text-nowrap mb-0" width="100%" cellspacing="0" style="color: #000000;">

                    <thead style="background-color: #f8f9fc; color: #003366; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">
                        <tr>
                            <th class="py-3 px-4 text-center" width="5%" style="border-top: none; border-bottom: 1px solid #e3e6f0;">No</th>
                            <th class="py-3" width="25%" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Pegawai</th>
                            <th class="py-3" width="20%" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Durasi & Tanggal</th>
                            <th class="py-3" width="35%" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Keterangan</th>
                            <th class="py-3 px-4 text-center" width="15%" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($pengajuan)) : ?>
                            <?php $no = 1; ?>
                            <?php $ada_data_menunggu = false; ?>

                            <?php foreach ($pengajuan as $p) : ?>

                                <?php
                                // ✅ LOGIKA FILTERING BERJENJANG 4 LEVEL
                                $show = false;
                                $role_aktif = $this->session->userdata('role_id_active') ?? $this->session->userdata('role_id') ?? $user->role_id;

                                if ($role_aktif == 1) {
                                    // Admin (Kepala Bidang): melihat yang menunggu atasan dan atasan_bidang-nya sesuai
                                    if (($p->status == 'Menunggu' || $p->status == 'Menunggu Atasan') && $p->atasan_bidang == $user->name) {
                                        $show = true;
                                    }
                                } elseif ($role_aktif == 3) {
                                    // Sekdir: melihat yang sudah lolos Atasan Bidang (Menunggu Sekdir)
                                    if ($p->status == 'Menunggu Sekdir') {
                                        $show = true;
                                    }
                                } elseif ($role_aktif == 4) {
                                    // Direktur: melihat yang sudah disetujui Sekdir (Menunggu Direktur)
                                    if ($p->status == 'Menunggu Direktur') {
                                        $show = true;
                                    }
                                } elseif ($role_aktif == 5) {
                                    // Admin SDM: melihat semua yang sedang menunggu
                                    if (in_array($p->status, ['Menunggu', 'Menunggu Atasan', 'Menunggu Sekdir', 'Menunggu Direktur'])) {
                                        $show = true;
                                    }
                                } else {
                                    // Atasan Bidang lainnya
                                    if (($p->status == 'Menunggu' || $p->status == 'Menunggu Atasan') && $p->atasan_bidang == $user->name) {
                                        $show = true;
                                    }
                                }

                                if (!$show) {
                                    continue;
                                }

                                $ada_data_menunggu = true;

                                // Badge warna berdasarkan status
                                switch ($p->status) {
                                    case 'Menunggu Atasan':
                                    case 'Menunggu':
                                        $badge_color = '#FFF3CD'; $badge_text = '#856404'; $badge_label = 'Menunggu Atasan';
                                        break;
                                    case 'Menunggu Sekdir':
                                        $badge_color = '#CCE5FF'; $badge_text = '#004085'; $badge_label = 'Menunggu Sekdir';
                                        break;
                                    case 'Menunggu Direktur':
                                        $badge_color = '#D4EDDA'; $badge_text = '#155724'; $badge_label = 'Menunggu Direktur';
                                        break;
                                    default:
                                        $badge_color = '#E2E3E5'; $badge_text = '#383D41'; $badge_label = $p->status;
                                }

                                // ✅ AMAN DARI NULL DATE
                                $tgl_mulai   = !empty($p->tanggal_mulai) ? $p->tanggal_mulai : date('Y-m-d');
                                $tgl_selesai = !empty($p->tanggal_selesai) ? $p->tanggal_selesai : date('Y-m-d');

                                // ✅ HITUNG DURASI AMAN
                                $start = new DateTime($tgl_mulai);
                                $end   = new DateTime($tgl_selesai);
                                $durasi = $start->diff($end)->days + 1;
                                ?>

                                <tr style="border-bottom: 1px solid #f8f9fc;">

                                    <td class="align-middle text-center px-4 font-weight-bold">
                                        <?= $no++; ?>
                                    </td>

                                    <!-- ✅ DATA USER -->
                                    <td class="align-middle">
                                        <div style="font-weight: bold; color: #333;">
                                            <?= htmlspecialchars($p->name); ?>
                                        </div>
                                        <div style="font-size: 0.8rem; color: #888;">
                                            <i class="far fa-id-card mr-1"></i>
                                            <?= htmlspecialchars($p->nip); ?>
                                        </div>
                                        <span style="font-size:0.7rem; background:<?= $badge_color; ?>; color:<?= $badge_text; ?>; padding:2px 8px; border-radius:10px; font-weight:600;">
                                            <?= $badge_label; ?>
                                        </span>
                                    </td>

                                    <!-- ✅ DURASI -->
                                    <td class="align-middle">
                                        <div style="background:#E0F7FA; padding:3px 10px; border-radius:15px; font-size:0.75rem; font-weight:bold;">
                                            <?= $durasi; ?> Hari
                                        </div>
                                        <div style="font-size:0.85rem;">
                                            <?= date('d M', strtotime($tgl_mulai)); ?> -
                                            <?= date('d M Y', strtotime($tgl_selesai)); ?>
                                        </div>
                                    </td>

                                    <!-- ✅ KETERANGAN -->
                                    <td class="align-middle">
                                        <div style="background:#E6F0FF; padding:3px 10px; border-radius:15px; font-size:0.75rem; font-weight:bold;">
                                            <?= htmlspecialchars($p->jenis_cuti); ?>
                                        </div>
                                        <div class="text-truncate" style="max-width:250px; font-style:italic;">
                                            "<?= htmlspecialchars($p->keterangan); ?>"
                                        </div>
                                    </td>

                                    <!-- ✅ AKSI -->
                                    <td class="align-middle text-center px-4">
                                        <a href="<?= base_url('cuti/approvalform/' . $p->id_cuti); ?>"
                                            class="btn btn-sm shadow-sm px-3 py-1 font-weight-bold"
                                            style="background-color:#003366; color:white; border-radius:20px;">
                                            <i class="fas fa-edit mr-1"></i> Proses
                                        </a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                            <!-- ✅ KALAU TIDAK ADA YANG MENUNGGU -->
                            <?php if (!$ada_data_menunggu) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        Tidak ada pengajuan yang perlu diproses.
                                    </td>
                                </tr>
                            <?php endif; ?>

                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Tidak ada data pengajuan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
            </div>
        </div>
    </div>
</div>