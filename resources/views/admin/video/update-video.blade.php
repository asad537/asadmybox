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
                <h3>Update Home Slider</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        @foreach ($edit_slides as $singleitem)


            <form class="form px-sm-4" method="post" action="{{ url('update-testimonial'.'/'.$singleitem->id ).'/'}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText1" type="text" name="client_name" class="form-control bg-light smalll"  value="{{ $singleitem->main_title }}"  />
                            <label for="inputText1" class="col-form-label"> Client Name </label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText2" type="text" name="designation" class="form-control bg-light smalll"  value="{{ $singleitem->designation }}" />
                            <label for="inputText2" class="col-form-label"> Desgination</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText3" type="text" name="slider_info" class="form-control bg-light smalll"  value="{{ $singleitem->slider_description }}"  />
                            <label for="inputText3" class="col-form-label"> Description</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText4" type="file" name="image" class="form-control bg-light smalll" />
                            <label for="inputText4" class="col-form-label"> Image</label>
                            <img src="{{ asset('images/'.$singleitem->slider_image ) }}"  class="d-block my-3" alt="" />
                            <input  type="hidden" name="oldimage" value="{{ $singleitem->slider_image }}"  />
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
