<?php

# update basic info
if (isset($_POST['updateInfo'])) {
    $fName = trim(mysqli_real_escape_string($conn, $_POST['fName']));
    $lName = trim(mysqli_real_escape_string($conn, $_POST['lName']));
    $bio = trim(mysqli_real_escape_string($conn, $_POST['bio']));
    $company = trim(mysqli_real_escape_string($conn, $_POST['company']));
    $job = trim(mysqli_real_escape_string($conn, $_POST['job']));
    $address = trim(mysqli_real_escape_string($conn, $_POST['address']));
    $phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $twitter = trim(mysqli_real_escape_string($conn, $_POST['twitter']));
    $facebook = trim(mysqli_real_escape_string($conn, $_POST['facebook']));
    $instagram = trim(mysqli_real_escape_string($conn, $_POST['instagram']));
    $linkedin = trim(mysqli_real_escape_string($conn, $_POST['linkedin']));

    $country = trim(intval($_POST['country']));
    $gender = trim(intval($_POST['gender']));

    $q = dbUpdate('administrators', ['fName' => $fName, 'lName' => $lName, 'bio' => $bio, 'job' => $job, 'company' => $company, 'address' => $address, 'phone' => $phone, 'email' => $email, 'fbURL' => $facebook, 'twURL' => $twitter, 'lkURL' => $linkedin, 'igURL' => $instagram, 'country' => $country, 'gender' => $gender, 'du' => $now], "id=" . $uId);
    if ($q == 'success') {
        $doLog = logAction('you updated your basic info', $uId);
        if ($doLog == 'logged') {
            $smsg = "basic information updated successfully";
            $url = $doctorRoot . 'profile?vw=e-info';
            header("Refresh: 2; url=$url");
        }
    } else {
        $emsg = "something went wrong.<br>" . mysqli_error($conn);
    }
}


# update Password
if (isset($_POST['updatePassword'])) {
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    $newPassword = trim(mysqli_real_escape_string($conn, $_POST['newPassword']));
    $newPassword2 = trim(mysqli_real_escape_string($conn, $_POST['newPassword2']));
    # validate inputs
    if (empty($password)) {
        $errs[] = $passwordError = "cannot be empty";
    } else {
        $cryptPwd = md5($password);
        if (!cntRows('administrators', "password", "password='$cryptPwd' AND id=$uId") > 0) {
            $errs[] = $passwordError = "incorrect old password";
        }
    }
    if (empty($newPassword)) {
        $errs[] = $newPasswordError = "cannot be empty";
    }
    if (empty($newPassword2)) {
        $errs[] = $newPassword2Error = "cannot be empty";
    }

    if ((!empty($newPassword) && !empty($newPassword2)) && $newPassword != $newPassword2) {
        $errs[] = $newPassword2Error = "password mismatch";
    }

    if (count($errs) == 0) {
        $cryptNewPassword = md5($newPassword);
        $q = dbUpdate('administrators', ['password' => $cryptNewPassword, 'du' => $now], "id=" . $uId);
        if ($q == 'success') {
            $smsg = "password was changed successfully. you will be signed out shortly";
            $logout = $doctorRoot . 'logout';
            header("Refresh: 10; url=$logout");
        } else {
            $emsg = "something went wrong.";
        }
    }
}

# update profile image
if (isset($_POST['updateImage'])) {
    $uploadPath = '../uploads/images/administrators/';
    $userImage = $_FILES['userImage']['name'];
    $userImageSz = $_FILES['userImage']['size'];
    $imgNameArr = explode('.', $userImage);
    $fileExt = strtolower(end($imgNameArr));
    #check extension
    $validExts = ['jpg', 'png'];
    if (!in_array($fileExt, $validExts)) {
        $errs[] = $userImageError = "invalid format encountered. jpg/png expected";
    }
    #check size
    if ($userImageSz > 500000) {
        $errs[] = $userImageError = "file too large. 500kb max expected";
    }

    if (count($errs) == 0) {
        $newFileName = strtolower($cuUserName) . '.' . $fileExt;
        $pngFile = strtolower($cuUserName) . '.png';
        $jpgFile = strtolower($cuUserName) . '.jpg';

        $q = dbUpdate('administrators', ['image' => $newFileName, 'du' => $now], "id=" . $uId);
        if ($q == 'success') {
            if (file_exists($uploadPath . $pngFile)) {
                unlink($uploadPath . $pngFile);
            }
            if (file_exists($uploadPath . $jpgFile)) {
                unlink($uploadPath . $jpgFile);
            }
            if (move_uploaded_file($_FILES['userImage']['tmp_name'], $uploadPath . $newFileName)) {
                $smsg = "profile image was updated successfully";
                $url = $doctorRoot . 'profile?vw=e-image';
                header("Refresh: 5; url=$url");
            }
        } else {
            $emsg = "something went wrong.";
        }
    }
}

if (isset($_GET['do'])) {
    $do = $_GET['do'];
    if ($do == 'reset-image') {
        $promptMsg = "You are about to reset your image back to default. Are you sure?";
        $pgURL = $doctorRoot . "profile?vw=e-info";
        $prompt = true;
        if (isset($_POST['doAction'])) {
            $prompt = false;
            $q = dbUpdate('administrators', ['image' => $adminDefaultImg, 'du' => $now], "id=" . $uId);
            if ($q == 'success') {
                $pngFile = strtolower($cuUserName) . '.png';
                $jpgFile = strtolower($cuUserName) . '.jpg';
                if (file_exists($uploadPath . $pngFile)) {
                    unlink($uploadPath . $pngFile);
                }
                if (file_exists($uploadPath . $jpgFile)) {
                    unlink($uploadPath . $jpgFile);
                }
                $smsg = "image reset was successful";
                $url = $doctorRoot . 'profile?vw=e-info';
                header("Refresh: 5; url=$url");
            } else {
                $emsg = "activation failed. try again";
            }
        }
    }
}
