<div class="container-fluid" style="padding: 20px 30px;">

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fc !important;
        }

        .table-hover tbody tr:hover td {
            color: #003366 !important;
        }
    </style>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="<?= base_url('admin/tambahstaff'); ?>" class="btn shadow-sm text-white"
            style="background-color: #003366; border-radius: 2rem; padding: 0.6rem 1.5rem;">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Tambah Staff
        </a>
    </div>

    <div class="card shadow mb-4"
        style="border: none; border-radius: 1rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); background: #fff;">

        <div class="card-header py-3 bg-white"
            style="border-radius: 1rem 1rem 0 0; border-bottom: 1px solid #e3e6f0;">

            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold" style="color: #003366;">
                    <i class="fas fa-users mr-2"></i> Daftar Pegawai
                </h6>

                <form action="<?= base_url('admin/datastaff'); ?>" method="get" class="form-inline">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            name="keyword"
                            placeholder="Cari nama, email..."
                            autocomplete="off"
                            value="<?= isset($keyword) ? $keyword : ''; ?>"
                            style="border-radius: 20px 0 0 20px;">

                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" style="background-color: #003366; border-color: #003366; border-radius: 0 20px 20px 0;">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>

                    <?php if (!empty($keyword)) : ?>
                        <a href="<?= base_url('admin/datastaff'); ?>" class="btn btn-sm btn-link text-danger ml-2" title="Hapus Pencarian">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush" id="dataTable" width="100%" cellspacing="0">

                    <thead style="background-color: #f8f9fc;">
                        <tr>
                            <th style="border-top: none; border-bottom: 2px solid #e3e6f0; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; color: #003366; padding: 1.2rem 1rem; padding-left: 2rem;">Profil Pegawai</th>
                            <th style="border-top: none; border-bottom: 2px solid #e3e6f0; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; color: #003366; padding: 1.2rem 1rem;">Jabatan & Role</th>
                            <th style="border-top: none; border-bottom: 2px solid #e3e6f0; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; color: #003366; padding: 1.2rem 1rem; width: 25%;">Sisa Cuti Tahunan</th>
                            <th style="border-top: none; border-bottom: 2px solid #e3e6f0; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; color: #003366; padding: 1.2rem 1rem;">Status</th>
                            <th class="text-center" style="border-top: none; border-bottom: 2px solid #e3e6f0; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; color: #003366; padding: 1.2rem 1rem;">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($staff)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-gray-300"></i><br>
                                    Belum ada data pegawai.
                                </td>
                            </tr>
                        <?php else : ?>

                            <?php foreach ($staff as $s) : ?>
                                <?php
                                // ✅ ID FIX (pakai id_user)
                                $id_user = $s->id_user ?? null;

                                // ✅ Sisa cuti
                                $jatah_cuti = 12;
                                $sisa_cuti = $s->sisa_cuti ?? 12;
                                $persen = ($jatah_cuti > 0) ? ($sisa_cuti / $jatah_cuti) * 100 : 0;

                                // ✅ Warna progress
                                if ($sisa_cuti <= 3) {
                                    $warna_bar = 'bg-danger';
                                } elseif ($sisa_cuti <= 6) {
                                    $warna_bar = 'bg-warning';
                                } else {
                                    $warna_bar = 'bg-success';
                                }

                                // ✅ Foto
                                $pake_icon = empty($s->image) || $s->image == 'default.jpg';
                                ?>

                                <tr>

                                    <!-- ================= PROFIL ================= -->
                                    <td style="vertical-align: middle; padding-left: 2rem;">
                                        <div class="d-flex align-items-center">

                                            <?php if ($pake_icon) : ?>
                                                <div class="mr-3"
                                                    style="width:50px;height:50px;border-radius:50%;background:#E6F0FF;color:#003366;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            <?php else : ?>
                                                <div class="mr-3" style="width:50px;height:50px;border-radius:50%;overflow:hidden;">
                                                    <img src="<?= base_url('assets/img/profile/') . $s->image; ?>" style="width:100%;height:100%;object-fit:cover;">
                                                </div>
                                            <?php endif; ?>

                                            <div>
                                                <div class="font-weight-bold"><?= $s->name ?? '-'; ?></div>
                                                <div class="small text-muted"><?= $s->email ?? '-'; ?></div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- ================= JABATAN ================= -->
                                    <td>
                                        <div class="font-weight-bold">
                                            <?= $s->jabatan ?? '-'; ?>
                                        </div>

                                        <div class="mt-1">
                                            <?php if (($s->role_id ?? 2) == 1) : ?>
                                                <span style="background:#E6F0FF;color:#003366;padding:5px 12px;border-radius:20px;font-size:0.7rem;">
                                                    Administrator
                                                </span>
                                            <?php else : ?>
                                                <span style="background:#F1F3F9;color:#5A5C69;padding:5px 12px;border-radius:20px;font-size:0.7rem;">
                                                    Staff
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- ================= CUTI ================= -->
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span><b><?= $sisa_cuti; ?> Hari</b></span>
                                            <small>dari <?= $jatah_cuti; ?></small>
                                        </div>

                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar <?= $warna_bar; ?>" style="width: <?= $persen; ?>%"></div>
                                        </div>
                                    </td>

                                    <!-- ================= STATUS ================= -->
                                    <td>
                                        <?php if (($s->is_active ?? 1) == 1) : ?>
                                            <span style="background:#E6FFFA;color:#006644;padding:5px 12px;border-radius:20px;font-size:0.7rem;">
                                                Aktif
                                            </span>
                                        <?php else : ?>
                                            <span style="background:#FFE6E6;color:#CC0000;padding:5px 12px;border-radius:20px;font-size:0.7rem;">
                                                Non-Aktif
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- ================= AKSI ================= -->
                                    <td class="text-center">

                                        <?php if ($id_user) : ?>

                                            <!-- DETAIL -->
                                            <a href="<?= base_url('admin/detailstaff/' . $id_user); ?>"
                                                class="btn btn-sm"
                                                style="background:#E6F0FF;color:#003366;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- TOGGLE STATUS -->
                                            <?php if (($s->is_active ?? 1) == 1) : ?>

                                                <a href="<?= base_url('admin/ubah_status_staff/' . $id_user . '/0'); ?>"
                                                    onclick="return confirm('Nonaktifkan pegawai ini?')"
                                                    class="btn btn-sm"
                                                    style="background:#E6FFFA;color:#00CC99;">
                                                    <i class="fas fa-toggle-on"></i>
                                                </a>

                                            <?php else : ?>

                                                <a href="<?= base_url('admin/ubah_status_staff/' . $id_user . '/1'); ?>"
                                                    onclick="return confirm('Aktifkan kembali?')"
                                                    class="btn btn-sm"
                                                    style="background:#F1F3F5;color:#ADB5BD;">
                                                    <i class="fas fa-toggle-off"></i>
                                                </a>

                                            <?php endif; ?>

                                        <?php else : ?>
                                            <small class="text-danger">ID tidak ditemukan</small>
                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

            <div class="card-footer py-3 bg-white" style="border-radius: 0 0 1rem 1rem;"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>