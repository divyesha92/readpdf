<?php
include 'db_connection.php';

// Fetch data from the database
$query = "SELECT `id`, `name`, `email`, `mobile`, `skills`, `carrier`, `file`, `created_at` FROM `candidates`";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
echo json_encode($data);
?>