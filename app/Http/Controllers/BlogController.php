<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
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
          $data['all_blogs'] = DB::table('blogs')->get();
        return view('admin.blogs.add-blog',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
public function create(Request $request)
{
    function cleanInvisibleChars($string) {
    
        return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $string);
    }

    $blog_title = trim($request->input('blogtitle'));
    $blogtitle = ucwords(strtolower($blog_title));

    $longdescription = cleanInvisibleChars($request->input('longdescription'));

    $data = [
        't_title' => $blogtitle,
        't_slug' => $request->input('blogurl'),
        'tag' => $request->input('metatitle'),
        'metadesc' => $request->input('metadescription'),
        'keywords' => $request->input('metatags'),
        'tags_clouds' => $request->input('tagclouds'),
        't_author' => $request->input('authorname'),
        't_d_text' =>  $longdescription,
        'alt' => $request->input('altname'),
        'time' => now()->format('Y-m-d'),
    ];

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('images/blog'), $fileName);
        $data['t_featured_image'] = $fileName;
    } else {
        $data['t_featured_image'] = '';
    }

    $exists = DB::table('blogs')->where('t_title', $blogtitle)->first();

    if (!$exists) {
        DB::table('blogs')->insert($data);
        \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
        Session::flash('message', 'Blog inserted successfully!');
    } else {
        Session::flash('error', 'Blog with the same title already exists!');
    }

    return redirect('addblog');
}



    public function store(Request $request)
    {
        //
    }


    public function showBlog()
    {
          $data['all_blogs'] = DB::table('blogs')->get();
          return view('admin.blogs.show-blog',  $data);
    }



    public function edit($id)
    {
     
         $data['edit_view'] = DB::table('blogs')->where('t_id', $id)->get();
        
        
        
          $data['all_blogs'] = DB::table('blogs')->get();
         return view('admin.blogs.update-blog',$data);

    }



    public function viewBlog($id)
    {
         $data['edit_view'] = DB::table('blogs')->where('t_id', $id)->get();
         return view('admin.blogs.view-blog',$data);

    }



    public function update(Request $request, $id)
    {
          function cleanInvisibleChars($string) {
        // Remove zero-width spaces, byte order marks, etc.
        return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $string);
    }

    $blog_title = trim($request->input('blogtitle'));
    $blogtitle = ucwords(strtolower($blog_title));

    $longdescription = cleanInvisibleChars($request->input('longdescription'));
    
        
    $blog_title =   trim($request->input('blogtitle'));

    $blogtitle =  ucwords(strtolower($blog_title));


        $data = array(

            't_title' => $blogtitle,
            't_slug' => $request->input('blogurl'),
            'tag' => $request->input('metatitle'),
            'metadesc' => $request->input('metadescription'),
            'keywords' => $request->input('metatags'),
            'tags_clouds' => $request->input('tagclouds'),
            't_author' => $request->input('authorname'),
 't_d_text' => $longdescription,

            'alt' => $request->input('altname'),
               'time'=> date('Y-m-d'),
         );
         if($request->hasFile('image')){
              $file = $request->file('image');
              $file_extension = $file->getClientOriginalName();
              $fileName = $file_extension;
              $file->move('images/blog/', $fileName );
              $data['t_featured_image']  =  $fileName;
         }else{
            $data['t_featured_image']  =  $request->input('oldImage');
         }

        
        DB::table('blogs')->where('t_id' , $id)->update($data);
        \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
        Session::flash('message' , 'Your blog Updated Successfully');
        return redirect('/showblog');
    }


    public function destroy($id)
    {
        // echo "Testing Delete Id";

        DB::table('blogs')->where('t_id', $id)->delete();
        \Illuminate\Support\Facades\Cache::forget('home_page_data_v1');
        Session::flash('message' , 'Your blog deleted Successfully');
        return redirect('/showblog');
    }
}
