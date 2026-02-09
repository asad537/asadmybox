<?php
/**
 * Server CSS Test - Check if server can serve CSS files properly
 */

// Set proper headers for CSS
header('Content-Type: text/css; charset=utf-8');
header('Cache-Control: public, max-age=3600');

// Test which CSS file to serve based on request
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
echo "/* CSS Server Test - Request: $requestUri */\n";

if (strpos($requestUri, 'app.css') !== false) {
    // Try to serve app.css
    $cssPath = __DIR__ . '/public/css/app.css';
    if (file_exists($cssPath)) {
        echo "/* Serving app.css from: $cssPath */\n";
        echo "/* File size: " . filesize($cssPath) . " bytes */\n";
        
        // Read and output the CSS file
        $cssContent = file_get_contents($cssPath);
        echo $cssContent;
    } else {
        echo "/* ERROR: app.css not found at $cssPath */\n";
        echo "body { background: red; color: white; }";
        echo "body:before { content: 'CSS FILE NOT FOUND'; }";
    }
} else {
    // Default test CSS
    echo "/* Default test CSS */\n";
    echo "body { background: #f0f0f0; font-family: Arial, sans-serif; }";
    echo ".test { background: green; color: white; padding: 10px; }";
    echo ".test:before { content: 'CSS SERVER TEST WORKING'; }";
}
?>