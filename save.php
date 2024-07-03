<?php

include 'db_connection.php';

if ($_REQUEST['type'] == 'add') {
    // Sample data
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $mobile = $_REQUEST['mobile'];
    $skills = $_REQUEST['skills'];
    $carrier = $_REQUEST['carrier'];
    $data = $_REQUEST['data'];
    $file = $_REQUEST['file'];
    $upload_from = 'Form';
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    $targetPath = str_replace('/temp', '/resume', $file);

    // Insert data into the table
    $sql = 'INSERT INTO `candidates` (`name`, `email`, `mobile`, `skills`, `carrier`, `data`, `file`, `upload_from`, `created_at`, `updated_at`) VALUES (:name, :email, :mobile, :skills, :carrier, :data, :file, :upload_from, :created_at, :updated_at)';

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':skills', $skills);
    $stmt->bindParam(':carrier', $carrier);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':file', $targetPath);
    $stmt->bindParam(':upload_from', $upload_from);
    $stmt->bindParam(':created_at', $created_at);
    $stmt->bindParam(':updated_at', $updated_at);

    if ($stmt->execute()) {
        // Move the uploaded file to the specified directory with the new name
        rename($file, $targetPath);
        echo json_encode(['status' => 'success', 'message' => 'New record created successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->errorInfo()[2]]);
    }

    // Close statement and connection
    $stmt->closeCursor();
} else {
    $id = $_REQUEST['id'];
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $mobile = $_REQUEST['mobile'];
    $skills = $_REQUEST['skills'];
    $carrier = $_REQUEST['carrier'];

    try {
        // Prepare the update query
        $query = "UPDATE candidates SET name = :name, email = :email, mobile = :mobile, skills = :skills, carrier = :carrier WHERE id = :id";
        $stmt = $conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $stmt->bindParam(':skills', $skills, PDO::PARAM_STR);
        $stmt->bindParam(':carrier', $carrier, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        echo json_encode(['status' => 'success', 'message' => 'Record updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }    
}

$conn = null;
exit;
?>