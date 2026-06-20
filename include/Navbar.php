<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <?php
                $logo_name = "";
                if ($_SESSION['role'] == "admin") {
                    $logo_name = (defined('APP_NAME') ? APP_NAME : 'Aquify');
                } else if ($_SESSION['role'] == "retailer") {
                    $logo_name = $_SESSION['name'];
                }
                
                // Extract initials
                $logo_initials = "";
                preg_match_all('/[A-Z]/', $logo_name, $matches);
                if (count($matches[0]) >= 2) {
                    $logo_initials = $matches[0][0] . $matches[0][1];
                } else {
                    $logo_initials = strtoupper(substr($logo_name, 0, 2));
                }
                ?>
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <?php echo $logo_initials; ?>
                    </span>
                    <span class="logo-lg">
                        <?php echo $logo_name; ?>
                    </span>
                </a>

                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <?php echo $logo_initials; ?>
                    </span>
                    <span class="logo-lg">
                        <?php echo $logo_name; ?>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/profile-img.jpg" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo $_SESSION['name'] ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="profile.php"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="logout.php"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div>

        </div>
    </div>
</header>