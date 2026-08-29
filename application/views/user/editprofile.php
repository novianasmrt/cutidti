<div class="container-fluid" style="padding: 20px 30px;">
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <form action="<?= base_url('user/editprofile'); ?>" method="post" enctype="multipart/form-data">

        <div class="row">

            <!-- FOTO PROFILE -->
            <div class="col-xl-4 mb-4">
                <div class="card shadow" style="border-radius: 15px; border: none;">
                    <div class="card-header bg-white py-4" style="border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                        <h6 class="m-0 font-weight-bold" style="color: #003366; font-size: 1.1rem;">
                            <i class="fas fa-camera mr-2"></i>Foto Profil
                        </h6>
                    </div>

                    <div class="card-body text-center" style="padding: 2rem;">

                        <?php
                        $user_img = isset($user->image) ? $user->image : '';
                        $has_img = (!empty($user_img) && $user_img != 'default.jpg' && $user_img != 'default.png');
                        $inisial = substr($user->name, 0, 1);
                        ?>

                        <!-- PREVIEW FOTO -->
                        <div id="previewContainer" class="mx-auto mb-4" style="width: 180px; height: 180px; position: relative;">
                            <div id="previewInitial" class="rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                style="width: 100%; height: 100%; background-color: #E6F0FF; color: #003366; font-size: 5rem; font-weight: bold; border: 5px solid #f8f9fc; <?= $has_img ? 'display: none !important;' : '' ?>">
                                <?= strtoupper($inisial); ?>
                            </div>
                            <img id="previewFoto" src="<?= $has_img ? base_url('assets/img/profile/' . $user_img) : '' ?>"
                                class="rounded-circle shadow-sm"
                                style="width: 100%; height: 100%; object-fit: cover; border: 5px solid #f8f9fc; <?= !$has_img ? 'display: none !important;' : '' ?>">
                        </div>

                        <!-- INPUT FILE -->
                        <div class="form-group mb-0">
                            <div class="custom-file text-left">
                                <input type="file" name="image" id="customFile" class="custom-file-input" accept="image/*" style="cursor: pointer;">
                                <label class="custom-file-label" for="customFile" style="border-radius: 10px; color: #6e707e;">Pilih gambar...</label>
                            </div>
                            <small class="text-muted d-block mt-2">Format: JPG, JPEG, PNG (Max 2MB)</small>
                        </div>

                    </div>
                </div>
            </div>

            <!-- SCRIPT PREVIEW GAMBAR -->
            <script>
                document.getElementById("customFile").addEventListener("change", function(e) {
                    const file = e.target.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            document.getElementById('previewInitial').style.setProperty('display', 'none', 'important');
                            document.getElementById('previewFoto').style.setProperty('display', 'block', 'important');
                            document.getElementById('previewFoto').src = e.target.result;
                            
                            // Update label
                            let fileName = file.name;
                            document.querySelector('.custom-file-label').innerHTML = fileName;
                        }

                        reader.readAsDataURL(file);
                    }
                });
            </script>
            <!-- FORM -->
            <div class="col-xl-8">
                <div class="card shadow" style="border-radius: 15px; border: none;">
                    <div class="card-header bg-white py-4" style="border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                        <h6 class="m-0 font-weight-bold" style="color: #003366; font-size: 1.1rem;">
                            <i class="fas fa-user-edit mr-2"></i>Informasi Profil
                        </h6>
                    </div>

                    <div class="card-body" style="padding: 2rem;">

                        <style>
                            .label-form { font-size: 0.85rem; font-weight: bold; color: #5a5c69; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 8px; }
                            .input-form { border-radius: 10px; color: #6e707e; border: 1px solid #d1d3e2; padding: 0.6rem 1rem; height: auto; }
                            .input-form:focus { border-color: #003366; box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.25); }
                        </style>

                        <!-- NAMA -->
                        <div class="form-group mb-4">
                            <label class="label-form">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control input-form"
                                value="<?= $user->name; ?>">
                        </div>

                        <!-- EMAIL -->
                        <div class="form-group mb-4">
                            <label class="label-form">Email</label>
                            <input type="email" class="form-control input-form bg-light"
                                value="<?= $user->email; ?>" readonly>
                        </div>

                        <!-- TELEPON -->
                        <div class="form-group mb-4">
                            <label class="label-form">No Telepon</label>
                            <input type="text" name="no_telpon" class="form-control input-form"
                                value="<?= $user->no_telpon ?? ''; ?>">
                        </div>

                        <!-- NIU -->
                        <div class="form-group mb-4">
                            <label class="label-form">NIP / Kode Resmi NIU</label>
                            <input type="text" name="nip" class="form-control input-form"
                                value="<?= $user->nip ?? ''; ?>">
                        </div>
                        
                        <div class="row">
                            <!-- JENIS -->
                            <div class="col-md-6 form-group mb-4">
                                <label class="label-form">Jenis Pegawai</label>
                                <input type="text" name="jenis_pegawai" class="form-control input-form"
                                    value="<?= $user->jenis_pegawai ?? ''; ?>">
                            </div>
                            <!-- KATEGORI -->
                            <div class="col-md-6 form-group mb-4">
                                <label class="label-form">Kategori</label>
                                <input type="text" name="kategori" class="form-control input-form"
                                    value="<?= $user->kategori ?? ''; ?>">
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- TIPE -->
                            <div class="col-md-6 form-group mb-4">
                                <label class="label-form">Tipe Pegawai</label>
                                <input type="text" name="tipe_pegawai" class="form-control input-form"
                                    value="<?= $user->tipe_pegawai ?? ''; ?>">
                            </div>
                            <!-- UNIT -->
                            <div class="col-md-6 form-group mb-4">
                                <label class="label-form">Unit Kerja</label>
                                <input type="text" name="unit_kerja" class="form-control input-form"
                                    value="<?= $user->unit_kerja ?? ''; ?>">
                            </div>
                        </div>

                        <!-- JABATAN -->
                        <div class="form-group mb-4">
                            <label class="label-form">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control input-form"
                                value="<?= $user->jabatan ?? ''; ?>">
                        </div>

                        <!-- PANGKAT -->
                        <div class="form-group mb-5">
                            <label class="label-form">Pangkat / Golongan</label>
                            <input type="text" name="pangkat" class="form-control input-form"
                                value="<?= $user->pangkat ?? ''; ?>">
                        </div>

                        <div class="text-right border-top pt-4">
                            <a href="<?= base_url('user/profile'); ?>" class="btn btn-light shadow-sm font-weight-bold px-4 mr-2" style="border-radius: 50px;">
                                Batal
                            </a>
                            <button type="submit" class="btn shadow-sm font-weight-bold px-4" style="background-color: #003366; color: white; border-radius: 50px;">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
