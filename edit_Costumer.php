<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
    echo '<script>window.location.href="./login.php";</script>';
} else {
    $costumer_id = $_GET['id'];
    if(isset($_POST['submit'])){
        $name = $_POST['full_name'];
        $rate = $_POST['rate'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $supplier_id = $_POST['supplier_id'];
        $area_id = $_POST['area_id'];
        $sql = "UPDATE `customer` SET `customer_name`='$name',`customer_contact`='$contact',`address`='$address',`customer_can_rate`='$rate',`area_id`='$area_id',`supplier_id`='$supplier_id' WHERE `customer_id`='$costumer_id'";
        $result = mysqli_query($conn,$sql);
        echo '<script>window.location.href="./manage_Costumer.php";</script>';

        if($result){
            echo '<script>window.location.href="./manage_Costumer.php";</script>';
        }
    }
    $sql = "SELECT `customer_name`, `customer_contact`, `address`, `customer_can_rate`, `area_id`, `supplier_id` FROM `customer` WHERE customer_id='$costumer_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $Costumer_name = $row['customer_name'];
        $Costumer_contact = $row['customer_contact'];
        $address = $row['address'];
        $Costumer_can = $row['customer_can_rate'];
        $area_id = $row['area_id'];
        $supplier_id = $row['supplier_id'];
    }
?>
    <!doctype html>
    <html lang="en">
    <!-- Head Links start Here -->
    <?php include "./include/head_links.php" ?>
    <!-- Head Links end Here -->

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
                                    <h4 class="mb-sm-0 font-size-18">Costumer</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Add New Costumer</li>
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
                                        <h5 class="card-title">Add New Costumer</h5>
                                        <form action="#" method="POST">
                                            <div class="row my-4">
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="floatingnameInput" placeholder="Rate Per Can" name="rate" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;" value="<?php echo $Costumer_can ?>">
                                                        <label for="floatingnameInput">Rate Per Can</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" name="supplier_id" aria-label="Default select example" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none; height:58px;">
                                                        <?php
                                                                $sql = "SELECT `id`, `full_name` FROM `supplier` WHERE `id`='$supplier_id'";
                                                                $result = mysqli_query($conn, $sql);
                                                                if (mysqli_num_rows($result)>0) {
                                                                    $row = mysqli_fetch_assoc($result);
                                                                    $SupplierName = $row['full_name'];
                                                                ?>
                                                    <option hidden value="<?php echo $row['id'] ?>"><?php echo $SupplierName?></option>
                                                    <?php
                                                                }
                                                    ?>
                                                        <?php
                                                                $sql = "SELECT `id`,`full_name` FROM `supplier`";
                                                                $result = mysqli_query($conn, $sql);
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option value="<?php echo $row['id'] ?>">
                                                                <?php echo $row['full_name'] ?></option>
                                                    <?php
                                                                    }
                                                                }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row my-4">
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="floatingnameInput" placeholder="Enter Name" name="full_name" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;" value="<?php echo $Costumer_name ?>">
                                                        <label for="floatingnameInput">Name</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="floatingemailInput" placeholder="Enter Costumer Id" name="address" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;" value="<?php echo $address?>">
                                                        <label for="floatingemailInput">Address</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row my-4">
                                            <div class="col">
                                                    <select class="form-select" name="area_id" aria-label="Default select example" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none; height:58px;">
                                                        <?php
                                                                $sql = "SELECT `id`, `area_name` FROM `area` WHERE `id`='$area_id'";
                                                                $result = mysqli_query($conn, $sql);
                                                                if (mysqli_num_rows($result)>0) {
                                                                    $row = mysqli_fetch_assoc($result);
                                                                    $AreaName = $row['area_name'];
                                                                ?>
                                                    <option hidden value="<?php echo $row['id'] ?>"><?php echo $AreaName?></option>
                                                    <?php
                                                                }
                                                    ?>
                                                        <?php
                                                                $sql = "SELECT `id`,`area_name` FROM `area`";
                                                                $result = mysqli_query($conn, $sql);
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option value="<?php echo $row['id'] ?>">
                                                                <?php echo $row['area_name'] ?></option>
                                                    <?php
                                                                    }
                                                                }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="floatingnameInput" placeholder="Enter Phone Number" name="contact" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;" value="<?php echo $Costumer_contact?>">
                                                        <label for="floatingnameInput">Contact No.</label>
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
?>