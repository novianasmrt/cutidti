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
                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-header bg-white">
                        <h6 class="font-weight-bold text-primary">Foto Profil</h6>
                    </div>

                    <div class="card-body text-center">

                        <?php
                        $image = (!empty($user->image)) ? $user->image : 'default.png';
                        ?>

                        <!-- PREVIEW FOTO -->
                        <img id="previewFoto"
                            src="<?= base_url('assets/img/profile/' . $image); ?>"
                            class="rounded-circle img-thumbnail mb-3"
                            style="width: 180px; height:180px; object-fit:cover;">

                        <!-- INPUT FILE -->
                        <div class="form-group">
                            <input type="file" name="image" id="customFile" class="form-control">
                            <small class="text-muted">Format: JPG, JPEG, PNG (Max 2MB)</small>
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
                            document.getElementById("previewFoto").src = e.target.result;
                        }

                        reader.readAsDataURL(file);
                    }
                });
            </script>
            <!-- FORM -->
            <div class="col-xl-8">
                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-header bg-white">
                        <h6 class="font-weight-bold text-primary">Informasi Profil</h6>
                    </div>

                    <div class="card-body">

                        <!-- NAMA -->
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control"
                                value="<?= $user->name; ?>">
                        </div>

                        <!-- EMAIL -->
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control"
                                value="<?= $user->email; ?>" readonly>
                        </div>

                        <!-- TELEPON -->
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" name="no_telpon" class="form-control"
                                value="<?= $user->no_telpon ?? ''; ?>">
                        </div>

                        <!-- NIU -->
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control"
                                value="<?= $user->nip ?? ''; ?>">
                        </div>
                        <!-- NIU -->
                        <div class="form-group">
                            <label>Jenis Pegawai</label>
                            <input type="text" name="jenis_pegawai" class="form-control"
                                value="<?= $user->jenis_pegawai ?? ''; ?>">
                        </div>
                        <!-- NIU -->
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="kategori" class="form-control"
                                value="<?= $user->kategori ?? ''; ?>">
                        </div>
                        <!-- NIU -->
                        <div class="form-group">
                            <label>Tipe Pegawai</label>
                            <input type="text" name="tipe_pegawai" class="form-control"
                                value="<?= $user->tipe_pegawai ?? ''; ?>">
                        </div>

                        <!-- UNIT -->
                        <div class="form-group">
                            <label>Unit Kerja</label>
                            <input type="text" name="unit_kerja" class="form-control"
                                value="<?= $user->unit_kerja ?? ''; ?>">
                        </div>

                        <!-- JABATAN -->
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" class="form-control"
                                value="<?= $user->jabatan ?? ''; ?>">
                        </div>

                        <!-- PANGKAT -->
                        <div class="form-group">
                            <label>Pangkat</label>
                            <input type="text" name="pangkat" class="form-control"
                                value="<?= $user->pangkat ?? ''; ?>">
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    document.getElementById('customFile').onchange = function(e) {
        const [file] = this.files;
        if (file) {
            document.getElementById('previewFoto').src = URL.createObjectURL(file);
        }
    };
</script>