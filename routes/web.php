<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 Route::get('custom-box-packaging/', 'HomeController@CustomBoxesPage1');

// CRM Routes
Route::group(['prefix' => 'crm', 'namespace' => 'Crm'], function () {
    // Auth
    Route::get('login', 'AuthController@showLoginForm')->name('crm.login');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout')->name('crm.logout');

    Route::group(['middleware' => ['auth:crm', 'crm.ip']], function () {
        Route::get('dashboard', 'DashboardController@index')->name('crm.dashboard');
        
        // Emails
        Route::get('inbox', 'EmailController@index')->name('crm.emails.index');
        Route::get('spam', 'EmailController@spam')->name('crm.emails.spam');
        Route::get('email/{id}', 'EmailController@show')->name('crm.emails.show');
        Route::post('email/{id}/spam', 'EmailController@markAsSpam')->name('crm.emails.markSpam');
        Route::post('email/{id}/valid', 'EmailController@markAsValid')->name('crm.emails.markValid');
        Route::post('email/{id}/forward', 'EmailController@forward')->name('crm.emails.forward');

        // User Management (Admin Only)
        Route::post('email/{id}/status', 'EmailController@updateStatus')->name('crm.emails.status');
        Route::delete('email/{id}', 'EmailController@destroy')->name('crm.emails.destroy');

        // Admin Only Routes
        Route::group(['middleware' => function ($request, $next) {
            if (!\Auth::guard('crm')->user()->isAdmin()) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }
            return $next($request);
        }], function () {
            Route::get('logs', 'StatusLogController@index')->name('crm.logs.index');
            Route::get('leads', 'LeadsController@index')->name('crm.leads.index');
            Route::get('team-performance', 'TeamController@index')->name('crm.team_performance');
            Route::resource('users', 'UserManagementController', ['as' => 'crm'])->only(['index', 'create', 'store', 'destroy']);
        });
    });
});

 // Clear application cache:
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

// Clear route cache:
Route::get('/route-cache', function() {
    Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});

// Clear config cache:
Route::get('/config-cache', function() {
    Artisan::call('config:cache');
    return 'Config cache has been cleared';
});

// Clear view cache:
Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});

 // *********************** Start Web Controller ***********************

// Fronend Data Mapping Routs
// Route::get('index.php','HomeController@index1');
Route::get('/','HomeController@index');
Route::get('testing-function', function(){
	product_actual_and_original_price(12);
});
// Routes  Create login to redirect dashboard

Route::post('get-a-quote-home/', 'HomeController@GetAQuote');

Route::post('email_contact_us_c/', 'HomeController@email_contact_us');

Route::post('product_form_submit', 'HomeController@singleprod_reqquote_p');


Route::post('product-quote_form_submit', 'HomeController@singleprod_reqquote_p_quote');

Route::post('beat-my-prices', 'HomeController@beatmyprices');

Route::post('customboxes_form_submit', 'HomeController@customboxes_form_submit');



Route::post('product_form_submit1', 'HomeController@singleprod_reqquote_p1');
Route::post('product_form_submit11', 'HomeController@singleprod_reqquote_p11');

Route::post('sample_kit', 'HomeController@sample_kit');

Route::post('email_requote_form', 'HomeController@email_req_quote');

 Route::post('beat-my-price-form_form/','HomeController@BeatQuoteForm_form');

Route::post('ppc-form/', 'HomeController@PPCForm');
// *********************** End Web Controller***********************
Route::post('user-login-check','HomeController@user_login_check');
Route::get('user-dashboard','HomeController@user_dashboard');

Route::get('add-balance', 'HomeController@add_balance');
Route::post('add-balance-process', 'HomeController@add_balance_process');

Route::post('check-rows', 'HomeController@check_rows');


// Route::get('our-location', 'HomeController@location');
// Route::get('our-location/{any}', 'HomeController@location_state');

Route::get('add-states','FAQController@States' );

Route::post('save-states','FAQController@Save' );

Route::get('show-states','FAQController@Show' );

Route::get('edit-states/{id}','FAQController@Edit' );

Route::post('update-states/{id}','FAQController@Update' );

Route::get('delete-states/{id}','FAQController@Delete');



Route::get('add-states-category','FAQController@StatesCategory' );

Route::post('save-states-category','FAQController@SaveCategory' );

Route::get('show-states-category','FAQController@ShowCategory' );

Route::get('edit-states-category/{id}','FAQController@EditCategory' );

Route::post('update-states-category/{id}','FAQController@UpdateCategory' );

Route::get('delete-states-category/{id}','FAQController@DeleteCategory');







