<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
  echo '<script>window.location.href="./login.php";</script>';
} else {
  $assign_id = $_GET['id'];
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
                  <h4 class="mb-sm-0 font-size-18">Edit Assign Area</h4>

                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item active">Edit Assign Area</li>

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
                    <h4 class="card-title">Edit Area List</h4>
                    <form action="#" method="POST">
                      <div class="row my-4">
                        <div class="col">
                          <?php
                          $sql = "SELECT * FROM `assign_area` INNER JOIN `area` ON `assign_area`.area_id = `area`.id WHERE `assign_area`.id = $assign_id";
                          $result = mysqli_query($conn, $sql);
                          if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                          ?>
                            <div class="form mb-3">
                              <input type="text" name="area_name" class="form-control" value="<?php echo $row['area_name'] ?>" placeholder="Enter Name" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0;" readonly>
                            </div>
                          <?php
                          }
                          ?>
                        </div>
                        <div class="col">
                          <select class="form-select" name="supplier_id" aria-label="Default select example" style="border: none;border-bottom: 2px solid #556ee6;border-radius:0; outline:none;">
                            <?php
                            $sql = "SELECT * FROM `assign_area` INNER JOIN `area` ON `assign_area`.area_id = `area`.id INNER JOIN supplier ON `assign_area`.`supplier_id` = `supplier`.id WHERE `assign_area`.id = $assign_id";

                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                              $assignSupRow = mysqli_fetch_assoc($result);
                            ?>
                              <option hidden value="<?php echo  $assignSupRow['id'] ?>">
                                <?php echo  $assignSupRow['full_name'] ?></option>
                              <?php
                            }
                            $supplierSql = "SELECT * FROM `supplier`";
                            $supplierResult = mysqli_query($conn, $supplierSql);
                            if (mysqli_num_rows($supplierResult) > 0) {
                              while ($row = mysqli_fetch_assoc($supplierResult)) {
                                if ($assignSupRow['full_name'] != $row['full_name']) {
                              ?>
                                  <option value="<?php echo $row['id'] ?>"><?php echo $row['full_name'] ?></option>
                            <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row text-center mt-2">
                        <div>
                          <button type="submit" name="update" class="btn btn-primary w-md">Update</button>
                        </div>
                      </div>
                    </form>
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
  if (isset($_POST['update'])) {
    $area_id = $_POST['area_id'];
    $supplier_id = $_POST['supplier_id'];
    echo $area_id;
    $sql = "UPDATE `assign_area` SET `supplier_id`= '$supplier_id' WHERE `id` = $assign_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      echo '<script>alert("Updated Successfully");window.location.href="./manage_AssignArea.php";</script>';
    }
  }
}
?>