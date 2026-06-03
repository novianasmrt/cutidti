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
                <i class="fas fa-history mr-2"></i> Daftar Riwayat Cuti
            </h6>

            <form action="<?= base_url('cuti/riwayat'); ?>" method="get" class="form-inline">
                <div class="input-group shadow-sm" style="border-radius: 20px;">

                    <input type="date" name="tanggal" class="form-control bg-light border-0 small"
                        aria-label="Search"
                        value="<?= $this->input->get('tanggal'); ?>"
                        style="border-top-left-radius: 20px; border-bottom-left-radius: 20px; color: #6e707e; height: 38px;">

                    <div class="input-group-append">
                        <button class="btn" type="submit" style="background-color: #003366; color: white; border-top-right-radius: 20px; border-bottom-right-radius: 20px; padding-left: 15px; padding-right: 15px;">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
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

                <table class="table table-hover text-nowrap mb-0" width="100%" cellspacing="0" style="color: #333;">

                    <thead style="background-color: #f8f9fc; color: #003366; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">
                        <tr>
                            <th class="py-3 px-4 text-center" style="border-top: none; border-bottom: 1px solid #e3e6f0;">No</th>
                            <th class="py-3" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Tgl Pengajuan</th>
                            <th class="py-3" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Mulai Cuti</th>
                            <th class="py-3" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Selesai Cuti</th>
                            <th class="py-3" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Tgl Masuk</th>
                            <th class="py-3" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Keterangan</th>
                            <th class="py-3 text-center" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Status</th>
                            <th class="py-3 px-4 text-center" style="border-top: none; border-bottom: 1px solid #e3e6f0;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($riwayat_cuti)) : ?>
                            <?php $no = 1; ?>
                            <?php foreach ($riwayat_cuti as $r) : ?>
                                <tr style="border-bottom: 1px solid #f8f9fc;">

                                    <td class="align-middle text-center px-4 font-weight-bold">
                                        <?= $no++; ?>
                                    </td>

                                    <td><?= date('d M Y', strtotime($r->tanggal_input ?? $r->tgl_pengajuan ?? '-')); ?></td>
                                    <td><?= date('d M Y', strtotime($r->tanggal_mulai ?? '-')); ?></td>
                                    <td><?= date('d M Y', strtotime($r->tanggal_selesai ?? '-')); ?></td>
                                    <td><?= date('d M Y', strtotime($r->tgl_masuk ?? $r->tanggal_masuk ?? '-')); ?></td>

                                    <td style="max-width:200px;">
                                        <?= htmlspecialchars($r->keterangan ?? $r->alasan ?? ''); ?>
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        if ($r->status == 'Disetujui') {
                                            $badge = "background:#E6FFFA;color:#006644;";
                                            $icon = "fa-check-circle";
                                        } elseif ($r->status == 'Ditolak') {
                                            $badge = "background:#FFE6E6;color:#CC0000;";
                                            $icon = "fa-times-circle";
                                        } else {
                                            $badge = "background:#FFF7E6;color:#CC8800;";
                                            $icon = "fa-clock";
                                        }
                                        ?>
                                        <span class="badge px-3 py-2" style="border-radius:20px; <?= $badge ?>">
                                            <i class="fas <?= $icon ?>"></i> <?= $r->status; ?>
                                        </span>
                                    </td>

                                    <td class="align-middle text-center" style="min-width: 100px;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="<?= base_url('cuti/detail/' . $r->id_cuti); ?>"
                                                title="Detail Cuti"
                                                style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; margin: 0 4px; text-decoration: none; border: none; background-color: #E6F0FF; color: #003366; transition: all 0.2s;">
                                                <i class="fas fa-eye fa-sm"></i>
                                            </a>
                                            <?php if ($r->status == 'Disetujui') : ?>
                                                <a href="<?= base_url('admin/cetaksurat/' . $r->id_cuti); ?>"
                                                    target="_blank"
                                                    title="Cetak Surat"
                                                    style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; margin: 0 4px; text-decoration: none; border: none; background-color: #E6FFFA; color: #006644; transition: all 0.2s;">
                                                    <i class="fas fa-print fa-sm"></i>
                                                </a>
                                            <?php else : ?>
                                                <button type="button"
                                                    disabled
                                                    title="Belum Disetujui"
                                                    style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; margin: 0 4px; border: none; background-color: #f1f3f9; color: #b7b9cc; cursor: not-allowed;">
                                                    <i class="fas fa-print fa-sm"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    Belum ada riwayat cuti
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>