Route::get('my-orders','HomeController@my_orders');
Route::get("leave-review/{any}", "HomeController@leave_review");
Route::post("submit-review-for-product", "HomeController@submit_review_for_product");
Route::get("successfully-submit-review", "HomeController@successfully_submit_review");
 
Route::get('login/','AdminController@index');
Route::get('user-logout/','HomeController@user_logout');
Route::post('payment-gateway','HomeController@payment_gateway');
Route::get('thank-you/','HomeController@thankyou');
Route::get('category-thank-you/','HomeController@categorythankyou');
Route::get('home-thank-you/','HomeController@homethankyou');
Route::get('quote-thank-you/','HomeController@quotethankyou');
Route::get('beatmyprices-thank-you/','HomeController@beatmypricesthankyou');
Route::get('customboxes-thank-you/','HomeController@customboxesthankyou');


//paypal routes

Route::get('payment_method','PayPalController@payment_method');
Route::post('payment', 'PayPalController@payment')->name('payment');
Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
Route::get('payment/success', 'PayPalController@success')->name('payment.success');
Route::get('successfull-payment/{any}', 'PayPalController@successfull_payment');

Route::get("my-order-pay-now", "PayPalController@my_order_pay_now");
Route::get("order-details/{any}", "HomeController@order_details");
Route::get("account-setting", "HomeController@account_setting");
Route::post("update-profile", "HomeController@update_profile");

// Routes Create logout to redirect login Route

Route::get('logout/','AdminController@logout');

// Routes Redirect to admin Dashboard
// Routes Admin Product FAQ's Crud
Route::get('add-product-faq','FAQController@AddFAQ' );

Route::post('add-product-faq-data','FAQController@create' );

Route::get('show-product-faq','FAQController@showFAQ' );

Route::get('edit-product-faq/{id}','FAQController@editFAQ' );

Route::post('update-product-faq-data/{id}','FAQController@updateFAQ' );

Route::get('deletefaq/{id}','FAQController@destroy');
// Routes Admin Product FAQ's Crud



Route::post('create-user/','AdminController@login_user');

Route::get('dashboard/','DashboardController@index');

// Routes Change Password admin

Route::get('changepassword/', 'DashboardController@changePassword');

Route::post('change-password/','DashboardController@updatePassword');

// Routes Admin Blog Crud

Route::get('addblog/','BlogController@index');

Route::post('createblog/','BlogController@create');

Route::get('showblog/', 'BlogController@showBlog');

Route::get('editblog/{id}','BlogController@edit');

Route::post('updateblog/{id}','BlogController@update');

Route::get('only-view-blog/{id}','BlogController@viewBlog');

Route::get('deleteblog/{id}','BlogController@destroy');

Route::get('blog/','HomeController@our_blog_view');

Route::post('blog-search/','HomeController@blog_searchbar');



// Routes Admin Category Crud



Route::get('pro_shi','HomeController@pro_shi');

Route::get('addcategory/','CategoryController@index' );

Route::post('createcategory/','CategoryController@createCate' );

Route::get('showcategory/','CategoryController@show' );

Route::get('editcategory/{id}','CategoryController@edit' );

Route::get('only-view-category/{id}','CategoryController@onlyView' );

Route::post('updatecategory/{id}','CategoryController@update' );

Route::get('deletecategory/{id}','CategoryController@destroy' );

// Routes Admin Product Crud

Route::get('addproduct/','ProductController@index' );

Route::post('createproduct/','ProductController@create' );

Route::get('showproduct/','ProductController@show' );

Route::get('editproduct/{id}','ProductController@edit' );

Route::get('only-view-product/{id}','ProductController@onlyViewProduct' );

Route::post('updateproduct/{id}','ProductController@updateProduct' );

Route::get('deleteproduct/{id}','ProductController@destroy' );

Route::get('del-gallery-image/{name}/{id}', 'ProductController@del_gallery_image');



Route::post('get_col_by_change','HomeController@get_price_var3');
Route::post('get_price','HomeController@get_price');

// Routes Admin cardboard Boxes Product  Crud

Route::post('view-cart','HomeController@save_cart');
Route::get('remove-cart-data/','HomeController@remove_cart');  
Route::get('clear-cart-data','HomeController@clear_cart');  

Route::get('user-login','HomeController@user_login');  

Route::get('user-signup','HomeController@user_signup');  


Route::get('add-cardboard','OtherProductController@indexCardboard' );

Route::post('create-cardboard/','OtherProductController@createCardboard' );

Route::get('show-cardboard/','OtherProductController@showCardboard' );

Route::get('edit-cardboard/{id}','OtherProductController@editCardboard' );

Route::get('only-view-cardboard/{id}','OtherProductController@onlyViewCardboardProd' );

