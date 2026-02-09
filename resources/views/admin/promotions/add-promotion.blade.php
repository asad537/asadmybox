@extends('layouts/admin')

@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>

    @if (Session::has('message'))
            <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
                <?php   echo Session::get('message');  ?>
            </div>
    @endif
    

    @if (Session::has('error'))
            <div class="alert alert-danger session-destroy mt-sm-4 mx-sm-4">
                <?php   echo Session::get('error');  ?>
            </div>
    @endif



    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>Add Insta Feeds </h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <form class="form px-sm-4" method="post" action="{{ url('/create-promotion').'/' }}"  enctype="multipart/form-data">
          "
            @csrf
            <div class="row">

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="promo_title" type="text" name="promo_title" class="form-control bg-light smalll" required=" required" />
                        <label for="promo_title" class="col-form-label"> Insta Feeds  Title </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="promo_title" type="text" name="url" class="form-control bg-light smalll" required=" required" />
                        <label for="promo_title" class="col-form-label"> Insta Feeds  URL </label>
                    </div>
                </div>

                

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="promo_banner" type="file" name="promoBanner" class="form-control bg-light smalll"  />
                        <label for="promo_banner" class="col-form-label"> Insta Feeds  Banner </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <button type="submit" name="submit" class="btn btn-submit-view px-sm-5"> Save </button>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts') @endsection
