<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
    echo '<script>window.location.href="./login.php";</script>';
} else {
    $id = $_SESSION['id'];
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $rate = $_POST['rate'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $area_id = $_POST['area_id'];
        $supplier_id = $_POST['supplier_id'];
        $sql = "INSERT INTO `customer`(`name`,`contact`,`address`,`rate`,`area`,`supplier`,`addby`) VALUES ('$name','$contact','$address','$rate','$area_id','$supplier_id','$id')";
        $result = mysqli_query($conn,$sql);
        $customer_id = mysqli_insert_id($conn); 
        if($result){
            echo '<script>window.location.href="./manage_Costumer.php";</script>';
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

                                    <form action="#" method="POST" >
                                        <div class="row mt-4">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingnameInput"
                                                        placeholder="Rate Per Can"
                                                        name="rate"
                                                        style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;"
                                                        required>
                                                    <label for="floatingnameInput">Rate Per Can</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <select class="form-select" name="supplier_id"
                                                    aria-label="Default select example"
                                                    style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none; height:58px;"
                                                    id="supplier_id">
                                                    <option hidden> Choose Supplier</option>
                                                    <?php
                                                        $sql = "SELECT * FROM `supplier` WHERE `status` = 1 AND `addby` = '$id'";
                                                        $result = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                    <option value="<?php echo $row['id'] ?>">
                                                        <?php echo $row['name'] ?></option>
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
                                                    <input type="text" class="form-control" id="floatingnameInput"
                                                        placeholder="Enter Name"name="name"
                                                        style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;"
                                                        required>
                                                    <label for="floatingnameInput">Name</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingemailInput"
                                                        placeholder="Enter Costumer Id"
                                                        name="address"
                                                        style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;"
                                                        required>
                                                    <label for="floatingemailInput">Address</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col">
                                                <select class="form-select" name="area_id"
                                                    aria-label="Default select example"
                                                    style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;height:58px;"
                                                    id="area_id">
                                                </select>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingnameInput"
                                                        placeholder="Enter Phone Number" name="contact"
                                                        style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;">
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
    <script>
        $('#supplier_id').on('change', function() {
            var supplier_id = this.value;
            // alert(supplier_id);
            
            $.ajax({
                type: "POST",
                url:  "ajax/get_area.php",
                data: {'supplier_id': supplier_id}

            }).done(function (msg) {
                $('#area_id').html(msg);
            });
});
    </script>
</body>
</html>
<?php
}
?>