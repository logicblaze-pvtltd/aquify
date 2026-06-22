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

                if ($row['status'] != 0) {

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
                    <svg style="height: auto; width:50px;" xmlns="http://www.w3.org/2000/svg" id="Layer_2" data-name="Layer 2" viewBox="0 0 467.68 602.55">
                        <defs>
                            <style>
                                .cls-1 {
                                    fill: #0077b6;
                                }
                            </style>
                        </defs>
                        <path class="cls-1" d="M316.29,47.14S144,237.43,110.57,317.14c-6.7,16-14.72,30.36-19.18,47.46a226.36,226.36,0,0,0,.4,114.4,222,222,0,0,0,24.83,57.91c18.63,30.65,44.3,56.8,73.76,77.26-6.26-4.35-11.49-16.36-15.17-22.91A197.06,197.06,0,0,1,163,565.38a204.12,204.12,0,0,1-12.88-55.67,197.46,197.46,0,0,1,3.22-57c1.85-8.93,3.05-15.13,3.18-24,.56-40.27,15.54-80.17,36.33-114.18,0,0,95.14-127.28,123.43-150.43l47.57,54S229,285.67,179.57,420.94c0,0-65.58,197.06,118.07,226.2,0,0,115.07,27.43,209.36-97.71,0,0-129.67,101.17-240-12-56.15-57.6-25-132.2,19.35-185.91a453.37,453.37,0,0,1,44.15-46.2c13-11.82,28.19-27.91,44.41-34.82,28.56-12.17,66.45-17.93,96.72-9.17,9.49,2.74,18.42,7.89,24.33,15.95-23.52-39.68-49.88-77.82-77.8-114.51C387,121.88,353.47,82.65,316.29,47.14Z" transform="translate(-84.24 -47.14)" />
                        <path class="cls-1" d="M551.88,420.22c-.66,31.95-9.74,64.09-28.75,89.15-19.5,25.71-47.27,44.57-77.93,54.35a170.62,170.62,0,0,1-51.77,8c-48.16,0-91.29-19.84-120.28-51.13a130.65,130.65,0,0,0,103.62,12.08c55-16.75,95.09-68.91,95.09-130.66a132.64,132.64,0,0,0-19.39-68.78c-13.4-22.07-31.9-36.54-51.77-52.16,29.47-14.63,67.19-7.18,93.24,11.07,26.31,18.43,43.87,47.5,52,78.22A180.5,180.5,0,0,1,551.88,420.22Z" transform="translate(-84.24 -47.14)" />
                        <path class="cls-1" d="M402,280.42c-.57.22-1.13.45-1.7.69-.51-.28-1-.55-1.54-.81C399.83,280.32,400.91,280.37,402,280.42Z" transform="translate(-84.24 -47.14)" />
                        <path class="cls-1" d="M315,371.14c-5.07,16.32-13.82,31.12-23.23,45.27-7.26,10.91-12.79,19.66-13.41,33.38,0,0-.22,36,34.93,40.92,0,0,37.92-1.28,41.14-34.92,2.39-25-17.87-44.21-30.25-63.6C321.43,387.88,313.14,377.12,315,371.14Z" transform="translate(-84.24 -47.14)" />
                    </svg>
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
                        <svg class="login-input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M21 8L17.4392 9.97822C15.454 11.0811 14.4614 11.6326 13.4102 11.8488C12.4798 12.0401 11.5202 12.0401 10.5898 11.8488C9.53864 11.6326 8.54603 11.0811 6.5608 9.97822L3 8M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V15.8C3 16.9201 3 17.4802 3.21799 17.908C3.40973 18.2843 3.71569 18.5903 4.09202 18.782C4.51984 19 5.07989 19 6.2 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </div>
                </div>

                <div class="login-field-wrapper">
                    <label class="login-field-label">Password</label>
                    <div class="login-input-container">
                        <input type="password" class="login-custom-input" name="password" id="login-password" placeholder="••••••••" required>
                        <svg class="login-input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M12 14.5V16.5M7 10.0288C7.47142 10 8.05259 10 8.8 10H15.2C15.9474 10 16.5286 10 17 10.0288M7 10.0288C6.41168 10.0647 5.99429 10.1455 5.63803 10.327C5.07354 10.6146 4.6146 11.0735 4.32698 11.638C4 12.2798 4 13.1198 4 14.8V16.2C4 17.8802 4 18.7202 4.32698 19.362C4.6146 19.9265 5.07354 20.3854 5.63803 20.673C6.27976 21 7.11984 21 8.8 21H15.2C16.8802 21 17.7202 21 18.362 20.673C18.9265 20.3854 19.3854 19.9265 19.673 19.362C20 18.7202 20 17.8802 20 16.2V14.8C20 13.1198 20 12.2798 19.673 11.638C19.3854 11.0735 18.9265 10.6146 18.362 10.327C18.0057 10.1455 17.5883 10.0647 17 10.0288M7 10.0288V8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8V10.0288" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                        <button class="login-eye-btn" type="button" id="login-password-toggle">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12S5.5 5 12 5s10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" />
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                            </svg>
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
                <svg style="height: auto; width:20px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.5609 10.7381L20.2109 9.15812C19.9609 8.85812 19.7509 8.29813 19.7509 7.89813V6.19812C19.7509 5.13812 18.8809 4.26812 17.8209 4.26812H16.1209C15.7209 4.26812 15.1509 4.05813 14.8509 3.80812L13.2709 2.45812C12.5809 1.86813 11.4509 1.86813 10.7609 2.45812L9.16086 3.80812C8.86086 4.05813 8.30086 4.26812 7.90086 4.26812H6.17086C5.11086 4.26812 4.24086 5.13812 4.24086 6.19812V7.89813C4.24086 8.28813 4.04086 8.84812 3.79086 9.14812L2.44086 10.7381C1.86086 11.4381 1.86086 12.5581 2.44086 13.2381L3.79086 14.8281C4.04086 15.1181 4.24086 15.6881 4.24086 16.0781V17.7881C4.24086 18.8481 5.11086 19.7181 6.17086 19.7181H7.91086C8.30086 19.7181 8.87086 19.9281 9.17086 20.1781L10.7509 21.5281C11.4409 22.1181 12.5709 22.1181 13.2609 21.5281L14.8409 20.1781C15.1409 19.9281 15.7009 19.7181 16.1009 19.7181H17.8009C18.8609 19.7181 19.7309 18.8481 19.7309 17.7881V16.0881C19.7309 15.6881 19.9409 15.1281 20.1909 14.8281L21.5409 13.2481C22.1509 12.5681 22.1509 11.4381 21.5609 10.7381ZM11.2509 8.12813C11.2509 7.71813 11.5909 7.37813 12.0009 7.37813C12.4109 7.37813 12.7509 7.71813 12.7509 8.12813V12.9581C12.7509 13.3681 12.4109 13.7081 12.0009 13.7081C11.5909 13.7081 11.2509 13.3681 11.2509 12.9581V8.12813ZM12.0009 16.8681C11.4509 16.8681 11.0009 16.4181 11.0009 15.8681C11.0009 15.3181 11.4409 14.8681 12.0009 14.8681C12.5509 14.8681 13.0009 15.3181 13.0009 15.8681C13.0009 16.4181 12.5609 16.8681 12.0009 16.8681Z" fill="currentColor"></path> </g></svg> Looking for bill inquiry?
                <a href="inquiry.php">Click Here</a>
            </div>

            <!-- Footer Copy -->
            <div class="login-footer-copy">
                <p>© <script>
                        document.write(new Date().getFullYear())
                    </script> Designed & Developed with <i class="bi bi-heart-fill"></i> by <a href="https://logicblaze.co">LogicBlaze Technologies
        </div>
    </div>

    <?php include "./include/footer_link.php" ?>
    <script>
        // Toggle loader overlay
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('login-loader').style.display = 'flex';
        });

        // Toggle eye icon class for premium feel
        document.getElementById('login-password-toggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('login-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';

                this.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                    <path d="M4 10C4 10 5.6 15 12 15M12 15C18.4 15 20 10 20 10M12 15V18M18 17L16 14.5M6 17L8 14.5"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>`;
            } else {
                passwordInput.type = 'password';

                this.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 12S5.5 5 12 5s10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" />
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                </svg>`;
            }
        });

    </script>
</body>

</html>