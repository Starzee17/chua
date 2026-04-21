
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
    if (isset($_FILES['module_file']) && $_FILES['module_file']['error'] === 0) {
        $file = $_FILES['module_file'];
        $allowed_types = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_types)) {
            $upload_dir = '../uploads/modules/';
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file['name']);
            $filepath = $upload_dir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                $sql = "INSERT INTO modules (title, description, file_path, file_type) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $title, $description, $filepath, $file_ext);

                if ($stmt->execute()) {
                    $success = 'Module uploaded successfully!';
                } else {
                    $error = 'Database error: ' . $conn->error;
                    unlink($filepath);
                }
            } else {
                $error = 'Error uploading file';
            }
        } else {
            $error = 'Invalid file type. Allowed: PDF, DOC, DOCX, PPT, PPTX, ZIP';
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
    <title>Upload Module - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Upload Module</h1>
                <a href="manage-modules.php" class="btn-secondary">Back to Modules</a>
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
                        <label for="title">Module Title *</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="module_file">Module File * (PDF, DOC, DOCX, PPT, PPTX, ZIP)</label>
                        <input type="file" id="module_file" name="module_file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
                    </div>

                    <button type="submit" class="btn-primary">Upload Module</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>