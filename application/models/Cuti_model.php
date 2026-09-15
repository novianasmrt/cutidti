<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cuti_model extends CI_Model
{
    // ==============================
    // 1. INSERT CUTI
    // ==============================
    public function insert_cuti($data)
    {
        return $this->db->insert('cuti', $data);
    }

    // ==============================
    // HELPER: HITUNG TGL MASUK
    // ==============================
    private function _process_cuti_results($results)
    {
        // Ambil hari libur dari database
        $holiday_query = $this->db->get('hari_libur')->result();
        $holidays = [];
        foreach ($holiday_query as $h) {
            $holidays[] = $h->tanggal;
        }

        foreach ($results as $cuti) {

            // Alias biar aman di view
            if (!isset($cuti->nama)) {
                $cuti->nama = $cuti->name ?? '-';
            }

            if (!isset($cuti->nip)) {
                $cuti->nip = '-';
            }

            if (!isset($cuti->jabatan)) {
                $cuti->jabatan = '-';
            }

            // ==========================
            // HITUNG TANGGAL MASUK
            // ==========================
            if (!empty($cuti->tgl_selesai)) {

                $next = strtotime($cuti->tgl_selesai . ' +1 day');

                while (true) {
                    $hari = date('l', $next);
                    $tanggal = date('Y-m-d', $next);

                    $is_weekend = ($hari == 'Saturday' || $hari == 'Sunday');
                    $is_holiday = in_array($tanggal, $holidays);

                    if (!$is_weekend && !$is_holiday) {
                        break;
                    }

                    $next = strtotime('+1 day', $next);
                }

                $cuti->tgl_masuk = date('Y-m-d', $next);
            } else {
                $cuti->tgl_masuk = null;
            }
        }

        return $results;
    }

    // ==============================
    // 2. CUTI BY USER
    // ==============================
    public function get_cuti_by_user($id_user)
    {
        $this->db->select('
        cuti.*,
        user.name,
        user.nip,
        user.jabatan,
        user.no_telpon,
        user.role_id as requester_role_id
    ');

        $this->db->from('cuti');
        $this->db->join('user', 'user.id_user = cuti.id_user', 'left');
        $this->db->where('cuti.id_user', $id_user);

        // ✅ pastikan kolom ini ADA di DB
        $this->db->order_by('cuti.tgl_pengajuan', 'DESC');

        $query = $this->db->get();

        // 🔒 HANDLE kalau kosong (biar ga error di view)
        if (!$query || $query->num_rows() == 0) {
            return [];
        }

        return $query->result(); // ✅ object
    }
    // Alias
    public function get_cuti_by_user_id($id_user)
    {
        return $this->get_cuti_by_user($id_user);
    }

    // ==============================
    // 3. SEMUA DATA CUTI (ADMIN)
    // ==============================
    public function get_all_cuti()
    {
        $this->db->select('cuti.*, user.name, user.nip, user.jabatan, user.role_id as requester_role_id');
        $this->db->from('cuti');
        $this->db->join('user', 'user.id_user = cuti.id_user', 'left');
        $this->db->order_by('cuti.tgl_pengajuan', 'DESC');

        $results = $this->db->get()->result();

        return $this->_process_cuti_results($results);
    }

    // ==============================
    // 4. DETAIL CUTI
    // ==============================
    public function get_cuti_by_id($id)
    {
        $this->db->select('cuti.*, user.name, user.nip, user.jabatan, user.no_telpon, (user.cuti_n + user.cuti_n1 + user.cuti_n2) AS sisa_cuti, user.cuti_n, user.cuti_n1, user.cuti_n2, user.role_id as requester_role_id');
        $this->db->from('cuti');
        $this->db->join('user', 'user.id_user = cuti.id_user', 'left');
        $this->db->where('cuti.id_cuti', $id);

        return $this->db->get()->row(); // ✅ OBJECT
    }

    // ==============================
    // 5. UPDATE STATUS
    // ==============================
    public function update_status($id, $status, $ket_approval = null)
    {
        $this->db->where('id_cuti', $id);
        $data = ['status' => $status];
        
        if ($ket_approval !== null) {
            $data['ket_approval'] = $ket_approval;
        }
        
        // Simpan tanggal approval direktur (final) agar muncul di surat
        if ($status === 'Disetujui') {
            $data['tanggal_disetujui'] = date('Y-m-d H:i:s');
            $CI =& get_instance();
            $role_aktif = $CI->session->userdata('role_id_active') ?? $CI->session->userdata('role_id');
            if ($role_aktif == 4) {
                $data['ttd_direktur'] = date('Y-m-d H:i:s');
            }
            
            // DEDUCT BUCKETS JIKA CUTI TAHUNAN
            $cuti = $this->db->get_where('cuti', ['id_cuti' => $id])->row();
            if ($cuti && $cuti->jenis_cuti == 'Cuti Tahunan') {
                $user = $this->db->get_where('user', ['id_user' => $cuti->id_user])->row();
                if ($user) {
                    $sisa_potong = (int)$cuti->jumlah_cuti;
                    
                    $n2 = (int)$user->cuti_n2;
                    $n1 = (int)$user->cuti_n1;
                    $n  = (int)$user->cuti_n;
                    
                    if ($sisa_potong > 0 && $n2 > 0) {
                        $potong = min($sisa_potong, $n2);
                        $n2 -= $potong;
                        $sisa_potong -= $potong;
                    }
                    if ($sisa_potong > 0 && $n1 > 0) {
                        $potong = min($sisa_potong, $n1);
                        $n1 -= $potong;
                        $sisa_potong -= $potong;
                    }
                    if ($sisa_potong > 0 && $n > 0) {
                        $potong = min($sisa_potong, $n);
                        $n -= $potong;
                        $sisa_potong -= $potong;
                    }
                    
                    $this->db->where('id_user', $user->id_user)->update('user', [
                        'cuti_n'  => $n,
                        'cuti_n1' => $n1,
                        'cuti_n2' => $n2
                    ]);
                }
            }
        }
        
        $this->db->where('id_cuti', $id);
        return $this->db->update('cuti', $data);
    }
    

}
