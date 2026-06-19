<?php
include "../include/session.php";
include "../include/connection.php";
$bill_id = $_POST['bill_id'];
$c_deliver = $_POST['can_deliver'];
$c_return_today = $_POST['can_return'];
$p_amount = $_POST['paid_amount'];
$p_date = $_POST['p_date'];

    if ($p_amount == 0) {

        $sqlUpdate = "UPDATE `sale` SET `D`='$c_deliver',`R`='$c_return_today',`paid_ammount`='0',
        `paid_ammount_date`= null WHERE `id` = '$bill_id'";

        mysqli_query($conn, $sqlUpdate);
    } else {

        $sqlUpdate = "UPDATE `sale` SET `D`='$c_deliver',`R`='$c_return_today',`paid_ammount`='$p_amount',
        `paid_ammount_date`= '$p_date' WHERE `id` = '$bill_id'";

        mysqli_query($conn, $sqlUpdate);
    }
    // $new_emp_can = 0;
    // echo $bill_id."else";
?>
