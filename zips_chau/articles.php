
<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: index.php');
    exit();
}

// Fetch all articles
$sql = "SELECT * FROM articles ORDER BY published_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Articles & Publications</h1>
            <p>Read our latest articles and research papers on procurement</p>
        </div>

        <div class="articles-list">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <article class="article-card">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <div class="article-meta">
                            <span>By <?php echo htmlspecialchars($row['author']); ?></span>
                            <span>📅 <?php echo date('M d, Y', strtotime($row['published_date'])); ?></span>
                            <span>👁️ <?php echo $row['views']; ?> views</span>
                        </div>
                        <div class="article-content">
                            <?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 300))); ?>...
                        </div>
                        <a href="article-view.php?id=<?php echo $row['id']; ?>" class="btn-secondary">Read More</a>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-content">
                    <p>No articles available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/main.js"></script>
</body>
</html>