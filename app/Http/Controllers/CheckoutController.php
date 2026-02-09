<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Logo;
use App\Models\Information;
use App\Models\Category;
use App\Models\Page;
use DB;
class CheckoutController extends Controller
{
    
public function index()
{
    $cart = session()->get('cart', []);
    // dd($cart);
    $total = 0;

    if (is_array($cart)) {
        foreach ($cart as $item) {
            if (is_array($item) && isset($item['price'], $item['quantity'])) {
                $total += floatval($item['price']) * intval($item['quantity']);
            }
        }
    }
        //  dd($cart);
        $meta_title = "";
        $meta_tags = "";
        $meta_description = "";
        $parent_category = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();
        $all_subcategory = DB::table('categories')->where('status', '=', '0')->get();
        
    return view('web.checkout.index', compact('cart', 'total','meta_title','meta_tags','meta_description','parent_category','all_subcategory'));
}

public function placeOrder(Request $request)
{
    
    $cart = session()->get('cart');
 
    if (!$cart) return redirect('/')->with('error', 'Cart is empty.');


    $orderId = DB::table('orders')->insertGetId([
        
    'firstname' => $request->f_name,
    
    'lastname' => $request->l_name,
    
    'companyname' => $request->c_name,
    
    'country' => $request->country,
    
    'address' => $request->address1,
    
    'address2' => $request->address2,
    
    'city' => $request->city,
    
    'state' => $request->state,
    
    'zipcode' => $request->zip,
    
    'phone' => $request->phone,
    
    'email' => $request->email,
    
    'message' => $request->message,
    
    'payment_method' => "Cash on Delivery",
    
    'order_total' => 1,
]);
  
    foreach ($cart as $productId => $item) {
       DB::table('order_items')->insert([
    'order_id' => $orderId, // assuming you're using $orderId from the previous insert
    'product_id' => $productId,
    'quantity' => $item['quantity'],
    'price' => $item['price'],
]);
    }

    session()->forget('cart');
    return redirect('thank-you')->with('SuccessOrdered', 'Order placed successfully!');
}

}