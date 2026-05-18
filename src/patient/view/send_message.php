<?php
include '../inc/config.php';
include '../inc/auth.php';

$requestId = (int)($_GET['id'] ?? 0);
$message   = trim(mysqli_real_escape_string($conn, $_POST['message'] ?? ''));

if($requestId > 0 && !empty($message)) {
    dbInsert('chat_messages', [
        'request_id'  => $requestId,
        'sender_id'   => $uId,
        'sender_role' => 'patient',
        'message'     => $message
    ]);
}
