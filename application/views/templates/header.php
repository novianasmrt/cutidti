<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        :root {
            --ugm-blue: #003366;
            --ugm-light-blue: #004080;
            --bg-color: #f3f4f6;
            --white: #ffffff;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body { background-color: var(--bg-color); display: flex; min-height: 100vh; overflow-x: hidden; }

        /* SIDEBAR STYLE */
        .sidebar {
            width: 260px !important; background-color: var(--ugm-blue); color: var(--white);
            display: flex; flex-direction: column; position: fixed;
            height: 100vh; transition: all 0.3s ease; z-index: 1000; /* Z-index tinggi agar di atas konten */
            left: 0; top: 0;
        }

        .sidebar-header {
            padding: 1.5rem; display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-header img { width: 32px; height: auto; }
        .sidebar-header h2 { font-size: 1.2rem; font-weight: 700; letter-spacing: 0.5px; }

        .sidebar-menu { padding: 1.5rem 1rem; flex: 1; overflow-y: auto; }
        
        .menu-category {
            font-size: 0.75rem; text-transform: uppercase; color: rgba(255,255,255,0.5);
            margin-bottom: 0.8rem; margin-top: 1rem; padding-left: 0.8rem; font-weight: 600;
        }

        .nav-link {
            display: flex; align-items: center; padding: 0.8rem 1rem;
            color: rgba(255,255,255,0.8); text-decoration: none; border-radius: 8px;
            margin-bottom: 0.25rem; transition: all 0.2s; font-size: 0.95rem; cursor: pointer;
        }
        .nav-link i { width: 24px; margin-right: 10px; text-align: center; }
        .nav-link:hover { background-color: rgba(255,255,255,0.1); color: var(--white); }
        .nav-link.active {
            background-color: var(--white); color: var(--ugm-blue);
            font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .sidebar-footer { padding: 1rem; border-top: 1px solid rgba(255,255,255,0.1); }

        /* LAYOUT & TOPBAR STYLE */
        .main-content { 
            flex: 1; 
            margin-left: 260px; /* Default desktop margin */
            display: flex; flex-direction: column; 
            width: calc(100% - 260px); 
            transition: all 0.3s ease;
        }
        
        .top-bar {
            background: var(--white); height: 70px; padding: 0 2rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02); position: sticky; top: 0; z-index: 900;
        }
        
        .page-title h1 { font-size: 1.25rem; font-weight: 600; color: var(--text-dark); margin: 0; }
        
        .user-actions { display: flex; align-items: center; gap: 20px; }
        .icon-btn { position: relative; color: var(--text-gray); font-size: 1.1rem; cursor: pointer; }
        .badge-count {
            position: absolute; top: -5px; right: -5px; background: #ef4444; color: white;
            font-size: 0.65rem; padding: 2px 5px; border-radius: 10px; border: 2px solid var(--white);
        }

        .profile-menu {
            display: flex; align-items: center; gap: 10px; cursor: pointer;
            padding: 5px 10px; border-radius: 8px; transition: background 0.2s;
        }
        .profile-menu:hover { background-color: #f3f4f6; }
        .profile-menu img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
        .profile-info { text-align: right; }
        .profile-info span { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text-dark); }
        .profile-info small { color: var(--text-gray); font-size: 0.75rem; }

        /* --- RESPONSIVE LOGIC --- */

        /* 1. Tombol Hamburger (Awalnya Sembunyi) */
        .menu-toggle {
            display: none; 
            font-size: 1.5rem;
            color: var(--ugm-blue);
            cursor: pointer;
            padding: 8px;
            margin-right: 15px; /* Jarak ke judul */
            border-radius: 5px;
            transition: 0.2s;
            background: transparent;
            border: none;
        }
        .menu-toggle:hover { background-color: #e5e7eb; }

        /* 2. Overlay Gelap */
        .overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5); z-index: 999; /* Di bawah sidebar(1000), di atas konten */
            display: none; opacity: 0; transition: opacity 0.3s;
        }
        .overlay.active { display: block; opacity: 1; }

        /* 3. MEDIA QUERY (Mobile < 768px) */
        @media (max-width: 768px) {
            /* Tampilkan Tombol Hamburger */
            .menu-toggle { display: block; }

            /* Sembunyikan Sidebar ke Kiri */
            .sidebar { transform: translateX(-100%); }

            /* Jika sidebar aktif (muncul) */
            .sidebar.active { transform: translateX(0); }

            /* Main Content Full Width */
            .main-content { margin-left: 0 !important; width: 100%; }

            /* Padding Topbar menyesuaikan */
            .top-bar { padding: 0 1rem; }
            
            /* Sembunyikan info user text di HP biar tidak sempit */
            .profile-info { display: none; }
        }
        /* --- STYLE MODAL MODERN (LOGOUT) --- */
            .modal-content {
                border: none;
                border-radius: 1rem; /* Sudut lebih melengkung */
                box-shadow: 0 15px 35px rgba(0,0,0,0.2);
                overflow: hidden;
            }
            
            .modal-header {
                background-color: #003366; /* Biru UGM */
                color: white;
                border-bottom: none;
                padding: 1.2rem 1.5rem;
            }
            
            .modal-header .close {
                color: white;
                opacity: 0.8;
                text-shadow: none;
            }
            .modal-header .close:hover { opacity: 1; }
            
            .modal-body {
                padding: 2rem 1.5rem;
                text-align: center; /* Teks di tengah */
                color: #5a5c69;
            }
            
            .modal-footer {
                border-top: none;
                background-color: #f8f9fc;
                padding: 1rem 1.5rem;
                justify-content: center; /* Tombol di tengah */
                gap: 10px;
            }

            /* Tombol Custom */
            .btn-custom-cancel {
                background-color: #e2e6ea;
                color: #555;
                border: none;
                font-weight: 600;
                padding: 0.6rem 1.5rem;
                border-radius: 0.5rem;
                transition: 0.2s;
            }
            .btn-custom-cancel:hover { background-color: #dbe0e5; color: #333; }

            .btn-custom-logout {
                background-color: #e74a3b; /* Merah untuk Logout/Bahaya */
                color: white;
                border: none;
                font-weight: 600;
                padding: 0.6rem 1.5rem;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(231, 74, 59, 0.3);
                transition: 0.2s;
            }
            .btn-custom-logout:hover { background-color: #c0392b; transform: translateY(-1px); }
    </style>
</head>
<body>

<div class="overlay" onclick="toggleSidebar()"></div>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.overlay');
        
        // Tambah/Hapus class 'active'
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }
</script>