
<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $graduation_year = intval($_POST['graduation_year']);
    $program = $conn->real_escape_string($_POST['program']);

    $sql = "INSERT INTO graduates (full_name, graduation_year, program) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $full_name, $graduation_year, $program);

    if ($stmt->execute()) {
        $success = 'Graduate added successfully!';
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
    <title>Add Graduate - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Add Graduate</h1>
                <a href="manage-graduates.php" class="btn-secondary">Back to Graduates</a>
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
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>

                    <div class="form-group">
                        <label for="graduation_year">Graduation Year *</label>
                        <input type="number" id="graduation_year" name="graduation_year" min="2023" max="2050" required>
                    </div>

                    <div class="form-group">
                        <label for="program">Program/Course</label>
                        <input type="text" id="program" name="program" placeholder="e.g., Procurement and Supply Chain Management">
                    </div>

                    <button type="submit" class="btn-primary">Add Graduate</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>