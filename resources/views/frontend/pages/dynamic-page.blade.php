@include('frontend/header')
               <section class="page-title-area breadcrumb-spacing cp-bg-14" style="background-color: var(--clr-bg-14);">
       
         
        </section>    
   <style>
    
    .breadcrumb>li+li:before {
    padding: 0 5px;
    color: red;
    content: "/\00a0";
}

        .breadcrumb {
    padding: 8px 15px;
    margin-bottom: 20px;
    list-style: none;
    background-color: #f5f5f5;
    border-radius: 4px;
}


    </style>



 <div class="col-xs-12 col-sm-4 col-md-4 breadcrumb_div" style="    padding: 20px;">
<ol class="breadcrumb" vocab="" typeof="BreadcrumbList">
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{url('/')}}">  <i  style="color: red;" class="fa fa-home"></i> </a>
		<meta property="position" content="1"> </li>
 
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{ url(str_replace(' ', '-', strtolower($url_links[0]->page_url))).'/'}}"> 
		<span property="name" style="color: red;">   {{$url_links[0]->page_name}}</span></a>
		<meta content="3" property="position">
	</li>
	
 

</ol>
</div>
  
<div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
         <h1 class="cp-title   wow fadeInUp    animated" data-wow-duration="1.5s" data-wow-delay="0.4s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.4s; animation-name: fadeInUp;"><?php echo $url_links[0]->page_name ; ?> </h1>
         
            </div>
        </div>
    </div>
 
<section class="about-page about-page-segment">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
         
               <div class="content-area">
    <?= htmlspecialchars_decode($url_links[0]->page_desc); ?>
</div>
            </div>
        </div>
    </div>
</section>
<style>
  .content-area ul {
  list-style-type: disc !important;
  list-style-position: outside !important;
  padding-left: 35px !important;
  margin-left: 0 !important;
}

.content-area li {
  display: list-item !important;
  color: #000 !important; /* ensure text color is visible */
  position: relative;
}

/* Force bullets (including in dark themes) */
.content-area li::marker {
  color: #000 !important;      /* bullet color */
  opacity: 1 !important;       /* make sure it's visible */
  font-size: 1em !important;   /* normal size */
}

/* In case the ::marker is suppressed by flex or resets, add custom bullet */
.content-area li::before {
  content: "•";
  position: absolute;
  left: -1.2em;
  color: #000 !important;      /* bullet color */
  font-size: 1.1em;
  line-height: 1;
  display: inline-block;
  margin-top: 6px;
}

/* Prevent double bullets (hide default if ::before is used) */
.content-area li::marker {
  display: none !important;
}

.content-area table {
  border-collapse: collapse !important;   /* ensures single unified border grid */
  width: 100% !important;                 /* optional: make full width */
  border: 1px solid #000 !important;      /* outer border */
}

.content-area th,
.content-area td {
  border: 1px solid #000 !important;      /* inner borders */
  padding: 8px !important;                /* neat cell spacing */
  text-align: left;                       /* consistent text alignment */
  vertical-align: middle;                 /* vertically centered text */
}

/* Optional: header styling for better look */
.content-area th {
  background-color: #f5f5f5 !important;
  font-weight: bold;
}
</style>
<!-- =========================  contact-us  Area End ========================= -->

@include('frontend/footer')