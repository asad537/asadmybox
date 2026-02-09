@extends('layouts/admin')



@section('content')


<div class="right_col" role="main">


    <div class="clearfix"></div>

    @if (Session::has('message'))
        <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
             <?php
                      echo Session::get('message') ;
            ?>
      </div>
     @endif

     @if (Session::has('error'))
     <div class="alert alert-danger session-destroy mt-sm-4 mx-sm-4">
          <?php
                   echo Session::get('error');
         ?>
   </div>
  @endif



    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>Add Customer</h3>
            </div>

            {{-- <div class="title_right">
                <div class="col-md-5 col-sm-5  form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="clearfix"></div>


     <form class="form px-sm-4" method="post" action="{{ url('add-customer-process').'/' }}" enctype="multipart/form-data" >
        @csrf
       
        <div class="row">
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="customer_url" class="form-control" required=" required" />
                    <label for="inputText1" class="col-form-label">Customer URL</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="categoryimage" type="file" name="customer_image" class="form-control"    />
                    <label for="categoryimage" class="col-form-label"> Image </label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style ">
                    <button type="submit" class="btn btn-submit-view  px-sm-5">Save</button>
                </div>
            </div>
        </div>
     </form>
    </div>
</div>

@endsection

@section('scripts')

@endsection
