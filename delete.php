<?php

include 'db_connection.php';

try {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Fetch the file path from the database
        $query = "SELECT `file` FROM candidates WHERE `id` = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $file = $stmt->fetchColumn();

        if ($file) {
            // Define the path to the file
            $filePath = $file;

            // Delete the file if it exists
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Prepare the delete query
        $query = "DELETE FROM candidates WHERE `id` = :id";
        $stmt = $conn->prepare($query);

        // Bind the id parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Failed to delete the record']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID parameter is missing']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn = null;
exit;
?>