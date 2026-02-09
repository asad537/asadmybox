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
                <h3>Only View Product</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        @foreach ($edit_products as $editdata)
        

        <form class="form px-sm-4" method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText1" type="text" name="productname" class="form-control"  value="{{ $editdata->prod_name }}"  readonly/>
                        <label for="inputText1" class="col-form-label">Product Name</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText2" type="text" name="producturl" class="form-control"  value="{{ $editdata->prod_url }}"  readonly />
                        <label for="inputText2" class="col-form-label">Product URL</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="metatitle" class="form-control" value="{{ $editdata->meta_title }}"   readonly/>
                        <label for="inputText3" class="col-form-label">Meta Title</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="metadescription" class="form-control" value="{{ $editdata->meta_description}}" readonly />
                        <label for="inputText4" class="col-form-label">Meta Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="metatags" class="form-control"  value="{{ $editdata->meta_tags }}" readonly />
                        <label for="inputText5" class="col-form-label">Meta Tags</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor1" required="required" name="shortdescription" readonly>  {{ $editdata->prod_short_desc }}  </textarea>
                        <label for="editor1" class="col-form-label">Short Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor2" required="required" name="longdescription" readonly > {{ $editdata->prod_long_desc }} </textarea>
                        <label for="editor2" class="col-form-label">Long Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        
                        <label for="categoryimage" class="col-form-label"> Image </label>
                        <img src="{{ url('images/'.$editdata->prod_image ) }}" alt="" class="img-fluid  d-inline-block mt-3" width="80px" />

                        <input  type="hidden" name="oldimage" value="{{  $editdata->prod_image }}"  />
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="altname" id="altname" class="form-control bg-light smalll"  readonly  value="{{ $editdata->prod_altname }}"  />
                        <label for="prod_altname" class="col-form-label">Altname</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px"  readonly>Feature Product</h6>
                        <label class="label-container col-form-label " style=" top: 37px;    pointer-events: none;"  >
                            <input style="pointer-events: none;"  type="checkbox" name="is_active_feature" value="1" {{ $editdata->feature_prod !=  0 ? 'checked' : '' }}   />

                            One
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mt-2">
                        {{-- <input id="fileuploadbasic" type="file" name="images[]" class="form-control bg-light smalll" multiple /> --}}
                        <label for="fileuploadbasic" class="col-form-label" style="pointer-events: none;">Gallery</label>

                                <?php
                                $images = json_decode($editdata->prod_gallery);
                                   
                                if(!empty($images)){
                                   foreach ($images as $image) {?>

                                    <img src="{{url('images/'.$image)}}" class="img-thumbnail img-fluid" width="100px" height="100px" alt="" />


                             <?php } }   ?>

                             <input  type="hidden" name="oldgallery" value="{{  $editdata->prod_gallery }}" />



                    </div>
                </div>

                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelect" class=""  style=" top: -29px; " style="pointer-events: none;" > Related Product </label>
                        <select id="multipleSelect" name="relatedProds[]" class="js-states form-control px-sm-4" multiple readonly   style="pointer-events: none;">
                            <option value="0" >--select a Category--</option>

                           <?php

                              $relProd = json_decode($edit_products[0]->related_prod);


                               if(!empty($relProd)){

                                    foreach ($all_products as $product_item) { ?>

                                     <option  style="pointer-events: none;" value="{{ $product_item->id }}"

                                            @foreach ($relProd as $index)
                                                {{ $product_item->id ==  $index ? "selected" : "" }}
                                            @endforeach>

                                         {{ $product_item->prod_name }}

                                    </option>


                           <?php  }  } ?>
                        </select>
                    </div>
                </div>




                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <select name="parentcate" id="prod_parent_cate" class="form-control px-sm-4" readonly>
                                    <option value="0" selected>-Select a product parent category--</option>
                                    @foreach ($all_categories as $item)
                                       <option value="{{ $item->id }}" {{ $item->id == $edit_products[0]->prod_category ? "selected" : "" }}>{{ $item->cate_name }}</option>
                                    @endforeach
                             </select>
                        <label for="prod_parent_cate" class=""  style=" top: -29px; ">Product Parent Category</label>
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
