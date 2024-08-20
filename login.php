<?php
session_start();
error_reporting(0);
include("dbconnection.php");

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists and is active
    $ret = mysqli_query($con, "SELECT * FROM user_detail WHERE username='$username' AND password='$password'");
    $num = mysqli_num_rows($ret);

    if($num > 0) {
        $row = mysqli_fetch_array($ret);

        // Check if the user is active
        if($row['is_active'] == 'Active') {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['user_type_id'] = $row['user_type_id'];
            
            $user_type_id = $row['user_type_id'];
            
            if($user_type_id == 1) {
                header("location: super_admin/dashboard.php");
            } elseif($user_type_id == 2) {
                header("location: sub_admin/dashboard.php");
            } elseif($user_type_id == 3) {
                header("location: technician/dashboard.php");
            } elseif($user_type_id == 4) {
                header("location: customer/dashboard.php");
            }
            exit();
        } else { 

            $_SESSION['errmsg'] = "Your account is Inactive. Please contact the Admin.";
        }
    } else {
        $_SESSION['errmsg'] = "Invalid Username or Password";
    }
}

$logout_msg = "";
if (isset($_GET['status']) && $_GET['status'] == 'logout_success') {
    $logout_msg = " Logged Out Successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCMS | Login</title>
    <link href="Watch-Guard-Tech-Logo.png" rel="icon">
    <link rel="stylesheet" href="login.css">
</head>
<body>


<?php include_once('navbar.php'); ?> <hr>

<div class="breadcrumb-section">
    <div class="containerr">
        <h1>Login</h1>
        <nav class="breadcrumb">
            <a href="index.php">Home</a>
            <strong> / </strong>
            <span>Login</span>
        </nav>
    </div>
</div> 

 <div class="container" style="margin-left: 450px;">
    <h2>Login</h2> <hr style="margin-bottom: 15px;">
     
    <?php if ($logout_msg): ?>
        <span class="alertsuccess" style= "color: green;"><?php echo $logout_msg; ?></span>
    <?php endif; ?>

    <span class="alert"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
    <form method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
        <!-- <div class="form-group checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div> -->
        <button type="submit" class="btn" name="submit">Login</button>
    </form>
</div>

<?php include_once('footer.php'); ?>


</body>
</html>
