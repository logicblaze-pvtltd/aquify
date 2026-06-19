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
                                    <h4 class="mb-sm-0 font-size-18">Supply</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Suplier List</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <?php
                        $addby = $_SESSION['id'];
                        $sql = "SELECT s.id as id, s.name  FROM `assign_area` aa INNER JOIN supplier s ON aa.`supplier` = s.id WHERE s.addby = $addby GROUP BY aa.`supplier`";
                        $result = mysqli_query($conn, $sql);
                        $count = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $name = $row['name'];
                                $supplier_id  = $row['id'];


                        ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="accordion" id="accordionExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $count ?>" aria-expanded="true" aria-controls="collapseOne">
                                                                    <?php echo $name ?>
                                                                </button>
                                                            </h2>
                                                            <div id="collapse<?= $count ?>" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <ul class="metismenu list-unstyled">
                                                                        <?php
                                                                        $areaNameSql = "SELECT a.id as id,a.name as name  FROM `assign_area` aa INNER JOIN area a ON aa.`area` = a.id WHERE  aa.`supplier` = '$supplier_id' ORDER BY a.name";
                                                                        $areaNameresult = mysqli_query($conn, $areaNameSql);
                                                                        if (mysqli_num_rows($areaNameresult) > 0) {
                                                                            while ($areaNamerow = mysqli_fetch_assoc($areaNameresult)) {
                                                                                $area =  $areaNamerow['name'];
                                                                                $a_id = $areaNamerow['id'];
                                                                        ?>
                                                                                <li>
                                                                                    <form action="Supply_Calender.php" method="POST">

                                                                                        <input type="hidden" name="supplier" value="<?php echo $name ?>">
                                                                                        <input type="hidden" name="area" value="<?php echo $area ?>">
                                                                                        <input type="hidden" name="supplier_id" value="<?php echo $supplier_id ?>">
                                                                                        <input type="hidden" name="a_id" value="<?php echo $a_id ?>">
                                                                                        <button class="waves-effect btn btn-outline-primary my-1 w-100 shadow" type="submit">
                                                                                            <?php echo  $area ?>
                                                                                        </button>
                                                                                    </form>

                                                                                </li>

                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                </div>
                        <?php
                                $count++;
                            }
                        } else {
                            echo "No Records";
                        }

                        ?>
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