<head>

    <meta charset="utf-8" />
    <?php
    if (isset($_SESSION['id']) && $_SESSION['role'] == "retailer") {
    ?>
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/<?php echo $_SESSION['image'] ?>">
        <title>
            <?php echo $_SESSION['name'] . ' - Dashboard';
            ?>
        </title><?php
            } else { ?>
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo.png">
        <title>
            <?php
                echo 'LogicBlaze - Water Management System';

            ?></title>
    <?php
            }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Calender -->

    <link href="assets/libs/%40fullcalendar/core/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/%40fullcalendar/daygrid/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/%40fullcalendar/bootstrap/main.min.css" rel="stylesheet" type="text/css" />
    <!-- tui charts Css -->
    <!-- <link href="assets/libs/tui-chart/tui-chart.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- Alert -->
    <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->
</head>