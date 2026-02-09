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
                <h3>Update Product</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        @foreach ($edit_products as $editdata)
        <form class="form px-sm-4" method="post" action="{{ url('updateproduct'.'/'. $editdata->id).'/'}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText1" type="text" name="productname" class="form-control"  value="{{ $editdata->prod_name }}" />
                        <label for="inputText1" class="col-form-label">Product Name</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText2" type="text" name="producturl" class="form-control"  value="{{ $editdata->prod_url }}"  />
                        <label for="inputText2" class="col-form-label">Product URL</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="metatitle" class="form-control" value="{{ $editdata->meta_title }}"  />
                        <label for="inputText3" class="col-form-label">Meta Title</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="metadescription" class="form-control" value="{{ $editdata->meta_description}}" />
                        <label for="inputText4" class="col-form-label">Meta Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="metatags" class="form-control"  value="{{ $editdata->meta_tags }}" />
                        <label for="inputText5" class="col-form-label">Meta Tags</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor1" required="required" name="shortdescription">  {{ $editdata->prod_short_desc }}  </textarea>
                        <label for="editor1" class="col-form-label">Short Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor2" required="required" name="longdescription"> {{ $editdata->prod_long_desc }} </textarea>
                        <label for="editor2" class="col-form-label">Long Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="image" class="form-control" />
                        <label for="categoryimage" class="col-form-label"> Image </label>

                        <img src="{{url('images/'.$editdata->prod_image)}}" class="img-thumbnail img-fluid" width="100px" height="100px" alt="" />
                        <input  type="hidden" name="oldimage" value="{{ $editdata->prod_image }}"  />
                    </div>
                </div>

                             <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="altname" id="altname" class="form-control bg-light smalll"    value="{{ $editdata->prod_altname }}"  />
                        <label for="prod_altname" class="col-form-label">Altname</label>
                    </div>
                </div>

                <div class="col-md-6 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="number" step="0.1" min="0" max="5" name="rating_value" id="rating_value" class="form-control" value="{{ $editdata->rating_value ?? '4.9' }}" />
                        <label for="rating_value" class="col-form-label">Rating Value (0-5) *</label>
                    </div>
                </div>

                <div class="col-md-6 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="number" min="0" name="review_count" id="review_count" class="form-control" value="{{ $editdata->review_count ?? '312' }}" />
                        <label for="review_count" class="col-form-label">Review Count *</label>
                    </div>
                </div>

                <div class="col-md-6 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="number" step="0.01" min="0" name="low_price" id="low_price" class="form-control" value="{{ $editdata->low_price ?? '0.7' }}" />
                        <label for="low_price" class="col-form-label">Low Price (USD) *</label>
                    </div>
                </div>

                <div class="col-md-6 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="number" step="0.1" min="0" name="high_price" id="high_price" class="form-control" value="{{ $editdata->high_price ?? '99' }}" />
                        <label for="high_price" class="col-form-label">High Price (USD) *</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px">Feature Product</h6>
                        <label class="label-container col-form-label " style=" top: 37px;" >
                            <input type="checkbox" name="is_active_feature" value="1" {{  $editdata->feature_prod !=  0 ? "checked"   : "" }} /> One
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>


                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px">New Arrival</h6>
                        <label class="label-container col-form-label " style=" top: 37px;" >
                            <input type="checkbox" name="new_arrival" value="1" {{  $editdata->new_arrival ==  1  ?  "checked"   : "" }} />
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px">Best Seller</h6>
                        <label class="label-container col-form-label " style=" top: 37px;" >
                            <input type="checkbox" name="best_seller" value="1" {{  $editdata->best_seller ==  1 ? "checked"   : "" }} />
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px">Special Offer</h6>
                        <label class="label-container col-form-label " style=" top: 37px;" >
                            <input type="checkbox" name="special_offer" value="1" {{  $editdata->special_offer ==  1  ? "checked"   : "" }} />
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                {{-- {{  $editdata->special_offer !=  0  AND  $editdata->special_offer ==  NULL  ?  "checked"   : "" }} --}}

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mt-2">
                        <input id="fileuploadbasic" type="file" name="images[]" class="form-control bg-light smalll" multiple />
                        <label for="fileuploadbasic" class="col-form-label">Gallery</label>

                            <?php $images = json_decode($edit_products[0]->prod_gallery);
                                // echo "<pre>";
                                // print_r($images);
                                // die();

                            ?>

                            @if ( !empty($images) )
                                @foreach ($images as $singleImage)
                                    <img src="{{url('images/'.$singleImage)}}" class="img-thumbnail img-fluid mt-4" width="100px" height="100px" alt="" />
                                    <a href="{{url('del-gallery-image/'.$singleImage.'/'. $edit_products[0]->id)}}">
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
                        <select id="multipleSelect" name="relatedProds[]" class="js-states form-control px-sm-4" multiple>
                            <option value="0" >--select a Category--</option>

                           <?php

                              $relProd = json_decode($edit_products[0]->related_prod);


                               if(!empty($all_products)){

                                    foreach ($all_products as $product_item) { ?>

                                     <option value="{{ $product_item->id }}"

                                           @if(!empty($relProd))
                                                @foreach ($relProd as $relprod_id)
                                                    {{ $product_item->id ==  $relprod_id ? "selected" : "" }}
                                                @endforeach
                                           @endif

                                          > {{ $product_item->prod_name }}

                                    </option>


                           <?php  }  } ?>
                           
                           
           
                        </select>


                    </div>
                </div>




                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <select name="parentcate" id="prod_parent_cate" class="form-control px-sm-4">
                                    <option value="0" selected>-Select a product parent category--</option>
                                    @foreach ($all_categories as $item)
                                       <option value="{{ $item->id }}" {{ $item->id == $edit_products[0]->prod_category ? "selected" : "" }}>{{ $item->cate_name }}</option>
                                    @endforeach
                             </select>
                        <label for="prod_parent_cate" class=""  style=" top: -29px; ">Product Parent Category</label>
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
