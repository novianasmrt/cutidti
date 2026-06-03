<div class="container-fluid" style="padding: 20px 30px;">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>

    <!-- Menampilkan pesan notifikasi -->
    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow mb-4" style="border: none; border-radius: 15px;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h6 class="m-0 font-weight-bold" style="color: #003366;">
                        <i class="fas fa-key mr-2"></i> Form Ubah Password
                    </h6>
                </div>
                
                <div class="card-body" style="padding: 2rem;">
                    
                    <div class="text-center mb-4">
                        <div class="soft-icon-circle soft-yellow mx-auto mb-3" style="width: 70px; height: 70px; font-size: 1.5rem;">
                            <i class="fas fa-lock"></i>
                        </div>
                        <p class="text-muted small">Pastikan password baru Anda kuat dan mudah diingat. Disarankan menggunakan kombinasi huruf dan angka.</p>
                    </div>

                    <?= form_open('user/changepassword'); ?>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold" style="color: #003366;">Password Saat Ini</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 0.8rem 0 0 0.8rem;"><i class="fas fa-unlock-alt text-muted"></i></span>
                                </div>
                                <input type="password" class="form-control border-left-0" style="border-radius: 0 0.8rem 0.8rem 0;" id="current_password" name="current_password" placeholder="Masukkan password lama">
                            </div>
                            <?= form_error('current_password', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                        <hr class="sidebar-divider my-4">

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold" style="color: #003366;">Password Baru</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 0.8rem 0 0 0.8rem;"><i class="fas fa-key text-muted"></i></span>
                                </div>
                                <input type="password" class="form-control border-left-0" style="border-radius: 0 0.8rem 0.8rem 0;" id="new_password1" name="new_password1" placeholder="Masukkan password baru (Min. 3 karakter)">
                            </div>
                            <?= form_error('new_password1', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold" style="color: #003366;">Ulangi Password Baru</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-radius: 0.8rem 0 0 0.8rem;"><i class="fas fa-check-double text-muted"></i></span>
                                </div>
                                <input type="password" class="form-control border-left-0" style="border-radius: 0 0.8rem 0.8rem 0;" id="new_password2" name="new_password2" placeholder="Ulangi password baru">
                            </div>
                            <?= form_error('new_password2', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                        <div class="d-flex justify-content-between mt-5">
                            <a href="<?= base_url('user/profile'); ?>" class="btn btn-light shadow-sm" style="border-radius: 2rem; padding: 0.5rem 1.5rem; font-weight: 600;">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn text-white shadow-sm" style="background-color: #003366; border-radius: 2rem; padding: 0.5rem 1.5rem; font-weight: 600;">
                                <i class="fas fa-save mr-2"></i> Simpan Password
                            </button>
                        </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control {
        border-radius: 0.8rem;
        padding: 0.6rem 1rem;
        height: auto;
    }

    .form-control:focus {
        border-color: #003366;
        box-shadow: none;
    }
    
    .input-group-text {
        border-color: #d1d3e2;
    }
    
    .form-control:focus + .input-group-text,
    .input-group:focus-within .input-group-text {
        border-color: #003366;
    }

    .soft-icon-circle {
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .soft-yellow {
        background-color: #FFF7E6;
        color: #CC8800;
    }
</style>
