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
            
                $stmtSelect->bind_param("ii",$uid,$uid);
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
                        }else{
                            if ($password == $row['password']) {
                                // $days = (38 - (int)$rowSelect['days']);
                                if($rowSelect['days'] <= 0){
                                    $stmtStatus = $conn->prepare("UPDATE `users` SET `status` = 2 WHERE `id` = ?");
                                    $stmtStatus->bind_param("i", $uid);
                                    if (!$stmtStatus->execute()) {
                                        error_log("Error updating status: " . $stmtStatus->error);
                                    }else{
                                        echo '<script>alert("'.$_SESSION['days'].'");</script>';
                                        echo '<script>alert("Your account has been Disalbled Due to pending Payment");window.location.href="./login.php";</script>';
                                    }
                                }else{
                                $_SESSION['id'] = $uid;
                                $_SESSION['days'] =  $rowSelect['days'];
                                $_SESSION['name'] = $row['name'];
                                $_SESSION['email'] = $row['email'];
                                $_SESSION['role'] = $row['role'];
                                $_SESSION['contact'] = $row['contact'];
                                $_SESSION['status'] = 0;
                                $_SESSION['image'] = $row['profile'];
                                echo '<script>alert("'.$_SESSION['days'].'");</script>';

                                header('location:index.php');
                                exit();
                                }
                            } else {
                                echo '<script>alert("Invalid Credentials");window.location.href="./login.php";</script>';
                            }
                        }
                    }else{
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
            } else{
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
                    <img src="assets/images/logo.png" alt="Logo">
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
                <p>© <script>document.write(new Date().getFullYear())</script> Designed & Developed with <i class="bi bi-heart-fill"></i> by <a href="<?php echo (defined('APP_URL') ? APP_URL : 'http://localhost/aquify'); ?>"><?php echo (defined('APP_NAME') ? APP_NAME : 'Aquify'); ?></a></p>
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
