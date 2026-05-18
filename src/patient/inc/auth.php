<?php
session_start();

$loginUrl = $patientRoot . 'login';
if (isset($_SESSION['abdPatie'])) {
    $uId = $_SESSION['abdPatie'];
    $q = dbSelect('users', "*", "id=$uId AND role='patient'");
    $userData = mysqli_fetch_array($q);
    $cuUserName = $userData['fName'] . " " . $userData['lName'];
    $cuUserID = $userData['userID'];
    $cuFName = $userData['fName'];
    $cuLName = $userData['lName'];
    $cuEmail = $userData['email'];
    $cuPhone = $userData['phone'];
    $cuGender = $userData['gender_id'];
    $cuBio = $userData['bio'];
    $cuJob = $userData['specialty'];
    $cuPassword = $userData['password'];
    $cuImage = $userData['profile_image'];

    $cuDC = $userData['dc'];
    $cuDU = $userData['du'];
    $cuStatus = $userData['status'];

    $cuRole = $userData['role'];
    // $cuRole = getColumnVal('roles', $cuRoleId);
} else {
    $url = $patientRoot . 'redirect?dir=not_logged_in';
    header("Location: $url");
}
