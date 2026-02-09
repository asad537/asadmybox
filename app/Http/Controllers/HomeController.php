<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\EmailLog;
use Cart;

class HomeController extends Controller
{

    /**
     * Verify reCAPTCHA using cURL (more reliable than file_get_contents)
     * 
     * @param string $recaptchaResponse
     * @return bool
     */
    private function verifyRecaptcha($recaptchaResponse)
    {
        if (empty($recaptchaResponse)) {
            return false;
        }
        
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $verifyUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'secret' => $secretKey,
            'response' => $recaptchaResponse
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $verifyResponse = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        if ($curlError) {
            \Log::error('reCAPTCHA cURL Error: ' . $curlError);
            return false;
        }
        
        $responseData = json_decode($verifyResponse);
        
        return $responseData && isset($responseData->success) && $responseData->success === true;
    }


    public function __construct()
    {
       $linksname =   request()->segment(2) ;
    
            
             if($linksname=='index.php/'){
                 return redirect('/');
             }
  
          $this->middleware(function ($request, $next) {

             $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get(); 

            $this->middleware($data);

            return $next($request);
        });
    }
    
    /**
     * Build a Product schema block that aligns with Google Merchant Center requirements.
     *
     * @param  array  $payload
     * @return string
     */
    private function buildProductSchema(array $payload): string
    {
        return json_encode(
            $this->buildProductSchemaArray($payload),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
    }

    /**
     * Prepare a Product schema array that can be embedded on its own or as part of a collection graph.
     *
     * @param  array  $payload
     * @return array
     */
    private function buildProductSchemaArray(array $payload): array
    {
        $images = $this->prepareProductImages(
            $payload['primaryImage'] ?? null,
            $payload['images'] ?? []
        );

        if (empty($images)) {
            $images[] = url('mbp.png');
        }

        $priceValue = isset($payload['price']) && $payload['price'] !== ''
            ? (float) $payload['price']
            : 0.01;

        $schema = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $this->sanitizeText($payload['name'] ?? ''),
            'description' => $this->sanitizeText($payload['description'] ?? ''),
            'image' => array_values($images),
            'url' => $payload['url'] ?? url('/'),
            'sku' => $payload['sku'] ?? ('MBP-' . ($payload['id'] ?? uniqid())),
            'brand' => [
                '@type' => 'Brand',
                'name' => $this->sanitizeText($payload['brand'] ?? 'My Box Printing'),
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => $payload['url'] ?? url('/'),
                'priceCurrency' => $payload['priceCurrency'] ?? 'USD',
                'price' => number_format($priceValue, 2, '.', ''),
                'priceValidUntil' => $payload['priceValidUntil'] ?? date('Y-m-d', strtotime('+1 year')),
                'availability' => $payload['availability'] ?? 'https://schema.org/InStock',
                'itemCondition' => $payload['itemCondition'] ?? 'https://schema.org/NewCondition',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => $this->sanitizeText($payload['seller'] ?? 'My Box Printing'),
                ],
                'shippingDetails' => [
                    '@type' => 'OfferShippingDetails',
                    'shippingDestination' => [
                        '@type' => 'DefinedRegion',
                        'addressCountry' => $payload['shippingCountry'] ?? 'US',
                    ],
                    'deliveryTime' => [
                        '@type' => 'ShippingDeliveryTime',
                        'handlingTime' => [
                            '@type' => 'QuantitativeValue',
                            'minValue' => $payload['handlingMin'] ?? 1,
                            'maxValue' => $payload['handlingMax'] ?? 2,
                            'unitCode' => 'd',
                        ],
                        'transitTime' => [
                            '@type' => 'QuantitativeValue',
                            'minValue' => $payload['transitMin'] ?? 3,
                            'maxValue' => $payload['transitMax'] ?? 5,
                            'unitCode' => 'd',
                        ],
                    ],
                    'shippingRate' => [
                        '@type' => 'MonetaryAmount',
                        'currency' => $payload['priceCurrency'] ?? 'USD',
                        'value' => isset($payload['shippingRate']) ? (float) $payload['shippingRate'] : 0,
                    ],
                ],
                'hasMerchantReturnPolicy' => $payload['returnPolicy'] ?? [
                    '@type' => 'MerchantReturnPolicy',
                    'applicableCountry' => $payload['shippingCountry'] ?? 'US',
                    'returnPolicyCategory' => $payload['returnPolicyCategory'] ?? 'https://schema.org/MerchantReturnFiniteReturnWindow',
                    'merchantReturnDays' => $payload['returnDays'] ?? 30,
                    'returnMethod' => $payload['returnMethod'] ?? 'https://schema.org/ReturnByMail',
                    'returnFees' => $payload['returnFees'] ?? 'https://schema.org/FreeReturn',
                    'refundType' => $payload['refundType'] ?? 'https://schema.org/FullRefund',
                ],
            ],
        ];

        if (!empty($payload['mpn'])) {
            $schema['mpn'] = $this->sanitizeText($payload['mpn']);
        }

        if (!empty($payload['gtin'])) {
            $schema['gtin'] = $this->sanitizeText($payload['gtin']);
        }

        if (!empty($payload['ratingValue']) && !empty($payload['reviewCount'])) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => (float) $payload['ratingValue'],
                'bestRating' => (float) ($payload['bestRating'] ?? 5),
                'reviewCount' => (int) $payload['reviewCount'],
            ];
        }

        if (!empty($payload['reviewBody'])) {
            $schema['review'] = [
                [
                    '@type' => 'Review',
                    'reviewRating' => [
                        '@type' => 'Rating',
                        'ratingValue' => (float) ($payload['ratingValue'] ?? 5),
                        'bestRating' => (float) ($payload['bestRating'] ?? 5),
                    ],
                    'author' => [
                        '@type' => 'Person',
                        'name' => $this->sanitizeText($payload['reviewAuthor'] ?? 'Customer'),
                    ],
                    'reviewBody' => $this->sanitizeText($payload['reviewBody']),
                ],
            ];
        }

        $schema['@id'] = $payload['@id'] ?? (($schema['offers']['url'] ?? $schema['url'] ?? url('/')) . '#product');

        return $schema;
    }

    /**
     * Build an ItemList collection schema with embedded product nodes.
     *
     * @param  string  $name
     * @param  string  $url
     * @param  string|null  $description
     * @param  string|null  $image
     * @param  array  $products
     * @return string
     */
    private function buildCollectionSchema(string $name, string $url, ?string $description, ?string $image, array $products): string
    {
        if (empty($products)) {
            return '';
        }

        $graph = [];
        $itemListElement = [];

        foreach ($products as $product) {
            if (empty($product['schema'] ?? [])) {
                continue;
            }

            $position = (int) ($product['position'] ?? (count($itemListElement) + 1));
            $schemaArray = $this->buildProductSchemaArray($product['schema']);
            $productId = $schemaArray['@id'] ?? (($schemaArray['url'] ?? $url) . '#product');
            $schemaArray['@id'] = $productId;

            $listItem = [
                '@type' => 'ListItem',
                'position' => $position,
                'item' => ['@id' => $productId],
            ];

            if (!empty($schemaArray['name'])) {
                $listItem['name'] = $schemaArray['name'];
            }

            $itemListElement[] = $listItem;
            $graph[] = $schemaArray;
        }

        if (empty($itemListElement)) {
            return '';
        }

        $collectionNode = [
            '@type' => 'CollectionPage',
            '@id' => $url . '#collection',
            'name' => $this->sanitizeText($name),
            'url' => $url,
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => $itemListElement,
            ],
        ];

        if (!empty($description)) {
            $collectionNode['description'] = $this->sanitizeText($description);
        }

        if (!empty($image)) {
            $collectionNode['image'] = $image;
        }

        array_unshift($graph, $collectionNode);

        return json_encode([
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Map a collection of product records into payloads suitable for the collection schema helper.
     *
     * @param  iterable  $products
     * @return array
     */
    private function mapProductsForCollection($products): array
    {
        $mapped = [];
        $position = 1;

        foreach ($products as $product) {
            $productUrl = url(trim(($product->prod_url ?? $product->url ?? ''), '/') . '/');
            $mapped[] = [
                'position' => $position++,
                'schema' => [
                    'id' => $product->id ?? null,
                    'name' => $product->prod_name ?? $product->name ?? '',
                    'description' => $product->meta_description ?? $product->prod_name ?? '',
                    'url' => $productUrl,
                    'primaryImage' => $product->prod_image ?? $product->image ?? null,
                    'images' => $product->prod_gallery ?? null,
                    'sku' => $product->sku ?? null,
                    'mpn' => $product->mpn ?? null,
                    'price' => $product->low_price ?? $product->high_price ?? 0.01,
                    'priceCurrency' => 'USD',
                    'availability' => 'https://schema.org/InStock',
                    'itemCondition' => 'https://schema.org/NewCondition',
                    'ratingValue' => $product->rating_value ?? null,
                    'reviewCount' => $product->review_count ?? null,
                    'reviewBody' => 'Great quality product with excellent packaging options.',
                    'seller' => 'My Box Printing',
                    '@id' => $productUrl . '#product',
                ],
            ];
        }

        return $mapped;
    }

    /**
     * Prepare absolute image URLs for schema usage.
     *
     * @param  string|null  $primaryImage
     * @param  array|string|null  $gallery
     * @return array
     */
    private function prepareProductImages($primaryImage, $gallery): array
    {
        $images = [];

        if (is_string($gallery)) {
            $decoded = json_decode($gallery, true);
            $gallery = is_array($decoded) ? $decoded : [];
        }

        if (is_array($gallery)) {
            foreach ($gallery as $image) {
                if (!empty($image)) {
                    $images[] = url('images/' . ltrim($image, '/'));
                }
            }
        }

        if (!empty($primaryImage)) {
            array_unshift($images, url('images/' . ltrim($primaryImage, '/')));
        }

        return array_values(array_unique(array_filter($images)));
    }

    /**
     * Strip tags and normalise whitespace for schema text nodes.
     *
     * @param  string|null  $value
     * @return string
     */
    private function sanitizeText(?string $value): string
    {
        $sanitised = trim(strip_tags((string) $value));

        return preg_replace('/\s+/u', ' ', $sanitised);
    }
    
     public function index1()
    {
        return redirect('/');
    }
    
 
     public function test()
    {
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
               

        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
        $data['all_products'] = DB::table('products')->get();
         $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        $data['prom_prod'] = DB::table('products')->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->where('feature_prod', 1)->get();
        $data['new_arrival']  =  DB::table('products')->where('new_arrival', 1)->limit(4)->get();
        /*echo "<pre>";
        print_r($data['new_arrival']);
        die();*/
        $data['best_seller']  =  DB::table('products')->where('best_seller', 1)->limit(4)->get();
        $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();

        $data['feature_prod']  =  DB::table('products')->where('feature_prod', 1)->limit(4)->get();
        $data['all_blogs']  = DB::table('blogs')->get();
        
        $data['parent_cate'] = DB::table('categories')->where('parent_cate', 0)->get();
        $data['get_sub_cate']=DB::table('categories')->where('parent_cate','!=',0)->limit(6)->get();
        $data['all_subcate'] = DB::table('categories')->get();
        $data['our_testimonial'] =  DB::table('testimonial')->get();
        $data['our_video'] =  DB::table('video')->get();
        $data['all_boxes'] =  DB::table('box_designs')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['dynamic_page']  =  DB::table('dynamic_pages')->get();
        $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['our_blogs']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(4)->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['content']  = DB::table('home_content')->get();
        $data['same_meta']= DB::table('products')->get();
        $data['same_meta']= DB::table('otherproducts')->get();
        $data['all_promotions'] = DB::table('promotions')->orderBy('promo_id', 'desc')->limit(6)->get();
        
 
        $data['meta_title']=$data['content'][0]->meta_title;
        $data['meta_tags']= $data['content'][0]->meta_tags;
        $data['meta_description']= $data['content'][0]->meta_description;
        $data['get_all_customers'] = DB::table("customers")->get();

        $data['our_home_slider'] =  DB::table('home_slider')->get();
    

         
        return  view('frontend.pages.test', $data);
    }
    public function NewAboutus()
    {
        $data['parent_category'] = DB::table('categories')->where('parent_cate', 0)->get();
        $data['all_subcategory'] = DB::table('categories')->get();
        $data['all_products'] = DB::table('products')->get();
        $data['meta_title']='About My Box Printing | Your Trusted Packaging Partner';
        $data['meta_tags']= 'About us, about My Box Printing, who we are, My Box Printing and packaging, My Box Printing';
        $data['meta_description']= "Learn more about My Box Printing. Find out how we can help bring your packaging visions to life and elevate your brand's presence in the market.";
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['content']  = DB::table('home_content')->get();
        $data['same_meta']= DB::table('products')->get();
        $data['same_meta']= DB::table('otherproducts')->get();
        $data['all_pro'] = DB::table('products')->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->get();
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_testimonial'] =  DB::table('testimonial')->get();
        $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
        $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $data['our_home_slider'] =  DB::table('home_slider')->get();
        
        // Get slider image safely with fallback
        $sliderImage = !empty($data['our_home_slider'][0]) ? $data['our_home_slider'][0]->slider_banner : 'default-banner.jpg';
        
        $data['BreadcrumbList'] = '[{
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "MyBoxPrinting",
                    "item": "'.url('/').'"
                },{
                    "@type": "ListItem",
                    "position": 2,
                    "name": "About Us"
                     
                }]
            }]';

            $data['open_graph']='
            <meta property="og:title" content="About My Box Printing | Your Trusted Packaging Partner"> 
            <meta property="og:description" content="Learn more about My Box Printing. Find out how we can help bring your packaging visions to life and elevate your brands presence in the market."> 
            <meta property="og:image" content="https://www.myboxprinting.com/images/'.$sliderImage.'"> 
            <meta property="og:url" content="https://www.myboxprinting.com/about-us/"> 
            <meta property="og:type" content="website">
            ';
             $data['twitter_card']='<meta name="twitter:card" content="summary"> 
            <meta name="twitter:site" content="@myboxprinting.com"> 
            <meta name="twitter:title" content="About My Box Printing | Your Trusted Packaging Partner"> 
            <meta name="twitter:description" content="Learn more about My Box Printing. Find out how we can help bring your packaging visions to life and elevate your brands presence in the market."> 
            <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$sliderImage.'"> 
            ';
        return  view('frontend.pages.aboutnew',$data);
    }
    public function SearchAutoComplete(Request $request)
    {
        $query = $request->get('term','');
        $boxstyle = DB::table('products')->where('prod_name','LIKE','%'.$query.'%')->get();
        // print_r($boxstyle);
        // die();
        $data = [];
        foreach($boxstyle as $item)
        {
            $data[] = [
                'value'=>$item->prod_name,
                'id'=>$item->id,
            ];
        }
        if(count($data))
        {
            return $data;
        }
        else
        {
            return ['value'=>'No Result Found'];
        }
    }
    public function Result(Request $request)
    {
        $searchingdata = $request->input('search_product');
        $box = DB::table('products')->where('prod_name','LIKE','%'.$searchingdata.'%')->first();
        // echo "<pre>";
        // print_r($box3);
        // die();
        if($box)
        {
            if(isset($_POST['searchbtn']))
            {
                return redirect($box->prod_url);
            }
            else
            {
                return redirect($box->prod_url);
            }
        }
        else
        {
            return redirect($box->prod_url);
        }
    }
    
    
          public function thankyou()
    {
        $data['meta_title']= "Thank You";
        $data['meta_tags']= "Thank You";
        $data['meta_description']= "Thank You";
        $data['content']  = DB::table('home_content')->get();
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
          $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
         $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
         $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
         $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
         $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
           return  view('frontend.error.thankyou', $data);
           
 
    }
    
    
    
    public function pro_shi()
    {
    	DB::table("products")->where("prod_name", "Double Wall Tuck Top")->update(array('prod_category'=>103));
    	DB::table("products")->where("prod_name", "Flower Shaped Top Closure")->update(array('prod_category'=>103));
    	DB::table("products")->where("prod_name", "Four Corner With Display Lid")->update(array('prod_category'=>103));
    	DB::table("products")->where("prod_name", "Gable Bag Auto Bottom")->update(array('prod_category'=>103));
    	DB::table("products")->where("prod_name", "Gable Bag Bottom Hanger")->update(array('prod_category'=>103));
    	DB::table("products")->where("prod_name", "Seal End With Perforated Top")->update(array('prod_category'=>103));
    	DB::table("products")->where("prod_name", "Self Lock Cake Box")->update(array('prod_category'=>103));	 
    }
    public function BeatQuoteForm(Request  $request)
    {
            // Verify reCAPTCHA
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (empty($recaptchaResponse)) {
                Session::flash('message', 'Please complete the reCAPTCHA verification.');
                return redirect()->back()->withInput();
            }
            
            // Verify reCAPTCHA
            if (!$this->verifyRecaptcha($recaptchaResponse)) {
                Session::flash('message', 'reCAPTCHA verification failed. Please try again.');
                return redirect()->back()->withInput();
            }
            
                $x = "beat_price";
                $name=$request->input('name');
                $email =$request->input('email');
                $phone = $request->input('phone');
                $length = $request->input('length');
                $width = $request->input('width');
                $height = $request->input('height');
                $measurement = $request->input('measurement');
                $box_style = $request->input('boxstyle');
                $stock=$request->input('stock');
                $quantity=$request->input('quantity');
                $price=$request->input('price');
                
                $message=$request->input('message');
                $subject =  $x;

                $to = "quotes@myboxprinting.com";
                $to1="quotes@myboxprinting.com";
                $subject = "Beat My Price";

                if ($request->hasFile('file')) 
                {
                    Log::info('BeatQuoteForm: File detected.');
                    $file = $request->file('file');
                    $extension = $file->getClientOriginalName();
                    Log::info('BeatQuoteForm: Original Name: ' . $extension);
                    $filename = $extension;
                    $file->move('images/blog/', $filename);
                    Log::info('BeatQuoteForm: Moved to images/blog/' . $filename);
                }
                else 
                {
                    Log::info('BeatQuoteForm: No file detected.');
                    Log::info('BeatQuoteForm: Input keys: ' . json_encode(array_keys($request->all())));
                    Log::info('BeatQuoteForm: File keys: ' . json_encode(array_keys($request->allFiles())));
                    $filename = "";
                }
                $htmlContent = ' 
                <html>
                    <head>
                    </head>
                    <body> 
                        <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Name:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                            </tr> 
                            <tr style="background-color: #e0e0e0;"> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Email:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                            </tr> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Phone:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                            </tr> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                            </tr> 
                             <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                            </tr> 
                             <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                            </tr> 

                             <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Measurement:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$measurement.'</td> 
                            </tr> 


                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Box Style:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$box_style.'</td> 
                            </tr> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">stock:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                            </tr> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Qty:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$quantity.'</td> 
                            </tr> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Price:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$price.'</td> 
                            </tr> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">File:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$filename.'</td> 
                            </tr> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                            </tr> 
                        </table> 
                    </body> 
                </html>';
                //  $message = 'Name: '.$name.'<br>'.'Email:'.$email.'<br>'.'Phone:'.$phone; 
                // $header = 'From: '.$email.'<'.$email.'>'; 
            
                // $header = "MIME-Version: 1.0\r\n";
                // $header = "Content-type: text/html\r\n";
     
     
              $configEmail = config('mail.from.address');
              $configName = config('mail.from.name');
              $header = [
                   'From' => $configName.' <'.$configEmail.'>',
                    'Reply-To' => $email,
                    'X-Sender' => $configName.' <'.$configEmail.'>',
                    'X-Mailer' => 'PHP/' . phpversion(),
                    'X-Priority' => '1',
                    'Return-Path' => '<'.$configEmail.'>',
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'text/html; charset=iso-8859-1',
                    
                ];
                
                
                
              
            
                // CRM Logging - Log BEFORE sending email
                \App\Helpers\SpamDetector::logInquiry([
                    'client_name' => $name,
                    'client_email' => $email,
                    'client_phone' => $phone,
                    'product_name' => $box_style,
                    'length' => $length,
                    'width' => $width,
                    'height' => $height,
                    'stock' => $stock,
                    'quantity' => $quantity,
                    'message' => $message,
                    'subject' => $subject,
'ip_address' => $request->ip(),
                    'file_url' => $filename ? url('images/blog/' . $filename) : null,
                ]);

                $this->sendEmail($to, $subject, $htmlContent, $email);
                
                try {
                     $this->sendEmail($to1, $subject, $htmlContent, $email);
                } catch (\Exception $e) {
                    // Ignore second email failure
                }

                Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
                     return redirect()->back()->with('success', 'your message,here');
           
                   
    }
    public function BeatQuote()
    {
        $data['parent_category'] = DB::table('categories')->where('parent_cate', 0)->get();
        $data['all_subcategory'] = DB::table('categories')->get();
        $data['all_products'] = DB::table('products')->get();
        $data['meta_title']='Unlock the Best Deals - Unbeatable Savings';
        $data['meta_tags']= 'Unlock the Best Deals, Unbeatable Savings, beat my price, discount on packaging, discount on boxes';
        $data['meta_description']= "Get the best value for your packaging needs with our competitive pricing and exceptional quality. Find out how you can save big on custom packaging solutions today!";
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['content']  = DB::table('home_content')->get();
        $data['same_meta']= DB::table('products')->get();
        $data['same_meta']= DB::table('otherproducts')->get();
        $data['all_pro'] = DB::table('products')->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->get();
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_testimonial'] =  DB::table('testimonial')->get();
        $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
        $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();


        $data['our_home_slider'] =  DB::table('home_slider')->get();
        
        // Get slider image safely with fallback
        $sliderImage = !empty($data['our_home_slider'][0]) ? $data['our_home_slider'][0]->slider_banner : 'default-banner.jpg';
        
        $data['open_graph']='
        <meta property="og:title" content="Unlock the Best Deals - Unbeatable Savings"> 
        <meta property="og:description" content="Get the best value for your packaging needs with our competitive pricing and exceptional quality. Find out how you can save big on custom packaging solutions today!"> 
        <meta property="og:image" content="https://www.myboxprinting.com/images/'.$sliderImage.'"> 
        <meta property="og:url" content="https://www.myboxprinting.com/beat-my-price/"> 
        <meta property="og:type" content="website">
        ';
         $data['twitter_card']='<meta name="twitter:card" content="summary"> 
        <meta name="twitter:site" content="@myboxprinting.com"> 
        <meta name="twitter:title" content="Unlock the Best Deals - Unbeatable Savings"> 
        <meta name="twitter:description" content="Get the best value for your packaging needs with our competitive pricing and exceptional quality. Find out how you can save big on custom packaging solutions today!"> 
        <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$sliderImage.'"> 
        ';

        $data['BreadcrumbList'] = '[{
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "My Box Printing",
                    "item": "'.url('/').'"
                },{
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Beat My Price"
                     
                }]
            }]';



        return  view('frontend.products.beatquote',$data);
    }
    public function CustomBoxesPage1()
    {
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
        $data['meta_title']='Custom Boxes: Design Your Box Packaging | My Box Printing';
        $data['meta_tags']= 'custom boxes, custom packaging boxes, custom box printing, personalized custom boxes, custom cardboard boxes, custom packaging, custom printed boxes, custom box design, custom gift boxes, packaging solutions, custom packaging for business, custom shipping boxes, custom retail boxes';
        $data['meta_description']= "Get custom boxes for retail, shipping, or eCommerce at low prices. Fast turnaround, free design support, and eco-friendly packaging solutions. Order now";
        $data['all_products'] = DB::table('products')->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['content']  = DB::table('home_content')->get();
        $data['same_meta']= DB::table('products')->get();
        $data['same_meta']= DB::table('otherproducts')->get();
        $data['all_pro'] = DB::table('products')->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->get();
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_testimonial'] =  DB::table('testimonial')->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        return  view('frontend.products.customboxpage',$data);
    }
    
    
    
    




