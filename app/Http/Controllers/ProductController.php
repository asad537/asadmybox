<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
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
    
    
    public function index()
    {
         $data['all_products'] = DB::table('products')->get();
         $data['all_categories'] = DB::table('categories')->get();
         return view('admin.products.add-product',  $data);
    }



    public function create(Request $request)
    {
        // dd($request->all());
        // die();

       $product_name = trim($request->input('productname'));
       $productname  = ucwords(strtolower($product_name));

        // echo  $productname ;
        // die();

        $data = [
            'prod_name' => $productname ,
            'prod_url' => $request->input('producturl'),
            'meta_title' => $request->input('metatitle'),
            'meta_description' => $request->input('metadescription'),
            'meta_tags' => $request->input('metatags'),
            'prod_short_desc' => $request->input('shortdescription'),
            'prod_long_desc' => $request->input('longdescription'),
            'prod_altname' => $request->input('altname'),
            'feature_prod' => $request->input('is_active_feature'),
            'new_arrival' => $request->input('new_arrival'),
            'best_seller' => $request->input('best_seller'),
            'special_offer' => $request->input('special_offer'),
            'related_prod' => json_encode($request->input('relatedProds')),
            'prod_category' => $request->input('parentcate'),
            'rating_value' => $request->input('rating_value') ?? 4.9,
            'review_count' => $request->input('review_count') ?? 312,
            'low_price' => $request->input('low_price') ?? 0.7,
            'high_price' => $request->input('high_price') ?? 99,
        ];

        //  $rp =   $data['related_prod'];
        // echo $rp;
        // die();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = $extension;
            $file->move('images/', $filename);
            $data['prod_image'] = $filename;
        }else {
            $data['prod_image'] = "";
        }


        if ($request->hasFile('hoverimage')) {
            $file = $request->file('hoverimage');
            $extension = $file->getClientOriginalName();
            $filename = $extension;
            $file->move('images/', $filename);
            $data['prod_hoverImage'] = $filename;
        }else {
            $data['prod_hoverImage'] = "";
        }

        if ($request->hasFile('images')) {

            $files = $request->file('images');

             foreach ($files as $file ) {
                $extension = $file->getClientOriginalName();
                $filename = $extension;
                $file->move('images/', $filename);
                $images[] =  $filename;
                $data['prod_gallery'] = json_encode($images);
            }
        } else {

             $data['prod_gallery'] = "";

        }

       
        // echo "<pre>";
        
        // print_r($data) ;
        // die();


        $exists = DB::table('products')->where('prod_name', $productname)->first();

        if(!$exists) {
            Session::flash('message', 'Single Product Inserted Successfully');
            DB::table('products')->insertOrIgnore($data);
            \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
            return redirect('addproduct');
        } else {
            Session::flash('error', 'Same Data Already Exist');
            return redirect('addproduct');
        }

    }



    public function show()
    {

        $data['all_products'] = DB::table('products')->get();
        return view('admin.products.show-product', $data);
    }


    public function edit($id)
    {
        $data['edit_products'] = DB::table('products')->where('id' , $id)->get();
        $data['all_categories'] = DB::table('categories')->get();
        $data['all_products'] = DB::table('products')->get();
        return view('admin.products.update-product' , $data);
    }


    public function onlyViewProduct($id)
    {
        $data['edit_products'] = DB::table('products')->where('id' , $id)->get();

        $data['all_categories'] = DB::table('categories')->get();

        $data['all_products'] = DB::table('products')->get();

        return view('admin.products.only-view-product' , $data);
    }



    public function updateProduct(Request $request, $id)
    {
 
         $data = [
             'prod_name' => $request->input('productname'),
             'prod_url' => $request->input('producturl'),
             'meta_title' => $request->input('metatitle'),
             'meta_description' => $request->input('metadescription'),
             'meta_tags' => $request->input('metatags'),
             'prod_short_desc' => $request->input('shortdescription'),
             'prod_long_desc' => $request->input('longdescription'),
             'prod_altname' => $request->input('altname'),
             'feature_prod' => $request->input('is_active_feature') ? true  : false,
             'new_arrival' => $request->input('new_arrival') ? true : false,
             'best_seller' => $request->input('best_seller') ? true : false,
             'special_offer' => $request->input('special_offer') ? true : false,
             'related_prod' => json_encode($request->input('relatedProds')),
             'prod_category' => $request->input('parentcate'),
             'rating_value' => $request->input('rating_value') ?? 4.9,
             'review_count' => $request->input('review_count') ?? 312,
             'low_price' => $request->input('low_price') ?? 0.7,
             'high_price' => $request->input('high_price') ?? 99,
             'time'=> date('Y-m-d'),
         ];
 
         if ($request->hasFile('image')) {
             $file = $request->file('image');
             $extension = $file->getClientOriginalName();
             $filename = $extension;
             $file->move('images/', $filename);
             $data['prod_image'] = $filename;
         }else {
             $data['prod_image'] =  $request->input('oldimage');
         }

         if ($request->hasFile('hoverimage')) {
            $file = $request->file('hoverimage');
            $extension = $file->getClientOriginalName();
            $filename = $extension;
            $file->move('images/', $filename);
            $data['prod_hoverImage'] = $filename;
        }else {
            $data['prod_hoverImage'] =  $request->input('oldhoverimage');
        }
    if($request->hasfile('images'))
         {
            foreach($request->file('images') as $image)
            {
                $name=$image->getClientOriginalName();
                $image->move('images/', $name);
                $temp_gallery[] = $name;
            }
 
            if($request->input('oldgallery')){
               $data['prod_gallery']= json_encode(array_merge($request->input('oldgallery'),$temp_gallery));
 
            }else {
                $data['prod_gallery']=json_encode($temp_gallery);
            }
         }

     

        Session::flash('message', 'Single Product Updated Successfully');
      DB::table('products')->where('id', $id)->update(array_merge($data, ['time' => now()->format('Y-m-d')]));
      \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
    
    
        // DB::table('products')->where('id', $id)->update($data);
        return redirect('editproduct'.'/'.$id);

    }



    public function destroy($id)
    {
         DB::table('products')->where('id',$id)->delete();
         \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
         Session::flash('message', 'Single Product deleted Successfully');
         return redirect('showproduct');
    }


    public function del_gallery_image($name,$id){
        if (!empty($id)) {
               $exData = DB::table('products')->where('id', $id)->get();
               $exData = json_decode(json_encode($exData), true);
               $exImages = json_decode($exData[0]['prod_gallery']);
               $exImages  = json_decode(json_encode( $exImages), true);
               $newImages = array_diff($exImages, array($name));
               //3
                    // echo "<pre>";
                    // print_r($newImages);
                    // die();
                $data = [
                  'prod_gallery' => json_encode($newImages),
                ];
                //    echo $data['prod_gallery'];
                //    die();
                DB::table('products')->where('id',$id)->update($data);
                return  redirect('editproduct/'.$id);
            } else{
                echo "image  already deleted";
                // Session::flash('error_img', 'Image  already deleted');
                // return redirect('update-product/'.$id);
        }
    }


    
    //  ******************** Testimonial Crud  Start ********************  //

    public function boxdesign()
    {
        return view('admin.boxdesign.add-boxdesign');
    }

    public function create_boxdesign(Request $request)
    {
        $box_name = trim($request->input('box_name'));
        $boxname  = ucwords(strtolower($box_name));
 

        $data = [
            'box_name' => $boxname,
            'box_desc' => $request->input('box_desc'),
            'box_link' => $request->input('box_link'),
            'box_position' => $request->input('box_position'),
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalName();
            $fileName = $fileExtension;
            $file->move('images/boxdesigns/', $fileName);
            $data['box_image'] = $fileName;
        } else {
            $data['box_image'] = "";
        }
        

        Session::flash('message', 'Box design Inserted Successfully');
        DB::table('box_designs')->insert($data);
        \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
        return redirect('add-boxdesign');

    }

    public function show_boxdesign()
    {
      

        $data['all_boxes'] = DB::table('box_designs')->get();
        return view('admin.boxdesign.show-boxdesign', $data);
    }

    public function edit_boxdesign($id)
    {
        $data['edit_boxes'] = DB::table('box_designs')->where('id', $id)->get();
        return view('admin.boxdesign.update-boxdesign', $data);
    }

    public function view_boxdesign($id)
    {
        $data['edit_boxes'] = DB::table('box_designs')->where('id', $id)->get();
        return view('admin.boxdesign.only-view-boxdesign', $data);
    }

    public function update_boxdesign(Request $request, $id)
    {
        $box_name = trim($request->input('box_name'));
        $boxname  = ucwords(strtolower($box_name));
 
        $data = [
            'box_name' => $boxname,
            'box_desc' => $request->input('box_desc'),
            'box_link' => $request->input('box_link'),
            'box_position' => $request->input('box_position'),
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalName();
            $fileName = $fileExtension;
            $file->move('images/boxdesigns/', $fileName);
            $data['box_image'] = $fileName;
        } else {
            $data['box_image'] = $request->input('oldimage');
        }

        Session::flash('message', 'Home Slider updated Successfully');
        DB::table('box_designs')->where('id', $id)->update($data);
        \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
        return redirect('show-boxdesign');
    }


    public function delete_boxdesign($id)
    {
        DB::table('box_designs')->where('id', $id)->delete();
        \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
        Session::flash('message', 'boxdesign Slide Deleted Successfully');
        return redirect('show-boxdesign');
    }

    //  ******************** Testimonial Crud End ********************  //
}
