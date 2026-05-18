<?php

#handle form submissions
if(isset($_POST['saveCountry'])){
    # collect data from form element(s)
    $countryName = trim(mysqli_real_escape_string($conn, $_POST['countryName']));
    # validate the data to get rid of errors
    if(empty($countryName)){ $errs[] = $countryNameError = "value expected"; }
    # prevent duplicate data in the database
    if(cntRows('countries',"*","name='$countryName'") > 0){
        $errs[] = $countryNameError = "country exists";
        $emsg = "country '$countryName' already exists in the database. try again";
    }
    
    # save data when all errors have been resolved
    if(count($errs) == 0){
        if(dbInsert('countries',['name'=>$countryName, 'dc'=>$now]) == 'success'){
            $smsg = "country '$countryName' saved successfully";
        }else{
            $emsg = "something went wrong. try again";
        }
        
    }
    
}

# manage country
if(isset($_GET['id']) && isset($_GET['do'])){
    $id = $_GET['id']; $do = $_GET['do'];
    $dbCountryName = getColumnVal('countries',$id);
    # edit
    # activate
    if($do == 'activate'){
        $promptMsg = "You are about to activate country '$id'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('countries',$id) == 'changed'){
                $smsg = "country '$dbCountryName' activated successfully";
            }
            else{
                $emsg = "activation failed. try again";
            }
        }
    }
    # deactivate
    if($do == 'deactivate'){
        $promptMsg = "You are about to deactivate country '$dbCountryName'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('countries',$id,'inactive') == 'changed'){
                $smsg = "country '$dbCountryName' deactivated successfully";
            }
            else{
                $emsg = "deactivation failed. try again";
            }
        }
    }
    # delete
    if($do == 'delete'){
        $promptMsg = "You are about to delete country '$dbCountryName'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(dbDelete('countries',"id=".$id) == 'success'){
                $smsg = "country '$dbCountryName' deleted successfully";
            }
            else{
                $emsg = "removal failed. try again";
            }
        }
    }
    
    # edit
    if($do == 'edit'){
        $cardTitle = "Edit $dbCountryName";
        if(isset($_POST['editCountry'])){
            # collect data from form element(s)
            $countryName = trim(mysqli_real_escape_string($conn, $_POST['countryName']));
            # validate the data to get rid of errors
            if(empty($countryName)){ $errs[] = $countryNameError = "value expected"; }
            # prevent duplicate data in the database
            if(cntRows('countries',"*","name='$countryName' AND id<>$id") > 0){
                $errs[] = $countryNameError = "country exists";
                $emsg = "country '$countryName' already exists in the database. try again";
            }
            elseif(cntRows('countries',"*","name='$countryName' AND id=$id") > 0){
                $errs[] = $countryNameError = "you must modify to continue";
            }

            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('countries',['name'=>$countryName, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "country '$dbCountryName' updated to '$countryName' successfully";
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
            if(cntRows('countries',"*") > 0){
                if(dbTruncate('countries') == 'success'){
                $smsg = "Countries data truncated successfully";
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
