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
                <h3>Add States</h3>
            </div>
        </div>
        <div class="clearfix"></div>


     <form class="form px-sm-4" method="post" action="{{ url('save-states').'/'}}" enctype="multipart/form-data" >
        @csrf
       
        <div class="row">
            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="states" class="form-control" required=" required" />
                    <label for="inputText1" class="col-form-label">Add States</label>
                </div>
            </div>  
              <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="code" class="form-control" />
                    <label for="inputText1" class="col-form-label">Add Code</label>
                </div>
            </div>  
            
             <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="lcode" class="form-control"  />
                    <label for="inputText1" class="col-form-label">Location Code</label>
                </div>
            </div>  
             <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="latitude" class="form-control"  />
                    <label for="inputText1" class="col-form-label">Latitude Code</label>
                </div>
            </div> 
             <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style">
                    <input id="inputText1" type="text" name="longitude" class="form-control"  />
                    <label for="inputText1" class="col-form-label">Longitude Code</label>
                </div>
            </div> 
            
                   <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor2" required="required" name="longdescription"></textarea>
                        <label for="editor2" class="col-form-label">State Description</label>
                    </div>
                </div>
                
                     <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                       <input id="inputText1" type="file" name="image" class="form-control"  />
                        <label for="editor2" class="col-form-label">State Banner</label>
                    </div>
                </div>
                
                
                
                <div  class="col-md-12 ">
                    <div class="form-group material-style">
                        <select class="form-control" id="parentcate" name="status">
                            <option value="1" > Active </option>
                            <option value="0" > Disable </option>
                        </select>
                        <label for="parentcate" class="col-form-label">Status</label>
    
                    </div>
                </div>


            <div  class="col-md-12 mb-sm-4">
                <div class="form-group material-style ">
                    <button type="submit" class="btn btn-submit-view  px-sm-5">Save</button>
                </div>
            </div>
        
     </form>
    </div>
</div>

@endsection

@section('scripts')

@endsection
