<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
  echo '<script>window.location.href="./login.php";</script>';
}
if(isset($_GET['Disbaleid'])){
  
  $id = $_GET['Disbaleid'];
  $sql = "UPDATE `supplier` SET `status`= 0 WHERE id='$id' ";
  $result = mysqli_query($conn,$sql);
  if($result){
    $status= 0;
    echo '<script>window.location.href="./manage_Supplier.php";</script>';
  }
}
if(isset($_GET['Enableid'])){
  $id = $_GET['Enableid'];
  $sql = "UPDATE `supplier` SET `status`= 1 WHERE id='$id' ";
  $result = mysqli_query($conn,$sql);
  if($result){
    $status= 1;
    echo '<script>window.location.href="./manage_Supplier.php";</script>';
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
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          $count = 1;
                          $addby = $_SESSION['id'];
$sql = "SELECT `id`,`name`,`contact`,`status` FROM `supplier` WHERE `addby` = $addby ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $contact = $row['contact'];
                            $status = $row['status'];
                          ?>
                            <tr>
                              <td><?php echo $count?></td>
                              <td><?php echo $name ?></td>
                              <td><?php echo $contact ?></td>
                              <td class="text-center">
                              <?php
                                if ($status == 1) { ?>
                                <span class="badge bg-success">Active</span>
                                <?php
                                } if($status == 0){?>
                                <span class="badge bg-warning">Not Active</span>
                                <?php
                                }
                                ?>
                              </td>
                              <td class="text-center">
                                <?php
                                if ($status == 1) { ?>
                                <a href="manage_Supplier.php?Disbaleid=<?php echo $id?>">
                                  <button type="button" name="disable" class="btn btn-danger">
                                    Disable
                                  </button>
                                </a>
                                <?php
                                } else {
                                ?>
                                <a href="manage_Supplier.php?Enableid=<?php echo $id?>">
                                  <button type="button" name="enable" class="btn btn-success">
                                    Enable
                                  </button>
                                </a>
                                <?php
                                }
                                ?>
                                <a href='edit_Supplier.php?id=<?php echo $id?>'>
                                  <button type="button" class="btn btn-primary">
                                    Edit
                                  </button>
                                </a>
                              </td>

                            </tr>
                          <?php
                          $count ++;
                              }
                          }else{
                            ?>
                            <tr>
                              <td class="text-danger text-center" colspan="5">
                                No Result Found!!
                              </td>
                            </tr>
                            <?php
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