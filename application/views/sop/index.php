<!-- Begin Page Content -->
<div class="container-fluid mb-5">

    <style>
        /* Custom Elegant Styling for SOP */
        .sop-header-card {
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #003366 0%, #004080 100%);
            box-shadow: 0 10px 20px rgba(0, 51, 102, 0.15);
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .sop-header-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .accordion-sop .card {
            border: none;
            border-radius: 12px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }

        .accordion-sop .card:hover {
            box-shadow: 0 8px 25px rgba(0, 51, 102, 0.1);
            transform: translateY(-2px);
        }

        .accordion-sop .card-header {
            background-color: #ffffff;
            border-radius: 12px !important;
            border-bottom: none;
            padding: 1.25rem 1.5rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .accordion-sop .card-header:not(.collapsed) {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            border-bottom: 1px solid #f1f3f5;
            background-color: #f8faff;
        }

        .accordion-sop .card-title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: #2c3e50;
            transition: color 0.3s ease;
        }

        .accordion-sop .card-header:not(.collapsed) .card-title {
            color: #003366;
        }

        .accordion-sop .card-body {
            background-color: #ffffff;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 1.5rem 2rem;
            color: #4a5568;
            font-size: 0.95rem;
            line-height: 1.8;
        }

        .sop-pasal-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.75rem;
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
        }

        .sop-pasal-title:first-child {
            margin-top: 0;
        }

        .sop-pasal-title i {
            color: #003366;
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .sop-list {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }

        .sop-list li {
            margin-bottom: 0.5rem;
        }

        .sop-list li:last-child {
            margin-bottom: 0;
        }
        
        .signature-box {
            border-top: 1px dashed #e2e8f0;
            padding-top: 1.5rem;
            margin-top: 2rem;
            text-align: right;
        }
    </style>

    <!-- Header Card -->
    <div class="card sop-header-card mb-5">
        <div class="card-body text-center py-5">
            <h3 class="font-weight-bold mb-2" style="letter-spacing: 1px;">PERATURAN PENGAJUAN CUTI</h3>
            <h5 class="mb-2 font-weight-light" style="opacity: 0.9;">DIREKTORAT TEKNOLOGI INFORMASI</h5>
            <h6 class="mb-0" style="opacity: 0.7; font-weight: 600; letter-spacing: 2px;">UNIVERSITAS GADJAH MADA</h6>
        </div>
    </div>

    <!-- Accordion / Chapters -->
    <div class="accordion accordion-sop" id="accordionSOP">

        <!-- Cuti Tahunan -->
        <div class="card">
            <div class="card-header" id="heading1" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                <h5 class="card-title">1. Cuti Tahunan</h5>
            </div>
            <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordionSOP">
                <div class="card-body">
                    <ol class="sop-list" type="a">
                        <li>Pegawai berhak memperoleh cuti tahunan sebanyak 12 (dua belas) hari kerja dalam 1 (satu) tahun;</li>
                        <li>Apabila pegawai selama 2 (dua) tahun berturut-turut tidak mengambil cuti tahunan, maka hak cuti pada tahun berikutnya dapat diperhitungkan sebanyak 24 (dua puluh empat) hari kerja;</li>
                        <li>Apabila dalam 2 (dua) tahun sebelumnya pegawai mengambil cuti tahunan pada salah satu tahun, maka hak cuti yang dapat diperhitungkan dan dibawa ke tahun berikutnya adalah paling banyak 6 (enam) hari kerja, sesuai ketentuan yang berlaku;</li>
                        <li>Cuti tahunan yang telah diajukan tetapi tidak disetujui oleh pimpinan karena adanya tugas kedinasan yang mendesak dapat diperhitungkan sebagai hak cuti pada tahun berikutnya sesuai ketentuan yang berlaku dan pencatatan administrasi kepegawaian.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Cuti Besar -->
        <div class="card">
            <div class="card-header collapsed" id="heading2" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                <h5 class="card-title">2. Cuti Besar</h5>
            </div>
            <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionSOP">
                <div class="card-body">
                    <ol class="sop-list" type="a">
                        <li>Cuti besar diberikan berdasarkan masa kerja dan berlaku dalam periode 5 (lima) tahun sesuai ketentuan yang berlaku;</li>
                        <li>Cuti besar dapat diberikan paling lama 3 (tiga) bulan;</li>
                        <li>Pegawai yang menggunakan cuti besar tidak memperoleh cuti tahunan pada periode yang sama, sesuai ketentuan yang berlaku;</li>
                        <li>Apabila pegawai telah menggunakan cuti tahunan sebanyak 12 (dua belas) hari kemudian mengajukan cuti besar, maka penggunaan cuti besar diperhitungkan dengan mempertimbangkan cuti tahunan yang telah digunakan sesuai ketentuan yang berlaku.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Cuti Sakit -->
        <div class="card">
            <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                <h5 class="card-title">3. Cuti Sakit</h5>
            </div>
            <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionSOP">
                <div class="card-body">
                    <ol class="sop-list" type="a">
                        <li>Cuti sakit diberikan berdasarkan surat keterangan dokter;</li>
                        <li>Cuti sakit diberikan paling lama 1 (satu) berdasarkan surat keterangan dokter dan sesuai ketentuan yang berlaku;</li>
                        <li>Apabila setelah 1 (satu) tahun pegawai masih mengalami sakit, cuti sakit dapat diperpanjang paling lama 6 (enam) bulan sesuai hasil pemeriksaan dan ketentuan yang berlaku;</li>
                        <li>Apabila setelah perpanjangan tersebut pegawai masih belum dapat menjalankan tugas, penyelesaian status kepegawaiannya dilakukan sesuai ketentuan peraturan perundang-undangan yang berlaku.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Cuti Sakit karena Gugur Kandungan -->
        <div class="card">
            <div class="card-header collapsed" id="heading4" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                <h5 class="card-title">4. Cuti Sakit karena Gugur Kandungan</h5>
            </div>
            <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionSOP">
                <div class="card-body">
                    <ol class="sop-list" type="a">
                        <li>PNS yang mengalami gugur kandungan berhak atas cuti sakit paling lama 1,5 (satu setengah) bulan, sesuai ketentuan yang berlaku;</li>
                        <li>Pengajuan wajib dilengkapi surat keterangan atau dokumen medis yang dipersyaratkan.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Cuti Melahirkan -->
        <div class="card">
            <div class="card-header collapsed" id="heading5" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                <h5 class="card-title">5. Cuti Melahirkan</h5>
            </div>
            <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionSOP">
                <div class="card-body">
                    <ol class="sop-list" type="a">
                        <li>Cuti melahirkan diberikan selama 3 (tiga) bulan;</li>
                        <li>Pengajuan cuti melahirkan dilengkapi dokumen pendukung sesuai ketentuan administrasi yang berlaku;</li>
                        <li>Pegawai yang istrinya melahirkan dapat mengajukan cuti karena alasan penting;</li>
                        <li>Cuti suami ketika istri melahirkan diberikan paling lama 1 (satu) bulan;</li>
                        <li>Pengajuan cuti dilengkapi surat keterangan rawat inap dari Unit Pelayanan Kesehatan atau dokumen medis yang dipersyaratkan.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Cuti Menikah -->
        <div class="card">
            <div class="card-header collapsed" id="heading6" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                <h5 class="card-title">6. Cuti Menikah</h5>
            </div>
            <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionSOP">
                <div class="card-body">
                    <ol class="sop-list" type="a">
                        <li>Pegawai yang melangsungkan pernikahan dapat mengajukan cuti selama 3 (tiga) sampai dengan 5 (lima) hari kerja;</li>
                        <li>Pelaksanaan cuti menikah harus memperoleh persetujuan pimpinan.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Ketentuan Umum Pengajuan Cuti -->
        <div class="card">
            <div class="card-header collapsed" id="heading7" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                <h5 class="card-title">7. Ketentuan Umum Pengajuan Cuti</h5>
            </div>
            <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordionSOP">
                <div class="card-body">
                    <ol class="sop-list" type="a">
                        <li>Setiap pengajuan cuti dilakukan sebelum tanggal mulai cuti dan harus memperoleh persetujuan pimpinan/pejabat yang berwenang;</li>
                        <li>Pengajuan mencantumkan jenis cuti, tanggal mulai dan berakhir cuti, jumlah hari cuti yang diajukan, serta keperluan cuti;</li>
                        <li>Dokumen pendukung wajib dilampirkan untuk jenis cuti yang mensyaratkannya;</li>
                        <li>Pengelola administrasi kepegawaian melakukan pencatatan terhadap pengajuan, persetujuan, penggunaan, dan sisa hak cuti setiap pegawai;</li>
                        <li>Perhitungan hak dan penggunaan cuti dilakukan berdasarkan jenis cuti serta ketentuan peraturan perundang-undangan dan kebijakan Universitas Gadjah Mada yang berlaku;</li>
                        <li>Apabila terdapat ketentuan dalam dokumen ini yang berbeda dengan peraturan perundang-undangan atau kebijakan Universitas Gadjah Mada yang lebih tinggi, maka ketentuan yang lebih tinggi tersebut yang berlaku.</li>
                    </ol>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->
