<?php

#handle form submissions
if(isset($_POST['saveAdministrator'])){
    # collect data from form element(s)
    $userName = trim(mysqli_real_escape_string($conn, $_POST['userName']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $role = intval(trim($_POST['role']));
    # validate the data to get rid of errors
    if(empty($userName)){ $errs[] = $userNameError = "value expected"; }
    if(empty($email)){ $errs[] = $emailError = "value expected"; }
    if($role == (0 || "")){ $errs[] = $roleError = "please select"; }
    # prevent duplicate data in the database
    if(cntRows('administrators',"*","username='$userName'") > 0){
        $errs[] = $userNameError = "administrator exists";
        $emsg = "administrator '$userName' already exists in the database. try again";
    }
    
    # save data when all errors have been resolved
    if(count($errs) == 0){
        while(true){
            $randVal = "MMA-".rand(000,999);
            if(preventDuplicateID('administrators',$randVal) == 'ok'){
                break;
            }
        }
        if(dbInsert('administrators',['userID'=>$randVal,'username'=>$userName, 'email'=>$email, 'role'=>$role, 'dc'=>$now]) == 'success'){
            $smsg = "administrator '$userName' saved successfully";
        }else{
            $emsg = "something went wrong. try again";
        }
        
    }
    
}

# manage administrator
if(isset($_GET['id']) && isset($_GET['do'])){
    $id = $_GET['id']; $do = $_GET['do'];
    $dbUsername = getColumnVal('administrators',$id,'username');
    $dbEmail = getColumnVal('administrators',$id,'email');
    $dbRole = getColumnVal('administrators',$id,'role');
    $dbRoleName = getColumnVal('roles',$dbRole);
    # edit
    # activate
    if($do == 'activate'){
        $promptMsg = "You are about to activate administrator '$dbUsername'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('administrators',$id) == 'changed'){
                $smsg = "administrator '$dbUsername' activated successfully";
            }
            else{
                $emsg = "activation failed. try again";
            }
        }
    }
    # deactivate
    if($do == 'deactivate'){
        $promptMsg = "You are about to deactivate administrator '$dbUsername'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('administrators',$id,'inactive') == 'changed'){
                $smsg = "administrator '$dbUsername' deactivated successfully";
            }
            else{
                $emsg = "deactivation failed. try again";
            }
        }        
    }
    # reset pwd
    if($do == 'reset-pwd'){
        $promptMsg = "You are about to reset password for administrator '$dbUsername'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            $q = resetPwd('administrators',$id);
            if($q == 'ok'){
                $smsg = "password reset for administrator '$dbUsername' was successful";
            }
            elseif($q == 'same'){
                $emsg = "password for administrator '$dbUsername' is already default";
            }
            else{
                $emsg = "reset failed. try again";
            }
        }
    }
    # delete
    if($do == 'delete'){
        $promptMsg = "You are about to delete administrator '$dbUsername'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(dbDelete('administrators',"id=".$id) == 'success'){
                $smsg = "administrator '$dbUsername' deleted successfully";
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
            # validate the data to get rid of errors
            if(empty($userName)){ $errs[] = $userNameError = "value expected"; }
            # prevent duplicate data in the database
            if(cntRows('administrators',"*","username='$userName' AND id<>$id") > 0){
                $errs[] = $userNameError = "administrator exists";
                $emsg = "administrator '$userName' already exists in the database. try again";
            }
            elseif(cntRows('administrators',"*","username='$userName' AND id=$id") > 0){
                $errs[] = $userNameError = "you must modify to continue";
            }

            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('administrators',['username'=>$userName, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "administrator '$dbUsername' updated to '$userName' successfully";
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
            if(cntRows('administrators',"*","email='$email' AND id<>$id") > 0){
                $errs[] = $emailError = "email exists";
                $emsg = "'$email' already exists in the database. try again";
            }
            elseif(cntRows('administrators',"*","email='$email' AND id=$id") > 0){
                $errs[] = $emailError = "you must modify to continue";
            }

            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('administrators',['email'=>$email, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "administrator '$dbEmail' updated to '$email' successfully";
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
            if(cntRows('administrators',"*","role=$role AND id=$id") > 0){
                $errs[] = $roleError = "you must modify to continue";
            }
            $newRoleName = getColumnVal('roles',$role);
            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('administrators',['role'=>$role, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "administrator role updated from '$dbRoleName' to '$newRoleName' successfully";
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
            if(dbTruncate('administrators') == 'success'){
            $smsg = "Administrators data truncated successfully";
            }
            else{
                $emsg = "data could not be truncated";
            }
        }
        
    }
