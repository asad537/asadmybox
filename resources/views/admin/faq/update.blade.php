@extends('layouts/admin')
@section('content')
<div class="right_col" role="main">
    <div class="clearfix"></div>
    @if (Session::has('message'))
        <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
             <?php echo Session::get('message') ; ?>
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
                <h3>Add Product FAQ's</h3>
            </div>
        </div>
        <div class="clearfix"></div>


     <form class="form px-sm-4" method="post" action="{{ url('update-product-faq-data'.'/'. $edit_view[0]->id).'/'}}" enctype="multipart/form-data" >
        @csrf
       
        <div class="row">
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="question" value="{{$edit_view[0]->question}}" class="form-control" required=" required" />
                    <label for="inputText1" class="col-form-label">Add Question</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <textarea class="form-control" id="editor1" required="required" name="answer">
                        <?php echo $edit_view[0]->answer?>
                    </textarea>
                    <label for="editor1" class="col-form-label">Add Answer</label>
                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <select class="form-control" id="parentcate" name="printing_product_name">
                        <option value="0"  Selected >--select a Printing Product--</option>
                        @foreach($printing_product as $all_printing_product)
                           <option value="{{$all_printing_product->id}}" <?php if($all_printing_product->id == $edit_view[0]->printing_product_name){echo "selected";} ?>> {{$all_printing_product->prod_name}} </option>
                        @endforeach
                    </select>
                    <label for="parentcate" class="col-form-label">Select Printing Product</label>

                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <select class="form-control" id="parentcate" name="product_name">
                        <option value="0"  Selected >--select a Product--</option>
                        @foreach($product as $all_product)
                           <option value="{{$all_product->id}}" <?php if($all_product->id == $edit_view[0]->product_name){echo "selected";} ?>> {{$all_product->prod_name}} </option>
                        @endforeach
                    </select>
                    <label for="parentcate" class="col-form-label">Select Product</label>

                </div>
            </div>
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <select class="form-control" id="parentcate" name="category_name">
                        <option value="0"  Selected >--select a Category--</option>
                        @foreach($category as $all_category)
                           <option value="{{$all_category->id}}" <?php if($all_category->id == $edit_view[0]->category_name){echo "selected";} ?>> {{$all_category->cate_name}} </option>
                        @endforeach
                    </select>
                    <label for="parentcate" class="col-form-label">Select Category</label>

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
