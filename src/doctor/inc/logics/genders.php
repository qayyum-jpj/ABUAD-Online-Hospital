<?php

#handle form submissions
if(isset($_POST['saveGender'])){
    # collect data from form element(s)
    $genderName = trim(mysqli_real_escape_string($conn, $_POST['genderName']));
    # validate the data to get rid of errors
    if(empty($genderName)){ $errs[] = $genderNameError = "value expected"; }
    # prevent duplicate data in the database
    if(cntRows('genders',"*","name='$genderName'") > 0){
        $errs[] = $genderNameError = "gender exists";
        $emsg = "gender '$genderName' already exists in the database. try again";
    }
    
    # save data when all errors have been resolved
    if(count($errs) == 0){
        if(dbInsert('genders',['name'=>$genderName, 'dc'=>$now]) == 'success'){
            $smsg = "gender '$genderName' saved successfully";
        }else{
            $emsg = "something went wrong. try again";
        }
        
    }
    
}

# manage gender
if(isset($_GET['id']) && isset($_GET['do'])){
    $id = $_GET['id']; $do = $_GET['do'];
    $dbGenderName = getColumnVal('genders',$id);
    # edit
    # activate
    if($do == 'activate'){
        $promptMsg = "You are about to activate gender '$id'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('genders',$id) == 'changed'){
                $smsg = "gender '$dbGenderName' activated successfully";
                $doNotResubmit = true;
            }
            else{
                $emsg = "activation failed. try again";
            }
        }
    }
    # deactivate
    if($do == 'deactivate'){
        $promptMsg = "You are about to deactivate gender '$dbGenderName'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('genders',$id,'inactive') == 'changed'){
                $smsg = "gender '$dbGenderName' deactivated successfully";
            }
            else{
                $emsg = "deactivation failed. try again";
            }
        }
    }
    # delete
    if($do == 'delete'){
        $promptMsg = "You are about to delete gender '$dbGenderName'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(dbDelete('genders',"id=".$id) == 'success'){
                $smsg = "gender '$dbGenderName' deleted successfully";
            }
            else{
                $emsg = "removal failed. try again";
            }
        }
    }
    
    # edit
    if($do == 'edit'){
        $cardTitle = "Edit $dbGenderName";
        if(isset($_POST['editGender'])){
            # collect data from form element(s)
            $genderName = trim(mysqli_real_escape_string($conn, $_POST['genderName']));
            # validate the data to get rid of errors
            if(empty($genderName)){ $errs[] = $genderNameError = "value expected"; }
            # prevent duplicate data in the database
            if(cntRows('genders',"*","name='$genderName' AND id<>$id") > 0){
                $errs[] = $genderNameError = "gender exists";
                $emsg = "gender '$genderName' already exists in the database. try again";
            }
            elseif(cntRows('genders',"*","name='$genderName' AND id=$id") > 0){
                $errs[] = $genderNameError = "you must modify to continue";
            }

            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('genders',['name'=>$genderName, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "gender '$dbGenderName' updated to '$genderName' successfully";
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
            if(cntRows('genders',"*") > 0){
                if(dbTruncate('genders') == 'success'){
                $smsg = "Genders data truncated successfully";
                }
                else{
                    $emsg = "data could not be truncated";
                }
            }
            else{
                $emsg = "No data to truncate. Table is empty";
            }
        }
        
    }
