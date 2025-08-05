<?php
session_start();

// Cegah halaman tersimpan di cache browser
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('konek-db.php');
require_once('functions.php');
?>
