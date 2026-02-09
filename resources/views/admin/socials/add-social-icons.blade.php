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
                <h3>Add Socials </h3>
            </div>
        </div>
        <div class="clearfix"></div>


        @foreach ($socials_links as $perLink)
        
        <form class="form px-sm-4" method="post" action="{{ url('create-socials').'/'}}" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="facebook_link" value="{{ $perLink->facebook_link }}" class="form-control bg-light smalll" />
                        <label for="inputText4" class="col-form-label"> Facebook </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="twitter_link" value="{{ $perLink->twitter_link }}" class="form-control bg-light smalll" />
                        <label for="inputText4" class="col-form-label"> Twitter </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="pinterest_link"  value="{{ $perLink->pinterest_link }}"class="form-control bg-light smalll" />
                        <label for="inputText4" class="col-form-label"> Pinterest </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="instagram_link" value="{{ $perLink->instagram_link }}" class="form-control bg-light smalll" />
                        <label for="inputText4" class="col-form-label"> Instagram </label>
                    </div>
                </div>
                
                
                 <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="linkedin_link" value="{{ $perLink->linkedin_link }}" class="form-control bg-light smalll" />
                        <label for="inputText5" class="col-form-label"> Linkedin </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText6" type="text" name="youtube_link"  value="{{ $perLink->youtube_link }}"class="form-control bg-light smalll" />
                        <label for="inputText6" class="col-form-label"> Youtube </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText7" type="text" name="google_link" value="{{ $perLink->google_link }}" class="form-control bg-light smalll" />
                        <label for="inputText7" class="col-form-label"> Google</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <button type="submit" class="btn btn-submit-view px-sm-5"> Save </button>
                    </div>
                </div>
            </div>
        </form>

            
        @endforeach
    </div>
</div>

@endsection
@section('scripts') @endsection
