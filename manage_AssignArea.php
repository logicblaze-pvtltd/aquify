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
                  <h4 class="mb-sm-0 font-size-18">Manage Assign Area</h4>

                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item active">Manage Assign Area</li>

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
                    <h4 class="card-title">Asign Area List</h4>
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100text-center">
                      <thead>
                        <tr>
                          <th>Serial Number</th>
                          <th>Area</th>
                          <th>Supplier</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $area_id = 0;
                        $sql = "SELECT a.name as area,a.id as area_id, s.name as supplier, aa.id FROM `assign_area` as aa INNER JOIN `area` a ON aa.area = a.id INNER JOIN supplier s ON
                        aa.`supplier` = s.id WHERE s.status = 1 and aa.addby =$id";
                        $result = mysqli_query($conn, $sql);
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                          $id = $row['id'];
                          $area_id = $row['area_id'];
                          $Areaname = $row['area'];
                          $SupplierName = $row['supplier'];
                        ?>
                          <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $Areaname ?></td>
                            <td><?php echo $SupplierName; ?></td>
                            <td class="text-center">
                              <a href='edit_AssignArea.php?id=<?php echo $id ?>'>
                                <button type="button" class="btn btn-primary">
                                  Edit
                                </button>
                              </a>
                              <a href='manage_AssignArea.php?delete=<?php echo $id ?>&area=<?php echo $area_id ?>'>
                                <button type="button" name="delete" class="btn btn-danger">
                                  Delete
                                </button>
                              </a>
                            </td>
                          </tr>
                        <?php
                          $count++;
                        }
                        ?>
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
  if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $area = $_GET['area'];
    $areaupdate = "UPDATE `area` SET `status`= 0 WHERE `id`= '$area'";
    $areaUpdateResult = mysqli_query($conn, $areaupdate);
    $sql = "DELETE FROM `assign_area` WHERE `id`='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result && $areaUpdateResult) {
      echo '<script>window.location.href="./manage_AssignArea.php";</script>';
    }
  }
}
?>