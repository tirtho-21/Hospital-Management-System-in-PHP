<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('includes/connection.php');
if(isset($_REQUEST['login']))
{
    $username = mysqli_real_escape_string($connection,$_REQUEST['username']);
    $pwd = mysqli_real_escape_string($connection,$_REQUEST['pwd']);
    
    $fetch_query = mysqli_query($connection, "select * from tbl_employee where username ='$username' and password = '$pwd'");
    if(!$fetch_query) {
        die("Query failed: " . mysqli_error($connection));
    }
    $res = mysqli_num_rows($fetch_query);
    if($res>0)
    {
        $data = mysqli_fetch_array($fetch_query);
        $name = $data['first_name'].' '.$data['last_name'];
        $role = $data['role'];
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;
        header('location:dashboard.php');
        exit;
    }
    else
    {
        $msg = "Incorrect login details.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- login23:11-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>HMS - Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/gradient-styles.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
			<div class="account-center">
				<div class="account-box">
                    <form method="post" class="form-signin">
						<div class="account-logo">
                            <a href="index.php"><img src="assets/img/logo-dark.png" alt=""></a>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" autofocus="" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pwd" required>
                        </div>
                        <?php if(!empty($msg)){ ?>
                        <div class="alert alert-danger">
                            <?php echo $msg; ?>
                        </div>
                        <?php } ?>
                        <div class="form-group text-center">
                            <button type="submit" name="login" class="btn btn-primary account-btn">Login</button>
                        </div>
                    </form>
                </div>
			</div>
        </div>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>


<!-- login23:12-->
</html>