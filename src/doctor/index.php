<?php
include 'inc/config.php';
include 'inc/auth.php';

#page constants
const TITLE = 'Doctor Home';
const HEADER = 'Doctor Dashboard';
const BREADCRUMB = 'home';
const KEYWORDS = 'doctor, dashboard, medical, schedule';
const PAGE_DESC = 'Doctor dashboard and daily schedule';

include 'inc/logics/index.php';
include 'inc/head.php';
?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<main id="main" class="main">

    <?php include 'inc/page-header.php'; ?>
    <section class="section dashboard">
        <div class="row">

            <div class="col-lg-8">
                
                <div class="row">
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Appointments <span>| Today</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $todayAppointmentsCnt ?? 8 ?></h6>
                                        <p class="mb-0"><span class="text-success small pt-1 fw-bold"><?= $completedAppointmentsCnt ?? 3 ?></span> <span class="text-muted small pt-2 ps-1">completed</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Waiting Room <span>| Now</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $waitingPatientsCnt ?? 2 ?></h6>
                                        <p class="mb-0"><span class="text-muted small pt-2 ps-1">Patients checked in</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Lab Results <span>| Pending Review</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger">
                                        <i class="bi bi-file-medical"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $pendingLabsCnt ?? 5 ?></h6>
                                        <p class="mb-0"><span class="text-danger small pt-1 fw-bold">Action required</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Today's Schedule <span>| <?= date('l, M j') ?></span></h5>

                                <table class="table table-hover align-middle datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Time</th>
                                            <th scope="col">Patient Name</th>
                                            <th scope="col">Reason for Visit</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold">09:00 AM</td>
                                            <td><a href="#" class="text-primary fw-bold text-decoration-none">John Doe</a></td>
                                            <td>Routine Checkup</td>
                                            <td><span class="badge bg-success rounded-pill">Completed</span></td>
                                            <td><button class="btn btn-sm btn-outline-secondary" disabled>View Chart</button></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">10:30 AM</td>
                                            <td><a href="#" class="text-primary fw-bold text-decoration-none">Jane Smith</a></td>
                                            <td>Blood Pressure Follow-up</td>
                                            <td><span class="badge bg-warning text-dark rounded-pill">Waiting</span></td>
                                            <td><button class="btn btn-sm btn-primary">Open Chart</button></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">11:15 AM</td>
                                            <td><a href="#" class="text-primary fw-bold text-decoration-none">Michael Johnson</a></td>
                                            <td>Telehealth Consult</td>
                                            <td><span class="badge bg-info text-dark rounded-pill">Scheduled</span></td>
                                            <td><button class="btn btn-sm btn-outline-primary"><i class="bi bi-camera-video"></i> Join</button></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">01:00 PM</td>
                                            <td><a href="#" class="text-primary fw-bold text-decoration-none">Sarah Williams</a></td>
                                            <td>Lab Results Review</td>
                                            <td><span class="badge bg-secondary rounded-pill">Scheduled</span></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Open Chart</button></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div></div>
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quick Actions</h5>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary text-start px-3 py-2" type="button">
                                <i class="bi bi-file-earmark-medical me-2"></i> New Prescription
                            </button>
                            <button class="btn btn-outline-primary text-start px-3 py-2" type="button">
                                <i class="bi bi-calendar-plus me-2"></i> Schedule Follow-up
                            </button>
                            <button class="btn btn-outline-primary text-start px-3 py-2" type="button">
                                <i class="bi bi-journal-text me-2"></i> Add Clinical Note
                            </button>
                        </div>
                    </div>
                </div><div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Clinical Activity <span>| Today</span></h5>

                        <div class="activity activity-box">
                            <?php
                            // Updated userType to 'doctor'
                            $q = dbSelect('act_logs', "*", "user=$uId AND userType='doctor'", "dc");
                            if (mysqli_num_rows($q) > 0) {
                                while ($row = mysqli_fetch_array($q)) {
                                    $dcInSecs = strtotime($row['dc']);
                            ?>
                                    <div class="activity-item d-flex">
                                        <div class="activite-label"><?= fancyTime($dcInSecs) ?></div>
                                        <i class='bi bi-circle-fill activity-badge text-<?= $row['color'] ?> align-self-start'></i>
                                        <div class="activity-content">
                                            <?= $row['log'] ?>
                                        </div>
                                    </div>
                                    <?php }
                            } else { ?>
                                <p class="text-muted small italic">No recent activity found.</p>
                            <?php } ?>
                        </div>

                    </div>
                </div></div>
            </div>
    </section>

</main>
<?php include 'inc/footer.php'; ?>
<?php include 'inc/foot.php'; ?>