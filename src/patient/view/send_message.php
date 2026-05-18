<?php
include '../inc/config.php';
include '../inc/auth.php';

$message = trim(mysqli_real_escape_string($conn, $_POST['message'] ?? ''));

if(!empty($message)) {
    // Get or create chat_request for this patient
    $chatReq = dbSelect('chat_requests', 'id', "patient_id=$uId");
    if($chatReq && mysqli_num_rows($chatReq) > 0) {
        
    } else {
        dbInsert('chat_requests', ['request_id'=> $cuUserID, 'patient_id' => $uId, 'status' => 'pending']);
    }

    dbInsert('chat_messages', [
        'request_id'  => $cuUserID,
        'sender_id'   => $uId,
        'sender_role' => 'patient',
        'message'     => $message
    ]);
}
