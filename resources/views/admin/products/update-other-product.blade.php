@extends('layouts/admin')



@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>


    @if (Session::has('message'))
            <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
                <?php echo Session::get('message'); ?>
            </div>
    @endif


    @if (Session::has('error'))
        <div class="alert alert-danger session-destroy mt-sm-4 mx-sm-4">
            <?php echo Session::get('error'); ?>
        </div>
    @endif

    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3> Update Other Product</h3>
            </div>
        </div>
        <div class="clearfix"></div>



        @foreach ($edit_products as $edit_prod_item)
     
   


        <form class="form px-sm-4" method="post" action="{{ url('update-otherproduct'.'/'. $edit_prod_item->id).'/'}}" enctype="multipart/form-data">

            @csrf

            <div class="row">
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText1" type="text" name="productname" class="form-control" value="{{ $edit_prod_item->prod_name }}" required=" required" />
                        <label for="inputText1" class="col-form-label">Product Name</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText2" type="text" name="producturl" value="{{ $edit_prod_item->prod_url }}" class="form-control"  />
                        <label for="inputText2" class="col-form-label">Product URL</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="metatitle" value="{{ $edit_prod_item->meta_title }}" class="form-control" />
                        <label for="inputText3" class="col-form-label">Meta Title</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="metadescription" value="{{ $edit_prod_item->meta_description }}"  class="form-control" />
                        <label for="inputText4" class="col-form-label">Meta Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="metatags" value="{{ $edit_prod_item->meta_tags }}" class="form-control" />
                        <label for="inputText5" class="col-form-label">Meta Tags</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor1" required="required" name="shortdescription">{{ $edit_prod_item->prod_short_desc }}</textarea>
                        <label for="editor1" class="col-form-label">Short Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor2" required="required" name="longdescription"> {{ $edit_prod_item->prod_long_desc }} </textarea>
                        <label for="editor2" class="col-form-label">Long Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">

                        <input id="categoryimage" type="file" name="image" class="form-control" />
                        <label for="categoryimage" class="col-form-label"> Image </label>

                        <img src="{{ url('images/' . $edit_prod_item->prod_image ) }}" alt=""  class="img-fluid mt-sm-4 d-inline-block img-thumbnail"  width="60px"  height="60px"  />
                        <input type="hidden" name="oldimage" id="altname"  value="{{ $edit_prod_item->prod_image }}"  />

                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="altname" id="altname"  value="{{ $edit_prod_item->prod_altname }}" class="form-control bg-light smalll" />
                        <label for="prod_altname" class="col-form-label" >Altname</label>
                    </div>
                </div>


                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mt-2">
                        <input id="fileuploadbasic" type="file" name="images[]" class="form-control bg-light smalll" multiple />
                        <label for="fileuploadbasic" class="col-form-label">Gallery</label>

                      
<?php $images = json_decode($edit_prod_item->prod_gallery);
                                // echo "<pre>";
                                // print_r($images);
                                // die();

                            ?>

                            @if ( !empty($images) )
                                @foreach ($images as $singleImage)
                                    <img src="{{url('images/'.$singleImage)}}" class="img-thumbnail img-fluid mt-4" width="100px" height="100px" alt="" />
                                    <a href="{{url('del-otherprod-image/'.$singleImage.'/'. $edit_prod_item->id)}}">
                                        <button type="button" class="btn btn-danger" >Delete</button>
                                    </a>
                                    <input  type="hidden" name="oldgallery[]" value="{{ $singleImage }}" />
                                @endforeach
                            @endif
                            

                    </div>
                </div>

                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">

                        <label for="multipleSelect" class=""  style=" top: -29px; " > Related Product </label>
                        <select id="multipleSelect" name="relatedProd[]" class="js-states form-control px-sm-4" multiple>
                            <option value="0" > -- select a other Product --</option>
                            <?php
                                $relatedProd = json_decode($edit_prod_item->related_prod);
                                if(!empty($all_otherproducts)){

                                    foreach ($all_otherproducts as $single_otherprod) { ?>
                                     <option value={{ $single_otherprod->id }}

                                      @if(!empty($relatedProd))  @foreach ($relatedProd as $perItem) {{  $single_otherprod->id == $perItem  ? "selected" : "" }}  @endforeach @endif>

                                         {{ $single_otherprod->prod_name }}
                                      </option>

                            <?php  } }  ?>
                      </select>
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
