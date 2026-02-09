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
                <h3>Add Category</h3>
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


     <form class="form px-sm-4" method="post" action="{{ url('createcategory').'/'}}" enctype="multipart/form-data" >
        @csrf
       
        <div class="row">
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="catename" class="form-control" required=" required" />
                    <label for="inputText1" class="col-form-label">Category Name</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText2" type="text" name="cateurl" class="form-control" required="required" />
                    <label for="inputText2" class="col-form-label">Category URL</label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText3" type="text" name="metatitle" class="form-control" />
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
                    <textarea class="form-control" id="editor1" required="required" name="longdescription"></textarea>
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
                     <option value="0"   Selected>--select a Category--</option>
                        @foreach ($all_categories as $item)
                             <option value="{{ $item->id }}" > {{ $item->cate_name }} </option>
                        @endforeach
                    </select>


                    <label for="multipleSelect" class="">Parent Category</label>
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
                    <input id="hoverimage" type="file" name="hoverimage" class="form-control" />
                    <label for="hoverimage" class="col-form-label"> Hover Image </label>
                </div>
            </div>

            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="categorybanner" type="file" name="catebanner" class="form-control" />
                    <label for="categorybanner" class="col-form-label"> Banner </label>
                </div>
            </div>

            <div class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="show_on_home" value="1"> Show on Home Page
                        </label>
                    </div>
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
