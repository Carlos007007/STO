<?php
    
    ini_set('session.use_strict_mode', '1');

    session_set_cookie_params([
        'samesite' => 'Strict',
        'httponly' => true,
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'

    ]);

    session_name(SESSION_NAME);
    session_start();