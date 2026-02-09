@extends('layouts/admin')

@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>Insta Feeds </h3>
            </div>
        </div>
        <div class="clearfix"></div>

        @foreach ($edit_promotions as $singleitem)
            <form class="form px-sm-4" method="post" action="{{ url('/create-promotion').'/' }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  

   
                     <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="promo_title" type="text" name="promo_title" class="form-control bg-light smalll"  value="{{ $singleitem->promo_title }}" readonly/ />
                            <label for="promo_title" class="col-form-label"> Insta Feeds  Title </label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            
                            <img src="{{ url('images/'. $singleitem->promo_banner) }}" alt=""  class="mx-auto img-fluid" readonly/ >
                            
                           <div><label for="promo_banner" class="col-form-label"> Insta Feeds  Banner </label></div> 
                            
                        </div>
                    </div>

                </div>
            </form>
        @endforeach
    </div>
</div>

@endsection
@section('scripts')



@endsection
