<div class="container-fluid" style="padding: 20px 30px;">

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fc !important;
        }
        .table-hover tbody tr:hover td {
            color: #000000 !important;
        }
    </style>

    <!-- CARD FILTER -->
    <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
        <div class="card-header py-4 bg-white"
            style="border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h6 class="m-0 font-weight-bold" style="color: #003366; font-size: 1.1rem;">
                <i class="fas fa-filter mr-2"></i>Filter Data Laporan
            </h6>
        </div>
        <div class="card-body py-4">
            <form action="<?= base_url('admin/laporan'); ?>" method="get">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="small font-weight-bold text-gray-600 ml-1">DARI TANGGAL</label>
                        <input type="date" name="tgl_awal" class="form-control border-0 small bg-light shadow-sm"
                            value="<?= $this->input->get('tgl_awal'); ?>"
                            style="border-radius: 20px; height: 38px; padding-left: 16px; color: #6e707e;">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="small font-weight-bold text-gray-600 ml-1">SAMPAI TANGGAL</label>
                        <input type="date" name="tgl_akhir" class="form-control border-0 small bg-light shadow-sm"
                            value="<?= $this->input->get('tgl_akhir'); ?>"
                            style="border-radius: 20px; height: 38px; padding-left: 16px; color: #6e707e;">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="small font-weight-bold text-gray-600 ml-1">STATUS CUTI</label>
                        <select name="status" class="form-control border-0 small bg-light shadow-sm"
                            style="border-radius: 20px; height: 38px; padding-left: 16px; color: #6e707e;">
                            <option value="">- Semua Status -</option>
                            <option value="Disetujui" <?= $f_status == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                            <option value="Menunggu"  <?= $f_status == 'Menunggu'  ? 'selected' : '' ?>>Menunggu</option>
                            <option value="Ditolak"   <?= $f_status == 'Ditolak'   ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-block shadow-sm font-weight-bold"
                            style="background-color: #003366; color: white; border-radius: 20px; height: 38px;">
                            <i class="fas fa-search mr-2"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    $params = http_build_query([
        'tgl_awal'  => $this->input->get('tgl_awal'),
        'tgl_akhir' => $this->input->get('tgl_akhir'),
        'status'    => $f_status
    ]);
    ?>

    <!-- CARD HASIL -->
    <div class="card shadow mb-4" style="border: none; border-radius: 15px;">

        <div class="card-header py-4 d-flex align-items-center justify-content-between"
            style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">

            <h6 class="m-0 font-weight-bold text-nowrap mr-3" style="color: #003366; font-size: 1.1rem;">
                <i class="fas fa-table mr-2"></i>Hasil Data Laporan
                <span class="text-muted font-weight-normal" style="font-size: 0.85rem; margin-left: 6px;">
                    — <?= ($f_status == '') ? 'Semua Status' : $f_status; ?>
                    (<?= count($laporan); ?> data)
                </span>
            </h6>

            <div class="d-flex flex-nowrap">
                <a href="<?= base_url('admin/excel?' . $params); ?>"
                    class="btn shadow-sm mr-2 font-weight-bold"
                    style="background-color: #d1e7dd; color: #0f5132; border-radius: 2rem; padding: 0.4rem 1.2rem; font-size: 0.85rem; border: none;">
                    <i class="fas fa-file-excel mr-1"></i> Excel
                </a>
                <a href="<?= base_url('admin/pdf?' . $params); ?>" target="_blank"
                    class="btn shadow-sm font-weight-bold"
                    style="background-color: #f8d7da; color: #842029; border-radius: 2rem; padding: 0.4rem 1.2rem; font-size: 0.85rem; border: none;">
                    <i class="fas fa-file-pdf mr-1"></i> PDF
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0" width="100%" cellspacing="0" style="color: #000000;">
                    <thead style="background-color: #f8f9fc; color: #003366; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">
                        <tr>
                            <th class="py-3 px-4 text-center border-0" width="5%">No</th>
                            <th class="py-3 border-0">Pegawai</th>
                            <th class="py-3 border-0">Keterangan</th>
                            <th class="py-3 text-center border-0">Durasi &amp; Tanggal</th>
                            <th class="py-3 text-center border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($laporan)) : ?>
                            <?php $no = 1; foreach ($laporan as $lap) : ?>
                                <?php
                                $tgl_mulai   = $lap->tanggal_mulai ?? $lap->tgl_mulai   ?? null;
                                $tgl_selesai = $lap->tanggal_selesai ?? $lap->tgl_selesai ?? null;

                                // Badge status
                                $bg  = '#fff3cd'; $txt = '#856404';
                                if ($lap->status == 'Disetujui')     { $bg = '#d1e7dd'; $txt = '#0f5132'; }
                                elseif ($lap->status == 'Ditolak')   { $bg = '#f8d7da'; $txt = '#842029'; }
                                elseif ($lap->status == 'Ditangguhkan') { $bg = '#eaecf4'; $txt = '#5a5c69'; }
                                ?>
                                <tr style="border-bottom: 1px solid #f0f1f5;">

                                    <td class="align-middle text-center px-4 font-weight-bold text-gray-600"><?= $no++; ?></td>

                                    <td class="align-middle">
                                        <div class="font-weight-bold" style="font-size: 0.95rem; color: #1f2937;"><?= $lap->nama ?? $lap->name ?? '-'; ?></div>
                                        <div class="small text-muted mt-1"><i class="far fa-id-card mr-1"></i><?= $lap->nip ?? '-'; ?></div>
                                    </td>

                                    <td class="align-middle">
                                        <span class="badge badge-light border text-gray-600 mb-1"><?= $lap->jenis_cuti; ?></span><br>
                                        <?php if (!empty($lap->keterangan) && $lap->keterangan != '-') : ?>
                                            <small class="text-gray-600 font-italic">"<?= substr($lap->keterangan, 0, 35); ?><?= strlen($lap->keterangan) > 35 ? '...' : ''; ?>"</small>
                                        <?php else : ?>
                                            <small class="text-gray-300">-</small>
                                        <?php endif; ?>
                                    </td>

                                    <td class="align-middle text-center">
                                        <span class="badge badge-light border mb-1 shadow-sm" style="color: #4e73df; background-color: #f0f4ff;">
                                            <?= $lap->jumlah_cuti ?? $lap->lama ?? '?'; ?> Hari
                                        </span>
                                        <div style="font-size: 0.85rem; font-weight: 600; color: #4b5563;">
                                            <?= $tgl_mulai ? date('d M', strtotime($tgl_mulai)) : '-'; ?>
                                            -
                                            <?= $tgl_selesai ? date('d M Y', strtotime($tgl_selesai)) : '-'; ?>
                                        </div>
                                    </td>

                                    <td class="align-middle text-center">
                                        <span class="badge px-3 py-2 rounded-pill font-weight-bold shadow-sm"
                                            style="background-color: <?= $bg; ?>; color: <?= $txt; ?>; font-size: 0.75rem;">
                                            <?= $lap->status; ?>
                                        </span>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-gray-500">
                                    <i class="fas fa-folder-open fa-3x mb-3" style="opacity: 0.3;"></i><br>
                                    Tidak ada data ditemukan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>