
<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Get statistics
$modules_count = $conn->query("SELECT COUNT(*) as count FROM modules")->fetch_assoc()['count'];
$pictures_count = $conn->query("SELECT COUNT(*) as count FROM pictures")->fetch_assoc()['count'];
$videos_count = $conn->query("SELECT COUNT(*) as count FROM videos")->fetch_assoc()['count'];
$articles_count = $conn->query("SELECT COUNT(*) as count FROM articles")->fetch_assoc()['count'];
$graduates_count = $conn->query("SELECT COUNT(*) as count FROM graduates")->fetch_assoc()['count'];
$messages_count = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <div class="admin-user">
                    Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                    <a href="logout.php" class="btn-secondary">Logout</a>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Modules</h3>
                    <div class="stat-number"><?php echo $modules_count; ?></div>
                    <a href="manage-modules.php">Manage →</a>
                </div>

                <div class="stat-card">
                    <h3>Pictures</h3>
                    <div class="stat-number"><?php echo $pictures_count; ?></div>
                    <a href="manage-pictures.php">Manage →</a>
                </div>

                <div class="stat-card">
                    <h3>Videos</h3>
                    <div class="stat-number"><?php echo $videos_count; ?></div>
                    <a href="manage-videos.php">Manage →</a>
                </div>

                <div class="stat-card">
                    <h3>Articles</h3>
                    <div class="stat-number"><?php echo $articles_count; ?></div>
                    <a href="manage-articles.php">Manage →</a>
                </div>

                <div class="stat-card">
                    <h3>Graduates</h3>
                    <div class="stat-number"><?php echo $graduates_count; ?></div>
                    <a href="manage-graduates.php">Manage →</a>
                </div>

                <div class="stat-card highlight">
                    <h3>New Messages</h3>
                    <div class="stat-number"><?php echo $messages_count; ?></div>
                    <a href="messages.php">View →</a>
                </div>
            </div>

            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="upload-module.php" class="btn-primary">Upload Module</a>
                    <a href="upload-picture.php" class="btn-primary">Upload Picture</a>
                    <a href="upload-video.php" class="btn-primary">Upload Video</a>
                    <a href="add-article.php" class="btn-primary">Add Article</a>
                    <a href="add-graduate.php" class="btn-primary">Add Graduate</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>