<?php
session_start();
global $conn;
if (isset($_POST['loginAdmin'])) {
    $user = trim(mysqli_real_escape_string($conn, $_POST['user']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    if (empty($user)) {
        $errs[] = $userError = "value expected";
    }
    if (empty($password)) {
        $errs[] = $passwordError = "value expected";
    }

    if (count($errs) == 0) {
        $password = md5($password);
        $q = dbSelect('administrators', "*", "(LCASE(username='$user') OR LCASE(email='$user')) AND password='$password'");
        if (mysqli_num_rows($q) > 0) {
            #proceed with login
            $userData = mysqli_fetch_array($q);
            $_SESSION['abdAdmin'] = $userData['id'];
            $userName = $userData['username'];
            $smsg = "welcome back " . strtoupper($userName) . ", you will be taken to your dashboard shortly " . '<div class="ms-3 spinner-border spinner-border-sm text-success"></div>';
            $url = $adminRoot . 'redirect?dir=login';
            header("Location: $url");
        } else {
            #return error msg for invalid credentials
            $emsg = "no such user here";
        }
    } else {
        $emsg = "you have " . count($errs) . " unresolved errors";
    }
}
