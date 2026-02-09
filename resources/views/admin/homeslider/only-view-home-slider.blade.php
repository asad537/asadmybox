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

        @foreach ($edit_slides as $singleData)



        <form class="form px-sm-4" method="post" action="{{ url('update-homeslider/'. $singleData->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="minititle" class="form-control" value="{{ $singleData->mini_title }}" readonly />
                        <label for="inputText3" class="col-form-label"> Mini Title </label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="bigtitle" class="form-control" value="{{ $singleData->big_title }}" readonly />
                        <label for="inputText3" class="col-form-label"> Big Title </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="sliderdesc" value="{{ $singleData->slider_description }}" class="form-control"  readonly />
                        <label for="inputText3" class="col-form-label"> Description </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <label for="inputText3" class="col-form-label"> Image </label>
                        <img src="{{ url('images/'. $singleData->slider_banner ) }}"  alt=""  class="d-block mt-sm-4" width="300px"  height="200px"  />
                        <input  type="hidden" name="oldbanner" value="{{ $singleData->slider_banner }}"  />
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="altname" value="{{ $singleData->slider_altname }}"  class="form-control" readonly />
                        <label for="inputText3" class="col-form-label"> alttag </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="button_link" value="{{ $singleData->button_link }}" class="form-control"  readonly />
                        <label for="inputText3" class="col-form-label"> Link </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="button_text" value="{{ $singleData->button_text }}" class="form-control"  readonly />
                        <label for="inputText3" class="col-form-label"> Button Text </label>
                    </div>
                </div>


            </div>
        </form>

        @endforeach
    </div>
</div>

@endsection
@section('scripts') @endsection
