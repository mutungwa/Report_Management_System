<!-- File List Section (Updated with View, Download, and Delete Buttons) -->
<div class="card mt-4">
    <div class="card-body">
        <h4 class="card-title">Your Documents</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Document Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display user's documents from the database
                $user_id = $_SESSION['user_id'];
                $conn = new mysqli('localhost', 'username', 'password', 'your_database');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, filename FROM documents WHERE user_id = '$user_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $document_id = $row['id'];
                        $document_filename = $row['filename'];

                        echo '<tr>';
                        echo '<td>' . $document_filename . '</td>';
                        echo '<td>';
                        echo '<a href="view_document.php?document_id=' . $document_id . '" class="btn btn-info">View</a>';
                        echo '<a href="download.php?document_id=' . $document_id . '" class="btn btn-success">Download</a>';
                        echo '<a href="delete.php?document_id=' . $document_id . '" class="btn btn-danger ml-2">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">No documents found.</td></tr>';
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
