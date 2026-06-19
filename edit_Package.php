<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
    echo '<script>window.location.href="./login.php";</script>';
} else {

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
                                    <h4 class="mb-sm-0 font-size-18">Package</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Edit Package</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <?php
                                            $id = $_GET['id'];
                                            $sql = "SELECT * from package where id = $id";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_array($result);
                                             ?>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="Sup_name" class="form-control" id="floatingnameInput" placeholder="Enter Name" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;" required value="<?php echo $row['name'] ?>">
                                                        <label for="floatingnameInput">Name</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="Sup_contact" class="form-control" id="floatingnameInput" placeholder="Enter Phone Number" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;" value="<?php echo $row['ammount'] ?>">
                                                        <label for="floatingnameInput">Ammount</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row text-center mt-2">
                                                <div>
                                                    <button type="submit" name="submit" class="btn btn-primary w-md">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
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
if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $name = $_POST['Sup_name'];
    $contact = $_POST['Sup_contact'];
    
    $sql = "UPDATE `package` SET `name`= '$name', `ammount`='$contact' WHERE id =$id ";
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } else {
        echo '<script>alert("Package Updated Successfully");window.location.href="./manage_Package.php";</script>';
    }
}
?>