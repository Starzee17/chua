
<?php
require_once 'config.php';

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: articles.php');
    exit();
}

$id = intval($_GET['id']);

// Update view count
$update_sql = "UPDATE articles SET views = views + 1 WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $id);
$update_stmt->execute();

// Get article
$sql = "SELECT * FROM articles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: articles.php');
    exit();
}

$article = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="article-full">
            <div class="article-header">
                <a href="articles.php" class="back-link">← Back to Articles</a>
                <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                <div class="article-meta">
                    <span>By <?php echo htmlspecialchars($article['author']); ?></span>
                    <span>📅 <?php echo date('M d, Y', strtotime($article['published_date'])); ?></span>
                    <span>👁️ <?php echo $article['views']; ?> views</span>
                </div>
            </div>

            <div class="article-body">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/main.js"></script>
</body>
</html>
