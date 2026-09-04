<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('includes/connection.php');

$error = "";
$success = "";

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $pwd = mysqli_real_escape_string($connection, $_POST['pwd']);
    
    echo "Attempting login with username: " . $username . "<br>";
    
    // Test database connection
    if (!$connection) {
        $error = "Database connection failed: " . mysqli_connect_error();
    } else {
        $query = "SELECT * FROM tbl_employee WHERE username = '$username' AND password = '$pwd'";
        echo "Executing query: " . $query . "<br>";
        
        $fetch_query = mysqli_query($connection, $query);
        
        if (!$fetch_query) {
            $error = "Query failed: " . mysqli_error($connection);
        } else {
            $res = mysqli_num_rows($fetch_query);
            echo "Rows returned: " . $res . "<br>";
            
            if ($res > 0) {
                $data = mysqli_fetch_array($fetch_query);
                $name = $data['first_name'] . ' ' . $data['last_name'];
                $role = $data['role'];
                
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;
                
                $success = "Login successful! Welcome, $name (Role: $role)";
                echo "Session values set - Name: " . $_SESSION['name'] . ", Role: " . $_SESSION['role'] . "<br>";
                echo "In a normal flow, you would be redirected to dashboard.php now.<br>";
            } else {
                $error = "Incorrect login details.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 30px;
            background-color: #f5f5f5;
        }
        .login-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Login Test</h2>
            
            <?php if($error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <?php if($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="pwd" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
            </form>
            
            <div class="mt-3">
                <a href="index.php" class="btn btn-secondary btn-sm">Back to Main Login</a>
                <a href="db_test.php" class="btn btn-info btn-sm float-right">Test Database Connection</a>
            </div>
        </div>
    </div>
</body>
</html> 