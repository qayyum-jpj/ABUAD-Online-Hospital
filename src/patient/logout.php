<?php
include 'inc/config.php';
$url = $patientRoot . 'redirect?dir=logout';
header("Location: $url");
