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
                <h3>Update Category</h3>
            </div>

            {{-- <div class="title_right">
                <div class="col-md-5 col-sm-5  form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="clearfix"></div>


        @foreach ($edit_category as $singleitem)



     <form class="form px-sm-4" method="post" action="{{ url('updatecategory'.'/'. $singleitem->id).'/'}}" enctype="multipart/form-data" >

        @csrf

        <div class="row">

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="catename"  value="{{ $singleitem->cate_name }}" class="form-control" required=" required" />
                    <label for="inputText1" class="col-form-label">Category Name</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText2" type="text" name="cateurl" value="{{ $singleitem->cate_url }}" class="form-control" required="required" />
                    <label for="inputText2" class="col-form-label">Category URL</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText3" type="text" name="metatitle" value="{{ $singleitem->meta_title }}" class="form-control" />
                    <label for="inputText3" class="col-form-label">Meta Title</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText4" type="text" name="metadescription" value="{{ $singleitem->meta_description}}" class="form-control" />
                    <label for="inputText4" class="col-form-label">Meta Description</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText5" type="text" name="metatags" value="{{ $singleitem->meta_tags }}" class="form-control" />
                    <label for="inputText5" class="col-form-label">Meta Tags</label>
                </div>
            </div>



            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <textarea class="form-control" id="editor1" required="required" name="longdescription"> {{ $singleitem->cate_long_desc }} </textarea>
                    <label for="editor1" class="col-form-label">Long Description</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                {{-- <div class="form-group material-style">
                    <select class="form-control" id="parentcate" name="parentcate">
                        <option value="0"  Selected >--select a Category--</option>
                        <option value="1" > Category 1 </option>
                        <option value="2" > Category 2 </option>
                    </select>
                    <label for="parentcate" class="col-form-label">Parent Category</label>

                </div> --}}

                <div class="form-group material-style">
                    <select  name="parentcate" class=" form-control px-sm-4 ">
                        <option value="0" >Select Default</option>

                        @foreach ($all_categories as $subitem)
                              <option value="{{ $subitem->id }}" {{ $subitem->id == $singleitem->parent_cate  ? "selected" : "" }} > {{ $subitem->cate_name }} </option>
                        @endforeach

                    </select>
                    <label for="multipleSelect" class="">Parent Category</label>
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


            <!--<div  class="col-md-12 mb-sm-4">-->
            <!--    <div class="form-group material-style">-->
            <!--        <input id="hoverimage" type="file" name="hoverimage" value="" class="form-control" />-->
            <!--        <label for="hoverimage" class="col-form-label"> Hover Image </label>-->

            <!--        <img src="{{ url('images/'.$singleitem->cate_overlay_image ) }}" alt="" class="img-fluid  d-inline-block mt-3" width="80px" />-->
            <!--        <input  type="hidden" name="old_overlayimage" value="{{ $singleitem->cate_overlay_image }}"   />-->
            <!--    </div>-->
            <!--</div>-->

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="categorybanner" type="file" name="catebanner" value="" class="form-control" />
                    <label for="categorybanner" class="col-form-label"> Banner </label>
                    <img src="{{ url('images/'.$singleitem->cate_banner ) }}" alt="" class="img-fluid  d-inline-block mt-3" width="80px" />

                    <input  type="hidden" name="oldbanner2" value="{{ $singleitem->cate_banner }}"  />
                </div>
            </div>

            <div class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="show_on_home" value="1" {{ $singleitem->show_on_home == 1 ? 'checked' : '' }}> Show on Home Page
                        </label>
                    </div>
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
