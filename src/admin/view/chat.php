<?php
include '../inc/config.php';
include '../inc/auth.php';

const TITLE      = 'Chat';
const HEADER     = 'Manage Chat';
const BREADCRUMB = 'chat';
const KEYWORDS   = '';
const PAGE_DESC  = 'the admin management page';

$pgURL = $adminRoot . "chat";

include '../inc/logics/chat.php';
include '../inc/head.php';

// userID = the patient's user ID from the URL
$patientUserId = (int)($_GET['userID'] ?? 0);

// Check if patient has sent at least one message (admin cannot write first)
$patientHasMessaged = false;
if($patientUserId > 0) {
    $checkFirst = mysqli_query($conn, "SELECT id FROM chat_messages WHERE sender_id=$patientUserId AND receiver_id=$uId AND sender_role='patient'");
    $patientHasMessaged = ($checkFirst && mysqli_num_rows($checkFirst) > 0);

    // Mark patient messages as read
    mysqli_query($conn, "UPDATE chat_messages SET is_read=1 WHERE sender_id=$patientUserId AND receiver_id=$uId AND sender_role='patient' AND is_read=0");
}

// Fetch existing meet link for this patient
$existingMeetLink = null;
if($patientUserId > 0) {
    $mlRow = dbSelect('meet_links', 'meet_url', "patient_id=$patientUserId");
    if($mlRow && mysqli_num_rows($mlRow) > 0) {
        $existingMeetLink = mysqli_fetch_array($mlRow)['meet_url'];
    }
}
?>

<?php include '../inc/header.php'; ?>
<?php include '../inc/sidebar.php'; ?>

