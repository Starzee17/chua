
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
    $content = $conn->real_escape_string($_POST['content']);
    $author = $conn->real_escape_string($_POST['author']);

    $sql = "INSERT INTO articles (title, content, author) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $author);

    if ($stmt->execute()) {
        $success = 'Article published successfully!';
    } else {
        $error = 'Error: ' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Article - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Publish New Article</h1>
                <a href="manage-articles.php" class="btn-secondary">Back to Articles</a>
            </div>

            <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <div style="background: white; padding: 2rem; border-radius: 10px;">
                <form method="POST">
                    <div class="form-group">
                        <label for="title">Article Title *</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="author">Author Name *</label>
                        <input type="text" id="author" name="author" required placeholder="e.g., Dr. John Banda">
                    </div>

                    <div class="form-group">
                        <label for="content">Article Content *</label>
                        <textarea id="content" name="content" rows="15" required placeholder="Write your article content here..."></textarea>
                    </div>

                    <button type="submit" class="btn-primary">Publish Article</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
