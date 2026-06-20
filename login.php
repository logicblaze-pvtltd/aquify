<?php
include "include/session.php";
include "include/connection.php";

if (isset($_SESSION['id'])) {
    header('location:index.php');
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['username'];
    $password = $_POST['password'];
    $days = 0;
    if (empty($email) || empty($password)) {
        echo '<script>alert("All fields are required!!");window.location.href="./login.php";</script>';
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $uid = $row['id'];

            if ($row['role'] == 'retailer') {

                if ($row['stauts'] != 0) {

                    $stmtSelect = $conn->prepare("SELECT 
                    DATEDIFF(CURDATE(), p.created_at) AS days
                        FROM 
                            payment p
                        INNER JOIN 
                            users u ON p.user = u.id
                        WHERE 
                            p.user = ?
                            AND 
                            p.id = (SELECT MAX(id) FROM payment WHERE user = ?);
                        ");

                    $stmtSelect->bind_param("ii", $uid, $uid);
                    $stmtSelect->execute();
                    $resultSelect = $stmtSelect->get_result();

                    if ($resultSelect) {
                        $rowSelect = $resultSelect->fetch_assoc();
                        // Check if the days value is greater than 30 or set to 999 (indicating no payment found)
                        if ($rowSelect['days'] >= 30 || $rowSelect['days'] == 999) {
                            $stmtStatus = $conn->prepare("UPDATE `users` SET `status` = 0 WHERE `id` = ?");
                            $stmtStatus->bind_param("i", $uid);
                            if (!$stmtStatus->execute()) {
                                error_log("Error updating status: " . $stmtStatus->error);
                            } else {
                                if ($password == $row['password']) {
                                    // $days = (38 - (int)$rowSelect['days']);
                                    if ($rowSelect['days'] <= 0) {
                                        $stmtStatus = $conn->prepare("UPDATE `users` SET `status` = 2 WHERE `id` = ?");
                                        $stmtStatus->bind_param("i", $uid);
                                        if (!$stmtStatus->execute()) {
                                            error_log("Error updating status: " . $stmtStatus->error);
                                        } else {
                                            echo '<script>alert("' . $_SESSION['days'] . '");</script>';
                                            echo '<script>alert("Your account has been Disalbled Due to pending Payment");window.location.href="./login.php";</script>';
                                        }
                                    } else {
                                        $_SESSION['id'] = $uid;
                                        $_SESSION['days'] =  $rowSelect['days'];
                                        $_SESSION['name'] = $row['name'];
                                        $_SESSION['email'] = $row['email'];
                                        $_SESSION['role'] = $row['role'];
                                        $_SESSION['contact'] = $row['contact'];
                                        $_SESSION['status'] = 0;
                                        $_SESSION['image'] = $row['profile'];
                                        echo '<script>alert("' . $_SESSION['days'] . '");</script>';

                                        header('location:index.php');
                                        exit();
                                    }
                                } else {
                                    echo '<script>alert("Invalid Credentials");window.location.href="./login.php";</script>';
                                }
                            }
                        } else {
                            if ($password == $row['password']) {
                                $_SESSION['id'] = $uid;
                                $_SESSION['days'] = $rowSelect['days'];
                                $_SESSION['name'] = $row['name'];
                                $_SESSION['email'] = $row['email'];
                                $_SESSION['role'] = $row['role'];
                                $_SESSION['contact'] = $row['contact'];
                                $_SESSION['status'] = $row['status'];
                                $_SESSION['image'] = $row['profile'];
                                header('location:index.php');
                                exit();
                            } else {
                                echo '<script>alert("Invalid Credentials");window.location.href="./login.php";</script>';
                            }
                        }
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo '<script>alert("Your Account is not active yet Please contact the Aquify Team");window.location.href="./login.php";</script>';
                }
            } else {
                if ($password == $row['password']) {
                    $_SESSION['id'] = $uid;
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['contact'] = $row['contact'];
                    $_SESSION['status'] = $row['status'];
                    $_SESSION['image'] = $row['profile'];
                    header('location:index.php');
                    exit();
                } else {
                    echo '<script>alert("Invalid Credentials");window.location.href="./login.php";</script>';
                }
            }
        } else {
            echo '<script>alert("Account Not Registered");window.location.href="./login.php";</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php include "./include/head_links.php" ?>
</head>

<body class="login-body-bg">
    <!-- Login Loader Overlay -->
    <div id="login-loader" style="display: none;">
        <div class="login-spinner-container">
            <div class="login-spinner"></div>
            <p class="login-loader-text">Logging in, please wait...</p>
        </div>
    </div>

    <!-- Ambient Animated Background Blobs -->
    <div class="login-bg-blobs">
        <div class="login-blob login-blob-1"></div>
        <div class="login-blob login-blob-2"></div>
        <div class="login-blob login-blob-3"></div>
    </div>

    <!-- Centralized Card Wrapper -->
    <div class="login-flex-container">
        <div class="login-glass-card">
            <!-- Theme Toggle Button -->
            <!-- <button id="login-theme-toggle" class="login-theme-toggle-btn" type="button">
                <i class="bi bi-moon"></i>
            </button>
             -->
            <!-- Branding Section -->
            <div class="login-brand-header">
                <div class="login-logo-ring">
                    <svg style="height: auto; width:50px;" xmlns="http://www.w3.org/2000/svg" id="Layer_2" data-name="Layer 2" viewBox="0 0 467.68 602.55"><defs><style>.cls-1{fill:#0077b6;}</style></defs><path class="cls-1" d="M316.29,47.14S144,237.43,110.57,317.14c-6.7,16-14.72,30.36-19.18,47.46a226.36,226.36,0,0,0,.4,114.4,222,222,0,0,0,24.83,57.91c18.63,30.65,44.3,56.8,73.76,77.26-6.26-4.35-11.49-16.36-15.17-22.91A197.06,197.06,0,0,1,163,565.38a204.12,204.12,0,0,1-12.88-55.67,197.46,197.46,0,0,1,3.22-57c1.85-8.93,3.05-15.13,3.18-24,.56-40.27,15.54-80.17,36.33-114.18,0,0,95.14-127.28,123.43-150.43l47.57,54S229,285.67,179.57,420.94c0,0-65.58,197.06,118.07,226.2,0,0,115.07,27.43,209.36-97.71,0,0-129.67,101.17-240-12-56.15-57.6-25-132.2,19.35-185.91a453.37,453.37,0,0,1,44.15-46.2c13-11.82,28.19-27.91,44.41-34.82,28.56-12.17,66.45-17.93,96.72-9.17,9.49,2.74,18.42,7.89,24.33,15.95-23.52-39.68-49.88-77.82-77.8-114.51C387,121.88,353.47,82.65,316.29,47.14Z" transform="translate(-84.24 -47.14)"/><path class="cls-1" d="M551.88,420.22c-.66,31.95-9.74,64.09-28.75,89.15-19.5,25.71-47.27,44.57-77.93,54.35a170.62,170.62,0,0,1-51.77,8c-48.16,0-91.29-19.84-120.28-51.13a130.65,130.65,0,0,0,103.62,12.08c55-16.75,95.09-68.91,95.09-130.66a132.64,132.64,0,0,0-19.39-68.78c-13.4-22.07-31.9-36.54-51.77-52.16,29.47-14.63,67.19-7.18,93.24,11.07,26.31,18.43,43.87,47.5,52,78.22A180.5,180.5,0,0,1,551.88,420.22Z" transform="translate(-84.24 -47.14)"/><path class="cls-1" d="M402,280.42c-.57.22-1.13.45-1.7.69-.51-.28-1-.55-1.54-.81C399.83,280.32,400.91,280.37,402,280.42Z" transform="translate(-84.24 -47.14)"/><path class="cls-1" d="M315,371.14c-5.07,16.32-13.82,31.12-23.23,45.27-7.26,10.91-12.79,19.66-13.41,33.38,0,0-.22,36,34.93,40.92,0,0,37.92-1.28,41.14-34.92,2.39-25-17.87-44.21-30.25-63.6C321.43,387.88,313.14,377.12,315,371.14Z" transform="translate(-84.24 -47.14)"/></svg>
                </div>
                <h4 class="login-title-primary">Welcome to <span><?php echo (defined('APP_NAME') ? APP_NAME : 'Aquify'); ?></span></h4>
                <p class="login-subtitle-secondary">Water Management System - Sign In</p>
            </div>

            <!-- Form -->
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="login-field-wrapper">
                    <label for="username" class="login-field-label">Username / Email</label>
                    <div class="login-input-container">
                        <input type="email" class="login-custom-input" name="username" id="username" placeholder="name@example.com" required>
                        <i class="bi bi-envelope login-input-icon"></i>
                    </div>
                </div>

                <div class="login-field-wrapper">
                    <label class="login-field-label">Password</label>
                    <div class="login-input-container">
                        <input type="password" class="login-custom-input" name="password" id="login-password" placeholder="••••••••" required>
                        <i class="bi bi-lock login-input-icon"></i>
                        <button class="login-eye-btn" type="button" id="password-addon">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="login-remember-container">
                    <label class="login-checkbox-label" for="remember-check">
                        <input class="login-checkbox-input" type="checkbox" id="remember-check">
                        Remember me
                    </label>
                </div>

                <button class="login-submit-btn" type="submit" name="login">Log In</button>
            </form>

            <!-- Bill Inquiry Alert Box -->
            <div class="login-inquiry-box">
                <i class="bi bi-info-circle-fill me-1"></i> Looking for bill inquiry?
                <a href="inquiry.php">Click Here</a>
            </div>

            <!-- Footer Copy -->
            <div class="login-footer-copy">
                <p>© <script>
                        document.write(new Date().getFullYear())
                    </script> Designed & Developed with <i class="bi bi-heart-fill"></i> by <a href="<?php echo (defined('APP_URL') ? APP_URL : 'http://localhost/aquify'); ?>"><?php echo (defined('APP_NAME') ? APP_NAME : 'Aquify'); ?></a></p>
            </div>
        </div>
    </div>

    <?php include "./include/footer_link.php" ?>
    <script>
        // Toggle loader overlay
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('login-loader').style.display = 'flex';
        });

        // Toggle eye icon class for premium feel
        document.getElementById('password-addon').addEventListener('click', function() {
            var icon = this.querySelector('i');
            if (icon.classList.contains('bi-eye')) {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Theme Toggle Script
        (function() {
            var themeToggleBtn = document.getElementById('login-theme-toggle');
            var themeIcon = themeToggleBtn.querySelector('i');

            function updateToggleIcon() {
                var currentMode = document.documentElement.getAttribute('data-layout-mode');
                if (currentMode === 'dark') {
                    themeIcon.className = 'bi bi-sun';
                } else {
                    themeIcon.className = 'bi bi-moon';
                }
            }

            // Set initial state
            updateToggleIcon();

            // themeToggleBtn.addEventListener('click', function() {
            //     var currentMode = document.documentElement.getAttribute('data-layout-mode');
            //     var targetMode = (currentMode === 'dark') ? 'light' : 'dark';

            //     document.documentElement.setAttribute('data-layout-mode', targetMode);
            //     document.body.setAttribute('data-layout-mode', targetMode);
            //     sessionStorage.setItem('is_visited', targetMode + '-mode-switch');
            //     updateToggleIcon();
            // });
        })();
    </script>
</body>

</html>