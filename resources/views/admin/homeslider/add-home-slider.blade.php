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
                <h3>Add Home Slider</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <form class="form px-sm-4" method="post" action="{{ url('/create-homeslider').'/' }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="minititle" class="form-control" required=" required" />
                        <label for="inputText3" class="col-form-label"> Mini Title </label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="bigtitle" class="form-control" required=" required" />
                        <label for="inputText3" class="col-form-label"> Big Title </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="sliderdesc" class="form-control"  />
                        <label for="inputText3" class="col-form-label"> Description </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="file" name="banner" class="form-control" required="required"  />
                        <label for="inputText3" class="col-form-label"> Image </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <label for="inputText3" class="col-form-label"> alttag </label>
                        <input id="inputText3" type="text" name="altname" class="form-control" />
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="button_link" class="form-control"  />
                        <label for="inputText3" class="col-form-label"> Link </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="button_text" class="form-control"  />
                        <label for="inputText3" class="col-form-label"> Button Text </label>
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
@section('scripts')

@endsection
