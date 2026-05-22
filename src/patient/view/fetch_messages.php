<?php
include '../inc/config.php';
include '../inc/auth.php';

// Load messages between patient ($uId) and admin ($_GET['userID'])
$adminId = (int)($_GET['userID'] ?? 0);

if($adminId > 0) {
    $messages = mysqli_query($conn,
        "SELECT * FROM chat_messages
         WHERE (sender_id=$uId AND receiver_id=$adminId)
            OR (sender_id=$adminId AND receiver_id=$uId)
         ORDER BY sent_at ASC"
    );

    if($messages && mysqli_num_rows($messages) > 0) {
        while($msg = mysqli_fetch_array($messages)) {
            $isMe  = ($msg['sender_role'] == 'patient') ? 'bg-primary text-white' : 'bg-light text-dark';
            $float = ($msg['sender_role'] == 'patient') ? 'justify-content-end' : 'justify-content-start';
            $align = ($msg['sender_role'] == 'patient') ? 'text-end' : 'text-start';
            ?>
            <div class="d-flex <?= $float ?> mb-3">
                <div class="d-flex flex-column <?= $align ?>" style="max-width:80%;">
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
        echo '<div class="text-center text-muted py-5"><i class="bi bi-chat-dots fs-1"></i><p class="mt-2">No messages yet.</p></div>';
    }
} else {
    echo '<div class="alert alert-danger">No conversation selected.</div>';
}
?>
