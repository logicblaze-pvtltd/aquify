<?php
include "../include/connection.php";

if (isset($_POST['area_id'])) {
    
    $area_id = $_POST['area_id'];
    $supplier_id = $_POST['supplier_id'];
    $curr_date = $_POST['p_date'];

    $sql = "SELECT * FROM `customer` WHERE `area_id`='$area_id' AND `supplier_id`='$supplier_id'";
    $result = mysqli_query($conn, $sql);
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['customer_id'];
        $name = $row['customer_name'];
        $sqlBill = "SELECT * FROM `bill_record` WHERE `customer_id` = '$id' AND `created_at` = '$curr_date'";
        $resultBill = mysqli_query($conn, $sqlBill);
        while ($rowBill = mysqli_fetch_assoc($resultBill)) {
            echo '<tr>
            <td class="bg-gradient bg-info bg-opacity-10 customer_id'.$id.'">' . $id . '</td>
            <td class="bg-gradient bg-info bg-opacity-10">' . $name . '</td>
            <td class="bg-gradient bg-info bg-opacity-10 can_rate'.$id.'">' . $rowBill['can_rate'] . '</td>
            <td class="bg-gradient bg-info bg-opacity-10">0</td>
            <td><input type="number" style="background: transparent; border: none; width:100%;" value="' . $rowBill['can_deliver'] . '" class="can_deliver'.$id.'" onkeyup="getD_id('.$id.')"></td>
            <td><input type="number" style="background: transparent; border: none; width:100%;" value="' . $rowBill['can_return'] . '" class="can_return'.$id.'"  onkeyup="getR_id('.$id.')"></td>
            <td class="bg-gradient bg-info bg-opacity-10 empty_can'.$id.'">' . $rowBill['empty_can'] . '</td>
            <td class="bg-gradient bg-info bg-opacity-10 total_can'.$id.'">' . $rowBill['total_can'] . '</td>
            <td class="bg-gradient bg-info bg-opacity-10 total_bill'.$id.'">' . $rowBill['total_bill'] . '</td>
            <td class="bg-gradient bg-info bg-opacity-10 previous_bill'.$id.'">' . $rowBill['previous_bill'] . '</td>
            <td><input type="number" style="background: transparent; border: none; width:100%;" value="' . $rowBill['paid_ammount'] . '" class="paid_amount'.$id.'" onkeyup="paid_bill('.$id.')"></td>
            <td class="bg-gradient bg-info bg-opacity-10 current_bill'.$id.'">' . $rowBill['current_bill'] . '</td>
        </tr>';
        }
    }
}
