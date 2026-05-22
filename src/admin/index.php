<?php
include 'inc/config.php';
include 'inc/auth.php';

#page constants
const TITLE = 'Admin Home';
const HEADER = 'Dashboard Home';
const BREADCRUMB = 'home';
const KEYWORDS = '';
const PAGE_DESC = 'admin home page';

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

            <div class="col-lg-8">
                <div class="row">

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card admin-card border-start border-primary border-4">
                            <div class="card-body">
                                <h5 class="card-title">Administrators <span>| System</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-light">
                                        <i class="bi bi-shield-lock text-primary"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="mb-0"><?= $administratorCnt ?></h6>
                                        <small class="text-success fw-bold"><?= $activeAdministratorCnt ?></small> <small class="text-muted">Active</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card medical-card border-start border-info border-4">
                            <div class="card-body">
                                <h5 class="card-title">Hospital Staff <span>| Users</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info-light">
                                        <i class="bi bi-person-badge text-info"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="mb-0"><?= $userCnt ?></h6>
                                        <span class="text-muted small">Doc: <b><?= $activeUserDocCnt ?></b></span> |
                                        <span class="text-muted small">Pat: <b><?= $activeUserPatCnt ?></b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-12">
                        <div class="card info-card gender-card border-start border-success border-4">
                            <div class="card-body">
                                <h5 class="card-title">Demographics <span>| Genders</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-light">
                                        <i class="bi bi-gender-ambiguous text-success"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="mb-0"><?= $genderCnt ?></h6>
                                        <small class="text-muted">Balanced Registry</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="card recent-sales overflow-auto shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="card-title mb-0">Recent Entries <span>| Today</span></h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-bordered mb-3" id="entryTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?= (!isset($_GET['vw']) || $_GET['vw'] == 'entry1') ? 'active' : '' ?>" href="<?= $adminRoot ?>home?vw=entry1">Meetings Today</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= (isset($_GET['vw']) && $_GET['vw'] == 'entry2') ? 'active' : '' ?>" href="<?= $adminRoot ?>home?vw=entry2">Specialized Records</a>
                                    </li>
                                </ul>

                                <div class="tab-content pt-2">
                                    <?php if (!isset($_GET['vw']) || $_GET['vw'] == 'entry1'): ?>
                                        <table class="table table-hover datatable mt-2">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Patient | Doctor</th>
                                                    <th scope="col">Time</th>
                                                    <th scope="col">Created by</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $no = 1;
                                                $q = dbSelectDate('meet_links', "*", "meet_date");
                                                while ($row = mysqli_fetch_array($q)) {

                                                ?>
                                                    <tr>
                                                        <td><a href="#" class="fw-bold"><?= $no; ?></a></td>
                                                        <td><?= getColumnVal('users', $row['patient_id'], 'fName')." ".getColumnVal('users', $row['patient_id'], 'lName') ?> | Dr. <?= getColumnVal('users', $row['doctor_id'], 'fName')." ".getColumnVal('users', $row['doctor_id'], 'lName') ?></td>
                                                        <td><?= $row['meet_time'] ?></td>
                                                        <td><?= getColumnVal('administrators', $row['admin_id'], 'fName')." ".getColumnVal('administrators', $row['admin_id'], 'lName') ?></td>
                                                        <td><span class="badge bg-success"><?= $row['status'] ?></span></td>
                                                    </tr>
                                                <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>

                                    <?php if (isset($_GET['vw']) && $_GET['vw'] == 'entry2'): ?>
                                        <table class="table table-hover datatable mt-2">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Patient | Doctor</th>
                                                    <th scope="col">Symptoms</th>
                                                    <th scope="col">Time</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $no = 1;
                                                $q = dbSelect('meet_links', "*");
                                                while ($row = mysqli_fetch_array($q)) {

                                                ?>
                                                    <tr>
                                                        <td><a href="#" class="fw-bold"><?= $no; ?></a></td>
                                                        <td><?= getColumnVal('users', $row['patient_id'], 'fName')." ".getColumnVal('users', $row['patient_id'], 'lName') ?> | <?= getColumnVal('users', $row['doctor_id'], 'fName')." ".getColumnVal('users', $row['doctor_id'], 'lName') ?></td>
                                                        <td></td>
                                                        <td><span class="badge bg-success"><?= $row['status'] ?></span></td>
                                                    </tr>
                                                <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">System Logs <span>| Today</span></h5>
                    </div>
                    <div class="card-body px-4">
                        <div class="activity">
                            <?php
                            $q = dbSelect('act_logs', "*", "user=$uId AND userType='admin'", "dc");
                            if (mysqli_num_rows($q) > 0) {
                                while ($row = mysqli_fetch_array($q)) {
                                    $dcInSecs = strtotime($row['dc']);
                            ?>
                                    <div class="activity-item d-flex mb-3">
                                        <div class="activite-label text-muted small" style="min-width: 65px;"><?= fancyTime($dcInSecs) ?></div>
                                        <i class='bi bi-circle-fill activity-badge text-<?= $row['color'] ?> align-self-start mx-2' style="font-size: 0.7rem;"></i>
                                        <div class="activity-content border-start ps-3 pb-3">
                                            <span class="text-dark"><?= $row['log'] ?></span>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-clipboard-x text-muted display-4"></i>
                                    <p class="text-muted mt-2">No activity recorded today.</p>
                                </div>
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