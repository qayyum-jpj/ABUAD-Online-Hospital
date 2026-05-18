<?php
session_start();

$loginUrl = $adminRoot . 'login';
if (isset($_SESSION['abdAdmin'])) {
    $uId = $_SESSION['abdAdmin'];
    $q = dbSelect('administrators', "*", "id=$uId");
    $userData = mysqli_fetch_array($q);
    $cuUserName = $userData['username'];
    $cuUserID = $userData['userID'];
    $cuFName = $userData['fName'];
    $cuLName = $userData['lName'];
    $cuEmail = $userData['email'];
    $cuPhone = $userData['phone'];
    $cuCountry = $userData['country'];
    $cuCompany = $userData['company'];
    $cuGender = $userData['gender'];
    $cuBio = $userData['bio'];
    $cuJob = $userData['job'];
    $cuAddress = $userData['address'];
    $cuPassword = $userData['password'];
    $cuImage = $userData['image'];
    $cuFbURL = $userData['fbURL'];
    $cuTwURL = $userData['twURL'];
    $cuLkURL = $userData['lkURL'];
    $cuIgURL = $userData['igURL'];

    $cuDC = $userData['dc'];
    $cuDU = $userData['du'];
    $cuStatus = $userData['status'];

    
    $cuRoleId = $userData['role'];
    $cuRole = getColumnVal('roles', $cuRoleId);
} else {
    $url = $adminRoot . 'redirect?dir=not_logged_in';
    header("Location: $url");
}
