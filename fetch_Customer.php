<?php
include "./include/session.php";
include "./include/connection.php";

if (isset($_POST['submit'])) {
    $id = $_SESSION['id'];
    $date = $_POST['date'];
    $area = $_POST['area'];
    $supplier = $_POST['supplier'];
    $area_id = (int)$_POST['area_id'];
    $supplier_id = (int)$_POST['supplier_id'];
    // return echo $date;
    $sql = "SELECT `id`, `rate` FROM customer WHERE `area` = ? AND `supplier` = ? AND `status` = 1";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $area_id, $supplier_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $cId = $row['id'];
            $rate = $row['rate'];

            $sqlCheck = "SELECT id FROM sale WHERE customer = ? AND created_at = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            if ($stmtCheck === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmtCheck->bind_param("is", $cId, $date);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();
            $stmtCheck->close();

            if ($resultCheck->num_rows > 0) {
                // Record already exists; skip insertion
                continue;
            }else{

                
                $sqlInsert = "INSERT INTO `sale` (`customer`, `rate`, `created_at`, `addby`) VALUES (?, ?, ?, ?)";
                $stmtInsert = $conn->prepare($sqlInsert);
                if ($stmtInsert === false) {
                    die("Prepare failed: " . $conn->error);
                }
                
                $stmtInsert->bind_param("iisi", $cId, $rate, $date, $id);
                $stmtInsert->execute();
                $stmtInsert->close();
            }
        }
        $result->free();

        header('Location: Supply_table.php?date=' . $date . '&area=' . $area . '&supplier=' . $supplier . '&a_id=' . $area_id . '&supplier_id=' . $supplier_id);
        exit();
    } else {
        die("Query failed: " . $conn->error);
    }
}
