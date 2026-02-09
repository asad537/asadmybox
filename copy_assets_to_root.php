<?php
/**
 * Copy assets from public folder to root for direct access
 */

echo "Copying assets to root level...\n";

// Define source and destination paths
$publicDir = __DIR__ . '/public';
$rootDir = __DIR__;

// Asset directories to copy
$assetDirs = ['css', 'js', 'images', 'assets', 'fonts'];

foreach ($assetDirs as $dir) {
    $source = $publicDir . '/' . $dir;
    $destination = $rootDir . '/' . $dir;
    
    if (is_dir($source)) {
        echo "Copying directory: $dir\n";
        
        // Create destination directory if it doesn't exist
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        
        // Copy files recursively
        copyDirectory($source, $destination);
    }
}

// Copy individual asset files
$assetFiles = [
    'favicon.ico',
    'robots.txt',
    'sitemap.xml',
    'logo.png',
    'mbp.png',
    'my-box-printing-logo.svg',
    'printing.webp'
];

foreach ($assetFiles as $file) {
    $source = $publicDir . '/' . $file;
    $destination = $rootDir . '/' . $file;
    
    if (file_exists($source) && !file_exists($destination)) {
        copy($source, $destination);
        echo "Copied file: $file\n";
    }
}

function copyDirectory($src, $dst) {
    $dir = opendir($src);
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            
            if (is_dir($srcFile)) {
                copyDirectory($srcFile, $dstFile);
            } else {
                copy($srcFile, $dstFile);
            }
        }
    }
    closedir($dir);
}

echo "Assets copied successfully!\n";
echo "Now assets are accessible directly from root URL\n";
?>