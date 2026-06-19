<?php
include "./include/session.php";
include "./include/connection.php";

if (!isset($_SESSION['id'])) {
  echo '<script>window.location.href="./login.php";</script>';
  exit();
}
$addby = $_SESSION['id'];
$date = isset($_GET['date']) ? mysqli_real_escape_string($conn, $_GET['date']) : '';
$supplier = isset($_GET['supplier']) ? mysqli_real_escape_string($conn, $_GET['supplier']) : '';
$area = isset($_GET['area']) ? mysqli_real_escape_string($conn, $_GET['area']) : '';
$area_id = isset($_GET['a_id']) ? intval($_GET['a_id']) : 0;
$supplier_id = isset($_GET['supplier_id']) ? intval($_GET['supplier_id']) : 0;
$curr_date = date('Y-m-d', strtotime($date));
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
                <h4 class="mb-sm-0 font-size-18">Supply Entry Page</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Entry Page</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <form action="fetch_Customer.php" method="POST">
                    <input type="submit" class="btn btn-primary" value="Fetch Costumer" name="submit">
                    <input type="hidden" name="date" value="<?php echo $curr_date ?>">
                    <input type="hidden" name="area_id" value="<?php echo $area_id ?>">
                    <input type="hidden" name="supplier_id" value="<?php echo $supplier_id ?>">
                    <input type="hidden" name="area" value="<?php echo $area ?>">
                    <input type="hidden" name="supplier" value="<?php echo $supplier ?>">
                  </form>
                </div>
                <div class="card-body table-responsive">
                  <div class="d-flex justify-content-between mb-4 border-top border-bottom alert alert-warning" role="alert">
                    <h5>Supplier: <strong><?php echo htmlspecialchars($supplier); ?></strong></h5>
                    <h5>Area: <strong><?php echo htmlspecialchars($area); ?></strong></h5>
                    <p id="date">
                      Displaying data of: <strong><?php echo date('Y-F-d', strtotime($date)); ?></strong>
                    </p>
                  </div>
                  <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                      <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Can Rate</th>
                        <th>Pre Empty Can</th>
                        <th>Delivery</th>
                        <th>Return</th>
                        <th>Empty Can</th>
                        <th>Total Can</th>
                        <th>Total Bill</th>
                        <th>Previous Bal</th>
                        <th>Paid Amount</th>
                        <th>Current Bal</th>
                      </tr>
                    </thead>
                    <input type="hidden" value="<?php echo $area_id; ?>" id="area_id">
                    <input type="hidden" value="<?php echo $supplier_id; ?>" id="supplier_id">
                    <p id="paid_date" hidden><?php echo $curr_date; ?></p>
                    <li id="newDate" hidden><?php echo $newDate = date('Y-m-d', strtotime($date . '+1 days')); ?></li>
                    <!-- <form action="#" method="POST"> -->
                      <tbody>
                        <?php
                        $sql = "SELECT s.*,c.id as customer,c.name,c.rate from `customer` c inner join `sale` s on c.`id`=s.`customer` where `area` =$area_id and `supplier`=$supplier_id and s.`created_at` ='$curr_date' and c.`status` = 1 AND c.`addby` = '$addby'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['customer'];
                            $name = $row['name'];

                        ?>
                            <tr>
                              <input type="hidden" id="bill_id<?php echo $id ?>" name="bill_id<?php echo $id ?>" value="<?php echo $row['id'] ?>">
                              <td class="bg-gradient bg-info bg-opacity-10 customer_id<?php echo $id ?>"><?php echo $id ?></td>
                              <td class="bg-gradient bg-info bg-opacity-10"><?php echo htmlspecialchars($name); ?></td>
                              <td class="bg-gradient bg-info bg-opacity-10 can_rate<?php echo $id ?>"><?php echo $row['rate'] ?></td>
                              <td class="bg-gradient bg-info bg-opacity-10 pre_empty_can<?php echo $id ?>">
                                <?php
                                $Sql_empty_can = "SELECT sum(`D`) as D,sum(
                                    `R`) as R,sum(`paid_ammount`) as Pay
                                                                      FROM `sale`
                                                                      Where customer = $id;
                                  ";
                                $result_empty_can = mysqli_query($conn, $Sql_empty_can);
                                $row_empty_can = mysqli_fetch_assoc($result_empty_can);
                                echo (int)$row_empty_can['D'] - (int)$row_empty_can['R'];
                                // echo (int)$row_empty_can['D'];
                                ?>
                              </td>
                              <td>
                                <input type="number" style="background: transparent; border: none; width:100%;" value="<?php echo $row['D'] ?>" class="can_deliver<?php echo $id ?>" onkeyup="getD_id(<?php echo $id ?>)"></td>
                              <td><input type="number" style="background: transparent; border: none; width:100%;" value="<?php echo $row['R'] ?>" class="can_return<?php echo $id ?>" onkeyup="getR_id(<?php echo $id ?>)"></td>
                              <td class="bg-gradient bg-info bg-opacity-10 empty_can<?php echo $id ?>">0</td>
                              <td class="bg-gradient bg-info bg-opacity-10 total_can<?php echo $id ?>">
                                <?php
                                $month = date('m', strtotime($date));
                                $year = date('Y', strtotime($date));
                                $T_can = "SELECT sum(`D`) as Tc, `rate` FROM `sale`
                                Where customer = $id AND MONTH(`created_at`) = $month AND YEAR(`created_at`) = $year";
                                                                      $T_result = mysqli_query($conn,$T_can);
                                                                      $T_can_row = mysqli_fetch_array($T_result);
                                                                      echo (int)$T_can_row['Tc'];
                                ?>
                              </td>
                              <p class="t_can<?php echo $id ?>" hidden>
                                <?php
                                echo (int)$T_can_row['Tc'];
                                ?>
                              </p>
                              <td class="bg-gradient bg-info bg-opacity-10 total_bill<?php echo $id ?>">0</td>
                              <td class="bg-gradient bg-info bg-opacity-10 previous_bill<?php echo $id ?>"><?php 
                               $T = "SELECT SUM(`D` * `rate`) AS TotalCost
                               FROM `sale`
                               WHERE `customer` = $id;";
                                                                     $T_result = mysqli_query($conn,$T);
                                                                     $T_row = mysqli_fetch_array($T_result);
                              echo (int)$T_row['TotalCost'] - (int)$row_empty_can['Pay'] ?></td>
                              <td><input type="number" style="background: transparent; border: none; width:100%;" value="<?php echo $row['paid_ammount'] ?>" class="paid_amount<?php echo $id ?>" onkeyup="paid_bill(<?php echo $id ?>)"></td>
                              <td class="bg-gradient bg-info bg-opacity-10 p_current_bill<?php echo $id ?>" hidden>
                                <?php echo (int)$row_empty_can['D'] * $row['rate'] ?>
                              </td>
                              <td class="bg-gradient bg-info bg-opacity-10 current_bill<?php echo $id ?>">
                                <?php echo  $T_row['TotalCost'] - $row_empty_can['Pay'] ?>
                              </td>
                            </tr>
                        <?php

                          }
                        }
                        ?>
                      </tbody>
                    <!-- </form> -->
                  </table>
                </div>
              </div>
            </div> <!-- end col -->
          </div>
          <!-- table Start Here -->
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
    <script>
      function getD_id(id) {
        var can_deliver = parseInt($(".can_deliver" + id).val(), 10);
        var total_can = parseInt($(".total_can" + id).text(), 10);
        var can_rate = parseInt($(".can_rate" + id).text(), 10);
        var previous_bill = parseInt($(".previous_bill" + id).text(), 10);
        var paid_amount = parseInt($(".paid_amount" + id).val(), 10);
        var t_can = parseInt($(".t_can" + id).text(), 10);
        var p_curr_bill = parseInt($(".p_current_bill" + id).text(), 10);
        var total_bill = (can_rate * can_deliver);

        if (!isNaN(total_can) && !isNaN(total_bill)) {
          var new_total_can = t_can + can_deliver;
          $(".total_can" + id).text(new_total_can);
          $(".total_bill" + id).text(total_bill);
          $(".current_bill" + id).html((total_bill + previous_bill) - paid_amount);
        }
        getR_id(id);
        sql_entry(id);
      }

      function getR_id(id) {
        var can_deliver = parseInt($(".can_deliver" + id).val(), 10);
        var can_return = parseInt($(".can_return" + id).val(), 10);
        var pre_empty_can = parseInt($(".pre_empty_can" + id).text(), 10);
        var empty_can = pre_empty_can + can_deliver - can_return;
        if (!isNaN(empty_can)) {
          $(".empty_can" + id).html(empty_can);
        }
        // console.log(empty_can);
        sql_entry(id);
        //  console.log("Today empty can"+empty_can);
      }

      function paid_bill(id) {
        var previous_bill = parseInt($(".previous_bill" + id).text(), 10);
        var paid_amount = parseInt($(".paid_amount" + id).val(), 10);
        var can_rate = parseInt($(".can_rate" + id).text(), 10);
        var can_deliver = parseInt($(".can_deliver" + id).val(), 10);
        var total_bill = can_rate * can_deliver;

        if (!isNaN(paid_amount)) {
          $(".current_bill" + id).html((total_bill + previous_bill) - paid_amount);
        }
        sql_entry(id);
      }

      function sql_entry(id) {
        var can_deliver = parseInt($(".can_deliver" + id).val(), 10);
        var can_return = parseInt($(".can_return" + id).val(), 10);
        var can_rate = parseInt($(".can_rate" + id).text(), 10);
        var empty_can = $(".empty_can" + id).text();
        var total_bill = $(".total_bill" + id).text();
        var total_can = parseInt($(".total_can" + id).text(), 10);
        var previous_bill = parseInt($(".previous_bill" + id).text(), 10);
        var paid_amount = parseInt($(".paid_amount" + id).val(), 10);
        var current_bill = parseInt($(".current_bill" + id).text(), 10);
        var p_date = $('#paid_date').html();
        var bill_id = $('#bill_id' + id).val();
        // console.log(empty_can);
        $.ajax({
          type: "POST",
          url: "ajax/update_supply.php",
          data: {
            bill_id: bill_id,
            can_deliver: can_deliver,
            can_return: can_return,
            paid_amount: paid_amount,
            p_date: p_date,
          }
        }).done(function(msg) {
          console.log(msg);
        });
      }
    </script>
</body>

</html>