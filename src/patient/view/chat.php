<?php 
include '../inc/config.php';
include '../inc/auth.php';

const TITLE      = 'Chat';
const HEADER     = 'Manage Chat';
const BREADCRUMB = 'chat';
const KEYWORDS   = '';
const PAGE_DESC  = 'the patient chat page';

$pgURL = $patientRoot . "chat";

include '../inc/logics/chat.php';
include '../inc/head.php';

// Fetch existing meet link for this patient
$existingMeetLink = null;
$mlRow = dbSelect('meet_links', 'meet_url', "patient_id=$uId");
if($mlRow && mysqli_num_rows($mlRow) > 0) {
    $existingMeetLink = mysqli_fetch_array($mlRow)['meet_url'];
}
?>

<!-- ======= Header ======= -->
<?php include '../inc/header.php'; ?>

<!-- ======= Sidebar ======= -->
<?php include '../inc/sidebar.php'; ?>

<main id="main" class="main">

    <?php include '../inc/page-header.php'; ?>

    <?php if($chatRequestId > 0): ?>

    <div class="row g-3">

        <!-- Admin List -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Admin</div>
                <ul class="list-group list-group-flush" style="max-height:420px; overflow-y:auto;">
                    <?php
                    $administrators = dbSelect('administrators', 'id, fName, lName, role', "role=1", 'fName ASC');
                    if($administrators && mysqli_num_rows($administrators) > 0):
                        while($u = mysqli_fetch_array($administrators)):
                    ?>
                    <a href="?id=<?= $u['id'] ?>" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">
                                <?= strtoupper(substr($u['fName'],0,1).substr($u['lName'],0,1)) ?>
                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.9rem;"><?= htmlspecialchars($u['fName'].' '.$u['lName']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars(getColumnVal('roles', $u['role'])) ?></small>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; else: ?>
                    <li class="list-group-item text-muted text-center">No administrators found.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Chat Panel -->
        <div class="col-md-8">
            <div class="chat-panel card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Support Chat</span>
                </div>

                <?php if($existingMeetLink): ?>
                <div class="alert alert-info m-2 py-2 mb-0" style="font-size:0.85rem;">
                    <i class="bi bi-link-45deg"></i> Active meet link:
                    <a href="<?= htmlspecialchars($existingMeetLink) ?>" target="_blank"><?= htmlspecialchars($existingMeetLink) ?></a>
                </div>
                <?php endif; ?>

                <div class="chat-body p-3" style="height:300px; overflow-y:scroll;" id="msgArea">
                    <?php
                    $messages = dbSelect('chat_messages', '*', "request_id=$chatRequestId", "sent_at ASC");
                    if($messages && mysqli_num_rows($messages) > 0) {
                        while($msg = mysqli_fetch_array($messages)) {
                            $isMe  = ($msg['sender_role'] == 'patient') ? 'bg-primary text-white align-self-end' : 'bg-light text-dark';
                            $float = ($msg['sender_role'] == 'patient') ? 'text-end' : 'text-start';
                            echo '<div class="d-flex flex-column mb-3 '.$float.'">';
                            echo '  <div class="p-2 rounded shadow-sm border '.$isMe.'" style="max-width:80%;display:inline-block;">';
                            echo        htmlspecialchars($msg['message']);
                            echo '  </div>';
                            echo '  <small class="text-muted" style="font-size:0.65rem;">'.date('H:i', strtotime($msg['sent_at'])).'</small>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="text-center text-muted py-5"><i class="bi bi-chat-dots"></i><p>No messages yet.</p></div>';
                    }
                    ?>
                </div>

                <div class="card-footer">
                    <form id="chatForm" method="POST" action="">
                        <div class="input-group">
                            <input type="text" id="msgInput" name="message" class="form-control" placeholder="Type message...">
                            <input type="hidden" name="request_id" id="request_id" value="<?= $chatRequestId ?>">
                            <button class="btn btn-success" type="submit" name="sendMessage">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- End Row -->

    <?php else: ?>

    <!-- Admin Only List -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">Admin</div>
        <ul class="list-group list-group-flush">
            <?php
            $administrators = dbSelect('administrators', 'id, fName, lName, role', "role=1", 'fName ASC');
            if($administrators && mysqli_num_rows($administrators) > 0):
                while($u = mysqli_fetch_array($administrators)):
            ?>
            <a href="?id=<?= $u['id'] ?>" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">
                        <?= strtoupper(substr($u['fName'],0,1).substr($u['lName'],0,1)) ?>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.9rem;"><?= htmlspecialchars($u['fName'].' '.$u['lName']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($u['role']) ?></small>
                    </div>
                </div>
            </a>
            <?php endwhile; else: ?>
            <li class="list-group-item text-muted text-center">No administrators found.</li>
            <?php endif; ?>
        </ul>
    </div>

    <?php endif; ?>

</main>

<?php include '../inc/footer.php'; ?>
<?php include '../inc/foot.php'; ?>

<script>
$(function () {
    const requestId = <?= $chatRequestId ?>;
    const msgArea   = $('#msgArea');

    function scrollToBottom() { msgArea.scrollTop(msgArea[0].scrollHeight); }

    function loadMessages() {
        if(requestId <= 0) return;
        $.ajax({
            url: 'view/fetch_messages.php?id=' + requestId,
            method: 'GET',
            success: function(response) {
                if(msgArea.html().trim() !== response.trim()) {
                    msgArea.html(response);
                    scrollToBottom();
                }
            }
        });
    }

    loadMessages();
    setInterval(loadMessages, 2000);

    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        let msg = $('#msgInput').val().trim();
        if(msg === '') return;
        $.ajax({
            url: 'view/send_message.php?id=' + requestId,
            method: 'POST',
            data: { message: msg },
            success: function() {
                $('#msgInput').val('');
                loadMessages();
            }
        });
    });
});
</script>
