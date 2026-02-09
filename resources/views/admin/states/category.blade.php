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
                <h3>State Category</h3>
            </div>
        </div>
        <div class="clearfix"></div>


     <form class="form px-sm-4" method="post" action="{{ url('save-states-category').'/'}}" enctype="multipart/form-data" >
        @csrf
       
        <div class="row">
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="name" class="form-control" required=" required" />
                    <label for="inputText1" class="col-form-label">Name</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText2" type="text" name="url" class="form-control" required="required" />
                    <label for="inputText2" class="col-form-label">URL</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText3" type="text" name="meta_title" class="form-control" />
                    <label for="inputText3" class="col-form-label">Meta Title</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText4" type="text" name="meta_description" class="form-control" />
                    <label for="inputText4" class="col-form-label">Meta Description</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="meta_tags" class="form-control" />
                    <label for="inputText5" class="col-form-label">Meta Tags</label>
                </div>
            </div>
            
              <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="sku" class="form-control" />
                    <label for="inputText5" class="col-form-label">SKU</label>
                </div>
            </div>
            
            <div  class="col-md-6 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="l_price" class="form-control" />
                    <label for="inputText5" class="col-form-label">Low Price</label>
                </div>
            </div>
            
            <div  class="col-md-6 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="h_price" class="form-control" />
                    <label for="inputText5" class="col-form-label">High Price</label>
                </div>
            </div>

                 <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="image" class="form-control"    />
                        <label for="categoryimage" class="col-form-label"> Image </label>
                    </div>
                </div>

                <div  class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor1" required="required" name="longdescription"></textarea>
                        <label for="editor1" class="col-form-label">Long Description</label>
                    </div>
                </div>
                
                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelect" class=""  style=" top: -29px; " > Product </label>
                        <select id="multipleSelect" name="related_product[]" class="js-states form-control px-sm-4" multiple>
                                @foreach ($all_product as $item)
                                     <option selected="selected" value="{{ $item->id }}" > {{ $item->prod_name }} </option>
                                @endforeach
                        </select>
                    </div>
                </div>
           
                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelectState" class=""  style=" top: -29px; " > States </label>
                        <select id="multipleSelectState" name="states[]" class="js-states form-control px-sm-4" multiple>
                                @foreach ($all_states as $item)
                                     <option value="{{ $item->id }}" > {{ $item->states }} </option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <!--Related Product-->
                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4">
                    <div class="form-group material-style">
                        <label for="multipleSelectState_" class="" style="top: -29px;"> Related States </label>
                        <select id="multipleSelectState_" name="relatedstate[]" class="js-states form-control px-sm-4" multiple>
                            <option value="0">--select a State--</option>
                            @foreach ($all_states_ as $State)
                            <option value="{{ $State->id }}">
                                {{ $State->cate_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--Related Product End-->
                
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
