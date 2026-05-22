<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="<?= $adminRoot ?>home">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        
        <li>
            <a class="nav-link" href="<?= $adminRoot ?>chat">
                <i class="bi bi-chat"></i>
                <span>Chat</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>App Users</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= $adminRoot ?>administrators">
                        <i class="bi bi-circle"></i><span>Administrators</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $adminRoot ?>doctors">
                        <i class="bi bi-circle"></i><span>Doctor</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $adminRoot ?>patients">
                        <i class="bi bi-circle"></i><span>Patients</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $adminRoot ?>roles">
                        <i class="bi bi-circle"></i><span>Roles</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#system-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>System Commons</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="system-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= $adminRoot ?>countries">
                        <i class="bi bi-circle"></i><span>Countries</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $adminRoot ?>meetings">
                        <i class="bi bi-circle"></i><span>Booked Meetings</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $adminRoot ?>genders">
                        <i class="bi bi-circle"></i><span>Genders</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= $adminRoot ?>temp">
                <i class="bi bi-file-earmark"></i>
                <span>Template</span>
            </a>
        </li>
        <!-- End Profile Page Nav -->


    </ul>

</aside>
