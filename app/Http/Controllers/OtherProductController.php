<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OtherProductController extends Controller
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
        $data['all_products'] =  DB::table('otherproducts')->get();
        return view('admin.products.add-other-product',  $data);
    }

    public function ppc_page()
    {
 
        $data['all_products'] =  DB::table('products')->get();
        return view('admin.products.ppc-pages',$data);
    }
    


    public function create_ppc_page(Request $request)
    {

        // echo "testing  heloo";
 
        $data = array(

            'prod_name' =>  $request->input('productname'),
            'sample_alt_name' =>  $request->input('sample_alt_name'),
            'prod_url' =>  $request->input('producturl'),
            'meta_title' =>   $request->input('metatitle'),
            'meta_description' =>   $request->input('metadescription'),
            'meta_tags' =>   $request->input('metatags'),
            'prod_short_desc' =>   $request->input('shortdescription'),
            'main_altname' =>   $request->input('main_altname'),
            'content_1' =>   $request->input('content_1'),
            'content_1_altname' =>   $request->input('content_1_altname'),
            'content_2' =>   $request->input('content_2'),
            'content_2_altname' =>   $request->input('content_2_altname'),
            'related_prod' =>   json_encode($request->input('relatedProd')),
        );
        
        


        if($request->hasFile('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['prod_image'] = $fileName ;


        }else{
            $data['prod_image'] = "" ;
        }




        
        if($request->hasFile('image1')){

            $file = $request->file('image1');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['content_image_1'] = $fileName ;


        }else{
            $data['content_image_1'] = "" ;
        }

  
        if($request->hasFile('image2')){

            $file = $request->file('image2');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['content_image_2'] = $fileName ;


        }else{
            $data['content_image_2'] = "" ;
        }

        if($request->hasFile('sample_image')){

            $file = $request->file('sample_image');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['sample_image'] = $fileName ;


        }else{
            $data['sample_image'] = "" ;
        }

 

                DB::table('ppc_pages')->insert($data);
                Session::flash('message', 'Create successfully');
                return redirect('add-ppc-pages');
        

    }





    public function create(Request $request)
    {

        // echo "testing  heloo";

        $prod_name = trim($request->input('productname'));
        $prodname =   ucwords(strtolower($prod_name));

        $data = array(

            'prod_name' =>  $prodname,
            'prod_url' =>  $request->input('producturl'),
            'meta_title' =>   $request->input('metatitle'),
            'meta_description' =>   $request->input('metadescription'),
            'meta_tags' =>   $request->input('metatags'),
            'prod_short_desc' =>   $request->input('shortdescription'),
            'prod_long_desc' =>   $request->input('longdescription'),
            'prod_altname' =>   $request->input('altname'),
            'related_prod' =>   json_encode($request->input('relatedProd')),
        );
        
        


        if($request->hasFile('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['prod_image'] = $fileName ;


        }else{
            $data['prod_image'] = "" ;
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

        $exists = DB::table('otherproducts')->where('prod_name',  $prodname )->first();


        if(!$exists){
                Session::flash('message', ' Single   Other products inserted successfully');
                DB::table('otherproducts')->insertOrIgnore($data);
                return redirect('add-otherproduct');
        }else{
            Session::flash('error', 'Same data already exists!');
            return redirect('add-otherproduct');
        }

    }


    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        $data['all_products'] =  DB::table('otherproducts')->get();
        return view('admin.products.show-other-product',  $data);
    }



    public function show_ppc_page()
    {
        $data['all_products'] =  DB::table('ppc_pages')->get();
        return view('admin.products.show_ppc_page',  $data);
    }

    





    public function edit($id)
    {
        $data['edit_products'] =  DB::table('otherproducts')->where('id', $id)->get();
        
       
        
        $data['all_otherproducts'] =  DB::table('otherproducts')->get();
        return view('admin.products.update-other-product',  $data);
    }




    public function edit_ppc_page($id)
    {
        $data['edit_products'] =  DB::table('ppc_pages')->where('id', $id)->get();
        
       
        
        $data['all_otherproducts'] =  DB::table('products')->get();
        return view('admin.products.update_ppc_pages',  $data);
    }



    





    public function onlyViewProduct($id)
    {
        $data['edit_products'] =  DB::table('otherproducts')->where('id', $id)->get();
        $data['all_otherproducts'] =  DB::table('otherproducts')->get();
        return view('admin.products.only-view-otherproduct',  $data);
    }



    

    public function update_ppc_page(Request $request, $id)
    {
 
    
        $data = array(

            'prod_name' =>  $request->input('productname'),
            'sample_alt_name' =>  $request->input('sample_alt_name'),
            'prod_url' =>  $request->input('producturl'),
            'meta_title' =>   $request->input('metatitle'),
            'meta_description' =>   $request->input('metadescription'),
            'meta_tags' =>   $request->input('metatags'),
            'prod_short_desc' =>   $request->input('shortdescription'),
            'main_altname' =>   $request->input('main_altname'),
            'content_1' =>   $request->input('content_1'),
            'content_1_altname' =>   $request->input('content_1_altname'),
            'content_2' =>   $request->input('content_2'),
            'content_2_altname' =>   $request->input('content_2_altname'),
            'related_prod' =>   json_encode($request->input('relatedProd')),
        );
        
        


        if($request->hasFile('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['prod_image'] = $fileName ;


        }else{
            
            $data['prod_image'] =  $request->input('prod_image');
        }




        
        if($request->hasFile('image1')){

            $file = $request->file('image1');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['content_image_1'] = $fileName ;


        }else{
           
            $data['content_image_1'] =  $request->input('content_image_1');
        }

  
        if($request->hasFile('image2')){

            $file = $request->file('image2');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['content_image_2'] = $fileName ;


        }else{
    
            $data['content_image_2'] =  $request->input('content_image_2');
        }
        
        if($request->hasFile('sample_image')){

            $file = $request->file('sample_image');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['sample_image'] = $fileName ;


        }else{
            
            $data['sample_image'] =  $request->input('sample_image');
        }
 

              
          
                Session::flash('message', 'Single other Product Updated Successfully');
                DB::table('ppc_pages')->where('id', $id)->update($data);
                return redirect('edit_ppc_page'.'/'.$id);

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
             'related_prod' => json_encode($request->input('relatedProd')),
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
             $data['prod_image'] =  $request->input('oldimage');
         }

         if($request->hasfile('images'))
         {
            foreach($request->file('images') as $image)
            {
                $name=$image->getClientOriginalName();
                $image->move('images/', $name);
                $temp_gallery[] = $name;
            }

                // echo "<pre>";
                // print_r($temp_gallery);
                // die();


            if($request->input('oldgallery')){
               $data['prod_gallery']= json_encode(array_merge($request->input('oldgallery'),$temp_gallery));

                // echo "<pre>";
                // print_r($data['prod_gallery']);
                // die();
            }else {
                $data['prod_gallery']=json_encode($temp_gallery);
            }
         }
             Session::flash('message', 'Single other Product Updated Successfully');
             DB::table('otherproducts')->where('id', $id)->update($data);
             return redirect('edit-otherproduct'.'/'.$id);

    }



    public function destroy_ppc($id)
    {

        DB::table('ppc_pages')->where('id', $id)->delete();
        Session::flash('message', ' products deleted successfully');
        return redirect('show_ppc_page');

    }



    public function destroy($id)
    {

        DB::table('otherproducts')->where('id', $id)->delete();
        Session::flash('message', 'Single Other products deleted successfully');
        return redirect('show-otherproduct');

    }



       public function del_galery_image($name,$id){
        if (!empty($id)) {
               $exData = DB::table('otherproducts')->where('id', $id)->get();
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
                DB::table('otherproducts')->where('id',$id)->update($data);
                return  redirect('edit-otherproduct/'.$id);
            } else{
                echo "image  already deleted";
                // Session::flash('error_img', 'Image  already deleted');
                // return redirect('update-product/'.$id);
        }
    }
    
    
    
    
    
    
    // Cardboard Boxes Crud 
    
    
    
    
    
    public function indexCardboard()
    {
      
        $data['all_cbproducts'] =  DB::table('cardboardboxes')->get();
        // return view('admin.products.add-other-product',  $data);
        return view('admin.cardboard.add-cardboard',  $data);
    }

    public function createCardboard(Request $request)
    {

        // echo "testing  heloo";

        $prod_name = trim($request->input('productname'));
        $prodname =   ucwords(strtolower($prod_name));

        $data = array(

            'prod_name' =>  $prodname,
            'prod_url' =>  $request->input('producturl'),
            'meta_title' =>   $request->input('metatitle'),
            'meta_description' =>   $request->input('metadescription'),
            'meta_tags' =>   $request->input('metatags'),
            'prod_short_desc' =>   $request->input('shortdescription'),
            'prod_long_desc' =>   $request->input('longdescription'),
            'prod_altname' =>   $request->input('altname'),
            'related_prod' =>   json_encode($request->input('relatedProd')),
        );
        
        


        if($request->hasFile('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $fileName   =  $extension;
            $file->move('images/',$fileName);
            $data['prod_image'] = $fileName ;


        }else{
            $data['prod_image'] = "" ;
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

        $exists = DB::table('cardboardboxes')->where('prod_name',  $prodname )->first();


        if(!$exists){
                Session::flash('message', ' Single cardboard product inserted successfully');
                DB::table('cardboardboxes')->insertOrIgnore($data);
                return redirect('add-cardboard');
        }else{
            Session::flash('error', 'Same data already exists!');
            return redirect('add-cardboard');
        }

    }





    public function showCardboard()
    {
        $data['all_products'] =  DB::table('cardboardboxes')->get();
        return view('admin.cardboard.show-cardboard',  $data);
    }


    public function editCardboard($id)
    {
        
       
        $data['edit_products'] =  DB::table('cardboardboxes')->where('id', $id)->get();
        
       
        
        $data['all_otherproducts'] =  DB::table('cardboardboxes')->get();
        return view('admin.cardboard.update-cardboard',  $data);
    }

    public function onlyViewCardboardProd($id)
    {
        $data['edit_products'] =  DB::table('cardboardboxes')->where('id', $id)->get();
        $data['all_otherproducts'] =  DB::table('cardboardboxes')->get();
        return view('admin.cardboard.only-view-cardboard',  $data);
    }


    public function updateCardboardProd(Request $request, $id)
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
             'related_prod' => json_encode($request->input('relatedProd')),
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

                // echo "<pre>";
                // print_r($data['prod_gallery']);
                // die();
            }else {
                $data['prod_gallery']=json_encode($temp_gallery);
            }
         }
         
        // echo "<pre>";
        // print_r($data);
        // die();

         
             Session::flash('message', 'Single Cardboard product Updated Successfully');
             DB::table('cardboardboxes')->where('id', $id)->update($data);
             return redirect('edit-cardboard'.'/'.$id);

    }



    public function destroyCardboardProd($id)
    {

        DB::table('cardboardboxes')->where('id', $id)->delete();
        Session::flash('message', 'Single Cardboard product deleted successfully');
        return redirect('show-cardboard');

    }



       public function del_cbgalery_image($name,$id){
        if (!empty($id)) {
               $exData = DB::table('cardboardboxes')->where('id', $id)->get();
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
                DB::table('cardboardboxes')->where('id',$id)->update($data);
                return  redirect('edit-cardboard'.'/'.$id);
            } else{
                echo "image  already deleted";
                // Session::flash('error_img', 'Image  already deleted');
                // return redirect('update-product/'.$id);
        }
    }

}
