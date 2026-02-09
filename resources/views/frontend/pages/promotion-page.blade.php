@extends('layouts/frontend') @section('content') @if (Session::has('message'))
<div class="alert alert-success session-destroy my-sm-0 py-sm-3 text-center">
    <?php echo Session::get('message'); ?>
</div>
@endif



   <style>
    
    .breadcrumb>li+li:before {
    padding: 0 5px;
    color: #ccc;
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
<div class="col-xs-12 col-sm-4 col-md-4 breadcrumb_div">
<ol class="breadcrumb" vocab="" typeof="BreadcrumbList">
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{url('/')}}">  <i  style="color: #55b3e6;" class="fa fa-home"></i> </a>
		<meta property="position" content="1"> </li>
 
	<li property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" href="{{url('promotions').'/'}}"> 
		<span property="name" style="color: #55b3e6;"> Promotions</span></a>
		<meta content="3" property="position">
	</li>
	
 

</ol>
</div>

 <div class="clearfix"></div>
    
     

 
<div class="promo-section promo-top text-center pt-sm-5 pt-4">
    <div class="container">
        <div class="text-center">
            <h3 class="text-center"><i>"We Make Every Purchase Special"</i></h3>
            <h4 class="text-center">
                * Limited Time Offer *<br />
                <small>Valid Till December 31st, 2022</small>
            </h4>
        </div>

        
        @foreach($all_promotions as  $indexPromo)
        
               <div class="col-12 col-sm-12 mb-sm-4 mb-3">
                    <div class="promo-boxed"><img class="img-fluid" src="{{asset('images/'.$indexPromo->promo_banner)}}"  alt="{{$indexPromo->promo_title}}" />
                        <button class="btn btn-dark btn-lg" data-toggle="modal" data-target="#exampleModal">Order Now</button>
                    </div>
                </div>
        
        @endforeach
                

   
    
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #3092c0; color: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="call_back_h" class="form-horizontal" action="{{url('email_promotions')}}" method="POST">
                    @csrf
                    <div class="modal-body row">
                        <label class="input col-12"> <input class="form-control" id="name" type="text" name="name" placeholder="Name" maxlength="255" value="" required="" /> </label>
                        <label class="input col-12"> <input class="form-control" id="email" type="email" name="email" placeholder="Email" maxlength="255" value="" required="" /> </label>
                        <label class="input col-12"> <input class="form-control" id="contact" type="text" name="phone" maxlength="255" placeholder="Contact" value="" required="" /> </label>
                        <label class="input col-12">
                            <textarea class="form-control" id="message" type="text" name="message" maxlength="255" placeholder="Message" rows="6" required=""></textarea>
                        </label>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer" style="border: none;">
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-default pull-right" style="margin: auto; margin-top: 1em; display: block;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