public function StateOnly($url)
    {
     
   
         $links = $url;
        $linksname =   request()->segment(2) ;
        $link=request()->segment(1);
         $linkx =   str_replace('-', ' ', strtolower($link)) ;
         $linksegmenttwo = $link.'/'.$linksname;
        $data['value'] = DB::table('statescategories')->where('cate_url', $linksegmenttwo)->where('status', '=', '0')->get();
        if(count($data['value'])>0)
        {
            $data['state_ca'] = DB::table('statescategories')->where('cate_url', $linksegmenttwo)->where('status', '=', '0')->get();
            $data['all_state_ca'] = DB::table('statescategories')->get();
             $faq = $data['value'][0]->id;
 
       
                    
          $data['pro'] = DB::table('statescategories')->where('cate_url', $data['value'][0]->cate_url)->get();
          
           $data['all_states_'] = DB::table('states')->where('status', 1)->get();
           
           
          $data['meta_title']=  $data['value'][0]->meta_title;
          $data['meta_tags']=  $data['value'][0]->meta_tags;
          $data['meta_description']=  $data['value'][0]->meta_description;
          
         $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
 
          
 
          $data['all_products'] = DB::table('products')->get();
          $data['sub_category'] = DB::table('categories')->where('parent_cate',$data['value'][0]->id)->get();
          $data['sub_product'] = DB::table('products')->where('prod_category',$data['value'][0]->id)->get();
          $data['dynamic_page']  =  DB::table('dynamic_pages')->get();
          
          $data['social_link_hf'] = DB::table('socials_media')->get();
          
          
          $data['meta_title']=  $data['value'][0]->meta_title;
          $data['meta_tags']=  $data['value'][0]->meta_tags;
          $data['meta_description']=  $data['value'][0]->meta_description;

          $data['open_graph']='
             <meta property="og:title" content="'.$data['value'][0]->meta_title.'"> 
             <meta property="og:description" content="'.$data['value'][0]->meta_description.'"> 
             <meta property="og:image" content="https://www.myboxprinting.com/images/'.$data['value'][0]->cate_image.'"> 
             <meta property="og:url" content="https://www.myboxprinting.com/'.$data['value'][0]->cate_url.'/"> 
             <meta property="og:type" content="website">
             ';
             
               $data['twitter_card']='
                <meta name="twitter:card" content="summary"> 
                <meta name="twitter:site" content="@myboxprinting.com/"> 
                <meta name="twitter:title" content="'.$data['value'][0]->meta_title.'"> 
                <meta name="twitter:description" content="'.$data['value'][0]->meta_description.'"> 
                <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$data['value'][0]->cate_image.'" />
             ';

                $data['breadcrumb'] = '[{
                    "@context": "https://schema.org",
                    "@type": "BreadcrumbList",
                    "itemListElement": [{
                            "@type": "ListItem",
                            "position": 1,
                            "name": "My Box Printing",
                            "item": "'.url('/').'/"
                        },{
                            "@type": "ListItem",
                            "position": 2,
                            "name": "'.$data['value'][0]->cate_name.'"
                             
                        }]
                }]';

 $state_data=DB::table('states')->where('id',json_decode($data['value'][0]->state))->get();

 
 

 $data['business_listing'] = '[{
                "@context": "https://schema.org/",
                "@type": "LocalBusiness",
                "name": "My Box Printing USA",
                "image": [
                  "https://www.myboxprinting.com/mbpp.png",
                  "https://www.myboxprinting.com/mbpp.png",
                  "https://www.myboxprinting.com/mbpp.png"
                 ],
              
                 
                 "PriceRange": "$",
                 "address": {
                   "@type": "PostalAddress",
                   "streetAddress": " 9933 Franklin Ave Suite 112 Franklin park IL 60131",
                   "addressLocality": "9933 Franklin Ave Suite",
                   "addressRegion": "Franklin",
                   "postalCode": "60131",
                   "telephone": "847-200-0974",
                   "addressCountry": "US"
                 },
      "location": {
		"@type": "Place",
		"geo": {
			"@type": "GeoCoordinates",
			"latitude": "'.$state_data[0]->latitude.'",
			"longitude": "'.$state_data[0]->longitude.'"
			}
		},
	"areaServed": [{
		"@type": "City",
		"name": "'.$state_data[0]->states.'"			
		}]
	}]
';
               
                
                
           return view ('frontend/products/statecategory', $data);
        }
        else
        {
            return redirect('404.php');
        }
    }


public function location_state()
    {
         $linksname =   request()->segment(2) ;
       
     
        $linkx =   str_replace('-', ' ', strtolower($linksname)) ;
        
    
         
         $data['meta_title']='Our Locations';
        $data['meta_tags']= 'Our Locations!';
        $data['meta_description']= 'Our Locations';
        
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
        $data['dynamic_page']  =  DB::table('dynamic_pages')->get();
        $data['all_products'] = DB::table('products')->get();
        
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['content']  = DB::table('home_content')->get();
        $data['same_meta']= DB::table('products')->get();
        $data['same_meta']= DB::table('otherproducts')->get();
        $data['all_pro'] = DB::table('products')->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->get();
        
        
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['social_link_hf'] = DB::table('socials_media')->get();
        $data['states_name'] = DB::table('states')->get();
        $data['states_cat'] = DB::table('statescategories')->orderBy('id', 'DESC')->paginate(20);
        
        $data['get_state']=DB::table('states')->where('states',$linkx)->get();
       
       
       
       
       
        
       
       
       
        
        $data['open_graph']='
        <meta property="og:title" content=""> 
        <meta property="og:description" content=""> 
        <meta property="og:image" content=""> 
        <meta property="og:url" content=""> 
        <meta property="og:type" content="website">
        ';
        
        $data['twitter_card']='
        <meta name="twitter:card" content="summary"> 
        <meta name="twitter:site" content=""> 
        <meta name="twitter:title" content=""> 
        <meta name="twitter:description" content=""> 
        <meta name="twitter:image" content="" />
        ';
        



         
      return view('frontend.products.state_location',$data);
            
    }


