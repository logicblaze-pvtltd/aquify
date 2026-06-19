<?php
include "../include/session.php";
include "../include/connection.php";
$s_id = $_POST['supplier_id'];
$sql = "SELECT a.name as area,a.id AS area_id FROM `assign_area` aa INNER JOIN `area` a ON aa.area = a.id WHERE aa.supplier = '$s_id'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
    $a_name = $row['area'];
    $a_id = $row['area_id'];

    echo "<option hidden>Choose Area</option>";
    echo "<option value='".$a_id."'>".$a_name."</option>";
}
?>