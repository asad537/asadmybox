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
                <h3>Update Your Blog</h3>
            </div>
        </div>

        <div class="clearfix"></div>
    @foreach ($edit_view as $editdata)
        <form class="form px-sm-4" method="post" action="{{ url('updateblog'.'/'. $editdata->t_id ).'/'}}" enctype="multipart/form-data" >
            @csrf

            <div class="row">
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText1" type="text" name="blogtitle" class="form-control" value="{{ $editdata->t_title }}"  />
                        <label for="inputText1" class="col-form-label">Blog Title</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText2" type="text" name="blogurl" class="form-control" value="{{ $editdata->t_slug }}"  />
                        <label for="inputText2" class="col-form-label">Blog URL</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="metatitle" class="form-control" value="{{ $editdata->tag }}"  />
                        <label for="inputText3" class="col-form-label">Meta Title</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="metadescription" value="{{ $editdata->metadesc }}" class="form-control" />
                        <label for="inputText4" class="col-form-label">Meta Description</label>
                    </div>
                </div>

                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="metatags" value="{{ $editdata->keywords }}" class="form-control" />
                        <label for="inputText5" class="col-form-label">Meta Tags</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText6" type="text" name="authorname" value="{{ $editdata->t_author }}" class="form-control" />
                        <label for="inputText6" class="col-form-label">Author Name</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText7" type="text" name="tagclouds" value="{{ $editdata->tags_clouds }}" class="form-control" />
                        <label for="inputText7" class="col-form-label">Tag Clouds</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control bg-light small" id="editor1"  required="required" name="longdescription"> {{ $editdata->t_d_text }} </textarea>
                        <label for="editor1" class="col-form-label">Long Description</label>
                    </div>
                </div>
                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText9" type="file" name="image" class="form-control" />
                        <label for="inputText9" class="col-form-label">Image</label>
                        <img src="{{ url('images/blog/'. $editdata->t_featured_image ) }}" width="90px" alt="" class="img-fluid d-inline-block mt-2" />
                        <input type="hidden" name="oldImage" value="{{ $editdata->t_featured_image }}" />
                    </div>
                </div>
                
          

                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText10" type="text" name="altname" value="{{ $editdata->alt }}" class="form-control" />
                        <label for="inputText10" class="col-form-label">alttag</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelect" class=""  style=" top: -29px; " > Related Blog </label>
                        <select id="multipleSelect" name="related_blogs[]" class="js-states form-control px-sm-4" multiple>
                            <option value="0" >--select a Blog--</option>

                           <?php

                              $relProd = json_decode($editdata->related_blogs);

                               if(!empty($all_blogs)){

                                    foreach ($all_blogs as $product_item) { ?>

                                     <option value="{{ $product_item->t_id }}"

                                           @if(!empty($relProd))
                                                @foreach ($relProd as $relprod_id)
                                                    {{ $product_item->t_id ==  $relprod_id ? "selected" : "" }}
                                                @endforeach
                                           @endif

                                          > {{ $product_item->t_title }}

                                    </option>


                           <?php  }  } ?>
                           
                           
           
                        </select>


                    </div>
                </div>


                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style ">
                        <button type="submit" class="btn btn-submit-view  px-sm-5">Update</button>
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
