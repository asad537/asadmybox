<?php
/**
 * Script to move Laravel files to correct structure for Hostinger
 */

echo "Moving Laravel files to correct structure...\n";

// Define paths
$publicHtml = __DIR__ . '/public_html';
$laravelApp = __DIR__ . '/laravel_app';

// Create laravel_app directory if it doesn't exist
if (!is_dir($laravelApp)) {
    mkdir($laravelApp, 0755, true);
    echo "Created laravel_app directory\n";
}

// Laravel directories to move (everything except public folder contents)
$laravelDirs = [
    'app',
    'bootstrap', 
    'config',
    'database',
    'resources',
    'routes',
    'storage',
    'vendor'
];

// Laravel files to move
$laravelFiles = [
    '.env',
    '.env.example',
    'artisan',
    'composer.json',
    'composer.lock',
    'package.json',
    'phpunit.xml',
    'server.php',
    'webpack.mix.js'
];

// Move directories
foreach ($laravelDirs as $dir) {
    $source = $publicHtml . '/' . $dir;
    $destination = $laravelApp . '/' . $dir;
    
    if (is_dir($source)) {
        echo "Moving directory: $dir\n";
        rename($source, $destination);
    }
}

// Move files
foreach ($laravelFiles as $file) {
    $source = $publicHtml . '/' . $file;
    $destination = $laravelApp . '/' . $file;
    
    if (file_exists($source)) {
        echo "Moving file: $file\n";
        rename($source, $destination);
    }
}

// Keep only public folder contents in public_html
$publicDir = $publicHtml . '/public';
if (is_dir($publicDir)) {
    echo "Moving public folder contents to public_html root\n";
    
    // Get all files and folders from public directory
    $items = scandir($publicDir);
    
    foreach ($items as $item) {
        if ($item != '.' && $item != '..') {
            $source = $publicDir . '/' . $item;
            $destination = $publicHtml . '/' . $item;
            
            // Don't overwrite if already exists
            if (!file_exists($destination)) {
                rename($source, $destination);
                echo "Moved: $item\n";
            }
        }
    }
    
    // Remove empty public directory
    rmdir($publicDir);
}

echo "Laravel files moved successfully!\n";
echo "Next steps:\n";
echo "1. Update public_html/index.php paths\n";
echo "2. Create storage link\n";
echo "3. Set proper permissions\n";
?>