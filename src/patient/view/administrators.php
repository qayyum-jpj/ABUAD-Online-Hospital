<?php
include '../inc/config.php';
include '../inc/auth.php';

#page constants
const TITLE = 'Administrators';
const HEADER = 'Manage Administrators';
const BREADCRUMB = 'administrators';
const KEYWORDS = '';
const PAGE_DESC = 'the admin management page';

$pgURL = $patientRoot . "administrators";

#logics for this page
include '../inc/logics/administrators.php';

include '../inc/head.php';
?>


<!-- ======= Header ======= -->
<?php include '../inc/header.php'; ?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php include '../inc/sidebar.php'; ?>
<!-- End Sidebar-->

<main id="main" class="main">

    <?php include '../inc/page-header.php'; ?>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="bg-white rounded py-3 px-2">
                    <a href="<?= $patientRoot ?>administrators?min=true&do=create" class="btn btn-sm btn-outline-info rounded-circle"><i class="bi bi-plus"></i></a>
                    <a href="<?= $patientRoot ?>administrators" class="btn btn-sm btn-outline-info rounded-circle float-end"><i class="bi bi-bootstrap-reboot"></i></a>
                </div>
            </div>
        </div>

        <?php include "../inc/alerts.php"; ?>
        <div class="row mt-3">
            <?php if (isset($_GET['min']) && $_GET['min'] == 'true'): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="">
                                <h4 class="card-title d-inline-block"><?= (isset($cardTitle)) ? $cardTitle : 'Add New'; ?></h4>
                                <a href="<?= $patientRoot ?>administrators" class="float-end text-danger fw-bolder"><i class="bi bi-x fw-bold"></i></a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="form-body">
                                <?php if (isset($_GET['do']) && $_GET['do'] == 'create'): ?>
                                    <form class="form form-vertical" action="" method="post">
                                        <div id="create" class="row mt-3">
                                            <div class="col-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Username" value="<?php if (isset($_POST['userName'])) {
                                                                                                                                                            echo $_POST['userName'];
                                                                                                                                                        } ?>">
                                                    <label for="userName">Username</label>
                                                </div>
                                                <?php if (isset($userNameError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $userNameError ?></span><?php endif ?>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php if (isset($_POST['email'])) {
                                                                                                                                                            echo $_POST['email'];
                                                                                                                                                        } ?>">
                                                    <label for="email">Email Address</label>
                                                </div>
                                                <?php if (isset($emailError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $emailError ?></span><?php endif ?>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="userRole" aria-label="Role" name="role">
                                                        <?php
                                                        $q = dbSelect('roles', "*", "status='active'");
                                                        while ($row = mysqli_fetch_array($q)) {
                                                        ?>
                                                            <option <?php if (isset($_POST['role']) && $_POST['role'] == $row['id']) {
                                                                        echo 'selected';
                                                                    } ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label for="userRole">Role</label>
                                                </div>
                                                <?php if (isset($roleError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $roleError ?></span><?php endif ?>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-success me-1 mb-1" name="saveAdministrator">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif ?>

                                <?php if (isset($_GET['do']) && $_GET['do'] == 'edit'): ?>
                                    <form class="form form-vertical mt-3 mb-3 pb-3 border-bottom" action="" method="post">
                                        <h6>Edit Username</h6>
                                        <div id="edit-username" class="row mt-3">
                                            <div class="col-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Username" value="<?php if (isset($_POST['userName'])) {
                                                                                                                                                            echo $_POST['userName'];
                                                                                                                                                        } else {
                                                                                                                                                            echo $dbUsername;
                                                                                                                                                        } ?>">
                                                    <label for="userName">Username</label>
                                                </div>
                                                <?php if (isset($userNameError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $userNameError ?></span><?php endif ?>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary me-1 mb-1" name="updateUsername"><i class="bi bi-check"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form form-vertical mb-3 pb-3 border-bottom" action="" method="post">
                                        <h6>Edit Email</h6>
                                        <div id="edit-email" class="row mt-3">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php if (isset($_POST['email'])) {
                                                                                                                                                            echo $_POST['email'];
                                                                                                                                                        } else {
                                                                                                                                                            echo $dbEmail;
                                                                                                                                                        } ?>">
                                                    <label for="email">Email Address</label>
                                                </div>
                                                <?php if (isset($emailError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $emailError ?></span><?php endif ?>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary me-1 mb-1" name="updateEmail"><i class="bi bi-check"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form form-vertical mb-3 pb-3 border-bottom" action="" method="post">
                                        <h6>Edit Role</h6>
                                        <div id="edit-role" class="row mt-3">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="userRole" aria-label="Role" name="role">
                                                        <?php
                                                        $q = dbSelect('roles', "*", "status='active'");
                                                        while ($row = mysqli_fetch_array($q)) {
                                                        ?>
                                                            <option <?php if ((isset($_POST['role']) && $_POST['role'] == $row['id']) || $row['id'] == $dbRole) {
                                                                        echo 'selected';
                                                                    } ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label for="userRole">Role</label>
                                                </div>
                                                <?php if (isset($roleError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $roleError ?></span><?php endif ?>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary me-1 mb-1" name="updateRole"><i class="bi bi-check"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <div class="col-md-<?php if (isset($_GET['min']) && $_GET['min'] == 'true') {
                                    echo 8;
                                } else {
                                    12;
                                } ?>">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage All</h4>
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th><i class="bi bi-toggles2 text-primary"></i></th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>DC</th>
                                    <th>DU</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $q = dbSelect('administrators', "*");
                                while ($row = mysqli_fetch_array($q)) {
                                ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-primary btn-sm me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <?php if ($row['status'] == 'active'): ?>
                                                            <a class="dropdown-item" href="<?= $patientRoot ?>administrators?id=<?= $row['id'] ?>&min=true&do=edit">Edit</a>
                                                            <a class="dropdown-item" href="<?= $patientRoot ?>administrators?id=<?= $row['id'] ?>&do=reset-pwd">Reset Password</a>
                                                            <a class="dropdown-item" href="<?= $patientRoot ?>administrators?id=<?= $row['id'] ?>&do=deactivate">Deactivate</a>
                                                        <?php else: ?>
                                                            <a class="dropdown-item" href="<?= $patientRoot ?>administrators?id=<?= $row['id'] ?>&do=activate">Activate</a>
                                                            <a class="dropdown-item" href="<?= $patientRoot ?>administrators?id=<?= $row['id'] ?>&do=delete">Delete</a>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $row['username'] ?></td>
                                        <td><a href="mailto:<?= $row['email'] ?>"><?= $row['email'] ?></a></td>
                                        <td><?= getColumnVal('roles', $row['role']) ?></td>
                                        <td><?= $row['dc'] ?></td>
                                        <td><?= $row['du'] ?></td>
                                        <td class="text-center">
                                            <i class="bi bi-circle-fill text-<?= formatStatus($row['status']) ?>"></i>
                                        </td>
                                    </tr>
                                <?php $no++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="<?= $patientRoot ?>administrators?do=truncate" class="btn btn-sm btn-outline-warning">Truncate Administrators</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<!-- End #main -->

<!-- ======= Footer ======= -->
<?php include '../inc/footer.php'; ?>
<!-- End Footer -->


<?php include '../inc/foot.php'; ?>