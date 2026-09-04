<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$server = "localhost";
$username = "root";
$password = "";
$database = "hms_db";

// Test connection
echo "<h2>Testing Database Connection</h2>";

// Connect without database selection first
$connection = mysqli_connect($server, $username, $password);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected to MySQL server successfully.<br>";

// Check if database exists
$db_check = mysqli_select_db($connection, $database);
if (!$db_check) {
    die("Database '$database' does not exist or cannot be selected: " . mysqli_error($connection));
}
echo "Selected database '$database' successfully.<br>";

// Test query
$test_query = mysqli_query($connection, "SELECT COUNT(*) as count FROM tbl_employee");
if (!$test_query) {
    die("Query failed: " . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($test_query);
echo "Number of employees in database: " . $row['count'] . "<br>";

echo "<h3>Database Connection Test Completed Successfully</h3>";
?> 