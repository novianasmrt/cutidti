<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Google API Configuration
| -------------------------------------------------------------------
| Konfigurasi Client ID dan Client Secret dari Google Cloud Console.
| Anda bisa mendapatkannya di: https://console.cloud.google.com/
*/

$config['google_client_id']     = getenv('GOOGLE_CLIENT_ID') ?: ''; // Dimuat dari .env
$config['google_client_secret'] = getenv('GOOGLE_CLIENT_SECRET') ?: ''; // Dimuat dari .env

// URL Redirect (Pastikan sesuai dengan yang didaftarkan di Google Cloud Console)
// Contoh: http://localhost/cutidti/auth/google_callback
$config['google_redirect_uri']  = base_url('auth/google_callback');