Route::post('update-cardboard/{id}','OtherProductController@updateCardboardProd' );

Route::get('delete-cardboard/{id}','OtherProductController@destroyCardboardProd' );

Route::get('del-cardboard-image/{name}/{id}', 'OtherProductController@del_cbgalery_image');

Route::get('corrugation-display-boxes', 'HomeController@cardboard_product');

// Routes Admin other Product  Crud

Route::get('add-otherproduct','OtherProductController@index' );


Route::get('add-ppc-pages','OtherProductController@ppc_page' );




Route::post('create-otherproduct/','OtherProductController@create' );

Route::post('create_ppc_page/','OtherProductController@create_ppc_page' );
Route::get('show_ppc_page/','OtherProductController@show_ppc_page' );




Route::get('sitemap.html', 'HomeController@sitemap_html');




Route::get('show-otherproduct/','OtherProductController@show' );

Route::get('edit-otherproduct/{id}','OtherProductController@edit' );

Route::get('edit_ppc_page/{id}','OtherProductController@edit_ppc_page' );




Route::get('only-view-otherproduct/{id}','OtherProductController@onlyViewProduct' );

Route::post('update-otherproduct/{id}','OtherProductController@updateProduct' );

Route::post('update_ppc_page/{id}','OtherProductController@update_ppc_page' );


Route::get('delete-otherproduct/{id}','OtherProductController@destroy' );

Route::get('destroy_ppc/{id}','OtherProductController@destroy_ppc' );






Route::get('del-otherprod-image/{name}/{id}', 'OtherProductController@del_galery_image');

Route::get('printing-products/', 'HomeController@other_product');


// Routes Admin Promotions Crud

Route::get('add-promotion/','DashboardController@Promotion' );

Route::post('create-promotion/','DashboardController@createPromotion' );

Route::get('show-promotions/','DashboardController@showPromotions' );

Route::get('edit-promotion/{id}','DashboardController@editPromotion' );

Route::get('brochures/{url}','HomeController@brochures');
Route::get('only-view-promotion/{id}','DashboardController@onlyViewPromotion' );

Route::post('update-promotion/{id}','DashboardController@updatePromotion' );

Route::get('delete-promotion/{id}','DashboardController@destroyPromotion' );




// Routes Admin Home slider Crud

Route::get('home-slider/','DashboardController@homeSlider');

Route::post('create-homeslider/','DashboardController@createSlider');

Route::get('show-homeslider/','DashboardController@showSlider');

Route::get('edit-homeslider/{id}','DashboardController@editSlider');

Route::get('only-view-homeslider/{id}','DashboardController@onlyViewSlider');

Route::post('update-homeslider/{id}','DashboardController@updateSlider');

Route::get('delete-homeslider/{id}','DashboardController@destroyHomeSlider');


// Routes Admin Testimonial slider Crud

Route::get('add-testimonial/','DashboardController@testimonial');
Route::post('create-testimonial/', 'DashboardController@createTestimonial');
Route::get('show-testimonial/', 'DashboardController@show_testimonial');
Route::get('edit-testimonial/{id}', 'DashboardController@edit_testimonial');
Route::get('only-view-testimonial/{id}', 'DashboardController@view_testimonial');
Route::post('update-testimonial/{id}', 'DashboardController@update_testimonial');
Route::get('delete-testimonial/{id}', 'DashboardController@deleteTestmonial');

// Routes Admin Customers

Route::get("add-customer", "DashboardController@add_customers");
Route::post("add-customer-process", "DashboardController@add_customers_process");
Route::get("show-customers", "DashboardController@show_customers");
Route::get("edit-customer/{any}", "DashboardController@edit_customer");
Route::post("edit-customer-process", "DashboardController@edit_customers_process");
Route::get("delete-customer/{any}", "DashboardController@delete_customer");

// Routes BOX DESIGN INSIPRES Crud

Route::get('add-boxdesign/','ProductController@boxdesign');
Route::post('create-boxdesign/', 'ProductController@create_boxdesign');
Route::get('show-boxdesign/', 'ProductController@show_boxdesign');
Route::get('edit-boxdesign/{id}', 'ProductController@edit_boxdesign');
Route::get('only-view-boxdesign/{id}', 'ProductController@view_boxdesign');
Route::post('update-boxdesign/{id}', 'ProductController@update_boxdesign');
Route::get('delete-boxdesign/{id}', 'ProductController@delete_boxdesign');


// Routes Admin Video Crud

Route::get('add-video/','DashboardController@video');
Route::post('create-video/', 'DashboardController@createVideo');

// Routes Admin Socials Crud

