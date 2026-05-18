<?php 
include '../inc/config.php';
include '../inc/auth.php';

#page constants
const TITLE = 'Template';
const HEADER = 'Template';
const BREADCRUMB = 'temp';
const KEYWORDS = '';
const PAGE_DESC = 'the template page';

$pgURL = $adminRoot."roles";

#logics for this page
include '../inc/logics/roles.php';

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
                    <a href="" class="btn btn-sm btn-outline-info rounded-circle"><i class="bi bi-plus"></i></a>
                    <a href="" class="btn btn-sm btn-outline-info rounded-circle float-end"><i class="bi bi-bootstrap-reboot"></i></a>
                </div>
            </div>
        </div>

        <?php include "../inc/alerts.php"; ?>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="">
                            <h4 class="card-title d-inline-block"><?= (isset($cardTitle)) ? $cardTitle : 'Add New'; ?></h4>
                            <a href="<?= $adminRoot ?>temp" class="float-end text-danger fw-bolder"><i class="bi bi-x fw-bold"></i></a>
                        </div>

                    </div>
                    <div class="card-body">
                        <form class="row g-3 mt-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                    <label for="floatingName">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingEmail" placeholder="Your Email">
                                    <label for="floatingEmail">Your Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
                                    <label for="floatingTextarea">Address</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingCity" placeholder="City">
                                        <label for="floatingCity">City</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" aria-label="State">
                                        <option selected="">New York</option>
                                        <option value="1">Oregon</option>
                                        <option value="2">DC</option>
                                    </select>
                                    <label for="floatingSelect">State</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingZip" placeholder="Zip">
                                    <label for="floatingZip">Zip</label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage All</h4>
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th><i class="bi bi-toggles2 text-primary"></i></th>
                                    <th>Name</th>
                                    <th>DC</th>
                                    <th>DU</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $no = 1;
                                        $q = dbSelect('roles',"*");
                                        while($row = mysqli_fetch_array($q)){
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
                                                    <?php if($row['status'] == 'active'): ?>
                                                    <a class="dropdown-item" href="<?= $adminRoot ?>roles?id=<?= $row['id'] ?>&min=true&do=edit">Edit</a>
                                                    <a class="dropdown-item" href="<?= $adminRoot ?>roles?id=<?= $row['id'] ?>&do=deactivate">Deactivate</a>
                                                    <?php else: ?>
                                                    <a class="dropdown-item" href="<?= $adminRoot ?>roles?id=<?= $row['id'] ?>&do=activate">Activate</a>
                                                    <a class="dropdown-item" href="<?= $adminRoot ?>roles?id=<?= $row['id'] ?>&do=delete">Delete</a>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['dc'] ?></td>
                                    <td><?= $row['du'] ?></td>
                                    <td class="text-center">
                                        <i class="bi bi-circle-fill text-<?= formatStatus($row['status']) ?>"></i>
                                    </td>
                                </tr>
                                <?php $no++; } ?>
                            </tbody>
                        </table>
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
