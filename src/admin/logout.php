<?php
include 'inc/config.php';
$url = $adminRoot.'redirect?dir=logout';
header("Location: $url");
