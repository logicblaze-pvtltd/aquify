<head>

    <!-- Dark Mode Flash Prevention Script -->
    <script>
        (function() {
            var savedMode = sessionStorage.getItem("is_visited");
            var isDark = savedMode === "dark-mode-switch" || (!savedMode && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
            var mode = isDark ? "dark" : "light";
            
            document.documentElement.setAttribute("data-layout-mode", mode);
            var observer = new MutationObserver(function(mutations, obs) {
                var body = document.querySelector('body');
                if (body) {
                    body.setAttribute("data-layout-mode", mode);
                    obs.disconnect();
                }
            });
            observer.observe(document.documentElement, { childList: true, subtree: true });
        })();
    </script>

    <meta charset="utf-8" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon_io/apple-touch-icon.png">

    <?php
    if (isset($_SESSION['id']) && $_SESSION['role'] == "retailer") {
    ?>
        <title>
            <?php echo $_SESSION['name'] . ' - Dashboard'; ?>
        </title>
    <?php
    } else {
    ?>
        <title>
            <?php echo (defined('APP_NAME') ? APP_NAME : 'Aquify') . ' - Water Management System'; ?>
        </title>
    <?php
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Custom Css override (loaded last) -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Preloader Skeleton Injector -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var preloader = document.getElementById("preloader");
            // Skip if page has a custom skeleton (e.g. inquiry page)
            if (preloader && !preloader.getAttribute("data-skeleton-type")) {
                preloader.innerHTML = `
                    <div class="skeleton-container">
                        <div class="skeleton-sidebar">
                            <div class="skeleton-logo"></div>
                            <div class="skeleton-item" style="width: 80%"></div>
                            <div class="skeleton-item" style="width: 60%"></div>
                            <div class="skeleton-item" style="width: 70%"></div>
                            <div class="skeleton-item" style="width: 85%"></div>
                            <div class="skeleton-item" style="width: 50%"></div>
                        </div>
                        <div class="skeleton-content">
                            <div class="skeleton-header">
                                <div class="skeleton-button" style="width: 100px"></div>
                                <div class="skeleton-avatar"></div>
                            </div>
                            <div class="skeleton-body">
                                <div class="skeleton-title" style="width: 200px; height: 32px"></div>
                                <div class="skeleton-row">
                                    <div class="skeleton-card"></div>
                                    <div class="skeleton-card"></div>
                                    <div class="skeleton-card"></div>
                                    <div class="skeleton-card"></div>
                                </div>
                                <div class="skeleton-table">
                                    <div class="skeleton-table-header"></div>
                                    <div class="skeleton-table-row"></div>
                                    <div class="skeleton-table-row"></div>
                                    <div class="skeleton-table-row"></div>
                                    <div class="skeleton-table-row"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        });
    </script>
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