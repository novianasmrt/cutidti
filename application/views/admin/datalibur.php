<div class="container-fluid" style="padding: 20px 30px;">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- Title left empty intentionally, using topbar title -->
    </div>

    <!-- Menampilkan pesan notifikasi -->
    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <div class="card shadow mb-4" style="border-radius: 15px; border: none;">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white" style="border-bottom: 2px solid #f3f4f6; border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h6 class="m-0 font-weight-bold" style="color: #003366;">
                <i class="fas fa-calendar-alt mr-2"></i> Daftar Hari Libur & Cuti Bersama
            </h6>
            
            <button class="btn btn-sm text-white font-weight-bold shadow-sm" style="background-color: #003366; border-radius: 8px;" data-toggle="modal" data-target="#tambahLiburModal">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Hari Libur
            </button>
        </div>
        
        <div class="card-body" style="padding: 1.5rem;">
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle" width="100%" cellspacing="0">
                    <thead style="background-color: #f8f9fc; color: #4b5563; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <tr>
                            <th class="py-3 px-4 text-center rounded-left" style="width: 5%;">No</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Keterangan</th>
                            <th class="py-3 px-4 text-center rounded-right" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="color: #374151; font-size: 0.95rem;">
                        <?php if (empty($libur)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 font-weight-bold">Belum ada data hari libur</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($libur as $l): ?>
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td class="text-center py-3 font-weight-bold text-gray-400"><?= $no++; ?></td>
                                    <td class="py-3 font-weight-bold">
                                        <?= date('d M Y', strtotime($l->tanggal)); ?>
                                    </td>
                                    <td class="py-3">
                                        <?= $l->keterangan; ?>
                                    </td>
                                    <td class="text-center py-3">
                                        <a href="<?= base_url('admin/hapus_libur/' . $l->id_libur); ?>" class="btn btn-danger btn-sm shadow-sm" style="border-radius: 8px;" onclick="return confirm('Yakin ingin menghapus hari libur ini?');" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Hari Libur -->
<div class="modal fade" id="tambahLiburModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header bg-light" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title font-weight-bold text-dark" id="exampleModalLabel">
                    <i class="fas fa-calendar-plus text-primary mr-2"></i> Tambah Hari Libur
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('admin/simpan_libur'); ?>" method="post">
                <div class="modal-body p-4">
                    
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-gray-700 small">Pilih Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-gray-700 small">Keterangan / Nama Hari Libur <span class="text-danger">*</span></label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Idul Fitri 1447 H" required>
                    </div>

                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button class="btn btn-light border font-weight-bold text-gray-600 px-4" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn text-white font-weight-bold px-4" type="submit" style="background-color: #003366;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
