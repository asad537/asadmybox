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
                <h3>Add Testimonial </h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <form class="form px-sm-4" method="post" action="{{ url('/create-testimonial').'/' }}" enctype="multipart/form-data">
            @csrf
            <div class="row">


                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText1" type="text" name="client_name" class="form-control bg-light smalll" required=" required" />
                        <label for="inputText1" class="col-form-label"> Client Name </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText2" type="text" name="designation" class="form-control bg-light smalll"  />
                        <label for="inputText2" class="col-form-label"> Desgination</label>
                    </div>
                </div>

             <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="p_url" class="form-control bg-light smalll"  />
                        <label for="inputText3" class="col-form-label"> Profile URL</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="slider_info" class="form-control bg-light smalll"  />
                        <label for="inputText3" class="col-form-label"> Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="file" name="image" class="form-control bg-light smalll" />
                        <label for="inputText4" class="col-form-label"> Image</label>
                    </div>
                </div>

          
                
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <select name="star" id="star_pos" class="form-control px-sm-4">
                              <option value="0" selected=""> -Select Stars</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                        </select>
                        <label for="star_pos" class="col-form-label" style=" top: -29px; "> Star </label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <button type="submit" class="btn btn-submit-view px-sm-5"> Save </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts') @endsection
