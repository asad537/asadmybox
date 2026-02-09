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

  <!--   @if (Session::has('error'))-->
  <!--   <div class="alert alert-danger session-destroy mt-sm-4 mx-sm-4">-->
        
  <!-- </div>-->
  <!--@endif-->



    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>Add Home Content </h3>
            </div>
        </div>
        <div class="clearfix"></div>

       @foreach ($content as $info)
         <form class="form px-sm-4" method="post" action="{{ url('create-home-content').'/'}}" enctype="multipart/form-data" >
          
            @csrf
           
            <div class="row">
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="meta_description" value="{{$info->meta_description}}" class="form-control bg-light smalll"  />
                        <label for="inputText3" class="col-form-label">Meta  Description</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="meta_title"  value="{{$info->meta_title}}" class="form-control bg-light smalll" required=" required" />
                        <label for="inputText4" class="col-form-label"> Meta Title </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="meta_tags" value="{{$info->meta_tags}}" class="form-control bg-light smalll"  />
                        <label for="inputText5" class="col-form-label"> Meta tags</label>
                    </div>
                </div>
    
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor1" required="required"   name="longdescription">{{$info->home_content}}</textarea>
                        <label for="editor1" class="col-form-label">Home Content</label>
                    </div>
                </div>
              
               
    
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style ">
                        <button type="submit" class="btn btn-submit-view  px-sm-5">Save</button>
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
