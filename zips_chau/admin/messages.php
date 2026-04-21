
<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Mark as read
if (isset($_GET['read'])) {
    $id = intval($_GET['read']);
    $sql = "UPDATE contact_messages SET is_read = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: messages.php');
    exit();
}

// Delete message
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM contact_messages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: messages.php');
    exit();
}

// Fetch all messages
$sql = "SELECT * FROM contact_messages ORDER BY received_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .messages-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
        }
        .message-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .message-item.unread {
            background-color: #e3f2fd;
            border-left: 4px solid #2196F3;
        }
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .message-meta {
            display: flex;
            gap: 1.5rem;
            font-size: 0.875rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        .message-subject {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        .message-actions {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Contact Messages</h1>
            </div>

            <div class="messages-container">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="message-item <?php echo $row['is_read'] ? '' : 'unread'; ?>">
                            <div class="message-meta">
                                <span><strong>From:</strong> <?php echo htmlspecialchars($row['name']); ?></span>
                                <span><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></span>
                                <span><strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($row['received_date'])); ?></span>
                            </div>

                            <div class="message-subject">
                                Subject: <?php echo htmlspecialchars($row['subject']); ?>
                            </div>

                            <div class="message-content">
                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                            </div>

                            <div class="message-actions" style="margin-top: 1rem;">
                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="btn-primary">Reply</a>
                                <?php if (!$row['is_read']): ?>
                                    <a href="?read=<?php echo $row['id']; ?>" class="btn-secondary">Mark as Read</a>
                                <?php endif; ?>
                                <a href="?delete=<?php echo $row['id']; ?>"
                                   class="btn-secondary"
                                   style="background-color: var(--danger-color);"
                                   onclick="return confirm('Delete this message?')">Delete</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center; padding: 2rem; color: #666;">No messages yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>