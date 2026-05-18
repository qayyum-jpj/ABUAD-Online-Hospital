<?php

// Auto-delete chat messages older than 24 hours
mysqli_query($conn, "DELETE FROM chat_messages WHERE sent_at < NOW() - INTERVAL 24 HOUR");

$errs = [];

// Get or create a chat_request row for this patient
$chatReq = dbSelect('chat_requests', 'id', "patient_id=$uId");
if($chatReq && mysqli_num_rows($chatReq) > 0) {
    $chatRequestId = mysqli_fetch_array($chatReq)['id'];
} else {
    dbInsert('chat_requests', ['patient_id' => $uId, 'status' => 'pending']);
    $chatRequestId = mysqli_insert_id($conn);
}

if(isset($_POST['sendMessage'])) {
    $message = trim(mysqli_real_escape_string($conn, $_POST['message'] ?? ''));

    if(empty($message)) $errs[] = "Message cannot be empty.";

    if(count($errs) == 0) {
        if(dbInsert('chat_messages', ['request_id' => $chatRequestId, 'sender_id' => $uId, 'sender_role' => 'patient', 'message' => $message]) == 'success') {
            $smsg = "message sent successfully";
        } else {
            $emsg = "something went wrong. try again";
        }
    }
}
