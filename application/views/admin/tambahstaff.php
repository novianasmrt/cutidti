<div class="container-fluid" style="padding: 20px 30px;">
    <div class="card card-modern mb-4">
        <div class="card-body p-4">

            <div class="d-flex align-items-center mb-4">
                <div class="soft-icon-circle soft-green">
                    <i class="fas fa-file-excel"></i>
                </div>
                <div>
                    <h5 class="m-0 font-weight-bold" style="color: #006644;">Import Data Pegawai</h5>
                    <small class="text-muted">Upload file Excel untuk menambahkan banyak data sekaligus.</small>
                </div>
            </div>

            <?= form_open_multipart('admin/import_excel', ['id' => 'formImport']); ?>
            <div class="row align-items-center p-3" style="background-color: #f8fffb; border-radius: 1rem; border: 1px dashed #006644;">

                <div class="col-md-8 mb-3 mb-md-0">
                    <label class="small font-weight-bold text-gray-700">Pilih File Excel (.xlsx / .xls)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file_excel" name="file_excel" accept=".xlsx, .xls" required>
                        <label class="custom-file-label" for="file_excel">Belum ada file dipilih...</label>
                    </div>
                </div>

                <div class="col-md-4 text-right">

                    <button type="submit" id="btnSubmitImport" class="btn btn-success shadow-sm" style="border-radius: 2rem; padding: 0.6rem 2rem; background-color: #006644; border: none;">
                        <i class="fas fa-cloud-upload-alt mr-2"></i> Import Sekarang
                    </button>

                    <button type="button" id="btnLoadingImport" class="btn btn-success shadow-sm" style="border-radius: 2rem; padding: 0.6rem 2rem; background-color: #004d33; border: none; display: none; cursor: not-allowed;" disabled>
                        <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                        Memproses...
                    </button>

                </div>
            </div>
            <?= form_close(); ?>

        </div>
    </div>


    <div class="card card-modern">
        <div class="card-body p-4">

            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="soft-icon-circle soft-blue">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h5 class="m-0 font-weight-bold text-ugm">Formulir Data Pegawai</h5>
                    <small class="text-muted">Input data pegawai secara manual (satu per satu).</small>
                </div>
            </div>

            <?= form_open_multipart('admin/simpan_staff'); ?>

            <div class="row">
                <div class="col-md-6 border-right pr-md-4">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-ugm ml-1">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukan nama lengkap..." value="<?= set_value('nama'); ?>">
                        <?= form_error('nama', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-ugm ml-1">NIP / NIU</label>
                        <input type="number" class="form-control" name="nip" placeholder="Nomor Induk Pegawai" value="<?= set_value('nip'); ?>">
                        <?= form_error('nip', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-ugm ml-1">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" placeholder="Contoh: Staff IT" value="<?= set_value('jabatan'); ?>">
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-ugm ml-1">Alamat Email</label>
                        <input type="email" class="form-control" name="email" placeholder="nama@kantor.com" value="<?= set_value('email'); ?>">
                        <?= form_error('email', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                </div>

                <div class="col-md-6 pl-md-4 mt-3 mt-md-0">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-ugm ml-1">Role (Hak Akses)</label>
                        <select name="role_id" class="form-control custom-select">
                            <option value="1">Administrator</option>
                            <option value="2">Staff (Pegawai Biasa)</option>
                            <option value="3">Sekretaris Direktur</option>
                            <option value="4">Direktur</option>
                            <option value="5">Admin SDM</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-ugm ml-1">Password Awal</label>
                        <input type="password" class="form-control" name="password" placeholder="Minimal 5 karakter">
                        <?= form_error('password', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-ugm ml-1">Foto Profil</label>
                        <div class="d-flex align-items-center p-3" style="background: #f8f9fc; border-radius: 1rem;">

                            <div class="mr-3">
                                <div id="icon-default" class="soft-icon-circle soft-blue mr-0" style="width: 70px; height: 70px;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                                <img id="img-preview" src="#" class="rounded-circle shadow-sm"
                                    style="width: 70px; height: 70px; object-fit: cover; display: none;">
                            </div>

                            <div class="flex-grow-1">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto">
                                    <label class="custom-file-label" for="foto" data-browse="Upload">Pilih foto...</label>
                                </div>
                                <small class="text-muted font-italic d-block mt-1">Format: JPG/PNG, Maks 2MB.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4" style="border-top: 1px dashed #e3e6f0;">

            <div class="d-flex justify-content-end">
                <a href="<?= base_url('admin/datastaff'); ?>" class="btn btn-cancel mr-2">
                    <i class="fas fa-times mr-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-ugm shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Data
                </button>
            </div>

            <?= form_close(); ?>

        </div>
    </div>
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
        transition: all 0.2s;
    }

    /* Input Form Modern */
    .form-control,
    .custom-select,
    .custom-file-label {
        border-radius: 0.8rem;
        /* Lebih rounded */
        border: 1px solid #d1d3e2;
        padding: 0.5rem 1rem;
        height: auto;
    }

    .form-control:focus,
    .custom-select:focus,
    .custom-file-input:focus~.custom-file-label {
        border-color: #003366;
        box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.15);
        /* Shadow biru UGM soft */
    }

    /* Ikon dengan Background Soft (Khas Dashboard) */
    .soft-icon-circle {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
        margin-right: 1rem;
    }

    /* Palet Warna */
    .soft-blue {
        background-color: #E6F0FF;
        color: #003366;
    }

    .soft-green {
        background-color: #E6FFFA;
        color: #006644;
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
    // 1. Script untuk Input File Excel
    document.getElementById('file_excel').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
            nextSibling.style.color = '#006644'; // Ubah warna teks jadi hijau saat file dipilih
            nextSibling.style.fontWeight = 'bold';
        }
    });

    // 2. Script Logika Preview Foto
    document.getElementById('foto').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Ambil elemen
            var iconDefault = document.getElementById('icon-default');
            var imgPreview = document.getElementById('img-preview');

            var reader = new FileReader();
            reader.onload = function() {
                // Set source gambar
                imgPreview.src = reader.result;

                // Sembunyikan Ikon, Munculkan Gambar
                iconDefault.style.display = 'none';
                iconDefault.classList.remove('d-flex');

                imgPreview.style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        }
        // --- 1. EFEK LOADING TOMBOL ---
        const formImport = document.getElementById('formImport');
        const btnSubmit = document.getElementById('btnSubmitImport');
        const btnLoading = document.getElementById('btnLoadingImport');

        formImport.addEventListener('submit', function() {
            // Sembunyikan tombol asli
            btnSubmit.style.display = 'none';
            // Munculkan tombol loading
            btnLoading.style.display = 'inline-block';
        });


        // --- 2. POP UP SWEETALERT (Menangkap Flashdata dari Controller) ---
        // Pastikan di Controller Anda sudah set flashdata:
        // $this->session->set_flashdata('message', 'success|Data Berhasil Diimport!');

        <?php if ($this->session->flashdata('message')) : ?>

            <?php
            // Pecah data flashdata (Tipe|Pesan)
            // Contoh format flashdata: "success|Data berhasil disimpan" atau "error|Format salah"
            $flashData = $this->session->flashdata('message');
            $pecah = explode('|', $flashData);
            $type = isset($pecah[0]) ? $pecah[0] : 'info';
            $msg = isset($pecah[1]) ? $pecah[1] : 'Notifikasi';
            ?>

            Swal.fire({
                icon: '<?= $type; ?>', // success, error, warning, info
                title: '<?= ($type == "success") ? "Berhasil!" : "Gagal!"; ?>',
                text: '<?= $msg; ?>',
                confirmButtonColor: '#003366', // Warna Biru UGM
                confirmButtonText: 'Oke, Siap!'
            });

        <?php endif; ?>
    });
</script>