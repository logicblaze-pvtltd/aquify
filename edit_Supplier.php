<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
    echo '<script>window.location.href="./login.php";</script>';
}
$id = $_GET['id'];
$sql = "SELECT `id`,`full_name`,`contact_no`,`status` FROM `supplier` WHERE id='$id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['full_name'];
    $contact = $row['contact_no'];
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
                                <h4 class="mb-sm-0 font-size-18">Supplier</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Add New Supplier</li>
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
                                                <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" placeholder=""name="Sup_name"value="<?php echo $name ?>" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;">
                                                </div>
                                            </div>
                                            <div class="col">
                                            <div class="mb-3">
                                                    <label for="formrow-firstname-input" class="form-label">Contact No.</label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" placeholder=""name="Sup_contact"value="<?php echo $contact ?>" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-center mt-2">
                                            <div>
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary w-md">Submit</button>
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
    $name = $_POST['Sup_name'];
    $contact = $_POST['Sup_contact'];
    $sql = "UPDATE `supplier` SET `full_name`='$name',`contact_no`='$contact' WHERE id  ='$id'";
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } else {
        echo '<script>window.location.href="./manage_Supplier.php";</script>';
    }
}
?>