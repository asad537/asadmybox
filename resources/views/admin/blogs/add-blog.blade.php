@extends('layouts/admin')



@section('content')


<div class="right_col" role="main">


    <div class="clearfix"></div>

    @if (Session::has('message'))
      <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
             <?php
                      echo Session::get('message');
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
                <h3>Add Blogs</h3>
            </div>
        </div>
        <div class="clearfix"></div>
       

     <form class="form px-sm-4" method="post" action="{{ url('/createblog').'/' }}" enctype="multipart/form-data" >

        @csrf

        <div class="row">
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="blogtitle" class="form-control" required=" required" />
                    <label for="inputText1" class="col-form-label">Blog Title</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText2" type="text" name="blogurl" class="form-control" required="required" />
                    <label for="inputText2" class="col-form-label">Blog URL</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText3" type="text" name="metatitle" class="form-control" required="required" />
                    <label for="inputText3" class="col-form-label">Meta Title</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText4" type="text" name="metadescription" class="form-control" />
                    <label for="inputText4" class="col-form-label">Meta Description</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="metatags" class="form-control" />
                    <label for="inputText5" class="col-form-label">Meta Tags</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText6" type="text" name="authorname" class="form-control" />
                    <label for="inputText6" class="col-form-label">Author Name</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText7" type="text" name="tagclouds" class="form-control" />
                    <label for="inputText7" class="col-form-label">Tag Clouds</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <textarea class="form-control bg-light small" id="editor1" required="required" name="longdescription"></textarea>
                    <label for="editor1" class="col-form-label">Long Description</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText9" type="file" name="image" class="form-control"  required="required" />
                    <label for="inputText9" class="col-form-label">Image</label>
                </div>
            </div>
            
             <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText9" type="file" name="home_image" class="form-control" />
                    <label for="inputText9" class="col-form-label">Home Image (use image (w225 x 135h))</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText10" type="text" name="altname" class="form-control" />
                    <label for="inputText10" class="col-form-label">alttag</label>
                </div>
            </div>
            
            <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelect" class=""  style=" top: -29px; " > Related Blog </label>
                        <select id="multipleSelect" name="related_blogs[]" class="js-states form-control px-sm-4" multiple>
                            <option value="0" >--select a Blogs--</option>
                            @foreach ($all_blogs as $related_prod_items)
                                 <option value="{{ $related_prod_items->t_id }}" >
                                    {{ $related_prod_items->t_title }}
                                 </option>
                            @endforeach
                        </select>
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
