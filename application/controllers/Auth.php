<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->database();
    }

    public function index()
    {
        // Kalau sudah login
        if ($this->session->userdata('email')) {
            redirect('admin');
        }

        // Validasi form
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('auth/login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // ✅ Ambil user dari DATABASE (bukan dummy)
        $user = $this->db->get_where('user', ['email' => $email])->row();

        if ($user) {

            // cek aktif
            if ($user->is_active == 1) {

                // ✅ CEK PASSWORD HASH
                if (password_verify($password, $user->password)) {

                    // SET SESSION
                    $data = [
                        'email'   => $user->email,
                        'name'    => $user->name,
                        'id_user' => $user->id_user,

                        // legacy (boleh tetap ada)
                        'role_id' => $user->role_id,

                        // ✅ WAJIB UNTUK SWITCH ROLE
                        'role_id_original' => $user->role_id,
                        'role_id_active'   => $user->role_id
                    ];
                    $this->session->set_userdata($data);

                    // Redirect berdasarkan role
                    if (in_array($user->role_id, [1, 3, 4, 5])) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger">Password salah!</div>'
                    );
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger">Akun belum aktif!</div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger">Email tidak terdaftar!</div>'
            );
            redirect('auth');
        }
    }

    // ================= REGISTER =================
    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'required|trim|min_length[3]|matches[password2]'
        );
        $this->form_validation->set_rules('password2', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Registration';
            $this->load->view('auth/registration', $data);
        } else {

            // ✅ HASH PASSWORD
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            // ✅ SIMPAN KE DATABASE
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => $password,
                'role_id' => 2, // default user
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success">Akun berhasil dibuat, silakan login!</div>'
            );
            redirect('auth');
        }
    }
    // ================= SWITCH Role =================
    public function switch_role()
    {
        // Ambil role sekarang
        $current_role = $this->session->userdata('role_id_active');
        $original_role = $this->session->userdata('role_id_original');

        // Toggle role
        if (in_array($current_role, [1, 3, 4, 5])) {
            // dari admin/direksi → pegawai
            $this->session->set_userdata('role_id_active', 2);
            redirect('user');
        } else {
            // dari pegawai → admin
            $this->session->set_userdata('role_id_active', $original_role);
            redirect('admin');
        }
    }

    // ================= LOGOUT =================
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('id_user');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">Berhasil logout!</div>'
        );

        redirect('auth');
    }
}
