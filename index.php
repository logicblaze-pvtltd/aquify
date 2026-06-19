<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
    echo '<script>window.location.href="./login.php";</script>';
} else {
    $id = $_SESSION['id'];
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
                                            <li class="breadcrumb-item active">Home</li>

                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- end page title -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid bg-primary bg-opacity-50">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total <?php
                                                                                        if ($_SESSION['role'] == 'retailer') {
                                                                                            echo "Earning";
                                                                                        } else {
                                                                                            echo "Retailers";
                                                                                        } ?></p>
                                                <h4 class="mb-0"><?php
                                                                    if ($_SESSION['role'] == 'retailer') {
                                                                        $sql = "SELECT sum(`paid_ammount`) as sale from sale WHERE `addby` = $id";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_fetch_assoc($result);
                                                                        echo "Rs. " . (int)$row['sale'];
                                                                    } else {
                                                                        $sql = "SELECT count(`id`) as users from users WHERE `role` = 'retailer'";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $row = mysqli_fetch_assoc($result);
                                                                        echo $row['users'] . " Users";
                                                                    }
                                                                    ?></h4>
                                            </div>
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <?php
                                                        if ($_SESSION['role'] == 'retailer') {
                                                            echo '<i class="bx bx-archive-in font-size-24"></i>';
                                                        } else {
                                                            echo '<i class="mdi mdi-store font-size-24"></i>';
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid bg-warning bg-opacity-50">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium"><?php
                                                                                if ($_SESSION['role'] == 'retailer') {
                                                                                    echo "Pending Ammount";
                                                                                } else {
                                                                                    echo "Active Retailers";
                                                                                }
                                                                                ?></p>
                                                <h4 class="mb-0">
                                                    <?php
                                                    if ($_SESSION['role'] == 'retailer') {
                                                        $sqlP = "SELECT SUM(total_sale) AS pending
                                                    FROM (
                                                        SELECT (SUM(D) * rate - paid_ammount) AS total_sale
                                                        FROM sale
                                                        WHERE `addby` = $id
                                                        GROUP BY id
                                                    ) AS subquery";
                                                        $resultP = mysqli_query($conn, $sqlP);
                                                        $rowP = mysqli_fetch_assoc($resultP);
                                                        echo "Rs. " . (int)$rowP['pending'];
                                                    } else {
                                                        $sql = "SELECT count(`id`) as users from users WHERE `role` = 'retailer' AND status = 1";
                                                        $result = mysqli_query($conn, $sql);
                                                        $row = mysqli_fetch_assoc($result);
                                                        echo $row['users'] . " Users";
                                                    }
                                                    ?>
                                                </h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <?php
                                                        if ($_SESSION['role'] == 'retailer') {

                                                            echo '<i class="mdi mdi-cash-plus font-size-24"></i>';
                                                        } else {
                                                            echo '<i class="fas fa-user-check font-size-24"></i>';
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid bg-success bg-opacity-50">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">
                                                    <?php
                                                    if ($_SESSION['role'] == 'retailer') {
                                                        echo "Total Supply";
                                                    } else {
                                                        echo "This Month Earning";
                                                    }
                                                    ?>
                                                </p>
                                                <h4 class="mb-0">
                                                    <?php
                                                    if ($_SESSION['role'] == 'retailer') {
                                                        $sqlS = "SELECT sum(D) as D from sale WHERE `addby` = $id";
                                                        $resultS = mysqli_query($conn, $sqlS);
                                                        $rowS = mysqli_fetch_assoc($resultS);
                                                        echo (int)$rowS['D'] . " Cans";
                                                    } else {
                                                        $month = date('m');
                                                        $year = date('Y');
                                                        $sql = "SELECT Sum(p.`ammount`) as total_amount 
                                                        from `payment` pay 
                                                        inner join `users` u on pay.user = u.id 
                                                        inner join `package` p on pay.package = p.id 
                                                        where u.status = 1
                                                        AND MONTH(pay.`created_at`) = $month AND YEAR(pay.`created_at`) = $year";
                                                        $result = mysqli_query($conn, $sql);
                                                        if ($row = mysqli_fetch_array($result)) {
                                                            if ($row['total_amount'] > 0) {
                                                                echo "Rs. " . $row['total_amount'];
                                                            } else {
                                                                echo "Rs. 0";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <?php 
                                                        if($_SESSION['role'] == 'retailer'){

                                                            echo '<i class="mdi mdi-water-plus font-size-24"></i>';

                                                        }else{
                                                            echo '<i class="bx bx-archive-in font-size-24"></i>';
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid bg-info bg-opacity-50">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">
                                                    <?php
                                                    if ($_SESSION['role'] == 'retailer') {

                                                        echo "Empty Can";
                                                    } else {
                                                        echo "Pending Ammount";
                                                    }
                                                    ?>
                                                </p>
                                                <h4 class="mb-0">
                                                    <?php
                                                    if ($_SESSION['role'] == 'retailer') {
                                                        $sqlE = "SELECT SUM(total_empty) AS emty
                                                    FROM (
                                                        SELECT (SUM(D) - sum(R) ) AS total_empty
                                                        FROM sale
                                                        WHERE addby = $id
                                                        GROUP BY id
                                                    ) AS subquery
                                                    ";
                                                        $resultE = mysqli_query($conn, $sqlE);
                                                        $rowE = mysqli_fetch_assoc($resultE);
                                                        echo (int)$rowE['emty'] . " Cans";
                                                    } else {
                                                        $sql = "SELECT COUNT(*) AS total_user
                      FROM `users` WHERE `status`!= 1 AND `role` = 'Retailer'";
                                                        $result = mysqli_query($conn, $sql);
                                                        if ($row = mysqli_fetch_array($result)) {
                                                            if ($row['total_user'] > 0) {
                                                                echo $row['total_user'] . " Users";
                                                            } else {
                                                                echo "0 User";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <?php
                                                        if($_SESSION['role'] == 'retailer'){
                                                           echo  '<i class="fas fa-wine-bottle font-size-24"></i>';

                                                        }else{
                                                            echo '<i class="mdi mdi-cash-plus font-size-24"></i>';
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($_SESSION['role'] == 'retailer') {
                        ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">
                                                <i class="fa fas fa-chart-area"></i>
                                                <span>Weekly Sale</span>
                                            </h4>
                                            <canvas id="SalesChart" arira-label="chart" role="img"></canvas>
                                            <?php
                                            $id = $_SESSION['id'];
                                            $dayMonth = array();
                                            $records = array();
                                            $sqlSale =
                                                "SELECT 
                                            DATE_FORMAT(`created_at`, '%M %d') AS day_month,
                                            SUM(D) AS records_count
                                        FROM 
                                            `sale`
                                        WHERE 
                                            `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                                            AND `addby` = $id
                                        GROUP BY 
                                            DATE_FORMAT(`created_at`, '%M %d')
                                        ORDER BY 
                                            DATE_FORMAT(`created_at`, '%Y-%m-%d') ASC;
                                        ";
                                            $resultSale = mysqli_query($conn, $sqlSale);
                                            if ($result) {
                                                $count = 0;
                                                while ($row = mysqli_fetch_array($resultSale)) {
                                                    $dayMonth[] = $row['day_month'];
                                                    $records[] = $row['records_count'];
                                            ?>
                                                    <input type="hidden" name="dayMonth<?php echo $count ?>[]" value="<?php print_r($dayMonth[$count]) ?>">
                                                    <input type="hidden" name="records<?php echo $count ?>[]" value="<?php print_r($records[$count]) ?>">
                                            <?php
                                                    $count++;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="card-title mb-4">
                                                <i class="fa fas fa-chart-bar"></i>
                                                <span>Monthly Sale</span>
                                            </h4>
                                            <canvas id="MedicineChart" arira-label="chart" role="img"></canvas>
                                            <?php
                                            $id = $_SESSION['id'];
                                            $month = array();
                                            $totalMed = array();
                                            $sqlMed = "SELECT MONTHNAME(`created_at`) AS month_name, sum(D) AS total_med
                  FROM `sale`
                  WHERE `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                  AND `addby` = $id
                  GROUP BY YEAR(`created_at`), MONTH(`created_at`)";
                                            $resultMed = mysqli_query($conn, $sqlMed);
                                            if ($result) {
                                                $count = 0;
                                                while ($rowMed = mysqli_fetch_array($resultMed)) {
                                                    $month[] = $rowMed['month_name'];
                                                    $totalMed[] = $rowMed['total_med'];
                                            ?>
                                                    <input type="hidden" name="month<?php echo $count ?>[]" value="<?php print_r($month[$count]) ?>">
                                                    <input type="hidden" name="totalMed<?php echo $count ?>[]" value="<?php print_r($totalMed[$count]) ?>">
                                            <?php
                                                    $count++;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <!-- Main Body  -->
                        <div class="col-12">
                            <div class="card">
                            <?php
                                if ($_SESSION['role'] == "admin") {
                                ?>
                                    <div class="card-body">
                                        <h4 class="card-title mb-4"> <i class="mdi mdi-table-large"></i> <span>List of Due Payments User</span></h4>
                                        <table id="datatable" class="table table-bordered table-hover dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="table table-dark">
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Status</th>
                                                    <th>Pakage</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT u.*, p.`name` as package, p.`id` as pid FROM `users` u
                      INNER JOIN `package` p on u.`package` = p.`id` WHERE `role` = 'retailer' AND `status` != 1";
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                if ($row['profile'] != "") {
                                                                    echo "<img class='rounded-circle header-profile-user img-thumbnail' src='./assets/images/users/" . $row['profile'] . "' >";
                                                                } else {
                                                                    echo '<img class="rounded-circle header-profile-user img-thumbnail" src="assets/images/profile-img.jpg" alt="">';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['email']; ?></td>
                                                            <td><?php echo $row['contact'] ?></td>
                                                            <td>
                                                                <?php
                                                                if ($row['status'] == 0) {
                                                                    echo '
                                    <h5>
                                    <span class="badge bg-warning">
                                      Due Payment
                                    </span>
                                  </h5>';
                                                                } else {
                                                                    echo '<h5>
                                    <span class="badge bg-danger">
                                      Disable
                                    </span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row['package'] ?></td>
                                                            <td>
                                                                <a href="edit_Retailer.php?id=<?php echo $row['id']; ?>">
                                                                    <button class="btn btn-info">
                                                                        Edit
                                                                    </button>
                                                                </a>
                                                                <a href="index.php?id=<?php echo $row['id']; ?>&pid=<?php echo $row['pid'] ?>">
                                                                    <button class="btn btn-secondary">
                                                                        Pay Bill
                                                                    </button>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
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
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pid = $_GET['pid'];
    $sqlInsert = "INSERT INTO payment (`user`,`package`) VALUES ('$id','$pid')";
    $resultInsert = mysqli_query($conn, $sqlInsert);
    if ($resultInsert) {
      $sql = "UPDATE `users` SET `status`= 1 WHERE id='$id' ";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        echo '<script>window.location.href="index.php";</script>';
      }
    }
  }
?>