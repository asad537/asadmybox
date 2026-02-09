<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FAQController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin_user_name') || !Session::has('admin_user_pass')) {
                return redirect('login');
            }
            return $next($request);
        });
    }
    
    
    
    
public function States()
{
    return view('admin.states.add');
}
    public function Save(Request $request)
{

    $data = 
            array(
                    'states' => $request->input('states'),
                     'code' => $request->input('code'),
                     'lcode' => $request->input('lcode'),
                     'latitude' => $request->input('latitude'),
                     'longitude' => $request->input('longitude'),
                     'status' => $request->input('status'),
                     'longdescription'=>$request->input('longdescription'),
                );
                
                 if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileExtension = $file->getClientOriginalName();
                $fileName = $fileExtension;
                $file->move('images/', $fileName);
                $data['image'] = $fileName;
                } else {
                $data['image'] = "";
                }


                 Session::flash('message', 'Data  inserted successfully !');
                 DB::table('states')->insert($data);
                 return redirect('add-states');
}
    public function Show()
{
      $data['all_states'] = DB::table('states')->get();
      return view('admin.states.view',  $data);
}
    public function Edit($id)
{
     $data['edit_view'] = DB::table('states')->where('id', $id)->get();
     return view('admin.states.update',$data);

}
    public function Update(Request $request, $id)
{

    $data = 
      array(
               'states' => $request->input('states'),
                 'code' => $request->input('code'),
               'status' => $request->input('status'),
                'latitude' => $request->input('latitude'),
                     'longitude' => $request->input('longitude'),
                'lcode' => $request->input('lcode'),
                   'longdescription'=>$request->input('longdescription'),
            );
    

  if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileExtension = $file->getClientOriginalName();
        $fileName = $fileExtension;
        $file->move('images/', $fileName);
        $data['image'] = $fileName;
    } else {
        $data['image'] = $request->input('oldimage');
    }
    
    DB::table('states')->where('id' , $id)->update($data);
    Session::flash('message' , 'Data Updated Successfully');
    return redirect('show-states');
}
    public function Delete($id)
{
    DB::table('states')->where('id', $id)->delete();
    Session::flash('message' , 'Data deleted Successfully');
    return redirect('show-states');
}


public function StatesCategory()
{
    $data['all_product'] = DB::table('products')->get();
    $data['all_states'] = DB::table('states')->get();
    $data['all_states_'] = DB::table('statescategories')->get();
    return view('admin.states.category', $data);
}

public function SaveCategory(Request $request)
{
    $data = [
        'cate_name' => $request->input('name'),
        'time'=> date('Y-m-d'),
        'sku' => $request->input('sku'),
        
        'l_price' => $request->input('l_price'),
        
        'h_price' => $request->input('h_price'),
        
        'cate_url' => $request->input('url'),
        
        'meta_title' => $request->input('meta_title'),
        
        'meta_description' => $request->input('meta_description'),
        
        'meta_tags' => $request->input('meta_tags'),
        
        'cate_long_desc' => $request->input('longdescription'),
        
        'state' => json_encode($request->input('states')),
        
        'state_products' => json_encode($request->input('related_product')),
        
        'relatedstate' => json_encode($request->input('relatedstate')),
        
        'check_product' => $request->input('check_product'),
    ];
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileExtension = $file->getClientOriginalName();
        $fileName = $fileExtension;
        $file->move('images/', $fileName);
        $data['cate_image'] = $fileName;
    } else {
        $data['cate_image'] = "";
    }
    
    $data['status'] = 0;
     Session::flash('message', 'Data Inserted Successfully');
        DB::table('statescategories')->insert($data);
        return redirect('add-states-category');
}

public function ShowCategory()
{
    $data['all_states_categories'] = DB::table('statescategories')->get();
    return view('admin.states.show-category', $data);
}

public function EditCategory($id)
{
    $data['all_products'] = DB::table('products')->get();
     $data['all_states'] = DB::table('states')->get();
    $data['edit_states_category'] = DB::table('statescategories')->where('id', $id)->get();
    $data['all_states_'] = DB::table('statescategories')->get();
    return view('admin.states.update-category', $data);
}


public function UpdateCategory(Request $request, $id)
{

     $data = [
         
        'sku' => $request->input('sku'),
        
        'l_price' => $request->input('l_price'),
        
        'h_price' => $request->input('h_price'),
         'time'=> date('Y-m-d'),
        'cate_name' => $request->input('name'),
        
        'cate_url' => $request->input('url'),
        
        'meta_title' => $request->input('meta_title'),
        
        'meta_description' => $request->input('meta_description'),
        
        'meta_tags' => $request->input('meta_tags'),
        
        'cate_long_desc' => $request->input('longdescription'),
        
        'state' => json_encode($request->input('states')),
        
        'state_products' => json_encode($request->input('related_product')),
        
        'relatedstate' => json_encode($request->input('relatedstate')),
        
        'check_product' => $request->input('check_product'),
    ];
   
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileExtension = $file->getClientOriginalName();
        $fileName = $fileExtension;
        $file->move('images/', $fileName);
        $data['cate_image'] = $fileName;
    } else {
        $data['cate_image'] = $request->input('oldimage');
    }
    Session::flash('message', 'Data Updated Successfully');

    DB::table('statescategories')->where('id', $id)->update($data);
   
    return redirect()->back()->with('success', 'your message,here');
}

public function DeleteCategory($id)
{
    DB::table('statescategories')->where('id', $id)->delete();
    Session::flash('message', 'Data Deleted Successfully');
    return redirect('show-states-category');
}

 

    public function AddFAQ()
    {
        $data["product"] = DB::table('products')->get();
        $data["category"] = DB::table('categories')->get();
        $data["printing_product"] = DB::table('otherproducts')->get();
        return view('admin.faq.add', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = 
                array(
                        'question' => $request->input('question'),
                        'answer' => $request->input('answer'),
                        'product_name' => $request->input('product_name'),
                        'category_name' => $request->input('category_name'),
                        'printing_product_name' => $request->input('printing_product_name'),
                    );

                     Session::flash('message', 'Data  inserted successfully !');
                     DB::table('faq')->insert($data);
                     return redirect('add-product-faq');
    }


    public function showFAQ()
    {
          $data['all_faq'] = DB::table('faq')->get();
          return view('admin.faq.view',  $data);
    }



    public function editFAQ($id)
    {
         $data['edit_view'] = DB::table('faq')->where('id', $id)->get();
         $data["product"] = DB::table('products')->get();
         $data["category"] = DB::table('categories')->get();
         $data["printing_product"] = DB::table('otherproducts')->get();
         return view('admin.faq.update',$data);

    }




    public function updateFAQ(Request $request, $id)
    {

        $data = 
          array(

                    'question' => $request->input('question'),
                    'answer' => $request->input('answer'),
                    'product_name' => $request->input('product_name'),
                    'category_name' => $request->input('category_name'),
                    'printing_product_name' => $request->input('printing_product_name'),
                );
        

        DB::table('faq')->where('id' , $id)->update($data);
        Session::flash('message' , 'Data Updated Successfully');
        return redirect('show-product-faq');
    }


    public function destroy($id)
    {
        DB::table('faq')->where('id', $id)->delete();
        Session::flash('message' , 'Data deleted Successfully');
        return redirect('show-product-faq');
    }
}
