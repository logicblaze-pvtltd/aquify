<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
    echo '<script>window.location.href="./login.php";</script>';
} else {
    $id = $_SESSION['id'];
    if (isset($_POST['submit'])) {
        $area = $_POST['area_id'];
        $supplier = $_POST['supplier_id']; 
        $sql = "INSERT INTO `assign_area`(`area`, `supplier`,`addby`,`status`) VALUES ('$area','$supplier','$id',1)";
        $result = mysqli_query($conn, $sql);

        $areaUpdateSql = "UPDATE area SET `status` = 1 WHERE `id` = '$area'";
        $areaUpdateResult =  mysqli_query($conn, $areaUpdateSql);   
        if ($result && $areaUpdateResult) {
            echo '<script>alert("Assign Area Successfully");</script>';
        }
    }
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
                                            <li class="breadcrumb-item active">Preloader Layout</li>

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
                                        <form action="#" method="POST">
                                            <div class="row my-4">
                                                <div class="col">
                                                    <select class="form-select" name="area_id" aria-label="Default select example" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                        <option hidden> Choose Area</option>
                                                        <?php
                                                        $sql = "SELECT * FROM `area` WHERE `status`= 0 AND `addby` = '$id'";
                                                        $result = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" name="supplier_id" aria-label="Default select example" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                        <option hidden> Choose Supplier</option>
                                                        <?php
                                                        $sql = "SELECT * FROM `supplier` WHERE `status` = 1 AND `addby` = '$id'";
                                                        $result = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>
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
?>