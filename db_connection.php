<?php
$dbhost = "localhost";
$dbusername = "root"; // Replace with your database username
$dbpassword = ""; // Replace with your database password
$dbname = "readpdf"; // Replace with your database name

try {
    // Create connection
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    die();
}
?>
