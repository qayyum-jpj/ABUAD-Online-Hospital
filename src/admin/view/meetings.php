<?php 
require_once '../inc/config.php';
require_once '../inc/auth.php';
require_once '../inc/funcs.php';

const TITLE = 'Booked Meetings';
include '../inc/head.php';
include '../inc/header.php';
include '../inc/sidebar.php';
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Remote Consultations</h1>
        <nav><ol class="breadcrumb"><li class="breadcrumb-item">Clinical Ops</li><li class="breadcrumb-item active">Meetings</li></ol></nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Active Schedule <span>| Remote Sessions</span></h5>
                        
                        <table class="table table-hover datatable align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Patient</th>
                                    <th>Assigned Doctor</th>
                                    <th>Time / Date</th>
                                    <th>Triage</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $q = dbSelect('appointments',"*");
                                while($row = mysqli_fetch_array($q)){
                                    $triageColor = match($row['triage_level']) {
                                        'Emergency' => 'danger',
                                        'High' => 'warning',
                                        'Medium' => 'info',
                                        default => 'secondary'
                                    };
                                ?>
                                <tr>
                                    <td><?= getColumnVal('users', $row['patient_id'], 'fName') ?></strong></td>
                                    <td><?= getColumnVal('users', $row['doctor_id'], 'fName') ?></td>
                                    <td><?= date('d M, Y', strtotime(getColumnVal()) ?><br>
                                    <small class="text-muted"><?= $row['start_time'] ?></small></td>
                                    <td><span class="badge rounded-pill bg-<?= $triageColor ?> border"><?= $row['triage_level'] ?></span></td>
                                    <td>
                                        <?php if($row['status'] == 'Accepted'): ?>
                                            <a href="<?= $row['meeting_link'] ?>" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="bi bi-camera-video"></i> Join
                                            </a>
                                        <?php endif; ?>
                                        <button class="btn btn-sm btn-outline-secondary" title="View History">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../inc/footer.php'; include '../inc/foot.php'; ?>