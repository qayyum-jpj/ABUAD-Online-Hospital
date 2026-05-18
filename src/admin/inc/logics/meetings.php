<?php

#handle form submissions

# manage meeting
if(isset($_GET['id']) && isset($_GET['do'])){
    $id = $_GET['id']; $do = $_GET['do'];
    $dbMeetingName = getColumnVal('meetings',$id);
    # edit
    # activate
    if($do == 'activate'){
        $promptMsg = "You are about to activate meeting '$id'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('meetings',$id) == 'changed'){
                $smsg = "meeting '$dbMeetingName' activated successfully";
                $doNotResubmit = true;
            }
            else{
                $emsg = "activation failed. try again";
            }
        }
    }
    # deactivate
    if($do == 'deactivate'){
        $promptMsg = "You are about to deactivate meeting '$dbMeetingName'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(changeStatus('meetings',$id,'inactive') == 'changed'){
                $smsg = "meeting '$dbMeetingName' deactivated successfully";
            }
            else{
                $emsg = "deactivation failed. try again";
            }
        }
    }
    # delete
    if($do == 'delete'){
        $promptMsg = "You are about to delete meeting '$dbMeetingName'. Are you sure?";
        $prompt = true;
        if(isset($_POST['doAction'])){
            $prompt = false;
            if(dbDelete('meetings',"id=".$id) == 'success'){
                $smsg = "meeting '$dbMeetingName' deleted successfully";
            }
            else{
                $emsg = "removal failed. try again";
            }
        }
    }
    
    # edit
    if($do == 'edit'){
        $cardTitle = "Edit $dbMeetingName";
        if(isset($_POST['editMeeting'])){
            # collect data from form element(s)
            $meetingName = trim(mysqli_real_escape_string($conn, $_POST['meetingName']));
            # validate the data to get rid of errors
            if(empty($meetingName)){ $errs[] = $meetingNameError = "value expected"; }
            # prevent duplicate data in the database
            if(cntRows('meetings',"*","name='$meetingName' AND id<>$id") > 0){
                $errs[] = $meetingNameError = "meeting exists";
                $emsg = "meeting '$meetingName' already exists in the database. try again";
            }
            elseif(cntRows('meetings',"*","name='$meetingName' AND id=$id") > 0){
                $errs[] = $meetingNameError = "you must modify to continue";
            }

            # save data when all errors have been resolved
            if(count($errs) == 0){
                if(dbUpdate('meetings',['name'=>$meetingName, 'du'=>$now],"id=".$id) == 'success'){
                    $smsg = "meeting '$dbMeetingName' updated to '$meetingName' successfully";
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
            if(cntRows('meetings',"*") > 0){
                if(dbTruncate('meetings') == 'success'){
                $smsg = "Meetings data truncated successfully";
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
