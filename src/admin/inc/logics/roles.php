<?php

#handle form submissions
if(isset($_POST['saveRole'])){
    # collect data from form element(s)
    $roleName = trim(mysqli_real_escape_string($conn, $_POST['roleName']));
    # validate the data to get rid of errors
    if(empty($roleName)){ $errs[] = $roleNameError = "value expected"; }
    # prevent duplicate data in the database
    if(cntRows('roles',"*","name='$roleName'") > 0){
        $errs[] = $roleNameError = "role exists";
        $emsg = "role '$roleName' already exists in the database. try again";
    }
    
    # save data when all errors have been resolved
    if(count($errs) == 0){
        if(dbInsert('roles',['name'=>$roleName, 'dc'=>$now]) == 'success'){
            $smsg = "role '$roleName' saved successfully";
        }else{
            $emsg = "something went wrong. try again";
        }
        
    }
    
}

# manage role
if(isset($_GET['id']) && isset($_GET['do'])){
    $id = $_GET['id']; $do = $_GET['do'];
    $dbRoleName = getColumnVal('roles',$id);
    # edit
    # activate
    if($do == 'activate'){
        $promptMsg = "You are about to activate role '$id'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('roles',$id) == 'changed'){
                $smsg = "role '$dbRoleName' activated successfully";
            }
            else{
                $emsg = "activation failed. try again";
            }
        }
    }
    # deactivate
    if($do == 'deactivate'){
        $promptMsg = "You are about to deactivate role '$dbRoleName'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('roles',$id,'inactive') == 'changed'){
                $smsg = "role '$dbRoleName' deactivated successfully";
            }
            else{
                $emsg = "deactivation failed. try again";
            }
        }
    }
    # delete
    if($do == 'delete'){
        $promptMsg = "You are about to delete role '$dbRoleName'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(dbDelete('roles',"id=".$id) == 'success'){
                $smsg = "role '$dbRoleName' deleted successfully";
            }
            else{
                $emsg = "removal failed. try again";
            }
        }
    }
    
    # edit
    if($do == 'edit'){
        $cardTitle = "Edit $dbRoleName";
        if(isset($_POST['editRole'])){
            # collect data from form element(s)
            $roleName = trim(mysqli_real_escape_string($conn, $_POST['roleName']));
            # validate the data to get rid of errors
            if(empty($roleName)){ $errs[] = $roleNameError = "value expected"; }
            # prevent duplicate data in the database
            if(cntRows('roles',"*","name='$roleName' AND id<>$id") > 0){
                $errs[] = $roleNameError = "role exists";
                $emsg = "role '$roleName' already exists in the database. try again";
            }
            elseif(cntRows('roles',"*","name='$roleName' AND id=$id") > 0){
                $errs[] = $roleNameError = "you must modify to continue";
            }

            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('roles',['name'=>$roleName, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "role '$dbRoleName' updated to '$roleName' successfully";
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
            if(dbTruncate('roles') == 'success'){
            $smsg = "Roles data truncated successfully";
            }
            else{
                $emsg = "data could not be truncated";
            }
        }
        
    }
