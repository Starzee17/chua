
<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: index.php');
    exit();
}

// Fetch graduates grouped by year
$sql = "SELECT * FROM graduates ORDER BY graduation_year DESC, full_name ASC";
$result = $conn->query($sql);

// Group graduates by year
$graduates_by_year = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $graduates_by_year[$row['graduation_year']][] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graduates - ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Our Graduates</h1>
            <p>Celebrating the success of ZIPS Chau graduates</p>
        </div>

        <div class="graduates-section">
            <?php if (!empty($graduates_by_year)): ?>
                <?php foreach($graduates_by_year as $year => $graduates): ?>
                    <div class="graduate-year-section">
                        <h2 class="year-heading">Class of <?php echo $year; ?></h2>
                        <div class="graduates-grid">
                            <?php foreach($graduates as $graduate): ?>
                                <div class="graduate-card">
                                    <div class="graduate-icon">🎓</div>
                                    <h3><?php echo htmlspecialchars($graduate['full_name']); ?></h3>
                                    <?php if ($graduate['program']): ?>
                                        <p class="program"><?php echo htmlspecialchars($graduate['program']); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-content">
                    <p>No graduate records available yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/main.js"></script>
</body>
</html>
