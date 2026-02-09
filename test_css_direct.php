<?php
/**
 * Direct CSS Test - Simple test to check CSS loading
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>CSS Loading Test - Final Debug</title>
    <meta charset="utf-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f5f5f5;
        }
        .test-container { 
            background: white; 
            padding: 20px; 
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .status { 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 3px;
        }
        .success { 
            background: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        .error { 
            background: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
        }
        .loading { 
            background: #fff3cd; 
            color: #856404; 
            border: 1px solid #ffeaa7; 
        }
        .info { 
            background: #d1ecf1; 
            color: #0c5460; 
            border: 1px solid #bee5eb; 
        }
        pre { 
            background: #f8f9fa; 
            padding: 10px; 
            border-radius: 3px; 
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>CSS Loading Test - Final Debug</h1>
        
        <div class="status info">
            <strong>Server Info:</strong><br>
            Current URL: <span id="currentUrl"></span><br>
            User Agent: <span id="userAgent"></span><br>
            Timestamp: <span id="timestamp"></span>
        </div>
        
        <div class="status loading" id="mainStatus">
            Initializing CSS tests...
        </div>
    </div>
    
    <div class="test-container">
        <h2>CSS File Tests</h2>
        <div id="cssResults"></div>
    </div>
    
    <div class="test-container">
        <h2>Direct File Access Tests</h2>
        <div id="fileResults"></div>
    </div>
    
    <div class="test-container">
        <h2>Network Analysis</h2>
        <div id="networkResults"></div>
    </div>
    
    <div class="test-container">
        <h2>Manual Test Links</h2>
        <p>Click these links to test direct access:</p>
        <ul>
            <li><a href="/css/app.css" target="_blank">/css/app.css</a> (Root level - should redirect)</li>
            <li><a href="/public/css/app.css" target="_blank">/public/css/app.css</a> (Direct public access)</li>
            <li><a href="css/app.css" target="_blank">css/app.css</a> (Relative path)</li>
            <li><a href="/css/style.css" target="_blank">/css/style.css</a> (Other CSS file)</li>
            <li><a href="css_server_test.php" target="_blank">css_server_test.php</a> (PHP CSS server test)</li>
        </ul>
    </div>

    <script>
        // Initialize page info
        document.getElementById('currentUrl').textContent = window.location.href;
        document.getElementById('userAgent').textContent = navigator.userAgent;
        document.getElementById('timestamp').textContent = new Date().toISOString();
        
        console.log('=== CSS Debug Test Started ===');
        console.log('URL:', window.location.href);
        console.log('Base:', window.location.origin);
        
        const testPaths = [
            { path: '/css/app.css', description: 'Root level app.css (via .htaccess)' },
            { path: '/public/css/app.css', description: 'Direct public app.css' },
            { path: 'css/app.css', description: 'Relative app.css' },
            { path: '/css/style.css', description: 'Root level style.css' },
            { path: 'css_server_test.php?css=app.css', description: 'PHP CSS server test' }
        ];
        
        const cssResults = document.getElementById('cssResults');
        const fileResults = document.getElementById('fileResults');
        const networkResults = document.getElementById('networkResults');
        const mainStatus = document.getElementById('mainStatus');
        
        let testsCompleted = 0;
        let testsTotal = testPaths.length;
        let networkData = [];
        
        // Performance observer for network timing
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.name.includes('.css')) {
                        networkData.push({
                            url: entry.name,
                            duration: entry.duration,
                            transferSize: entry.transferSize || 0,
                            responseStart: entry.responseStart,
                            responseEnd: entry.responseEnd
                        });
                    }
                }
            });
            observer.observe({entryTypes: ['resource']});
        }
        
        function testCSS(testConfig) {
            return new Promise((resolve) => {
                const startTime = performance.now();
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.type = 'text/css';
                link.href = testConfig.path;
                
                const timeout = setTimeout(() => {
                    resolve({ 
                        ...testConfig, 
                        status: 'TIMEOUT', 
                        error: 'Request timed out after 10 seconds',
                        duration: performance.now() - startTime
                    });
                }, 10000);
                
                link.onload = () => {
                    clearTimeout(timeout);
                    resolve({ 
                        ...testConfig, 
                        status: 'SUCCESS', 
                        error: null,
                        duration: performance.now() - startTime,
                        sheet: link.sheet ? 'Available' : 'Not available'
                    });
                };
                
                link.onerror = () => {
                    clearTimeout(timeout);
                    resolve({ 
                        ...testConfig, 
                        status: 'ERROR', 
                        error: 'Failed to load CSS file',
                        duration: performance.now() - startTime
                    });
                };
                
                document.head.appendChild(link);
            });
        }
        
        function testFileAccess(url) {
            return fetch(url, { method: 'HEAD' })
                .then(response => ({
                    url,
                    status: response.status,
                    statusText: response.statusText,
                    contentType: response.headers.get('content-type'),
                    contentLength: response.headers.get('content-length'),
                    cacheControl: response.headers.get('cache-control')
                }))
                .catch(error => ({
                    url,
                    status: 'ERROR',
                    error: error.message
                }));
        }
        
        async function runTests() {
            mainStatus.textContent = 'Running CSS loading tests...';
            
            // Test CSS loading
            for (const testConfig of testPaths) {
                const result = await testCSS(testConfig);
                testsCompleted++;
                
                const div = document.createElement('div');
                div.className = 'status ' + (result.status === 'SUCCESS' ? 'success' : 'error');
                div.innerHTML = `
                    <strong>${result.description}</strong><br>
                    Path: ${result.path}<br>
                    Status: ${result.status}<br>
                    Duration: ${result.duration ? result.duration.toFixed(2) + 'ms' : 'N/A'}<br>
                    ${result.sheet ? 'Stylesheet: ' + result.sheet + '<br>' : ''}
                    ${result.error ? 'Error: ' + result.error : 'Loaded successfully!'}
                `;
                cssResults.appendChild(div);
                
                console.log('CSS Test result:', result);
            }
            
            // Test file access
            mainStatus.textContent = 'Testing direct file access...';
            
            const fileTests = [
                '/css/app.css',
                '/public/css/app.css',
                'css/app.css',
                '/css/style.css'
            ];
            
            for (const url of fileTests) {
                const result = await testFileAccess(url);
                
                const div = document.createElement('div');
                div.className = 'status ' + (result.status === 200 ? 'success' : 'error');
                div.innerHTML = `
                    <strong>${result.url}</strong><br>
                    Status: ${result.status} ${result.statusText || ''}<br>
                    Content-Type: ${result.contentType || 'N/A'}<br>
                    Content-Length: ${result.contentLength || 'N/A'}<br>
                    Cache-Control: ${result.cacheControl || 'N/A'}<br>
                    ${result.error ? 'Error: ' + result.error : ''}
                `;
                fileResults.appendChild(div);
                
                console.log('File access result:', result);
            }
            
            // Display network data
            setTimeout(() => {
                if (networkData.length > 0) {
                    const networkDiv = document.createElement('div');
                    networkDiv.className = 'status info';
                    networkDiv.innerHTML = '<strong>Network Performance Data:</strong><pre>' + 
                        JSON.stringify(networkData, null, 2) + '</pre>';
                    networkResults.appendChild(networkDiv);
                } else {
                    networkResults.innerHTML = '<div class="status info">No network performance data available</div>';
                }
            }, 2000);
            
            mainStatus.className = 'status success';
            mainStatus.textContent = `All tests completed! (${testsCompleted}/${testsTotal})`;
            
            console.log('=== All tests completed ===');
        }
        
        // Start tests
        runTests();
    </script>
</body>
</html>