<div class="container-fluid" style="padding: 20px 30px;">
    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>
    <?php
    // Ambil filter dari URL
    $f_status = $this->input->get('status');
    $f_bulan  = $this->input->get('bulan');

    // Hitung Data untuk Dashboard
    $total_data = count($data_cuti);
    $pending = 0;
    $acc = 0;

    foreach ($data_cuti as $c) {
        if (stripos($c->status, 'Menunggu') !== false) {
            $pending++;
        }
        if ($c->status == 'Disetujui') {
            $acc++;
        }
    }
    ?>

    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card shadow-sm h-100 py-2" style="border-left: 4px solid #4e73df; border-radius: 12px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_data; ?> Data</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-primary" style="opacity: 0.6;"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card shadow-sm h-100 py-2" style="border-left: 4px solid #f6c23e; border-radius: 12px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Persetujuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pending; ?> Data</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clock fa-2x text-warning" style="opacity: 0.8;"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card shadow-sm h-100 py-2" style="border-left: 4px solid #1cc88a; border-radius: 12px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $acc; ?> Data</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-success" style="opacity: 0.6;"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fc !important;
        }

        .table-hover tbody tr:hover td {
            color: #000000 !important;
        }

        .action-btn {
            background-color: #eaecf4;
            color: #6e707e;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .action-btn:hover {
            background-color: #d1d3e2;
            color: #4e73df;
        }
    </style>

    <div class="card shadow mb-4" style="border: none; border-radius: 15px;">

        <div class="card-header py-4 d-flex align-items-center justify-content-between"
            style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">

            <h6 class="m-0 font-weight-bold text-nowrap mr-3" style="color: #003366; font-size: 1.1rem;">
                <i class="fas fa-list-alt mr-2"></i>Rekapitulasi Cuti
            </h6>

            <form action="<?= base_url('admin/datacuti'); ?>" method="get" class="form-inline d-flex flex-nowrap">
                <select name="status" class="form-control border-0 small mr-2 shadow-sm"
                    style="border-radius: 20px; height: 38px; color: #6e707e; background-color: #f8f9fc;">
                    <option value="">- Semua Status -</option>
                    <option value="Menunggu" <?= $f_status == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="Disetujui" <?= $f_status == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                    <option value="Ditolak" <?= $f_status == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    <option value="Ditangguhkan" <?= $f_status == 'Ditangguhkan' ? 'selected' : '' ?>>Ditangguhkan</option>
                    <option value="Perubahan" <?= $f_status == 'Perubahan' ? 'selected' : '' ?>>Perubahan</option>
                </select>

                <div class="input-group shadow-sm" style="border-radius: 20px;">
                    <input type="month" name="bulan" class="form-control border-0 small bg-light"
                        value="<?= $f_bulan; ?>"
                        style="border-top-left-radius: 20px; border-bottom-left-radius: 20px; color: #6e707e; height: 38px;">
                    <div class="input-group-append">
                        <button class="btn" type="submit" style="background-color: #003366; color: white; border-top-right-radius: 20px; border-bottom-right-radius: 20px; padding-left: 20px; padding-right: 20px;">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0" width="100%" cellspacing="0" style="color: #000000;">
                    <thead style="background-color: #f8f9fc; color: #003366;font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">
                        <tr>
                            <th class="py-3 px-4 text-center border-0" width="5%">No</th>
                            <th class="py-3 border-0">Pegawai</th>
                            <th class="py-3 text-center border-0">Durasi & Tanggal</th>
                            <th class="py-3 border-0">Keterangan</th>
                            <th class="py-3 text-center border-0">Lampiran</th>
                            <th class="py-3 text-center border-0">Status</th>
                            <th class="py-3 px-4 text-center border-0">Aksi</th>
                        </tr>
                    </thead>

                    <?php if (!empty($data_cuti)) : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($data_cuti as $cuti) : ?>

                            <?php
                            // LOGIKA FILTER
                            if ($f_status != '') {
                                if ($f_status == 'Menunggu') {
                                    if (stripos($cuti->status, 'Menunggu') === false) continue;
                                } else {
                                    if ($cuti->status != $f_status) continue;
                                }
                            }
                            if ($f_bulan != '') {
                                $bulan_data = date('Y-m', strtotime($cuti->tanggal_mulai));
                                if ($bulan_data != $f_bulan) continue;
                            }

                            // Logic Durasi & Helper Variables
                            $tgl1 = new DateTime($cuti->tanggal_mulai);
                            $tgl2 = new DateTime($cuti->tanggal_selesai);
                            $durasi = $tgl2->diff($tgl1)->days + 1;

                            $id_fix = $cuti->id_cuti;
                            $ket_raw = $cuti->keterangan ?? $cuti->alasan ?? '';
                            $ket_fix = ($ket_raw == '-' || trim($ket_raw) == '') ? '' : $ket_raw;
                            $tanggal_str = date('d M Y', strtotime($cuti->tanggal_mulai)) . ' s/d ' . date('d M Y', strtotime($cuti->tanggal_selesai));
                            ?>

                            <tr style="border-bottom: 1px solid #f0f1f5;">
                                <td class="align-middle text-center px-4 font-weight-bold text-gray-600"><?= $no++; ?></td>
                                <td class="align-middle">
                                    <div class="font-weight-bold" style="font-size: 0.95rem; color: #1f2937;"><?= $cuti->nama; ?></div>
                                    <div class="small text-muted mt-1"><i class="far fa-id-card mr-1"></i> <?= $cuti->nip ?? rand(10000, 99999); ?></div>
                                    <?php if (!empty($cuti->no_surat)) : ?>
                                        <div class="small mt-1" style="color: #003366; font-weight: bold;"><i class="fas fa-file-alt mr-1"></i> No: <?= htmlspecialchars($cuti->no_surat); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-light border mb-1 shadow-sm" style="color: #4e73df; background-color: #f0f4ff;"><?= $durasi; ?> Hari</span>
                                    <div style="font-size: 0.85rem; font-weight: 600; color: #4b5563;">
                                        <?= date('d M', strtotime($cuti->tanggal_mulai)); ?> - <?= date('d M Y', strtotime($cuti->tanggal_selesai)); ?>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-light border text-gray-600 mb-1"><?= $cuti->jenis_cuti; ?></span><br>
                                    <?php if (!empty($ket_fix)): ?>
                                        <small class="text-gray-600 font-italic">"<?= substr($ket_fix, 0, 30); ?><?= strlen($ket_fix) > 30 ? '...' : ''; ?>"</small>
                                    <?php else: ?>
                                        <small class="text-gray-300">-</small>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?php if (!empty($cuti->lampiran)) : ?>
                                        <a href="<?= base_url('assets/lampiran/' . $cuti->lampiran); ?>" target="_blank" class="btn btn-sm btn-circle shadow-sm" style="background-color: #fff; border: 1px solid #e3e6f0; color: #e74a3b;" title="Lihat Lampiran"><i class="fas fa-file-pdf"></i></a>
                                    <?php else : ?><span class="text-gray-400 small">-</span><?php endif; ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?php
                                    // Logic Badge Status
                                    $bg  = '#fff3cd'; // Default: Menunggu (Kuning)
                                    $txt = '#856404';

                                    if ($cuti->status == 'Disetujui') {
                                        $bg  = '#d1e7dd'; // Hijau Soft
                                        $txt = '#0f5132'; // Hijau Tua
                                    } elseif ($cuti->status == 'Ditolak') {
                                        $bg  = '#f8d7da'; // Merah Soft
                                        $txt = '#842029'; // Merah Tua
                                    } elseif ($cuti->status == 'Ditangguhkan') {
                                        // --- SARAN: ABU-ABU (Grey) ---
                                        $bg  = '#eaecf4';
                                        $txt = '#5a5c69';
                                    } elseif ($cuti->status == 'Direvisi') {
                                        // --- SARAN: UNGU (Purple) ---
                                        $bg  = '#e2d9f3';
                                        $txt = '#5a2a8c';
                                        // Atau jika ingin Cyan: $bg='#cff4fc'; $txt='#055160';
                                    }
                                    ?>
                                    <span class="badge px-3 py-2 rounded-pill font-weight-bold shadow-sm" style="background-color: <?= $bg; ?>; color: <?= $txt; ?>; font-size: 0.75rem;">
                                        <?= $cuti->status; ?>
                                    </span>
                                </td>

                                <td class="align-middle text-center" style="min-width: 100px;">

                                    <div class="d-flex justify-content-center align-items-center">

                                        <a href="javascript:void(0);"
                                            class="btn-detail"
                                            data-toggle="modal"
                                            data-target="#modalDetail"
                                            data-nama="<?= $cuti->nama; ?>"
                                            data-jenis="<?= $cuti->jenis_cuti; ?>"
                                            data-tanggal="<?= $tanggal_str; ?>"
                                            data-durasi="<?= $durasi; ?> Hari"
                                            data-keterangan="<?= $ket_fix; ?>"
                                            data-status="<?= $cuti->status; ?>"
                                            data-catatan="<?= htmlspecialchars($cuti->ket_approval ?? ''); ?>"

                                            title="Detail Permohonan"
                                            style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; margin: 0 4px; text-decoration: none; border: none; background-color: #E6F0FF; color: #003366; transition: all 0.2s;">
                                            <i class="fas fa-eye fa-sm"></i>
                                        </a>

                                        <?php if ($cuti->status == 'Disetujui') : ?>

                                            <a href="<?= base_url('admin/cetaksurat/' . $id_fix); ?>"
                                                target="_blank"
                                                title="Cetak Surat"
                                                style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; margin: 0 4px; text-decoration: none; border: none; background-color: #E6FFFA; color: #006644; transition: all 0.2s;">
                                                <i class="fas fa-print fa-sm"></i>
                                            </a>

                                            <?php 
                                            $current_role = $this->session->userdata('role_id_active') ?? $user->role_id;
                                            if ($current_role == 5) : ?>
                                                <a href="javascript:void(0);"
                                                    class="btn-input-no-surat"
                                                    data-id="<?= $id_fix; ?>"
                                                    data-no-surat="<?= htmlspecialchars($cuti->no_surat ?? ''); ?>"
                                                    data-nama="<?= htmlspecialchars($cuti->nama); ?>"
                                                    title="Input Nomor Surat"
                                                    style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; margin: 0 4px; text-decoration: none; border: none; background-color: #E2E3E5; color: #383D41; transition: all 0.2s;">
                                                    <i class="fas fa-file-signature fa-sm"></i>
                                                </a>
                                            <?php endif; ?>

                                        <?php else : ?>

                                            <button type="button"
                                                disabled
                                                title="Belum Disetujui"
                                                style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; margin: 0 4px; border: none; background-color: #f1f3f9; color: #b7b9cc; cursor: not-allowed;">
                                                <i class="fas fa-print fa-sm"></i>
                                            </button>

                                        <?php endif; ?>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-gray-500"><i class="fas fa-folder-open fa-3x mb-3" style="opacity: 0.3;"></i><br>Tidak ada data cuti ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">

            <div class="modal-header align-items-center py-3"
                style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title font-weight-bold" id="modalDetailLabel" style="color: #003366;">
                    <i class="fas fa-info-circle mr-2"></i>Detail Pengajuan
                </h5>
                <button type="button" class="close text-secondary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4">
                <div class="row mb-3 border-bottom pb-2">
                    <div class="col-4 text-gray-600 small font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Nama Pegawai</div>
                    <div class="col-8 text-dark" id="det_nama">...</div>
                </div>
                <div class="row mb-3 border-bottom pb-2">
                    <div class="col-4 text-gray-600 small font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Jenis Cuti</div>
                    <div class="col-8 text-dark" id="det_jenis">...</div>
                </div>
                <div class="row mb-3 border-bottom pb-2">
                    <div class="col-4 text-gray-600 small font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Tanggal</div>
                    <div class="col-8 text-dark" id="det_tanggal">...</div>
                </div>

                <div class="row mb-3 border-bottom pb-2">
                    <div class="col-4 text-gray-600 small font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Durasi</div>
                    <div class="col-8" id="div_durasi">
                        <span id="det_durasi">...</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4 text-gray-600 small font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Status</div>
                    <div class="col-8" id="det_status">...</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4 text-gray-600 small font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Catatan</div>
                    <div class="col-8" id="det_catatan">...</div>
                </div>

                <div class="p-3 mt-3 bg-light rounded" style="border-left: 5px solid #003366;">
                    <small class="text-primary d-block mb-1 font-weight-bold" style="color: #003366 !important;">
                        <i class="fas fa-quote-left mr-1"></i> Keterangan / Alasan:
                    </small>
                    <p class="mb-0 text-dark font-italic" id="det_keterangan" style="font-size: 0.95rem;">...</p>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 pb-4">
                <button type="button" class="btn shadow-sm font-weight-bold px-4 w-100" data-dismiss="modal"
                    style="background-color: #003366; color: white; border-radius: 50px;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInputNoSurat" tabindex="-1" role="dialog" aria-labelledby="modalInputNoSuratLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div class="modal-header align-items-center py-3" style="background-color: #fff; border-bottom: 1px solid #e3e6f0; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title font-weight-bold" id="modalInputNoSuratLabel" style="color: #003366;">
                    <i class="fas fa-file-signature mr-2"></i>Input Nomor Surat
                </h5>
                <button type="button" class="close text-secondary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/input_no_surat'); ?>" method="post">
                <div class="modal-body p-4">
                    <input type="hidden" name="id_cuti" id="input_id_cuti">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Nama Pegawai</label>
                        <div id="input_nama_pegawai" class="form-control-plaintext font-weight-bold text-dark">...</div>
                    </div>
                    <div class="form-group">
                        <label for="no_surat" class="font-weight-bold text-gray-700">Nomor Surat <span class="text-danger">*</span></label>
                        <input type="text" name="no_surat" id="input_no_surat" class="form-control" placeholder="Contoh: 123/UN1/DTI/KP.05.01/2026" required style="border-radius: 10px;">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-detail', function() {

            // 1. Ambil Data
            var nama = $(this).attr('data-nama');
            var jenis = $(this).attr('data-jenis');
            var tanggal = $(this).attr('data-tanggal');
            var durasi = $(this).attr('data-durasi');
            var keterangan = $(this).attr('data-keterangan');
            var status = $(this).attr('data-status');
            var catatan = $(this).attr('data-catatan');

            // 2. Isi Data Text Standar
            $('#det_nama').text(nama);
            $('#det_jenis').text(jenis);
            $('#det_tanggal').text(tanggal);
            $('#det_keterangan').text(keterangan ? keterangan : 'Tidak ada keterangan.');
            $('#det_catatan').text(catatan ? catatan : 'Tidak ada catatan dari Atasan.');


            // 3. LOGIC WARNA DURASI (Sama persis dengan Tabel)
            // Style: color: #4e73df; background-color: #f0f4ff;
            var durasiHtml = '<span class="badge badge-light border shadow-sm px-3 py-2" style="color: #4e73df; background-color: #f0f4ff; font-size: 0.9rem;">' + durasi + '</span>';
            $('#div_durasi').html(durasiHtml);

            // 4. LOGIC WARNA STATUS (Sama persis dengan Tabel PHP)
            var bg = '#fff3cd';
            var txt = '#856404'; // Default (Menunggu) - Kuning

            if (status == 'Disetujui') {
                bg = '#d1e7dd';
                txt = '#0f5132'; // Hijau
            } else if (status == 'Ditolak') {
                bg = '#f8d7da';
                txt = '#842029'; // Merah
            }

            // Render Badge Status dengan warna Hex yang sudah ditentukan
            var statusHtml = '<span class="badge px-3 py-2 rounded-pill font-weight-bold shadow-sm" style="background-color: ' + bg + '; color: ' + txt + '; font-size: 0.9rem;">' + status + '</span>';
            $('#det_status').html(statusHtml);
        });

        $(document).on('click', '.btn-input-no-surat', function() {
            var id = $(this).attr('data-id');
            var noSurat = $(this).attr('data-no-surat');
            var nama = $(this).attr('data-nama');

            $('#input_id_cuti').val(id);
            $('#input_no_surat').val(noSurat);
            $('#input_nama_pegawai').text(nama);

            $('#modalInputNoSurat').modal('show');
        });
    });
</script>