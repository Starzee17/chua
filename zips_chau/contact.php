
<?php
require_once 'config.php';

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: index.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        $success = 'Thank you! Your message has been sent successfully.';
    } else {
        $error = 'Sorry, there was an error sending your message. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - ZIPS Chau E-Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Contact Us</h1>
            <p>Get in touch with ZIPS Chau Chapter</p>
        </div>

        <div class="contact-layout">
            <div class="contact-info-box">
                <h2>Contact Information</h2>

                <div class="contact-item">
                    <h3>📧 Email</h3>
                    <p><a href="mailto:chau@zips.com">chau@zips.com</a></p>
                </div>

                <div class="contact-item">
                    <h3>📱 Social Media</h3>
                    <p>
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">
                            Facebook: Zambia Institute of Purchasing and Supply - Chalimbana University
                        </a>
                    </p>
                </div>

                <div class="contact-item">
                    <h3>🏫 Location</h3>
                    <p>Chalimbana University<br>Zambia</p>
                </div>

                <div class="contact-item">
                    <h3>📅 Established</h3>
                    <p>July 2023</p>
                </div>
            </div>

            <div class="contact-form-box">
                <h2>Send Us a Message</h2>

                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" class="contact-form">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="6" required></textarea>
                    </div>

                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/main.js"></script>
</body>
</html>
