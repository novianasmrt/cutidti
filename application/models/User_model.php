<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->auto_rollover_cuti();
    }

    // ==============================
    // RESET CUTI OTOMATIS TAHUN BARU
    // ==============================
    public function auto_rollover_cuti()
    {
        $current_year = (int) date('Y');
        
        $this->db->where('tahun_reset_cuti <', $current_year);
        $this->db->or_where('tahun_reset_cuti IS NULL');
        $users = $this->db->get('user')->result();
        
        if (!empty($users)) {
            foreach ($users as $u) {
                $n = (int) $u->cuti_n;
                $n1 = (int) $u->cuti_n1;
                $n2 = (int) $u->cuti_n2;
                
                $last_year = (int) $u->tahun_reset_cuti;
                if ($last_year == 0) $last_year = $current_year - 1;
                
                $diff = $current_year - $last_year;
                
                if ($diff == 1) {
                    // Cek apakah 2 tahun berturut-turut tidak pernah cuti (N dan N1 masih utuh 12)
                    if ($n == 12 && $n1 == 12) {
                        // Berhak dapat 24 hari (N1 baru = 12, N2 = hangus)
                        $new_n1 = 12;
                        $new_n2 = 0;
                    } else {
                        // Pernah cuti: hanya N tahun ini yang bisa dibawa, maks 6 hari → jadi N1 baru
                        // N1 lama & N2 lama → hangus (tidak dibawa lagi)
                        $new_n1 = min(6, $n);
                        $new_n2 = 0; // selalu hangus
                    }
                    $new_n = 12; // jatah baru
                } elseif ($diff >= 2) {
                    $new_n2 = 0;
                    $new_n1 = min(6, $n); 
                    $new_n = 12;
                } else {
                    continue;
                }
                
                $this->db->where('id_user', $u->id_user);
                $this->db->update('user', [
                    'cuti_n' => $new_n,
                    'cuti_n1' => $new_n1,
                    'cuti_n2' => $new_n2,
                    'tahun_reset_cuti' => $current_year
                ]);
            }
        }
    }

    // ==============================
    // 1. AMBIL SEMUA USER
    // ==============================
    public function get_all_users()
    {
        return $this->db
            ->select('user.*, (user.cuti_n + user.cuti_n1 + user.cuti_n2) AS sisa_cuti, user_role.role')
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
            ->select('user.*, (user.cuti_n + user.cuti_n1 + user.cuti_n2) AS sisa_cuti, user_role.role')
            ->from('user')
            ->join('user_role', 'user_role.id_role = user.role_id', 'left')
            ->where_in('user.role_id', [1, 3])
            ->order_by('user.name', 'ASC')
            ->get()
            ->result(); // ✅ OBJECT
    }

    // ==============================
    // 1C. AMBIL USER BERDASARKAN ROLE
    // ==============================
    public function get_users_by_role($role_id)
    {
        return $this->db
            ->select('user.*, (user.cuti_n + user.cuti_n1 + user.cuti_n2) AS sisa_cuti, user_role.role')
            ->from('user')
            ->join('user_role', 'user_role.id_role = user.role_id', 'left')
            ->where('user.role_id', $role_id)
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
            ->select('user.*, (user.cuti_n + user.cuti_n1 + user.cuti_n2) AS sisa_cuti, user_role.role')
            ->from('user')
            ->join('user_role', 'user_role.id_role = user.role_id', 'left')
            ->where('user.id_user', $id)
            ->get()
            ->row(); // ✅ OBJECT
        
        return $user;
    }

    // ==============================
    // 3. AMBIL USER BY EMAIL (LOGIN)
    // ==============================
    public function get_user_by_email($email)
    {
        $user = $this->db
            ->select('user.*, (user.cuti_n + user.cuti_n1 + user.cuti_n2) AS sisa_cuti, user_role.role')
            ->from('user')
            ->join('user_role', 'user_role.id_role = user.role_id', 'left')
            ->where('user.email', $email)
            ->get()
            ->row(); // ✅ OBJECT
        
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
