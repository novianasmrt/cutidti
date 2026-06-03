<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Cuti</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; }
        .header p { margin: 5px 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        
        /* Hilangkan elemen ini saat diprint jika ada */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2 style="text-transform: uppercase;">Laporan Rekapitulasi Cuti Pegawai</h2>
        <p>Periode: <?= $periode; ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th>Nama Pegawai</th>
                <th>NIP</th>
                <th>Jenis Cuti</th>
                <th style="text-align: center;">Tanggal Cuti</th>
                <th style="text-align: center;">Lama</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($laporan)) : ?>
                <?php $no = 1; foreach($laporan as $row) : ?>
                <tr>
                    <td style="text-align: center;"><?= $no++; ?></td>
                    <td>
                        <strong><?= $row->nama; ?></strong>
                    </td>
                    <td><?= $row->nip; ?></td>
                    <td><?= $row->jenis_cuti; ?></td>
                    <td style="text-align: center;">
                        <?= date('d M Y', strtotime($row->tanggal_mulai ?? $row->tgl_mulai)); ?> - <?= date('d M Y', strtotime($row->tanggal_selesai ?? $row->tgl_selesai)); ?>
                    </td>
                    <td style="text-align: center;"><?= $row->jumlah_cuti ?? $row->lama; ?> Hari</td>
                    <td style="text-align: center; text-transform: uppercase; font-size: 10px;">
                        <?= $row->status; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">Data tidak ditemukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; margin-right: 50px;">
        <p>Yogyakarta, <?= date('d F Y'); ?></p>
        <br><br><br>
        <p><strong>( Admin HRD )</strong></p>
    </div>

    <script>
        // Otomatis membuka dialog print saat halaman dimuat
        window.print();
    </script>
</body>
</html>