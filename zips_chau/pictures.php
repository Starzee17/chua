
<?php
require_once 'config.php';

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: index.php');
    exit();
}

$sql = "SELECT * FROM pictures ORDER BY uploaded_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pictures - ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Photo Gallery</h1>
            <p>Browse through our collection of memories and events</p>
        </div>

        <div class="gallery-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="gallery-item">
                        <img src="<?php echo htmlspecialchars($row['file_path']); ?>"
                             alt="<?php echo htmlspecialchars($row['title']); ?>"
                             onclick="openLightbox('<?php echo htmlspecialchars($row['file_path']); ?>', '<?php echo htmlspecialchars($row['title']); ?>')">
                        <div class="gallery-caption">
                            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-content">
                    <p>No pictures available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="close">&times;</span>
        <img class="lightbox-content" id="lightbox-img">
        <div class="lightbox-caption" id="lightbox-caption"></div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/main.js"></script>
    <script src="js/lightbox.js"></script>
</body>
</html>
