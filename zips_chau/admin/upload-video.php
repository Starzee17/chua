
<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);

    // File upload handling
    if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === 0) {
        $file = $_FILES['video_file'];
        $allowed_types = ['mp4', 'avi', 'mov', 'wmv'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_types)) {
            $upload_dir = '../uploads/videos/';
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file['name']);
            $filepath = $upload_dir . $filename;

            // Check file size (max 100MB)
            if ($file['size'] <= 100 * 1024 * 1024) {
                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    $sql = "INSERT INTO videos (title, description, file_path) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $title, $description, $filepath);

                    if ($stmt->execute()) {
                        $success = 'Video uploaded successfully!';
                    } else {
                        $error = 'Database error: ' . $conn->error;
                        unlink($filepath);
                    }
                } else {
                    $error = 'Error uploading file';
                }
            } else {
                $error = 'File size too large. Maximum: 100MB';
            }
        } else {
            $error = 'Invalid file type. Allowed: MP4, AVI, MOV, WMV';
        }
    } else {
        $error = 'Please select a file to upload';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Upload Video</h1>
                <a href="manage-videos.php" class="btn-secondary">Back to Videos</a>
            </div>

            <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <div style="background: white; padding: 2rem; border-radius: 10px;">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Video Title *</label>
                        <input type="text" id="title" name="title" required placeholder="e.g., Procurement Lecture - Week 1">
                    </div>

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" rows="4" required placeholder="Brief description of the video content"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="video_file">Video File * (MP4, AVI, MOV, WMV)</label>
                        <input type="file" id="video_file" name="video_file" required accept="video/mp4,video/avi,video/quicktime,video/x-ms-wmv">
                        <small style="color: #666; display: block; margin-top: 0.5rem;">
                            Maximum file size: 100MB. Recommended format: MP4
                        </small>
                    </div>

                    <div style="background: #fff3cd; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
                        <strong>Note:</strong> Large video files may take several minutes to upload. Please be patient and do not close the browser.
                    </div>

                    <button type="submit" class="btn-primary">Upload Video</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
