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
                <h3>Add Product</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <form class="form px-sm-4" method="post" action="{{ url('createproduct').'/' }}" enctype="multipart/form-data">

            @csrf

            <div class="row">
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText1" type="text" name="productname" class="form-control" required=" required" />
                        <label for="inputText1" class="col-form-label">Product Name</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText2" type="text" name="producturl" class="form-control" required="required" />
                        <label for="inputText2" class="col-form-label">Product URL</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="metatitle" class="form-control" />
                        <label for="inputText3" class="col-form-label">Meta Title</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="metadescription" class="form-control" />
                        <label for="inputText4" class="col-form-label">Meta Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="metatags" class="form-control" />
                        <label for="inputText5" class="col-form-label">Meta Tags</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor1" required="required" name="shortdescription"></textarea>
                        <label for="editor1" class="col-form-label">Short Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor2" required="required" name="longdescription"></textarea>
                        <label for="editor2" class="col-form-label">Long Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="image" class="form-control"  />
                        <label for="categoryimage" class="col-form-label"> Image </label>
                    </div>
                </div>
                <!--<div class="col-md-12 mb-sm-4">-->
                <!--    <div class="form-group material-style">-->
                <!--        <input id="categoryimage" type="file" name="hoverimage" class="form-control" required="required"  />-->
                <!--        <label for="categoryimage" class="col-form-label">Hover Image </label>-->
                <!--    </div>-->
                <!--</div>-->

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="altname" id="altname" class="form-control bg-light smalll" />
                        <label for="prod_altname" class="col-form-label">Altname</label>
                    </div>
                </div>

                <div class="col-md-6 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="number" step="0.01" min="0" max="5" name="rating_value" id="rating_value" class="form-control" value="4.9" />
                        <label for="rating_value" class="col-form-label">Rating Value (0-5) *</label>
                    </div>
                </div>

                <div class="col-md-6 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="number" min="0" name="review_count" id="review_count" class="form-control" value="312" />
                        <label for="review_count" class="col-form-label">Review Count *</label>
                    </div>
                </div>

                <div class="col-md-6 mb-sm-4">
                    <div class="form-group material-style">
                    <input type="number" step="any" min="0" name="low_price" id="low_price" class="form-control" value="0.7" />
                    <label for="low_price" class="col-form-label">Low Price (USD) *</label>
                    </div>
                </div>

                <div class="col-md-6 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="number" step="0.1" min="0" name="high_price" id="high_price" class="form-control" value="99" />
                        <label for="high_price" class="col-form-label">High Price (USD) *</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px">Feature Product</h6>
                        <label class="label-container col-form-label " style=" top: 37px;" >
                            <input type="checkbox" name="is_active_feature" value="1" /> One
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px">New Arrival</h6>
                        <label class="label-container col-form-label " style=" top: 37px;" >
                            <input type="checkbox" name="new_arrival" value="1" />
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px"> Best Seller </h6>
                        <label class="label-container col-form-label " style=" top: 37px;" >
                            <input type="checkbox" name="best_seller" value="1" />
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mb-sm-5">
                        <h6 class="col-form-label" style="font-weight: 600; font-size: 16px; color:#000000; margin-top:-25px"> Special Offer </h6>
                        <label class="label-container col-form-label " style=" top: 37px;" >
                            <input type="checkbox" name="special_offer" value="1" />
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style mt-2">
                        <input id="fileuploadbasic" type="file" name="images[]" class="form-control bg-light smalll" multiple  />
                        <label for="fileuploadbasic" class="col-form-label">Gallery</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelect" class=""  style=" top: -29px; " > Related Product </label>
                        <select id="multipleSelect" name="relatedProds[]" class="js-states form-control px-sm-4" multiple>
                            <option value="0" >--select a Category--</option>
                            @foreach ($all_products as $related_prod_items)
                            {{-- {{ $related_prod_items->id == $related_prod_items->prod_category  ? "selected" : "" }} --}}
                                 <option value="{{ $related_prod_items->id }}" >
                                    {{ $related_prod_items->prod_name }}
                                 </option>
                            @endforeach
                        </select>
                    </div>
                </div>




                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <select name="parentcate" id="prod_parent_cate" class="form-control px-sm-4">
                                    <option value="0" selected>-Select a product parent category--</option>
                                    @foreach ($all_categories as $item)
                                       <option value="{{ $item->id }}">{{ $item->cate_name }}</option>
                                    @endforeach
                             </select>
                        <label for="prod_parent_cate" class=""  style=" top: -29px; ">Product Parent Category</label>
                    </div>
                </div>

                
   
	      
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style center">
                        <button type="submit" name="btnsubmit" class="btn btn-submit-view px-sm-5">Save</button>
                    </div>
                </div>
                 
                
            </div>
        </form>
    
</div>

@endsection

@section('scripts')
 @endsection
