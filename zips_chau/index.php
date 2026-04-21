
<?php
require_once 'config.php';

// Check if already logged in
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header('Location: dashboard.php');
    exit();
}

// Handle PIN submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pin'])) {
    if ($_POST['pin'] === ACCESS_PIN) {
        $_SESSION['authenticated'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid PIN. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo-section">
                <h1>ZIPS Chau</h1>
                <h2>E-Library</h2>
                <p class="tagline">Zambia Institute of Purchasing and Supply</p>
                <p class="tagline">Chalimbana University Chapter</p>
            </div>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="pin">Enter Access PIN</label>
                    <input
                        type="password"
                        id="pin"
                        name="pin"
                        placeholder="Enter PIN"
                        required
                        autocomplete="off"
                    >
                </div>

                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>

                <button type="submit" class="btn-primary">Access Library</button>
            </form>

            <div class="info-section">
                <p><strong>About ZIPS Chau Chapter</strong></p>
                <p>Established in July 2023, our chapter bridges the gap between procurement theory and practical skills.</p>
            </div>

            <div class="contact-info">
                <p><strong>Contact Us:</strong></p>
                <p>Email: <a href="mailto:chau@zips.com">chau@zips.com</a></p>
                <p>
                    <a href="https://facebook.com" target="_blank" class="social-link">
                        Facebook: Zambia Institute of Purchasing and Supply - Chalimbana University
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>