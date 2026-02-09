<?php




if ($_SERVER['REQUEST_URI'] == '/burger-boxes/' || $_SERVER['REQUEST_URI'] == '/burger-boxes') {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://www.myboxprinting.com/custom-burger-boxes/");
    exit();
}
if ($_SERVER['REQUEST_URI'] == '/product-boxes/' || $_SERVER['REQUEST_URI'] == '/product-boxes') {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://www.myboxprinting.com/custom-product-boxes/");
    exit();
}
 if ($_SERVER['REQUEST_URI'] == '/blog/is-cardboard-environmentally-friendly-' || $_SERVER['REQUEST_URI'] == '/blog/is-cardboard-environmentally-friendly-') {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://www.myboxprinting.com/blog/what-is-difference-between-degradable-and-biodegradable/");
    exit();
}
 
 if ($_SERVER['REQUEST_URI'] == '/blog/what-is-difference-between-degradable-and-biodegradable-' || $_SERVER['REQUEST_URI'] == 'blog/what-is-difference-between-degradable-and-biodegradable-') {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://www.myboxprinting.com/blog/what-is-difference-between-degradable-and-biodegradable/");
    exit();
}
 


 

// $url = "https://www.myboxprinting.com/index.php";

// // Extract the path from the URL
// $path = parse_url($url, PHP_URL_PATH);

// // Get the filename from the path
// $filename = basename($path);

//  if($filename=='index.php'){
//         header("Location: https://www.myboxprinting.com/");
    
//  }



// if ($request()->segment(1) == 'index.php') {
//     // Replace "https://www.yourdomain.com" with your actual domain
//     header("Location: https://www.myboxprinting.com/");
//     exit();
// }
 
 
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
