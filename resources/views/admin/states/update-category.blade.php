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
                //    echo Session::get('error');
         ?>
   </div>
  @endif



    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>States Category</h3>
            </div>

        </div>
        <div class="clearfix"></div>


        @foreach ($edit_states_category as $singleitem)



     <form class="form px-sm-4" method="post" action="{{ url('update-states-category'.'/'. $singleitem->id).'/'}}" enctype="multipart/form-data" >

        @csrf

        <div class="row">

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="name"  value="{{ $singleitem->cate_name }}" class="form-control" required=" required" />
                    <label for="inputText1" class="col-form-label">Name</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText2" type="text" name="url" value="{{ $singleitem->cate_url }}" class="form-control" required="required" />
                    <label for="inputText2" class="col-form-label">URL</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText3" type="text" name="meta_title" value="{{ $singleitem->meta_title }}" class="form-control" />
                    <label for="inputText3" class="col-form-label">Meta Title</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText4" type="text" name="meta_description" value="{{ $singleitem->meta_description}}" class="form-control" />
                    <label for="inputText4" class="col-form-label">Meta Description</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="meta_tags" value="{{ $singleitem->meta_tags }}" class="form-control" />
                    <label for="inputText5" class="col-form-label">Meta Tags</label>
                </div>
            </div>
            
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="sku" value="{{ $singleitem->sku }}" class="form-control" />
                    <label for="inputText5" class="col-form-label">SKU</label>
                </div>
            </div>
            
            <div  class="col-md-6 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="l_price" value="{{ $singleitem->l_price }}" class="form-control" />
                    <label for="inputText5" class="col-form-label">Low Price</label>
                </div>
            </div>
            
            <div  class="col-md-6 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="h_price" value="{{ $singleitem->h_price }}" class="form-control" />
                    <label for="inputText5" class="col-form-label">High Price</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="categoryimage" type="file" name="image"  value=""class="form-control" />
                    <label for="categoryimage" class="col-form-label"> Image </label>
                    <img src="{{ url('images/'.$singleitem->cate_image ) }}" alt="" class="img-fluid  d-inline-block mt-3" width="80px" />
                    <input  type="hidden" name="oldimage" value="{{ $singleitem->cate_image }} "   />
                </div>
            </div>
            

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <textarea class="form-control" id="editor1" required="required" name="longdescription"> {{ $singleitem->cate_long_desc }} </textarea>
                    <label for="editor1" class="col-form-label">Long Description</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
               

                <div class="form-group material-style">
                    <label for="multipleSelect" class=""  style=" top: -29px; " > Product </label>
                    <select id="multipleSelect" name="related_product[]" class="js-states form-control px-sm-4 " multiple>
                        <option value="0" >Select Default</option>

                         <?php $temp=json_decode($singleitem->state_products);

                        if(!empty($all_products)){ foreach ($all_products as $index){?>

                            <option value="<?php echo $index->id;  ?>"
                            
                                        <?php  if(!empty($temp)){foreach ($temp as $key => $keyvalue) {
                                            
                                            if($keyvalue==$index->id){echo"selected";}
                                            
                                        }} ?>>
                                <?php echo $index->prod_name; ?>

                                        </option>
                                    <?php } }?>

                    </select>
                     
                </div>
            </div>
            
               <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelectState" class=""  style=" top: -29px; " > States </label>
                        <select id="multipleSelectState" name="states[]" class="js-states form-control px-sm-4" multiple>
                               <?php $temp=json_decode($singleitem->state);

                        if(!empty($all_states)){ foreach ($all_states as $index){?>

                            <option value="<?php echo $index->id;  ?>"
                            
                                        <?php  if(!empty($temp)){foreach ($temp as $key => $keyvalue) {
                                            
                                            if($keyvalue==$index->id){echo"selected";}
                                            
                                        }} ?>>
                                <?php echo $index->states; ?>

                                        </option>
                                    <?php } }?>
                        </select>
                    </div>
                </div>
                
        <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4">
            <div class="form-group material-style">
                <label for="multipleSelectState_" class="" style="top: -29px;"> Related States </label>
                <select id="multipleSelectState_" name="relatedstate[]" class="js-states form-control px-sm-4" multiple>
                    <option value="0">--select a States--</option>
                    <?php
                     $relProd = json_decode($singleitem->relatedstate); if(!empty($all_states_)){ foreach ($all_states_ as $product_item) { ?>
                    <option value="{{ $product_item->id }}" 
                        @if(!empty($relProd)) @foreach ($relProd as $relprod_id) {{ $product_item->id == $relprod_id ? "selected" : "" }} @endforeach @endif >
                        {{ $product_item->cate_name }} 
                    </option>
                    <?php  }  } ?>
                </select>
            </div>
        </div>



            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style ">
                    <button type="submit" class="btn btn-submit-view  px-sm-5"> Update </button>
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
