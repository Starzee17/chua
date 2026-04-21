
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
    $sql = "SELECT file_path FROM videos WHERE id = ?";
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
        $delete_sql = "DELETE FROM videos WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
    }

    header('Location: manage-videos.php');
    exit();
}

// Fetch all videos
$sql = "SELECT * FROM videos ORDER BY uploaded_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Videos - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            background: white;
            padding: 2rem;
            border-radius: 10px;
        }
        .video-item {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }
        .video-player {
            background: #000;
        }
        .video-player video {
            width: 100%;
            height: 200px;
        }
        .video-info {
            padding: 1.5rem;
        }
        .video-info h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        .video-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.875rem;
            color: #666;
            margin: 1rem 0;
        }
        .video-actions {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Manage Videos</h1>
                <a href="upload-video.php" class="btn-primary">Upload New Video</a>
            </div>

            <div class="video-grid">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="video-item">
                            <div class="video-player">
                                <video controls>
                                    <source src="<?php echo htmlspecialchars($row['file_path']); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="video-info">
                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                <p style="color: #666; font-size: 0.9rem;">
                                    <?php echo htmlspecialchars(substr($row['description'], 0, 100)); ?>
                                    <?php echo strlen($row['description']) > 100 ? '...' : ''; ?>
                                </p>
                                <div class="video-meta">
                                    <span>📅 <?php echo date('M d, Y', strtotime($row['uploaded_date'])); ?></span>
                                    <span>👁️ <?php echo $row['views']; ?> views</span>
                                </div>
                                <div class="video-actions">
                                    <a href="<?php echo $row['file_path']; ?>" class="btn-secondary" download>Download</a>
                                    <a href="?delete=<?php echo $row['id']; ?>"
                                       class="btn-secondary"
                                       style="background-color: var(--danger-color);"
                                       onclick="return confirm('Are you sure you want to delete this video?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center; padding: 2rem; color: #666; grid-column: 1/-1;">No videos found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
