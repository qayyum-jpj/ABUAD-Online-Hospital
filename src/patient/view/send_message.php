<?php
include '../inc/config.php';
include '../inc/auth.php';

// $uId = patient's user ID (sender)
// $_GET['userID'] = admin's ID (receiver) — stored in administrators table
$receiverId = (int)($_GET['userID'] ?? 0);
$message    = trim(mysqli_real_escape_string($conn, $_POST['message'] ?? ''));

if($receiverId > 0 && !empty($message)) {
    dbInsert('chat_messages', [
        'sender_id'   => $uId,
        'receiver_id' => $receiverId,
        'sender_role' => 'patient',
        'message'     => $message
    ]);
}
