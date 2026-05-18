<?php
#app URL definitions
$mainRoot = "http://localhost/my/ABUAD-Online-Hospital/";
$patientRoot = "http://localhost/my/ABUAD-Online-Hospital/src/admin/";
$doctorRoot = "http://localhost/my/ABUAD-Online-Hospital/src/doctor/";
$patientRoot = "http://localhost/my/ABUAD-Online-Hospital/src/patient/";
$uploadsRoot = "http://localhost/my/ABUAD-Online-Hospital/src/admin/uploads/";


#db connection configuration
const HOST = '127.0.0.1';
const USER = 'root';
const PWD = '';
const DB = 'abuad_hospital';

$conn = mysqli_connect(HOST, USER, PWD, DB);


# App Vars
date_default_timezone_set('Africa/Lagos');
$smsg = $emsg = $imsg = "";
$errs = [];
$now = date("Y-m-d h:i");
$prompt = $doNotResubmit = false;
$defPwd = 'pass';

$adminDefaultImg = 'default.png';
// $smsg = date("F jS, Y h:i:a");
include 'funcs.php';
