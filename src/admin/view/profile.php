<?php 
include '../inc/config.php';
include '../inc/auth.php';

#page constants
const TITLE = 'Profile';
const HEADER = 'Profile';
const BREADCRUMB = 'profile';
const KEYWORDS = '';
const PAGE_DESC = 'the profile page';

$pgURL = $adminRoot."profile";

#logics for this page
include '../inc/logics/profile.php';

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

    <section class="section profile">

        <div class="card">
            <div class="card-body pt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-card pt-4 d-flex flex-column align-items-center">

                            <img src="<?= $uploadsRoot ?>images/administrators/<?= $cuImage ?>" alt="Profile" class="rounded-circle">
                            <h2><?= strtoupper($cuUserName) ?></h2>
                            <h3><?= ucfirst($cuRole) ?></h3>
                            <div class="social-links mt-2">
                                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['vw']) && $_GET['vw'] == 'overview'){ echo 'active'; } ?>" href="<?= $adminRoot ?>profile?vw=overview">Overview</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['vw']) && $_GET['vw'] == 'e-info'){ echo 'active'; } ?>" href="<?= $adminRoot ?>profile?vw=e-info">Edit Info</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['vw']) && $_GET['vw'] == 'e-image'){ echo 'active'; } ?>" href="<?= $adminRoot ?>profile?vw=e-image">Edit Image</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['vw']) && $_GET['vw'] == 'c-pwd'){ echo 'active'; } ?>" href="<?= $adminRoot ?>profile?vw=c-pwd">Change Password</a>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">
                            <div class="d-flex mb-2 justify-content-end">
                                <p class="text-info">Recent Update: <?= "($cuDU) 33 mins ago" ?></p>
                            </div>
                            <?php include "../inc/alerts.php"; ?>

                            <?php if(isset($_GET['vw']) && $_GET['vw'] == 'overview'): ?>
                            <div class="tab-pane fade show active pt-3">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic"><?= $cuBio ?></p>

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8"><?= $cuFName." ".$cuLName ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Company</div>
                                    <div class="col-lg-9 col-md-8"><?= $cuCompany ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Job</div>
                                    <div class="col-lg-9 col-md-8"><?= $cuJob ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Gender</div>
                                    <div class="col-lg-9 col-md-8"><?= getColumnVal('genders',$cuGender) ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8"><?= getColumnVal('countries',$cuCountry) ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8"><?= $cuAddress ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8"><?= $cuPhone ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?= $cuEmail ?></div>
                                </div>

                            </div>
                            <?php endif ?>

                            <?php if(isset($_GET['vw']) && $_GET['vw'] == 'e-info'): ?>
                            <div class="tab-pane fade show active pt-3">

                                <!-- Profile Edit Form -->
                                <form action="" method="post">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="<?= $uploadsRoot ?>images/administrators/<?= $cuImage ?>" width="100" alt="Profile">
                                            <div class="pt-2">
                                                <a href="<?= $adminRoot ?>profile?vw=e-image" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                <?php if($cuImage != $adminDefaultImg): ?>
                                                <a href="<?= $adminRoot ?>profile?vw=e-info&do=reset-image" class="btn btn-danger btn-sm" title="Reset image to default"><i class="bi bi-trash"></i></a>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fName" type="text" class="form-control" value="<?= $cuFName ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="lName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="lName" type="text" class="form-control" value="<?= $cuLName ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="bio" class="form-control" id="about" style="height: 100px"><?= $cuBio ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="company" type="text" class="form-control" id="company" value="<?= $cuCompany ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="job" type="text" class="form-control" id="Job" value="<?= $cuJob ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3  col-form-label">Gender</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select class="form-select" name="gender">
                                                <option selected="">Please Choose</option>
                                                <?php
                                                $q = dbSelect('genders',"*","status='active'");
                                                while($row=mysqli_fetch_array($q)){
                                                ?>
                                                <option <?php if($cuGender == $row['id']){ echo 'selected'; } ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3  col-form-label">Country</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select class="form-select" name="country">
                                                <option selected="">Please Choose</option>
                                                <?php
                                                $q = dbSelect('countries',"*","status='active'");
                                                while($row=mysqli_fetch_array($q)){
                                                ?>
                                                <option <?php if($cuCountry == $row['id']){ echo 'selected'; } ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="address" type="text" class="form-control" id="Address" value="<?= $cuAddress ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="Phone" value="<?= $cuPhone ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="Email" value="<?= $cuEmail ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="twitter" type="text" class="form-control" id="Twitter" value="<?= $cuTwURL ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="facebook" type="text" class="form-control" id="Facebook" value="<?= $cuFbURL ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="instagram" type="text" class="form-control" id="Instagram" value="<?= $cuIgURL ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="linkedin" type="text" class="form-control" id="Linkedin" value="<?= $cuLkURL ?>">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" name="updateInfo" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>
                            <?php endif ?>

                            <?php if(isset($_GET['vw']) && $_GET['vw'] == 'e-image'): ?>
                            <div class="tab-pane fade show active pt-3">

                                <!-- Settings Form -->
                                <form action="" method="post" enctype="multipart/form-data">

                                    <div class="row mb-3">
                                        <div class="col-md-7">
                                            <label for="">Profile Image <span class="text-info">jpg/png expected not more than 500kb</span></label>
                                            <div class="input-group mb-3">
                                                <input type="file" name="userImage" class="form-control form-control-lg" onChange="doPreview(this);">
                                                <button class="btn btn-primary btn-lg" name="updateImage" type="submit"><?= ($cuImage == 'default.png') ? 'Upload' : 'Update' ?></button>
                                            </div>
                                            <?php if(isset($userImageError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $userImageError ?></span><?php endif ?>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="img-preview-box rounded shadow-sm p-3 d-inline-block">
                                                <img src="<?= $uploadsRoot ?>images/administrators/<?= $cuImage ?>" alt="" class="imgPreviewBox img-fluid rounded-circle">
                                            </div>
                                        </div>
                                    </div>
                                </form><!-- End settings Form -->

                            </div>
                            <?php endif ?>

                            <?php if(isset($_GET['vw']) && $_GET['vw'] == 'c-pwd'): ?>
                            <div class="tab-pane fade show active pt-3">
                                <!-- Change Password Form -->
                                <form action="" method="post">

                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="input-group">
                                                <input name="password" type="password" class="form-control" id="currentPassword" value="<?php if(isset($_POST['password'])){ echo $_POST['password']; } ?>">
                                                <button id="show" class="btn btn-light" type="button"><i class="bi bi-eye"></i></button>
                                                <button id="hide" class="btn btn-light" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                            <?php if(isset($passwordError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $passwordError ?></span><?php endif ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="input-group">
                                                <input name="newPassword" type="password" class="form-control" id="newPassword" value="<?php if(isset($_POST['newPassword'])){ echo $_POST['newPassword']; } ?>">
                                                <button id="show2" class="btn btn-light" type="button"><i class="bi bi-eye"></i></button>
                                                <button id="hide2" class="btn btn-light" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                            <?php if(isset($newPasswordError)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $newPasswordError ?></span><?php endif ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword2" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="input-group">
                                                <input name="newPassword2" type="password" class="form-control" id="newPassword2" value="<?php if(isset($_POST['newPassword2'])){ echo $_POST['newPassword2']; } ?>">
                                                <button id="show3" class="btn btn-light" type="button"><i class="bi bi-eye"></i></button>
                                                <button id="hide3" class="btn btn-light" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                            <?php if(isset($newPassword2Error)): ?><span class="d-inline-block bg-danger text-white px-2 rounded mt-1"><?= $newPassword2Error ?></span><?php endif ?>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" name="updatePassword" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>
                            <?php endif ?>

                        </div>
                        <!-- End Bordered Tabs -->
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
