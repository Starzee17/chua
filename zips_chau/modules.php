
<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: index.php');
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
    <title>Modules - ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Course Modules</h1>
            <p>Access and download course materials and learning modules</p>
        </div>

        <div class="content-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="content-card">
                        <div class="card-header">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <span class="badge"><?php echo strtoupper($row['file_type']); ?></span>
                        </div>
                        <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                        <div class="card-meta">
                            <span>📅 <?php echo date('M d, Y', strtotime($row['uploaded_date'])); ?></span>
                            <span>👁️ <?php echo $row['views']; ?> views</span>
                        </div>
                        <div class="card-actions">
                            <a href="download.php?type=module&id=<?php echo $row['id']; ?>" class="btn-primary">
                                Download
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-content">
                    <p>No modules available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/main.js"></script>
</body>
</html>