<div class="container-fluid" style="padding: 20px 30px;">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>

    <div class="row">

        <div class="col-xl-7 col-lg-7">
            <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h6 class="m-0 font-weight-bold" style="color: #003366;">
                        <i class="fas fa-file-alt mr-2"></i> Informasi Pengajuan
                    </h6>

                    <?php
                    $bg_badge = '#fff3cd';
                    $txt_badge = '#856404'; // Default Kuning
                    if ($cuti->status == 'Disetujui') {
                        $bg_badge = '#d1e7dd';
                        $txt_badge = '#0f5132';
                    } elseif ($cuti->status == 'Ditolak') {
                        $bg_badge = '#f8d7da';
                        $txt_badge = '#842029';
                    }
                    ?>
                    <span class="badge px-3 py-2 rounded-pill font-weight-bold" style="background-color: <?= $bg_badge; ?>; color: <?= $txt_badge; ?>; font-size: 0.85rem;">
                        <?= $cuti->status; ?>
                    </span>
                </div>

                <div class="card-body" style="padding: 2rem;">

                    <div class="form-row mb-4">
                        <div class="col-md-6">
                            <label class="small font-weight-bold text-gray-600">Jenis Cuti</label>
                            <input type="text" class="form-control" value="<?= $cuti->jenis_cuti; ?>"
                                style="background-color: #f8f9fc; border: 1px solid #e3e6f0; color: #1f2937; font-weight: 600;" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="small font-weight-bold text-gray-600">Tanggal Pengajuan</label>
                            <input type="text" class="form-control" value="<?= date('d F Y', strtotime($cuti->tgl_pengajuan)); ?>"
                                style="background-color: #f8f9fc; border: 1px solid #e3e6f0;" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-4">
                            <label class="small font-weight-bold text-gray-600">Mulai Cuti</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0 text-primary"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control border-left-0" value="<?= date('d M Y', strtotime($cuti->tanggal_mulai)); ?>" readonly style="background-color: #fff;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="small font-weight-bold text-gray-600">Selesai Cuti</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0 text-primary"><i class="fas fa-calendar-check"></i></span>
                                </div>
                                <input type="text" class="form-control border-left-0" value="<?= date('d M Y', strtotime($cuti->tanggal_selesai)); ?>" readonly style="background-color: #fff;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="small font-weight-bold text-gray-600">Masuk Kerja</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0 text-success"><i class="fas fa-briefcase"></i></span>
                                </div>
                                <input type="text" class="form-control border-left-0" value="<?= date('d M Y', strtotime($cuti->tanggal_masuk)); ?>" readonly style="background-color: #fff;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-gray-600">Keterangan / Alasan</label>
                        <textarea class="form-control" rows="4" readonly style="background-color: #f8f9fc; border: 1px solid #e3e6f0; color: #1f2937;"><?= $cuti->keterangan; ?></textarea>
                    </div>
                    
                    <?php if (!empty($cuti->ket_approval)) : ?>
                    <div class="form-group mb-0 mt-4">
                        <label class="small font-weight-bold text-gray-600">Catatan dari Atasan</label>
                        <textarea class="form-control" rows="3" readonly style="background-color: #fff3cd; border: 1px solid #ffe69c; color: #856404;"><?= $cuti->ket_approval; ?></textarea>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
                <div class="card-header py-3" style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h6 class="m-0 font-weight-bold" style="color: #003366;">
                        <i class="fas fa-paperclip mr-2"></i> Lampiran Dokumen
                    </h6>
                </div>
                <div class="card-body text-center p-4">

                    <?php if (!empty($cuti->lampiran)) : ?>
                        <div class="mb-4" style="border: 2px dashed #d1d5db; border-radius: 10px; padding: 20px; background: #f9fafb;">
                            <i class="fas fa-file-pdf fa-4x text-danger mb-3 mt-2"></i>
                            <p class="font-weight-bold text-gray-800 mb-1"><?= $cuti->lampiran; ?></p>
                            <p class="small text-gray-500 mb-3">Klik tombol di bawah untuk melihat detail</p>

                            <a href="<?= base_url('assets/lampiran/' . $cuti->lampiran); ?>" target="_blank" class="btn btn-primary btn-block shadow-sm" style="background-color: #003366; border: none;">
                                <i class="fas fa-external-link-alt mr-1"></i> Buka / Download Dokumen
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="py-5">
                            <i class="fas fa-folder-open fa-4x text-gray-300 mb-3"></i>
                            <p class="text-gray-500 font-weight-bold">Tidak ada dokumen lampiran.</p>
                        </div>
                    <?php endif; ?>

                    <hr class="my-4">
                    <a href="<?= base_url('cuti/riwayat'); ?>" class="btn btn-block shadow-sm py-2"
                        style="background-color: #e2e6ea; color: #4b5563; font-weight: 600; border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>