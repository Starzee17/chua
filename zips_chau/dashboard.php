
<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZIPS Chau E-Library - Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="welcome-section">
            <h1>Welcome to ZIPS Chau E-Library</h1>
            <p>Your digital resource center for procurement education and excellence</p>
        </div>

        <div class="dashboard-grid">
            <!-- Modules Section -->
            <div class="dashboard-card">
                <div class="card-icon">📚</div>
                <h3>Modules</h3>
                <p>Access course modules and learning materials</p>
                <a href="modules.php" class="btn-secondary">View Modules</a>
            </div>

            <!-- Pictures Section -->
            <div class="dashboard-card">
                <div class="card-icon">🖼️</div>
                <h3>Pictures</h3>
                <p>Browse our photo gallery</p>
                <a href="pictures.php" class="btn-secondary">View Gallery</a>
            </div>

            <!-- Videos Section -->
            <div class="dashboard-card">
                <div class="card-icon">🎥</div>
                <h3>Videos</h3>
                <p>Watch educational videos and lectures</p>
                <a href="videos.php" class="btn-secondary">View Videos</a>
            </div>

            <!-- Articles Section -->
            <div class="dashboard-card">
                <div class="card-icon">📰</div>
                <h3>Articles</h3>
                <p>Read articles and research papers</p>
                <a href="articles.php" class="btn-secondary">Read Articles</a>
            </div>

            <!-- Graduates Section -->
            <div class="dashboard-card">
                <div class="card-icon">🎓</div>
                <h3>Graduates</h3>
                <p>Celebrate our successful graduates</p>
                <a href="graduates.php" class="btn-secondary">View Graduates</a>
            </div>

            <!-- About Section -->
            <div class="dashboard-card">
                <div class="card-icon">ℹ️</div>
                <h3>About Us</h3>
                <p>Learn about ZIPS Chau Chapter</p>
                <a href="about.php" class="btn-secondary">Learn More</a>
            </div>

            <!-- Contact Section -->
            <div class="dashboard-card">
                <div class="card-icon">📧</div>
                <h3>Contact</h3>
                <p>Get in touch with us</p>
                <a href="contact.php" class="btn-secondary">Contact Us</a>
            </div>

            <!-- Share Link -->
            <div class="dashboard-card">
                <div class="card-icon">🔗</div>
                <h3>Share Library</h3>
                <p>Share this e-library with others</p>
                <button onclick="shareLibrary()" class="btn-secondary">Copy Link</button>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="js/main.js"></script>
    <script>
        function shareLibrary() {
            const url = window.location.origin + window.location.pathname.replace('dashboard.php', 'index.php');
            navigator.clipboard.writeText(url).then(() => {
                alert('Library link copied to clipboard!\nShare PIN: zips2025');
            }).catch(() => {
                prompt('Copy this link:', url);
            });
        }
    </script>
</body>
</html>