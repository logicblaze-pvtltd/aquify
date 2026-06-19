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
                  <h4 class="mb-sm-0 font-size-18">Supplier</h4>

                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item active">Manage Supplier</li>

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
                    <h4 class="card-title">Manage Supplier</h4>
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100text-center">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $id = $_SESSION['id'];
                        $sql = "SELECT `id`,`name`,`status` FROM `area` WHERE `addby` = '$id'";
                        $result = mysqli_query($conn, $sql);
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                          $id = $row['id'];
                          $name = $row['name'];
                          $status = $row['status'];
                        ?>
                          <tr class="text-center">
                            <td><?php echo $count ?></td>
                            <td><?php echo $name ?></td>
                            <td>
                              <?php
                              if ($status == 1) { ?>
                                <span class="badge bg-success">Assigned</span>
                              <?php
                              }
                              if ($status == 0) { ?>
                                <span class="badge bg-warning">Not Assigned</span>
                              <?php
                              }
                              ?>
                            </td>
                            <td>
                              <a href='manage_Area.php?deleteid=<?php echo $id ?>'>
                                <button type="button" class="btn btn-danger" name="delete">
                                  Delete
                                </button>
                              </a>
                              <a href='edit_area.php?id=<?php echo $id ?>'>
                                <button type="button" class="btn btn-primary">
                                  Edit
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
  if (isset($_GET['deleteid'])) {

    $id = $_GET['deleteid'];
    $sql = "DELETE FROM `area` WHERE `id`='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      echo '<script>window.location.href="./manage_Area.php";</script>';
    }
  }
}
?>