<?php
/**
 * Direct CSS Server - Handles CSS from multiple directories
 */

// Get the requested CSS file
$cssFile = $_GET['file'] ?? 'app.css';
$cssFile = basename($cssFile); // Security: prevent directory traversal

// Define possible CSS file paths (check in order)
$possiblePaths = [
    __DIR__ . '/public/css/' . $cssFile,
    __DIR__ . '/public/box_assets/css/' . $cssFile,
    __DIR__ . '/public/assets/css/' . $cssFile,
];

// Find the first existing file
$cssPath = null;
foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $cssPath = $path;
        break;
    }
}

// Check if file exists
if (!$cssPath) {
    http_response_code(404);
    header('Content-Type: text/plain');
    echo "CSS file not found: $cssFile\n";
    echo "Searched in:\n";
    foreach ($possiblePaths as $path) {
        echo "  - $path\n";
    }
    exit;
}

// Set proper headers for CSS
header('Content-Type: text/css; charset=utf-8');
header('Cache-Control: public, max-age=3600');
header('Content-Length: ' . filesize($cssPath));

// Add debug comment
echo "/* Served by serve_css.php */\n";
echo "/* File: $cssFile */\n";
echo "/* Path: $cssPath */\n";
echo "/* Size: " . filesize($cssPath) . " bytes */\n";
echo "/* Time: " . date('Y-m-d H:i:s') . " */\n\n";

// Output the CSS file
readfile($cssPath);
?>