public function location()
    {
 
        $data['meta_title']='Our Locations';
        $data['meta_tags']= 'Our Locations!';
        $data['meta_description']= 'Our Locations';
        
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
        $data['dynamic_page']  =  DB::table('dynamic_pages')->get();
        $data['all_products'] = DB::table('products')->get();
        
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['content']  = DB::table('home_content')->get();
        $data['same_meta']= DB::table('products')->get();
        $data['same_meta']= DB::table('otherproducts')->get();
        $data['all_pro'] = DB::table('products')->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->get();
        
        
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['social_link_hf'] = DB::table('socials_media')->get();
        $data['states_name'] = DB::table('states')->get();
        $data['states_cat'] = DB::table('statescategories')->orderBy('id', 'DESC')->paginate(20);
        
        
       
        
        $data['open_graph']='
        <meta property="og:title" content=""> 
        <meta property="og:description" content=""> 
        <meta property="og:image" content=""> 
        <meta property="og:url" content=""> 
        <meta property="og:type" content="website">
        ';
        
        $data['twitter_card']='
        <meta name="twitter:card" content="summary"> 
        <meta name="twitter:site" content=""> 
        <meta name="twitter:title" content=""> 
        <meta name="twitter:description" content=""> 
        <meta name="twitter:image" content="" />
        ';
        



         
            return view('frontend.products.location',$data);
        
        
    }
    
    
    
    
    public function sitemap_html()
    {
        
        $data['parent_category'] = DB::table('categories')->where('parent_cate', 0)->get();
        $data['all_subcategory'] = DB::table('categories')->get();
        $data['all_products'] = DB::table('products')->get();
        
    
        $data['meta_title']='Html Sitemap For Users- 1 Click for all Products URLs';
        $data['meta_tags']= 'Html sitemap, better UI UX , 1 Click for all product URLs, Official SiteMap ';
        $data['meta_description']= 'My Box Printing official HTML sitemap for respected user. You can get all the product urls in just 1 click. Click Now';
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['content']  = DB::table('home_content')->get();
        
        
        $data['same_meta']= DB::table('products')->get();
        $data['same_meta']= DB::table('otherproducts')->get();
        
        $data['all_pro'] = DB::table('products')->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->get();
        
            //   echo"<pre>";
            // print_r($data['all_pro']);
            // die();
        
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();

        return  view('frontend.sitemap.sitemap_html',$data);
    }
    public function index()
    {
        $data = Cache::remember('home_page_data_v1', 60 * 24, function () {
            $data = [];
            // Removed duplicate rating_code schema - using business_listing instead
            $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(4)->get();
            $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
            $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
            $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
            $data['all_products'] = DB::table('products')->get();
            $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(12)->get();
            $data['prom_prod'] = DB::table('products')->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->where('feature_prod', 1)->get();
            $data['new_arrival']  =  DB::table('products')->where('new_arrival', 1)->limit(4)->get();
            
            $data['best_seller']  =  DB::table('products')->where('best_seller', 1)->limit(4)->get();
            $data['feature_prod_home1'] = DB::table('products')->where('best_seller', 1)->limit(8)->get();
            $data['feature_prod_home11'] = DB::table('products')->where('best_seller', 1)->orderBy('id','desc')->limit(12)->get();
            $data['feature_prod_home_new_arrival'] = DB::table('products')->where('best_seller', 1)->limit(8)->get();
        
            // Pre-load data for blade template to avoid queries in view
            $data['home_categories'] = DB::table('categories')->where('show_on_home', 1)->limit(6)->get();
            $data['home_other_products'] = DB::table('otherproducts')
            ->whereIn('prod_name', ['Decals Printing', 'Business Cards','Tags Printing','Vinyl Banners','Booklets','Brochures'])
            ->limit(6)
            ->get();
            $data['all_products_for_form'] = DB::table('products')->get();
        
            $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->limit(8)->get();
            $data['feature_prod']  =  DB::table('products')->where('feature_prod', 1)->limit(4)->get();
            $data['all_blogs']  = DB::table('blogs')->get();
            $data['parent_cate'] = DB::table('categories')->where('parent_cate', 0)->get();
            $data['get_sub_cate']=DB::table('categories')->where('parent_cate','!=',0)->limit(6)->get();
            $data['all_subcate'] = DB::table('categories')->get();
            $data['our_testimonial'] =  DB::table('testimonial')->get();
            $data['our_video'] =  DB::table('video')->get();
            $data['all_boxes'] =  DB::table('box_designs')->get();
            $data['our_socials']  =DB::table('socials_media')->get();
            $data['dynamic_page']  =  DB::table('dynamic_pages')->get();
            $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
            $data['our_blogs']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(3)->get();
            $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
            $data['content']  = DB::table('home_content')->get();
            $data['same_meta']= DB::table('products')->get(); // This line was in original
            $data['same_meta']= DB::table('otherproducts')->get();
            $data['all_promotions'] = DB::table('promotions')->orderBy('promo_id', 'desc')->limit(6)->get();
            
            $data['get_all_customers'] = DB::table("customers")->get();
            $data['our_home_slider'] =  DB::table('home_slider')->get();
            
            return $data;
        });

        $homeContent = $data['content']->first();
        $data['meta_title'] = $homeContent->meta_title ?? '';
        $data['meta_tags'] = $homeContent->meta_tags ?? '';
        $data['meta_description'] = $homeContent->meta_description ?? '';
        
        $homeSlider = $data['our_home_slider']->first();
        
        // Ensure home_slider_first always has default values
        if (!$homeSlider) {
            $homeSlider = (object)[
                'mini_title' => 'Welcome to My Box Printing',
                'big_title' => 'Custom Box Printing Solutions',
                'slider_description' => 'Premium custom boxes and packaging at wholesale rates',
                'slider_banner' => 'default-banner.jpg'
            ];
        }
        
        $sliderBanner = $homeSlider->slider_banner ?? '';
        $data['home_slider_first'] = $homeSlider;
        $data['slider_banner'] = $sliderBanner;
        $data['open_graph']='
        <meta property="og:title" content="'.$data['meta_title'].'"> 
        <meta property="og:description" content="'.$data['meta_description'].'"> 
        <meta property="og:image" content="https://www.myboxprinting.com/images/'.$sliderBanner.'"> 
        <meta property="og:url" content="https://www.myboxprinting.com/"> 
        <meta property="og:type" content="website">
        ';
         $data['twitter_card']='<meta name="twitter:card" content="summary"> 
        <meta name="twitter:site" content="@myboxprinting.com"> 
        <meta name="twitter:title" content="'.$data['meta_title'].'"> 
        <meta name="twitter:description" content="'.$data['meta_description'].'"> 
        <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$sliderBanner.'"> 
        ';

        $data['BreadcrumbList'] = '[{
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "My Box Printing",
                    "item": "'.url('/').'"
                }]
            }]';
            
            
            
            
            
     $data['business_listing'] = '[{
       "@context": "https://schema.org",
       "@type" : "LocalBusiness",
       "@id" : "https://www.myboxprinting.com/",
       "name" : "My Box Printing",
       "hasMap": "https://www.google.com/maps/place/My+Box+Printing/@41.9376778,-87.8772044,17z/data=!3m1!4b1!4m6!3m5!1s0x880fb5629fff7223:0x6629d52356d1127a!8m2!3d41.9376778!4d-87.8746295!16s%2Fg%2F11kb4rmbtp?entry=ttu&g_ep=EgoyMDI1MDIwMi4wIKXMDSoASAFQAw%3D%3D",
       "logo" : "https://www.myboxprinting.com/public/my-box-printing-logo.svg",
       "telephone" : "847-200-0974",
       "email" : "quotes@myboxprinting.com",
       "url" : "https://www.myboxprinting.com/",
       "image" : [
           "https://www.myboxprinting.com/images/retail-boxes.webp",
           "https://www.myboxprinting.com/images/Gift-Boxes.webp",
           "https://www.myboxprinting.com/images/eco-friednly-boxes.webp",
           "https://www.myboxprinting.com/images/Food-and-Beverage.webp",
           "https://www.myboxprinting.com/images/Display-Packaging.webp",
           "https://www.myboxprinting.com/images/CBD-Packaging.webp",
           "https://www.myboxprinting.com/images/Cosmetic-Boxes.webp",
           "https://www.myboxprinting.com/images/Cardboard-Boxes.webp",
           "https://www.myboxprinting.com/images/Software-Boxes.webp",
           "https://www.myboxprinting.com/images/Mylar%20bags-food-storage-mylar-bags.webp",
           "https://www.myboxprinting.com/images/Candle-Boxes.webp",
           "https://www.myboxprinting.com/images/Donut-Boxes.webp",
           "https://www.myboxprinting.com/box_assets/img/homelogo.webp",
           "https://www.myboxprinting.com/images/printed-Mailer-boxes.webp",
           "https://www.myboxprinting.com/images/bangle-boxes.webp",
           "https://www.myboxprinting.com/images/E-Cigarette-Boxes.webp"
       ], 
       "priceRange" : "$0.1 - $50",
       "description" : "Get Custom Packaging Boxes with Logo at unbeatable prices! My Box Printing Provides Custom Boxes With free design support and shipping across the USA.",
       "address" : {
           "@type": "PostalAddress",
           "addressCountry": "US",
           "addressLocality": "Franklin Park",
           "addressRegion": "IL",
           "postalCode": "60131",
           "streetAddress": "9933 Franklin Ave Suite 112 Franklin Park, IL 60131"
       },
       "geo" : {
           "@type" : "GeoCoordinates",
           "longitude": "-87.8746295",
           "latitude": "41.9376778"
       },
       "potentialAction": {
           "@type": "SearchAction",
           "target": "https://www.myboxprinting.com/search/",
           "query-input": "required name=search_term_string"
       }
}]';



              $data['faq_schema'] ='{
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": [{
                  "@type": "Question",
                  "name": "What is custom packaging boxes?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Custom packaging boxes are containers that can come in different shapes, sizes, and forms. These are easy to personalise and businesses from different industries can use them to pack items. These play an essential role in the protection of commodities but also facilitate the manufacturing companies in conveying their brand USPs to the audience through the proper presentation."
                  }
                },{
                    "@type": "Question",
                    "name": "What kind of box is best for shipping?",
                    "acceptedAnswer": {
                      "@type": "Answer",
                      "text": "It all depends on your personal choice. However, depending on the nature of your product, you can discuss it with our professional support team and they will guide you on this. For an optimum shipping experience, you can choose corrugated packaging boxes. These come with extra strength and offer more cushion, particularly during the critical phase of product shipping."
                    }
                  },{
                    "@type": "Question",
                    "name": "How much does a box usually cost?",
                    "acceptedAnswer": {
                      "@type": "Answer",
                      "text": "The price of each packaging box varies and it depends on numerous factors such as the type of box, its desired thickness, stock type, and printing options. You can easily request a price quote on My Box Printing USA website. Our experts will get back to you with the price quote as per the information shared by you in the form. You can also send us an email at quotes@myboxprinting.com or call us at +847-200-0974"
                    }
                  },{
                    "@type": "Question",
                    "name": "When will I receive my packaging box delivery in USA?",
                    "acceptedAnswer": {
                      "@type": "Answer",
                      "text": "Our turnaround time is exceptionally fast and we can deliver the order within 10 to 12 working days. However, in the case of urgent delivery, our team can ship the boxes within a week through an expeditious delivery system. As soon as an order is placed, our team starts working on it till the time it’s delivered to your doorstep in a safe and sound condition."
                    }
                  },{
                    "@type": "Question",
                    "name": "Do you offer design services for the custom packaging boxes?",
                    "acceptedAnswer": {
                      "@type": "Answer",
                      "text": "Depending on your business goals, you can discuss the packaging box’s branding with our professional design team and seek their valuable input through a free-of-charge design support service. We will help style your packaging through proper logo placement, printing techniques, embossing, foil stamping, raised ink effect, application of creative visualisations, and a lot more."
                    }
                  }]
              }';
         
        return  view('frontend.home', $data);
    }
    public function user_signup_saved(Request $request)
    {

        $username=$request->input('user_name');

        $check=DB::table('user_signup')->where('user_name',$username)->get();

        if(count($check)>0){
            Session::flash('dublicate','This Username already Exits !');
            return redirect('user-signup');
        }else
        {
            $data=[
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'number' => $request->input('number'),
                'user_name' => $request->input('user_name'),
                'password' => md5($request->input('password')),
            ];
            $x = "create_account";
            $edata = [
                'name' => $request->input('name'),
                'subject' => $x,
            ];
         

            DB::table('user_signup')->insert($data);
            Session::flash('signup','Register Successfully Now Please Login ! ');
            return redirect('user-signup');
         }
        
    
    }
    public function add_balance()
    {

        $data['meta_title']='Dashboard';
        $data['meta_tags']= 'Dashboard';
        $data['meta_description']= 'Dashboard';
        
        return view('frontend/user_account/add_balance',$data);
    }
    public function add_balance_process(Request $request)
    {
        
        $get_user_details_by_id = DB::table("user_signup")->where("id", Session::get("user_id"))->get();
       
       
        $old_balance=$get_user_details_by_id[0]->total_balance;
        $old_remaining_balance=$get_user_details_by_id[0]->remaining_balance;


        $old_used_balance=$get_user_details_by_id[0]->used_balance;
        $new_balance=$request->input('bln');
        

        $data['total_balance']=$old_balance+$new_balance;

        $data['remaining_balance']=$data['total_balance']-$old_used_balance;


      DB::table('user_signup')->where('id',Session::get("user_id"))->update($data);

      return redirect('user-dashboard');
    }
    public function producturl($url)
    {
        // echo $url;
        // die();
        $val=$url;
        $a= DB::table('categories')->where('cat_url',$val)->get();
        $b=DB::table('other_product')->where('url',$val)->get();
        $c=DB::table('products')->where('url',$val)->get();
    
    
        $temp_cont=0;
        if (count($c)==0) 
        {
          $temp_cont=$temp_cont+1;
        }
        if (count($b)==0) 
        {
          $temp_cont=$temp_cont+1;
        }
        if (count($a)==0) 
        {
          $temp_cont=$temp_cont+1;
        }
        if($temp_cont==3)
        {
            return response(redirect(url('404.php')), 404);
        }
        else
        {
    
            $data['get_other_data']=DB::table('other_product')->where('url',$val)->get();
            if (count($data['get_other_data'])>0) {
            $data['get_product_data']=DB::table('other_product')->where('url',$val)->get();
            $data['product']=DB::table('products')->get();
            $data['parent_category']=DB::table('categories')->where('parent_cate', 0)->get();
            $data['child_category']=DB::table('add_category')->get();
            $data['get_related_data']=DB::table('other_product')->get();
            $data['offers']=DB::table('offers')->get();
            $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        
            return view('web/product-detail',$data);
        }
        else{
    
        $data['get_product_data']=DB::table('products')->where('url',$val)->get();
    
        if (count($data['get_product_data'])>0) {
        $data['product']=DB::table('products')->get();
        $data['parent_category']=DB::table('categories')->where('parent_cate', 0)->get();
        $data['child_category']=DB::table('add_category')->get();
        $data['offers']=DB::table('offers')->get();
        $data['get_related_data']=DB::table('products')->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
    
        //$data['temppp']=App::make('url')->to('/');
        return view('web/product-detail',$data);
        
        }
    
        else{
    
    
    
        $cat=DB::table('add_category')->where('cat_url',$val)->get();
    
        $var=$cat[0]->cat_id;
    
        $temp['par']=DB::table('add_category')->where('parent_category',$var)->get();
     
    
    
        $temp['sub_cat']=DB::table('products')->where('cat_id',$var)->get();
     
     
    
        $temp['product']=DB::table('products')->get();
        $temp['parent_category']=DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'asc')->limit(1)->get();
        $temp['child_category']=DB::table('add_category')->get();
        $temp['get_description']=DB::table('add_category')->select('name')->select('description')->where('cat_id',$cat[0]->cat_id)->get();
        $temp['get_related_data']=DB::table('other_product')->get();
        $temp['get_cat_name']=DB::table('add_category')->select('baner','meta_title','name','meta_des','meta_tag')->where('cat_id',$cat[0]->cat_id)->get();
        $temp['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        //$temp['temppp']=App::make('url')->to('/');
     
    
        return view('web/category_show',$temp);
        }
    
        }
        }
        
        }
        // public function shop_detail($url){
        //      echo $url;
        //      die();
        // }
     public function shop_detail($url)
    {

       
                $val=$url;
                $a= DB::table('categories')->where('cate_url',$val)->get();
                $b=DB::table('dynamic_pages')->where('page_url',$val)->get();
                $c=DB::table('products')->where('prod_url',$val)->get();
                $d=DB::table('otherproducts')->where('prod_url',$val)->get();
                $e=DB::table('ppc_pages')->where('prod_url',$val)->get();
                $f=DB::table('cardboardboxes')->where('prod_url',$val)->get();
                
                
             
                $temp_cont=0;
                
                if (count($c)==0) 
                {
                $temp_cont=$temp_cont+1;
                }
                if (count($b)==0) 
                {
                $temp_cont=$temp_cont+1;
                }
                if (count($a)==0) 
                {
                $temp_cont=$temp_cont+1;
                }
                if (count($d)==0) 
                {
                    $temp_cont=$temp_cont+1;
                }
                if (count($e)==0) 
                {
                    $temp_cont=$temp_cont+1;
                }
                if (count($f)==0) 
                {
                    $temp_cont=$temp_cont+1;
                }
                
                if($temp_cont==6)
                {
                
                return response(redirect(url('404.php')), 404);
                
                }
        else
        {        
        $data['main_product']=DB::table('products')->where('prod_url',$val)->get();
        if (count($data['main_product'])>0) 
        {
            $data['get_product_data']=DB::table('products')->where('prod_url',$val)->get();
            $data['product']=DB::table('products')->get();
            // $data['child_category']=DB::table('categories')->get();
            $data['get_related_data']=DB::table('cardboardboxes')->get();
            $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
            $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
            $data['all_products'] = DB::table('products')->get();
            $p_id=$data['main_product'][0]->id;
            $data['our_testimonial'] =  DB::table('testimonial')->get();
            $data['get_variations_name']=DB::table('variations_name')->where('product_id',$p_id)->get();
            // $data['rel_prod']=DB::table('products')->orderBy('id', 'desc')->limit(4)->get();
             $data['rel_prod']=DB::table('products')->select("products.*", "products.id AS product_id", "categories.id","categories.cate_url","categories.cate_name")->leftJoin('categories', 'products.prod_category','=','categories.id')->whereIn('products.id',json_decode($data['get_product_data'][0]->related_prod))->orderBy('product_id', 'desc')->limit(4)->get();
             
            $data['get_ten_recent_category']=DB::table('categories')->orderBy('id', 'desc')->limit(15)->get();
            $data['get_ten_recent_feature_products']=DB::table('products')->orderBy('id', 'desc')->limit(15)->get();
            $data['get_ten_recent_best_seller_products']=DB::table('products')->orderBy('id', 'desc')->limit(15)->get();
            $data['promotions']=DB::table('promotions')->orderBy('promo_id', 'desc')->limit(15)->get();
            $data['meta_title']=$data['get_product_data'][0]->meta_title;
            $data['meta_tags']= $data['get_product_data'][0]->meta_tags;
                  $get_url=$data['get_product_data'][0]->prod_url;
            $data['meta_description']= $data['get_product_data'][0]->meta_description;

            $data['product_name_thi']=DB::table('products')->where('prod_url',$val)->get();

            $data['sub_parent_match_product']=DB::table('categories')->where('id',$data['product_name_thi'][0]->prod_category)->get();

             $data['sub_cat_name_pro'] =$data['sub_parent_match_product'][0]->cate_name;
             $data['sub_cat_name_pro_url'] =$data['sub_parent_match_product'][0]->cate_url;

             $data['sub_cat_parent_pro'] =$data['sub_parent_match_product'][0]->parent_cate;

             $data['product_main_category'] = DB::table('categories')->where('id', $data['sub_cat_parent_pro'])->get();

             $data['main_category_c'] = $data['product_main_category'][0]->cate_name;
             $data['main_category_c_url'] = $data['product_main_category'][0]->cate_url;

            
             $data['open_graph']='
             <meta property="og:title" content="'.$data['get_product_data'][0]->meta_title.'"> 
             <meta property="og:description" content="'.$data['get_product_data'][0]->meta_description.'"> 
             <meta property="og:image" content="https://www.myboxprinting.com/images/'.$data['get_product_data'][0]->prod_image.'"> 
             <meta property="og:url" content="https://www.myboxprinting.com/'.$data['get_product_data'][0]->prod_url.'/"> 
             <meta property="og:type" content="website">
             ';
              $data['twitter_card']='<meta name="twitter:card" content="summary"> 
             <meta name="twitter:site" content="@myboxprinting.com"> 
             <meta name="twitter:title" content="'.$data['get_product_data'][0]->meta_title.'"> 
             <meta name="twitter:description" content="'.$data['get_product_data'][0]->meta_description.'"> 
             <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$data['get_product_data'][0]->prod_image.'"> 
             ';
            $data['BreadcrumbList'] = '[{
                "@context": "https://schema.org",
                "@type": "BreadcrumbList",
                "itemListElement": [{
                        "@type": "ListItem",
                        "position": 1,
                        "name": "My Box Printing",
                        "item": "'.url('/').'"
                    },{
                        "@type": "ListItem",
                        "position": 2,
                        "name": "'.$data['main_category_c'].'",
                        "item": "'.url( $data['main_category_c_url']).'/"
                    },{
                        "@type": "ListItem",
                        "position": 3,
                        "name": "'.$data['sub_cat_name_pro'].'",
                        "item": "'.url( $data['sub_cat_name_pro_url']).'/"
                    },{
                        "@type": "ListItem",
                        "position": 4,
                        "name": "'.$data['product_name_thi'][0]->prod_name.'"
                    }]
                }]';
             
            $productRecord = $data['get_product_data'][0];
            $productUrl = url(trim($productRecord->prod_url ?? '', '/') . '/');

            $schema = $this->buildProductSchema([
                'id' => $productRecord->id ?? null,
                'name' => $productRecord->prod_name ?? '',
                'description' => $productRecord->meta_description ?? '',
                'url' => $productUrl,
                'primaryImage' => $productRecord->prod_image ?? null,
                'images' => $productRecord->prod_gallery ?? null,
                'sku' => $productRecord->sku ?? null,
                'mpn' => $productRecord->mpn ?? null,
                'brand' => 'My Box Printing',
                'price' => $productRecord->low_price ?? $productRecord->high_price ?? 0.01,
                'priceCurrency' => 'USD',
                'availability' => 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
                'ratingValue' => $productRecord->rating_value ?? null,
                'reviewCount' => $productRecord->review_count ?? null,
                'reviewBody' => 'Great quality product with excellent packaging options.',
                'seller' => 'My Box Printing',
            ]);

            $data['rating_code'] = $schema;
            $data['product_schema'] = $data['product_schema'] ?? null;

            $data['product_r'] = DB::table('products')->where('prod_url',$val)->get();
            $data['all_product'] = DB::table('products')->get();
            $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
            $faq = $data['get_product_data'][0]->id;
            // $data['faqtable']=DB::table('faq')->where('product_name',$faq)->get();
            $faqtable=DB::table('faq')->where('product_name',$faq)->get();


            $data['faqtable']=DB::table('faq')->where('product_name',$faq)->get();

          $faqtable=DB::table('faq')->where('product_name',$faq)->get();
   
            //faq code

             if(count($faqtable)!=0){
             $faq_sc = array();
            $i = 0;
            foreach($faqtable as $key=>$value){
                $faq_sc[$i]["@type"] = 'Question';
                $faq_sc[$i]["name"] = $value->question;
                $faq_sc[$i]['acceptedAnswer'] = array('@type'=>'answer', 'text'=>$value->answer);
                $i++;
            }
            $data['faq_schema'] = '{
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": '.json_encode($faq_sc).'
            }';
            }
            
            return view('frontend/products/product-detail',$data);
        }
        else{
        
        
        
                $data['url_links']=DB::table('dynamic_pages')->where('page_url',$val)->get();
                if (count($data['url_links'])>0) 
                {
                    $data['product']=DB::table('products')->get();
                    
                    $data['child_category']=DB::table('categories')->get();
                    $data['our_testimonial'] =  DB::table('testimonial')->get();
                    $data['get_related_data']=DB::table('products')->get();
                    $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
                    $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
                    $data['all_products'] = DB::table('products')->get();
                    $data['meta_title']=$data['url_links'][0]->m_title;
                    $data['meta_tags']= $data['url_links'][0]->m_tags;
                    $data['meta_description']= $data['url_links'][0]->m_des;
                    $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();



                    $data['BreadcrumbList'] = '[{
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [{
                                "@type": "ListItem",
                                "position": 1,
                                "name": "My Box Printing",
                                "item": "'.url('/').'"
                            },{
                                "@type": "ListItem",
                                "position": 2,
                                "name": "'.$data['url_links'][0]->page_name.'"
                                 
                            }]
                        }]';

                        $data['our_home_slider'] =  DB::table('home_slider')->get();
                        
                        // Get slider image safely with fallback
                        $sliderImage = !empty($data['our_home_slider'][0]) ? $data['our_home_slider'][0]->slider_banner : 'default-banner.jpg';
                        
                        $data['open_graph']='
                        <meta property="og:title" content="'.$data['url_links'][0]->m_title.'"> 
                        <meta property="og:description" content="'.$data['url_links'][0]->m_des.'"> 
                        <meta property="og:image" content="https://www.myboxprinting.com/images/'.$sliderImage.'"> 
                        <meta property="og:url" content="https://www.myboxprinting.com/'.$data['url_links'][0]->page_url.'/"> 
                        <meta property="og:type" content="website">
                        ';
                         $data['twitter_card']='<meta name="twitter:card" content="summary"> 
                        <meta name="twitter:site" content="@myboxprinting.com"> 
                        <meta name="twitter:title" content="'.$data['url_links'][0]->m_title.'"> 
                        <meta name="twitter:description" content="'.$data['url_links'][0]->m_des.'"> 
                        <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$sliderImage.'"> 
                        ';
                    return view('frontend/pages/dynamic-page',$data);
                
                }
            else
            {
                $data['url_links']=DB::table('ppc_pages')->where('prod_url',$val)->get();
                if (count($data['url_links'])>0) 
                {
                    $data['get_product_data']=DB::table('ppc_pages')->where('prod_url',$val)->get();
                    $data['meta_title']=$data['get_product_data'][0]->meta_title;
                    $data['meta_tags']= $data['get_product_data'][0]->meta_tags;
                    $data['meta_description']= $data['get_product_data'][0]->meta_description;
                    $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
                    $data['child_category'] = DB::table('categories')->where('status', '=', '0')->get();
                    
                    $data['all_products'] = DB::table('products')->get();
                    $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
                    $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
            

                    $data['BreadcrumbList'] = '[{
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [{
                                "@type": "ListItem",
                                "position": 1,
                                "name": "My Box Printing",
                                "item": "'.url('/').'"
                            },{
                                "@type": "ListItem",
                                "position": 2,
                                "name": "'.$data['url_links'][0]->prod_name.'"
                                 
                            }]
                        }]';


                    return view('frontend/products/ppc_pages',$data);
        
                }
                
                
                      
                else{
                    $data['product_r']=DB::table('otherproducts')->where('prod_url',$val)->get();
        if (count($data['product_r'])>0) 
        {
            // echo "<pre>";
            // print_r($data['url_links']);
            //     die();
            

            $data['get_product_data']=DB::table('otherproducts')->where('prod_url',$val)->get();

            $data['product']=DB::table('products')->get();
        
            $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
            $data['child_category'] = DB::table('categories')->where('status', '=', '0')->get();


            $data['our_testimonial'] =  DB::table('testimonial')->get();
            $data['get_related_data']=DB::table('products')->get();
        
            $data['all_subcategory'] = DB::table('categories')->get();
            $data['all_products'] = DB::table('products')->get();
            $data['meta_title']=$data['get_product_data'][0]->meta_title;
            $data['meta_tags']= $data['get_product_data'][0]->meta_tags;
            $data['meta_description']= $data['get_product_data'][0]->meta_description;

            $data['main_category_c_url'] = "#";
            $data['main_category_c'] = "Printing Products";

            $data['sub_cat_name_pro_url'] = "#";
            $data['sub_cat_name_pro'] = "printing-products";
        
            $data['product_name_thi']=DB::table('otherproducts')->where('prod_url',$val)->get();

              
            $data['BreadcrumbList'] = '[{
                "@context": "https://schema.org",
                "@type": "BreadcrumbList",
                "itemListElement": [{
                        "@type": "ListItem",
                        "position": 1,
                        "name": "My Box Printing",
                        "item": "'.url('/').'"
                    },{
                        "@type": "ListItem",
                        "position": 2,
                        "name": "Printing Products",
                        "item": "https://www.myboxprinting.com/printing-products/"
                    },{
                        "@type": "ListItem",
                        "position": 3,
                        "name": "'.$data['product_name_thi'][0]->prod_name.'"
                    
                    }]
                }]';

                    

            $data['all_other_product'] = DB::table('otherproducts')->get(); 
            $data['other'] = DB::table('otherproducts')->where('prod_url',$val)->get();
            $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
            $faq = $data['get_product_data'][0]->id;
            $data['faqtable']=DB::table('faq')->where('printing_product_name',$faq)->get();

            $data['faqtable']=DB::table('faq')->where('printing_product_name',$faq)->get();

          $faqtable=DB::table('faq')->where('printing_product_name',$faq)->get();
   
            //faq code

             if(count($faqtable)!=0)
             {
                    $faq_sc = array();
                        $i = 0;
                        foreach($faqtable as $key=>$value){
                            $faq_sc[$i]["@type"] = 'Question';
                            $faq_sc[$i]["name"] = $value->question;
                            $faq_sc[$i]['acceptedAnswer'] = array('@type'=>'answer', 'text'=>$value->answer);
                            $i++;
                        }
                        $data['faq_schema'] = '{
                            "@context": "https://schema.org",
                            "@type": "FAQPage",
                            "mainEntity": '.json_encode($faq_sc).'
                        }';
             }

            $data['open_graph']='
             <meta property="og:title" content="'.$data['get_product_data'][0]->meta_title.'"> 
             <meta property="og:description" content="'.$data['get_product_data'][0]->meta_description.'"> 
             <meta property="og:image" content="https://www.myboxprinting.com/images/'.$data['get_product_data'][0]->prod_image.'"> 
             <meta property="og:url" content="https://www.myboxprinting.com/'.$data['get_product_data'][0]->prod_url.'/"> 
             <meta property="og:type" content="website">
             ';
              $data['twitter_card']='<meta name="twitter:card" content="summary"> 
             <meta name="twitter:site" content="@myboxprinting.com"> 
             <meta name="twitter:title" content="'.$data['get_product_data'][0]->meta_title.'"> 
             <meta name="twitter:description" content="'.$data['get_product_data'][0]->meta_description.'"> 
             <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$data['get_product_data'][0]->prod_image.'"> 
             ';
             
            $otherProduct = $data['get_product_data'][0];
            $otherProductUrl = url(trim($otherProduct->prod_url ?? '', '/') . '/');

            $schema = $this->buildProductSchema([
                'id' => $otherProduct->id ?? null,
                'name' => $otherProduct->prod_name ?? '',
                'description' => $otherProduct->meta_description ?? '',
                'url' => $otherProductUrl,
                'primaryImage' => $otherProduct->prod_image ?? null,
                'images' => $otherProduct->prod_gallery ?? null,
                'sku' => $otherProduct->sku ?? null,
                'mpn' => $otherProduct->mpn ?? null,
                'brand' => 'My Box Printing',
                'price' => $otherProduct->low_price ?? $otherProduct->high_price ?? 0.01,
                'priceCurrency' => 'USD',
                'availability' => 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
                'ratingValue' => $otherProduct->rating_value ?? null,
                'reviewCount' => $otherProduct->review_count ?? null,
                'reviewBody' => 'Great quality product with excellent packaging options.',
                'seller' => 'My Box Printing',
            ]);

            $data['rating_code'] = $schema;
            $data['product_schema'] = $data['product_schema'] ?? null;

  $data['rel_prod']=DB::table('otherproducts')->orderBy('id', 'desc')->limit(4)->get();
             

            return view('frontend/products/product-detail',$data);
        }
           
           
           
                 
                else{
                    $data['product_r']=DB::table('cardboardboxes')->where('prod_url',$val)->get();
        if (count($data['product_r'])>0) 
        {
            // echo "<pre>";
            // print_r($data['url_links']);
            //     die();
            

            $data['get_product_data']=DB::table('cardboardboxes')->where('prod_url',$val)->get();

            $data['product']=DB::table('products')->get();
        
            $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
            $data['child_category'] = DB::table('categories')->where('status', '=', '0')->get();


            $data['our_testimonial'] =  DB::table('testimonial')->get();
            $data['get_related_data']=DB::table('products')->get();
        
            $data['all_subcategory'] = DB::table('categories')->get();
            $data['all_products'] = DB::table('products')->get();
            $data['meta_title']=$data['get_product_data'][0]->meta_title;
            $data['meta_tags']= $data['get_product_data'][0]->meta_tags;
            $data['meta_description']= $data['get_product_data'][0]->meta_description;

            $data['main_category_c_url'] = "#";
            $data['main_category_c'] = "Printing Products";

            $data['sub_cat_name_pro_url'] = "#";
            $data['sub_cat_name_pro'] = "printing-products";
        
            $data['product_name_thi']=DB::table('cardboardboxes')->where('prod_url',$val)->get();

              
            $data['BreadcrumbList'] = '[{
                "@context": "https://schema.org",
                "@type": "BreadcrumbList",
                "itemListElement": [{
                        "@type": "ListItem",
                        "position": 1,
                        "name": "My Box Printing",
                        "item": "'.url('/').'"
                    },{
                        "@type": "ListItem",
                        "position": 2,
                        "name": "Printing Products",
                        "item": "https://www.myboxprinting.com/printing-products/"
                    },{
                        "@type": "ListItem",
                        "position": 3,
                        "name": "'.$data['product_name_thi'][0]->prod_name.'"
                    
                    }]
                }]';

                    

            $data['all_other_product'] = DB::table('cardboardboxes')->get(); 
            $data['other'] = DB::table('cardboardboxes')->where('prod_url',$val)->get();
            $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
            $faq = $data['get_product_data'][0]->id;
            $data['faqtable']=DB::table('faq')->where('printing_product_name',$faq)->get();

            $data['faqtable']=DB::table('faq')->where('printing_product_name',$faq)->get();

          $faqtable=DB::table('faq')->where('printing_product_name',$faq)->get();
   
            //faq code

             if(count($faqtable)!=0)
             {
                    $faq_sc = array();
                        $i = 0;
                        foreach($faqtable as $key=>$value){
                            $faq_sc[$i]["@type"] = 'Question';
                            $faq_sc[$i]["name"] = $value->question;
                            $faq_sc[$i]['acceptedAnswer'] = array('@type'=>'answer', 'text'=>$value->answer);
                            $i++;
                        }
                        $data['faq_schema'] = '{
                            "@context": "https://schema.org",
                            "@type": "FAQPage",
                            "mainEntity": '.json_encode($faq_sc).'
                        }';
             }

            $data['open_graph']='
             <meta property="og:title" content="'.$data['get_product_data'][0]->meta_title.'"> 
             <meta property="og:description" content="'.$data['get_product_data'][0]->meta_description.'"> 
             <meta property="og:image" content="https://www.myboxprinting.com/images/'.$data['get_product_data'][0]->prod_image.'"> 
             <meta property="og:url" content="https://www.myboxprinting.com/'.$data['get_product_data'][0]->prod_url.'/"> 
             <meta property="og:type" content="website">
             ';
              $data['twitter_card']='<meta name="twitter:card" content="summary"> 
             <meta name="twitter:site" content="@myboxprinting.com"> 
             <meta name="twitter:title" content="'.$data['get_product_data'][0]->meta_title.'"> 
             <meta name="twitter:description" content="'.$data['get_product_data'][0]->meta_description.'"> 
             <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$data['get_product_data'][0]->prod_image.'"> 
             ';
             
            $cardboardProduct = $data['get_product_data'][0];
            $cardboardProductUrl = url(trim($cardboardProduct->prod_url ?? '', '/') . '/');

            $schema = $this->buildProductSchema([
                'id' => $cardboardProduct->id ?? null,
                'name' => $cardboardProduct->prod_name ?? '',
                'description' => $cardboardProduct->meta_description ?? '',
                'url' => $cardboardProductUrl,
                'primaryImage' => $cardboardProduct->prod_image ?? null,
                'images' => $cardboardProduct->prod_gallery ?? null,
                'sku' => $cardboardProduct->sku ?? null,
                'mpn' => $cardboardProduct->mpn ?? null,
                'brand' => 'My Box Printing',
                'price' => $cardboardProduct->low_price ?? $cardboardProduct->high_price ?? 0.01,
                'priceCurrency' => 'USD',
                'availability' => 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
                'ratingValue' => $cardboardProduct->rating_value ?? null,
                'reviewCount' => $cardboardProduct->review_count ?? null,
                'reviewBody' => 'Great quality product with excellent packaging options.',
                'seller' => 'My Box Printing',
            ]);

            $data['rating_code'] = $schema;
            $data['product_schema'] = $data['product_schema'] ?? null;

  $data['rel_prod']=DB::table('cardboardboxes')->orderBy('id', 'desc')->limit(4)->get();
             

            return view('frontend/products/product-detail',$data);
        }
                
                
           
         else
            {
        
                $temp['category_name']=DB::table('categories')->where('cate_url',$val)->get();

                $temp['all_category_name_sec']=DB::table('categories')->get();
                $temp['sub_category_name_sec']=DB::table('categories')->where('cate_url',$val)->get();

                $temp['sub_parent_match']=DB::table('categories')->where('id',$temp['sub_category_name_sec'][0]->parent_cate)->get();

                $faq = $temp['category_name'][0]->id;
                
                $temp['faqtable']=DB::table('faq')->where('category_name',$faq)->get();
                
                $cat=DB::table('categories')->where('cate_url',$val)->get();
                $var=$cat[0]->id;
                $temp['par']=DB::table('categories')->where('parent_cate',$var)->get();
                // Fetch products from both tables
                $products = DB::table('products')->where('prod_category',$var)->get();
                $otherProducts = DB::table('otherproducts')->where('category_id',$var)->get();
                $temp['sub_cat'] = $products->merge($otherProducts);
                $temp['product']=DB::table('products')->get();
                $temp['parent_category']=DB::table('categories')->where('parent_cate', 0)->get();
                $temp['child_category']=DB::table('categories')->get();
                $temp['get_description']=DB::table('categories')->select('cate_name')->select('cate_long_desc')->where('id',$cat[0]->id)->get();
                $temp['get_cat_name']= DB::table('categories')->select('cate_name')->where('id',$cat[0]->id)->get();
                $temp['get_category_by_id'] = DB::table('categories')->where('id',$cat[0]->id)->get();
            

                $temp['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
                $temp['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();


                $temp['all_products'] = DB::table('products')->get();
                $temp['parent_category'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id','asc')->get();
            
                $data['our_testimonial'] =  DB::table('testimonial')->get();
                $temp['meta_title']= $temp['get_category_by_id'][0]->meta_title;
                $temp['meta_tags']= $temp['get_category_by_id'][0]->meta_tags;
                $temp['meta_description']= $temp['get_category_by_id'][0]->meta_description;
                $temp['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
                
                 if($temp['category_name'][0]->parent_cate == 0)
                 {

                   $temp['BreadcrumbList'] = '[{
                    "@context": "https://schema.org",
                    "@type": "BreadcrumbList",
                    "itemListElement": [{
                            "@type": "ListItem",
                            "position": 1,
                            "name": "My Box Printing",
                            "item": "'.url('/').'"
                        },{
                            "@type": "ListItem",
                            "position": 2,
                            "name": "'.$temp['get_category_by_id'][0]->cate_name.'"
                             
                        }]
                    }]';
                }
                else
                   {
                       $temp['BreadcrumbList'] = '[{
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [{
                                "@type": "ListItem",
                                "position": 1,
                                "name": "My Box Printing",
                                "item": "'.url('/').'"
                            },{
                                "@type": "ListItem",
                                "position": 2,
                                "name": "'.$temp['sub_parent_match'][0]->cate_name.'",
                                "item": "'.url($temp['sub_parent_match'][0]->cate_url).'/"
                            },{
                                "@type": "ListItem",
                                "position": 3,
                                "name": "'.$temp['category_name'][0]->cate_name.'"
                            
                            }]
                        }]';
                    }
                
                 if($temp['category_name'][0]->parent_cate == 0)
                 {
                     $temp['sub_category'] = DB::table('categories')->where('parent_cate',$temp['category_name'][0]->id)->get();
                     
                     // Fetch products from both tables for schema
                     $products_for_schema = DB::table('products')->where('prod_category',$temp['category_name'][0]->id)->limit(10)->get();
                     $otherProducts_for_schema = DB::table('otherproducts')->where('category_id',$temp['category_name'][0]->id)->limit(10)->get();
                     $sub_products_for_schema = $products_for_schema->merge($otherProducts_for_schema)->take(10);
                    $collectionProducts = $this->mapProductsForCollection($sub_products_for_schema);
                    $categoryUrl = url(trim($temp['category_name'][0]->cate_url ?? '', '/') . '/');
                    $categoryImage = $temp['get_category_by_id'][0]->cate_image ?? null;
                    $categoryImageUrl = $categoryImage ? url('images/' . ltrim($categoryImage, '/')) : null;

                    $temp['rating_code'] = $this->buildCollectionSchema(
                        $temp['category_name'][0]->cate_name ?? '',
                        $categoryUrl,
                        $temp['category_name'][0]->meta_description ?? '',
                        $categoryImageUrl,
                        $collectionProducts
                    ) ?: null;

                    $temp['product_schema'] = null;
                          $temp['open_graph']='
             <meta property="og:title" content="'.$temp['get_category_by_id'][0]->meta_title.'"> 
             <meta property="og:description" content="'.$temp['get_category_by_id'][0]->meta_description.'"> 
             <meta property="og:image" content="https://www.myboxprinting.com/images/'.$temp['get_category_by_id'][0]->cate_image.'"> 
             <meta property="og:url" content="https://www.myboxprinting.com/'.$temp['get_category_by_id'][0]->cate_url.'/"> 
             <meta property="og:type" content="website">
             ';
              $temp['twitter_card']='<meta name="twitter:card" content="summary"> 
             <meta name="twitter:site" content="@myboxprinting.com"> 
             <meta name="twitter:title" content="'.$temp['get_category_by_id'][0]->meta_title.'"> 
             <meta name="twitter:description" content="'.$temp['get_category_by_id'][0]->meta_description.'"> 
             <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$temp['get_category_by_id'][0]->cate_image.'"> 
             ';

            
               
          

             //
              

             $faqtable=DB::table('faq')->where('category_name',$faq)->get();


             $data['faqtable']=DB::table('faq')->where('category_name',$faq)->get();
 
  
          
             //faq code
             
 
  
             $faq_sc = array();
             $i = 0;
             foreach($faqtable as $key=>$value){
                 $faq_sc[$i]["@type"] = 'Question';
                 $faq_sc[$i]["name"] = $value->question;
                 $faq_sc[$i]['acceptedAnswer'] = array('@type'=>'answer', 'text'=>$value->answer);
                 $i++;
             }
             $temp['faq_schema'] = '{
                 "@context": "https://schema.org",
                 "@type": "FAQPage",
                 "mainEntity": '.json_encode($faq_sc).'
             }';

             // Fetch products from both tables
             $products = DB::table('products')->select("products.*", "categories.id","categories.cate_url","categories.cate_name")->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->where('prod_category', $temp['get_category_by_id'][0]->id )->limit(10)->get();
             $otherProducts = DB::table('otherproducts')->where('category_id', $temp['get_category_by_id'][0]->id)->limit(10)->get();
             $temp['sub_products'] = $products->merge($otherProducts)->take(10);

             $collectionProducts = $this->mapProductsForCollection($temp['sub_products']);
             $categoryUrl = url(trim($temp['category_name'][0]->cate_url ?? '', '/') . '/');
             $categoryImage = $temp['get_category_by_id'][0]->cate_image ?? null;
             $categoryImageUrl = $categoryImage ? url('images/' . ltrim($categoryImage, '/')) : null;

             $temp['rating_code'] = $this->buildCollectionSchema(
                 $temp['category_name'][0]->cate_name ?? '',
                 $categoryUrl,
                 $temp['category_name'][0]->meta_description ?? '',
                 $categoryImageUrl,
                 $collectionProducts
             ) ?: null;

             $temp['product_schema'] = null;
                    
                      return view('frontend/categories/sub-category',$temp);
                 }
                 else {
           // Fetch products from both tables
           $products_ = DB::table('products')->where('prod_category',$temp['category_name'][0]->id)->limit(10)->get();
           $otherProducts_ = DB::table('otherproducts')->where('category_id',$temp['category_name'][0]->id)->limit(10)->get();
           $sub_product_ = $products_->merge($otherProducts_)->take(10);

        $collectionProducts = $this->mapProductsForCollection($sub_product_);
        $categoryImage = $temp['get_category_by_id'][0]->cate_image ?? ($collectionProducts[0]['schema']['primaryImage'] ?? null);
        $categoryImageUrl = $categoryImage ? url('images/' . ltrim($categoryImage, '/')) : null;
        $categoryUrl = url(trim($temp['category_name'][0]->cate_url ?? '', '/') . '/');

        $temp['rating_code'] = $this->buildCollectionSchema(
            $temp['category_name'][0]->cate_name ?? '',
            $categoryUrl,
            $temp['category_name'][0]->meta_description ?? '',
            $categoryImageUrl,
            $collectionProducts
        ) ?: null;

        $temp['product_schema'] = null;

                }
                $temp['open_graph']='
             <meta property="og:title" content="'.$temp['get_category_by_id'][0]->meta_title.'"> 
             <meta property="og:description" content="'.$temp['get_category_by_id'][0]->meta_description.'"> 
             <meta property="og:image" content="https://www.myboxprinting.com/images/'.$temp['get_category_by_id'][0]->cate_image.'"> 
             <meta property="og:url" content="https://www.myboxprinting.com/'.$temp['get_category_by_id'][0]->cate_url.'/"> 
             <meta property="og:type" content="website">
             ';
              $temp['twitter_card']='<meta name="twitter:card" content="summary"> 
             <meta name="twitter:site" content="@myboxprinting.com"> 
             <meta name="twitter:title" content="'.$temp['get_category_by_id'][0]->meta_title.'"> 
             <meta name="twitter:description" content="'.$temp['get_category_by_id'][0]->meta_description.'"> 
             <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$temp['get_category_by_id'][0]->cate_image.'"> 
             ';

            
               
          

             //
              

             $faqtable=DB::table('faq')->where('category_name',$faq)->get();


             $data['faqtable']=DB::table('faq')->where('category_name',$faq)->get();
 
  
          
             //faq code
             
 
  
             $faq_sc = array();
             $i = 0;
             foreach($faqtable as $key=>$value){
                 $faq_sc[$i]["@type"] = 'Question';
                 $faq_sc[$i]["name"] = $value->question;
                 $faq_sc[$i]['acceptedAnswer'] = array('@type'=>'answer', 'text'=>$value->answer);
                 $i++;
             }
             $temp['faq_schema'] = '{
                 "@context": "https://schema.org",
                 "@type": "FAQPage",
                 "mainEntity": '.json_encode($faq_sc).'
             }';

              // Fetch products from both tables
              $products = DB::table('products')->select("products.*", "categories.id","categories.cate_url","categories.cate_name")->leftJoin('categories', 'categories.id', '=', 'products.prod_category')->where('prod_category', $temp['get_category_by_id'][0]->id )->get();
              $otherProducts = DB::table('otherproducts')->where('category_id', $temp['get_category_by_id'][0]->id)->get();
              $temp['sub_products'] = $products->merge($otherProducts);

                return view('frontend/categories/category',$temp);
            }
        }
        } 
    }
        }}}
     
	public function save_cart(Request $request){
	       $data['price_product'] = $_POST['product_price'];
         $product_id = $request->input('productid');
         $data['product_data']=DB::table('products')->where('id',$product_id)->get();
	        $image=$data['product_data'][0]->prod_image;
          $name=$data['product_data'][0]->prod_name;
   
	 
	     $arr=["one","two","three","four","five","six","seven","eight","nine","ten"];
	     $temp=[];
      
        $check=0;
        
        
      
 
        foreach($arr as $index) {
          
          
           if($request->post($index) !=''){
              $heading=$index."-h";
              if($request->post($heading)=="Quantity"||$request->post($heading)=="quantity"){
                $data['qty']=$request->post($index);
              }else{
               $temp[$request->post($heading)] = $request->post($index);
               $check++;
              }
           }
                 
        }

        
       $variations= serialize($temp);
       
	    
	    
	    
	    
 
	   
 	Cart::add(array(
        array(
          'id' => $product_id,
          'name' =>  $name,
          'price' =>  $data['price_product'],
          'quantity' => $data['qty'],
           'conditions' =>$variations,
           'attributes'=>$image,
       
       
        ),
  )); 
  
  
  
  
   
      $items = Cart::getContent(); 
        
 
       return redirect('cart');
	   
	       
	   
	}


  public function brochures($url){
    
   
    $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
    $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

    $data['all_products'] = DB::table('products')->get();
    $data['all_promotions']=DB::table('promotions')->get();
    $data['meta_title'] = "";
    $data['meta_tags'] = "";
    $data['meta_description'] = "";
    return  view('frontend/pages/promotion-page',$data);

  
  }

    public function remove_cart(Request $request){
	       
        $id=$request->post('remove_id');
      Session::flash('remove','Item Deleted Successfully !');
     Cart::getContent();
     
     Cart::remove($id);

     return redirect('cart');
   }  

   public function clear_cart(){
    Session::flash('empty','Your Cart is Empty Now Kindly add one Item to proceed the Checkout!');
     $cart_check = Cart::getContent();
     
     Cart::clear();

     return redirect('cart');
   }  
        public function get_price(){
	    
            $data['product_id'] = $_POST['productid'];
            $countrow =$_POST['countrow'];
            $res = $_POST['res'];
            $arr=["one","two","three","four","five","six","seven","eight","nine","ten"];
            $temp=0;
            foreach($arr as $index) { 
               if($temp<$countrow){
                  $data[$index] = $res[$temp];
               }else{
                  $data[$index] = '';
               }
                  $temp++;
              }        
              
                    $result=DB::table('variations')->where(array('product_id'=>$data['product_id'],'one'=>$data['one'],'two'=>$data['two'],'three'=>$data['three'],'four'=>$data['four'],'five'=>$data['five'],'six'=>$data['six'],'seven'=>$data['seven'],'eight'=>$data['eight'],'nine'=>$data['nine'],'ten'=>$data['ten']))->get();
                    print_r($result[0]->price);
        }
        public function get_price_var3(){
            $variations=array();
            $product_id=$_POST['productid'];
            $countrow = $_POST['countrow'];
            $col = $_POST['col'];
            $col_val = $_POST['col_val'];
            
            
            
            $arr=["one","two","three","four","five","six","seven","eight","nine","ten"];
            $temp=0;
            foreach($arr as $index) { 
               if($temp<$countrow){
                if($col==$index){
                    
                    $variations[$index]= DB::table('variations')->select($index)->distinct($index)->where('product_id', $product_id)->get();
                     
                  }
                  
                 else
                  {
                     $variations[$index]=DB::table('variations')->select($index)->distinct($index)->where($col,$col_val)->where('product_id',$product_id)->get();
                  }
               }
                  $temp++;
              }
                print_r(json_encode($variations));
            
            
        }
    

  public function shop_detail_2($url)
{

 
        $links = trim($url);
        $linksname =   request()->segment(2) ;
        $link=request()->segment(1);
        $linkx =   str_replace('-', ' ', strtolower($link)) ;
        $data['content']  = DB::table('home_content')->get();
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table("products")->select("products.*", "products.id AS product_id")->leftJoin('categories', 'products.prod_category','=','categories.id')->get();
        $data['all_otherprods'] = DB::table('otherproducts')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['dynamic_pages'] = DB::table('dynamic_pages')->get();
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $links = trim($link);
        $linksnames =   str_replace('-', ' ', strtolower($links)) ;
        $data1 = DB::table('categories')->where('cate_url',$linksnames)->get();
         if(count($data1)==0){
                  return response(redirect(url('404.php')), 404);
            }
            
            
            else{
                
        $data['url_links']=DB::table('products')->select("products.*", "categories.id","categories.cate_url","categories.cate_name")->leftJoin('categories', 'products.prod_category','=','categories.id')->where('prod_url',$linksname)->where('cate_url',$linkx)->get();
           

      if(count($data['url_links']) > 0){
    
         if(is_array(json_decode($data['url_links'][0]->related_prod))>0){
              $data['rel_prod']=DB::table('products')->select("products.*", "products.id AS product_id", "categories.id","categories.cate_url","categories.cate_name")->leftJoin('categories', 'products.prod_category','=','categories.id')->whereIn('products.id',json_decode($data['url_links'][0]->related_prod))->orderBy('id', 'desc')->limit(4)->get();
         
         }
         else{
              $data['rel_prod']=[];
         }
       
        $data['meta_title']=$data['url_links'][0]->meta_title;
        $data['meta_tags']= $data['url_links'][0]->meta_tags;
        $data['meta_description']= $data['url_links'][0]->meta_description;
        $data['faqtable']=DB::table('faq')->where('product_name',$faq)->get();
            return view('frontend.products.product-detail',$data);   
       }else{
           
             $data['url_links'] = DB::table('otherproducts')->where('prod_url', $linksname)->get();
             
                
             if(count($data['url_links'])>0){
                $data['rel_prod']=DB::table('products')->select("products.*", "products.id AS product_id", "categories.id","categories.cate_url","categories.cate_name")->leftJoin('categories', 'products.prod_category','=','categories.id')->whereIn('products.id',json_decode($data['url_links'][0]->related_prod))->orderBy('id', 'desc')->limit(4)->get();
                $data['meta_title']=$data['url_links'][0]->meta_title;
                $data['meta_tags']= $data['url_links'][0]->meta_tags;
                $data['meta_description']= $data['url_links'][0]->meta_description;
                $data['faqtable']=DB::table('faq')->where('product_name',$faq)->get();
                return view('frontend.products.product-detail',$data);  
            }else{
                $data['meta_title']= "404 Page Not Found";
                $data['meta_tags']= "";
                $data['meta_description']= "";
               return response(redirect(url('404.php')), 404);
            }
       }
       
    }
}


    public function cart()
    {
        
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['meta_title']= "Cart";
        $data['meta_tags']= "Cart";
        $data['meta_description']= "Cart";
        return view('frontend/bascit/cart',$data);
    }

    public function check_out()
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }
     
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['meta_title']= "Checkout";
        $data['meta_tags']= "Checkout";
        $data['meta_description']= "Checkout";
        return view('frontend/bascit/check_out',$data);
    }
    
    public function  searchbar(Request $request)
    {
        $data['searchLinks'] = $request->get('search');
        $data['content']  = DB::table('home_content')->get();
        $data['searchLinks']  = strtolower($data['searchLinks']);
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['no_record']  = "No Record Found !";
        $data['search_category'] = DB::table('categories')->where('cate_name','LIKE', '%' . $data['searchLinks']. '%')->get();
        $data['search_prods'] = DB::table('products')->where('prod_name','LIKE', '%' . $data['searchLinks']. '%')->get();
        $data['search_otherprods'] = DB::table('otherproducts')->where('prod_name','LIKE', '%' . $data['searchLinks']. '%')->get();
       //    home page 
       $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
       $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
        $data['all_products'] = DB::table('products')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['meta_title']='Search';
        $data['meta_tags']= 'Search';
        $data['meta_description']= 'Search';
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
            return  view('frontend.search.search', $data);
        
        
    }

    public function other_product()
    {
        
        $data['content']  = DB::table('home_content')->get();
      
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['all_otherprods']  = DB::table('otherproducts')->get();

        // echo "<pre>";
        // print_r($data['all_otherprods']);
        // die();
        // $data['meta_tags']  = DB::table('otherproducts')->get();
        // $data['meta_description']  = DB::table('otherproducts')->get();
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['meta_title']='All Digital Printing Products Online, Print Your Own Product';
        $data['meta_tags']= 'custom printing products, promotional printing products, Mug Printing, T Shirt Printing, specialized printing products';
        $data['meta_description']= 'Print your own products at wholesale price. Printed products like Banners, the largest category, includes brochures, flyers, booklets as well mug and T-Shirt.';
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $data['our_home_slider'] =  DB::table('home_slider')->get();

        $data['BreadcrumbList'] = '[{
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "My Box Printing",
                    "item": "'.url('/').'"
                },{
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Printing Products"
                     
                }]
            }]';
        $listingImage = !empty($data['our_home_slider'][0]) ? $data['our_home_slider'][0]->slider_banner : 'default-banner.jpg';
        $schema = $this->buildProductSchema([
            'name' => 'Printing Products',
            'description' => $data['meta_description'] ?? '',
            'url' => url('printing-products/'),
            'primaryImage' => $listingImage,
            'images' => null,
            'sku' => 'PRINTING-PRODUCTS',
            'brand' => 'My Box Printing',
            'price' => 0.70,
            'priceCurrency' => 'USD',
            'availability' => 'https://schema.org/InStock',
            'itemCondition' => 'https://schema.org/NewCondition',
            'ratingValue' => 4.9,
            'reviewCount' => 312,
            'reviewBody' => 'Customers trust our printing products for their reliable quality and quick turnaround.',
            'seller' => 'My Box Printing',
        ]);

        $data['rating_code'] = $schema;
        $data['product_schema'] = $data['product_schema'] ?? null;

            
            $data['open_graph']='
            <meta property="og:title" content="All Digital Printing Products Online, Print Your Own Product"> 
            <meta property="og:description" content="Print your own products at wholesale price. Printed products like Banners, the largest category, includes brochures, flyers, booklets as well mug and T-Shirt."> 
            <meta property="og:image" content="https://www.myboxprinting.com/images/'.$listingImage.'"> 
            <meta property="og:url" content="https://www.myboxprinting.com/printing-products/"> 
            <meta property="og:type" content="website">
            ';
             $data['twitter_card']='<meta name="twitter:card" content="summary"> 
            <meta name="twitter:site" content="@myboxprinting.com"> 
            <meta name="twitter:title" content="All Digital Printing Products Online, Print Your Own Product"> 
            <meta name="twitter:description" content="Print your own products at wholesale price. Printed products like Banners, the largest category, includes brochures, flyers, booklets as well mug and T-Shirt."> 
            <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$listingImage.'"> 
            ';

        return  view('frontend/products/other-product', $data);
          
          
      
        

    }
    
    public function cardboard_product()
    {
        $data['content']  = DB::table('home_content')->get();
 
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['all_otherprods']  = DB::table('otherproducts')->get();
        // $data['meta_tags']  = DB::table('otherproducts')->get();
        // $data['meta_description']  = DB::table('otherproducts')->get();
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['meta_title']= "custom printed cardboard packaging wholesale | Custom Boxes";
        $data['meta_tags']= "Cardboard Packaging, cardboard packaging boxes, cardboard boxes manufacturer USA, cardboard box maker, buy cardboard boxes USA";
        $data['meta_description']= "We have a large range of high quality cardboard packaging boxes for your business needs. Free and fast delivery & bulk discounts are available.";
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        
           if(count($data)>0){
        
          return  view('frontend.products.cardboard-product', $data);
               
           }
        
        else{
             return response(redirect(url('404.php')), 404);
        }
        

    }
    
    

    public function our_blog_view()
    {
        $data['content']  = DB::table('home_content')->get();
    
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['all_blogs']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(5)->get();
        $data['all_blogss']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->paginate(8);
        $data['recent_post']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(3)->get();
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        // echo "<pre>";
        
        // print_r($data['recent_post']);
        
        // die();
        
        $data['meta_title']= "The Art & Science of Packaging: Insights, Innovations, and Impact";
        $data['meta_tags']= "My Box Printing news, My Box Printing stories, packaging insights, packaging tips, packaging toturials";
        $data['meta_description']= "Welcome to My Box Printing's Packaging Blog! Our blog is a treasure trove of industry insights, expert tips, and innovative ideas for packaging solutions.";
        
        $data['open_graph']='
        <meta property="og:title" content="The Art & Science of Packaging: Insights, Innovations, and Impact"> 
        <meta property="og:description" content="Welcome to My Box Printings Packaging Blog! Our blog is a treasure trove of industry insights, expert tips, and innovative ideas for packaging solutions."> 
        <meta property="og:image" content="src="https://www.myboxprinting.com/web/front/legacy-home-f-image.jpg"> 
        <meta property="og:url" content="https://www.myboxprinting.com/blog/"> 
        <meta property="og:type" content="website">
        ';
         $data['twitter_card']='<meta name="twitter:card" content="summary"> 
        <meta name="twitter:site" content="@myboxprinting.com"> 
        <meta name="twitter:title" content="The Art & Science of Packaging: Insights, Innovations, and Impact"> 
        <meta name="twitter:description" content="Welcome to My Box Printings Packaging Blog! Our blog is a treasure trove of industry insights, expert tips, and innovative ideas for packaging solutions."> 
        <meta name="twitter:image" content="src="https://www.myboxprinting.com/web/front/legacy-home-s-image.jpg"> 
        ';
   
        // echo "<pre>";
        // print_r($data['all_blogs']);
        // die();

        $data['BreadcrumbList'] = '[{
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "My Box Printing",
                    "item": "'.url('/').'"
                },{
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Blogs"
                     
                }]
            }]';


            $data['our_home_slider'] =  DB::table('home_slider')->get();

        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        return  view('frontend.pages.blogs.blog', $data);

    }

    public function blog_detail(Request $request)
    {
        $data['content']  = DB::table('home_content')->get();

        $newSegment = $request->segment('2');
        $newSegment =  trim($newSegment);
        $newSegmentView     = $newSegment;
    
     $aa=DB::table('blogs')->where('t_slug',$newSegmentView)->get();
       if(count($aa)==0){
        return response(redirect(url('404.php')), 404);
       }
       else{
         $data['single_data'] = "Single Blog Details"   ;
      
         $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
         $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
 
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['all_products'] = DB::table('products')->get();
         $data['all_promotions'] = DB::table('promotions')->get();
        $data['all_blogs']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(4)->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['blog_detail']  = DB::table('blogs')->where('t_slug', $newSegmentView)->get();
        $data['blog_name_b'] = $data['blog_detail'][0]->t_title;
        $data['meta_title']=$data['blog_detail'][0]->t_title;
        $data['meta_tags']= $data['blog_detail'][0]->keywords;
        $data['meta_description']= $data['blog_detail'][0]->metadesc;
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $data['blog_detail_rel']  = DB::table('blogs')->where('t_slug', $newSegmentView)->get();
        $data['all_blogss'] = DB::table('blogs')->get();
        
        $data['open_graph']='
        <meta property="og:title" content="'.$data['blog_detail'][0]->t_title.'"> 
        <meta property="og:description" content="'.$data['blog_detail'][0]->metadesc.'"> 
        <meta property="og:image" content="https://www.myboxprinting.com/images/blog/'.$data['blog_detail'][0]->t_featured_image.'"> 
        <meta property="og:url" content="https://www.myboxprinting.com/blog/'.$data['blog_detail'][0]->t_slug.'/"> 
        <meta property="og:type" content="website">
        ';
         $data['twitter_card']='<meta name="twitter:card" content="summary"> 
        <meta name="twitter:site" content="@myboxprinting.com"> 
        <meta name="twitter:title" content="'.$data['blog_detail'][0]->t_title.'"> 
        <meta name="twitter:description" content="'.$data['blog_detail'][0]->metadesc.'"> 
        <meta name="twitter:image" content="https://www.myboxprinting.com/images/blog/'.$data['blog_detail'][0]->t_featured_image.'"> 
        ';

        $data['BreadcrumbList'] = '[{
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "My Box Printing",
                    "item": "'.url('/').'"
                },{
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Blog",
                    "item": "https://www.myboxprinting.com/blog/"
                },{
                    "@type": "ListItem",
                    "position": 3,
                    "name": "'.$data['blog_name_b'].'"
                    
                }]
            }]';


            $publishDate = date('c', strtotime($data['blog_detail_rel'][0]->time));
            $data['blog_detail_page'] = '{
                "@context": "https://schema.org",
                "@type": "Article",
                "headline": "'.$data['blog_detail_rel'][0]->t_title.'",
                "image": [
                "https://www.myboxprinting.com/images/blog/'.$data['blog_detail_rel'][0]->t_featured_image.'"
                ],
                "datePublished": "'.$publishDate.'",
                "dateModified": "'.$publishDate.'",
                "author": [{
                    "@type": "Person",
                    "name": "'.$data['blog_detail_rel'][0]->t_author.'",
                    "url": "https://www.myboxprinting.com/blog/'.$data['blog_detail_rel'][0]->t_slug.'/'.'"
                }]
            }';


        return  view('frontend.pages.blogs.blog-detail', $data);  
        
       }
        
        
        
       

    }



  public function sample_kit(Request $request)
    {
            // Verify reCAPTCHA
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (empty($recaptchaResponse)) {
                Session::flash('message_for_kit', 'Please complete the reCAPTCHA verification.');
                return redirect()->back()->withInput();
            }
            
            // Verify with Google
            $secretKey = env('RECAPTCHA_SECRET_KEY');
            
            // Use cURL instead of file_get_contents for better SSL handling
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'secret' => $secretKey,
                'response' => $recaptchaResponse
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $verifyResponse = curl_exec($ch);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            if ($verifyResponse === false) {
                Session::flash('message_for_kit', 'Unable to verify reCAPTCHA. Please try again later.');
                \Log::error('reCAPTCHA cURL error: ' . $curlError);
                return redirect()->back()->withInput();
            }
            
            $responseData = json_decode($verifyResponse);
            
            if (!$responseData || !$responseData->success) {
                Session::flash('message_for_kit', 'reCAPTCHA verification failed. Please try again.');
                return redirect()->back()->withInput();
            }

            $prodname=$request->prodname;
            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
            $companyname=$request->companyname;
            $website=$request->website;
            $physicaladdress=$request->physicaladdress;
            $qty=$request->qty;
        
            $to="quotes@myboxprinting.com";
            $subject = "Sample Kit";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                      <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr>
                        
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Prodname:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$prodname.'</td> 
                        </tr>
                         
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;"> Company Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$companyname.'</td> 
                        </tr> 
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Website:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$website.'</td> 
                        </tr> 
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Physical Address:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$physicaladdress.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Qty:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty.'</td> 
                        </tr>
                     
                        
                        
                    </table> 
                </body> 
            </html>';

    
  // CRM Logging
  \App\Helpers\SpamDetector::logInquiry([
    'client_name' => $name,
    'client_email' => $email,
    'client_phone' => $phone,
    'product_name' => $prodname,
    'quantity' => $qty,
    'message' => 'Company: ' . $companyname . ', Website: ' . $website . ', Address: ' . $physicaladdress,
    'subject' => $subject,
'ip_address' => $request->ip(),
 ]);

  $this->sendEmail($to, $subject, $htmlContent, $email);
                
  Session::flash('message_for_kit','Thank you for the inquiry, our sales representative will contact soon!');
              
  return redirect()->back()->with('success', 'your message,here');
            
                 
               
            
    }
    
    
    // $headers = "From:MNP <sales@s.com>\r\n";
    // $headers .= "Reply-To: $email\r\n";
    // $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    // $headers .= "X-Priority: 1\r\n";
    // $headers .= "MIME-Version: 1.0\r\n";
    // $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
    
      public function singleprod_reqquote_p11(Request $request)
    {
            // Verify reCAPTCHA
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (empty($recaptchaResponse)) {
                Session::flash('message', 'Please complete the reCAPTCHA verification.');
                return redirect()->back()->withInput();
            }
            
            // Verify with Google using cURL (more reliable than file_get_contents)
            $secretKey = env('RECAPTCHA_SECRET_KEY');
            $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $verifyUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'secret' => $secretKey,
                'response' => $recaptchaResponse
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $verifyResponse = curl_exec($ch);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            if ($curlError) {
                \Log::error('reCAPTCHA cURL Error: ' . $curlError);
                Session::flash('message', 'Unable to verify reCAPTCHA. Please try again.');
                return redirect()->back()->withInput();
            }
            
            $responseData = json_decode($verifyResponse);
            
            if (!$responseData || !$responseData->success) {
                Session::flash('message', 'reCAPTCHA verification failed. Please try again.');
                return redirect()->back()->withInput();
            }

            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
            $length=$request->length;
            $width=$request->width;
            $height=$request->height;
            $unit=$request->unit;
            $stock=$request->stock;
            $printing=$request->color;
            $coating=$request->coating;
            $cad_sample=$request->cad_sample;
            $qty=$request->qty;
            $message=$request->message;
            $to="quotes@myboxprinting.com";
            $subject = "Order Quote";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                    
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                        </tr> 
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                        </tr> 
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Unit:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$unit.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Stock:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Color:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$printing.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Coating:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$coating.'</td> 
                        </tr>
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">CAD Sample:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$cad_sample.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Qty:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty.'</td> 
                        </tr>
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                        </tr>
                        
                        
                    </table> 
                </body> 
            </html>';

  // CRM Logging
  \App\Helpers\SpamDetector::logInquiry([
    'client_name' => $name,
    'client_email' => $email,
    'client_phone' => $phone,
    // 'product_name' => $product_name ?? null, // Not always available in this form
    'length' => $length,
    'width' => $width,
    'height' => $height,
    'unit' => $unit,
    'stock' => $stock,
    'color' => $printing,
    'coating' => $coating,
    'quantity' => $qty,
    'message' => $message,
    'subject' => $subject,
'ip_address' => $request->ip(),
 ]);

  $this->sendEmail($to, $subject, $htmlContent, $email);
  Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
   return redirect('home-thank-you');
            
                 
               
            
    }
    
    
    
      public function singleprod_reqquote_p_quote(Request $request)
    {

   
           

            $product_name=$request->prodname;
            
          
            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
            $length=$request->length;
            $width=$request->width;
            $height=$request->height;
            $unit=$request->unit;
            $stock=$request->stock;
            $printing=$request->color;
            $coating=$request->coating;
            $cad_sample=$request->cad_sample;
            $qty=$request->qty;
            $message=$request->message;
            
                if ($request->hasFile('image')) {
                        Log::info('RequestQuote: File detected.');
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalName();
                        $filename = $extension;
                        $file->move('images/blog/', $filename);
                        Log::info('RequestQuote: Moved to ' . $filename);
                    }
                    else 
                    {
                        Log::info('RequestQuote: No file detected.');
                        Log::info('RequestQuote: Inputs: ' . json_encode($request->all()));
                        $filename = "";
                    }
                    
                    
            $to="quotes@myboxprinting.com";
            $subject = "Request a Quote";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                      <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Product Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$product_name.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                        </tr> 
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                        </tr> 
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Unit:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$unit.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Stock:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Color:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$printing.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Coating:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$coating.'</td> 
                        </tr>
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">CAD Sample:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$cad_sample.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Qty:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty.'</td> 
                        </tr>
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">File:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">https://www.myboxprinting.com/images/blog/'.$filename.'</td> 
                        </tr>
                        
                        
                        
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                        </tr>
                        
                        
                    </table> 
                </body> 
            </html>';

                     // CRM Logging
                     \App\Helpers\SpamDetector::logInquiry([
                        'client_name' => $name,
                        'client_email' => $email,
                        'client_phone' => $phone,
                        'product_name' => $product_name,
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                        'unit' => $unit,
                        'stock' => $stock,
                        'color' => $printing,
                        'coating' => $coating,
                        'quantity' => $qty,
                        'message' => $message,
                        'subject' => $subject,
'ip_address' => $request->ip(),
                        'file_url' => $filename ? url('images/blog/' . $filename) : null,
                     ]);
                     
                     $this->sendEmail($to, $subject, $htmlContent, $email);
                
                    Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
              
             return redirect('/quote-thank-you/');

            
                 
               
            
    }
    
    
      public function beatmyprices(Request $request)
     {
            // Verify reCAPTCHA
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (empty($recaptchaResponse)) {
                Session::flash('message', 'Please complete the reCAPTCHA verification.');
                return redirect()->back()->withInput();
            }
            
            // Verify reCAPTCHA
            if (!$this->verifyRecaptcha($recaptchaResponse)) {
                Session::flash('message', 'reCAPTCHA verification failed. Please try again.');
                return redirect()->back()->withInput();
            }

            $product_name=$request->prodname;
            
          
            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
            $length=$request->length;
            $width=$request->width;
            $height=$request->height;
            $unit=$request->unit;
            $stock=$request->stock;
            $printing=$request->color;
            $coating=$request->coating;
            $cad_sample=$request->cad_sample;
            $qty=$request->qty;
            $message=$request->message;
            $to="quotes@myboxprinting.com";
            $to="quotes@myboxprinting.com";
            $subject = "Beat My Price";

            $filename = "";
            $fileUrl = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalName();
                $filename = $extension;
                $file->move('images/blog/', $filename);
                $fileUrl = url('images/blog/' . $filename);
            }
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                      <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Product Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$product_name.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                        </tr> 
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                        </tr> 
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Unit:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$unit.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Stock:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Color:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$printing.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Coating:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$coating.'</td> 
                        </tr>
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">CAD Sample:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$cad_sample.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Qty:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty.'</td> 
                        </tr>
                        <tr> 
                             <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">File:</th>
                             <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$fileUrl.'</td> 
                        </tr>
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                        </tr>
                        
                        
                    </table> 
                </body> 
            </html>';

  // CRM Logging
  \App\Helpers\SpamDetector::logInquiry([
    'client_name' => $name,
    'client_email' => $email,
    'client_phone' => $phone,
    'product_name' => $product_name,
    'length' => $length,
    'width' => $width,
    'height' => $height,
    'unit' => $unit,
    'stock' => $stock,
    'color' => $printing,
    'coating' => $coating,
    'quantity' => $qty,
    'message' => $message,
    'message' => $message,
    'subject' => $subject,
    'file_url' => $fileUrl,
'ip_address' => $request->ip(),
 ]);

  $this->sendEmail($to, $subject, $htmlContent, $email);
  Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
   return redirect('beatmyprices-thank-you');
            
                 
               
            
    }
    
    
     public function customboxes_form_submit(Request $request)
    {

    
            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
            $length=$request->length;
            $width=$request->width;
            $height=$request->height;
            $unit=$request->unit;
            $stock=$request->stock;
            $printing=$request->color;
            $coating=$request->coating;
            $cad_sample=$request->cad_sample;
            $qty=$request->qty;
            $message=$request->message;
            $to="quotes@myboxprinting.com";
            $subject = "Custom Boxes Quote";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                      
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                        </tr> 
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                        </tr> 
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Unit:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$unit.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Stock:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Color:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$printing.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Coating:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$coating.'</td> 
                        </tr>
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">CAD Sample:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$cad_sample.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Qty:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty.'</td> 
                        </tr>
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                        </tr>
                        
                        
                    </table> 
                </body> 
            </html>';

  $this->sendEmail($to, $subject, $htmlContent, $email);
  Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
   return redirect('customboxes-thank-you');
            
                 
               
            
    }
    
    
    
  public function singleprod_reqquote_p1(Request $request)
    {
            // Verify reCAPTCHA
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (empty($recaptchaResponse)) {
                Session::flash('message', 'Please complete the reCAPTCHA verification.');
                return redirect()->back()->withInput();
            }
            
            // Verify reCAPTCHA
            if (!$this->verifyRecaptcha($recaptchaResponse)) {
                Session::flash('message', 'reCAPTCHA verification failed. Please try again.');
                return redirect()->back()->withInput();
            }

            $product_name=$request->prodname;
            
          
            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
            $length=$request->length;
            $width=$request->width;
            $height=$request->height;
            $unit=$request->unit;
            $stock=$request->stock;
            $printing=$request->color;
            $coating=$request->coating;
            $cad_sample=$request->cad_sample;
            $qty=$request->qty;
            $message=$request->message;
            $to="quotes@myboxprinting.com";
            $subject = "Quote";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                      <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Product Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$product_name.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                        </tr> 
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                        </tr> 
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Unit:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$unit.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Stock:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Color:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$printing.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Coating:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$coating.'</td> 
                        </tr>
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">CAD Sample:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$cad_sample.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Qty:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty.'</td> 
                        </tr>
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                        </tr>
                        
                        
                    </table> 
                </body> 
            </html>';

  // CRM Logging
  \App\Helpers\SpamDetector::logInquiry([
    'client_name' => $name,
    'client_email' => $email,
    'client_phone' => $phone,
    'product_name' => $product_name ?? 'Category Quote',
    'length' => $length,
    'width' => $width,
    'height' => $height,
    'unit' => $unit,
    'stock' => $stock,
    'color' => $printing,
    'coating' => $coating,
    'quantity' => $qty,
    'message' => $message,
    'subject' => $subject,
'ip_address' => $request->ip(),
 ]);

  $this->sendEmail($to, $subject, $htmlContent, $email);
  Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
   return redirect('category-thank-you');
            
                 
               
            
    }
    
    
   public function singleprod_reqquote_p(Request $request)
    {
            // Verify reCAPTCHA
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (empty($recaptchaResponse)) {
                Session::flash('message', 'Please complete the reCAPTCHA verification.');
                return redirect()->back()->withInput();
            }
            
            // Verify reCAPTCHA
            if (!$this->verifyRecaptcha($recaptchaResponse)) {
                Session::flash('message', 'reCAPTCHA verification failed. Please try again.');
                return redirect()->back()->withInput();
            }

            $product_name=$request->prodname;
            
          
            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
            $length=$request->length;
            $width=$request->width;
            $height=$request->height;
            $unit=$request->unit;
            $stock=$request->stock;
            $printing=$request->color;
            $coating=$request->coating;
            $cad_sample=$request->cad_sample;
            $qty=$request->qty;
            $message=$request->message;
            
                if ($request->hasFile('image')) {
                        Log::info('ProductQuote: File detected.');
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalName();
                        $filename = $extension;
                        $file->move('images/blog/', $filename);
                        Log::info('ProductQuote: Moved to ' . $filename);
                    }
                    else 
                    {
                        Log::info('ProductQuote: No file detected.');
                        Log::info('ProductQuote: Inputs: ' . json_encode($request->all()));
                        $filename = "";
                    }
                    
                    
            $to="quotes@myboxprinting.com";
            $subject = "Product Request a Quote";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                      <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Product Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$product_name.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Client Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                        </tr> 
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                        </tr> 
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Unit:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$unit.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Stock:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Color:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$printing.'</td> 
                        </tr>
                         <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Coating:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$coating.'</td> 
                        </tr>
                        
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">CAD Sample:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$cad_sample.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Qty:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty.'</td> 
                        </tr>
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">File:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">https://www.myboxprinting.com/images/blog/'.$filename.'</td> 
                        </tr>
                        
                        
                        
                          <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                        </tr>
                        
                        
                    </table> 
                </body> 
            </html>';
     

         
                     // CRM Logging
                     \App\Helpers\SpamDetector::logInquiry([
                        'client_name' => $name,
                        'client_email' => $email,
                        'client_phone' => $phone,
                        'product_name' => $product_name,
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                        'unit' => $unit,
                        'stock' => $stock,
                        'color' => $printing,
                        'coating' => $coating,
                        'quantity' => $qty,
                        'message' => $message,
                        'subject' => $subject,
'ip_address' => $request->ip(),
                        'file_url' => $filename ? url('images/blog/' . $filename) : null,
                     ]);
         
                     $this->sendEmail($to, $subject, $htmlContent, $email);
                
                    Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
              
             return redirect('/thank-you/');

            
                 
               
            
    }
    

    
    
      public function blog_searchbar(Request $request)
    {
        
      
       $data['content']  = DB::table('home_content')->get();
        $data['searchblog'] = $request->get('blogsearch');
        $data['no_record']  = "No Record Exists!";
        $data['all_promotions'] = DB::table('promotions')->get();
        $data['title']  = "single Blog";
        $data['search_blogs']  =  DB::table('blogs')->where('t_title','LIKE','%'.$data['searchblog'].'%')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->get(); 
        
        
        
        
       /*if($data['search_blogs'] ){
           
       }else{
           
       } */
        
     $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
       
     $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
     $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        
         if(count($data['search_blogs'])>0){
            $data['meta_title']=$data['search_blogs'][0]->t_title;
            $data['meta_tags']= $data['search_blogs'][0]->keywords;
            $data['meta_description']= $data['search_blogs'][0]->metadesc;
        }else{
            $data['meta_title']="";
            $data['meta_tags']= "";
            $data['meta_description']= "";
            
        }
        if($request->ajax()) {
            return view('frontend.pages.blogs.blog_list_partial', ['blogs' => $data['search_blogs']])->render();
        }

        return  view('frontend.pages.blogs.blog-post-search', $data);
        }
        
         
      
          public function customboxesthankyou()
    {
        $data['meta_title']= "Thank You";
        $data['meta_tags']= "Thank You";
        $data['meta_description']= "Thank You";
        $data['content']  = DB::table('home_content')->get();
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
          $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
         $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
         $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
         $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
         $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        return response()->view('frontend.error.customboxesthankyou',$data);
    }
    
            public function beatmypricesthankyou()
    {
        $data['meta_title']= "Thank You";
        $data['meta_tags']= "Thank You";
        $data['meta_description']= "Thank You";
        $data['content']  = DB::table('home_content')->get();
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
          $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
         $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
         $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
         $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
         $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        return response()->view('frontend.error.beatmypricesthankyou',$data);
    }
    
    
          public function quotethankyou()
    {
        $data['meta_title']= "Thank You";
        $data['meta_tags']= "Thank You";
        $data['meta_description']= "Thank You";
        $data['content']  = DB::table('home_content')->get();
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
          $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
         $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
         $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
         $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
         $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        return response()->view('frontend.error.quotethankyou',$data);
    }
    
       public function homethankyou()
    {
        $data['meta_title']= "Thank You";
        $data['meta_tags']= "Thank You";
        $data['meta_description']= "Thank You";
        $data['content']  = DB::table('home_content')->get();
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
          $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
         $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
         $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
         $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
         $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        return response()->view('frontend.error.homethankyou',$data);
    }
      public function categorythankyou()
    {
        $data['meta_title']= "Thank You";
        $data['meta_tags']= "Thank You";
        $data['meta_description']= "Thank You";
        $data['content']  = DB::table('home_content')->get();
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
          $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
         $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
         $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
         $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
         $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        return response()->view('frontend.error.categorythankyou',$data);
    }
    
    public function error()
    {
        $data['meta_title']= "404 Page Not Found";
        $data['meta_tags']= "404 Page Not Found";
        $data['meta_description']= "404 Page Not Found";
        $data['content']  = DB::table('home_content')->get();
       
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
          $data['all_promotions'] = DB::table('promotions')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
         $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
         $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
         $data['feature_prod_home']  =  DB::table('products')->where('feature_prod', 1)->get();
         $data['all_products_get_4'] = DB::table('products')->orderBy('id', 'asc')->limit(10)->get();
        return response()->view('frontend.error.error',$data,404);
    }


    public function requestQoute()
    {
        $data['content']  = DB::table('home_content')->get();
        $data['meta_title'] = "Get Free Quote | My Box Printing";
        $data['meta_tags']= '';
        $data['meta_description']= 'My Box Printing Provides Online Printing Services in the USA. Including Sticker Printing, Door hangers, Business Cards and all Other Printing Types.';
      
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
          $data['all_promotions'] = DB::table('promotions')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        $data['BreadcrumbList'] = '[{
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "My Box Printing",
                    "item": "'.url('/').'"
                },{
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Request a quote"
                     
                }]
            }]';

        $data['our_home_slider'] =  DB::table('home_slider')->get();
        
        // Get slider image safely with fallback
        $sliderImage = !empty($data['our_home_slider'][0]) ? $data['our_home_slider'][0]->slider_banner : 'default-banner.jpg';
        
        $data['open_graph']='
        <meta property="og:title" content="Get Free Quote | My Box Printing"> 
        <meta property="og:description" content="My Box Printing Provides Online Printing Services in the USA. Including Sticker Printing, Door hangers, Business Cards and all Other Printing Types."> 
        <meta property="og:image" content="https://www.myboxprinting.com/images/'.$sliderImage.'"> 
        <meta property="og:url" content="https://www.myboxprinting.com/get-quote/"> 
        <meta property="og:type" content="website">
        ';
         $data['twitter_card']='<meta name="twitter:card" content="summary"> 
        <meta name="twitter:site" content="@myboxprinting.com"> 
        <meta name="twitter:title" content="Get Free Quote | My Box Printing"> 
        <meta name="twitter:description" content="My Box Printing Provides Online Printing Services in the USA. Including Sticker Printing, Door hangers, Business Cards and all Other Printing Types."> 
        <meta name="twitter:image" content="https://www.myboxprinting.com/images/'.$sliderImage.'"> 
        ';
        return  view('frontend.pages.request-quote', $data);
    }


    public function contactUs()
    {
        $data['content']  = DB::table('home_content')->get();
      
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
        $data['all_promotions'] = DB::table('promotions')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['meta_title']="Contact Us - My Box Printing";
        $data['meta_tags']= "";
        $data['open_graph']='
            <meta property="og:title" content="Contact Us - My Box Printing"> 
            <meta property="og:description" content="My Box Printing provides online printing and packaging services in the USA. We offer high-quality cardboard, corrugated and kraft packaging printing services."> 
            <meta property="og:image" content="src="https://www.myboxprinting.com/web/front/legacy-home-f-image.jpg"> 
            <meta property="og:url" content="https://www.myboxprinting.com/contact-us/"> 
            <meta property="og:type" content="website">
            ';
             $data['twitter_card']='<meta name="twitter:card" content="summary"> 
            <meta name="twitter:site" content="@myboxprinting.com"> 
            <meta name="twitter:title" content="Contact Us - My Box Printing"> 
            <meta name="twitter:description" content="My Box Printing provides online printing and packaging services in the USA. We offer high-quality cardboard, corrugated and kraft packaging printing services."> 
            <meta name="twitter:image" content="src="https://www.myboxprinting.com/web/front/legacy-home-s-image.jpg"> 
            ';

        $data['BreadcrumbList'] = '[{
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "My Box Printing",
                    "item": "'.url('/').'"
                },{
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Contact Us"
                     
                }]
            }]';



        $data['meta_description']= "My Box Printing provides online printing and packaging services in the USA. We offer high-quality cardboard, corrugated and kraft packaging printing services.";
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        return  view('frontend.pages.contact-us', $data);
    }


      public function email_contact_us(Request  $request)
       {
                    // Verify reCAPTCHA
                    $recaptchaResponse = $request->input('g-recaptcha-response');
                    
                    if (empty($recaptchaResponse)) {
                        Session::flash('message', 'Please complete the reCAPTCHA verification.');
                        return redirect()->back()->withInput();
                    }
                    
                    // Verify with Google
                    $secretKey = env('RECAPTCHA_SECRET_KEY');
                    
                    // Use cURL instead of file_get_contents for better SSL handling
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                        'secret' => $secretKey,
                        'response' => $recaptchaResponse
                    ]));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    
                    $verifyResponse = curl_exec($ch);
                    $curlError = curl_error($ch);
                    curl_close($ch);
                    
                    if ($verifyResponse === false) {
                        Session::flash('message', 'Unable to verify reCAPTCHA. Please try again later.');
                        \Log::error('reCAPTCHA cURL error: ' . $curlError);
                        return redirect()->back()->withInput();
                    }
                    
                    $responseData = json_decode($verifyResponse);
                    
                    if (!$responseData || !$responseData->success) {
                        Session::flash('message', 'reCAPTCHA verification failed. Please try again.');
                        return redirect()->back()->withInput();
                    }
             
                    $x = "contact_us";
                    $name=$request->input('contact_name');
                    $email =$request->input('contact_email');
                    $phone = $request->input('contact_phone');
                    $contact_subject = $request->input('contact_subject');
                    $message = $request->input('contact_message');
                    $subject =  $x;

                    $to = "quotes@myboxprinting.com";
                    $subject = "Contact Us";
                    $htmlContent = ' 
                    <html>
                        <head>
                        </head>
                        <body> 
                            <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                                <tr> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Name:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                                </tr> 
                                <tr style="background-color: #e0e0e0;"> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Email:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                                </tr> 
                                <tr> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Phone:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                                </tr> 
                                <tr> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Subject:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$contact_subject.'</td> 
                                </tr> 
                                <tr> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                                </tr> 
                            </table> 
                        </body> 
                    </html>';
                    //  $message = 'Name: '.$name.'<br>'.'Email:'.$email.'<br>'.'Phone:'.$phone; 

                     // CRM Logging - Log BEFORE sending email
                     \App\Helpers\SpamDetector::logInquiry([
                        'client_name' => $name,
                        'client_email' => $email,
                        'client_phone' => $phone,
                        'subject' => $contact_subject,
                        'message' => $message,
                        'ip_address' => $request->ip(),
                     ]);

                     $this->sendEmail($to, $subject, $htmlContent, $email);
                     
                     Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
                             return redirect()->back()->with('success', 'your message,here');
        }


    public function subcribed_email(Request $request)
    {
        try {
            $email = $request->input('email_subcribe');
            
            // Validate email
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::flash('error', 'Please enter a valid email address.');
                return redirect()->back();
            }
            
            $to = "quotes@myboxprinting.com";
            $subject = "New Subscriber - My Box Printing";
            
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                       
                        <tr style="background-color: #e0e0e0;"> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Subscriber Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        <tr>
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Date:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.date('Y-m-d H:i:s').'</td>
                        </tr>
                        
                    </table> 
                </body>
            </html>';
            

            
            // Send email to admin
            
            // CRM Logging
            \App\Helpers\SpamDetector::logInquiry([
                'client_email' => $email,
                'subject' => $subject,
'ip_address' => $request->ip(),
                'message' => 'New Subscriber Request',
                'client_name' => 'Subscriber',
            ]);
            Mail::send([], [], function ($message) use ($to, $subject, $htmlContent, $email) {
                $message->to($to)
                        ->subject($subject)
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->replyTo($email)
                        ->setBody($htmlContent, 'text/html');
            });
            
            // Send confirmation email to subscriber
            $confirmationSubject = "Thank You for Subscribing - My Box Printing";
            $confirmationContent = '
            <html>
                <head>
                </head>
                <body style="font-family: Arial, sans-serif;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                        <h2 style="color: #3498db;">Thank You for Subscribing!</h2>
                        <p>Dear Subscriber,</p>
                        <p>Thank you for subscribing to My Box Printing. We will keep you updated with our latest offers and news.</p>
                        <p>Best regards,<br>My Box Printing Team</p>
                    </div>
                </body>
            </html>';
            
            Mail::send([], [], function ($message) use ($email, $confirmationSubject, $confirmationContent) {
                $message->to($email)
                        ->subject($confirmationSubject)
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->setBody($confirmationContent, 'text/html');
            });
            
            Session::flash('message', 'Thank you for subscribing to My Box Printing. Please check your email for confirmation.');
            return redirect()->back()->with('success', 'Subscription successful!');
            
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Subscription email error: ' . $e->getMessage());
            
            Session::flash('error', 'There was an error processing your subscription. Please try again later.');
            return redirect()->back();
        }
    }
    
    
    
      public function email_callback(Request  $request){
          
                $src_url   =   $request->input('prodname');
                $src_url   =   str_replace(' ', '-',  strtolower($src_url));
                
          
                $x = "REQUEST A CALLBACK";
                $data =  [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'message' => $request->input('message'),
                    'subject' =>  $x,
                ];
                    
                
                // CRM Logging
                \App\Helpers\SpamDetector::logInquiry([
                    'client_name' => $request->name,
                    'client_email' => $request->email,
                    'client_phone' => $request->phone,
                    'message' => $request->message,
                    'subject' => $x,
                ]);

             Session::flash('message','We have received your message will respond you soon.');
            //   return redirect($src_url.'/');
            //   return Redirect::back()->withErrors(['msg' => 'The Message']);
              return redirect()->back()->with('success', 'your message,here');
                 
        }
        
        
          public function email_opcallback(Request  $request){
          
                $src_url   =   $request->input('prodname2');
                $src_url   =   str_replace(' ', '-',  strtolower($src_url));
                
          
                $x = "other product callback";
                $data =  [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'message' => $request->input('message'),
                    'subject' =>  $x,
                ];

                // CRM Logging
                \App\Helpers\SpamDetector::logInquiry([
                    'client_name' => $request->input('name'),
                    'client_email' => $request->input('email'),
                    'client_phone' => $request->input('phone'),
                    'message' => $request->input('message'),
                    'subject' => $x,
                ]);
                    
                
             
             
              Mail::to('quotes@myboxprinting.com')->send(new SendMail($data));
              Mail::to('quotes@myboxprinting.com')->send(new SendMail($data));
              Session::flash('message','We have received your message will respond you soon.');
                      return redirect()->back()->with('success', 'your message,here');
                 
        }
        public function callBack(Request $request)
        {

                $x = "CallBack";
                    $name = $request->input('name');
                    $email = $request->input('email');
                    $phone = $request->input('phone');
                    $subject =  $x;
                    $to = "quotes@myboxprinting.com";
                    $subject = "Call Back";
                    $htmlContent = ' 
                <html>
                    <head>
                    </head>
                    <body> 
                        <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Name:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                            </tr> 
                            <tr style="background-color: #e0e0e0;"> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Email:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                            </tr> 
                            <tr> 
                                <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Phone:</th>
                                <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                            </tr> 
                        </table> 
                    </body> 
                </html>';

                     $this->sendEmail($to, $subject, $htmlContent, $email);
                    Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
                       return redirect()->back()->with('success', 'your message,here');
             
        }
        
         public function email_prom_quot(Request $request)
         {
                $x = "promotion_quote";
                $data =  [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'message' => $request->input('message'),
                    'subject' =>  $x,
                ];
                    
                
             
             
                // CRM Logging
                \App\Helpers\SpamDetector::logInquiry([
                    'client_name' => $request->input('name'),
                    'client_email' => $request->input('email'),
                    'client_phone' => $request->input('phone'),
                    'message' => $request->input('message'),
                    'subject' => $x,
                ]);

               try {
                  Mail::to('quotes@myboxprinting.com')->send(new SendMail($data));
                  Mail::to('quotes@myboxprinting.com')->send(new SendMail($data));
               } catch (\Exception $e) {
                   Log::error("Email failed: " . $e->getMessage());
               }
              Session::flash('message','We have received your message will respond you soon.');
                       return redirect()->back()->with('success', 'your message,here');
         }
         
        
         
         
          public function GetAQuote(Request  $request)
           {
                $x = "GetaQuote";
                    $name = $request->input('name');
                    $email = $request->input('email');
                    $phone = $request->input('phone');
                    $message = $request->input('message');
                    $subject =  $x;

                    $to = "quotes@myboxprinting.com";
                    $subject = "GetaQuote";
                    $htmlContent = ' 
                    <html>
                        <head>
                        </head>
                        <body> 
                            <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                                <tr> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Name:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                                </tr> 
                                <tr style="background-color: #e0e0e0;"> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Email:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                                </tr> 
                                <tr> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Phone:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                                </tr> 
                                <tr> 
                                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                                    <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                                </tr> 
                            </table> 
                        </body> 
                    </html>';

                     // CRM Logging - Log BEFORE sending email
                     \App\Helpers\SpamDetector::logInquiry([
                        'client_name' => $name,
                        'client_email' => $email,
                        'client_phone' => $phone,
                        'message' => $message,
                        'subject' => $subject,
'ip_address' => $request->ip(),
                     ]);
                     
                     $this->sendEmail($to, $subject, $htmlContent, $email);

                        Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
                               return redirect()->back()->with('success', 'your message,here');   
                    
                   
                 
            }
    
    
    public function email_req_quote(Request $request)
    {
        $req_quote = "email_request_quote";
         $name=$request->name;
         $email=$request->email;
         $phone=$request->phone;
         $box_style=$request->box_style;
         $qty_one=$request->qt1;
         $qty_two=$request->qt2;
         $qty_three=$request->qt3;
         $qty_four=$request->qt4;
         $stock=$request->stock;
         $type=$request->type;
         $length=$request->length;
         $width=$request->width;
         $height=$request->height;
         $color=$request->color;
         $inches=$request->inches;
         $comment=$request->comment;
         $subject = $req_quote;

            $to = "quotes@myboxprinting.com";
            $subject = "Request Quote";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr style="background-color: #e0e0e0;"> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Box Style:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$box_style.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Quantity 1:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty_one.'</td> 
                        </tr> 

                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Quantity 2:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty_two.'</td> 
                        </tr> 
                        <tr style="background-color: #e0e0e0;"> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Quantity 3:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty_three.'</td> 
                        </tr> 
                        <tr style="background-color: #e0e0e0;"> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Quantity 4:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty_four.'</td> 
                        </tr>
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Stock:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Type:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$type.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                        </tr> 

                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                        </tr> 
                        <tr style="background-color: #e0e0e0;"> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Color:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$color.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Measurment:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$inches.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$comment.'</td> 
                        </tr> 
                    </table> 
                </body> 
            </html>';

                    // CRM Logging - Log BEFORE sending email
                    \App\Helpers\SpamDetector::logInquiry([
                        'client_name' => $name,
                        'client_email' => $email,
                        'client_phone' => $phone,
                        'product_name' => $box_style, // Treating box_style as product name
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                        'stock' => $stock,
                        'color' => $color,
                        'quantity' => $qty_one,
                        'message' => $comment,
                        'subject' => $subject,
'ip_address' => $request->ip(),
                    ]);

                     $this->sendEmail($to, $subject, $htmlContent, $email);

                    Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
                         return redirect()->back()->with('success', 'your message,here');
                
         

    }

  public function email_prodreq_quote(Request $request)
    {
        
        
        $src_url   =   $request->input('prodname1');
        $src_url   =   str_replace(' ', '-',  strtolower($src_url));
        $req_quote = "email_prod_requote";

       
 
    $data=array(
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'stock'=>$request->stock,
        'box_style'=>$request->box_style,
        'color'=>$request->color,
        'type'=>$request->type,
        'length'=>$request->length,
        'width'=>$request->width,
        'height'=>$request->height,
        'unit'=>$request->unit,
        'qty'=>$request->qty,
        'qty1'=>$request->qty1,
        'qty2'=>$request->qty2,
        
        'subject'=>$req_quote
    );


        // CRM Logging - Log BEFORE sending email
        \App\Helpers\SpamDetector::logInquiry([
            'client_name' => $request->name,
            'client_email' => $request->email,
            'client_phone' => $request->phone,
            'stock' => $request->stock,
            'product_name' => $request->box_style,
            'color' => $request->color,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'unit' => $request->unit,
            'quantity' => $request->qty,
            'subject' => $req_quote,
        ]);

        try {
            Mail::to('quotes@myboxprinting.com')->send(new SendMail($data));
            Mail::to('quotes@myboxprinting.com')->send(new SendMail($data));
        } catch(\Exception $e) {
            // Ignore email failure for local testing
            Log::error("Email failed: " . $e->getMessage());
        }

        Session::flash('message','Thank you for the inquiry, our sales representative will contact you very soon!');
               return redirect()->back()->with('success', 'your message,here');

}


          public function PPCForm(Request  $request){
                // Verify reCAPTCHA
                $recaptchaResponse = $request->input('g-recaptcha-response');
                
                if (empty($recaptchaResponse)) {
                    Session::flash('message', 'Please complete the reCAPTCHA verification.');
                    return redirect()->back()->withInput();
                }
                
                // Verify with Google
                $secretKey = env('RECAPTCHA_SECRET_KEY');
                
                // Use cURL instead of file_get_contents for better SSL handling
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                    'secret' => $secretKey,
                    'response' => $recaptchaResponse
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                
                $verifyResponse = curl_exec($ch);
                $curlError = curl_error($ch);
                curl_close($ch);
                
                if ($verifyResponse === false) {
                    Session::flash('message', 'Unable to verify reCAPTCHA. Please try again later.');
                    \Log::error('reCAPTCHA cURL error: ' . $curlError);
                    return redirect()->back()->withInput();
                }
                
                $responseData = json_decode($verifyResponse);
                
                if (!$responseData || !$responseData->success) {
                    Session::flash('message', 'reCAPTCHA verification failed. Please try again.');
                    return redirect()->back()->withInput();
                }

                $x = "PPCForm";
                    $name = $request->input('name');
                    $email =$request->input('email');
                    $phone = $request->input('phone');
                    $message = $request->input('message');
                    $subject = $x;

                  
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalName();
                        $filename = $extension;
                        $file->move('images/blog/', $filename);
                        
                    }
                    else 
                    {
                        $filename = "";
                    }
            $to = "quotes@myboxprinting.com";
            $subject = "PPC Form";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr style="background-color: #e0e0e0;"> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                    
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">file:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">
                            <img src="https://www.myboxprinting.com/images/blog/'.$filename.'" alt="services-1" class="" style="border-radius:20px;"/>
                            
                            </td> 
                        </tr> 

                    
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                        </tr> 
                    </table> 
                </body> 
            </html>';

                     // CRM Logging
                     \App\Helpers\SpamDetector::logInquiry([
                        'client_name' => $name,
                        'client_email' => $email,
                        'client_phone' => $phone,
                        'message' => $message,
                        'subject' => $subject,
'ip_address' => $request->ip(),
                        'file_url' => $filename ? url('images/blog/' . $filename) : null,
                     ]);
                     
                     $this->sendEmail($to, $subject, $htmlContent, $email);
                     
                    Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
                       return redirect()->back()->with('success', 'your message,here');
                
          
        }
