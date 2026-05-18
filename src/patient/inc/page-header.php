<div class="pagetitle">
    <h1>
        <?php
        if (defined('HEADER')) {
            echo HEADER;
        } else {
            echo 'Admin Dashboard';
        }
        ?>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $patientRoot ?>home"><i class="bi bi-house-fill"></i></a></li>
            <li class="breadcrumb-item active">
                <?php
                if (defined('BREADCRUMB')) {
                    echo BREADCRUMB;
                } else {
                    echo 'dashboard';
                }
                ?>
            </li>
        </ol>
    </nav>
</div>