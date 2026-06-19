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

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100text-center table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Code</th>
                          <th>Contact</th>
                          <th>Can Rate</th>
                          <th>Area</th>
                          <th>Supplier</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $sql = "SELECT `id`,`name`,`contact`,`rate`,`area`,`supplier`,`status` FROM `customer` WHERE `addby` = '$id' ORDER BY `id` DESC";
                        $result = mysqli_query($conn, $sql);
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                          $id = $row['id'];
                          $name = $row['name'];
                          $contact = $row['contact'];
                          $can_rate = $row['rate'];
                          $area_id = $row['area'];
                          $supplier_id = $row['supplier'];
                          $status = $row['status'];

                        ?>
                          <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $name ?></td>
                            <td class="text-danger fw-bold"><?php echo $id ?></td>
                            <td><?php echo $contact ?></td>
                            <td><?php echo $can_rate ?></td>
                            <td>
                              <?php
                              $Areasql = "SELECT `name` FROM `area` WHERE `id`='$area_id'";
                              $Arearesult = mysqli_query($conn, $Areasql);
                              if (mysqli_num_rows($Arearesult) > 0) {
                                $row = mysqli_fetch_assoc($Arearesult);
                                echo $row['name'];
                              }
                              ?>
                            </td>
                            <td>
                              <?php
                              $Areasql = "SELECT `name` FROM `supplier` WHERE `id`='$supplier_id'";
                              $Arearesult = mysqli_query($conn, $Areasql);
                              if (mysqli_num_rows($Arearesult) > 0) {
                                $row = mysqli_fetch_assoc($Arearesult);
                                echo $row['name'];
                              }
                              ?>
                            </td>
                            <td class="text-center">
                              <?php
                              if ($status == 1) { ?>
                                <a href="manage_Costumer.php?Disbaleid=<?php echo $id ?>">
                                  <button type="button" name="disable" class="btn btn-danger">
                                    Disable
                                  </button>
                                </a>
                              <?php
                              } else {
                              ?>
                                <a href="manage_Costumer.php?Enableid=<?php echo $id ?>">
                                  <button type="button" name="enable" class="btn btn-success">
                                    Enable
                                  </button>
                                </a>
                              <?php
                              }
                              ?>
                              <a href="edit_Costumer.php?id=<?php echo $id ?>">
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
    $sql = "UPDATE `customer` SET `status`=0 WHERE `id`= '$id'";

    $result = mysqli_query($conn, $sql);
    if ($result) {
      $status = 0;
      echo '<script>window.location.href="./manage_Costumer.php";</script>';
    }
  }
  if (isset($_GET['Enableid'])) {
    $id = $_GET['Enableid'];
    $sql = "UPDATE `customer` SET `status`=1 WHERE `id`= '$id'";

    $result = mysqli_query($conn, $sql);
    if ($result) {
      $status = 1;
      echo '<script>window.location.href="./manage_Costumer.php";</script>';
    }
  }
}
?>