<?php
/**
 * Create storage link accessible from root level
 */

// Define paths
$target = __DIR__ . '/storage/app/public';
$publicLink = __DIR__ . '/public/storage';
$rootLink = __DIR__ . '/storage_link';

echo "Creating storage links for root-level access...\n";

// Ensure target directory exists
if (!is_dir($target)) {
    mkdir($target, 0755, true);
    echo "Created target directory: $target\n";
}

// Create link in public folder (standard Laravel)
if (!file_exists($publicLink)) {
    if (function_exists('symlink') && symlink($target, $publicLink)) {
        echo "Created symlink in public folder\n";
    } else {
        // Manual copy for public folder
        if (!is_dir($publicLink)) {
            mkdir($publicLink, 0755, true);
        }
        copyDirectory($target, $publicLink);
        echo "Copied storage to public folder\n";
    }
}

// Create link at root level for direct access
if (!file_exists($rootLink)) {
    if (function_exists('symlink') && symlink($target, $rootLink)) {
        echo "Created symlink at root level\n";
    } else {
        // Manual copy for root level
        if (!is_dir($rootLink)) {
            mkdir($rootLink, 0755, true);
        }
        copyDirectory($target, $rootLink);
        echo "Copied storage to root level\n";
    }
}

function copyDirectory($src, $dst) {
    if (!is_dir($src)) return;
    
    $dir = opendir($src);
    @mkdir($dst, 0755, true);
    
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copyDirectory($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

echo "Storage links created successfully!\n";
echo "Access storage files via:\n";
echo "- /storage/ (redirected to public/storage/)\n";
echo "- /storage_link/ (direct root access)\n";
?>