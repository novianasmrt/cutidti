<div class="container-fluid" style="padding: 20px 30px;">
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?= form_open_multipart('admin/update_staff'); ?>
    <input type="hidden" name="id_user" value="<?= $staff->id_user; ?>">

    <div class="row">

        <!-- LEFT COLUMN: FOTO PROFILE & PREVIEW -->
        <div class="col-xl-4 mb-4">
            <div class="card card-modern shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-ugm">
                        <i class="fas fa-camera mr-2"></i> Foto Profil
                    </h6>
                </div>

                <div class="card-body text-center" style="padding: 2rem;">

                    <!-- PREVIEW FOTO -->
                    <div class="mb-4 mx-auto" style="width: 180px; height: 180px; position: relative;">
                        <?php if (empty($staff->image) || $staff->image == 'default.jpg' || $staff->image == 'default.png') : ?>
                            <?php 
                            $inisial = substr($staff->name ?? 'U', 0, 1); 
                            ?>
                            <div id="default-initial" class="rounded-circle shadow-sm d-flex justify-content-center align-items-center mx-auto" 
                                style="width: 100%; height: 100%; border: 5px solid #f8f9fc; background-color: #E6F0FF; color: #003366; font-size: 5rem; font-weight: bold; text-transform: uppercase;">
                                <?= $inisial; ?>
                            </div>
                            <img id="img-preview" src=""
                                class="img-fluid rounded-circle shadow-sm d-none"
                                style="width: 100%; height: 100%; object-fit: cover; border: 5px solid #fff; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;">
                        <?php else : ?>
                            <img id="img-preview" src="<?= base_url('assets/img/profile/' . $staff->image) . '?v=' . time(); ?>"
                                class="img-fluid rounded-circle shadow-sm"
                                style="width: 100%; height: 100%; object-fit: cover; border: 5px solid #fff; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;">
                        <?php endif; ?>
                    </div>

                    <h5 class="font-weight-bold text-gray-900 mb-1">
                        <?= $staff->name ?? '-'; ?>
                    </h5>
                    <p class="small text-muted mb-4">
                        NIP: <?= $staff->nip ?? '-'; ?>
                    </p>

                    <!-- INPUT FILE -->
                    <div class="form-group text-left">
                        <label class="small font-weight-bold text-ugm">Ganti Foto Profil</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="foto" name="foto">
                            <label class="custom-file-label text-truncate" for="foto" data-browse="Pilih">Pilih foto...</label>
                        </div>
                        <small class="text-muted font-italic d-block mt-1">Format: JPG, JPEG, PNG (Maks 2MB)</small>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: FORM DATA PEGATWAI -->
        <div class="col-xl-8">
            <div class="card card-modern shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-ugm">
                        <i class="fas fa-edit mr-2"></i> Edit Data Pegawai
                    </h6>
                </div>

                <div class="card-body" style="padding: 2.5rem;">

                    <h6 class="font-weight-bold text-uppercase mb-4" style="color: #003366; font-size: 0.85rem; letter-spacing: 0.5px;">
                        <i class="fas fa-info-circle mr-2"></i> Informasi Akun & Kontak
                    </h6>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukan nama lengkap..." value="<?= set_value('nama', $staff->name); ?>" required>
                            <?= form_error('nama', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Alamat Email</label>
                            <input type="email" class="form-control" name="email" placeholder="nama@kantor.com" value="<?= set_value('email', $staff->email); ?>" required>
                            <?= form_error('email', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Nomor Telepon</label>
                            <input type="text" class="form-control" name="no_telpon" placeholder="Nomor telepon aktif..." value="<?= set_value('no_telpon', $staff->no_telpon); ?>">
                            <?= form_error('no_telpon', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Password Baru (Optional)</label>
                            <input type="password" class="form-control" name="password" placeholder="Isi hanya jika ingin ganti password...">
                            <?= form_error('password', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                    </div>

                    <h6 class="font-weight-bold text-uppercase mb-4 mt-4" style="color: #003366; font-size: 0.85rem; letter-spacing: 0.5px;">
                        <i class="fas fa-id-card mr-2"></i> Data Kepegawaian & Administrasi
                    </h6>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">NIP / NIU</label>
                            <input type="number" class="form-control" name="nip" placeholder="Nomor Induk Pegawai" value="<?= set_value('nip', $staff->nip); ?>" required>
                            <?= form_error('nip', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" placeholder="Contoh: Staff IT" value="<?= set_value('jabatan', $staff->jabatan); ?>">
                            <?= form_error('jabatan', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Jenis Pegawai</label>
                            <input type="text" class="form-control" name="jenis_pegawai" placeholder="Contoh: PNS / Non-PNS" value="<?= set_value('jenis_pegawai', $staff->jenis_pegawai); ?>">
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Kategori Pegawai</label>
                            <input type="text" class="form-control" name="kategori" placeholder="Contoh: Dosen / Tendik" value="<?= set_value('kategori', $staff->kategori); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Tipe Pegawai</label>
                            <input type="text" class="form-control" name="tipe_pegawai" placeholder="Contoh: Tetap / Kontrak" value="<?= set_value('tipe_pegawai', $staff->tipe_pegawai); ?>">
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Unit Kerja</label>
                            <input type="text" class="form-control" name="unit_kerja" placeholder="Contoh: Direktorat IT" value="<?= set_value('unit_kerja', $staff->unit_kerja); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Pangkat / Golongan</label>
                            <input type="text" class="form-control" name="pangkat" placeholder="Contoh: Penata Muda / IIIa" value="<?= set_value('pangkat', $staff->pangkat); ?>">
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Atasan Bidang</label>
                            <select name="atasan_bidang" class="form-control custom-select">
                                <option value="">-- Tanpa Atasan Bidang --</option>
                                <?php foreach ($admins as $a) : ?>
                                    <option value="<?= $a->name; ?>" <?= ($staff->atasan_bidang == $a->name) ? 'selected' : ''; ?>>
                                        <?= $a->name; ?> (<?= $a->role; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Sisa Cuti Tahunan (Hari)</label>
                            <input type="number" class="form-control" name="sisa_cuti" placeholder="12" value="<?= set_value('sisa_cuti', $staff->sisa_cuti); ?>" min="0">
                            <?= form_error('sisa_cuti', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                        <div class="form-group col-md-6 mb-4">
                            <label class="small font-weight-bold text-ugm ml-1">Role (Hak Akses)</label>
                            <select name="role_id" class="form-control custom-select">
                                <option value="1" <?= ($staff->role_id == 1) ? 'selected' : ''; ?>>Administrator</option>
                                <option value="2" <?= ($staff->role_id == 2) ? 'selected' : ''; ?>>Staff (Pegawai Biasa)</option>
                                <option value="3" <?= ($staff->role_id == 3) ? 'selected' : ''; ?>>Sekretaris Direktur</option>
                                <option value="4" <?= ($staff->role_id == 4) ? 'selected' : ''; ?>>Direktur</option>
                                <option value="5" <?= ($staff->role_id == 5) ? 'selected' : ''; ?>>Admin SDM</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4" style="border-top: 1px dashed #e3e6f0;">

                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('admin/detailstaff/' . $staff->id_user); ?>" class="btn btn-cancel mr-2">
                            <i class="fas fa-times mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-ugm shadow-sm">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <?= form_close(); ?>
</div>

<style>
    /* Warna Identitas */
    .text-ugm {
        color: #003366;
    }

    .bg-ugm {
        background-color: #003366;
    }

    /* Card Modern */
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
        background: #fff;
    }

    /* Input Form Modern */
    .form-control,
    .custom-select,
    .custom-file-label {
        border-radius: 0.8rem;
        border: 1px solid #d1d3e2;
        padding: 0.5rem 1rem;
        height: auto;
    }

    .form-control:focus,
    .custom-select:focus,
    .custom-file-input:focus~.custom-file-label {
        border-color: #003366;
        box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.15);
    }

    /* Tombol Custom */
    .btn-ugm {
        background-color: #003366;
        color: white;
        border-radius: 2rem;
        padding: 0.5rem 1.5rem;
        transition: all 0.2s;
    }

    .btn-ugm:hover {
        background-color: #002244;
        color: white;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background-color: #eaecf4;
        color: #5a5c69;
        border-radius: 2rem;
        padding: 0.5rem 1.5rem;
    }

    .btn-cancel:hover {
        background-color: #dde2f1;
        text-decoration: none;
        color: #333;
    }
</style>

<script>
    // Live preview for profile image upload
    document.getElementById('foto').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
            nextSibling.style.fontWeight = 'bold';

            var imgPreview = document.getElementById('img-preview');
            var defaultInitial = document.getElementById('default-initial');

            var reader = new FileReader();
            reader.onload = function() {
                if(defaultInitial) {
                    defaultInitial.classList.add('d-none');
                }
                imgPreview.classList.remove('d-none');
                imgPreview.src = reader.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