Route::get('add-socials/','DashboardController@socials');
Route::post('create-socials/', 'DashboardController@create_socials_Links');


// Routes Admin Promotions Crud

 
Route::get('home-content/','DashboardController@home_content');
Route::post('create-home-content/', 'DashboardController@create_homeContents');



// Routes Admin Dynamic Page Crud





Route::get('add-dynamic-page/','DashboardController@dynamic');
Route::post('create-dynamic-page/', 'DashboardController@createDynamic');
Route::get('show-dynamic-page/', 'DashboardController@show_dynamic');
Route::get('edit-dynamic-page/{id}', 'DashboardController@edit_dynamic');
Route::get('only-view-dynamic-page/{id}', 'DashboardController@view_dynamic');
Route::post('update-dynamic-page/{id}', 'DashboardController@update_dynamic');
Route::get('delete-dynamic-page/{id}', 'DashboardController@deleteDynamic');


// cart for merchant start

Route::get('/cart', [CartController::class, 'index']);
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'placeOrder']);
Route::post('/cart/add/{id}', [CartController::class, 'add']);
Route::post('/cart/update/{id}', [CartController::class, 'update']);
Route::post('/cart/remove/{id}', [CartController::class, 'remove']);

// cart for merchant end
// Sitemap
    Route::get('sitemap.xml', function() {
        $view = view('frontend/sitemap/sitemap');
        return Response::make($view)->header('Content-Type', 'text/xml');
    });



    Route::get('image-sitemap.xml', function() {
    $view = view('web/sitemap/sitemap');
    return Response::make($view)->header('Content-Type', 'text/xml');
});

// image Sitemap
     Route::get('image-sitemap.xml', function() {
        $view = view('frontend/sitemap/image-sitemap');
        return Response::make($view)->header('Content-Type', 'text/xml');
    });

    
   
    
    // Route::get('about-us/', 'HomeController@NewAboutus');

// Routes Request A Quote

Route::get('get-quote/', 'HomeController@requestQoute');


// Routes Contact Us

Route::get('contact-us/', 'HomeController@contactUs');

// Search routes




Route::post('search/','HomeController@searchbar');

// Route::get('cart','HomeController@cart');


Route::get('check-out','HomeController@check_out');
// 404 Error Page routes
Route::get('beat-my-price/','HomeController@BeatQuote');
Route::post('beat-my-price-form/','HomeController@BeatQuoteForm');

Route::get('404.php/','HomeController@error');
Route::post('admin/update-variation','ProductController@update_variation');
 
Route::get('product/admin/variation/{url}','ProductController@admin_add_variations');
Route::get('delete-all-variations/{any}','ProductController@delete_all_variations');
Route::post('reseller/variation/csv_import_data','ProductController@uploadFile');

Route::post('admin/newaddvariation','ProductController@newaddvariation');

Route::get('admin/delete-variation/{id}','ProductController@delete_variation');

// Admin Orders
Route::get("show-orders", "AdminController@admin_orders");
Route::get("admin-view-order/{any}", "AdminController@admin_view_order");
Route::post("update-admin-order-status", "AdminController@update_admin_order_status");

Route::get('{any}','HomeController@shop_detail');


// upload_csv Page routes

Route::get('email_subcribe', 'HomeController@subcribed_email');

Route::post('upload_csv', 'DashboardController@upload_csv');

// Route permotion

Route::get('promotions/','HomeController@promotions');



// Email Routs for all Forms


Route::post('email_contact_us/', 'HomeController@email_contact_us');

Route::post('email_subcribe/', 'HomeController@subcribed_email');

Route::post('email_promotions/', 'HomeController@email_prom_quot');

Route::post('email_requote/', 'HomeController@email_req_quote');

Route::post('email_prod_requote/', 'HomeController@email_prodreq_quote');


Route::post('user_signup_saved','HomeController@user_signup_saved');

Route::post('email_callback/', 'HomeController@email_callback');


Route::post('email_callback/', 'HomeController@email_callback');



Route::post('email_opcallback/', 'HomeController@email_opcallback');

Route::post('email_singleprod_requote/', 'HomeController@singleprod_reqquote');

Route::post('callback-email/', 'HomeController@callBack');


Route::post('get-a-quote-home/', 'HomeController@GetAQuote');

Route::post('ppc-form/', 'HomeController@PPCForm');


// Any routes

// Product Detail pages &&  single Product Pages && Categories Pages




Route::get('blog/{any}','HomeController@blog_detail');

Route::get('{any}/{name}','HomeController@shop_detail_2');
Route::get('admin/edit-variation/{id}/{any}','ProductController@edit_variation');
Route::get('{any}/{name}','HomeController@StateOnly');


?>
