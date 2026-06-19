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
<body>
    <div style="width: 30px; height: 200px; background-color: #3498db; transform: rotate(45deg); position: absolute; margin-top:-5%;"></div>
    <div style="width: 30px; height: 300px; background-color: #001F3F; transform: rotate(45deg); position: absolute; margin-top:-5%"></div>
    <div class="account-pages my-1 pt-sm-5">
        <div class="container">
            <h2 class="text-center"><span>For Bill Inquiry</span> <a href="inquiry.php">Click Here</a></h2>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow rounded-4">
                        <div class="bg-primary bg-soft rounded-4">
                            <div class="row">
                                <div class="col-8">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome Back to <strong class="form-footer-text">LogicBlaze</strong>  Water Management System</h5>
                                        <p>Log in to your account.</p>
                                    </div>
                                </div>
                                <div class="col-4 align-self-end">
                                    <img src="assets/images/login-image.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="#" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle">
                                            <img src="assets/images/logo.png" alt="" class="rounded-circle" height="75">
                                        </span>
                                    </div>
                                </a>
                                <a href="#" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="assets/images/logo.png" alt="" class="rounded-circle" height="75">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <div class="mb-3">
                                        <label for="username" class="form-label"><strong>Username</strong></label>
                                        <input type="email" class="form-control" name="username" id="username" placeholder="Enter username" style="border-radius:0px; border:none; border-bottom:2px solid blue; outline:none;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" ><strong>Password</strong></label>
                                        <div class="input-group auth-pass-input-group">
                                            <input type="password" class="form-control" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" style="border-radius:0px; border:none; border-bottom:2px solid blue; outline:none;">
                                            <button class="btn btn-light" type="button" id="password-addon" style="border-radius:0px; border:none; border-bottom:2px solid blue; background:transparent; color:white"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col form-check ms-2">
                                            <input class="form-check-input" type="checkbox" id="remember-check" style="background-color: transparent; border: 1px solid white;">
                                            <label class="form-check-label" for="remember-check" style="color:white;">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit" name="login">Log In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <div>
                            <p>© <script>document.write(new Date().getFullYear())</script> Designed & Developed with  <i class="bi bi-heart-fill text-danger"></i> by <a href=""><strong class="form-footer-text">LogicBlaze</strong></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "./include/footer_link.php" ?>
</body>
</html>
