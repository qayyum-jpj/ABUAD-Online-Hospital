<?php

#handle form submissions
if(isset($_POST['saveDoctor'])){
    # collect data from form element(s)
    $userName = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    $role = trim(mysqli_real_escape_string($conn, $_POST['role']));
    $specialty = trim(mysqli_real_escape_string($conn, $_POST['specialty']));
    # validate the data to get rid of errors
    if(empty($userName)){ $errs[] = $userNameError = "value expected"; }
    $errorResult = $checkEmail($email); 
    if ($errorResult !== null) { $emailError = $errorResult; $errs[] = $emailError; $isValid = false;}
    if(empty($password)){ $errs[] = $passwordError = "value expected"; }
    if(empty($role)){ $errs[] = $roleError = "value expected"; }
    if(empty($specialty)){ $errs[] = $specialtyError = "value expected"; }
    
    # prevent duplicate data in the database
    if(cntRows('users',"*","username='$userName'") > 0){
        $errs[] = $userNameError = "doctor exists";
        $emsg = "doctor '$userName' already exists in the database. try again";
    }
    $encryptedPassword = md5($password);

    # save data when all errors have been resolved
    if(count($errs) == 0){
        while(true){
            $randVal = "ABD-".rand(000,999);
            if(preventDuplicateID('users',$randVal) == 'ok'){
                break;
            }
        }
        if(dbInsert('users',['userID'=>$randVal,'username'=>$userName, 'email'=>$email, 'role'=>$role, 'password'=>$encryptedPassword, 'specialty'=>$specialty, 'dc'=>$now]) == 'success'){
            $smsg = "doctor '$userName' saved successfully";
        }else{
            $emsg = "something went wrong. try again";
        }
        
    }
    
}

# manage doctor
if(isset($_GET['id']) && isset($_GET['do'])){
    $id = $_GET['id']; $do = $_GET['do'];
    $dbUsername = getColumnVal('users',$id,'username');
    $dbEmail = getColumnVal('users',$id,'email');
    $dbRole = getColumnVal('users',$id,'role');
    // $dbRoleName = getColumnVal('roles',$dbRole);
    # edit
    # activate
    if($do == 'activate'){
        $promptMsg = "You are about to activate doctor '$dbUsername'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('users',$id) == 'changed'){
                $smsg = "doctor '$dbUsername' activated successfully";
            }
            else{
                $emsg = "activation failed. try again";
            }
        }
    }
    # deactivate
    if($do == 'deactivate'){
        $promptMsg = "You are about to deactivate doctor '$dbUsername'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('users',$id,'inactive') == 'changed'){
                $smsg = "doctor '$dbUsername' deactivated successfully";
            }
            else{
                $emsg = "deactivation failed. try again";
            }
        }        
    }
    # reset pwd
    if($do == 'reset-pwd'){
        $promptMsg = "You are about to reset password for doctor '$dbUsername'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            $q = resetPwd('users',$id);
            if($q == 'ok'){
                $smsg = "password reset for doctor '$dbUsername' was successful";
            }
            elseif($q == 'same'){
                $emsg = "password for doctor '$dbUsername' is already default";
            }
            else{
                $emsg = "reset failed. try again";
            }
        }
    }
    # delete
    if($do == 'delete'){
        $promptMsg = "You are about to delete doctor '$dbUsername'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(dbDelete('users',"id=".$id) == 'success'){
                $smsg = "doctor '$dbUsername' deleted successfully";
            }
            else{
                $emsg = "removal failed. try again";
            }
        }
    }
    # edit
    if($do == 'edit'){
        $cardTitle = "Edit $dbUsername";
        if(isset($_POST['updateUsername'])){
            # collect data from form element(s)
            $userName = trim(mysqli_real_escape_string($conn, $_POST['userName']));
            $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
            $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
            $role = trim(mysqli_real_escape_string($conn, $_POST['role']));
            $specialty = trim(mysqli_real_escape_string($conn, $_POST['specialty']));
            # validate the data to get rid of errors
            if(empty($userName)){ $errs[] = $userNameError = "value expected"; }
            if(empty($email)){ $errs[] = $emailError = "value expected"; }
            if(empty($password)){ $errs[] = $passwordError = "value expected"; }
            if(empty($role)){ $errs[] = $roleError = "value expected"; }
            if(empty($specialty)){ $errs[] = $specialtyError = "value expected"; }
            # prevent duplicate data in the database
            if(cntRows('users',"*","username='$userName' AND id<>$id") > 0){
                $errs[] = $userNameError = "doctor exists";
                $emsg = "doctor '$userName' already exists in the database. try again";
            }
            elseif(cntRows('users',"*","username='$userName' AND id=$id") > 0){
                $errs[] = $userNameError = "you must modify to continue";
            }

            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('users',['username'=>$userName, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "doctor '$dbUsername' updated to '$userName' successfully";
                }else{
                    $emsg = "something went wrong. try again";
                }

            }
        }
        
        if(isset($_POST['updateEmail'])){
            # collect data from form element(s)
            $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
            # validate the data to get rid of errors
            if(empty($email)){ $errs[] = $emailError = "value expected"; }
            # prevent duplicate data in the database
            if(cntRows('users',"*","email='$email' AND id<>$id") > 0){
                $errs[] = $emailError = "email exists";
                $emsg = "'$email' already exists in the database. try again";
            }
            elseif(cntRows('users',"*","email='$email' AND id=$id", "role='doctor'") > 0){
                $errs[] = $emailError = "you must modify to continue";
            }

            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('users',['email'=>$email, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "doctor '$dbEmail' updated to '$email' successfully";
                }else{
                    $emsg = "something went wrong. try again";
                }

            }
        }
        
        if(isset($_POST['updateRole'])){
            # collect data from form element(s)
            $role = intval(trim($_POST['role']));
            # validate the data to get rid of errors
            if($role == (0 || "")){ $errs[] = $roleError = "value expected"; }
            # prevent duplicate data in the database
            if(cntRows('users',"*","role=$role AND id=$id") > 0){
                $errs[] = $roleError = "you must modify to continue";
            }
            $newRoleName = getColumnVal('roles',$role);
            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('users',['role'=>$role, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "doctor role updated from '$dbRoleName' to '$newRoleName' successfully";
                }else{
                    $emsg = "something went wrong. try again";
                }

            }
        }
    }
    
}

if(isset($_GET['do']) && $_GET['do'] == 'truncate'){
        $promptMsg = "You are about to truncate a whole table. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(dbTruncate('users') == 'success'){
            $smsg = "Doctors data truncated successfully";
            }
            else{
                $emsg = "data could not be truncated";
            }
        }
        
    }
