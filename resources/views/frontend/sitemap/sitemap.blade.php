<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
<loc>{{url('/')}}</loc>
<lastmod>2024-05-11</lastmod>
<changefreq>weekly</changefreq>
<priority>0.7</priority>
</url>
 

  <url>
 <loc>https://www.myboxprinting.com/printing-products/</loc>
<lastmod>2024-05-11</lastmod>
<changefreq>weekly</changefreq>
<priority>0.7</priority>
</url>


  <url>
 <loc>https://www.myboxprinting.com/contact-us/</loc>
<lastmod>2024-05-11</lastmod>
<changefreq>weekly</changefreq>
<priority>0.7</priority>
</url>



  <url>
 <loc>https://www.myboxprinting.com/blog/</loc>
<lastmod>2024-05-11</lastmod>
<changefreq>weekly</changefreq>
<priority>0.7</priority>
</url>



  <url>
 <loc>https://www.myboxprinting.com/get-quote/</loc>
<lastmod>2024-05-11</lastmod>
<changefreq>weekly</changefreq>
<priority>0.7</priority>
</url>

 

 


<?php $all_otherprods = DB::table('otherproducts')->get(); 

foreach($all_otherprods as $key=>$value_ss){
	?>
	<url>
<loc>{{url(str_replace(' ','-',strtolower($value_ss->prod_url)))}}/</loc>
<lastmod>2024-05-11</lastmod>
<changefreq>Weekly</changefreq>
<priority>0.7</priority>
</url>
	<?php
}

?>
 


<?php $dynamic=DB::table('dynamic_pages')->where('status',1)->get();


foreach ($dynamic as $bb) {?>

<url>
<loc>{{url(str_replace(' ','-',strtolower('/' . $bb->page_url)))}}/</loc>
<lastmod>2024-05-11</lastmod>
<changefreq>Weekly</changefreq>
<priority>0.7</priority>
</url>
<?php }?> 

<?php $add_category=DB::table('categories')->get();
foreach ($add_category as $bb) {?>
<?php 
$lastmod_date = date('Y-m-d');
if($bb->time && !empty($bb->time)) {
    $parsed_date = strtotime($bb->time);
    if($parsed_date !== false) {
        $lastmod_date = date('Y-m-d', $parsed_date);
    }
}
?>

<url>
<loc>{{url(str_replace(' ','-',strtolower('/' . $bb->cate_url)))}}/</loc>
<lastmod>{{$lastmod_date}}</lastmod>
<changefreq>Weekly</changefreq>
<priority>0.7</priority>
</url>
<?php }?> 

<?php $product = DB::table('products')->get(); 
foreach ($product as $bb) {?>
<?php 
$lastmod_date = date('Y-m-d');
if($bb->time && !empty($bb->time)) {
    $parsed_date = strtotime($bb->time);
    if($parsed_date !== false) {
        $lastmod_date = date('Y-m-d', $parsed_date);
    }
}
?>

<url>
<loc>{{url(str_replace(' ','-',strtolower($bb->prod_url)))}}/</loc>
<lastmod>{{$lastmod_date}}</lastmod>
<changefreq>Weekly</changefreq>
<priority>0.7</priority>
</url>
<?php }?> 


<?php $statescategories=DB::table('cardboardboxes')->get();
foreach ($statescategories as $bb) {?>
<?php 
$lastmod_date = date('Y-m-d');
if($bb->time && !empty($bb->time)) {
    $parsed_date = strtotime($bb->time);
    if($parsed_date !== false) {
        $lastmod_date = date('Y-m-d', $parsed_date);
    }
}
?>

<url>
<loc>{{url(str_replace(' ','-',strtolower($bb->prod_url)))}}/</loc>
<lastmod>{{$lastmod_date}}</lastmod>
<changefreq>Weekly</changefreq>
<priority>0.7</priority>
</url>
<?php }?> 
      
 
<?php $add_blog=DB::table('blogs')->get();
foreach ($add_blog as $bb) {?>
<?php 
$lastmod_date = date('Y-m-d');
if($bb->time && !empty($bb->time)) {
    $parsed_date = strtotime($bb->time);
    if($parsed_date !== false) {
        $lastmod_date = date('Y-m-d', $parsed_date);
    }
}
?>

<url>
<loc>{{url(str_replace(' ','-',strtolower('blog'.'/' . $bb->t_slug)))}}/</loc>
<lastmod>{{$lastmod_date}}</lastmod>
<changefreq>Weekly</changefreq>
<priority>0.7</priority>
</url>
<?php }?> 

 




</urlset>

