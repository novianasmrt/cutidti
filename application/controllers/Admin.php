<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Cuti_model');
    }

    // ===============================================================
    // DASHBOARD
    // ===============================================================
    public function index()
    {
        // ==============================
        // 1. SETUP
        // ==============================
        $data['title'] = 'Dashboard';
        $data['subtitle'] = 'Dashboard Admin';

        // ==============================
        // 2. USER LOGIN
        // ==============================
        $email = $this->session->userdata('email');

        if (!$email) {
            redirect('auth/logout');
        }

        $data['user'] = $this->User_model->get_user_by_email($email);

        // ==============================
        // 3. AMBIL DATA CUTI + USER
        // ==============================
        $this->db->select('cuti.*, user.name');
        $this->db->from('cuti');
        $this->db->join('user', 'user.id_user = cuti.id_user', 'left');
        $all_cuti = $this->db->get()->result(); // ✅ object

        // ambil jumlah staff
        $total_pegawai = $this->db->count_all('user');

        // ==============================
        // 4. HITUNG STATISTIK
        // ==============================
        $pending = 0;
        $disetujui = 0;
        $ditolak = 0;
        $cuti_hari_ini = 0;
        $request_bulan_ini = 0;

        $today = date('Y-m-d');
        $bulan = date('Y-m');

        foreach ($all_cuti as $c) {

            // STATUS
            if ($c->status == 'Menunggu') {
                $pending++;
            } elseif ($c->status == 'Disetujui') {
                $disetujui++;
            } elseif ($c->status == 'Ditolak') {
                $ditolak++;
            }

            // BULAN INI
            if (!empty($c->tgl_pengajuan)) {
                if (date('Y-m', strtotime($c->tgl_pengajuan)) == $bulan) {
                    $request_bulan_ini++;
                }
            }

            // CUTI HARI INI
            if ($c->status == 'Disetujui' && !empty($c->tgl_mulai) && !empty($c->tgl_selesai)) {
                if ($today >= $c->tgl_mulai && $today <= $c->tgl_selesai) {
                    $cuti_hari_ini++;
                }
            }
        }

        $data['stats'] = (object) [
            'total_pegawai'   => $total_pegawai,
            'status_pending'  => $pending,
            'disetujui'       => $disetujui,
            'ditolak'         => $ditolak,
            'cuti_hari_ini'   => $cuti_hari_ini,
            'req_bulan_ini'   => $request_bulan_ini
        ];

        // ==============================
        // 5. CUTI BULAN INI
        // ==============================
        $cuti_bulan_ini = [];
        foreach ($all_cuti as $c) {
            if (!empty($c->tgl_pengajuan)) {
                if (date('Y-m', strtotime($c->tgl_pengajuan)) == $bulan) {
                    $cuti_bulan_ini[] = $c;
                }
            }
        }

        usort($cuti_bulan_ini, function ($a, $b) {
            $a_date = !empty($a->tgl_pengajuan) ? strtotime($a->tgl_pengajuan) : 0;
            $b_date = !empty($b->tgl_pengajuan) ? strtotime($b->tgl_pengajuan) : 0;
            return $b_date - $a_date;
        });

        $data['cuti_bulan_ini'] = $cuti_bulan_ini;

        // ==============================
        // 6. KALENDER EVENTS
        // ==============================
        $events = [];

        // Weekend
        $events[] = [
            'groupId' => 'weekend',
            'daysOfWeek' => [0, 6],
            'display' => 'background',
            'backgroundColor' => '#ffacac'
        ];

        // Libur Nasional (Dinamis dari DB)
        $hari_libur = $this->db->get('hari_libur')->result();
        foreach ($hari_libur as $libur) {
            $events[] = [
                'title' => $libur->keterangan,
                'start' => $libur->tanggal,
                'color' => '#ff6b6b',
                'allDay' => true
            ];
        }

        foreach ($all_cuti as $c) {

            if ($c->status != 'Disetujui') continue;
            if (empty($c->tgl_mulai) || empty($c->tgl_selesai)) continue;

            // WARNA BERDASARKAN JENIS
            $color = '#003366';

            if (stripos($c->jenis_cuti, 'Sakit') !== false) {
                $color = '#f2994a';
            } elseif (stripos($c->jenis_cuti, 'Alasan Penting') !== false) {
                $color = '#6fcf97';
            } elseif (stripos($c->jenis_cuti, 'Tahunan') !== false) {
                $color = '#85a6ff';
            }

            $events[] = [
                'title' => ($c->name ?? 'User') . ' (' . $c->jenis_cuti . ')',
                'start' => $c->tgl_mulai,
                'end'   => date('Y-m-d', strtotime($c->tgl_selesai . ' +1 day')),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'allDay' => true
            ];
        }

        $data['json_events'] = json_encode($events);

        // ==============================
        // 6B. GRAFIK DISTRIBUSI CUTI PER ATASAN BIDANG
        // ==============================
        // 1. Ambil semua admin yang dapat dipilih sebagai atasan bidang
        $all_admins = $this->User_model->get_admins();
        
        // 2. Inisialisasi map nama atasan -> 0
        $atasan_map = [];
        foreach ($all_admins as $admin) {
            $atasan_map[$admin->name] = 0;
        }

        // 3. Ambil data cuti disetujui dari database
        $chart_query = $this->db->select('atasan_bidang, COUNT(id_cuti) as total_cuti')
            ->from('cuti')
            ->where('status', 'Disetujui')
            ->where('atasan_bidang IS NOT NULL')
            ->where('atasan_bidang !=', '')
            ->group_by('atasan_bidang')
            ->get()
            ->result();

        // 4. Update nilai dari database ke map
        // Hanya update jika nama ada di daftar admin saat ini (skip nama lama yang sudah diubah)
        foreach ($chart_query as $row) {
            if (array_key_exists($row->atasan_bidang, $atasan_map)) {
                $atasan_map[$row->atasan_bidang] = (int) $row->total_cuti;
            }
        }

        // 5. Susun ke array label dan data
        $chart_labels = [];
        $chart_data = [];
        foreach ($atasan_map as $nama_atasan => $total_cuti) {
            $chart_labels[] = $nama_atasan;
            $chart_data[] = $total_cuti;
        }

        $data['chart_labels'] = json_encode($chart_labels);
        $data['chart_data'] = json_encode($chart_data);

        // ==============================
        // 7. LOAD VIEW
        // ==============================
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    // ===============================================================
    // DATA STAFF (SUDAH DIPERBAIKI SESUAI Dummy_model ANDA)
    // ===============================================================
    public function datastaff()
    {
        $data['title'] = 'Data Staff';
        $data['subtitle'] = 'Data Staff';

        // USER LOGIN
        $email = $this->session->userdata('email');
        if (!$email) {
            redirect('auth/logout');
        }

        $data['user'] = $this->User_model->get_user_by_email($email);

        // AMBIL DATA STAFF
        $keyword = $this->input->get('keyword'); // pakai GET biar konsisten dengan search bar
        $data['keyword'] = $keyword;

        if (!empty($keyword)) {
            $data['staff'] = $this->User_model->search_users($keyword);
        } else {
            $data['staff'] = $this->User_model->get_all_users();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/datastaff', $data);
        $this->load->view('templates/footer');
    }

    // ===============================================================
    // DETAIL STAFF (SUDAH DIPERBAIKI SESUAI Dummy_model ANDA)
    // ===============================================================
    public function detailstaff($id)
    {
        $data['title'] = 'Detail Staff';
        $data['subtitle'] = 'Data Staff';

        // USER LOGIN
        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        // 🔥 AMBIL DATA STAFF DARI DATABASE (BUKAN DUMMY)
        $data['staff'] = $this->User_model->get_user_by_id($id);

        // ❗ CEK DATA ADA ATAU TIDAK
        if (!$data['staff']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/datastaff');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/detailstaff', $data);
        $this->load->view('templates/footer');
    }

    // ===============================================================
    // EDIT STAFF (FORM)
    // ===============================================================
    public function editstaff($id)
    {
        $data['title'] = 'Edit Staff';
        $data['subtitle'] = 'Data Staff';

        // USER LOGIN
        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        // AMBIL DATA STAFF DARI DATABASE
        $data['staff'] = $this->User_model->get_user_by_id($id);

        // CEK DATA ADA ATAU TIDAK
        if (!$data['staff']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/datastaff');
        }

        // AMBIL DAFTAR ADMIN UNTUK PILIHAN ATASAN BIDANG
        $data['admins'] = $this->User_model->get_admins();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/editstaff', $data);
        $this->load->view('templates/footer');
    }

    // ===============================================================
    // PROSES UPDATE STAFF
    // ===============================================================
    public function update_staff()
    {
        $id_user = $this->input->post('id_user');
        $current_user = $this->User_model->get_user_by_id($id_user);

        if (!$current_user) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User tidak ditemukan!</div>');
            redirect('admin/datastaff');
        }

        // Validasi Form
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nip', 'NIP/NIU', 'required|numeric');

        // Jika email diubah, validasi uniqueness
        if ($this->input->post('email') != $current_user->email) {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        }

        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[5]');
        }

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, tampilkan form edit lagi
            $this->editstaff($id_user);
        } else {
            // Upload Foto jika ada
            $foto = $current_user->image;
            $upload_image = $_FILES['foto']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '5048'; // 5MB
                $config['upload_path']   = './assets/img/profile/';
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    $new_image = $this->upload->data('file_name');
                    
                    // Hapus foto lama jika bukan default.jpg
                    if ($foto && $foto != 'default.jpg') {
                        $old_path = FCPATH . 'assets/img/profile/' . $foto;
                        if (file_exists($old_path) && is_file($old_path)) {
                            unlink($old_path);
                        }
                    }
                    $foto = $new_image;
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error . '</div>');
                    redirect('admin/editstaff/' . $id_user);
                    return;
                }
            }

            // Siapkan data update
            $update_data = [
                'id_user'        => $id_user,
                'name'           => htmlspecialchars($this->input->post('nama', true)),
                'nip'            => htmlspecialchars($this->input->post('nip', true)),
                'email'          => htmlspecialchars($this->input->post('email', true)),
                'no_telpon'      => htmlspecialchars($this->input->post('no_telpon', true)),
                'jenis_pegawai'  => htmlspecialchars($this->input->post('jenis_pegawai', true)),
                'kategori'       => htmlspecialchars($this->input->post('kategori', true)),
                'tipe_pegawai'   => htmlspecialchars($this->input->post('tipe_pegawai', true)),
                'unit_kerja'     => htmlspecialchars($this->input->post('unit_kerja', true)),
                'jabatan'        => htmlspecialchars($this->input->post('jabatan', true)),
                'pangkat'        => htmlspecialchars($this->input->post('pangkat', true)),
                'atasan_bidang'  => $this->input->post('atasan_bidang') ? htmlspecialchars($this->input->post('atasan_bidang', true)) : null,
                'sisa_cuti'      => (int)$this->input->post('sisa_cuti'),
                'role_id'        => $this->input->post('role_id'),
                'image'          => $foto
            ];

            // Update password jika diisi
            if ($this->input->post('password')) {
                $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $this->User_model->update($update_data);

            // ✅ Sync nama atasan_bidang di tabel cuti jika nama berubah
            // (karena atasan_bidang menyimpan nama sebagai teks, bukan ID)
            $nama_baru = htmlspecialchars($this->input->post('nama', true));
            $nama_lama = $current_user->name;
            if ($nama_baru !== $nama_lama) {
                $this->db->where('atasan_bidang', $nama_lama);
                $this->db->update('cuti', ['atasan_bidang' => $nama_baru]);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data staff berhasil diperbarui!</div>');
            redirect('admin/datastaff');
        }
    }
    // Menampilkan Halaman Tambah Staff
    // ===============================================================
    // HALAMAN TAMBAH STAFF (FORM)
    // ===============================================================
    public function tambahstaff()
    {
        $data['title'] = 'Tambah Staff Baru';
        $data['subtitle'] = 'Tambah Staff';

        $email_login = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email_login);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/tambahstaff', $data);
        $this->load->view('templates/footer');
    }

    // ===============================================================
    // FUNGSI IMPORT EXCEL (SIMULASI DUMMY)
    // ===============================================================
    public function import_excel()
    {
        // 1. Konfigurasi Upload File
        $upload_file = $_FILES['file_excel']['name'];
        $extension = pathinfo($upload_file, PATHINFO_EXTENSION);

        // Validasi Ekstensi
        if ($extension == 'csv' || $extension == 'xls' || $extension == 'xlsx') {

            $config['upload_path']      = './assets/temp_excel/';
            $config['allowed_types']    = 'csv|xls|xlsx';
            $config['max_size']         = '5048'; // 5MB
            $config['file_name']        = 'import_' . time();

            $this->load->library('upload', $config);

            // 2. Proses Upload
            if ($this->upload->do_upload('file_excel')) {

                $file_excel = $this->upload->data();

                // Pastikan library PhpSpreadsheet terload (Jika pakai Composer)
                // require 'vendor/autoload.php'; 

                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($extension));
                $spreadsheet = $reader->load($file_excel['full_path']);
                $sheetdata = $spreadsheet->getActiveSheet()->toArray();

                // 3. Looping Data
                $jumlah_sukses = 0;

                $existing_users = $this->User_model->get_all_users();

                for ($i = 1; $i < count($sheetdata); $i++) {

                    // Cek baris tidak kosong (Nama di index 0, NIP di index 1, Email di index 2)
                    if (!empty($sheetdata[$i][0]) && !empty($sheetdata[$i][2])) {

                        $nama_excel = trim($sheetdata[$i][0]);
                        $nip_excel = trim($sheetdata[$i][1] ?? '');
                        $email_excel = trim($sheetdata[$i][2]);
                        $jabatan_excel = trim($sheetdata[$i][3] ?? 'Staff');

                        // LOGIKA CEK DUPLIKAT
                        $is_duplicate = false;
                        foreach ($existing_users as $u) {
                            if ($u->email == $email_excel) {
                                $is_duplicate = true;
                                break;
                            }
                        }

                        if (!$is_duplicate) {
                            $data_insert = [
                                'name'          => htmlspecialchars($nama_excel),
                                'nip'           => htmlspecialchars($nip_excel),
                                'email'         => htmlspecialchars($email_excel),
                                'image'         => 'default.jpg',
                                'password'      => password_hash('12345', PASSWORD_DEFAULT), // Default password
                                'role_id'       => 2, // Default Staff
                                'jabatan'       => htmlspecialchars($jabatan_excel),
                                'is_active'     => 1,
                                'date_created'  => time(),
                                'sisa_cuti_2025'=> 0,
                                'sisa_cuti'     => 0
                            ];
                            $this->db->insert('user', $data_insert);
                            $jumlah_sukses++;
                        }
                    }
                }

                // 4. Hapus File Excel
                if (file_exists($file_excel['full_path'])) {
                    unlink($file_excel['full_path']);
                }

                // 5. Feedback ke User
                if ($jumlah_sukses > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> Mengimport ' . $jumlah_sukses . ' data pegawai baru.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Pemberitahuan:</strong> Tidak ada data baru yang diimport atau format file salah.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>');
                }

                redirect('admin/datastaff');
            } else {
                // Gagal Upload
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal Upload: ' . strip_tags($error) . '</div>');
                redirect('admin/tambahstaff');
            }
        } else {
            // Ekstensi Salah
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Format file salah! Harap upload file Excel.</div>');
            redirect('admin/tambahstaff');
        }
    }

    // Proses Penyimpanan Data ke Database
    public function simpan_staff()
    {
        // 1. Atur Aturan Validasi
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('nip', 'NIP/NIU', 'required|numeric');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');

        if ($this->form_validation->run() == false) {
            // Jika validasi form gagal, kembalikan ke halaman form
            $this->tambahstaff();
        } else {
            // 3. Konfigurasi Upload Foto
            $foto = 'default.jpg';
            $upload_image = $_FILES['foto']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '5048'; // 5MB
                $config['upload_path']   = './assets/img/profile/';
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    $new_image = $this->upload->data('file_name');
                    $foto = $new_image;
                } else {
                    // Jika gagal upload, tampilkan error
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error . '</div>');
                    redirect('admin/tambahstaff');
                    return;
                }
            }

            // 4. SIAPKAN DATA
            $data_insert = [
                'name'          => htmlspecialchars($this->input->post('nama', true)),
                'nip'           => htmlspecialchars($this->input->post('nip', true)),
                'email'         => htmlspecialchars($this->input->post('email', true)),
                'image'         => $foto,
                'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id'       => $this->input->post('role_id'),
                'jabatan'       => htmlspecialchars($this->input->post('jabatan', true)),
                'is_active'     => 1,
                'date_created'  => time(),
                'sisa_cuti_2025'=> 0,
                'sisa_cuti'     => 0
            ];

            // 5. INSERT DATABASE
            $this->db->insert('user', $data_insert);

            // 6. Redirect dengan Pesan Sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Staff baru berhasil ditambahkan!</div>');
            redirect('admin/datastaff');
        }
    }

    // ===============================================================
    // DATA CUTI (DUMMY)
    // ===============================================================
    public function datacuti()
    {
        $data['title'] = 'Data Cuti';
        $data['subtitle'] = 'Data Cuti';

        // ==============================
        // 1. USER LOGIN
        // ==============================
        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        if (!$data['user']) {
            redirect('auth/logout');
        }

        // ==============================
        // 2. AMBIL DATA CUTI (DATABASE)
        // ==============================
        $this->db->select('cuti.*, user.name as nama, user.nip');
        $this->db->from('cuti');
        $this->db->join('user', 'user.id_user = cuti.id_user', 'left');

        // ==============================
        // 3. FILTER STATUS (OPSIONAL)
        // ==============================
        $status = $this->input->get('status');
        if ($status) {
            $this->db->where('cuti.status', $status);
        }

        $this->db->order_by('cuti.id_cuti', 'DESC');

        $data['data_cuti'] = $this->db->get()->result(); // ✅ OBJECT

        // ==============================
        // 4. STATISTIK
        // ==============================
        $data['total_data'] = count($data['data_cuti']);
        $data['pending'] = 0;
        $data['disetujui'] = 0;

        foreach ($data['data_cuti'] as $d) {
            if ($d->status == 'Menunggu') $data['pending']++;
            if ($d->status == 'Disetujui') $data['disetujui']++;
        }

        // ==============================
        // 5. LOAD VIEW
        // ==============================
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/datacuti', $data);
        $this->load->view('templates/footer');
    }
    public function cetaksurat($id)
    {
        // 1. AMBIL DATA DARI DATABASE LANGSUNG
        $this->db->select('cuti.*, user.name as nama, user.nip, user.jabatan, user.pangkat, user.unit_kerja, user.no_telpon, user.sisa_cuti');
        $this->db->from('cuti');
        $this->db->join('user', 'user.id_user = cuti.id_user', 'left');
        $this->db->where('cuti.id_cuti', $id);
        $data_ditemukan = $this->db->get()->row();

        // 3. VALIDASI: DATA TIDAK DITEMUKAN
        if (!$data_ditemukan) {
            show_error('Data cuti tidak ditemukan (ID: ' . $id . ').', 404);
            return;
        }

        // 4. VALIDASI: STATUS BELUM DISETUJUI
        // Surat resmi biasanya hanya boleh dicetak kalau sudah "Disetujui"
        if ($data_ditemukan->status != 'Disetujui') {
            echo "<script>
                    alert('Maaf, surat tidak dapat dicetak karena status dokumen masih: " . $data_ditemukan->status . "');
                    window.history.back(); 
                  </script>";
            return;
        }

        // 5. PERSIAPAN DATA UNTUK VIEW

        // A. Ambil Data User yang sedang login (Admin)
        // Kita kasih "Fallback" email dummy kalau session belum jalan, biar nggak error saat testing
        $email_login = $this->session->userdata('email') ? $this->session->userdata('email') : 'ferry.teguh@ugm.ac.id';
        $data['user_login'] = $this->User_model->get_user_by_email($email_login);

        $data['cuti'] = $data_ditemukan;

        // C. Ambil Data Sekdir (Role ID = 3)
        $data['sekdir'] = $this->db->get_where('user', ['role_id' => 3])->row();

        // D. Ambil Data Atasan Bidang berdasarkan nama yang tersimpan
        $data['atasan'] = $this->db->get_where('user', ['name' => $data_ditemukan->atasan_bidang])->row();

        // E. Ambil Data Direktur (Role ID = 4)
        $data['direktur'] = $this->db->get_where('user', ['role_id' => 4])->row();

        // 6. LOAD VIEW CETAK
        // PERBAIKAN: Kirim variable $data, BUKAN $id
        // Pastikan nama file view-nya benar 'admin/cetaksurat.php'
        $this->load->view('admin/cetaksurat', $data);
    }
    // ===============================================================
    // HALAMAN LAPORAN (FILTERING)
    // ===============================================================
    public function laporan()
    {
        $data['title'] = 'User';
        $data['subtitle'] = 'Laporan';

        // 1. AMBIL USER LOGIN
        $email_login = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email_login);

        // 2. AMBIL PARAMETER FILTER
        $tgl_awal  = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $status    = $this->input->get('status');

        // Default status jika tidak dipilih adalah 'Disetujui' (Biar laporan rapi)
        // Tapi kalau mau menampilkan semua di awal, bisa ubah jadi '' (kosong)
        if ($status === null) $status = 'Disetujui';

        // 3. AMBIL SEMUA DATA CUTI (DARI DATABASE)
        $semua_data = $this->Cuti_model->get_all_cuti();
        $data_filtered = [];

        // 4. LOGIKA FILTERING
        foreach ($semua_data as $row) {
            // Support backward compatibility between dummy property and real property
            $tanggal_mulai = $row->tanggal_mulai ?? $row->tgl_mulai ?? null;

            // Filter Tanggal Awal
            if (!empty($tgl_awal) && $tanggal_mulai < $tgl_awal) continue;

            // Filter Tanggal Akhir
            if (!empty($tgl_akhir) && $tanggal_mulai > $tgl_akhir) continue;

            // Filter Status (Jika status tidak kosong/semua)
            if ($status != '' && $row->status != $status) continue;

            // Jika lolos semua filter, masukkan ke array
            $data_filtered[] = $row;
        }

        $data['laporan']  = $data_filtered;
        $data['f_status'] = $status; // Untuk menjaga value dropdown tetap terpilih

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/laporan', $data);
        $this->load->view('templates/footer');
    }

    // ===============================================================
    // EXPORT EXCEL (DOWNLOAD HELPER)
    // ===============================================================
    public function excel()
    {
        // 1. AMBIL PARAMETER FILTER (Sama seperti Laporan)
        $tgl_awal  = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $status    = $this->input->get('status');
        if ($status === null) $status = 'Disetujui';

        // 2. AMBIL DATA (DATABASE)
        $semua_data = $this->Cuti_model->get_all_cuti();
        $data_filtered = [];

        // 3. FILTERING
        foreach ($semua_data as $row) {
            $tanggal_mulai = $row->tanggal_mulai ?? $row->tgl_mulai ?? null;

            if (!empty($tgl_awal) && $tanggal_mulai < $tgl_awal) continue;
            if (!empty($tgl_akhir) && $tanggal_mulai > $tgl_akhir) continue;
            if ($status != '' && $row->status != $status) continue;
            
            $data_filtered[] = $row;
        }

        $data['laporan'] = $data_filtered;

        // Label Periode untuk Judul Excel
        $data['periode'] = empty($tgl_awal) ? 'Semua Periode' : date('d M Y', strtotime($tgl_awal)) . ' s/d ' . date('d M Y', strtotime($tgl_akhir));

        // 4. DOWNLOAD EXCEL
        // Pastikan view 'admin/laporanexcel' hanya berisi tabel HTML murni (tanpa template admin)
        $this->load->helper('download');
        $filename = "Laporan_Cuti_" . date('Ymd_His') . ".xls";

        // Load view ke dalam variabel string
        $html_content = $this->load->view('admin/laporanexcel', $data, TRUE);

        force_download($filename, $html_content);
    }

    // ===============================================================
    // EXPORT PDF
    // ===============================================================
    public function pdf()
    {
        // 1. AMBIL PARAMETER FILTER
        $tgl_awal  = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $status    = $this->input->get('status');
        if ($status === null) $status = 'Disetujui';

        // 2. AMBIL DATA (DATABASE)
        $semua_data = $this->Cuti_model->get_all_cuti();
        $data_filtered = [];

        // 3. FILTERING
        foreach ($semua_data as $row) {
            $tanggal_mulai = $row->tanggal_mulai ?? $row->tgl_mulai ?? null;

            if (!empty($tgl_awal) && $tanggal_mulai < $tgl_awal) continue;
            if (!empty($tgl_akhir) && $tanggal_mulai > $tgl_akhir) continue;
            if ($status != '' && $row->status != $status) continue;
            
            $data_filtered[] = $row;
        }

        $data['laporan'] = $data_filtered;
        $data['periode'] = empty($tgl_awal) ? 'Semua Periode' : date('d M Y', strtotime($tgl_awal)) . ' s/d ' . date('d M Y', strtotime($tgl_akhir));

        // 4. LOAD VIEW PDF
        // Pastikan view 'admin/laporanpdf' memiliki window.print() otomatis
        $this->load->view('admin/laporanpdf', $data);
    }
    // Fungsi untuk mengubah status
    public function ubah_status_staff($id_user, $status_baru)
    {
        $this->db->where('id_user', $id_user);
        $this->db->update('user', ['is_active' => $status_baru]);

        if ($status_baru == 0) {
            // Jika user dimatikan
            $pesan = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Berhasil Dinonaktifkan!</strong> Pegawai kini tidak dapat login.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
        } else {
            // Jika user dihidupkan
            $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil Diaktifkan!</strong> Pegawai kini dapat login kembali.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
        }

        // Set notifikasi
        $this->session->set_flashdata('message', $pesan);

        // Kembalikan ke halaman tabel staff
        redirect('admin/datastaff');
    }

    // ===============================================================
    // FITUR KALENDER HARI LIBUR
    // ===============================================================
    public function datalibur()
    {
        $data['title'] = 'Hari Libur';
        $data['subtitle'] = 'Kalender Libur';

        $email = $this->session->userdata('email');
        if (!$email) redirect('auth');

        $data['user'] = $this->User_model->get_user_by_email($email);
        
        $this->db->order_by('tanggal', 'ASC');
        $data['libur'] = $this->db->get('hari_libur')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/datalibur', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_libur()
    {
        $data = [
            'tanggal' => $this->input->post('tanggal', true),
            'keterangan' => htmlspecialchars($this->input->post('keterangan', true))
        ];

        $this->db->insert('hari_libur', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Hari libur berhasil ditambahkan!</div>');
        redirect('admin/datalibur');
    }

    public function hapus_libur($id)
    {
        $this->db->where('id_libur', $id);
        $this->db->delete('hari_libur');
        $this->session->set_flashdata('message', '<div class="alert alert-success">Hari libur berhasil dihapus!</div>');
        redirect('admin/datalibur');
    }

    public function input_no_surat()
    {
        // Pastikan hanya role Admin SDM (5) yang bisa input
        $role_id = $this->session->userdata('role_id_active') ?? $this->session->userdata('role_id');
        if ($role_id != 5) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak memiliki akses!</div>');
            redirect('admin/datacuti');
            return;
        }

        $id_cuti = $this->input->post('id_cuti');
        $no_surat = $this->input->post('no_surat');

        $this->db->where('id_cuti', $id_cuti);
        $this->db->update('cuti', ['no_surat' => $no_surat]);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Nomor surat berhasil disimpan!</div>');
        redirect('admin/datacuti');
    }

    // ===============================================================
    // SYNC ATASAN BIDANG DI TABEL CUTI (DATA HISTORIS)
    // Dipanggil sekali untuk memperbaiki nama lama yang masih tersimpan
    // URL: admin/sync_atasan_cuti
    // ===============================================================
    public function sync_atasan_cuti()
    {
        // Ambil semua admin/atasan yang ada di tabel user saat ini
        $all_admins = $this->User_model->get_admins();

        // Buat map id_user -> nama terbaru
        $nama_admin_map = [];
        foreach ($all_admins as $admin) {
            $nama_admin_map[$admin->id_user] = $admin->name;
        }

        // Ambil semua nilai atasan_bidang unik yang ada di tabel cuti
        $distinct_atasan = $this->db
            ->select('DISTINCT atasan_bidang')
            ->where('atasan_bidang IS NOT NULL')
            ->where('atasan_bidang !=', '')
            ->get('cuti')
            ->result();

        $updated = 0;
        $not_found = [];

        foreach ($distinct_atasan as $row) {
            $nama_di_cuti = $row->atasan_bidang;

            // Cek apakah nama ini masih ada di tabel user
            $match = $this->db
                ->where('name', $nama_di_cuti)
                ->where_in('role_id', [1, 3])
                ->get('user')
                ->row();

            if (!$match) {
                // Nama sudah tidak ada — cari admin berdasarkan kemiripan (LIKE)
                $kemungkinan = $this->db
                    ->like('name', explode(' ', $nama_di_cuti)[0])
                    ->where_in('role_id', [1, 3])
                    ->get('user')
                    ->row();

                if ($kemungkinan) {
                    // Update record cuti yang masih pakai nama lama
                    $this->db->where('atasan_bidang', $nama_di_cuti);
                    $this->db->update('cuti', ['atasan_bidang' => $kemungkinan->name]);
                    $updated++;
                } else {
                    $not_found[] = $nama_di_cuti;
                }
            }
        }

        $msg = "Sync selesai. $updated nama atasan berhasil diperbarui.";
        if (!empty($not_found)) {
            $msg .= " Nama berikut tidak dapat dipetakan otomatis: " . implode(', ', $not_found);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-info">' . $msg . '</div>');
        redirect('admin/datacuti');
    }
}
