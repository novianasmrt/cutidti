<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->model('Cuti_model');

        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
    }

    // ===============================================================
    // DASHBOARD
    // ===============================================================
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['subtitle'] = 'Dashboard';

        $email = $this->session->userdata('email');
        $user  = $this->User_model->get_user_by_email($email);

        if (!$user) {
            redirect('auth/logout');
        }

        $data['user'] = $user;

        // ===============================
        // AMBIL DATA CUTI
        // ===============================
        $my_cuti = $this->Cuti_model->get_cuti_by_user($user->id_user);

        // Pastikan selalu array
        if (!is_array($my_cuti)) {
            $my_cuti = [];
        }

        $cuti_terpakai = 0;
        $pending = 0;
        $calendar_events = [];

        // ===============================
        // BACKGROUND WEEKEND
        // ===============================
        $calendar_events[] = [
            'groupId' => 'weekend',
            'daysOfWeek' => [0, 6],
            'display' => 'background'
        ];

        // ===============================
        // HARI LIBUR NASIONAL (DB)
        // ===============================
        $hari_libur = $this->db->get('hari_libur')->result();
        foreach ($hari_libur as $libur) {
            $calendar_events[] = [
                'title' => $libur->keterangan,
                'start' => $libur->tanggal,
                'color' => '#ff6b6b',
                'textColor' => '#ffffff',
                'allDay' => true
            ];
        }

        // ===============================
        // LOOP DATA CUTI
        // ===============================
        foreach ($my_cuti as $c) {

            // AMANIN ARRAY
            $status        = $c->status ?? '';
            $jenis_cuti    = $c->jenis_cuti ?? '';
            $tgl_mulai     = $c->tgl_mulai ?? null;
            $tgl_selesai   = $c->tgl_selesai ?? null;
            $jumlah_cuti   = (int) ($c->jumlah_cuti ?? 0);

            // HITUNG PENDING
            if ($status === 'Menunggu') {
                $pending++;
            }

            // HITUNG CUTI TERPAKAI + CALENDAR
            if ($status === 'Disetujui') {

                $cuti_terpakai += $jumlah_cuti;

                if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
                    $calendar_events[] = [
                        'title' => 'Cuti (' . $jenis_cuti . ')',
                        'start' => $tgl_mulai,
                        'end'   => date('Y-m-d', strtotime($tgl_selesai . ' +1 day')),
                        'color' => '#003366',
                        'textColor' => '#ffffff'
                    ];
                }
            }
        }

        // ===============================
        // SORT TERBARU (AMAN NULL)
        // ===============================
        usort($my_cuti, function ($a, $b) {
            $tglA = !empty($a->tgl_pengajuan) ? strtotime($a->tgl_pengajuan) : 0;
            $tglB = !empty($b->tgl_pengajuan) ? strtotime($b->tgl_pengajuan) : 0;
            return $tglB - $tglA;
        });

        // ===============================
        // LAST SUBMISSION
        // ===============================
        $last_submission = !empty($my_cuti) ? $my_cuti[0] : null;

        // ===============================
        // DATA KE VIEW
        // ===============================
        $data['stats'] = (object) [
            'sisa_cuti'     => $user->sisa_cuti ?? 0,
            'cuti_terpakai' => $cuti_terpakai,
            'pending'       => $pending,
            'last_sub'      => $last_submission
        ];

        $data['json_events']  = json_encode($calendar_events);
        $data['riwayat_cuti'] = $my_cuti;

        // ===============================
        // LOAD VIEW
        // ===============================
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }
    // ===============================================================
    // PROFILE
    // ===============================================================
    public function profile()
    {
        $data['title'] = 'Profile';
        $data['subtitle'] = 'Profile';

        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/profile', $data);
        $this->load->view('templates/footer');
    }

    // ===============================================================
    // EDIT PROFILE
    // ===============================================================
    public function editprofile()
    {
        $data['title'] = 'Edit Profile';
        $data['subtitle'] = 'Profile';

        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/editprofile', $data);
            $this->load->view('templates/footer');
        } else {

            // =====================
            // UPLOAD FOTO (FIX)
            // =====================
            // =====================
            // UPLOAD FOTO
            // =====================
            $image = $data['user']->image; // default pakai lama

            if (!empty($_FILES['image']['name'])) { // ✅ FIX: harus "image"

                $config['upload_path']   = './assets/img/profile/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['file_name']     = 'profile_' . time();

                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) { // ✅ FIX

                    $new_image = $this->upload->data('file_name');

                    // =====================
                    // HAPUS FOTO LAMA (AMAN)
                    // =====================
                    if (
                        !empty($data['user']->image) &&
                        $data['user']->image != 'default.png'
                    ) {
                        $old_path = FCPATH . 'assets/img/profile/' . $data['user']->image;

                        if (file_exists($old_path) && is_file($old_path)) {
                            unlink($old_path);
                        }
                    }

                    $image = $new_image;
                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>'
                    );
                    redirect('user/editprofile');
                    return;
                }
            }

            // =====================
            // UPDATE DATA
            // =====================
            $update = [
                'id_user'        => $data['user']->id_user,
                'name'           => $this->input->post('name'),
                'no_telpon'      => $this->input->post('no_telpon'), // ✅ FIX: dari view
                'nip'            => $this->input->post('nip'),     // ✅ FIX: mapping
                'jenis_pegawai'  => $this->input->post('jenis_pegawai'),
                'kategori'       => $this->input->post('kategori'),
                'tipe_pegawai'   => $this->input->post('tipe_pegawai'),
                'unit_kerja'     => $this->input->post('unit_kerja'),
                'jabatan'        => $this->input->post('jabatan'),
                'pangkat'        => $this->input->post('pangkat'),
                'image'          => $image
            ];

            $this->User_model->update($update);

            // update session biar langsung berubah di UI
            $this->session->set_userdata([
                'name'  => $update['name'],
                'image' => $image
            ]);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success">Profile berhasil diupdate!</div>'
            );

            redirect('user/profile');

            $this->User_model->update($update);

            // update session
            $this->session->set_userdata('name', $update['name']);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success">Profile berhasil diupdate!</div>'
            );

            redirect('user/profile');
        }
    }

    // ===============================================================
    // CHANGE PASSWORD
    // ===============================================================
    public function changepassword()
    {
        $data['title'] = 'Change Password';
        $data['subtitle'] = 'Profile';

        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm Password', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {

            if (!password_verify($this->input->post('current_password'), $data['user']->password)) {

                $this->session->set_flashdata('message', '<div class="alert alert-danger">Password saat ini salah!</div>');
                redirect('user/changepassword');
            }

            $new_password = password_hash($this->input->post('new_password1'), PASSWORD_DEFAULT);

            $this->User_model->update([
                'id_user' => $data['user']->id_user,
                'password' => $new_password
            ]);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Password berhasil diubah!</div>');
            redirect('user/profile');
        }
    }
}
