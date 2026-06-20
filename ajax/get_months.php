<?php
include "../include/connection.php";
if (isset($_GET['year']) && is_numeric($_GET['year'])) {
    $year = mysqli_real_escape_string($conn, $_GET['year']);
    
    // Distinct months fetch karein
    $sqlMonth = "SELECT DISTINCT MONTHNAME(created_at) AS month_name, MONTH(created_at) AS month_num 
                 FROM sale 
                 WHERE YEAR(created_at) = '$year' 
                 ORDER BY month_num DESC";
                 
    $resultMonth = mysqli_query($conn, $sqlMonth);
    
    if (mysqli_num_rows($resultMonth) > 0) {
        while ($rowMonth = mysqli_fetch_assoc($resultMonth)) {
            echo '<option value="'. $rowMonth['month_num'] .'">'. $rowMonth['month_name'] .'</option>';
        }
    } else {
        echo '<option disabled>No records</option>';
    }
}
?>