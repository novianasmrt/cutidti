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
            $role_id = $this->session->userdata('role_id_active') ?? $this->session->userdata('role_id');
            if (in_array($role_id, [1, 3, 4, 5])) {
                redirect('admin');
            } else {
                redirect('user');
            }
        }

        // Inisialisasi Google Client
        require_once APPPATH . '../vendor/autoload.php';
        $this->load->config('google');

        $client = new Google_Client();
        $client->setClientId($this->config->item('google_client_id'));
        $client->setClientSecret($this->config->item('google_client_secret'));
        $client->setRedirectUri($this->config->item('google_redirect_uri'));
        $client->addScope("email");
        $client->addScope("profile");

        $data['google_login_url'] = $client->createAuthUrl();
        $data['title'] = 'Login Page';
        
        $this->load->view('auth/login', $data);
    }

    public function google_callback()
    {
        require_once APPPATH . '../vendor/autoload.php';
        $this->load->config('google');

        $client = new Google_Client();
        $client->setClientId($this->config->item('google_client_id'));
        $client->setClientSecret($this->config->item('google_client_secret'));
        $client->setRedirectUri($this->config->item('google_redirect_uri'));

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (!isset($token['error'])) {
                $client->setAccessToken($token['access_token']);
                
                $google_service = new Google_Service_Oauth2($client);
                $data = $google_service->userinfo->get();
                
                $email = $data['email'];

                // Cek apakah email ada di database
                $user = $this->db->get_where('user', ['email' => $email])->row();

                if ($user) {
                    if ($user->is_active == 1) {
                        // SET SESSION
                        $session_data = [
                            'email'   => $user->email,
                            'name'    => $user->name,
                            'id_user' => $user->id_user,
                            'role_id' => $user->role_id,
                            'role_id_original' => $user->role_id,
                            'role_id_active'   => $user->role_id
                        ];
                        $this->session->set_userdata($session_data);

                        // Redirect berdasarkan role
                        if (in_array($user->role_id, [1, 3, 4, 5])) {
                            redirect('admin');
                        } else {
                            redirect('user');
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
                        '<div class="alert alert-danger">Email tidak terdaftar di sistem!</div>'
                    );
                    redirect('auth');
                }
            } else {
                redirect('auth');
            }
        } else {
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
