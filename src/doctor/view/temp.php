<?php
include '../inc/config.php';
include '../inc/auth.php';

#page constants
const TITLE = 'Patient Home';
const HEADER = 'My Health Dashboard';
const BREADCRUMB = 'home';
const KEYWORDS = 'patient, dashboard, health, portal';
const PAGE_DESC = 'Patient health portal and dashboard';

include '../inc/logics/index.php';
include '../inc/head.php';
?>

<?php include '../inc/header.php'; ?>
<?php include '../inc/sidebar.php'; ?>
<main id="main" class="main">

    <?php include '../inc/page-header.php'; ?>
    <section class="section dashboard">
        <div class="row">

            <div class="col-lg-8">
                
                <div class="row">
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Appointments <span>| Upcoming</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-calendar-event"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $upcomingAppointmentsCnt ?? 2 ?></h6>
                                        <p class="mb-0"><span class="text-muted small pt-2 ps-1">Scheduled visits</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Prescriptions <span>| Active</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-capsule"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $activePrescriptionsCnt ?? 3 ?></h6>
                                        <p class="mb-0"><span class="text-warning small pt-1 fw-bold">1</span> <span class="text-muted small pt-2 ps-1">needs refill</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Lab Results <span>| Recent</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info">
                                        <i class="bi bi-clipboard2-pulse"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $newLabResultsCnt ?? 1 ?></h6>
                                        <p class="mb-0"><span class="text-success small pt-1 fw-bold">New report</span> <span class="text-muted small pt-2 ps-1">available</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto border-0 shadow-sm">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">My Appointments</h5>
                                    <a href="#" class="btn btn-sm btn-link text-decoration-none">View All</a>
                                </div>

                                <table class="table table-hover align-middle datatable">
                                    <thead class="table-light text-muted small">
                                        <tr>
                                            <th scope="col">Date & Time</th>
                                            <th scope="col">Doctor</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold">
                                                May 12, 2026<br>
                                                <span class="text-muted small">10:30 AM</span>
                                            </td>
                                            <td><a href="#" class="text-dark fw-bold text-decoration-none">Dr. Praise Michael</a></td>
                                            <td>Cardiology</td>
                                            <td><span class="badge bg-info text-dark rounded-pill">Scheduled</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Cancel</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">
                                                May 18, 2026<br>
                                                <span class="text-muted small">02:00 PM</span>
                                            </td>
                                            <td><a href="#" class="text-dark fw-bold text-decoration-none">Dr. Sarah Williams</a></td>
                                            <td>General Practice</td>
                                            <td><span class="badge bg-primary rounded-pill">Telehealth</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-camera-video"></i> Join</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-muted">
                                                April 28, 2026<br>
                                                <span class="text-muted small">09:15 AM</span>
                                            </td>
                                            <td><span class="text-muted">Dr. John Doe</span></td>
                                            <td><span class="text-muted">Dermatology</span></td>
                                            <td><span class="badge bg-success rounded-pill opacity-75">Completed</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-secondary">View Notes</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div></div>
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Quick Links</h5>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary text-start px-3 py-2 fw-semibold" type="button">
                                <i class="bi bi-calendar-plus me-2"></i> Book Appointment
                            </button>
                            <button class="btn btn-outline-primary text-start px-3 py-2 fw-semibold" type="button">
                                <i class="bi bi-capsule me-2"></i> Request Refill
                            </button>
                            <button class="btn btn-outline-primary text-start px-3 py-2 fw-semibold" type="button">
                                <i class="bi bi-chat-dots me-2"></i> Message Doctor
                            </button>
                        </div>
                    </div>
                </div><div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Health Timeline <span>| Recent</span></h5>

                        <div class="activity activity-box">
                            <?php
                            // Fetch activity logs specifically for this patient
                            $q = dbSelect('act_logs', "*", "user=$uId AND userType='patient'", "dc DESC LIMIT 5");
                            if (mysqli_num_rows($q) > 0) {
                                while ($row = mysqli_fetch_array($q)) {
                                    $dcInSecs = strtotime($row['dc']);
                            ?>
                                    <div class="activity-item d-flex">
                                        <div class="activite-label text-muted" style="min-width: 65px; font-size: 0.8rem;"><?= fancyTime($dcInSecs) ?></div>
                                        <i class='bi bi-circle-fill activity-badge text-<?= $row['color'] ?> align-self-start z-1'></i>
                                        <div class="activity-content text-dark fs-6 ms-2">
                                            <?= $row['log'] ?>
                                        </div>
                                    </div>
                                    <?php }
                            } else { ?>
                                <div class="activity-item d-flex mb-3">
                                    <div class="activite-label text-muted" style="min-width: 65px; font-size: 0.8rem;">Today</div>
                                    <i class='bi bi-circle-fill activity-badge text-info align-self-start z-1'></i>
                                    <div class="activity-content text-dark fs-6 ms-2">
                                        Your Blood Test results are ready to view.
                                    </div>
                                </div>
                                <div class="activity-item d-flex mb-3">
                                    <div class="activite-label text-muted" style="min-width: 65px; font-size: 0.8rem;">2 days ago</div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start z-1'></i>
                                    <div class="activity-content text-dark fs-6 ms-2">
                                        Prescription <strong>Lisinopril</strong> was renewed.
                                    </div>
                                </div>
                                <div class="activity-item d-flex mb-3">
                                    <div class="activite-label text-muted" style="min-width: 65px; font-size: 0.8rem;">1 week ago</div>
                                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start z-1'></i>
                                    <div class="activity-content text-dark fs-6 ms-2">
                                        Completed visit with Dr. Praise Michael.
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div></div>
            </div>
    </section>

</main>
<?php include '../inc/footer.php'; ?>
<?php include '../inc/foot.php'; ?>