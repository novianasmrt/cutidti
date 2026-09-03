<div class="container-fluid" style="padding: 20px 30px;">

    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
        }
        .table-hover tbody tr:hover td {
            color: #1f2937 !important;
        }
        .btn-action-soft {
            width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: 8px; margin: 0 4px; text-decoration: none; border: none; transition: all 0.2s;
            background-color: transparent;
        }
        .btn-view { color: #3b82f6; } .btn-view:hover { background-color: #eff6ff; color: #2563eb; }
        .btn-edit { color: #f59e0b; } .btn-edit:hover { background-color: #fef3c7; color: #d97706; }
        .btn-toggle-on { color: #10b981; } .btn-toggle-on:hover { background-color: #d1fae5; color: #059669; }
        .btn-toggle-off { color: #9ca3af; } .btn-toggle-off:hover { background-color: #f3f4f6; color: #6b7280; }
    </style>

    <div class="card shadow mb-4" style="border: none; border-radius: 15px;">

        <div class="card-header py-4 d-flex flex-column flex-md-row align-items-center justify-content-between"
            style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">

            <h6 class="m-0 font-weight-bold mb-3 mb-md-0 w-100 text-center text-md-left" style="color: #003366; font-size: 1.1rem;">
                <i class="fas fa-users mr-2"></i>Daftar Pegawai
            </h6>

            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center w-100" style="max-width: 600px; justify-content: flex-end;">
                <form action="<?= base_url('admin/datastaff'); ?>" method="get" class="form-inline d-flex w-100 mb-2 mb-md-0 mr-md-3">
                    <div class="input-group shadow-sm w-100" style="border-radius: 20px;">
                        <input type="text" class="form-control border-0 small bg-light"
                            name="keyword"
                            placeholder="Cari nama, email..."
                            autocomplete="off"
                            value="<?= isset($keyword) ? $keyword : ''; ?>"
                            style="border-top-left-radius: 20px; border-bottom-left-radius: 20px; color: #6e707e; height: 38px;">
                        <div class="input-group-append">
                            <button class="btn" type="submit" style="background-color: #003366; color: white; border-top-right-radius: 20px; border-bottom-right-radius: 20px; padding-left: 20px; padding-right: 20px;">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                    <?php if (!empty($keyword)) : ?>
                        <a href="<?= base_url('admin/datastaff'); ?>" class="btn btn-sm btn-link text-danger ml-2" title="Reset">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    <?php endif; ?>
                </form>

                <a href="<?= base_url('admin/tambahstaff'); ?>" class="btn shadow-sm text-white w-100 text-nowrap"
                    style="background-color: #003366; border-radius: 2rem; padding: 0.5rem 1.4rem; font-size: 0.85rem; max-width: max-content;">
                    <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Staff
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0" width="100%" cellspacing="0" style="color: #000000;">
                    <thead style="background-color: #f9fafb; color: #6b7280; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-4 text-center border-0" width="5%">No</th>
                            <th class="py-3 border-0">Profil Pegawai</th>
                            <th class="py-3 border-0">Jabatan &amp; Role</th>
                            <th class="py-3 text-center border-0" width="20%">Sisa Cuti Tahunan</th>
                            <th class="py-3 text-center border-0">Status</th>
                            <th class="py-3 px-4 text-center border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (empty($staff)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-gray-500">
                                    <i class="fas fa-folder-open fa-3x mb-3" style="opacity: 0.3;"></i><br>
                                    Belum ada data pegawai.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach ($staff as $s) : ?>
                                <?php
                                $id_user    = $s->id_user ?? null;
                                $jatah_cuti = 12;
                                $sisa_cuti  = $s->sisa_cuti ?? 12;
                                $persen     = ($jatah_cuti > 0) ? ($sisa_cuti / $jatah_cuti) * 100 : 0;
                                $persen     = min($persen, 100);

                                if ($sisa_cuti <= 3)      { $warna_bar = 'bg-danger'; }
                                elseif ($sisa_cuti <= 6)  { $warna_bar = 'bg-warning'; }
                                else                       { $warna_bar = 'bg-success'; }

                                $pake_icon = empty($s->image) || $s->image == 'default.jpg';

                                $role_id = $s->role_id ?? 2;
                                switch ($role_id) {
                                    case 1:  $role_label = 'Administrator';        break;
                                    case 3:  $role_label = 'Sekretaris Direktur';  break;
                                    case 4:  $role_label = 'Direktur';             break;
                                    case 5:  $role_label = 'Admin SDM';            break;
                                    default: $role_label = 'Staff';                break;
                                }
                                $role_bg    = ($role_id == 2) ? '#F1F3F9' : '#E6F0FF';
                                $role_color = ($role_id == 2) ? '#5A5C69' : '#003366';
                                ?>

                                <tr style="border-bottom: 1px solid #f0f1f5;">

                                    <td class="align-middle text-center px-4 font-weight-bold text-gray-600"><?= $no++; ?></td>

                                    <!-- PROFIL -->
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <?php if ($pake_icon) : ?>
                                                <div class="mr-3" style="width:42px;height:42px;border-radius:50%;background:#E6F0FF;color:#003366;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    <i class="fas fa-user fa-sm"></i>
                                                </div>
                                            <?php else : ?>
                                                <div class="mr-3" style="width:42px;height:42px;border-radius:50%;overflow:hidden;flex-shrink:0;">
                                                    <img src="<?= base_url('assets/img/profile/') . $s->image; ?>" style="width:100%;height:100%;object-fit:cover;">
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div style="font-size: 0.9rem; font-weight: 600; color: #374151;"><?= $s->name ?? '-'; ?></div>
                                                <div class="small text-muted mt-1"><i class="far fa-envelope mr-1"></i><?= $s->email ?? '-'; ?></div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- JABATAN & ROLE -->
                                    <td class="align-middle">
                                        <div style="font-size: 0.85rem; font-weight: 500; color: #4b5563; white-space: normal; max-width: 280px;">
                                            <?= $s->jabatan ?? '-'; ?>
                                        </div>
                                        <div class="mt-1">
                                            <span style="background:<?= $role_bg; ?>;color:<?= $role_color; ?>;padding:4px 12px;border-radius:20px;font-size:0.7rem;font-weight:600;">
                                                <?= $role_label; ?>
                                            </span>
                                        </div>
                                    </td>

                                    <!-- SISA CUTI -->
                                    <td class="align-middle">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span><b><?= $sisa_cuti; ?> Hari</b></span>
                                            <small class="text-muted">dari <?= $jatah_cuti; ?></small>
                                        </div>
                                        <div class="progress" style="height: 6px; border-radius: 10px;">
                                            <div class="progress-bar <?= $warna_bar; ?>" style="width: <?= $persen; ?>%; border-radius: 10px;"></div>
                                        </div>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="align-middle text-center">
                                        <?php if (($s->is_active ?? 1) == 1) : ?>
                                            <span class="badge px-3 py-2 rounded-pill font-weight-bold shadow-sm" style="background-color: #d1e7dd; color: #0f5132; font-size: 0.75rem;">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge px-3 py-2 rounded-pill font-weight-bold shadow-sm" style="background-color: #f8d7da; color: #842029; font-size: 0.75rem;">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- AKSI -->
                                    <td class="align-middle text-center" style="min-width: 100px;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <?php if ($id_user) : ?>
                                                <a href="<?= base_url('admin/detailstaff/' . $id_user); ?>"
                                                    title="Detail Staff" class="btn-action-soft btn-view">
                                                    <i class="fas fa-eye fa-sm"></i>
                                                </a>

                                                <a href="<?= base_url('admin/editstaff/' . $id_user); ?>"
                                                    title="Edit Staff" class="btn-action-soft btn-edit">
                                                    <i class="fas fa-edit fa-sm"></i>
                                                </a>

                                                <?php if (($s->is_active ?? 1) == 1) : ?>
                                                    <a href="<?= base_url('admin/ubah_status_staff/' . $id_user . '/0'); ?>"
                                                        onclick="return confirm('Nonaktifkan pegawai ini?')"
                                                        title="Nonaktifkan" class="btn-action-soft btn-toggle-on">
                                                        <i class="fas fa-toggle-on fa-sm"></i>
                                                    </a>
                                                <?php else : ?>
                                                    <a href="<?= base_url('admin/ubah_status_staff/' . $id_user . '/1'); ?>"
                                                        onclick="return confirm('Aktifkan kembali?')"
                                                        title="Aktifkan" class="btn-action-soft btn-toggle-off">
                                                        <i class="fas fa-toggle-off fa-sm"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <small class="text-danger">ID tidak ditemukan</small>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('[data-toggle="tooltip"]').tooltip();

        // Fitur pencarian otomatis (Live Search DOM)
        const searchInput = document.querySelector('input[name="keyword"]');
        const form = searchInput.closest('form');
        const tableRows = document.querySelectorAll('tbody tr');
        const emptyRowTemplate = `
            <tr id="empty-search-row">
                <td colspan="6" class="text-center py-5 text-gray-500">
                    <i class="fas fa-search fa-3x mb-3" style="opacity: 0.3;"></i><br>
                    Data tidak ditemukan.
                </td>
            </tr>`;

        if (searchInput) {
            // Cegah form melakukan submit (reload halaman) saat dienter
            form.addEventListener('submit', function(e) {
                e.preventDefault();
            });

            // Filter saat user mengetik
            searchInput.addEventListener('input', function(e) {
                const keyword = this.value.toLowerCase();
                let hasVisibleRow = false;
                
                // Hapus pesan kosong sebelumnya jika ada
                const emptyMsg = document.getElementById('empty-search-row');
                if (emptyMsg) emptyMsg.remove();
                
                tableRows.forEach(row => {
                    // Lewati baris "Belum ada data" bawaan
                    if (row.querySelector('td[colspan]')) return;
                    
                    const text = row.textContent.toLowerCase();
                    if (text.includes(keyword)) {
                        row.style.display = '';
                        hasVisibleRow = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Jika tabel memiliki data tetapi hasil pencarian kosong, tampilkan pesan
                if (!hasVisibleRow && tableRows.length > 0 && !tableRows[0].querySelector('td[colspan]')) {
                    document.querySelector('tbody').insertAdjacentHTML('beforeend', emptyRowTemplate);
                }
            });
            
            // Trigger pencarian pertama kali jika ada value (misalnya dari URL sebelumnya)
            if(searchInput.value) {
                searchInput.dispatchEvent(new Event('input'));
            }
        }
    });
</script>