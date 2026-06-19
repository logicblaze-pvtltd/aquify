<?php
include "./include/connection.php";
if (isset($_POST['submit'])) {
    $id = $_POST['uid'];
    $can  = $_POST['can_deliver'];
    $return = $_POST['can_return'];
    $days = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $paid = $_POST['paid'];
    $sqldate = array();
    print_r($paid);
    $sqlSelect = "SELECT `created_at` FROM `sale` WHERE `customer` = '$id' AND MONTH(`created_at`) = '$month' AND YEAR(`created_at`) = '$year'";
    $result = mysqli_query($conn, $sqlSelect);
    
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            // Store the dates as DateTime objects
            $sqldate[] = new DateTime($row['created_at']);
        }
    }

    // Now iterate and print dates for each day from $_POST.
    foreach ($days as $key => $day) {
        // Create a DateTime object for the current day
        $date = new DateTime("$year-$month-$day");

        // Test against all sql dates
        foreach ($sqldate as $sqld) {
            if ($sqld->format('d-m-Y') === $date->format('d-m-Y')) {
                echo "Match";
                $D = $can[$key];
                $R = $return[$key];
                $P = $paid[$key];
                $sqlDate = $date->format('Y-m-d');
                if($P == 0){
                    $sql = "UPDATE `sale` SET `D` = $D, `R` = $R,`paid_ammount` = 0,`paid_ammount_date` = null WHERE `customer` = $id AND `created_at` = '$sqlDate'";
                    // echo $sql . '<br>'; // print the SQL statement
    
                    $result = mysqli_query($conn, $sql);
                    // show rows affected
                    if ($result) {
                    }
                }else{
                    $sql = "UPDATE `sale` SET `D` = $D, `R` = $R,`paid_ammount` = $P,`paid_ammount_date` = '$sqlDate' WHERE `customer` = $id AND `created_at` = '$sqlDate'";
                    // echo $sql . '<br>'; // print the SQL statement
    
                    $result = mysqli_query($conn, $sql);
                    // show rows affected
                    if ($result) {
                        
                    }
                }
               
            }
        }
    }
    header('location:edit_BillList.php?id='.$id.'&month='.$month.'&year='.$year);
}
?>
