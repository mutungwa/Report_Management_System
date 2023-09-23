<?php
// Handle document deletion logic
if (isset($_GET['document_id'])) {
    $document_id = $_GET['document_id'];

    // Connect to your database (replace with your database connection logic)
    $conn = new mysqli('localhost', 'username', 'password', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Implement proper validation and authorization to ensure the user has permission to delete the document
    // You can use session variables or user roles/permissions for this

    // Fetch the document's filename and path for deletion
    $sql = "SELECT filename, filepath FROM documents WHERE id = $document_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $document_filename = $row['filename'];
        $document_path = $row['filepath'];

        // Delete the document record from the database
        $sql_delete = "DELETE FROM documents WHERE id = $document_id";
        if ($conn->query($sql_delete) === TRUE) {
            // Delete the actual file from the server (uncomment the following line)
            // unlink($document_path);
            
            // Redirect back to the dashboard or document list
            header("Location: dashboard.php");
        } else {
            echo "Error deleting document from the database: " . $conn->error;
        }
    } else {
        echo "Document not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
