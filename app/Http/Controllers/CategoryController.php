<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
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
        $data['all_categories'] = DB::table('categories')->get();
        return view('admin.categories.add-category', $data);
    }

    public function createCate(Request $request)
    {
        $cate_name = trim($request->input('catename'));
        $catename = ucwords(strtolower($cate_name));

        //  echo $catename;
        //  die();

        $data = [
            'cate_name' => $catename,
            'cate_url' => $request->input('cateurl'),
            'meta_title' => $request->input('metatitle'),
            'meta_description' => $request->input('metadescription'),
            'meta_tags' => $request->input('metatags'),
            'cate_long_desc' => $request->input('longdescription'),
            'parent_cate' => $request->input('parentcate'),
            'show_on_home' => $request->has('show_on_home') ? 1 : 0,
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

        if ($request->hasFile('hoverimage')) {
            $file = $request->file('hoverimage');
            $fileExtension = $file->getClientOriginalName();
            $fileName = $fileExtension;
            $file->move('images/', $fileName);
            $data['cate_overlay_image'] = $fileName;
        } else {
            $data['cate_overlay_image'] = "";
        }

        if ($request->hasFile('catebanner')) {
            $file = $request->file('catebanner');
            $fileExtension = $file->getClientOriginalName();
            $fileName = $fileExtension;
            $file->move('images/', $fileName);
            $data['cate_banner'] = $fileName;
        } else {
            $data['cate_banner'] = "";
        }
        $data['status'] = 0;

            // echo "<pre>";
            // print_r($data);
            // die();

        // 1st method

        $exists = DB::table('categories')->where('cate_name', $catename)->first();
   
        if (!$exists) {
         Session::flash('message', 'Category Inserted Successfully');
            DB::table('categories')->insert($data);
            \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
            return redirect('addcategory');
        } else {
            Session::flash('error', 'Same Category Already Exist!');
            return redirect('addcategory');
        }

        // 2nd method Laravel 5.8

        // try {

        //         $insert = DB::table('categories')->insert($data);;
        //         if(!$insert){
        //             return redirect('addcategory');
        //         }
        //         else{
        //             Session::flash('message','Category Inserted Successfully');
        //             return redirect('addcategory');
        //         }
        //     } catch(\Illuminate\Database\QueryException $e){
        //         $errorCode = $e->errorInfo[1];
        //         if($errorCode == '1062'){
        //             Session::flash('error', 'Same Category Already Exist!');
        //             return redirect('addcategory');
        //         }
        //     }
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        $data['all_categories'] = DB::table('categories')->get();
        return view('admin.categories.show-category', $data);
    }

    public function edit($id)
    {
        $data['all_categories'] = DB::table('categories')->get();
        $data['edit_category'] = DB::table('categories')
            ->where('id', $id)
            ->get();
        return view('admin.categories.update-category', $data);
    }

    public function onlyView($id)
    {
        $data['all_categories'] = DB::table('categories')->get();
        $data['edit_category'] = DB::table('categories')
            ->where('id', $id)
            ->get();
        return view('admin.categories.only-view-category', $data);
    }

    public function update(Request $request, $id)
    {
        // echo "create category";

        $cate_name = trim($request->input('catename'));
        $catename = ucwords(strtolower($cate_name));

        //  echo $catename;
        //  die();

        $data = [
            'cate_name' => $catename,
            'cate_url' => $request->input('cateurl'),
            'meta_title' => $request->input('metatitle'),
            'meta_description' => $request->input('metadescription'),
            'meta_tags' => $request->input('metatags'),
            'cate_long_desc' => $request->input('longdescription'),
            'parent_cate' => $request->input('parentcate'),
             'time'=> date('Y-m-d'),
             'show_on_home' => $request->has('show_on_home') ? 1 : 0,
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

        if ($request->hasFile('hoverimage')) {
            $file = $request->file('hoverimage');
            $fileExtension = $file->getClientOriginalName();
            $fileName = $fileExtension;
            $file->move('images/', $fileName);
            $data['cate_overlay_image'] = $fileName;
        } else {
            $data['cate_overlay_image'] = $request->input('old_overlayimage');
        }

        if ($request->hasFile('catebanner')) {
            $file = $request->file('catebanner');
            $fileExtension = $file->getClientOriginalName();
            $fileName = $fileExtension;
            $file->move('images/', $fileName);
            $data['cate_banner'] = $fileName;
        } else {
            $data['cate_banner'] = $request->input('oldbanner2');
        }

        Session::flash('message', 'Category Updated Successfully');

        DB::table('categories')
            ->where('id', $id)
            ->update($data);

        \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');

       
        return redirect()->back()->with('success', 'your message,here');
    }

    public function destroy($id)
    {
        DB::table('categories')
            ->where('id', $id)
            ->delete();
        \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
        Session::flash('message', 'Category Deleted Successfully');
        return redirect('showcategory');
    }
}
