<div class="container-fluid" style="padding: 20px 30px;">
    <div class="row">

        <!-- ================= DETAIL PERMOHONAN ================= -->
        <div class="col-xl-7 col-lg-7 mb-4">
            <div class="card shadow mb-4" style="border-radius: 15px;">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Detail Permohonan
                    </h6>
                </div>

                <div class="card-body" style="padding: 2rem;">

                    <!-- Nama -->
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Pegawai</label>
                        <input type="text" class="form-control"
                            value="<?= !empty($p->name) ? $p->name : '-'; ?>"
                            readonly>
                    </div>

                    <!-- Sisa Cuti -->
                    <div class="form-group">
                        <label class="font-weight-bold">Sisa Cuti</label>
                        <input type="text" class="form-control"
                            value="<?= isset($p->sisa_cuti) ? $p->sisa_cuti : '0'; ?> Hari"
                            readonly>
                    </div>

                    <!-- Tanggal -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Mulai Cuti</label>
                                <input type="text" class="form-control"
                                    value="<?= !empty($p->tanggal_mulai) ? date('d M Y', strtotime($p->tanggal_mulai)) : '-'; ?>"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Selesai Cuti</label>
                                <input type="text" class="form-control"
                                    value="<?= !empty($p->tanggal_selesai) ? date('d M Y', strtotime($p->tanggal_selesai)) : '-'; ?>"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="form-group">
                        <label class="font-weight-bold">Keterangan</label>
                        <textarea class="form-control" rows="3" readonly><?= !empty($p->keterangan) ? $p->keterangan : '-'; ?></textarea>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= FORM APPROVAL ================= -->
        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4" style="border-radius: 15px;">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Keputusan Approval
                    </h6>
                </div>

                <div class="card-body" style="padding: 2rem;">

                    <form action="<?= base_url('cuti/approval_save/' . $p->id_cuti); ?>" method="post">

                        <!-- Status -->
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Status Persetujuan <span class="text-danger">*</span>
                            </label>

                            <select name="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <?php
                                $role_aktif = $this->session->userdata('role_id_active') ?? $this->session->userdata('role_id') ?? $user->role_id;
                                ?>
                                <?php if ($role_aktif == 4): ?>
                                    <!-- Direktur: Persetujuan final - QR akan muncul di surat -->
                                    <option value="Disetujui">&#10003; Disetujui Final (QR akan muncul di surat)</option>
                                <?php elseif ($role_aktif == 3): ?>
                                    <!-- Sekdir: Lanjutkan ke Direktur -->
                                    <option value="Menunggu Direktur">&#10003; Setujui (Lanjut ke Direktur)</option>
                                <?php elseif ($p->status == 'Menunggu' || $p->status == 'Menunggu Atasan'): ?>
                                    <!-- Atasan / Admin Bidang: Lanjut ke Sekdir -->
                                    <option value="Menunggu Sekdir">&#10003; Setujui (Lanjut ke Sekretaris Direktur)</option>
                                <?php else: ?>
                                    <option value="Disetujui">&#10003; Disetujui</option>
                                <?php endif; ?>
                                <option value="Ditolak">&#10007; Ditolak</option>
                            </select>
                        </div>

                        <!-- Catatan -->
                        <div class="form-group">
                            <label class="font-weight-bold">Catatan (Opsional)</label>
                            <textarea name="ket_approval" class="form-control" rows="4"
                                placeholder="Tulis catatan untuk pegawai..."></textarea>
                        </div>

                        <hr>

                        <!-- Button -->
                        <button type="submit"
                            class="btn btn-primary btn-block font-weight-bold"
                            style="background-color:#003366; border-radius:10px;">
                            Simpan Keputusan
                        </button>

                        <a href="<?= base_url('cuti/approval'); ?>"
                            class="btn btn-light btn-block font-weight-bold">
                            Batal
                        </a>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>