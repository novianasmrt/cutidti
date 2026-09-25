<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Google API Configuration
| -------------------------------------------------------------------
| Konfigurasi Client ID dan Client Secret dari Google Cloud Console.
| Anda bisa mendapatkannya di: https://console.cloud.google.com/
*/

$config['google_client_id']     = '647749178463-ieo0u917pb0oul41vp729re8gbanf4sj.apps.googleusercontent.com';
$config['google_client_secret'] = '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';

// URL Redirect (Pastikan sesuai dengan yang didaftarkan di Google Cloud Console)
// Contoh: http://localhost/cutidti/auth/google_callback
$config['google_redirect_uri']  = base_url('auth/google_callback');
