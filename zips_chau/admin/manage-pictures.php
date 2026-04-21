
<?php
require_once '../config.php';
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "SELECT file_path FROM pictures WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc();
        if (file_exists($file['file_path'])) unlink($file['file_path']);
        $delete_sql = "DELETE FROM pictures WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
    }
    header('Location: manage-pictures.php');
    exit();
}

$sql = "SELECT * FROM pictures ORDER BY uploaded_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Manage Pictures</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="admin-layout"><?php include 'includes/admin-sidebar.php'; ?><div class="admin-content">
<div class="admin-header"><h1>Manage Pictures</h1><a href="upload-picture.php" class="btn-primary">Upload New Picture</a></div>
<div style="background:white;padding:2rem;border-radius:10px;display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:1.5rem;">
<?php if($result && $result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
<div style="border:1px solid #ddd;border-radius:8px;overflow:hidden;">
<img src="<?php echo $row['file_path']; ?>" style="width:100%;height:200px;object-fit:cover;">
<div style="padding:1rem;">
<h3><?php echo htmlspecialchars($row['title']); ?></h3>
<p style="font-size:0.875rem;color:#666;"><?php echo date('M d, Y', strtotime($row['uploaded_date'])); ?></p>
<a href="?delete=<?php echo $row['id']; ?>" class="btn-secondary" style="background-color:#F44336;margin-top:0.5rem;" onclick="return confirm('Delete this picture?')">Delete</a>
</div></div>
<?php endwhile; else: ?>
<p style="text-align:center;padding:2rem;color:#666;">No pictures found.</p>
<?php endif; ?>
</div></div></div></body></html>
