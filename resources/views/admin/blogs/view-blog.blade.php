@extends('layouts/admin')



@section('content')


<div class="right_col" role="main">


    <div class="clearfix"></div>

    @if (Session::has('message'))
      <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
             <?php
                      echo Session::get('message');
                    //    Session::flush();
                    //    Session::forget('message') ;
            ?>
      </div>
    @endif



    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>Only View Blog</h3>
            </div>

        </div>

        <div class="clearfix"></div>

     <form class="form px-sm-4" method="get" action="" enctype="multipart/form-data" >

        @csrf


        @foreach ($edit_view as $editdata)


            <div class="row">
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText1" type="text" name="blogtitle" class="form-control" value="{{ $editdata->t_title }}" readonly  />
                        <label for="inputText1" class="col-form-label">Blog Title</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText2" type="text" name="blogurl" class="form-control" value="{{ $editdata->t_slug }}"   readonly />
                        <label for="inputText2" class="col-form-label">Blog URL</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="metatitle" class="form-control" value="{{ $editdata->tag }}"   readonly />
                        <label for="inputText3" class="col-form-label">Meta Title</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="metadescription" value="{{ $editdata->metadesc }}" class="form-control"   readonly />
                        <label for="inputText4" class="col-form-label">Meta Description</label>
                    </div>
                </div>

                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="metatags" value="{{ $editdata->keywords }}" class="form-control"  readonly />
                        <label for="inputText5" class="col-form-label">Meta Tags</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText6" type="text" name="authorname" value="{{ $editdata->t_author }}" class="form-control" readonly />
                        <label for="inputText6" class="col-form-label">Author Name</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText7" type="text" name="tagclouds" value="{{ $editdata->tags_clouds }}" class="form-control"  readonly />
                        <label for="inputText7" class="col-form-label">Tag Clouds</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control bg-light small" id="editor1"  required="required" name="longdescription"  readonly> {{ $editdata->t_d_text }} </textarea>
                        <label for="editor1" class="col-form-label">Long Description</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        
                        <label for="inputText9" class="col-form-label">Image</label>
                        <img src="{{ url('images/blog/'. $editdata->t_featured_image ) }}" width="90px" alt="" class="img-fluid d-inline-block mt-2" />
                        
                    </div>
                </div>

                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText10" type="text" name="altname" value="{{ $editdata->alt }}" class="form-control"  readonly />
                        <label for="inputText10" class="col-form-label">alttag</label>
                    </div>
                </div>
            </div>

        @endforeach
     </form>



    </div>
</div>

@endsection


@section('scripts')



@endsection
