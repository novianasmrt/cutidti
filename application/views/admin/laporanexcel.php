<?php
// Skrip untuk memaksa download file Excel (.xls)
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Cuti_" . date('Ymd') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Excel</title>
    <style>
        .header { font-size: 14px; font-weight: bold; text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #4CAF50; color: white; padding: 10px; border: 1px solid #000; }
        td { padding: 8px; border: 1px solid #000; vertical-align: middle; }
    </style>
</head>
<body>
    
    <div class="header">
        LAPORAN REKAPITULASI CUTI PEGAWAI<br>
        Periode: <?= $periode; ?>
    </div>
    <br>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="25%">NAMA PEGAWAI</th>
                <th width="20%">JENIS CUTI</th>
                <th width="20%">TANGGAL CUTI</th>
                <th width="15%">LAMA</th>
                <th width="15%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($laporan)) : ?>
                <?php $no = 1; foreach($laporan as $row) : ?>
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td><?= $row->nama; ?></td>
                    <td><?= $row->jenis_cuti; ?></td>
                    <td align="center">
                        '<?= date('d/m/Y', strtotime($row->tanggal_mulai ?? $row->tgl_mulai)); ?> - <?= date('d/m/Y', strtotime($row->tanggal_selesai ?? $row->tgl_selesai)); ?>
                    </td>
                    <td align="center"><?= $row->jumlah_cuti ?? $row->lama; ?> Hari</td>
                    <td align="center"><?= $row->status; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" align="center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>