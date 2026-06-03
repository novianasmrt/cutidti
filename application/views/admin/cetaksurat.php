<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Cuti - <?= $cuti->nama; ?></title>
    
    <style>
        @page { size: A4; margin: 2cm; }
        @media print {
            body { background: none !important; -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
        }
        body { font-family: "Times New Roman", Times, serif; font-size: 11pt; margin: 0; padding: 0; background-color: #eee; }
        .no-print { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        
        /* Helper Class */
        .tbl-border { width: 100%; border-collapse: collapse; }
        .tbl-border td, .tbl-border th { border: 1px solid black; padding: 4px; }
        .box-check { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; margin-right: 5px; }
        .bg-black { background-color: #000; }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" style="background-color: #003366; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">
            🖨️ CETAK DOKUMEN
        </button>
    </div>

    <div style="width: 210mm; min-height: 297mm; background: #fff; padding: 1.5cm 2cm; margin: 20px auto; box-sizing: border-box; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <div style="position: relative; border-bottom: 3px double #000; padding-bottom: 15px; margin-bottom: 20px;">
            <img src="<?= base_url('assets/img/ugm-logo.png'); ?>" 
                 style="position: absolute; left: 0; top: -10px; width: 80px; height: auto;" 
                 alt="Logo UGM">

            <div style="margin-left: 90px;">
                <h2 style="margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase;">UNIVERSITAS GADJAH MADA</h2>
                <p style="margin: 2px 0 0 0; font-size: 10pt; line-height: 1.2;">
                    Bulaksumur, Yogyakarta 55281, Telp. +62 274 588688, +62 274 562011, Fax. +62 274 565223<br>
                    http://ugm.ac.id, E-mail: setr@ugm.ac.id
                </p>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <u style="font-weight: bold; font-size: 12pt; text-transform: uppercase;">SURAT IZIN CUTI TAHUNAN</u><br>
            <span>Nomor: <?= !empty($cuti->no_surat) ? htmlspecialchars($cuti->no_surat) : ($cuti->id_cuti . '/UN1/DTI/KP.05.01/' . date('Y')); ?></span>
        </div>

        <div style="text-align: justify; line-height: 1.5;">
            <p style="margin-top: 0;">1. Diberikan cuti tahunan untuk tahun <?= date('Y'); ?> kepada Pegawai Negeri Sipil UGM:</p>
            
            <table style="width: 100%; margin-left: 20px; margin-bottom: 15px;">
                <tr><td style="width: 130px;">Nama</td><td style="width: 10px;">:</td><td style="font-weight: bold;"><?= $cuti->nama; ?></td></tr>
                <tr><td>NIP / NIU</td><td>:</td><td><?= $cuti->nip; ?></td></tr>
                <tr><td>Pangkat/Gol.</td><td>:</td><td><?= $cuti->pangkat ?? '-'; ?></td></tr>
                <tr><td>Jabatan</td><td>:</td><td><?= $cuti->jabatan; ?></td></tr>
                <tr><td>Unit Kerja</td><td>:</td><td><?= $cuti->unit_kerja ?? '-'; ?></td></tr>
            </table>

            <?php 
                // PERBAIKAN LOGIKA TANGGAL SESUAI DUMMY MODEL
                // Di Model pakai 'tgl_mulai' bukan 'tanggal_mulai'
                $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                
                $ts_mulai   = strtotime($cuti->tanggal_mulai);
                $ts_selesai = strtotime($cuti->tanggal_selesai);
                
                $tgl1_s = date('j', $ts_mulai) . ' ' . $bulan[(int)date('n', $ts_mulai)] . ' ' . date('Y', $ts_mulai);
                $tgl2_s = date('j', $ts_selesai) . ' ' . $bulan[(int)date('n', $ts_selesai)] . ' ' . date('Y', $ts_selesai);
            ?>

            <p style="margin-bottom: 5px;">
                selama <strong><?= $cuti->jumlah_cuti; ?> Hari</strong>, yaitu pada tanggal <strong><?= $tgl1_s; ?> s/d <?= $tgl2_s; ?></strong> dengan ketentuan sebagai berikut:
            </p>
            <ol type="a" style="margin-top: 0; padding-left: 40px;">
                <li style="margin-bottom: 5px;">Sebelum menjalankan cuti wajib menyerahkan pekerjaannya kepada atasan langsung.</li>
                <li style="margin-bottom: 5px;">Selama cuti bersedia dipanggil sewaktu-waktu jika mendesak.</li>
                <li style="margin-bottom: 5px;">Setelah selesai cuti wajib melaporkan diri kepada atasan langsung.</li>
            </ol>
            <p>2. Demikian surat izin cuti ini dibuat untuk digunakan sebagaimana mestinya.</p>
        </div>

        <div style="float: right; width: 300px; margin-top: 30px; text-align: left;">
            <div>Yogyakarta, <?= date('j') . ' ' . $bulan[(int)date('n')] . ' ' . date('Y'); ?></div>
            <div style="margin-bottom: 10px;">Sekretaris<br>Direktur Teknologi Informasi</div>
            
            <?php 
            $nama_sekdir = isset($sekdir) && $sekdir ? $sekdir->name : 'Sekretaris Direktur';
            $nip_sekdir = isset($sekdir) && $sekdir ? $sekdir->nip : '...................';
            $qr_sekdir = "Tanda Tangan Digital\nNama: " . $nama_sekdir . "\nNIP: " . $nip_sekdir;
            ?>
            <img src="https://quickchart.io/qr?text=<?= rawurlencode($qr_sekdir); ?>&size=100" alt="QR Sekdir" style="margin-bottom: 10px;">

            <div style="font-weight: bold; text-decoration: underline;">
                <?= $nama_sekdir; ?>
            </div>
            <div>NIP. <?= $nip_sekdir; ?></div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="page-break"></div>

    <div style="width: 210mm; min-height: 297mm; background: #fff; padding: 1.5cm 2cm; margin: 20px auto; box-sizing: border-box; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <div style="text-align: right; margin-bottom: 20px; font-size: 10pt;">
            Yogyakarta, <?= date('j') . ' ' . $bulan[(int)date('n')] . ' ' . date('Y'); ?><br>
            Kepada Yth. Direktur Sumber Daya Manusia UGM<br>
            di Yogyakarta
        </div>

        <div style="text-align: center; font-size: 12pt; font-weight: bold; margin-bottom: 15px;">
            FORMULIR PERMINTAAN DAN PEMBERIAN CUTI
        </div>

        <div style="border: 1px solid black; margin-bottom: 10px;">
            <div style="font-weight: bold; padding: 5px; border-bottom: 1px solid black;">I. DATA PEGAWAI</div>
            <table class="tbl-border" style="border: none;">
                <tr>
                    <td style="width: 15%; border: none; border-right: 1px solid black;">Nama</td>
                    <td style="width: 35%; border: none; border-right: 1px solid black;"><?= $cuti->nama; ?></td>
                    <td style="width: 15%; border: none; border-right: 1px solid black;">NIP/NIU</td>
                    <td style="width: 35%; border: none;"><?= $cuti->nip; ?></td>
                </tr>
                <tr style="border-top: 1px solid black;">
                    <td style="border: none; border-right: 1px solid black;">Jabatan</td>
                    <td style="border: none; border-right: 1px solid black;"><?= $cuti->jabatan; ?></td>
                    <td style="border: none; border-right: 1px solid black;">Pangkat/Gol</td>
                    <td style="border: none;"><?= $cuti->pangkat ?? '-'; ?></td>
                </tr>
                <tr style="border-top: 1px solid black;">
                    <td style="border: none; border-right: 1px solid black;">Unit Kerja</td>
                    <td colspan="3" style="border: none;"><?= $cuti->unit_kerja ?? '-'; ?></td>
                </tr>
            </table>
        </div>

        <div style="border: 1px solid black; margin-bottom: 10px;">
            <div style="font-weight: bold; padding: 5px; border-bottom: 1px solid black;">II. JENIS CUTI YANG DIAMBIL</div>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; padding: 2px;">
                        <span class="box-check <?= stripos($cuti->jenis_cuti, 'Tahunan')!==false ? 'bg-black' : ''; ?>"></span> 1. Cuti Tahunan
                    </td>
                    <td style="width: 50%; padding: 2px;">
                        <span class="box-check <?= stripos($cuti->jenis_cuti, 'Besar')!==false ? 'bg-black' : ''; ?>"></span> 2. Cuti Besar
                    </td>
                </tr>
                <tr>
                    <td style="padding: 2px;">
                        <span class="box-check <?= stripos($cuti->jenis_cuti, 'Sakit')!==false ? 'bg-black' : ''; ?>"></span> 3. Cuti Sakit
                    </td>
                    <td style="padding: 2px;">
                        <span class="box-check <?= stripos($cuti->jenis_cuti, 'Melahirkan')!==false ? 'bg-black' : ''; ?>"></span> 4. Cuti Melahirkan
                    </td>
                </tr>
                <tr>
                    <td style="padding: 2px;">
                        <span class="box-check <?= stripos($cuti->jenis_cuti, 'Penting')!==false ? 'bg-black' : ''; ?>"></span> 5. Cuti Alasan Penting
                    </td>
                    <td style="padding: 2px;">
                        <span class="box-check <?= stripos($cuti->jenis_cuti, 'Luar')!==false ? 'bg-black' : ''; ?>"></span> 6. Cuti Luar Tanggungan
                    </td>
                </tr>
            </table>
        </div>

        <div style="border: 1px solid black; margin-bottom: 10px;">
            <div style="font-weight: bold; padding: 5px; border-bottom: 1px solid black;">III. ALASAN CUTI</div>
            <div style="padding: 5px; min-height: 30px;">
                <?= $cuti->keterangan; ?>
            </div>
        </div>

        <div style="border: 1px solid black; margin-bottom: 10px;">
            <div style="font-weight: bold; padding: 5px; border-bottom: 1px solid black;">IV. LAMA CUTI</div>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 15%; padding: 4px; border-right: 1px solid black;">Selama</td>
                    <td style="width: 25%; padding: 4px; border-right: 1px solid black;"><?= $cuti->jumlah_cuti; ?> Hari</td>
                    <td style="width: 15%; padding: 4px; border-right: 1px solid black;">Tanggal</td>
                    <td style="padding: 4px;"><?= $tgl1_s; ?> s/d <?= $tgl2_s; ?></td>
                </tr>
            </table>
        </div>

        <div style="border: 1px solid black; margin-bottom: 10px;">
            <div style="font-weight: bold; padding: 5px; border-bottom: 1px solid black;">V. CATATAN CUTI</div>
            <table class="tbl-border">
                <tr style="text-align: center; background-color: #f0f0f0;">
                    <td style="width: 20%;">Tahun</td>
                    <td style="width: 15%;">Sisa</td>
                    <td style="width: 30%;">Keterangan</td>
                    <td style="width: 35%;">TTD Pejabat</td>
                </tr>
                <tr>
                    <td>N-2</td>
                    <td style="text-align: center;">-</td>
                    <td></td>
                    <td rowspan="3" style="vertical-align: middle; text-align: center; color: #ccc;">(Paraf)</td>
                </tr>
                <tr>
                    <td>N-1</td>
                    <td style="text-align: center;">-</td>
                    <td></td>
                </tr>
                <tr>
                    <td>N (Berjalan)</td>
                    <td style="text-align: center;"><?= $cuti->sisa_cuti ?? 12; ?></td>
                    <td></td>
                </tr>
            </table>
        </div>

        <div style="border: 1px solid black; margin-bottom: 10px;">
            <div style="font-weight: bold; padding: 5px; border-bottom: 1px solid black;">VI. ALAMAT SELAMA MENJALANKAN CUTI</div>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 60%; padding: 4px; vertical-align: top; height: 60px;">
                        <?= $cuti->alamat ?? '-'; ?>
                    </td>
                    <td style="width: 40%; padding: 4px; vertical-align: top;">
                        Telp: <?= $cuti->no_telpon ?? '-'; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 10px; text-align: right;">
                        <div style="display: inline-block; text-align: center; width: 200px;">
                            Hormat saya,<br>
                            <?php $qr_pemohon = "Tanda Tangan Digital\nNama: " . $cuti->nama . "\nNIP: " . $cuti->nip; ?>
                            <img src="https://quickchart.io/qr?text=<?= rawurlencode($qr_pemohon); ?>&size=90" alt="QR Pemohon" style="margin-top: 10px; margin-bottom: 10px;"><br>
                            <u style="font-weight: bold;"><?= $cuti->nama; ?></u><br>
                            NIP/NIU. <?= $cuti->nip; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="width: 50%; padding-right: 5px; vertical-align: top;">
                    <div style="border: 1px solid black; height: 100%;">
                        <div style="font-weight: bold; padding: 5px; border-bottom: 1px solid black;">VII. PERTIMBANGAN ATASAN LANGSUNG</div>
                        <div style="padding: 10px;">
                            <span class="box-check <?= $cuti->status=='Disetujui' ? 'bg-black' : ''; ?>"></span> DISETUJUI<br>
                            <span class="box-check <?= $cuti->status=='Menunggu' ? 'bg-black' : ''; ?>"></span> DITANGGUHKAN<br>
                            <span class="box-check <?= $cuti->status=='Ditolak' ? 'bg-black' : ''; ?>"></span> TIDAK DISETUJUI
                        </div>
                        <div style="text-align: center; margin-top: 15px; margin-bottom: 10px;">
                            <?php 
                            $nama_atasan = $cuti->atasan_bidang ?? 'Nama Atasan';
                            $nip_atasan = isset($atasan) && $atasan ? $atasan->nip : '...................';
                            $qr_atasan = "Tanda Tangan Digital\nNama: " . $nama_atasan . "\nNIP: " . $nip_atasan;
                            ?>
                            <img src="https://quickchart.io/qr?text=<?= rawurlencode($qr_atasan); ?>&size=90" alt="QR Atasan" style="margin-bottom: 5px;"><br>
                            <u style="font-weight: bold;"><?= $nama_atasan; ?></u><br>
                            NIP. <?= $nip_atasan; ?>
                        </div>
                    </div>
                </td>
                
                <td style="width: 50%; padding-left: 5px; vertical-align: top;">
                    <div style="border: 1px solid black; height: 100%;">
                        <div style="font-weight: bold; padding: 5px; border-bottom: 1px solid black;">VIII. KEPUTUSAN PEJABAT BERWENANG</div>
                        <div style="padding: 10px;">
                            <span class="box-check <?= $cuti->status=='Disetujui' ? 'bg-black' : ''; ?>"></span> DISETUJUI<br>
                            <span class="box-check"></span> PERUBAHAN<br>
                            <span class="box-check <?= $cuti->status=='Ditolak' ? 'bg-black' : ''; ?>"></span> DITOLAK
                        </div>
                        <div style="text-align: center; margin-top: 15px; margin-bottom: 10px;">
                            <img src="https://quickchart.io/qr?text=<?= rawurlencode($qr_sekdir); ?>&size=90" alt="QR Sekdir" style="margin-bottom: 5px;"><br>
                            <u style="font-weight: bold;"><?= $nama_sekdir; ?></u><br>
                            NIP. <?= $nip_sekdir; ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>