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

$reqId = (int)($_GET['id'] ?? 0);

// Check if patient has sent at least one message (admin cannot write first)
$patientHasMessaged = false;
if ($reqId > 0) {
    $checkFirst = dbSelect('chat_messages', 'id', "request_id=$reqId AND sender_role='patient'");
    $patientHasMessaged = ($checkFirst && mysqli_num_rows($checkFirst) > 0);
}

// Fetch existing meet link for this patient
$existingMeetLink = null;
if ($reqId > 0) {
    $mlRow = dbSelect('meet_links', 'meet_url', "patient_id=$reqId");
    if ($mlRow && mysqli_num_rows($mlRow) > 0) {
        $existingMeetLink = mysqli_fetch_array($mlRow)['meet_url'];
    }
}
?>

<!-- ======= Header ======= -->
<?php include '../inc/header.php'; ?>

<!-- ======= Sidebar ======= -->
<?php include '../inc/sidebar.php'; ?>

<main id="main" class="main">

    <?php include '../inc/page-header.php'; ?>

    <?php if ($reqId > 0): ?>

        <div class="row g-3">

            <!-- Users List -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header fw-semibold">Users</div>
                    <ul class="list-group list-group-flush" style="max-height:420px; overflow-y:auto;">
                        <?php
                        $users = dbSelect('users', 'id, fName, lName, role', "role!='doctor'", 'fName ASC');
                        if ($users && mysqli_num_rows($users) > 0):
                            while ($u = mysqli_fetch_array($users)):
                                $active = ($reqId == $u['id']) ? 'active' : '';
                        ?>
                                <a href="?id=<?= $u['id'] ?>" class="list-group-item list-group-item-action <?= $active ?>">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">
                                            <?= strtoupper(substr($u['fName'], 0, 1) . substr($u['lName'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="font-size:0.9rem;"><?= htmlspecialchars($u['fName'] . ' ' . $u['lName']) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($u['role']) ?></small>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile;
                        else: ?>
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
                            <i class="bi bi-camera-video"></i> Send Meet Link
                        </button>
                    </div>

                    <?php if ($existingMeetLink): ?>
                        <div class="alert alert-info m-2 py-2 mb-0" style="font-size:0.85rem;">
                            <i class="bi bi-link-45deg"></i> Active meet link:
                            <a href="<?= htmlspecialchars($existingMeetLink) ?>" target="_blank"><?= htmlspecialchars($existingMeetLink) ?></a>
                        </div>
                    <?php endif; ?>

                    <div class="chat-body p-3" style="height:300px; overflow-y:scroll;" id="msgArea">
                        <?php
                        $messages = dbSelect('chat_messages', '*', "request_id=$reqId", "sent_at ASC");
                        if ($messages && mysqli_num_rows($messages) > 0) {
                            while ($msg = mysqli_fetch_array($messages)) {
                                $isMe  = ($msg['sender_role'] == 'admin') ? 'bg-primary text-white align-self-end' : 'bg-light text-dark';
                                $float = ($msg['sender_role'] == 'admin') ? 'text-end' : 'text-start';
                                echo '<div class="d-flex flex-column mb-3 ' . $float . '">';
                                echo '  <div class="p-2 rounded shadow-sm border ' . $isMe . '" style="max-width:80%;display:inline-block;">';
                                echo        htmlspecialchars($msg['message']);
                                echo '  </div>';
                                echo '  <small class="text-muted" style="font-size:0.65rem;">' . date('H:i', strtotime($msg['sent_at'])) . '</small>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="text-center text-muted py-5"><i class="bi bi-chat-dots"></i><p>No messages yet.</p></div>';
                        }
                        ?>
                    </div>

                    <div class="card-footer">
                        <?php if ($patientHasMessaged): ?>
                            <form id="chatForm" method="POST" action="">
                                <div class="input-group">
                                    <input type="hidden" name="request_id" id="request_id" value="<?= $reqId ?>">
                                    <input type="text" id="msgInput" class="form-control" placeholder="Type message...">
                                    <button class="btn btn-success" type="submit" name="sendMessage">Send</button>
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
        <!-- End Row -->

        <!-- Google Meet Link Modal -->
        <div class="modal fade" id="meetLinkModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-camera-video"></i> Send Google Meet Link</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($smsg)): ?>
                            <div class="alert alert-success"><?= $smsg ?></div>
                        <?php endif; ?>
                        <?php if (!empty($emsg)): ?>
                            <div class="alert alert-danger"><?= $emsg ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <input type="hidden" name="patient_id" value="<?= $reqId ?>">
                            <div class="mb-3">
                                <label class="form-label">Assign Doctor</label>
                                <select name="doctor_id" id="doctorSelect" class="form-select" required>
                                    <option value="">-- Select Doctor --</option>
                                    <?php
                                    $docs = dbSelect('users', 'id, fName, lName, email', "role='doctor' AND status='active'", 'fName ASC');
                                    if ($docs && mysqli_num_rows($docs) > 0):
                                        while ($d = mysqli_fetch_array($docs)):
                                    ?>
                                            <option value="<?= $d['id'] ?>" data-email="<?= htmlspecialchars($d['email']) ?>">
                                                <?= htmlspecialchars('Dr. ' . $d['fName'] . ' ' . $d['lName']) ?>
                                            </option>
                                    <?php endwhile;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Doctor Email</label>
                                <input type="email" name="doctor_email" id="doctorEmail" class="form-control" placeholder="Auto-filled on doctor select" required>
                                <small class="text-muted">Email notification will be sent to this address.</small>
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
                            <p class="text-muted" style="font-size:0.8rem;"><i class="bi bi-info-circle"></i> A unique WebRTC meeting link will be auto-generated and sent to the doctor by email. Only the patient will see the link in their dashboard.</p>
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
                if ($users && mysqli_num_rows($users) > 0):
                    while ($u = mysqli_fetch_array($users)):
                ?>
                        <a href="?id=<?= $u['id'] ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">
                                    <?= strtoupper(substr($u['fName'], 0, 1) . substr($u['lName'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:0.9rem;"><?= htmlspecialchars($u['fName'] . ' ' . $u['lName']) ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($u['role']) ?></small>
                                </div>
                            </div>
                        </a>
                    <?php endwhile;
                else: ?>
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
        const requestId = <?= $reqId ?>;
        const msgArea = $('#msgArea');

        function scrollToBottom() {
            msgArea.scrollTop(msgArea[0].scrollHeight);
        }

        function loadMessages() {
            if (requestId <= 0) return;
            $.ajax({
                url: 'view/fetch_messages.php?id=' + requestId,
                method: 'GET',
                success: function(response) {
                    if (msgArea.html().trim() !== response.trim()) {
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
            let req = $('#request_id').val();
            if (msg === '') return;
            $.ajax({
                url: 'view/send_message.php?id=' + req,
                method: 'POST',
                data: { message: msg },
                success: function() {
                    $('#msgInput').val('');
                    loadMessages();
                }
            });
        });

        // Auto-fill doctor email when doctor is selected
        $('#doctorSelect').on('change', function() {
            const email = $(this).find(':selected').data('email') || '';
            $('#doctorEmail').val(email);
        });
    });
</script>