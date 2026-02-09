<!DOCTYPE html>
<html>
<head>
    <title>CSS Path Checker</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #86C342; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #86C342; color: white; }
        tr:hover { background: #f9f9f9; }
        .status-ok { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; }
        .status-missing { background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; }
        .info-box { background: #e7f3ff; border-left: 4px solid #2196F3; padding: 15px; margin: 20px 0; }
        .code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 CSS Path Checker - MyBoxPrinting</h1>
        
        <div class="info-box">
            <strong>Purpose:</strong> This script checks if all CSS files are accessible from their expected paths.
        </div>

        <?php
        // Define CSS paths to check
        $cssChecks = [
            'Box Assets CSS' => [
                '/box_assets/css/2bootstrap.min.css',
                '/box_assets/css/mbpmain.min.css',
                '/box_assets/css/animate.min.css',
                '/box_assets/css/preloader.css',
                '/box_assets/css/swiper-bundle.css',
                '/box_assets/css/backToTop.css',
                '/box_assets/css/magnific-popup.css',
                '/box_assets/css/ui-range-slider.css',
                '/box_assets/css/nice-select.css',
                '/box_assets/css/hover-reveal.css',
                '/box_assets/css/mbp_owl.carousel.min.css',
            ],
            'Assets CSS' => [
                '/assets/css/animate.css',
                '/assets/css/bootstrap.min.css',
                '/assets/css/stylesheet1.css',
                '/assets/css/jquery.smartmenus.bootstrap-4.css',
                '/assets/css/owl.carousel.min.css',
            ],
            'Laravel CSS' => [
                '/css/app.css',
            ],
        ];

        $totalFiles = 0;
        $foundFiles = 0;
        $missingFiles = 0;

        foreach ($cssChecks as $category => $paths) {
            echo "<h2>$category</h2>";
            echo "<table>";
            echo "<tr><th>CSS File</th><th>Physical Path</th><th>Status</th><th>Size</th></tr>";
            
            foreach ($paths as $webPath) {
                $totalFiles++;
                
                // Convert web path to physical path
                $physicalPath = __DIR__ . '/public' . $webPath;
                
                // Check if file exists
                $exists = file_exists($physicalPath);
                $size = $exists ? filesize($physicalPath) : 0;
                $sizeFormatted = $exists ? number_format($size / 1024, 2) . ' KB' : 'N/A';
                
                if ($exists) {
                    $foundFiles++;
                    $statusClass = 'status-ok';
                    $statusText = '✓ Found';
                } else {
                    $missingFiles++;
                    $statusClass = 'status-missing';
                    $statusText = '✗ Missing';
                }
                
                echo "<tr>";
                echo "<td><code>$webPath</code></td>";
                echo "<td><small>$physicalPath</small></td>";
                echo "<td><span class='$statusClass'>$statusText</span></td>";
                echo "<td>$sizeFormatted</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        }

        // Summary
        echo "<h2>📊 Summary</h2>";
        echo "<table>";
        echo "<tr><th>Metric</th><th>Value</th></tr>";
        echo "<tr><td>Total CSS Files Checked</td><td><strong>$totalFiles</strong></td></tr>";
        echo "<tr><td>Files Found</td><td><span class='success'>$foundFiles</span></td></tr>";
        echo "<tr><td>Files Missing</td><td><span class='error'>$missingFiles</span></td></tr>";
        echo "<tr><td>Success Rate</td><td><strong>" . round(($foundFiles / $totalFiles) * 100, 1) . "%</strong></td></tr>";
        echo "</table>";

        // Check .htaccess
        echo "<h2>⚙️ Configuration Check</h2>";
        echo "<table>";
        echo "<tr><th>File</th><th>Status</th><th>Size</th></tr>";
        
        $htaccessPath = __DIR__ . '/.htaccess';
        $htaccessExists = file_exists($htaccessPath);
        $htaccessSize = $htaccessExists ? filesize($htaccessPath) : 0;
        
        echo "<tr>";
        echo "<td><code>.htaccess</code></td>";
        echo "<td><span class='" . ($htaccessExists ? 'status-ok' : 'status-missing') . "'>" . ($htaccessExists ? '✓ Found' : '✗ Missing') . "</span></td>";
        echo "<td>" . number_format($htaccessSize / 1024, 2) . " KB</td>";
        echo "</tr>";
        
        $serveCssPath = __DIR__ . '/serve_css.php';
        $serveCssExists = file_exists($serveCssPath);
        $serveCssSize = $serveCssExists ? filesize($serveCssPath) : 0;
        
        echo "<tr>";
        echo "<td><code>serve_css.php</code></td>";
        echo "<td><span class='" . ($serveCssExists ? 'status-ok' : 'status-missing') . "'>" . ($serveCssExists ? '✓ Found' : '✗ Missing') . "</span></td>";
        echo "<td>" . number_format($serveCssSize / 1024, 2) . " KB</td>";
        echo "</tr>";
        
        echo "</table>";

        // Check if box_assets rule exists in .htaccess
        if ($htaccessExists) {
            $htaccessContent = file_get_contents($htaccessPath);
            $hasBoxAssetsRule = strpos($htaccessContent, 'box_assets') !== false;
            
            echo "<h2>🔧 .htaccess Rules</h2>";
            echo "<table>";
            echo "<tr><th>Rule</th><th>Status</th></tr>";
            echo "<tr><td>Box Assets Rewrite Rule</td><td><span class='" . ($hasBoxAssetsRule ? 'status-ok' : 'status-missing') . "'>" . ($hasBoxAssetsRule ? '✓ Present' : '✗ Missing') . "</span></td></tr>";
            echo "</table>";
            
            if (!$hasBoxAssetsRule) {
                echo "<div class='info-box' style='background: #fff3cd; border-left-color: #ffc107;'>";
                echo "<strong>⚠️ Warning:</strong> The .htaccess file does not contain rules for <code>box_assets</code>. ";
                echo "Please ensure the updated .htaccess file is uploaded to the server.";
                echo "</div>";
            }
        }

        // Final recommendation
        echo "<h2>✅ Recommendations</h2>";
        if ($missingFiles > 0) {
            echo "<div class='info-box' style='background: #f8d7da; border-left-color: #dc3545;'>";
            echo "<strong>Action Required:</strong> $missingFiles CSS file(s) are missing. ";
            echo "Please ensure all files are uploaded to the correct directories.";
            echo "</div>";
        } else {
            echo "<div class='info-box' style='background: #d4edda; border-left-color: #28a745;'>";
            echo "<strong>✓ All CSS files found!</strong> Your CSS files are in the correct locations.";
            echo "</div>";
        }

        // Test URLs
        echo "<h2>🧪 Test URLs</h2>";
        echo "<ul>";
        echo "<li><a href='/test_box_assets_css.html' target='_blank'>Test Box Assets CSS Loading</a></li>";
        echo "<li><a href='/box_assets/css/mbpmain.min.css' target='_blank'>Direct: mbpmain.min.css</a></li>";
        echo "<li><a href='/box_assets/css/2bootstrap.min.css' target='_blank'>Direct: 2bootstrap.min.css</a></li>";
        echo "<li><a href='/assets/css/bootstrap.min.css' target='_blank'>Direct: assets bootstrap.min.css</a></li>";
        echo "</ul>";
        ?>

        <div class="info-box">
            <strong>Next Steps:</strong>
            <ol>
                <li>If all files are found, test the frontend pages</li>
                <li>Check browser console for any CSS loading errors</li>
                <li>Clear browser cache if CSS doesn't appear</li>
                <li>Verify .htaccess rules are active on the server</li>
            </ol>
        </div>
    </div>
</body>
</html>
