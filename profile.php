<?php
include "./include/session.php";
include "./include/connection.php";
if(!isset($_SESSION['id'])){
    echo '<script>window.location.href="./login.php";</script>';
}
else{
?>
<!doctype html>
<html lang="en">
<!-- Head Links start Here -->
<?php include "./include/head_links.php" ?>
<!-- Head Links start Here -->

<body data-sidebar="dark">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Navbar Start Here -->
        <?php include "./include/Navbar.php" ?>
        <!-- Navbar End Here -->
        <!-- ========== Left Sidebar Start ========== -->
        <?php include "./include/Left_Side_Bar.php" ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Profile Image</h4>
                                    <form method="POST">
                                        <div class="row mt-5 text-center">
                                                <div>
                                                    <img src="./assets/images/profile-img.jpg" class="rounded-circle" height= "250">
                                                </div>
                                        </div>
                                        <div class="row mt-2">
                                                <div class="mb-3">
                                                    <input type="file" class="form-control" id="formrow-firstname-input" placeholder="" value="">
                                                </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col text-center">
                                                <button class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Presonal Information</h4>
                                    <form method="POST">
                                        <div class="row mt-5">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" placeholder="" value="<?php echo $_SESSION['name'] ?>" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="formrow-firstname-input" placeholder="" value="<?php echo $_SESSION['email'] ?>" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Contact No.</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" placeholder="" value="<?php echo $_SESSION['contact'] ?>" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="formrow-firstname-input" placeholder="Enter Your Passeord" required style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col text-center">
                                                <button class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Change Password</h4>
                                    <form method="POST">
                                        <div class="row mt-5">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Old Password</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" placeholder="Enter Old Password" value=""style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">New Password</label>
                                                    <input type="password" class="form-control" id="formrow-firstname-input" placeholder="Enter New Passeord" required style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col text-center">
                                                <button class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->



            <!-- Footer Start Here -->
            <?php include "./include/Footer.php" ?>
            <!-- Footer End Here -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <?php include "./include/Rght_Side_Bar.php" ?>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- Footer Link Start Here-->
    <?php include "./include/footer_link.php" ?>
    <!-- Footer Link End Here-->
</body>
</html>
<?php
}
?>