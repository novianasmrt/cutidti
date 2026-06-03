<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-ugm text-uppercase mb-1">Total Pegawai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $stats->total_pegawai; ?> <span class="text-xs text-muted">Orang</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="soft-icon-circle soft-blue"><i class="fas fa-users"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sedang Cuti (Hari Ini)</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                <?= $stats->cuti_hari_ini; ?> <span class="text-xs text-muted">Orang</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="soft-icon-circle soft-green"><i class="fas fa-plane-departure"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Approval</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                <?= $stats->status_pending; ?> <span class="text-xs text-muted">Request</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="soft-icon-circle soft-yellow"><i class="fas fa-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Permohonan Bulan Ini</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                <?= $stats->req_bulan_ini; ?> <span class="text-xs text-muted">Request</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="soft-icon-circle soft-cyan"><i class="fas fa-clipboard-list"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-8 col-lg-7">
            <div class="card card-dashboard shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-ugm">
                        <i class="far fa-calendar-alt mr-2"></i>Kalender Cuti Pegawai
                    </h6>
                    <div class="small d-none d-sm-block">
                        <span class="mr-2"><i class="fas fa-circle text-primary"></i> Tahunan</span>
                        <span class="mr-2"><i class="fas fa-circle text-success"></i> Melahirkan</span>
                        <span><i class="fas fa-circle text-warning"></i> Sakit</span>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">

                        <div id='calendar' style="min-width: 700px;"></div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">

            <div class="card card-dashboard shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-0">

                    <h6 class="m-0 font-weight-bold text-ugm">Permohonan Terbaru</h6>

                    <a href="<?= base_url('cuti/approval'); ?>" class="small font-weight-bold text-ugm">Lihat Semua &rarr;</a>

                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">

                        <?php if (empty($permohonan_terbaru)) : ?>
                            <div class="text-center p-4 text-muted">Belum ada data permohonan.</div>
                        <?php else : ?>

                            <?php foreach ($permohonan_terbaru as $row) : ?>

                                <?php
                                // 1. Tentukan Warna berdasarkan Status
                                $badge_color = 'badge-warning'; // Default (Menunggu)
                                $bg_icon     = 'soft-yellow';   // Default
                                if ($row->status == 'Disetujui') {
                                    // Hijau
                                    $badge_color = 'badge-success';
                                    $bg_icon     = 'soft-green';
                                } elseif ($row->status == 'Ditolak') {
                                    // Merah
                                    $badge_color = 'badge-danger';
                                    $bg_icon     = 'soft-red';
                                } elseif ($row->status == 'Ditangguhkan') {
                                    // Abu-abu (Netral)
                                    $badge_color = 'badge-secondary'; // Pakai class bootstrap bawaan/custom
                                    $bg_icon     = 'soft-grey';       // Pakai class custom di atas

                                } elseif ($row->status == 'Direvisi') {
                                    // Ungu (Perhatian Khusus)
                                    $badge_color = 'badge-purple';    // Pakai class custom di atas
                                    $bg_icon     = 'soft-purple';     // Pakai class custom di atas

                                } else {
                                    // Default: Menunggu (Kuning)
                                    $badge_color = 'badge-warning';
                                    $bg_icon     = 'soft-yellow';
                                }

                                // 2. Ambil Huruf Depan Nama (Inisial)
                                $inisial = substr($row->name, 0, 1);
                                ?>

                                <div class="list-group-item d-flex align-items-center p-3 border-0 border-bottom">

                                    <div class="mr-3">
                                        <div class="initial-circle <?= $bg_icon; ?>">
                                            <?= $inisial; ?>
                                        </div>
                                    </div>

                                    <div class="w-100">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="font-weight-bold text-gray-800"><?= $row->name; ?></span>
                                            <span class="badge <?= $badge_color; ?>" style="font-size: 0.6rem; font-weight: normal;">
                                                <?= $row->status; ?>
                                            </span>
                                        </div>
                                        <p class="text-xs text-muted mb-1">
                                            <?= $row->jenis_cuti; ?> (<?= $row->jumlah_cuti; ?>)
                                        </p>
                                        <small class="text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            <?= date('d M Y', strtotime($row->tgl_pengajuan)); ?>
                                        </small>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* --- STYLE KHUSUS DASHBOARD (UGM MODERN) --- */

    /* Warna Identitas */
    .text-ugm {
        color: #003366;
    }

    .bg-ugm {
        background-color: #003366;
    }

    /* Styling Card Widget Soft */
    .card-dashboard {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
        background: #fff;
        transition: all 0.2s ease-in-out;
    }

    .card-dashboard:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.1);
    }

    /* Ikon dengan Background Soft */
    .soft-icon-circle {
        height: 60px;
        width: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* Palet Warna Soft */
    .soft-blue {
        background-color: #E6F0FF;
        color: #003366;
    }

    .soft-green {
        background-color: #E6FFFA;
        color: #006644;
    }

    .soft-yellow {
        background-color: #FFF7E6;
        color: #CC8800;
    }

    .soft-cyan {
        background-color: #E0F7FA;
        color: #006064;
    }

    /* Styling Kalender FullCalendar */
    #calendar {
        font-family: 'Nunito', sans-serif;
    }

    .fc-toolbar-title {
        font-size: 1.2rem !important;
        font-weight: 700;
        color: #003366;
    }

    .fc-button-primary {
        background-color: #003366 !important;
        border-color: #003366 !important;
    }

    .fc-day-today {
        background-color: #f0f4ff !important;
    }

    .fc-event {
        border: none;
        border-radius: 4px;
        padding: 3px 5px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
    }

    .fc-col-header-cell-cushion {
        color: #003366;
        text-decoration: none;
    }

    .fc-daygrid-day-number {
        color: #555;
        text-decoration: none;
    }

    .badge-secondary {
        background-color: #858796;
        /* Abu-abu Bootstrap */
        color: #ffffff;
    }

    .soft-grey {
        background-color: #eaecf4;
        color: #5a5c69;
    }

    /* 2. Status DIREVISI (Ungu) */
    .badge-purple {
        background-color: #6f42c1;
        /* Ungu terang */
        color: #ffffff;
    }

    .soft-purple {
        background-color: #e2d9f3;
        /* Ungu sangat muda */
        color: #5a2a8c;
    }

    /* 3. Status DITOLAK (Merah - Jika belum ada) */
    .soft-red {
        background-color: #f8d7da;
        color: #e74a3b;

    }

    /* List Permohonan Kanan */
    .initial-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1rem;
    }

    /* --- RESPONSIVE FIX (BOOTSTRAP STYLE) --- */
    @media (max-width: 768px) {

        /* Header Kalender jadi tumpuk di HP agar rapi */
        .fc-header-toolbar {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .fc-toolbar-title {
            font-size: 1.1rem !important;
        }

        /* Tombol download di atas sembunyi di HP */
        .btn-download-report {
            display: none;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // AMBIL DATA DARI CONTROLLER (PHP)
        // Data ini sudah berisi Weekend, Libur Nasional, DAN Data Cuti Pegawai
        var eventsFromPHP = <?= $json_events; ?>;

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 550,
            locale: 'id',

            // Set tanggal awal agar pas demo langsung kelihatan datanya (Januari 2026 sesuai dummy)
            // Nanti kalau sudah live, baris ini bisa dihapus biar otomatis ke bulan sekarang
            initialDate: '2026-01-01',


            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            buttonText: {
                today: 'Hari Ini'
            },

            // MASUKKAN DATA EVENT DINAMIS DI SINI
            events: eventsFromPHP,

            eventClick: function(info) {
                // Contoh: Tampilkan nama orang dan jenis cuti saat diklik
                alert('Detail: ' + info.event.title);
            }
        });

        calendar.render();
    });
</script>