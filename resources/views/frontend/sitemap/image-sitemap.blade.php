<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<url>
<loc>{{url('/').'/'}}</loc>
<lastmod>{{date('Y-m-d')}}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.8</priority>
</url>

  <?php  $all_pro = DB::table('products')->get(); ?>
  <?php  foreach($all_pro as $value){?>
    <?php 
    $lastmod_date = date('Y-m-d');
    if(isset($value->time) && $value->time && !empty($value->time)) {
        $parsed_date = strtotime($value->time);
        if($parsed_date !== false) {
            $lastmod_date = date('Y-m-d', $parsed_date);
        }
    }
    ?>
    <url>
        <loc>{{ url(str_replace( ' ','-',strtolower($value->prod_url))).'/'}}</loc>
        <lastmod>{{$lastmod_date}}</lastmod>
        <changefreq>daily</changefreq>
        <?php  $images = json_decode($value->prod_gallery); if(!empty($images)){ foreach ($images as $index) { ?>
        <image:image>
        <image:loc>{{url('/images/'.$index)}}</image:loc>
        <image:title>{{$value->prod_name}}</image:title>
        </image:image>
        <?php } } ?>
    </url>
  <?php  } ?>

</urlset>

