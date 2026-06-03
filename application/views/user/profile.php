<div class="container-fluid" style="padding: 20px 30px;">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>

    <div class="row">

        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
                <div class="card-body text-center" style="padding: 3rem 2rem;">

                    <div class="mb-4 mx-auto" style="width: 180px; height: 180px; position: relative;">
                        <img src="<?= base_url('assets/img/profile/' . $user->image) . '?v=' . time(); ?>"
                            class="img-fluid rounded-circle shadow-sm"
                            alt="Foto Profil"
                            style="width: 100%; height: 100%; object-fit: cover; border: 5px solid #f8f9fc;">
                    </div>

                    <h4 class="font-weight-bold text-gray-800 mb-1"><?= $user->name; ?></h4>
                    <p class="text-muted mb-4"><?= $user->jabatan; ?></p>

                    <a href="<?= base_url('user/editprofile/'); ?>" class="btn btn-block shadow-sm font-weight-bold py-2 mb-2"
                        style="background-color: #003366; color: white; border-radius: 10px;">
                        <i class="fas fa-user-edit mr-2"></i> Edit Profil
                    </a>
                    
                    <a href="<?= base_url('user/changepassword/'); ?>" class="btn btn-block shadow-sm font-weight-bold py-2"
                        style="background-color: #f8f9fc; color: #003366; border: 1px solid #d1d3e2; border-radius: 10px;">
                        <i class="fas fa-key mr-2"></i> Ubah Password
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h6 class="m-0 font-weight-bold" style="color: #003366;">
                        <i class="fas fa-id-card mr-2"></i> Detail Data Pegawai
                    </h6>
                </div>

                <div class="card-body" style="padding: 2rem;">

                    <h6 class=" font-weight-bold text-uppercase mb-3" style="color: #003366; font-size: 0.9rem; letter-spacing: 1px;">
                        Informasi Akun
                    </h6>

                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Nama Lengkap</div>
                        <div class="col-sm-8 text-gray-800 font-weight-bold">: <?= $user->name; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Email</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->email; ?></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 label-profile">Nomor Telepon</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->no_telpon; ?></div>
                    </div>

                    <hr class="sidebar-divider my-4">

                    <h6 class=" font-weight-bold text-uppercase mb-3" style="color: #003366; font-size: 0.9rem; letter-spacing: 1px;">
                        Data Kepegawaian
                    </h6>

                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Kode Resmi NIU</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->nip; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Jenis Pegawai</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->jenis_pegawai; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Kategori</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->kategori; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Tipe Pegawai</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->tipe_pegawai; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Unit Kerja</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->unit_kerja; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Jabatan</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->jabatan; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 label-profile">Pangkat / Golongan</div>
                        <div class="col-sm-8 text-gray-800">: <?= $user->pangkat; ?><br>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .label-profile {
        font-weight: 600;
        color: #5a5c69;
        /* Warna abu-abu SB Admin 2 */
        margin-bottom: 0.5rem;
        /* Jarak di mobile */
    }

    /* Pada layar Desktop, hilangkan margin bawah label agar sejajar */
    @media (min-width: 576px) {
        .label-profile {
            margin-bottom: 0;
        }
    }
</style>