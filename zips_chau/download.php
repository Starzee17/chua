
<?php
require_once 'config.php';

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    die('Unauthorized access');
}

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die('Invalid request');
}

$type = $_GET['type'];
$id = intval($_GET['id']);

// Determine table based on type
$table = '';
switch ($type) {
    case 'module':
        $table = 'modules';
        break;
    case 'video':
        $table = 'videos';
        break;
    default:
        die('Invalid type');
}

// Get file information
$sql = "SELECT * FROM $table WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('File not found');
}

$file = $result->fetch_assoc();
$filepath = $file['file_path'];

// Update view count
$update_sql = "UPDATE $table SET views = views + 1 WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $id);
$update_stmt->execute();

// Check if file exists
if (!file_exists($filepath)) {
    die('File not found on server');
}

// Set headers for download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
header('Content-Length: ' . filesize($filepath));
header('Cache-Control: must-revalidate');
header('Pragma: public');

// Clear output buffer
ob_clean();
flush();

// Read and output file
readfile($filepath);
exit();
?>
