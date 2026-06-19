<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
  echo '<script>window.location.href="./login.php";</script>';
} else {
  // $area_name = $_GET['area_name'];
  $month = $_GET['month'];
  $year = $_GET['year'];
  $area_id = $_GET['area_id'];
  $supplier_id = $_GET['supplier_id'];
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
                      <li class="breadcrumb-item active">Manage Costumer</li>

                    </ol>
                  </div>

                </div>
              </div>
            </div>
            <!-- table Start Here -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Manage Costumer</h4>
                    <div class="d-flex justify-content-between my-4 p-4 border-top border-bottom bg-info bg-opacity-25 text-info">
                      <h5>Supplier: <strong><?php $sqlA = "SELECT `name` FROM `supplier` WHERE `id` = $supplier_id";
                      $resultA = mysqli_query($conn,$sqlA);
                      $rowA = mysqli_fetch_array($resultA);
                      echo $rowA['name'];?></strong></h5>
                      <h5>Date: <strong><?php echo date('F-Y',strtotime($year.'-'.$month.'-01')) ?></strong></h5>
                      <h5>Area: <strong><?php 
                      $sqlA = "SELECT `name` FROM `area` WHERE `id` = $area_id";
                      $resultA = mysqli_query($conn,$sqlA);
                      $rowA = mysqli_fetch_array($resultA);
                      echo $rowA['name'];?></strong></h5>

                      
                    </div>
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100text-center">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Code</th>
                          <th>Total Supply</th>
                          <th>Total Empty</th>
                          <th>Previous Bill</th>
                          <th>Current Bill</th>
                          <th>Paid Ammount</th>
                          <th>Total Bill</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $addby = $_SESSION['id'];
                        $sql = "SELECT 
                        c.`id`,
                        c.`name`,
                        c.`rate` as rate,
                        a.id as area_id,
                        sp.id as supplier_id,
                        SUM(s.`D`) as totalSupply,
                        SUM(s.`R`) as R,
                        SUM(s.`paid_ammount`) as Pay,
                        SUM(s.`rate` *s.`D`) as TotalCost
                    FROM 
                        `customer` c 
                    INNER JOIN 
                        `sale` s on c.`id` = s.`customer` 
                    INNER JOIN 
                        `area` a on c.`area` = a.`id` 
                    INNER JOIN 
                        `supplier` sp on c.`supplier` = sp.`id`
                    WHERE 
                        month(s.`created_at`) = $month 
                        AND year(s.`created_at`) = $year 
                        AND s.`addby` = $addby
                        AND c.area = $area_id
                        AND c.supplier = $supplier_id
                    GROUP BY 
                        c.`id`, c.`name`, c.`rate`, a.id, sp.id
                    ";
                        $result = mysqli_query($conn, $sql);
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                          $id = $row['id'];
                          $name = $row['name'];
                          $area_id = $row['area_id'];
                          $TotalCan = (int)$row['totalSupply'];
                          $supplier_id = $row['supplier_id'];
                        ?>
                          <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $name ?></td>
                            <td class="text-danger fw-bold"><?php echo $id ?></td>
                          <td><?php echo $TotalCan ?></td>
                          <td><?php
                          $sqlE = "SELECT sum(s.`D`) as D, sum(s.`R`) as R, s.`rate` as rate,sum(s.`paid_ammount`) as paid
                          FROM sale s
                          INNER JOIN `customer` c on s.customer = c.id
                              WHERE c.id = $id
                              AND MONTH(s.created_at) = MONTH(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH))
                              AND YEAR(s.created_at) = YEAR(DATE_ADD('$year-$month-01', INTERVAL -1 MONTH))";
                              $resultE=mysqli_query($conn,$sqlE);
                              $rowE = mysqli_fetch_array($resultE);

                           echo ((int)$TotalCan - (int)$row['R'])+((int)$rowE['D']-(int)$rowE['R']) ?></td>

                           <td><?php echo ((int)$rowE['D']*(int)$rowE['rate']) - (int)$rowE['paid'] ?></td>
                           
                           <td><?php echo ((int)$row['TotalCost']) ?></td>

                          <td><?php echo $row['Pay']?></td>
                          <td><?php echo ((int)$row['TotalCost']-(int)$row['Pay']) - ((int)$rowE['paid']-((int)$rowE['D']*(int)$rowE['rate']))?></td>

                        <td class="text-center">
                        <a href="BillList.php?id=<?php echo $id;?>&month=<?php echo $month;?>&year=<?php echo $year; ?>&rate=<?php echo $row['rate']?>">
                            <button type="button" name="edit" class="btn btn-success">View</button>
                          </a>
                          <a href="edit_BillList.php?id=<?php echo $id ?>&month=<?php echo $month;?>&year=<?php echo $year; ?>&rate=<?php echo $row['rate']?>">
                            <button type="button" name="edit" class="btn btn-primary">Edit</button>
                          </a>
                        </td>
                          </tr>
                        <?php
                          $count++;
                        } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- table End Here -->
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
  if (isset($_GET['Disbaleid'])) {

    $id = $_GET['Disbaleid'];
    $sql = "UPDATE `customer` SET `status`=0 WHERE `customer_id`= '$id'";

    $result = mysqli_query($conn, $sql);
    if ($result) {
      $status = 0;
      echo '<script>window.location.href="./manage_Costumer.php";</script>';
    }
  }
  if (isset($_GET['Enableid'])) {
    $id = $_GET['Enableid'];
    $sql = "UPDATE `customer` SET `status`=1 WHERE `customer_id`= ''$id";

    $result = mysqli_query($conn, $sql);
    if ($result) {
      $status = 1;
      echo '<script>window.location.href="./manage_Costumer.php";</script>';
    }
  }
}
?>