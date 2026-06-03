<div class="container-fluid" style="padding: 20px 30px;">
    <div class="row">

        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
                <div class="card-body text-center" style="padding: 3rem 2rem;">

                    <?php
                    $foto = (!empty($staff->image) && $staff->image != 'default.jpg')
                        ? base_url('assets/img/profile/' . $staff->image)
                        : base_url('assets/img/profile/default.jpg');
                    ?>

                    <div class="mb-4 mx-auto" style="width: 180px; height: 180px; position: relative;">
                        <img src="<?= $foto; ?>"
                            class="img-fluid rounded-circle shadow-sm"
                            style="width: 100%; height: 100%; object-fit: cover; border: 5px solid #fff;">
                    </div>

                    <h4 class="font-weight-bold text-gray-900 mb-1">
                        <?= $staff->name ?? '-'; ?>
                    </h4>

                    <p class="font-weight-bold mb-4" style="color: #003366;">
                        <?= $staff->jabatan ?? 'Staff'; ?>
                    </p>

                    <div class="text-left mt-4">
                        <div class="p-3 mb-3 rounded" style="background-color: #f8f9fc; border-left: 4px solid #003366;">
                            <small class="text-gray-600 d-block font-weight-bold text-uppercase" style="font-size: 0.7rem;">Role</small>
                            <span class="text-gray-900 font-weight-bold">
                                <?= $staff->role ?? '-'; ?>
                            </span>
                        </div>

                        <div class="p-3 rounded" style="background-color: #f8f9fc; border-left: 4px solid #1cc88a;">
                            <small class="text-gray-600 d-block font-weight-bold text-uppercase">Status</small>
                            <span class="text-gray-900 font-weight-bold">
                                <?= ($staff->is_active == 1) ? 'Aktif' : 'Nonaktif'; ?>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" style="border: none; border-radius: 15px;">

                <div class="card-header py-3 d-flex justify-content-between"
                    style="background-color: #fff; border-bottom: 1px solid #e3e6f0;">
                    <h6 class="m-0 font-weight-bold" style="color: #003366;">
                        <i class="fas fa-id-card mr-2"></i> Biodata & Kepegawaian
                    </h6>
                </div>

                <div class="card-body" style="padding: 2rem;">

                    <h6 class="font-weight-bold text-uppercase mb-4">Informasi Kontak</h6>

                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4">Nama Lengkap</div>
                        <div class="col-sm-8"><?= $staff->name ?? '-'; ?></div>
                    </div>

                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4">Email</div>
                        <div class="col-sm-8"><?= $staff->email ?? '-'; ?></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4">No HP</div>
                        <div class="col-sm-8"><?= $staff->no_hp ?? '-'; ?></div>
                    </div>

                    <h6 class="font-weight-bold text-uppercase mb-4 mt-5">Data Administrasi</h6>

                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4">NIP</div>
                        <div class="col-sm-8"><?= $staff->nip ?? '-'; ?></div>
                    </div>

                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4">Jabatan</div>
                        <div class="col-sm-8"><?= $staff->jabatan ?? '-'; ?></div>
                    </div>

                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4">Sisa Cuti</div>
                        <div class="col-sm-8"><?= $staff->sisa_cuti ?? '0'; ?> Hari</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4">Role</div>
                        <div class="col-sm-8"><?= $staff->role ?? '-'; ?></div>
                    </div>

                    <hr class="my-4">

                    <a href="<?= base_url('admin/datastaff'); ?>"
                        class="btn btn-block py-2 font-weight-bold shadow-sm"
                        style="background-color: #e2e6ea; color: #4b5563; border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>