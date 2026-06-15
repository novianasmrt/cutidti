<div class="container-fluid" style="padding: 20px 30px;">

    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fc !important;
        }
        .table-hover tbody tr:hover td {
            color: #000000 !important;
        }
    </style>

    <div class="card shadow mb-4" style="border: none; border-radius: 15px;">

        <div class="card-header py-4 d-flex align-items-center justify-content-between"
            style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">

            <h6 class="m-0 font-weight-bold text-nowrap mr-3" style="color: #003366; font-size: 1.1rem;">
                <i class="fas fa-calendar-alt mr-2"></i>Daftar Hari Libur &amp; Cuti Bersama
            </h6>

            <button class="btn shadow-sm text-white text-nowrap" style="background-color: #003366; border-radius: 2rem; padding: 0.5rem 1.4rem; font-size: 0.85rem;" data-toggle="modal" data-target="#tambahLiburModal">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Hari Libur
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0" width="100%" cellspacing="0" style="color: #000000;">
                    <thead style="background-color: #f8f9fc; color: #003366; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">
                        <tr>
                            <th class="py-3 px-4 text-center border-0" width="5%">No</th>
                            <th class="py-3 border-0">Tanggal</th>
                            <th class="py-3 border-0">Keterangan / Nama Hari Libur</th>
                            <th class="py-3 px-4 text-center border-0" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($libur)) : ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-gray-500">
                                    <i class="fas fa-folder-open fa-3x mb-3" style="opacity: 0.3;"></i><br>
                                    Belum ada data hari libur.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach ($libur as $l) : ?>
                                <tr style="border-bottom: 1px solid #f0f1f5;">

                                    <td class="align-middle text-center px-4 font-weight-bold text-gray-600"><?= $no++; ?></td>

                                    <td class="align-middle">
                                        <div class="font-weight-bold" style="font-size: 0.95rem; color: #1f2937;">
                                            <?= date('d M Y', strtotime($l->tanggal)); ?>
                                        </div>
                                        <div class="small text-muted mt-1">
                                            <?= date('l', strtotime($l->tanggal)); ?>
                                        </div>
                                    </td>

                                    <td class="align-middle">
                                        <span class="badge badge-light border text-gray-600 mb-1" style="font-size: 0.8rem; font-weight: 500;">
                                            <i class="fas fa-umbrella-beach mr-1 text-warning"></i>
                                            <?= htmlspecialchars($l->keterangan); ?>
                                        </span>
                                    </td>

                                    <td class="align-middle text-center px-4">
                                        <a href="<?= base_url('admin/hapus_libur/' . $l->id_libur); ?>"
                                            onclick="return confirm('Yakin ingin menghapus hari libur ini?');"
                                            title="Hapus"
                                            style="width:35px;height:35px;display:inline-flex;align-items:center;justify-content:center;border-radius:10px;margin:0 4px;text-decoration:none;border:none;background-color:#f8d7da;color:#842029;transition:all 0.2s;">
                                            <i class="fas fa-trash fa-sm"></i>
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
<div class="modal fade" id="tambahLiburModal" tabindex="-1" role="dialog" aria-labelledby="tambahLiburLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">

            <div class="modal-header align-items-center py-3"
                style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title font-weight-bold" id="tambahLiburLabel" style="color: #003366;">
                    <i class="fas fa-calendar-plus mr-2"></i>Tambah Hari Libur
                </h5>
                <button type="button" class="close text-secondary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url('admin/simpan_libur'); ?>" method="post">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Pilih Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Keterangan / Nama Hari Libur <span class="text-danger">*</span></label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Idul Fitri 1447 H" required style="border-radius: 10px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4">
                    <button type="submit" class="btn shadow-sm font-weight-bold px-4" style="background-color: #003366; color: white; border-radius: 50px; flex: 1;">
                        Simpan
                    </button>
                    <button type="button" class="btn btn-light shadow-sm font-weight-bold px-4" data-dismiss="modal" style="border-radius: 50px; flex: 1;">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
