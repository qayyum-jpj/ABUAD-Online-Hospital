<?php
include 'inc/config.php';
include 'inc/auth.php';

#page constants
const TITLE = 'Student Home';
const HEADER = 'Dashboard Home';
const BREADCRUMB = 'home';
const KEYWORDS = '';
const PAGE_DESC = 'Student  page';

include 'inc/logics/index.php';
include 'inc/head.php';
?>

<!-- ======= Header ======= -->
<?php include 'inc/header.php'; ?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php include 'inc/sidebar.php'; ?>
<!-- End Sidebar-->

<main id="main" class="main">

    <?php include 'inc/page-header.php'; ?>

    <section class="section dashboard">
        <div class="row">

            <?php
            $mlResult = dbSelect('meet_links', 'meet_url, meet_date, meet_time', "patient_id=$uId");
            if ($mlResult && mysqli_num_rows($mlResult) > 0):
                $ml = mysqli_fetch_array($mlResult);
            ?>
                <div class="col-12 mb-4">
                    <div class="card info-card bg-primary text-white shadow-lg border-0">
                        <div class="card-body py-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="fw-bold mb-1"><i class="bi bi-camera-video"></i> Virtual Consultation Ready</h4>
                                    <p class="mb-0 opacity-75">Your doctor is waiting for you. Please join the session at the scheduled time.</p>
                                    <div class="mt-3">
                                        <span class="badge bg-white text-primary px-3 py-2 me-2">
                                            <i class="bi bi-calendar-event"></i> <?= date('M j, Y', strtotime($ml['meet_date'])) ?>
                                        </span>
                                        <span class="badge bg-white text-primary px-3 py-2">
                                            <i class="bi bi-clock"></i> <?= date('h:i A', strtotime($ml['meet_time'])) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a href="<?= htmlspecialchars($ml['meet_url']) ?>" target="_blank" class="btn btn-light btn-lg px-4 fw-bold shadow-sm">
                                        Join Meeting Now <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card info-card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-muted">Appointments</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded bg-info-light text-info p-3">
                                        <i class="bi bi-calendar-check fs-3"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h4 class="fw-bold mb-0">12</h4>
                                        <span class="text-muted small">Total</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card info-card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-muted">Health Records</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded bg-success-light text-success p-3">
                                        <i class="bi bi-file-earmark-medical fs-3"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h4 class="fw-bold mb-0">05</h4>
                                        <span class="text-muted small">Reports</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card info-card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-muted">Prescriptions</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded bg-warning-light text-warning p-3">
                                        <i class="bi bi-capsule fs-3"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h4 class="fw-bold mb-0">02</h4>
                                        <span class="text-muted small">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">My Recent Health Activities</h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3 mt-2" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="pill">Lab Results</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="pill">Doctor Notes</button>
                                    </li>
                                </ul>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Item</th>
                                                <th>Physician</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>May 10, 2026</td>
                                                <td class="fw-bold">General Checkup</td>
                                                <td>Dr. Smith</td>
                                                <td><span class="badge rounded-pill bg-success">Released</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-2">Activity Timeline</h5>
                        <div class="activity mt-3">
                            <?php
                            $q = dbSelect('act_logs', "*", "user=$uId AND userType='patient'", "dc");
                            if (mysqli_num_rows($q) > 0) {
                                while ($row = mysqli_fetch_array($q)) {
                            ?>
                                    <div class="activity-item d-flex mb-3">
                                        <div class="text-muted small" style="min-width: 60px;"><?= fancyTime(strtotime($row['dc'])) ?></div>
                                        <i class='bi bi-circle-fill activity-badge text-primary align-self-start mx-2'></i>
                                        <div class="activity-content small">
                                            <?= $row['log'] ?>
                                        </div>
                                    </div>
                            <?php } } else { ?>
                                <p class="text-muted text-center py-4">No recent activity.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<!-- End #main -->

<!-- ======= Footer ======= -->
<?php include 'inc/footer.php'; ?>
<!-- End Footer -->


<?php include 'inc/foot.php'; ?>