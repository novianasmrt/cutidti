<div class="container-fluid" style="padding: 20px 30px;">
    <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
        <div class="card-header py-3 bg-white" style="border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h6 class="m-0 font-weight-bold" style="color: #003366;">
                <i class="fas fa-filter mr-2"></i> Filter Data Laporan
            </h6>
        </div>
        <div class="card-body py-4">
            <form action="<?= base_url('admin/laporan'); ?>" method="get">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="small font-weight-bold text-gray-600 ml-2">DARI TANGGAL</label>
                        <input type="date" name="tgl_awal" class="form-control bg-light border-0 shadow-sm"
                            value="<?= $this->input->get('tgl_awal'); ?>" style="border-radius: 30px; height: 45px; padding-left: 20px; color: #495057;">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="small font-weight-bold text-gray-600 ml-2">SAMPAI TANGGAL</label>
                        <input type="date" name="tgl_akhir" class="form-control bg-light border-0 shadow-sm"
                            value="<?= $this->input->get('tgl_akhir'); ?>" style="border-radius: 30px; height: 45px; padding-left: 20px; color: #495057;">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="small font-weight-bold text-gray-600 ml-2">STATUS CUTI</label>
                        <select name="status" class="form-control bg-light border-0 shadow-sm" style="border-radius: 30px; height: 45px; padding-left: 20px; color: #495057;">
                            <option value="">- Semua Status -</option>
                            <option value="Disetujui" <?= $f_status == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                            <option value="Menunggu" <?= $f_status == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                            <option value="Ditolak" <?= $f_status == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-block shadow font-weight-bold"
                            style="background-color: #003366; color: white; border-radius: 30px; height: 45px; transition: 0.2s;">
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

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background-color: #fff;">
                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between py-3" style="border-left: 5px solid #003366; border-radius: 10px;">
                    <div class="mb-3 mb-md-0" style="color: #1f2937;">
                        <i class="fas fa-info-circle mr-2 text-primary"></i>
                        Data Laporan: <strong><?= ($f_status == '') ? 'Semua Status' : $f_status; ?></strong>
                    </div>
                    <div>
                        <a href="<?= base_url('admin/excel?' . $params); ?>" class="btn shadow-sm mr-2 font-weight-bold px-4"
                            style="background-color: #d1e7dd; color: #0f5132; border-radius: 10px; border: none; transition: 0.2s;">
                            <i class="fas fa-file-excel mr-2"></i> Excel
                        </a>
                        <a href="<?= base_url('admin/pdf?' . $params); ?>" target="_blank" class="btn shadow-sm font-weight-bold px-4"
                            style="background-color: #f8d7da; color: #842029; border-radius: 10px; border: none; transition: 0.2s;">
                            <i class="fas fa-file-pdf mr-2"></i> PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fc !important;
        }

        .table-hover tbody tr:hover td {
            color: #000000 !important;
        }

        .btn[href*="Excel"]:hover {
            background-color: #badbcc !important;
            transform: translateY(-2px);
        }

        .btn[href*="PDF"]:hover {
            background-color: #f5c2c7 !important;
            transform: translateY(-2px);
        }
    </style>

    <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
        <div class="card-header py-3 bg-white" style="border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h6 class="m-0 font-weight-bold" style="color: #003366;"><i class="fas fa-table mr-2"></i> Hasil Data</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0" width="100%" cellspacing="0" style="color: #000;">
                    <thead style="background-color: #f8f9fc; color: #003366; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">
                        <tr>
                            <th class="py-3 px-4 text-center border-0" width="5%">No</th>
                            <th class="py-3 border-0">Nama Pegawai</th>
                            <th class="py-3 border-0">Jenis Cuti</th>
                            <th class="py-3 text-center border-0">Tanggal Cuti</th>
                            <th class="py-3 text-center border-0">Lama Cuti</th>
                            <th class="py-3 text-center border-0">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($laporan)) : ?>
                            <?php $no = 1;
                            foreach ($laporan as $lap) : ?>
                                <tr style="border-bottom: 1px solid #f0f1f5;">
                                    <td class="align-middle text-center text-gray-600 px-4"><?= $no++; ?></td>
                                    <td class="align-middle text-gray-600"><?= $lap->nama; ?></td>
                                    <td class="align-middle text-gray-600"><?= $lap->jenis_cuti; ?></td>
                                    <td class="align-middle text-center " style="color: #5a5c69;">
                                        <?= date('d M', strtotime($lap->tanggal_mulai ?? $lap->tgl_mulai)); ?> - <?= date('d M Y', strtotime($lap->tanggal_selesai ?? $lap->tgl_selesai)); ?>
                                    </td>
                                    <td class="align-middle text-center text-gray-600"><?= $lap->jumlah_cuti ?? $lap->lama; ?> Hari</td>
                                    <td class="align-middle text-center">
                                        <?php
                                        $bg = '#fff3cd';
                                        $txt = '#856404';
                                        if ($lap->status == 'Disetujui') {
                                            $bg = '#d1e7dd';
                                            $txt = '#0f5132';
                                        } elseif ($lap->status == 'Ditolak') {
                                            $bg = '#f8d7da';
                                            $txt = '#842029';
                                        }
                                        ?>
                                        <span class="badge px-3 py-2 rounded-pill font-weight-bold shadow-sm" style="background-color: <?= $bg; ?>; color: <?= $txt; ?>; font-size: 0.75rem;"><?= $lap->status; ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-gray-500"><i class="fas fa-search fa-3x mb-3" style="opacity: 0.3;"></i><br>Tidak ada data ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>