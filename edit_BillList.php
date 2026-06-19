<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
    echo '<script>window.location.href="./login.php";</script>';
} else {
    $id = $_GET['id'];
    $month  = $_GET['month'];
    $year   = $_GET['year'];
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
                    <form action="save.php" method="POST">
                        <div class="container-fluid">

                            <!-- start page title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0 font-size-18">Bill List</h4>
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item active">Other Details</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- end page title -->
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-header bg-primary bg-opacity-25 border-bottom text-uppercase text-center border-bottom border-primary">
                                            <h4>
                                                Supply Data
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>
                                                            Per Can Rate
                                                        </th>
                                                        <th>
                                                            Previous Empty Can.
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-primary bg-opacity-10">

                                                    <tr class="text-center">
                                                        <td class="text-primary">
                                                            <strong>
                                                                <?php
                                                                $sqlRate = "SELECT `rate` from `customer` where
                                                                id = $id";
                                                                $resultRate= mysqli_query($conn, $sqlRate);
                                                                $rowRate = mysqli_fetch_array($resultRate);
                                                                    echo $rowRate['rate'];
                                                                
                                                                ?>
                                                            </strong>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $preE = 0;
                                                           
                                                            $sqlpre = "SELECT sum(D) as D, sum(R) as R
                                                            FROM sale
                                                            WHERE  MONTH(created_at) = MONTH(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH))
                                                                AND YEAR(created_at) = YEAR(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH))
                                                            AND customer = $id     
                                                        ";
                                                            $result = mysqli_query($conn, $sqlpre);
                                                            if ($row = mysqli_fetch_array($result)) {
                                                                // Check if 'empty_can' is NULL
                                                                echo $preE = (int)$row['D'] - (int)$row['R'];
                                                                echo '<input type="hidden" class="preE" value="' . $preE . '">';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody>

                                                </tbody>
                                            </table>
                                            <!-- Table Start -->

                                            <div class="table-responsive">
                                                <table class="table mb-0 table-bordered table-hover table-striped">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Deliver</th>
                                                            <th>Return</th>
                                                            <th>Paid</th>
                                                            <th>Empty Can.</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $paid = 0;
                                                        $Rcan = 0;
                                                       
                                                        $can = 0;
                                                        $Tcan = 0;
                                                        $query = "SELECT `D`,`R`,`paid_ammount`,`paid_ammount_date`,`created_at`,`id` as id from `sale` Where month(created_at) = $month and year(created_at) = $year and customer = $id";
                                                        $result = mysqli_query($conn, $query);
                                                        if ($result) {
                                                            $data = array_fill(0, 31, array('D' => '', 'R' => '', 'paid_ammount' => '', 'id' => ''));
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                $day = date('d', strtotime($row['created_at'])) - 1; // index based on 0-30
                                                                $data[$day] = $row;
                                                            }

                                                            foreach ($data as $day => $value) {
                                                                $Tcan += (int)$value['D'];
                                                                $Rcan += (int)$value['R'];
                                                        ?>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <input type="number" class="form-control border-0 bg-transparent fw-bold" name="day[]" value="<?php echo $day + 1 ?>" readonly>
                                                                    </th>
                                                                    <td>
                                                                        <input type="number" name="can_deliver[]" class="form-control border-0 bg-transparent can_deliver<?php echo $day + 1 ?>" onkeyup="get_D(<?php echo $day + 1 ?>)" value="<?php echo (int)$value['D']; ?>">
                                                                    </td>
                                                                    <td><input type="number" name="can_return[]" class="form-control border-0 bg-transparent can_return<?php echo $day + 1 ?>" value="<?php echo (int)$value['R']; ?>" onkeyup="get_R(<?php echo $day + 1 ?>)"></td>
                                                                    <td><input type="number" class="form-control <?php if ((int)$value['paid_ammount'] > 0) {
                                                                                                                        echo "fw-bold text-info";
                                                                                                                    } ?> border-0 bg-transparent paid_ammount<?php echo $day + 1 ?>" value="<?php echo (int)$value['paid_ammount']; ?>" name="paid[]"></td>
                                                                    <td>
                                                                        <input type="number" name="empty_can[]" class="form-control border-0 bg-transparent empty_can<?php echo $day + 1 ?>" value="<?php echo $Tcan - $Rcan + $preE; ?>" readonly>
                                                                    </td>
                                                                </tr>

                                                        <?php
                                                                $can += (int)$value['D'];
                                                                $paid += (int)$value['paid_ammount'];
                                                            }
                                                        }
                                                        ?>
                                                        <input type="hidden" value="<?php echo $id ?>" name="uid">
                                                        <input type="hidden" value="<?php echo $month ?>" name="month">
                                                        <input type="hidden" value="<?php echo $year ?>" name="year">
                                                    </tbody>
                                                </table>
                                                <!-- Table END -->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                               
                                $sql = "SELECT c.`name` FROM `customer` c inner join `sale` s on c.id = s.customer  WHERE c.id = $id";
                                $result  = mysqli_query($conn, $sql);
                                if ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-header bg-info bg-opacity-25 text-center text-uppercase border-bottom border-info">
                                                <h4>customer Detail</h4>
                                            </div>
                                            <div class="card-body">
                                                <table class="table mb-4">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                Customer Name
                                                            </th>
                                                            <th>
                                                                Month
                                                            </th>
                                                            <th>
                                                                Year
                                                            </th>
                                                            <th>
                                                                Code
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        <tr class="bg-info bg-opacity-10 text-info fw-semibold">
                                                            <td>
                                                                <?php echo $row['name'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo date('F', strtotime('1-' . $month . '-' . $year)) ?>
                                                            </td>
                                                            <td>
                                                                <?php echo date('Y', strtotime('1-' . $month . '-' . $year)) ?>
                                                            </td>
                                                            <td style="color: red;">
                                                                <?php echo $_GET['id'] ?>
                                                            </td>
                                                        </tr>

                                                    </tbody>

                                                </table>


                                                <div class="row mt-3">
                                                    <div class="card-header bg-warning bg-opacity-25 text-center text-uppercase border-bottom border-top border-warning">
                                                        <h4>
                                                            payment detail
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-3 text-end">
                                                        <h6 class="p-1" style="font-weight: bold;">Previous Bal.</h6>
                                                    </div>
                                                    <div class="col text-center border-bottom">
                                                        <h6 class="p-2">
                                                            <?php
                                                            $pre = 0;
                                                            $total = 0;
                                                            
                                                            $sqlpre = "SELECT sum(s.`D`) as D,s.rate as rate, sum(s.paid_ammount) as paid
                                                        FROM sale s
                                                        INNER JOIN customer c on s.customer = c.id
                                                            WHERE c.id = $id
                                                            AND MONTH(s.created_at) = MONTH(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH))
                                                            AND YEAR(s.created_at) = YEAR(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH))     
                                                                                          
                                                        ";
                                                            $resultBill = mysqli_query($conn, $sqlpre);
                                                            if ($rowBill = mysqli_fetch_array($resultBill)) {
                                                                // Check if 'empty_can' is NULL
                                                                //  ((int)$rowBill['D']*(int)$rowBill['rate']) - (int)$rowBill['paid'];
                                                                echo $pre = (int)$rowBill['D'] * (int)$rowBill['rate'] - (int)$rowBill['paid'];
                                                            }
                                                            ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 text-end">
                                                        <h6 class="p-2" style="font-weight: bold;">Current Bal.</h6>
                                                    </div>
                                                    <div class="col text-center border-bottom">
                                                        <h6 class="p-1 bold"><?php echo $total = $can * (int)$rowRate['rate']; ?></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 text-end">
                                                        <h6 class="p-2" style="font-weight: bold;">Paid Ammount.</h6>
                                                    </div>
                                                    <div class="col text-center border-bottom">
                                                        <h6 class="p-1 bold"><?php echo $paid ?></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 text-end">
                                                        <h6 class="p-2" style="font-weight: bold;">Total Bal.</h6>
                                                    </div>
                                                    <div class="col text-center border-bottom">
                                                        <h6 class="p-1 bold"><?php echo $pre + $total - $paid ?></h6>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <input type="submit" class="btn btn-success w-75 m-auto" name="submit" value="Update">
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                            </div>

                            <!-- end row -->
                        </div> <!-- container-fluid -->
                    </form>
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

    <script>
        function get_D(day) {
            var can_deliver = parseInt($(".can_deliver" + day).val(), 10);
            var can_return = parseInt($(".can_return" + day).val(), 10);
            var empty_can = parseInt($(".empty_can" + (day - 1)).val(), 10);
            if (!isNaN(can_deliver)) {
                for (var i = day; i <= 31; i++) {
                    // var nid = id;
                    if (!isNaN(empty_can)) {
                        // console.log(empty_can);
                        // console.log(empty_can);
                        if (i == day) {
                            $('.empty_can' + i).val((empty_can + can_deliver) - can_return);
                        } else {
                            var can = parseInt($(".can_deliver" + i).val(), 10);
                            var empty_can = parseInt($(".empty_can" + (i - 1)).val(), 10);
                            $('.empty_can' + i).val((empty_can + can) - can_return);
                        }
                    } else {

                        var preE = parseInt($(".preE").val(), 10);
                        if (i == day) {
                            // console.log(preE);
                            $('.empty_can' + i).val((can_deliver + preE) - can_return);
                        } else {
                            var can = parseInt($(".can_deliver" + i).val(), 10);
                            var empty_can = parseInt($(".empty_can" + (i - 1)).val(), 10);
                            $('.empty_can' + i).val(can_return - (can + empty_can));
                            // console.log(can+"e "+empty_can);
                        }
                    }

                }
            }
            get_R(day);
        }

        function get_R(day) {
            var can_deliver = parseInt($(".can_deliver" + day).val(), 10);
            var can_return = parseInt($(".can_return" + day).val(), 10);

            var empty_can = parseInt($(".empty_can" + (day - 1)).val(), 10);
            // console.log(empty_can);
            if (!isNaN(can_return)) {
                for (var i = day; i <= 31; i++) {
                    // var nid = id;
                    // console.log(empty_can);
                    if (!isNaN(empty_can)) {
                        if (i == day) {
                            $('.empty_can' + i).val((can_deliver - can_return) + empty_can);
                        } else {
                            var can = parseInt($(".can_deliver" + i).val(), 10);
                            var can_return = parseInt($(".can_return" + i).val(), 10);
                            var empty_can = parseInt($(".empty_can" + (i - 1)).val(), 10);
                            $('.empty_can' + i).val((can - can_return) + empty_can);
                            // console.log(can+" "+can_return+" "+empty_can);
                        }
                    } else {
                        var preE = parseInt($(".preE").val(), 10);

                        if (i == day) {
                            $('.empty_can' + i).val((can_deliver - can_return) + preE);
                        } else {
                            var can = parseInt($(".can_deliver" + i).val(), 10);
                            var can_return = parseInt($(".can_return" + i).val(), 10);
                            var empty_can = parseInt($(".empty_can" + (i - 1)).val(), 10);
                            $('.empty_can' + i).val((can - can_return) + empty_can);
                            // console.log(can+" "+can_return+" "+empty_can);
                        }
                    }

                }
            }
        }
    </script>

    </html>
<?php
}
?>