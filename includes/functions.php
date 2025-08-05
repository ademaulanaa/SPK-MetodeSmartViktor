<?php

// Fungsi redirect aman
function redirect_to($url = '') {
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit();
    } else {
        echo "<script>window.location.href='$url';</script>";
        exit();
    }
}

// Fungsi untuk memastikan user sudah login
function cek_login() {
    if (empty($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        session_unset();
        session_destroy();
        redirect_to("login.php");
    }
}

// Fungsi untuk mendapatkan username login (opsional)
function get_username() {
    return isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
}
?>
