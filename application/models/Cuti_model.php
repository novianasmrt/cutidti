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
        user.no_telpon
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
        $this->db->select('cuti.*, user.name, user.nip, user.jabatan');
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
        $this->db->select('cuti.*, user.name, user.nip, user.jabatan, user.no_telpon, user.sisa_cuti, user.sisa_cuti_2025');
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
        
        return $this->db->update('cuti', $data);
    }
    
    // ==============================
    // 6. HITUNG SISA CUTI TAHUNAN (PNS)
    // ==============================
    public function hitung_sisa_cuti_tahunan($id_user)
    {
        // 1. Ambil data user
        $user = $this->db->get_where('user', ['id_user' => $id_user])->row();
        if (!$user) return 0;
        
        $sisa_cuti_2025 = (int) $user->sisa_cuti_2025;
        
        // 2. Ambil semua cuti tahunan yang 'Disetujui'
        $this->db->select('EXTRACT(YEAR FROM tanggal_mulai) as tahun, SUM(jumlah_cuti) as total_taken');
        $this->db->where('id_user', $id_user);
        $this->db->where('jenis_cuti', 'Cuti Tahunan');
        $this->db->where('status', 'Disetujui');
        $this->db->group_by('EXTRACT(YEAR FROM tanggal_mulai)');
        $query = $this->db->get('cuti')->result_array();
        
        $taken_per_year = [];
        foreach ($query as $row) {
            if ($row['tahun']) {
                $taken_per_year[$row['tahun']] = (int) $row['total_taken'];
            }
        }
        
        $current_year = (int) date('Y');
        $start_year = 2026;
        
        // Jika current year masih di bawah 2026, tetapkan ke 2026
        if ($current_year < 2026) {
            $current_year = 2026;
        }
        
        $history = [];
        
        // Loop dari 2026 sampai current_year
        for ($y = $start_year; $y <= $current_year; $y++) {
            $taken = isset($taken_per_year[$y]) ? $taken_per_year[$y] : 0;
            
            if ($y == 2026) {
                // Di tahun 2026, bawa carry-over dari 2025
                $entitlement = 12 + $sisa_cuti_2025;
            } else {
                $taken_y1 = isset($taken_per_year[$y - 1]) ? $taken_per_year[$y - 1] : 0;
                $taken_y2 = isset($taken_per_year[$y - 2]) ? $taken_per_year[$y - 2] : 0;
                $sisa_y1 = isset($history[$y - 1]['sisa']) ? $history[$y - 1]['sisa'] : 0;
                
                // Jika tidak cuti 2 tahun berturut-turut, akumulasi max 24
                if ($taken_y1 == 0 && $taken_y2 == 0 && $y >= 2028) {
                    $entitlement = 24;
                } else {
                    $entitlement = 12 + min(6, $sisa_y1);
                }
            }
            
            $sisa = max(0, $entitlement - $taken);
            
            $history[$y] = [
                'sisa' => $sisa
            ];
        }
        
        $final_sisa = $history[$current_year]['sisa'];
        
        // Update ke database
        $this->db->where('id_user', $id_user)->update('user', ['sisa_cuti' => $final_sisa]);
        
        return $final_sisa;
    }
}
