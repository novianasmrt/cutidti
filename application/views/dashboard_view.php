<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <style>
        /* --- CUSTOM STYLES UNTUK MENIRU GAMBAR --- */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }

        /* Sidebar Styling */
        #sidebar-wrapper {
            background-color: #1a2e44;
            /* Dark Blue UGM Style */
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1.2rem;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .sidebar-nav {
            padding: 0;
            list-style: none;
            margin-top: 20px;
        }

        .sidebar-heading {
            padding: 10px 20px;
            font-size: 0.75rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
        }

        .nav-item .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            display: block;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .nav-item .nav-link:hover,
        .nav-item .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #fff;
            /* Active indicator */
        }

        .nav-item .nav-link i {
            width: 30px;
            text-align: center;
        }

        /* Content Wrapper */
        #content-wrapper {
            margin-left: 250px;
            /* Lebar sidebar */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            height: 70px;
            background-color: #fff;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            justify-content: flex-end;
        }

        /* Card Styles (Kunci Tampilan Gambar) */
        .card {
            border: none;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15);
            border-radius: 0.35rem;
        }

        /* Colored Border Left Classes */
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        /* Biru */
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        /* Hijau */
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        /* Cyan/Teal */
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        /* Kuning */

        .text-xs {
            font-size: .7rem;
        }

        .text-gray-300 {
            color: #dddfeb !important;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        /* Badge Pills */
        .badge-success {
            background-color: #1cc88a;
        }

        .badge-warning {
            background-color: #f6c23e;
            color: #fff;
        }

        .btn-info-custom {
            background-color: #36b9cc;
            color: white;
            border: none;
            padding: 3px 10px;
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: -250px;
            }

            #content-wrapper {
                margin-left: 0;
            }

            #sidebar-wrapper.toggled {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <div id="wrapper">

        <ul id="sidebar-wrapper" class="sidebar-nav">
            <a class="sidebar-brand" href="#">
                <i class="fas fa-user-graduate fa-lg mr-2"></i> CUTIDTI
            </a>

            <li class="nav-item active">
                <a class="nav-link active" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <div class="sidebar-heading">CUTI</div>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-plus-square"></i>
                    <span>Pengajuan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Riwayat</span>
                </a>
            </li>

            <div class="sidebar-heading">ADMIN</div>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-check-double"></i>
                    <span>Approval</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Staff</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <li class="nav-item" style="margin-top: auto;">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        <div id="content-wrapper">

            <nav class="topbar mb-4 static-top">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link" href="#">
                            <i class="fas fa-bell fa-fw text-secondary"></i>
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link" href="#">
                            <i class="fas fa-envelope fa-fw text-secondary"></i>
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                    </li>
                    <div class="topbar-divider d-none d-sm-block" style="width: 0; border-right: 1px solid #e3e6f0; height: 2rem; margin: auto 1rem;"></div>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user; ?></span>
                            <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name=<?= $user; ?>&background=random" style="height: 2rem; width: 2rem;">
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid">

                <div class="row">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Sisa Cuti</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $stats->sisa_cuti; ?> Hari</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Cuti Berjalan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats->cuti_berjalan; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Riwayat</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats->riwayat; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Status</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats->status_pending; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengajuan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center bg-light">
                                        <th>No</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Mulai Cuti</th>
                                        <th>Selesai Cuti</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($riwayat_cuti as $row): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $row->tgl_pengajuan; ?></td>
                                            <td><?= $row->mulai; ?></td>
                                            <td><?= $row->selesai; ?></td>
                                            <td><?= $row->masuk; ?></td>
                                            <td><?= $row->keterangan; ?></td>
                                            <td class="text-center">
                                                <span class="badge badge-<?= $row->badge; ?> px-3 py-1">
                                                    <?= $row->status; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-info-custom rounded-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Script untuk Toggle Sidebar di Mobile
        $("#sidebarToggleTop").on('click', function(e) {
            e.preventDefault();
            $("#sidebar-wrapper").toggleClass("toggled");
        });
    </script>

</body>

</html>