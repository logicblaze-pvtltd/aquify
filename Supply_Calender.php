<?php
include "./include/session.php";
include "./include/connection.php";

if (!isset($_SESSION['id'])) {
    echo '<script>window.location.href="./login.php";</script>';
    exit;
}

if (isset($_POST['area'])) {
    $area = $_POST['area'];
    $supplier = $_POST['supplier'];
    $area_id = $_POST['a_id'];
    $supplier_id = $_POST['supplier_id'];
} else {
    $area = $_SESSION['area'];
    $supplier = $_SESSION['supplier'];
    $area_id = $_SESSION['a_id'];
    $supplier_id = $_SESSION['supplier_id'];
}

$_SESSION['area'] = $area;
$_SESSION['supplier'] = $supplier;
$_SESSION['a_id'] = $area_id;
$_SESSION['supplier_id'] = $supplier_id;

date_default_timezone_set('Asia/Karachi');

if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    $ym = date('Y-m');
}

$timestamp = strtotime($ym . "-01");
if ($timestamp === false) {
    $timestamp = time();
}

$date = date('Y-m-d', $timestamp);
$today = date('Y-m-d', time());
$html_title = date('Y', $timestamp);
$html_title_month = date('F', $timestamp);

$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));
$day_count = date('t', $timestamp);
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

$weeks = array();
$week = '';
$week .= str_repeat("<td></td>", $str);

for ($day = 1; $day <= $day_count; $day++, $str++) {
    $date = $ym . '-' . $day;
    if ($today == $date) {
        $week .= "<td class='bg-today text-white text-center'><a href='Supply_table.php?date=$date&area=$area&supplier=$supplier&a_id=$area_id&supplier_id=$supplier_id' class='text-white'>$day</a></td>";
    } else {
        $week .= "<td class='bg-light text-center'><a href='Supply_table.php?date=$date&area=$area&supplier=$supplier&a_id=$area_id&supplier_id=$supplier_id' class='text-dark'>$day</a></td>";
    }

    if ($str % 7 == 6 || $day == $day_count) {
        if ($day == $day_count) {
            $week .= str_repeat("<td></td>", 6 - ($str % 7));
        }
        $weeks[] = "<tr>$week</tr>";
        $week = '';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <?php include "./include/head_links.php"; ?>
    <style>
        td {
            height: 100px;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .bg-today {
            background-color: green !important;
        }
    </style>
</head>
<body data-sidebar="dark">

    <div id="layout-wrapper">
        <?php include "./include/Navbar.php"; ?>
        <?php include "./include/Left_Side_Bar.php"; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Supply</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Supplier List <span> <i class="fas fa-angle-double-right"></i> </span> Supply Calendar</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="d-flex justify-content-between my-2">
                                                    <div class="btn-group">
                                                        <a href="?ym=<?php echo $prev; ?>" class="btn btn-primary"><i class="fa fa-chevron-left"></i></a>
                                                        <button class="btn btn-primary"><?php echo $html_title_month; ?></button>
                                                        <a href="?ym=<?php echo $next; ?>" class="btn btn-primary"><i class="fa fa-chevron-right"></i></a>
                                                    </div>
                                                    <button class="btn btn-primary"><?php echo $html_title; ?></button>
                                                </div>

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Sun</th>
                                                            <th>Mon</th>
                                                            <th>Tue</th>
                                                            <th>Wed</th>
                                                            <th>Thu</th>
                                                            <th>Fri</th>
                                                            <th>Sat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($weeks as $week) echo $week; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>

                            <!-- Add New Event Modal -->
                            <div class="modal fade" id="event-modal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header py-3 px-4 border-bottom-0">
                                            <h5 class="modal-title" id="modal-title">Event</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Event Name</label>
                                                            <input class="form-control" placeholder="Insert Event Name" type="text" name="title" id="event-title" required />
                                                            <div class="invalid-feedback">Please provide a valid event name</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Category</label>
                                                            <select class="form-control form-select" name="category" id="event-category">
                                                                <option selected> --Select-- </option>
                                                                <option value="bg-danger">Danger</option>
                                                                <option value="bg-success">Success</option>
                                                                <option value="bg-primary">Primary</option>
                                                                <option value="bg-info">Info</option>
                                                                <option value="bg-dark">Dark</option>
                                                                <option value="bg-warning">Warning</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select a valid event category</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger" id="btn-delete-event">Delete</button>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal -->
                        </div>
                    </div>
                </div> 
            </div> 
            <?php include "./include/Footer.php"; ?>
        </div>
    </div>

    <?php include "./include/Rght_Side_Bar.php"; ?>
    <div class="rightbar-overlay"></div>
    <?php include "./include/footer_link.php"; ?>

    <script>
        // Form validation
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();

        // AJAX event handler for form submission
        $('#form-event').on('submit', function(event) {
            event.preventDefault();
            // Add your AJAX call here to save event data
            // On success, close modal and refresh calendar or update dynamically
            $('#event-modal').modal('hide');
        });

        $('#btn-delete-event').on('click', function() {
            // Add your AJAX call here to delete event data
            // On success, close modal and refresh calendar or update dynamically
            $('#event-modal').modal('hide');
        });
    </script>
</body>
</html>
<?php
?>
