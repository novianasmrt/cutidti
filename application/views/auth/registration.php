<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - Universitas Gadjah Mada</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- COPY STYLE AGAR SELARAS DENGAN LOGIN --- */
        :root {
            --ugm-blue: #003366;
            --ugm-yellow: #f9d423;
            --bg-color: #f3f4f6;
            --text-dark: #1f2937;
            --white: #ffffff;
            --input-border: #d1d5db;
            --focus-ring: rgba(0, 51, 102, 0.2);
            --error-text: #dc2626;
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

        /* Register Card */
        .register-card {
            background: var(--white); width: 100%; max-width: 550px;
            padding: 2.5rem; border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            text-align: center; animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .logo-section i { font-size: 2.5rem; color: var(--ugm-blue); margin-bottom: 0.5rem; }
        .register-card h2 { color: var(--text-dark); font-size: 1.5rem; margin-bottom: 0.5rem; }
        .register-card p { color: #6b7280; font-size: 0.9rem; margin-bottom: 2rem; }

        /* Form Elements */
        .form-group { margin-bottom: 1.25rem; text-align: left; }
        
        /* Layout untuk Password Side-by-Side */
        .form-row { display: flex; gap: 15px; }
        @media (max-width: 600px) { .form-row { flex-direction: column; gap: 0; } }

        .input-wrapper { position: relative; }
        .input-wrapper i {
            position: absolute; left: 14px; top: 14px;
            color: #9ca3af; font-size: 0.9rem; z-index: 10;
        }
        
        input {
            width: 100%; padding: 12px 12px 12px 40px;
            border: 1px solid var(--input-border); border-radius: 8px;
            font-size: 0.95rem; outline: none; transition: 0.3s; color: var(--text-dark);
        }
        input:focus { border-color: var(--ugm-blue); box-shadow: 0 0 0 3px var(--focus-ring); }

        /* Error Message CI3 Styling */
        small.text-danger {
            color: var(--error-text); font-size: 0.8rem; margin-top: 5px; display: block;
        }
        small.text-danger.pl-3 { padding-left: 0 !important; } /* Override bootstrap style if needed */

        /* Buttons */
        .btn {
            width: 100%; padding: 12px; border: none; border-radius: 8px;
            font-weight: 600; cursor: pointer; transition: 0.2s; display: block;
        }
        .btn-primary { background-color: var(--ugm-blue); color: var(--white); margin-bottom: 1rem; }
        .btn-primary:hover { background-color: #002244; }
        
        .btn-google { 
            background: var(--white); border: 1px solid var(--input-border); 
            display: flex; justify-content: center; align-items: center; gap: 10px; color: var(--text-dark);
        }
        .btn-google:hover { background: #f9fafb; }

        /* Links */
        .footer-links { margin-top: 1.5rem; font-size: 0.9rem; }
        .footer-links a { color: var(--ugm-blue); text-decoration: none; font-weight: 500; }
        .footer-links a:hover { text-decoration: underline; }

        .page-footer { text-align: center; padding: 1.5rem; font-size: 0.8rem; color: #6b7280; border-top: 1px solid #e5e7eb; background: var(--white); }
    </style>
</head>
<body>

    <header class="top-bar">
        <img src="https://pertanian.uma.ac.id/wp-content/uploads/2019/12/UGM.png" alt="Logo UGM">
        <div class="top-bar-text">
            <h1>Sistem Pengajuan Cuti</h1>
            <p>Direktorat Teknologi Informasi - UGM</p>
        </div>
    </header>

    <div class="main-container">
        <div class="register-card">
            
            <div class="logo-section">
                <i class="fas fa-user-plus"></i>
            </div>
            
            <h2>Create an Account!</h2>
            <p>Silakan isi form untuk mendaftar akun baru</p>

            <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               placeholder="Full Name" 
                               value="<?= set_value('name'); ?>">
                    </div>
                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="text" 
                               id="email" 
                               name="email" 
                               placeholder="Email Address" 
                               value="<?= set_value('email'); ?>">
                    </div>
                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" 
                                   id="password1" 
                                   name="password1" 
                                   placeholder="Password">
                        </div>
                        <?= form_error('password1', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <div class="input-wrapper">
                            <i class="fas fa-key"></i>
                            <input type="password" 
                                   id="password2" 
                                   name="password2" 
                                   placeholder="Repeat Password">
                        </div>
                        </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Register Account
                </button>

                <div class="footer-links">
                    <div style="margin-bottom: 5px;">
                        <a href="forgot-password.html">Forgot Password?</a>
                    </div>
                    <div>
                        <span style="color: #6b7280">Already have an account?</span> 
                        <a href="<?= base_url('auth'); ?>">Login!</a>
                    </div>
                </div>

            </form>
            </div>
    </div>

    <footer class="page-footer">
        &copy; 2025 DTI Universitas Gadjah Mada. All rights reserved.
    </footer>

</body>
</html>