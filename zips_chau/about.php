
<?php
require_once 'config.php';

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
    <title>About - ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>About ZIPS Chau Chapter</h1>
        </div>

        <div class="about-content">
            <section class="about-section">
                <h2>Our Mission</h2>
                <p>
                    The Zambia Institute of Purchasing and Supply (ZIPS) Chalimbana University Chapter was established in <strong>July 2023</strong> with a clear vision: to bridge the gap between procurement theory and practical skills.
                </p>
            </section>

            <section class="about-section">
                <h2>Who We Are</h2>
                <p>
                    We are a student-led chapter affiliated with the Zambia Institute of Purchasing and Supply, operating at Chalimbana University. Our chapter brings together students passionate about procurement, supply chain management, and logistics.
                </p>
            </section>

            <section class="about-section">
                <h2>What We Do</h2>
                <ul class="feature-list">
                    <li>Connect theoretical knowledge with real-world procurement practices</li>
                    <li>Provide hands-on training and workshops</li>
                    <li>Facilitate networking opportunities with industry professionals</li>
                    <li>Organize guest lectures and seminars</li>
                    <li>Support students in their professional development</li>
                    <li>Maintain this digital library for resource sharing</li>
                </ul>
            </section>

            <section class="about-section">
                <h2>Our Vision</h2>
                <p>
                    To be the leading student chapter in procurement education, producing graduates who are not only academically excellent but also industry-ready professionals.
                </p>
            </section>

            <section class="about-section">
                <h2>Core Values</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <h3>Excellence</h3>
                        <p>We strive for excellence in all our activities and education</p>
                    </div>
                    <div class="value-card">
                        <h3>Integrity</h3>
                        <p>We uphold the highest standards of ethics in procurement</p>
                    </div>
                    <div class="value-card">
                        <h3>Collaboration</h3>
                        <p>We believe in the power of teamwork and partnerships</p>
                    </div>
                    <div class="value-card">
                        <h3>Innovation</h3>
                        <p>We embrace innovative approaches to procurement challenges</p>
                    </div>
                </div>
            </section>

            <section class="about-section">
                <h2>Join Us</h2>
                <p>
                    Interested in becoming part of ZIPS Chau Chapter? We welcome all students passionate about procurement and supply chain management. Contact us to learn more about membership opportunities.
                </p>
            </section>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/main.js"></script>
</body>
</html>