public  function user_login()
{
     
    $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
    $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['meta_title']= "Login";
        $data['meta_tags']= "Login";
        $data['meta_description']= "Login";
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
    return view('frontend/user_account/user_login',$data);
}
public  function user_signup()
{
   
    $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
    $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

      $data['all_products'] = DB::table('products')->get();
      $data['meta_title']= "Signup";
        $data['meta_tags']= "Signup";
        $data['meta_description']= "Signup";
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
  return view('frontend/user_account/user_signup',$data);
}

  public function singleprod_reqquote(Request $request)
    {
   
            $src_url   =   $request->input('prodname2');
            $src_url   =   str_replace(' ', '-',  strtolower($src_url));

            $req_quote = "email_singleprod_requote";

            $box_style=$request->product_name;
            $name=$request->name;
            $email=$request->email;
            $phone=$request->phone;
            $stock=$request->stock;
            $qty=$request->qty;
            $unit=$request->unit;
            $length=$request->length;
            $width=$request->width;
            $height=$request->height;
            $printing=$request->printing;
            $message=$request->message;
            $subject=$req_quote;

            $to = "quotes@myboxprinting.com";
            $subject = "Product Form";
            $htmlContent = ' 
            <html>
                <head>
                </head>
                <body> 
                    <table cellspacing="0" style="width: 600px; border-collapse: collapse;"> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Box Style:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$box_style.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Name:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$name.'</td> 
                        </tr> 
                        <tr style="background-color: #e0e0e0;"> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Email:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$email.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Phone:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$phone.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Color:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$stock.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Quantity:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$qty.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Unit:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$unit.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Length:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$length.'</td> 
                        </tr> 
                        <tr style="background-color: #e0e0e0;"> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Width:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$width.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Height:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$height.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Printing:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$printing.'</td> 
                        </tr> 
                        <tr> 
                            <th style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;background: #3498db;  color: white;  font-weight: bold;">Message:</th>
                            <td style="padding: 10px; border: 1px solid #ccc; text-align: left; font-size: 18px;">'.$message.'</td> 
                        </tr> 
                    </table> 
                </body> 
            </html>';

                     // CRM Logging
                     \App\Helpers\SpamDetector::logInquiry([
                        'client_name' => $name,
                        'client_email' => $email,
                        'client_phone' => $phone,
                        'product_name' => $box_style,
                        'stock' => $stock,
                        'quantity' => $qty,
                        'unit' => $unit,
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                        'coating' => $printing,
                        'message' => $message,
                        'subject' => $subject,
'ip_address' => $request->ip(),
                     ]);

                     $this->sendEmail($to, $subject, $htmlContent, $email);
                    Session::flash('message','Thank you for the inquiry, our sales representative will contact soon!');
                          return redirect()->back()->with('success', 'your message,here');
                
    }




    public function promotions()
    {
        $data['content']  = DB::table('home_content')->get();
             $data['title'] = "contact us";
    
             $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
             $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
     
          $data['all_promotions'] = DB::table('promotions')->get();
        $data['all_products'] = DB::table('products')->get();
        $data['our_socials']  =DB::table('socials_media')->get();
         $data['why_tcb2']  =  DB::table('dynamic_pages')->where('page_url', 'why-tcb.php')->get();
        $data['clients_feedback']  = DB::table('blogs')->orderBy('time', 'DESC')->orderBy('t_id', 'DESC')->limit(2)->get();
        $data['all_cardboardprods'] = DB::table('cardboardboxes')->get();
        $data['meta_title']='';
        $data['meta_tags']= '';
        $data['meta_description']= '';
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
         return view('frontend.pages.promotion-page', $data);
    }





    public function user_login_check(Request $request)
    {

       



             $username  =  $request->get('username');

             $password = md5($request->get('password'));
     
             $active_user = DB::table('user_signup')->where('user_name', $username)->get();
     
     
     
                     
             if(!empty($active_user) && count($active_user) > 0){
     
                      if( $active_user[0]->password == $password ){
     
                         Session::put('user_name', $active_user[0]->user_name);
                         Session::put('user_id', $active_user[0]->id);
                    
                         Session::put('user_pass', $active_user[0]->password);
     
                         Session::flash('message','You are logged in successfullly !');
                         return  redirect('user-dashboard');
     
                      }else{
                          Session::flash('message','Password Mismatch !');
                          return redirect('user-login');
                      }
     
             }
             else{
                  Session::flash('message','Data does not exists!  !');
                  return redirect('user-login');
             }




    }


    public function check_rows(Request $request)
    {

        $data['get_signup_data'] = DB::table("user_signup")->where("id", Session::get("user_id"))->get();
       
         $get_total_balance= $data['get_signup_data'][0]->total_balance;

         $old_used_balance= $data['get_signup_data'][0]->used_balance;

        $total_rows=$request->input('bln');
        $price_one_row=1;
        $get_total_price=$total_rows*$price_one_row;
        $new_used_balance=  $old_used_balance+$get_total_price;

        $new_remaining_balance=$get_total_balance-$new_used_balance;


      DB::table('user_signup')->where('id',Session::get("user_id"))->update(array("used_balance"=>$new_used_balance,"remaining_balance"=>$new_remaining_balance));

      
      return redirect('user-dashboard');

 


    }

    public function user_dashboard()
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }

        $data['get_signup_data'] = DB::table("user_signup")->where("id", Session::get("user_id"))->get();
       

            // echo"<pre>";
            // print_r( $data['get_signup_data']);
            // die();

            $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
            $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();
    
        $data['all_products'] = DB::table('products')->get();
        $data['meta_title']='Dashboard';
        $data['meta_tags']= 'Dashboard';
        $data['meta_description']= 'Dashboard';
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        return view('frontend/user_account/user_dashboard',$data);
    }
    public function my_orders()
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }
   
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

      $data['all_products'] = DB::table('products')->get();
      $data['get_my_orders'] = DB::table("orders")->where("cus_id", Session::get("user_id"))->get();
      $data['meta_title']='My Orders';
        $data['meta_tags']= 'My Orders';
        $data['meta_description']= 'My Orders';
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
      return view("frontend/user_account/my-orders", $data);
    }
    public function order_details($id)
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }
    
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

      $data['all_products'] = DB::table('products')->get();
      $data['get_order_details_by_id'] = DB::table("orders")->where("order_id", $id)->get();
      $data['meta_title']='Order Details';
      $data['meta_tags']= 'Order Details';
      $data['meta_description']= 'Order Details';
      $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
      return view("frontend/user_account/order-details", $data);
    }
    public function account_setting()
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }
  
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

      $data['all_products'] = DB::table('products')->get();
      $data['get_user_details_by_id'] = DB::table("user_signup")->where("id", Session::get("user_id"))->get();
      $data['meta_title']='Account Setting';
      $data['meta_tags']= 'Account Setting';
      $data['meta_description']= 'Account Setting';
      $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
      return view("frontend/user_account/account-setting", $data);
    }
    public function update_profile(Request $request)
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }
      $data['name'] = $request->input("name");
      $data['number'] = $request->input("number");
      $result = DB::table("user_signup")->where("id", Session::get("user_id"))->update($data);
      return redirect("account-setting");
    }
    public function leave_review($id)
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }
      $data = array();
 
      $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
      $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

      $data['all_products'] = DB::table('products')->get();
      $data['meta_title']='Leave Review';
      $data['meta_tags']= 'Leave Review';
      $data['meta_description']= 'Leave Review';
      $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
      return view("frontend/user_account/leave-review", $data);
    }
    public function submit_review_for_product(Request $request)
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }
        $data['star_rating'] = $request->input("star_rating");
        $data['product_review'] = $request->input("product_review");
        $data['product_id'] = $request->input("product_id");
        $data['product_review_time'] = time();
        $data['user_id'] = Session::get("user_id");
        $result = DB::table("product_star_rating")->insert($data);
        if($result==1){
            return redirect("successfully-submit-review");
        }
    }
    public function successfully_submit_review()
    {
        if(empty(Session::get("user_name"))){
            return redirect('user-login');
        }
        $data = array();
    
        $data['parent_category'] = DB::table('categories')->where('status', '=', '0')->where('parent_cate', '=', '0')->orderBy('id','asc')->get();	
        $data['all_subcategory'] = DB::table('categories')->where('status', '=', '0')->get();

        $data['all_products'] = DB::table('products')->get();
        $data['meta_title']='Successfully Submit Review';
        $data['meta_tags']= 'Successfully Submit Review';
        $data['meta_description']= 'Successfully Submit Review';
        $data['parent_category_style'] = DB::table('categories')->where('parent_cate', 0)->orderBy('id', 'desc')->limit(1)->get();
        return view("frontend/user_account/successfully-submit-review", $data);
    }
    public function payment_gateway(Request $request)
    {
        
        $payment=$request->input('payment');
        if($payment=='paypal'){
             echo "This is Paypal";
            die();
        }
        else{
        echo "This is Paytrace";
        die();
      }
    }
    public function user_logout()
    {
        Session::flush();
        Session::forget('user_name');
        Session::forget('password');
        Session::flash('logout_msg'," You'r logout successfully! ");
        return redirect('user-login');
    }
    
    /**
     * Helper method to send email using Laravel Mail and log to database
     */
    private function sendEmail($to, $subject, $htmlContent, $replyTo = null, $formType = null)
    {
        $fromEmail = config('mail.from.address');
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        
        // Create email log entry
        $emailLog = EmailLog::create([
            'to_email' => $to,
            'from_email' => $fromEmail,
            'subject' => $subject,
            'body' => $htmlContent,
            'reply_to' => $replyTo,
            'status' => 'pending',
            'form_type' => $formType,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
        
        try {
            Mail::send([], [], function ($message) use ($to, $subject, $htmlContent, $replyTo, $fromEmail) {
                $message->to($to)
                        ->subject($subject)
                        ->from($fromEmail, config('mail.from.name'))
                        ->setBody($htmlContent, 'text/html');
                
                if ($replyTo) {
                    $message->replyTo($replyTo);
                }
            });
            
            // Update status to sent
            $emailLog->update([
                'status' => 'sent'
            ]);
            
            return true;
        } catch (\Exception $e) {
            // Update status to failed with error message
            $emailLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);
            
            Log::error('Email send error: ' . $e->getMessage());
            return false;
        }
    }
}
