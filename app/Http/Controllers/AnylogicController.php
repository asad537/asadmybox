public function shop_detail($url){
        $links = trim($url);
        $linkChange =   str_replace('-', ' ', strtolower($links)) ;
            // echo $linkChange ;

            $data['url_links'] = DB::table('dynamic_pages')->where('page_url',$linkChange)->get();

            if(count($data['url_links'])>0){
                $data['parent_category'] = DB::table('categories')->where('parent_cate', 0)->get();
                $data['all_subcategory'] = DB::table('categories')->get();
                $data['all_products'] = DB::table('products')->get();
                $data['our_socials']  =DB::table('socials_media')->get();

                // echo ($data['url_links'][0]->page_name);
                // die();

                return  view('frontend.pages.dynamic-page', $data);
            }else{

                $data['url_links'] = DB::table('categories')->where('cate_url',$linkChange)->get();
                if(count($data['url_links'])>0){
                    $data['parent_category'] = DB::table('categories')->where('parent_cate', 0)->get();
                    $data['all_subcategory'] = DB::table('categories')->get();
                    $data['all_products'] = DB::table('products')->get();
                    $data['our_socials']  =DB::table('socials_media')->get();
                    $data['sub_categories']  = DB::table('categories')->where('parent_cate', $data['url_links'][0]->id)->get();
                    $data['sub_products']  =DB::table('products')->where('prod_category', $data['url_links'][0]->id)->get();
                    // echo "<pre>";
                    // echo print_r($data['sub_categories']);
                    // die();
                    return  view('frontend.categories.category', $data);

                }else{

                    $data['url_links'] = DB::table('products')->where('prod_url',$linkChange)->get();
                    if(count($data['url_links']) > 0){

                        $data['parent_category'] = DB::table('categories')->where('parent_cate', 0)->get();
                        $data['all_subcategory'] = DB::table('categories')->get();
                        $data['all_products'] = DB::table('products')->get();
                        $data['our_socials']  =DB::table('socials_media')->get();
                        return  view('frontend.products.product-detail', $data);

                    }
                    else{
                            $data['url_links'] = DB::table('otherproducts')->where('prod_url',$linkChange)->get();
                            if( count($data['url_links'])> 0 ){
                                $data['parent_category'] = DB::table('categories')->where('parent_cate', 0)->get();
                                $data['all_subcategory'] = DB::table('categories')->get();
                                $data['all_products'] = DB::table('products')->get();
                                $data['our_socials']  =DB::table('socials_media')->get();
                                $data['all_otherprods']  = DB::table('otherproducts')->get();
                                return  view('frontend.products.single-otherproduct-detail', $data);
                            } else{
                                return redirect('404.php');
                           }
                    }
            }
        }
    }
