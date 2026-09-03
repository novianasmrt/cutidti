<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cuti extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // ✅ MODEL DATABASE
        $this->load->model('User_model');
        $this->load->model('Cuti_model');

        $this->load->library('form_validation');
        $this->load->library('upload');

        // ✅ WAJIB LOGIN
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
    }

    public function index()
    {
        redirect('cuti/pengajuan');
    }

    // ===================================================
    // PENGAJUAN CUTI
    // ===================================================
    public function pengajuan()
    {
        $data['title'] = 'Cuti';
        $data['subtitle'] = 'Pengajuan';

        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);
        
        $this->load->model('Cuti_model');
        $data['user']->sisa_cuti = $this->Cuti_model->hitung_sisa_cuti_tahunan($data['user']->id_user);

        $data['admins'] = $this->User_model->get_admins();

        // Ambil hari libur dari database
        $data['hari_libur'] = $this->db->get('hari_libur')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cuti/pengajuan', $data);
        $this->load->view('templates/footer');
    }

    // ===================================================
    // SIMPAN CUTI
    // ===================================================
    public function simpan()
    {
        $email = $this->session->userdata('email');
        $user = $this->User_model->get_user_by_email($email);

        $jenis_cuti = $this->input->post('jenis_cuti');
        $jumlah_cuti = (int) $this->input->post('jumlah_cuti');

        // Validasi Sisa Cuti Tahunan
        if ($jenis_cuti == 'Cuti Tahunan') {
            if ($jumlah_cuti > $user->sisa_cuti) {
                $this->session->set_flashdata('error', 'Sisa cuti tahunan Anda tidak mencukupi! Sisa saat ini: ' . $user->sisa_cuti . ' hari.');
                redirect('cuti/pengajuan');
                return;
            }
        }

        $lampiran = null;

        if (!empty($_FILES['lampiran']['name'])) {

            $path = realpath(FCPATH . 'assets/lampiran/') . '/';

            if (!is_dir($path)) {
                die('Folder tidak ditemukan: ' . $path);
            }

            $config['upload_path']   = $path;
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = true;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('lampiran')) {
                $lampiran = $this->upload->data('file_name');
            } else {
                echo $this->upload->display_errors();
                die;
            }
        }

        $data_insert = [
            'id_user'       => $user->id_user, // ✅ FIX
            'tgl_pengajuan' => date('Y-m-d'),
            'jenis_cuti'    => $this->input->post('jenis_cuti'),
            'tanggal_mulai'     => $this->input->post('tanggal_mulai'),
            'tanggal_selesai'   => $this->input->post('tanggal_selesai'),
            'tanggal_masuk' => $this->input->post('tanggal_masuk'),
            'jumlah_cuti'   => $this->input->post('jumlah_cuti'),
            'keterangan'    => $this->input->post('keterangan'),
            'alamat'        => $this->input->post('alamat'),
            'atasan_bidang' => $this->input->post('atasan_bidang'),
            'lampiran'      => $lampiran,
            'status'        => 'Menunggu Atasan'
        ];

        $this->Cuti_model->insert_cuti($data_insert);
        
        // --- NOTIFIKASI EMAIL KE ATASAN ---
        $atasan_nama = $this->input->post('atasan_bidang');
        $atasan = $this->db->get_where('user', ['name' => $atasan_nama])->row();
        if ($atasan && $atasan->email) {
            $subject = 'Pengajuan Cuti Baru - Menunggu Persetujuan Anda';
            $message = "Halo {$atasan->name},<br><br>";
            $message .= "Ada pengajuan cuti baru dari <b>{$user->name}</b> yang menunggu persetujuan Anda.<br>";
            $message .= "Silakan login ke aplikasi untuk melihat detail dan memberikan persetujuan.<br><br>";
            $message .= "Terima kasih.";
            $this->_send_email($atasan->email, $subject, $message);
        }

        $this->session->set_flashdata('success', 'Pengajuan cuti berhasil!');
        redirect('cuti/riwayat');
    }

    // ===================================================
    // RIWAYAT CUTI
    // ===================================================
    public function riwayat()
    {
        $data['title'] = 'Cuti';
        $data['subtitle'] = 'Riwayat';

        // ✅ Ambil email dari session
        $email = $this->session->userdata('email');

        // ❌ kalau session kosong → lempar ke login
        if (!$email) {
            redirect('auth');
        }

        // ✅ Ambil user dari DB
        $user = $this->User_model->get_user_by_email($email);

        // ❌ kalau user tidak ditemukan
        if (!$user) {
            redirect('auth/logout');
        }

        $data['user'] = $user;

        // ✅ Ambil data riwayat cuti
        $data['riwayat_cuti'] = $this->Cuti_model->get_cuti_by_user($user->id_user);

        // 🔒 Jaga kalau kosong
        if (!$data['riwayat_cuti']) {
            $data['riwayat_cuti'] = [];
        }

        // LOAD VIEW
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cuti/riwayat', $data);
        $this->load->view('templates/footer');
    }

    // ===================================================
    // DETAIL CUTI
    // ===================================================
    public function detail($id)
    {
        $data['title'] = 'Detail Cuti';
        $data['subtitle'] = 'Detail';

        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        $data['cuti'] = $this->Cuti_model->get_cuti_by_id($id);

        if (!$data['cuti']) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cuti/detailcuti', $data);
        $this->load->view('templates/footer');
    }

    // ===================================================
    // APPROVAL LIST
    // ===================================================
    public function approval()
    {
        $data['title'] = 'Approval Cuti';
        $data['subtitle'] = 'Approval';

        // Ambil user login
        $email = $this->session->userdata('email');
        $user  = $this->User_model->get_user_by_email($email);

        // Validasi user
        if (!$user) {
            redirect('auth/logout');
        }

        $data['user'] = $user;

        // Ambil semua data cuti (OBJECT)
        $data['pengajuan'] = $this->Cuti_model->get_all_cuti();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cuti/approval', $data);
        $this->load->view('templates/footer');
    }
    // ===================================================
    // APPROVAL SAVE
    // ===================================================
    public function approval_save($id)
    {
        $status = $this->input->post('status');
        $ket_approval = $this->input->post('ket_approval');

        // Validasi status
        if (!in_array($status, ['Menunggu', 'Menunggu Atasan', 'Menunggu Sekdir', 'Menunggu Direktur', 'Disetujui', 'Ditolak'])) {
            $this->session->set_flashdata('error', 'Status tidak valid!');
            redirect('cuti/approval');
            return;
        }

        // Update ke database
        $this->Cuti_model->update_status($id, $status, $ket_approval);
        
        // --- LOGIKA NOTIFIKASI EMAIL BERTINGKAT ---
        $cuti = $this->Cuti_model->get_cuti_by_id($id);
        if ($cuti) {
            $pemohon = $this->User_model->get_user_by_id($cuti->id_user);
            
            // 1. Selalu beri tahu pemohon untuk SETIAP perubahan status
            if ($pemohon && $pemohon->email) {
                $subject = 'Update Status Pengajuan Cuti Anda: ' . $status;
                $message = "Halo {$pemohon->name},<br><br>";
                $message .= "Pengajuan cuti Anda yang dimulai pada tanggal <b>" . date('d-m-Y', strtotime($cuti->tanggal_mulai)) . "</b> saat ini telah berubah status menjadi: <b>{$status}</b>.<br>";
                if ($ket_approval) {
                    $message .= "Catatan Approval: {$ket_approval}<br>";
                }
                $message .= "Silakan login ke aplikasi untuk melihat detail surat cuti Anda.<br><br>";
                $message .= "Terima kasih.";
                $this->_send_email($pemohon->email, $subject, $message);
            }

            // 2. Beri tahu approver selanjutnya atau pihak terkait (Direktur untuk TTE)
            if ($status == 'Menunggu Sekdir') {
                // Cari Sekdir (role_id = 3)
                $sekdirs = $this->User_model->get_users_by_role(3);
                foreach ($sekdirs as $sekdir) {
                    if ($sekdir->email) {
                        $subject = 'Pengajuan Cuti Lanjutan - Menunggu Persetujuan Anda';
                        $message = "Halo {$sekdir->name},<br><br>";
                        $message .= "Pengajuan cuti dari <b>{$pemohon->name}</b> telah disetujui oleh Atasan Bidang dan kini menunggu persetujuan Anda sebagai Sekretaris Direktur.<br>";
                        $message .= "Silakan login ke sistem untuk memproses pengajuan ini.<br><br>";
                        $message .= "Terima kasih.";
                        $this->_send_email($sekdir->email, $subject, $message);
                    }
                }
            } elseif ($status == 'Menunggu Direktur' || $status == 'Disetujui') {
                // Jika Menunggu Direktur, Direktur perlu menyetujui.
                // Jika Disetujui (oleh Sekdir/Admin), dokumen siap untuk dibubuhkan/TTE Direktur.
                $direkturs = $this->User_model->get_users_by_role(4);
                foreach ($direkturs as $direktur) {
                    if ($direktur->email) {
                        $subject = $status == 'Disetujui' ? 'Dokumen Cuti Siap untuk TTE Direktur' : 'Pengajuan Cuti Final - Menunggu Persetujuan Anda';
                        $message = "Halo {$direktur->name},<br><br>";
                        if ($status == 'Disetujui') {
                            $message .= "Pengajuan cuti dari <b>{$pemohon->name}</b> telah Disetujui dan dokumennya sudah siap untuk dibubuhkan Tanda Tangan Elektronik (TTE) Anda.<br>";
                        } else {
                            $message .= "Pengajuan cuti dari <b>{$pemohon->name}</b> telah disetujui oleh Sekretaris Direktur dan kini menunggu persetujuan akhir Anda sebagai Direktur.<br>";
                        }
                        $message .= "Silakan login ke sistem untuk memproses pengajuan atau membubuhkan TTE pada dokumen terkait.<br><br>";
                        $message .= "Terima kasih.";
                        $this->_send_email($direktur->email, $subject, $message);
                    }
                }
            }

            // Recalculate sisa cuti if status changed
            $this->Cuti_model->hitung_sisa_cuti_tahunan($cuti->id_user);
        }

        $this->session->set_flashdata('success', 'Status berhasil diupdate!');
        redirect('admin/datacuti');
    }

    public function approvalform($id)
    {
        $data['title'] = 'Form Approval';
        $data['subtitle'] = 'Approval';

        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        // ✅ AMBIL DATA CUTI BERDASARKAN ID
        $data['p'] = $this->Cuti_model->get_cuti_by_id($id);

        // ❗ CEK kalau data tidak ditemukan
        if (!$data['p']) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cuti/approvalform', $data);
        $this->load->view('templates/footer');
    }

    // ===================================================
    // SEND EMAIL NOTIFICATION (PRIVATE)
    // ===================================================
    private function _send_email($to_email, $subject, $message_body)
    {
        // Pastikan ada email tujuan
        if (empty($to_email)) return false;

        $this->load->library('email');

        // Note: Pengaturan SMTP sudah ada di config/email.php
        $this->email->from('no-reply@cutisistem.com', 'Sistem Cuti');
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message_body);

        return $this->email->send();
    }
}
