<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        // dd($cart);
        $meta_title = "";
        $meta_tags = "";
        $meta_description = "";
        $parent_category = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();
        $all_subcategory = DB::table('categories')->where('status', '=', '0')->get();
        
        
        
        return view('web.cart.index', compact('cart','meta_title','meta_description','meta_tags','parent_category','all_subcategory'));
    }
    
    public function add($id)
    {
       
        $product = DB::table('products')->where('id', $id)->first();
        // print_r($product);
        // die();
         
        $cart = session()->get('cart', []);
   
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->prod_name,
                "quantity" => 1,
                "price" => 1,
                "image" => $product->prod_image,
            ];
        }
    
        session()->put('cart', $cart);
        return redirect('/cart')->with('success', 'Product added!');
    }
    
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return redirect('/cart');
    }
    
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect('/cart');
    }

}