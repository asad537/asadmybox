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
                <h3>Add Video </h3>
            </div>
        </div>
        <div class="clearfix"></div>

        @foreach ($vid_link as $links)      
           <form class="form px-sm-4" method="post" action="{{ url('create-video').'/' }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText1" type="text" name="video_title" value="{{ $links->video_title }}" class="form-control bg-light smalll" required=" required" />
                            <label for="inputText1" class="col-form-label"> Video Title </label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText4" type="text" name="video_link" value="{{ $links->video_link }}" class="form-control bg-light smalll" />
                            <label for="inputText4" class="col-form-label"> Video Upload </label>
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
@section('scripts') @endsection
