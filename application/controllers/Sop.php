<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sop extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');

        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'SOP Cuti';
        $data['subtitle'] = 'SOP';

        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_user_by_email($email);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sop/index', $data);
        $this->load->view('templates/footer');
    }
}
