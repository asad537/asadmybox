<?php
/**
 * CSS Loading Debug Test
 */

echo "<h1>CSS Loading Debug Test</h1>";

// Test CSS file paths
$cssFiles = [
    '/css/app.css',
    '/css/style.css', 
    '/css/bootstrap.min.css',
    '/public/css/app.css',
    'css/app.css'
];

echo "<h2>Testing CSS File Access:</h2>";

foreach ($cssFiles as $cssPath) {
    $fullPath = __DIR__ . '/public' . $cssPath;
    if (strpos($cssPath, '/public/') === 0) {
        $fullPath = __DIR__ . $cssPath;
    } elseif (strpos($cssPath, '/') !== 0) {
        $fullPath = __DIR__ . '/public/' . $cssPath;
    }
    
    $exists = file_exists($fullPath);
    $readable = is_readable($fullPath);
    $size = $exists ? filesize($fullPath) : 0;
    
    echo "<p>";
    echo "<strong>Path:</strong> $cssPath<br>";
    echo "<strong>Full Path:</strong> $fullPath<br>";
    echo "<strong>Exists:</strong> " . ($exists ? 'YES' : 'NO') . "<br>";
    echo "<strong>Readable:</strong> " . ($readable ? 'YES' : 'NO') . "<br>";
    echo "<strong>Size:</strong> " . ($size > 0 ? number_format($size) . ' bytes' : '0 bytes') . "<br>";
    echo "</p><hr>";
}

echo "<h2>Test CSS Links:</h2>";
foreach ($cssFiles as $cssPath) {
    echo "<link rel='stylesheet' href='$cssPath' onload=\"console.log('Loaded: $cssPath')\" onerror=\"console.log('Failed: $cssPath')\">";
    echo "<br>";
}

echo "<h2>Direct CSS Content Test:</h2>";
$testCssPath = __DIR__ . '/public/css/app.css';
if (file_exists($testCssPath)) {
    $cssContent = file_get_contents($testCssPath);
    echo "<p><strong>CSS Content (first 500 chars):</strong></p>";
    echo "<pre>" . htmlspecialchars(substr($cssContent, 0, 500)) . "...</pre>";
} else {
    echo "<p>CSS file not found!</p>";
}

echo "<script>
console.log('CSS Debug Test loaded');
setTimeout(() => {
    const links = document.querySelectorAll('link[rel=\"stylesheet\"]');
    links.forEach((link, index) => {
        console.log('Link ' + index + ':', link.href, 'Sheet:', link.sheet);
    });
}, 2000);
</script>";
?>