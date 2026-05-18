<?php
include 'inc/config.php';
$url = $doctorRoot . 'redirect?dir=logout';
header("Location: $url");
