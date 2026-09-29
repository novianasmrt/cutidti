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

        <!-- BAB I -->
        <div class="card">
            <div class="card-header" id="headingBab1" data-toggle="collapse" data-target="#collapseBab1" aria-expanded="true" aria-controls="collapseBab1">
                <h5 class="card-title">BAB I &nbsp;&mdash;&nbsp; KETENTUAN UMUM</h5>
            </div>
            <div id="collapseBab1" class="collapse show" aria-labelledby="headingBab1" data-parent="#accordionSOP">
                <div class="card-body">
                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 1: Pengertian</div>
                    <ol class="sop-list">
                        <li>Cuti adalah keadaan tidak masuk kerja yang diizinkan dalam jangka waktu tertentu sesuai dengan ketentuan yang berlaku.</li>
                        <li>Pegawai yang dimaksud dalam peraturan ini adalah pegawai di lingkungan Direktorat Teknologi Informasi Universitas Gadjah Mada.</li>
                        <li>Pengajuan cuti dilakukan melalui mekanisme administrasi yang ditetapkan oleh Direktorat Teknologi Informasi Universitas Gadjah Mada.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- BAB II -->
        <div class="card">
            <div class="card-header collapsed" id="headingBab2" data-toggle="collapse" data-target="#collapseBab2" aria-expanded="false" aria-controls="collapseBab2">
                <h5 class="card-title">BAB II &nbsp;&mdash;&nbsp; JENIS DAN KETENTUAN CUTI</h5>
            </div>
            <div id="collapseBab2" class="collapse" aria-labelledby="headingBab2" data-parent="#accordionSOP">
                <div class="card-body">
                    
                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 2: Cuti Tahunan</div>
                    <ol class="sop-list">
                        <li>Pegawai berhak memperoleh cuti tahunan sebanyak 12 (dua belas) hari kerja dalam 1 (satu) tahun.</li>
                        <li>Apabila pegawai selama 2 (dua) tahun berturut-turut tidak menggunakan cuti tahunan, maka hak cuti tahunan pada tahun berikutnya dapat diberikan sebanyak 24 (dua puluh empat) hari kerja, sesuai ketentuan yang berlaku.</li>
                        <li>Apabila pegawai dalam 2 (dua) tahun sebelumnya telah menggunakan cuti tahunan pada salah satu tahun tersebut, maka hak cuti yang dapat diperhitungkan dan dibawa ke tahun berikutnya adalah paling banyak 6 (enam) hari kerja, sesuai ketentuan yang berlaku.</li>
                        <li>Apabila permohonan cuti tahunan tidak dapat disetujui oleh pimpinan karena adanya tugas kedinasan yang mendesak, hak cuti yang tidak terlaksana tersebut diperhitungkan sebagai hak cuti pada tahun berikutnya sesuai ketentuan yang berlaku dan hasil persetujuan pimpinan.</li>
                    </ol>

                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 3: Cuti Besar</div>
                    <ol class="sop-list">
                        <li>Cuti besar diberikan kepada pegawai sesuai masa kerja yang dipersyaratkan dan berlaku untuk periode 5 (lima) tahun.</li>
                        <li>Cuti besar diberikan paling lama 3 (tiga) bulan.</li>
                        <li>Pegawai yang menggunakan cuti besar tidak berhak mendapatkan cuti tahunan pada periode yang sama, sesuai ketentuan yang berlaku.</li>
                        <li>Apabila pegawai telah menggunakan cuti tahunan sebanyak 12 (dua belas) hari sebelum mengajukan cuti besar, penggunaan cuti besar diperhitungkan dengan mempertimbangkan cuti tahunan yang telah digunakan tersebut sesuai ketentuan yang berlaku.</li>
                    </ol>

                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 4: Cuti Sakit</div>
                    <ol class="sop-list">
                        <li>Cuti sakit diberikan berdasarkan surat keterangan dokter sebagai dokumen pendukung.</li>
                        <li>Cuti sakit diberikan untuk waktu paling lama 1 (satu) tahun.</li>
                        <li>Apabila setelah jangka waktu 1 (satu) tahun pegawai masih mengalami sakit, cuti sakit dapat diperpanjang paling lama 6 (enam) bulan sesuai hasil pemeriksaan dan ketentuan yang berlaku.</li>
                        <li>Apabila setelah jangka waktu sebagaimana dimaksud pada ayat (3) pegawai masih belum dinyatakan sembuh atau tidak dapat menjalankan tugas, penyelesaian status kepegawaiannya dilakukan sesuai ketentuan peraturan perundang-undangan yang berlaku.</li>
                    </ol>

                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 5: Cuti Sakit karena Gugur Kandungan</div>
                    <ol class="sop-list">
                        <li>PNS yang mengalami gugur kandungan berhak atas cuti sakit paling lama 1,5 (satu setengah) bulan.</li>
                        <li>Pengajuan cuti sebagaimana dimaksud pada ayat (1) dilengkapi dengan dokumen atau surat keterangan medis yang dipersyaratkan.</li>
                    </ol>

                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 6: Cuti Melahirkan</div>
                    <ol class="sop-list">
                        <li>Cuti melahirkan diberikan selama 3 (tiga) bulan.</li>
                        <li>Pengajuan cuti melahirkan dilakukan dengan melampirkan dokumen pendukung sesuai ketentuan administrasi yang berlaku.</li>
                    </ol>

                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 7: Cuti karena Alasan Penting bagi Suami yang Istrinya Melahirkan</div>
                    <ol class="sop-list">
                        <li>Pegawai yang istrinya melahirkan dapat mengajukan cuti karena alasan penting sesuai ketentuan yang berlaku.</li>
                        <li>Cuti sebagaimana dimaksud pada ayat (1) diberikan paling lama 1 (satu) bulan.</li>
                        <li>Pengajuan wajib dilengkapi surat keterangan rawat inap dari Unit Pelayanan Kesehatan atau dokumen medis yang dipersyaratkan.</li>
                    </ol>

                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 8: Cuti Menikah</div>
                    <ol class="sop-list">
                        <li>Pegawai yang melangsungkan pernikahan dapat mengajukan cuti menikah selama 3 (tiga) sampai dengan 5 (lima) hari kerja.</li>
                        <li>Pelaksanaan cuti sebagaimana dimaksud pada ayat (1) harus memperoleh persetujuan pimpinan.</li>
                    </ol>

                </div>
            </div>
        </div>

        <!-- BAB III -->
        <div class="card">
            <div class="card-header collapsed" id="headingBab3" data-toggle="collapse" data-target="#collapseBab3" aria-expanded="false" aria-controls="collapseBab3">
                <h5 class="card-title">BAB III &nbsp;&mdash;&nbsp; MEKANISME PENGAJUAN</h5>
            </div>
            <div id="collapseBab3" class="collapse" aria-labelledby="headingBab3" data-parent="#accordionSOP">
                <div class="card-body">
                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 9: Pengajuan Cuti</div>
                    <ol class="sop-list">
                        <li>Setiap pengajuan cuti dilakukan sebelum tanggal mulai cuti dan memperoleh persetujuan pejabat/pimpinan yang berwenang.</li>
                        <li>Pengajuan harus mencantumkan jenis cuti, tanggal mulai dan berakhir cuti, jumlah hari cuti, serta dokumen pendukung yang dipersyaratkan.</li>
                        <li>Pengajuan cuti sakit, cuti melahirkan, cuti karena alasan penting, dan jenis cuti lain yang mensyaratkan bukti pendukung wajib dilengkapi dokumen yang sah.</li>
                        <li>Pimpinan dapat mempertimbangkan kebutuhan kedinasan dalam memberikan persetujuan cuti.</li>
                        <li>Dalam hal cuti tahunan tidak dapat dilaksanakan karena tugas kedinasan yang mendesak, hak cuti tersebut dicatat untuk diperhitungkan pada periode berikutnya sesuai ketentuan yang berlaku.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- BAB IV -->
        <div class="card">
            <div class="card-header collapsed" id="headingBab4" data-toggle="collapse" data-target="#collapseBab4" aria-expanded="false" aria-controls="collapseBab4">
                <h5 class="card-title">BAB IV &nbsp;&mdash;&nbsp; PENCATATAN DAN PENGENDALIAN</h5>
            </div>
            <div id="collapseBab4" class="collapse" aria-labelledby="headingBab4" data-parent="#accordionSOP">
                <div class="card-body">
                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 10: Pencatatan Hak Cuti</div>
                    <ol class="sop-list">
                        <li>Setiap pengajuan, persetujuan, penolakan, dan penggunaan cuti dicatat dalam administrasi kepegawaian Direktorat Teknologi Informasi.</li>
                        <li>Pengelola administrasi kepegawaian melakukan pencatatan saldo cuti setiap pegawai untuk memastikan jumlah hak cuti yang tersedia.</li>
                        <li>Perhitungan hari cuti dilakukan berdasarkan jenis cuti dan ketentuan yang berlaku untuk masing-masing jenis cuti.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- BAB V -->
        <div class="card">
            <div class="card-header collapsed" id="headingBab5" data-toggle="collapse" data-target="#collapseBab5" aria-expanded="false" aria-controls="collapseBab5">
                <h5 class="card-title">BAB V &nbsp;&mdash;&nbsp; KETENTUAN PENUTUP</h5>
            </div>
            <div id="collapseBab5" class="collapse" aria-labelledby="headingBab5" data-parent="#accordionSOP">
                <div class="card-body">
                    <div class="sop-pasal-title"><i class="fas fa-bookmark"></i> Pasal 11: Penutup</div>
                    <ol class="sop-list">
                        <li>Hal-hal yang belum diatur dalam peraturan ini mengikuti ketentuan peraturan perundang-undangan dan kebijakan Universitas Gadjah Mada yang berlaku.</li>
                        <li>Apabila terdapat ketentuan dalam peraturan ini yang berbeda dengan peraturan perundang-undangan yang lebih tinggi, maka yang berlaku adalah ketentuan peraturan perundang-undangan tersebut.</li>
                        <li>Peraturan ini mulai berlaku sejak tanggal ditetapkan.</li>
                    </ol>

                    <div class="signature-box">
                        <p class="mb-1 text-muted">Yogyakarta, ......................... 2026</p>
                        <p class="mb-4 text-dark" style="font-size: 1.05rem;"><strong>Direktur Teknologi Informasi</strong></p>
                        <br>
                        <p class="mt-4 text-dark" style="font-size: 1.05rem;"><strong>Universitas Gadjah Mada</strong></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->
