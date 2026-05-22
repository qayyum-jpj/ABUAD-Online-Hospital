<?php
include '../inc/config.php';
include '../inc/auth.php';

// $uId = admin's user ID (from administrators table, but we use it as sender)
// $_GET['userID'] = patient's user ID (receiver)
$receiverId = (int)($_GET['userID'] ?? 0);
$message    = trim(mysqli_real_escape_string($conn, $_POST['message'] ?? ''));

if($receiverId > 0 && !empty($message)) {
    dbInsert('chat_messages', [
        'sender_id'   => $uId,
        'receiver_id' => $receiverId,
        'sender_role' => 'admin',
        'message'     => $message
    ]);
}
