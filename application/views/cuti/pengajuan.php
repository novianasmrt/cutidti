<div class="container-fluid" style="padding: 20px 30px;">

    <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
        <div class="card-body" style="padding: 2.5rem;">

            <form action="<?= base_url('cuti/simpan') ?>" method="post" enctype="multipart/form-data">

                <div class="mb-5">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <h5 class="font-weight-bold mb-4" style="color: #003366; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">
                        <i class="fas fa-user-circle mr-2"></i> Informasi Pemohon
                    </h5>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Tanggal Input</label>
                            <input type="date" name="tanggal_input" class="form-control bg-light" value="<?= date('Y-m-d') ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="no_induk" class="form-control bg-light" value="<?= $user->name; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">NIU / NIP</label>
                            <input type="text" name="nama" class="form-control bg-light" value="<?= $user->nip; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Jabatan</label>
                            <input type="text" name="departemen" class="form-control bg-light" value="<?= $user->jabatan; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Pangkat / Golongan</label>
                            <input type="text" name="jabatan" class="form-control bg-light" value="<?= $user->pangkat; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Sisa Cuti Tahunan</label>
                            <div class="d-flex align-items-center pl-3 rounded" style="background-color: #e0f2fe; height: calc(1.5em + .75rem + 2px); border: 1px solid #bae6fd;">
                                <span class="font-weight-bold" style="color: #003366;"><?= $user->sisa_cuti; ?></span>
                                <input type="hidden" name="sisa_akhir" value="<?= $user->sisa_cuti; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="font-weight-bold mb-4" style="color: #003366; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">
                        <i class="fas fa-calendar-alt mr-2"></i> Detail Cuti
                    </h5>

                    <div id="alert-sdm" class="alert alert-warning border-left-warning d-none" role="alert">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Perhatian:</strong> Silahkan hubungi administrator SDM Direktorat Teknologi Informasi untuk pengajuan cuti ini.
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Jenis Cuti <span class="text-danger">*</span></label>
                            <select name="jenis_cuti" id="jenis_cuti" class="form-control custom-select" required onchange="cekJenisCuti()">
                                <option value="" disabled selected>-- Pilih Jenis Cuti --</option>
                                <option value="Cuti Tahunan">Cuti Tahunan</option>
                                <option value="Cuti Sakit">Cuti Sakit</option>
                                <option value="Cuti Alasan Penting">Cuti Alasan Penting</option>
                                <option value="Cuti Besar">Cuti Besar</option>
                                <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" id="tgl_mulai" class="form-control" required onchange="hitungOtomatis()">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" id="tgl_selesai" class="form-control" required onchange="hitungOtomatis()">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_masuk" id="tgl_masuk" class="form-control" required readonly>
                            <small class="text-muted">*Terisi otomatis (Hari kerja)</small>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">Jumlah Cuti Diambil</label>
                            <input type="number" name="jumlah_cuti" id="jml_cuti" class="form-control" value="0" min="1" required readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold text-gray-700">No. Telp / HP <span class="text-danger">*</span></label>
                            <input type="text" name="telepon" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-gray-700">Alasan Cuti <span class="text-danger">*</span></label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Acara Keluarga, Menengok Orang Tua Sakit" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-gray-700">Alamat Selama Cuti</label>
                        <input type="text" name="alamat" class="form-control" placeholder="Alamat lengkap saat cuti..." required>
                    </div>
                </div>
                <div class="mb-4">
                    <h5 class="font-weight-bold mb-4" style="color: #003366; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">
                        <i class="fas fa-file-signature mr-2"></i> Persetujuan & Lampiran
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold text-gray-700">Pilih Atasan Bidang <span class="text-danger">*</span></label>
                                <select name="atasan_bidang" class="form-control custom-select" required>
                                    <option value="" disabled selected>-- Pilih Atasan Bidang --</option>
                                    <?php foreach ($admins as $a) : ?>
                                        <option value="<?= $a->name; ?>"><?= $a->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="small font-weight-bold text-gray-700">Lampiran Dokumen (Optional)</label>

                            <div class="upload-area" style="border: 2px dashed #d1d5db; border-radius: 10px; background: #f9fafb; padding: 2rem; text-align: center; position: relative; cursor: pointer; transition: all 0.3s;">
                                <input type="file" name="lampiran" id="fileUpload" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;">

                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2" style="color: #003366;"></i>
                                    <p class="mb-0 text-muted small">Klik atau drag file ke sini (PDF/JPG, Max 2MB)</p>
                                </div>
                                <div id="fileInfo" style="display: none;">
                                    <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                                    <p class="mb-0 font-weight-bold text-dark" id="fileNameDisplay">File Terpilih</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-5 mb-4">
                <div class="d-flex justify-content-end">
                    <a href="<?= base_url('cuti/riwayat') ?>" class="btn btn-light border mr-2 px-4 font-weight-bold" style="color: #6b7280;">Batal</a>
                    <button type="submit" class="btn text-white px-5 font-weight-bold shadow-sm" style="background-color: #003366;">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('fileUpload');
    const uploadArea = document.querySelector('.upload-area');
    const placeholder = document.getElementById('uploadPlaceholder');
    const fileInfo = document.getElementById('fileInfo');
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    // Efek Hover
    uploadArea.addEventListener('dragover', (e) => {
        uploadArea.style.borderColor = '#003366';
        uploadArea.style.backgroundColor = '#e0f2fe';
    });
    uploadArea.addEventListener('dragleave', (e) => {
        uploadArea.style.borderColor = '#d1d5db';
        uploadArea.style.backgroundColor = '#f9fafb';
    });

    // Saat file dipilih
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            placeholder.style.display = 'none';
            fileInfo.style.display = 'block';
            fileNameDisplay.innerText = this.files[0].name;
            uploadArea.style.borderColor = '#16a34a'; // Hijau border
            uploadArea.style.backgroundColor = '#f0fdf4';
        }
    });
    // DAFTAR HARI LIBUR NASIONAL DARI DATABASE
    const liburNasional = <?= json_encode(array_column($hari_libur ?? [], 'tanggal')) ?>;

    // FUNGSI 1: Cek Jenis Cuti (Notifikasi)
    function cekJenisCuti() {
        const jenis = document.getElementById('jenis_cuti').value;
        const alertBox = document.getElementById('alert-sdm');

        if (jenis === 'Cuti Melahirkan' || jenis === 'Cuti Besar') {
            alertBox.classList.remove('d-none'); // Munculkan pesan
        } else {
            alertBox.classList.add('d-none'); // Sembunyikan pesan
        }
    }


    // 3. FUNGSI UTAMA HITUNG OTOMATIS
    function hitungOtomatis() {
        const tglMulaiStr = document.getElementById('tgl_mulai').value;
        const tglSelesaiStr = document.getElementById('tgl_selesai').value;

        if (tglMulaiStr && tglSelesaiStr) {
            const start = new Date(tglMulaiStr);
            const end = new Date(tglSelesaiStr);

            // Validasi: Tanggal selesai tidak boleh sebelum tanggal mulai
            if (end < start) {
                alert("Tanggal selesai tidak boleh lebih awal dari tanggal mulai!");
                document.getElementById('tgl_selesai').value = "";
                return;
            }

            //Hitung Jumlah Hari Cuti (Hanya Hari Kerja)
            let totalHariKerja = 0;
            let loopDate = new Date(start); // Copy tanggal mulai agar aslinya tidak berubah

            // Looping dari tgl mulai s.d tgl selesai
            while (loopDate <= end) {
                // Jika BUKAN hari libur, hitung sebagai cuti
                if (!isHoliday(loopDate)) {
                    totalHariKerja++;
                }
                // Maju ke hari berikutnya
                loopDate.setDate(loopDate.getDate() + 1);
            }

            // Masukkan hasil ke input jml_cuti
            document.getElementById('jml_cuti').value = totalHariKerja;


            // --- Hitung Tanggal Masuk Otomatis ---
            // Mulai pengecekan dari H+1 tanggal selesai
            let nextDay = new Date(end);
            nextDay.setDate(nextDay.getDate() + 1);

            // Looping: Selama hari tersebut adalah Libur, lewati (tambah 1 hari lagi)
            while (isHoliday(nextDay)) {
                nextDay.setDate(nextDay.getDate() + 1);
            }

            // Format tanggal hasil ke YYYY-MM-DD
            const yyyy = nextDay.getFullYear();
            const mm = String(nextDay.getMonth() + 1).padStart(2, '0');
            const dd = String(nextDay.getDate()).padStart(2, '0');

            document.getElementById('tgl_masuk').value = `${yyyy}-${mm}-${dd}`;
        }
    }

    // Fungsi Helper: Cek apakah hari libur (Sabtu, Minggu, atau Tanggal Merah)
    function isHoliday(dateObj) {
        const day = dateObj.getDay(); // 0 = Minggu, 6 = Sabtu

        // Cek Sabtu (6) atau Minggu (0)
        if (day === 6 || day === 0) {
            return true;
        }

        // Cek Tanggal Merah Nasional
        // Konversi objek date ke format string YYYY-MM-DD untuk dicocokkan dengan array
        const yyyy = dateObj.getFullYear();
        const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
        const dd = String(dateObj.getDate()).padStart(2, '0');
        const dateString = `${yyyy}-${mm}-${dd}`;

        if (liburNasional.includes(dateString)) {
            return true;
        }

        return false; // Bukan hari libur
    }
</script>