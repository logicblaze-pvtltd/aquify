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
                                    <h4 class="mb-sm-0 font-size-18">Bill Inquiry</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">View Customer Bill</li>

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
                                        <h4 class="card-title">ENTER DETAIL:</h4>
                                        <form action="CustomerList.php" method="GET">
                                            <div class="row mt-5">
                                                <div class="col">
                                                    <label for="year">Select Year:</label>
                                                    <select class="form-select glass-input" name="year" id="yearSelect" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                        <option selected hidden>-- Select Year --</option>
                                                        <?php
                                                        $sqlYear = "SELECT DISTINCT YEAR(created_at) AS sale_year FROM sale WHERE created_at IS NOT NULL ORDER BY sale_year DESC";
                                                        $resultYear = mysqli_query($conn, $sqlYear);
                                                        while ($rowYear = mysqli_fetch_assoc($resultYear)) {
                                                            echo '<option value="' . $rowYear['sale_year'] . '">' . $rowYear['sale_year'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="month">Select Month:</label>
                                                    <select class="form-select glass-input" name="month" id="monthSelect" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                        <option selected hidden>-- Select Year First --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col">
                                                    <label for="area">Select Supplier:</label>
                                                    <select class="form-select" id="supplier_id" name="supplier_id" aria-label="Default select example" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                        <option hidden> Choose Supplier</option>
                                                        <?php
                                                        $addby = $_SESSION['id'];
                                                        $sql = "SELECT * FROM `supplier` WHERE `addby` = $addby";
                                                        $result = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {

                                                        ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                                        <?php

                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="area">Select Area:</label>
                                                    <select class="form-select" name="area_id" id="area_id" aria-label="Default select example" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                                                        <option>--Select Area--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row my-5">
                                                <input type="submit" name="submit" value="Submit" class="btn btn-primary m-auto w-25">
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

        <script>
            $('#supplier_id').on('change', function() {
                var supplier_id = this.value;
                // alert(supplier_id);

                $.ajax({
                    type: "POST",
                    url: "ajax/get_area.php",
                    data: {
                        'supplier_id': supplier_id
                    }

                }).done(function(msg) {
                    $('#area_id').html(msg);
                });
            });
        </script>
        <!-- ====== SCRIPT ====== -->
        <script>
            document.getElementById('yearSelect').addEventListener('change', function() {
                let selectedYear = this.value;
                let monthSelect = document.getElementById('monthSelect');
                monthSelect.innerHTML = '<option selected hidden>Loading...</option>';
                if (selectedYear) {
                    fetch('<?php echo (defined('APP_URL') ? APP_URL : "/aquify"); ?>/ajax/get_months.php?year=' + selectedYear)
                        .then(response => response.text())
                        .then(data => {
                            monthSelect.innerHTML = '<option selected hidden>-- Select Month --</option>' + data;
                        })
                        .catch(error => {
                            console.error('Error fetching months:', error);
                            monthSelect.innerHTML = '<option selected hidden>Error loading months</option>';
                        });
                } else {
                    monthSelect.innerHTML = '<option selected hidden>-- Select Year First --</option>';
                }
            });
        </script>
    </body>

    </html>
<?php
}
?>