<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<div class="container-fluid" style="padding: 20px 30px;">
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

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>



    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-soft-hover h-100 py-3 px-2"
                style="border: none; border-radius: 20px; background: #fff; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #003366; letter-spacing: 1px;">
                                Sisa Cuti Tahunan
                            </div>
                            <div class="h2 mb-1 font-weight-bold" style="color: #333;">
                                <?= $stats->sisa_cuti; ?> <span style="font-size: 1rem; color: #b7b9cc;">Hari</span>
                            </div>
                            <div class="mb-0 font-weight-bold" style="font-size: 0.8rem; color: #1cc88a;">
                                <i class="fas fa-check-circle mr-1"></i> Status Aman
                            </div>
                        </div>
                        <div class="col-auto">
                            <div style="width: 60px; height: 60px; background-color: #E6F0FF; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-check fa-2x" style="color: #003366;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-soft-hover h-100 py-3 px-2"
                style="border: none; border-radius: 20px; background: #fff; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #006644; letter-spacing: 1px;">
                                Cuti Terpakai
                            </div>
                            <div class="h2 mb-1 font-weight-bold" style="color: #333;">
                                <?= $stats->cuti_terpakai; ?> <span style="font-size: 1rem; color: #b7b9cc;">Hari</span>
                            </div>
                            <div class="mb-0 text-muted" style="font-size: 0.8rem;">
                                Periode Tahun Ini
                            </div>
                        </div>
                        <div class="col-auto">
                            <div style="width: 60px; height: 60px; background-color: #E6FFFA; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-history fa-2x" style="color: #006644;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-soft-hover h-100 py-3 px-2"
                style="border: none; border-radius: 20px; background: #fff; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #CC8800; letter-spacing: 1px;">
                                Pengajuan Terakhir
                            </div>

                            <?php if (!empty($stats->last_sub)) : ?>
                                <div class="h5 mb-1 font-weight-bold" style="color: #555;">
                                    <?= !empty($stats->last_sub->tgl_pengajuan)
                                        ? date('d M Y', strtotime($stats->last_sub->tgl_pengajuan))
                                        : '-' ?>
                                </div>
                                <div class="mb-0" style="font-size: 0.8rem;">
                                    Status: <strong><?= $stats->last_sub->status ?? '-' ?></strong>
                                </div>
                            <?php else : ?>
                                <div class="h5 mb-1 font-weight-bold" style="color: #555;">-</div>
                                <div class="mb-0 text-muted" style="font-size: 0.8rem;">Belum ada data</div>
                            <?php endif; ?>

                        </div>
                        <div class="col-auto">
                            <div style="width: 60px; height: 60px; background-color: #FFF7E6; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-signature fa-2x" style="color: #CC8800;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="border: none; border-radius: 20px;">

                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between bg-white"
                    style="border-radius: 10px 10px 0 0; border-bottom: 1px solid #f8f9fc;">
                    <h6 class="m-0 font-weight-bold" style="color: #003366;">
                        <i class="far fa-calendar-alt mr-2"></i> Kalender Kerja & Libur
                    </h6>

                    <div class="d-flex">
                        <span class="badge px-3 py-2 mr-2" style="background-color: #FFE6E6; color: #CC0000; border-radius: 10px;">
                            <i class="fas fa-square mr-1"></i> Libur
                        </span>
                        <span class="badge px-3 py-2" style="background-color: #E6F0FF; color: #003366; border-radius: 10px;">
                            <i class="fas fa-square mr-1"></i> Cuti Saya
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div id='calendar' style="min-width: 700px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // AMBIL DATA JSON DARI CONTROLLER
        var eventsFromController = <?= $json_events; ?>;

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id', // Bahasa Indonesia
            height: 600,
            initialDate: '2026-01-01', // Sesuaikan tanggal awal (Dummy data kamu Jan 2026)

            // Toolbar
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            buttonText: {
                today: 'Hari Ini'
            },

            // MASUKKAN DATA EVENT DINAMIS DI SINI
            events: eventsFromController,

            eventClick: function(info) {
                alert(info.event.title);
            }
        });

        calendar.render();
    });
</script>