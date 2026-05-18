<?php 
include '../inc/config.php';
include '../inc/auth.php';

#page constants
const TITLE = 'Countries';
const HEADER = 'Manage Countries';
const BREADCRUMB = 'countries';
const KEYWORDS = '';
const PAGE_DESC = 'the countries management page';

$pgURL = $adminRoot."countries";

#logics for this page
include '../inc/logics/countries.php';

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
                    <a href="<?= $adminRoot ?>countries?min=true&do=create" class="btn btn-sm btn-outline-info rounded-circle"><i class="bi bi-plus"></i></a>
                    <a href="<?= $adminRoot ?>countries" class="btn btn-sm btn-outline-info rounded-circle float-end"><i class="bi bi-bootstrap-reboot"></i></a>
                </div>
            </div>
        </div>

        <?php include "../inc/alerts.php"; ?>
        <div class="row mt-3">
            <?php if(isset($_GET['min']) && $_GET['min'] == 'true'): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="">
                            <h4 class="card-title d-inline-block"><?= (isset($cardTitle)) ? $cardTitle : 'Add New'; ?></h4>
                            <a href="<?= $adminRoot ?>countries" class="float-end text-danger fw-bolder"><i class="bi bi-x fw-bold"></i></a>
                        </div>

                    </div>
                    <div class="card-body">
                        <form class="form form-vertical" action="" method="post">
                            <div class="form-body">
                                <?php if(isset($_GET['do']) && $_GET['do'] == 'create'): ?>
                                <div id="create" class="row mt-3">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="countryName" name="countryName" placeholder="Country Name" value="<?php if(isset($_POST['countryName'])){ echo $_POST['countryName']; } ?>">
                                            <label for="countryName">Country Name</label>
                                        </div>
                                        <?php if(isset($countryNameError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $countryNameError ?></span><?php endif ?>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success me-1 mb-1" name="saveCountry">Save</button>
                                    </div>
                                </div>
                                <?php endif ?>

                                <?php if(isset($_GET['do']) && $_GET['do'] == 'edit'): ?>
                                <div id="edit" class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="countryName">Country Name</label>
                                            <input type="text" id="countryName" class="form-control" name="countryName" value="<?php if(isset($_POST['countryName'])){ echo $_POST['countryName']; }else{ echo $dbCountryName; } ?>">
                                            <?php if(isset($countryNameError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $countryNameError ?></span><?php endif ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1 mb-1" name="editCountry">Update</button>
                                    </div>
                                </div>
                                <?php endif ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif ?>
            <div class="col-md-<?php if(isset($_GET['min']) && $_GET['min'] == 'true'){ echo 8; }else{ 12; } ?>">
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
                                        $q = dbSelect('countries',"*");
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
                                                    <a class="dropdown-item" href="<?= $adminRoot ?>countries?id=<?= $row['id'] ?>&min=true&do=edit">Edit</a>
                                                    <a class="dropdown-item" href="<?= $adminRoot ?>countries?id=<?= $row['id'] ?>&do=deactivate">Deactivate</a>
                                                    <?php else: ?>
                                                    <a class="dropdown-item" href="<?= $adminRoot ?>countries?id=<?= $row['id'] ?>&do=activate">Activate</a>
                                                    <a class="dropdown-item" href="<?= $adminRoot ?>countries?id=<?= $row['id'] ?>&do=delete">Delete</a>
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
                    <div class="card-footer bg-transparent">
                        <a href="<?= $adminRoot ?>countries?do=truncate" class="btn btn-sm btn-outline-warning">Truncate Countries</a>
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
