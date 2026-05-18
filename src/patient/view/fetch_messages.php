<?php
include '../inc/config.php';
include '../inc/auth.php';

// Get the request ID from the AJAX 'data' parameter
$reqId = (int)($_GET['reqId'] ?? 0);

if ($reqId > 0) {
    $messages = dbSelect('chat_messages', '*', "request_id=$reqId", "sent_at ASC");

    if ($messages && mysqli_num_rows($messages) > 0) {
        while ($msg = mysqli_fetch_array($messages)) {
            // Logic to check if the message was sent by the current logged-in patient
            // We assume 'sender_role' is stored in the DB to distinguish users
            $isMe  = ($msg['sender_role'] == 'patient') ? 'bg-primary text-white align-self-end' : 'bg-light text-dark align-self-start';
            $float = ($msg['sender_role'] == 'patient') ? 'text-end' : 'text-start';
            $align = ($msg['sender_role'] == 'patient') ? 'justify-content-end' : 'justify-content-start';
            ?>
            
            <div class="d-flex <?= $align ?> mb-3">
                <div class="d-flex flex-column <?= $float ?>" style="max-width: 80%;">
                    <div class="p-2 rounded shadow-sm border <?= $isMe ?>">
                        <?= htmlspecialchars($msg['message']) ?>
                    </div>
                    <small class="text-muted mt-1" style="font-size:0.7rem;">
                        <?= date('h:i A', strtotime($msg['sent_at'])) ?>
                    </small>
                </div>
            </div>

            <?php
        }
    } else {
        // Fallback for an empty conversation
        echo '
        <div class="text-center text-muted py-5">
            <i class="bi bi-chat-dots fs-1"></i>
            <p class="mt-2">No messages yet. Start the conversation!</p>
        </div>';
    }
} else {
    echo '<div class="alert alert-danger">Error: No conversation selected.</div>';
}
?>