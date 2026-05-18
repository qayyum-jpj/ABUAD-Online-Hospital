<?php

// Auto-delete chat messages older than 24 hours
mysqli_query($conn, "DELETE FROM chat_messages WHERE sent_at < NOW() - INTERVAL 24 HOUR");

$errs = [];

if(isset($_POST['sendMessage'])) {
    $requestId = (int)($_GET['id'] ?? 0);
    $message   = trim(mysqli_real_escape_string($conn, $_POST['message'] ?? ''));

    if(empty($message)) $errs[] = "Message cannot be empty.";
    if($requestId <= 0)  $errs[] = "Invalid request.";

    if(count($errs) == 0) {
        if(dbInsert('chat_messages', ['request_id' => $requestId, 'sender_id' => $uId, 'sender_role' => 'admin', 'message' => $message]) == 'success') {
            $smsg = "message sent successfully";
        } else {
            $emsg = "something went wrong. try again";
        }
    }
}

include 'meet_link.php';