<main id="main" class="main">

    <?php include '../inc/page-header.php'; ?>

    <?php if($patientUserId > 0): ?>

    <div class="row g-3">

        <!-- Users List -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Users</div>
                <ul class="list-group list-group-flush" style="max-height:420px; overflow-y:auto;">
                    <?php
                    $users = dbSelect('users', 'id, fName, lName, role', "role!='doctor'", 'fName ASC');
                    if($users && mysqli_num_rows($users) > 0):
                        while($u = mysqli_fetch_array($users)):
                            $active = ($patientUserId == $u['id']) ? 'active' : '';
                            // Count unread messages from this patient
                            $unreadQ = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM chat_messages WHERE sender_id={$u['id']} AND receiver_id=$uId AND sender_role='patient' AND is_read=0");
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
                                    <small class="text-muted"><?= htmlspecialchars($u['role']) ?></small>
                                </div>
                            </div>
                            <?php if($unread > 0): ?>
                            <span class="badge bg-danger rounded-pill"><?= $unread ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                    <?php endwhile; else: ?>
                    <li class="list-group-item text-muted text-center">No users found.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Chat Panel -->
        <div class="col-md-8">
            <div class="chat-panel card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Support Chat</span>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#meetLinkModal">
                        <i class="bi bi-camera-video"></i> Schedule Meeting
                    </button>
                </div>

                <?php if($existingMeetLink): ?>
                <div class="alert alert-info m-2 py-2 mb-0" style="font-size:0.85rem;">
                    <i class="bi bi-link-45deg"></i> Active meet link:
                    <a href="<?= htmlspecialchars($existingMeetLink) ?>" target="_blank"><?= htmlspecialchars($existingMeetLink) ?></a>
                </div>
                <?php endif; ?>

                <div class="chat-body p-3" style="height:300px; overflow-y:scroll;" id="msgArea"></div>

                <div class="card-footer">
                    <?php if($patientHasMessaged): ?>
                    <form id="chatForm">
                        <div class="input-group">
                            <input type="text" id="msgInput" class="form-control" placeholder="Type message...">
                            <button class="btn btn-success" type="submit">Send</button>
                        </div>
                    </form>
                    <?php else: ?>
                    <div class="text-muted text-center py-2" style="font-size:0.85rem;">
                        <i class="bi bi-lock"></i> Waiting for the patient to send the first message.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Meeting Modal -->
    <div class="modal fade" id="meetLinkModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-camera-video"></i> Schedule Meeting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if(!empty($smsg)): ?><div class="alert alert-success"><?= $smsg ?></div><?php endif; ?>
                    <?php if(!empty($emsg)): ?><div class="alert alert-danger"><?= $emsg ?></div><?php endif; ?>
                    <form method="POST" action="">
                        <input type="hidden" name="patient_id" value="<?= $patientUserId ?>">
                        <div class="mb-3">
                            <label class="form-label">Assign Doctor</label>
                            <select name="doctor_id" id="doctorSelect" class="form-select" required>
                                <option value="">-- Select Doctor --</option>
                                <?php
                                $docs = dbSelect('users', 'id, fName, lName, email', "role='doctor' AND status='active'", 'fName ASC');
                                if($docs && mysqli_num_rows($docs) > 0):
                                    while($d = mysqli_fetch_array($docs)):
                                ?>
                                <option value="<?= $d['id'] ?>" data-email="<?= htmlspecialchars($d['email']) ?>">
                                    <?= htmlspecialchars('Dr. '.$d['fName'].' '.$d['lName']) ?>
                                </option>
                                <?php endwhile; endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Doctor Email</label>
                            <input type="email" name="doctor_email" id="doctorEmail" class="form-control" placeholder="Auto-filled on doctor select" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="meet_date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Time</label>
                                <input type="time" name="meet_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Symptoms Summary</label>
                            <textarea name="symptoms_summary" class="form-control" rows="3" placeholder="Briefly describe the patient's symptoms..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Triage Level</label>
                            <select name="triage_level" class="form-select" required>
                                <option value="">-- Select Triage Level --</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="Emergency">Emergency</option>
                            </select>
                        </div>
                        <p class="text-muted" style="font-size:0.8rem;"><i class="bi bi-info-circle"></i> A unique WebRTC link will be auto-generated and emailed to the doctor. Only the patient sees it in their dashboard.</p>
                        <button type="submit" name="saveMeetLink" class="btn btn-primary w-100">Schedule &amp; Notify Doctor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>

    <!-- Users Only List -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">Users</div>
        <ul class="list-group list-group-flush">
            <?php
            $users = dbSelect('users', 'id, fName, lName, role', "role!='doctor'", 'fName ASC');
            if($users && mysqli_num_rows($users) > 0):
                while($u = mysqli_fetch_array($users)):
                    $unreadQ = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM chat_messages WHERE sender_id={$u['id']} AND receiver_id=$uId AND sender_role='patient' AND is_read=0");
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
                            <small class="text-muted"><?= htmlspecialchars($u['role']) ?></small>
                        </div>
                    </div>
                    <?php if($unread > 0): ?>
                    <span class="badge bg-danger rounded-pill"><?= $unread ?></span>
                    <?php endif; ?>
                </div>
            </a>
            <?php endwhile; else: ?>
            <li class="list-group-item text-muted text-center">No users found.</li>
            <?php endif; ?>
        </ul>
    </div>

    <?php endif; ?>

</main>

<?php include '../inc/footer.php'; ?>
<?php include '../inc/foot.php'; ?>

<script>
$(function() {
    const patientUserId = <?= $patientUserId ?>;
    const msgArea = $('#msgArea');

    function scrollToBottom() { msgArea.scrollTop(msgArea[0].scrollHeight); }

    function loadMessages() {
        if(patientUserId <= 0) return;
        $.ajax({
            url: 'view/fetch_messages.php?userID=' + patientUserId,
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
            url: 'view/send_message.php?userID=' + patientUserId,
            method: 'POST',
            data: { message: msg },
            success: function() {
                $('#msgInput').val('');
                loadMessages();
            }
        });
    });

    $('#doctorSelect').on('change', function() {
        $('#doctorEmail').val($(this).find(':selected').data('email') || '');
    });
});
</script>
