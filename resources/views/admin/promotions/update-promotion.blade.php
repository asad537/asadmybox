@extends('layouts/admin')

@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>

    @if (Session::has('message'))
            <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
                <?php   echo Session::get('message');  ?>
            </div>
    @endif

    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>Update Insta Feeds </h3>
            </div>
        </div>
        <div class="clearfix"></div>

        @foreach ($edit_promotions as $singlePage)


            <form class="form px-sm-4" method="post" action="{{ url('update-promotion'.'/'.$singlePage->promo_id).'/'}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    
                     <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="promo_title" type="text" name="promo_title" class="form-control bg-light smalll"  value="{{ $singlePage->promo_title }}" required=" required" />
                            <label for="promo_title" class="col-form-label"> Insta Feeds  Title </label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="promo_title" type="text" name="url" class="form-control bg-light smalll"  value="{{ $singlePage->url }}" />
                        <label for="promo_title" class="col-form-label"> Insta Feeds  URL </label>
                    </div>
                </div>
                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                              <label for="promo_banner" class="col-form-label position-static"> Insta Feeds  Banner </label>
                            <input id="promo_banner" type="file" name="promoBanner" class="form-control bg-light smalll" />
                            <img src="{{ url('images/'. $singlePage->promo_banner) }}" alt=""  class="mx-auto img-fluid" >
                            <input type="hidden" name="oldbanner"  value="{{ $singlePage->promo_banner }}" />
                           
                            
                        </div>
                    </div>

                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <button type="submit" class="btn btn-submit-view px-sm-5"> Update </button>
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
