<?php
include "./include/session.php";
include "./include/connection.php";
if (!isset($_SESSION['id'])) {
  echo '<script>window.location.href="./login.php";</script>';
}
if(isset($_GET['Disbaleid'])){
  
  $id = $_GET['Disbaleid'];
  $sql = "UPDATE `users` SET `status`= 0 WHERE id='$id' ";
  $result = mysqli_query($conn,$sql);
  if($result){
    $status= 0;
    echo '<script>window.location.href="./manage_Retailer.php";</script>';
  }
}
if(isset($_GET['Enableid'])){
  $id = $_GET['Enableid'];
  $sql = "UPDATE `users` SET `status`= 1 WHERE id='$id' ";
  $result = mysqli_query($conn,$sql);
  if($result){
    $status= 1;
    echo '<script>window.location.href="./manage_Retailer.php";</script>';
  }
}
$sql = "SELECT p.`id`,p.`name`,p.`ammount`,count(u.id) as users FROM `package` p inner join `users` u on p.id = u.package";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
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
                  <h4 class="mb-sm-0 font-size-18">Package</h4>

                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item active">Manage Package</li>

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
                    <h4 class="card-title">Manage Retailer</h4>
                      <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100text-center">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Ammount</th>
                            <th>Users</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          $count = 1;
                          while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $ammount = $row['ammount'];
                          ?>
                            <tr>
                              <td><?php echo $count?></td>
                              <td><?php echo $name ?></td>
                              <td><?php echo $ammount ?></td>
                              <td class="text-center">
                              <?php echo $row['users'] ?>
                              </td>
                              <td>
                              <span class="badge rounded-pill badge-soft-success font-size-12" id="task-status">Enable</span>
                              </td>
                              <td>
                                <a href="edit_Package.php?id=<?php echo $id ?>" class="btn btn-info">
                                  Edit
                                </a>
                              </td>
                              
                            </tr>
                          <?php
                          $count ++;

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

} else {
  echo "NoRecords!";
}
?>