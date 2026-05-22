<?php
include '../inc/config.php';
include '../inc/auth.php';

const TITLE      = 'Chat';
const HEADER     = 'Support Chat';
const BREADCRUMB = 'chat';
const KEYWORDS   = '';
const PAGE_DESC  = 'the patient chat page';

$pgURL = $patientRoot . "chat";

include '../inc/logics/chat.php';
include '../inc/head.php';

// userID = the admin's ID from the URL
$adminUserId = (int)($_GET['userID'] ?? 0);

// Fetch existing meet link for this patient
$existingMeetLink = null;
$mlRow = dbSelect('meet_links', 'meet_url', "patient_id=$uId");
if($mlRow && mysqli_num_rows($mlRow) > 0) {
    $existingMeetLink = mysqli_fetch_array($mlRow)['meet_url'];
}
?>

<?php include '../inc/header.php'; ?>
<?php include '../inc/sidebar.php'; ?>

<main id="main" class="main">

    <?php include '../inc/page-header.php'; ?>

    <?php if($adminUserId > 0): ?>

    <div class="row g-3">

        <!-- Admin List -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Admin</div>
                <ul class="list-group list-group-flush" style="max-height:420px; overflow-y:auto;">
                    <?php
                    $administrators = dbSelect('administrators', 'id, fName, lName', null, 'fName ASC');
                    if($administrators && mysqli_num_rows($administrators) > 0):
                        while($u = mysqli_fetch_array($administrators)):
                            $active = ($adminUserId == $u['id']) ? 'active' : '';
                            $unreadQ = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM chat_messages WHERE sender_id={$u['id']} AND receiver_id=$uId AND sender_role='admin' AND is_read=0");
                            $unread  = $unreadQ ? (int)mysqli_fetch_array($unreadQ)['cnt'] : 0;
                    ?>
                    <a href="?userID=<?= $u['id'] ?>" class="list-group-item list-group-item-action <?= $active ?>">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">
                                    <?= strtoupper(substr($u['fName'],0,1).substr($u['lName'],0,1)) ?>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:0.9rem;"><?= htmlspecialchars($u['fName'].' '.$u['lName']) ?></div>
                                    <small class="text-muted">Admin</small>
                                </div>
                            </div>
                            <?php if($unread > 0): ?>
                            <span class="badge bg-danger rounded-pill"><?= $unread ?></span>
                            <?php endif; ?>
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
                <div class="alert alert-success m-2 py-2 mb-0" style="font-size:0.85rem;">
                    <i class="bi bi-camera-video-fill"></i> Meeting scheduled:
                    <a href="<?= htmlspecialchars($existingMeetLink) ?>" target="_blank" class="btn btn-success btn-sm ms-2">Join Meeting</a>
                </div>
                <?php endif; ?>

                <div class="chat-body p-3" style="height:300px; overflow-y:scroll;" id="msgArea"></div>

                <div class="card-footer">
                    <form id="chatForm">
                        <div class="input-group">
                            <input type="text" id="msgInput" class="form-control" placeholder="Type message...">
                            <button class="btn btn-success" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <?php else: ?>

    <!-- Admin Only List -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">Admin</div>
        <ul class="list-group list-group-flush">
            <?php
            $administrators = dbSelect('administrators', 'id, fName, lName', null, 'fName ASC');
            if($administrators && mysqli_num_rows($administrators) > 0):
                while($u = mysqli_fetch_array($administrators)):
                    $unreadQ = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM chat_messages WHERE sender_id={$u['id']} AND receiver_id=$uId AND sender_role='admin' AND is_read=0");
                    $unread  = $unreadQ ? (int)mysqli_fetch_array($unreadQ)['cnt'] : 0;
            ?>
            <a href="?userID=<?= $u['id'] ?>" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">
                            <?= strtoupper(substr($u['fName'],0,1).substr($u['lName'],0,1)) ?>
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:0.9rem;"><?= htmlspecialchars($u['fName'].' '.$u['lName']) ?></div>
                            <small class="text-muted">Admin</small>
                        </div>
                    </div>
                    <?php if($unread > 0): ?>
                    <span class="badge bg-danger rounded-pill"><?= $unread ?></span>
                    <?php endif; ?>
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
$(function() {
    const adminUserId = <?= $adminUserId ?>;
    const msgArea = $('#msgArea');

    function scrollToBottom() { msgArea.scrollTop(msgArea[0].scrollHeight); }

    function loadMessages() {
        if(adminUserId <= 0) return;
        $.ajax({
            url: 'view/fetch_messages.php?userID=' + adminUserId,
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
            url: 'view/send_message.php?userID=' + adminUserId,
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
