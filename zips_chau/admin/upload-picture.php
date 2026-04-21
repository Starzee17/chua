
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
    if (isset($_FILES['picture_file']) && $_FILES['picture_file']['error'] === 0) {
        $file = $_FILES['picture_file'];
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_types)) {
            // Check if file is actually an image
            $check = getimagesize($file['tmp_name']);
            if ($check !== false) {
                $upload_dir = '../uploads/pictures/';
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file['name']);
                $filepath = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    $sql = "INSERT INTO pictures (title, description, file_path) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $title, $description, $filepath);

                    if ($stmt->execute()) {
                        $success = 'Picture uploaded successfully!';
                    } else {
                        $error = 'Database error: ' . $conn->error;
                        unlink($filepath);
                    }
                } else {
                    $error = 'Error uploading file';
                }
            } else {
                $error = 'File is not a valid image';
            }
        } else {
            $error = 'Invalid file type. Allowed: JPG, JPEG, PNG, GIF';
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
    <title>Upload Picture - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Upload Picture</h1>
                <a href="manage-pictures.php" class="btn-secondary">Back to Pictures</a>
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
                        <label for="title">Picture Title *</label>
                        <input type="text" id="title" name="title" required placeholder="e.g., ZIPS Chapter Meeting 2024">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="3" placeholder="Brief description of the picture"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="picture_file">Picture File * (JPG, PNG, GIF)</label>
                        <input type="file" id="picture_file" name="picture_file" required accept="image/jpeg,image/png,image/gif">
                        <small style="color: #666; display: block; margin-top: 0.5rem;">
                            Maximum file size: 5MB. Recommended size: 1200x800 pixels
                        </small>
                    </div>

                    <button type="submit" class="btn-primary">Upload Picture</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
