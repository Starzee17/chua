
<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Get file path
    $sql = "SELECT file_path FROM modules WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc();
        // Delete file
        if (file_exists($file['file_path'])) {
            unlink($file['file_path']);
        }

        // Delete from database
        $delete_sql = "DELETE FROM modules WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
    }

    header('Location: manage-modules.php');
    exit();
}

// Fetch all modules
$sql = "SELECT * FROM modules ORDER BY uploaded_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Modules - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .table-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: var(--primary-color);
            color: white;
        }
        .action-btn {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-delete {
            background-color: var(--danger-color);
            color: white;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Manage Modules</h1>
                <a href="upload-module.php" class="btn-primary">Upload New Module</a>
            </div>

            <div class="table-container">
                <?php if ($result && $result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>File Type</th>
                                <th>Views</th>
                                <th>Upload Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($row['description'], 0, 100)); ?>...</td>
                                    <td><?php echo strtoupper($row['file_type']); ?></td>
                                    <td><?php echo $row['views']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['uploaded_date'])); ?></td>
                                    <td>
                                        <a href="<?php echo $row['file_path']; ?>" class="action-btn btn-secondary" target="_blank">View</a>
                                        <a href="?delete=<?php echo $row['id']; ?>"
                                           class="action-btn btn-delete"
                                           onclick="return confirm('Are you sure you want to delete this module?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; padding: 2rem; color: #666;">No modules found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
