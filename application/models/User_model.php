<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    // ==============================
    // 1. AMBIL SEMUA USER
    // ==============================
    public function get_all_users()
    {
        return $this->db
            ->select('user.*, user_role.role')
            ->from('user')
            ->join('user_role', 'user_role.id_role = user.role_id', 'left')
            ->order_by('user.id_user', 'DESC')
            ->get()
            ->result(); // ✅ OBJECT
    }

    // ==============================
    // 1B. AMBIL SEMUA ADMIN
    // ==============================
    public function get_admins()
    {
        return $this->db
            ->select('user.*, user_role.role')
            ->from('user')
            ->join('user_role', 'user_role.id_role = user.role_id', 'left')
            ->where_in('user.role_id', [1, 3])
            ->order_by('user.name', 'ASC')
            ->get()
            ->result(); // ✅ OBJECT
    }

    // ==============================
    // 2. AMBIL USER BY ID
    // ==============================
    public function get_user_by_id($id)
    {
        $user = $this->db
            ->select('user.*, user_role.role')
            ->from('user')
            ->join('user_role', 'user_role.id_role = user.role_id', 'left')
            ->where('user.id_user', $id)
            ->get()
            ->row(); // ✅ OBJECT
            
        if ($user) {
            $this->load->model('Cuti_model');
            $user->sisa_cuti = $this->Cuti_model->hitung_sisa_cuti_tahunan($user->id_user);
        }
        
        return $user;
    }

    // ==============================
    // 3. AMBIL USER BY EMAIL (LOGIN)
    // ==============================
    public function get_user_by_email($email)
    {
        $user = $this->db
            ->select('user.*, user_role.role')
            ->from('user')
            ->join('user_role', 'user_role.id_role = user.role_id', 'left')
            ->where('user.email', $email)
            ->get()
            ->row(); // ✅ OBJECT
            
        if ($user) {
            $this->load->model('Cuti_model');
            $user->sisa_cuti = $this->Cuti_model->hitung_sisa_cuti_tahunan($user->id_user);
        }
        
        return $user;
    }

    // ==============================
    // 4. INSERT USER
    // ==============================
    public function insert_user($data)
    {
        return $this->db->insert('user', $data);
    }

    // ==============================
    // 5. UPDATE USER
    // ==============================
    public function update($data)
    {
        $this->db->where('id_user', $data['id_user']);
        return $this->db->update('user', $data);
    }

    // ==============================
    // 6. DELETE USER
    // ==============================
    public function delete_user($id)
    {
        return $this->db
            ->where('id_user', $id)
            ->delete('user');
    }

    // ==============================
    // 7. CEK EMAIL SUDAH ADA ATAU BELUM
    // ==============================
    public function check_email_exists($email)
    {
        return $this->db
            ->where('email', $email)
            ->get('user')
            ->row(); // ✅ OBJECT
    }
    public function search_users($keyword)
    {
        $this->db->select('user.*, user_role.role');
        $this->db->from('user');
        $this->db->join('user_role', 'user_role.id_role = user.role_id', 'left');

        $this->db->group_start();
        $this->db->like('user.name', $keyword);
        $this->db->or_like('user.email', $keyword);
        $this->db->or_like('user.nip', $keyword);
        $this->db->group_end();

        return $this->db->get()->result(); // OBJECT
    }
}
