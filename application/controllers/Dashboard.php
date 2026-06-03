<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        // Data Dummy untuk simulasi database
        $data['title'] = 'Dashboard - Sistem Cuti';
        $data['user'] = 'Noviana'; // Sesuai gambar
        
        // Data Statistik Kartu
        $data['stats'] = (object) [
            'sisa_cuti' => 10,
            'cuti_berjalan' => 0,
            'riwayat' => 2,
            'status_pending' => 0
        ];

        // Data Tabel Riwayat
        $data['riwayat_cuti'] = [
            [
                'tgl_pengajuan' => '2025-09-01',
                'mulai' => '2025-09-05',
                'selesai' => '2025-09-10',
                'masuk' => '2025-09-11',
                'keterangan' => 'Cuti tahunan keluarga',
                'status' => 'Disetujui',
                'badge' => 'success'
            ],
            [
                'tgl_pengajuan' => '2025-09-15',
                'mulai' => '2025-09-20',
                'selesai' => '2025-09-22',
                'masuk' => '2025-09-23',
                'keterangan' => 'Acara pernikahan saudara',
                'status' => 'Menunggu',
                'badge' => 'warning'
            ]
        ];

        $this->load->view('dashboard_view', $data);
    }
}