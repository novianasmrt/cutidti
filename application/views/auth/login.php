<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SSO - Universitas Gadjah Mada</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- CSS MODERN UGM STYLE --- */
        :root {
            --ugm-blue: #003366;
            --ugm-yellow: #f9d423;
            --bg-color: #f3f4f6;
            --text-dark: #1f2937;
            --white: #ffffff;
            --input-border: #d1d5db;
            --focus-ring: rgba(0, 51, 102, 0.2);
            --error-text: #dc2626; /* Merah untuk error CI3 */
            --error-bg: #fee2e2;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-color);
            background-image: radial-gradient(at 0% 0%, hsla(212,33%,96%,1) 0, transparent 50%), 
                              radial-gradient(at 50% 100%, hsla(212,33%,96%,1) 0, transparent 50%);
            display: flex; flex-direction: column; min-height: 100vh;
        }

        /* Top Bar */
        .top-bar {
            background-color: var(--ugm-blue); color: var(--white);
            padding: 1rem 2rem; display: flex; align-items: center; gap: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .top-bar img { height: 40px; width: auto; }
        .top-bar-text h1 { font-size: 1rem; font-weight: 600; }
        .top-bar-text p { font-size: 0.85rem; opacity: 0.9; }

        /* Main Container */
        .main-container {
            flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem;
        }

        /* Login Card */
        .login-card {
            background: var(--white); width: 100%; max-width: 450px;
            padding: 2.5rem; border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            text-align: center; animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .logo-section i { font-size: 2.5rem; color: var(--ugm-yellow); margin-bottom: 0.5rem; }
        .login-card h2 { color: var(--text-dark); font-size: 1.5rem; margin-bottom: 0.5rem; }
        .login-card p { color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem; }

        /* Form Elements */
        .form-group { margin-bottom: 1.25rem; text-align: left; }
        .input-wrapper { position: relative; }
        .input-wrapper i {
            position: absolute; left: 14px; top: 14px; /* Adjusted for centering */
            color: #9ca3af; font-size: 0.9rem; z-index: 10;
        }
        
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%; padding: 12px 12px 12px 40px;
            border: 1px solid var(--input-border); border-radius: 8px;
            font-size: 0.95rem; outline: none; transition: 0.3s;
            color: var(--text-dark);
        }
        input:focus { border-color: var(--ugm-blue); box-shadow: 0 0 0 3px var(--focus-ring); }

        /* Error Message Styling (CI3) */
        small.text-danger {
            color: var(--error-text); font-size: 0.8rem; margin-top: 5px; display: block;
        }

        /* Buttons */
        .btn {
            width: 100%; padding: 12px; border: none; border-radius: 8px;
            font-weight: 600; cursor: pointer; transition: 0.2s; display: block;
        }
        .btn-primary { background-color: var(--ugm-blue); color: var(--white); margin-bottom: 1rem; }
        .btn-primary:hover { background-color: #002244; }
        
        .btn-google { 
            background: var(--white); border: 1px solid var(--input-border); 
            display: flex; justify-content: center; align-items: center; gap: 10px; 
            color: var(--text-dark);
        }
        .btn-google:hover { background: #f9fafb; }

        /* Links */
        .footer-links { margin-top: 1.5rem; font-size: 0.9rem; display: flex; flex-direction: column; gap: 8px; }
        .footer-links a { color: var(--ugm-blue); text-decoration: none; transition: 0.2s; }
        .footer-links a:hover { text-decoration: underline; }

        .page-footer { text-align: center; padding: 1.5rem; font-size: 0.8rem; color: #6b7280; border-top: 1px solid #e5e7eb; background: var(--white); }
        
        /* Alert Box */
        .alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: left;}
        .alert-danger { background-color: var(--error-bg); color: var(--error-text); border: 1px solid #fecaca; }
        .alert-success { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    </style>
</head>
<body>

    <header class="top-bar">
        <img src="assets/img/dti-logo.png" alt="Logo UGM">
        <div class="top-bar-text">
            <h1>Sistem Pengajuan Cuti</h1>
            <p>Direktorat Teknologi Informasi - UGM</p>
        </div>
    </header>

    <div class="main-container">
        <div class="login-card">
            
            <div class="logo-section">
                <img src="assets/img/ugm-logo.png" width="80px" height="80px" alt="Logo UGM"> 
            </div>
            
            <h2>Single Sign On</h2>
            <p>Plis login with email ugm</p>

            <?php if($this->session->flashdata('message')): ?>
                <div class="alert-wrapper">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>

            <form class="user" method="post" action="<?= base_url('auth'); ?>">
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="far fa-envelope"></i>
                        <input type="text" 
                               id="email" 
                               name="email" 
                               placeholder="Enter Email Address..." 
                               value="<?= set_value('email'); ?>"
                               autocomplete="off">
                    </div>
                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               placeholder="Password">
                    </div>
                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group" style="display: flex; align-items: center;">
                    <input type="checkbox" id="customCheck" style="width: auto; margin-right: 8px;"> 
                    <label for="customCheck" style="font-size: 0.9rem; color: #6b7280; cursor: pointer;">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Login
                </button>

                <div class="footer-links">
                    <a href="forgot-password.html">Forgot Password?</a>
                    <a href="<?= base_url('auth/registration'); ?>">Create an Account!</a>
                </div>

            </form>
            </div>
    </div>

    <footer class="page-footer">
        &copy; 2025 DTI Universitas Gadjah Mada. All rights reserved.
    </footer>

</body>
</html>