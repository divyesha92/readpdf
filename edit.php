<?php

include 'db_connection.php';

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

    // Fetch data from the database
    $query = "SELECT `id`, `name`, `email`, `mobile`, `skills`, `carrier`, `data`, `file`, `created_at` FROM `candidates` WHERE `id` = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if 'file' key exists and replace it with 'pdf'
	if (isset($data['file'])) {
	    $data['pdf'] = $data['file'];
	    unset($data['file']);
	}

    $data['type'] = 'update';
    $data['status'] = 'success';
    $data['massage'] = 'Fetching candidate details';
    // echo '<pre>';print_r($data);exit;
    // Return the data as JSON
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'ID parameter is missing']);
}

$conn = null;
exit;
?>