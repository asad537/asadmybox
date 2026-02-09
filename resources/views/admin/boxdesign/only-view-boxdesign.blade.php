@extends('layouts/admin')

@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>

    @if (Session::has('message'))
            <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
                <?php   echo Session::get('message');  ?>
            </div>
    @endif

    @if (Session::has('error'))
            <div class="alert alert-danger session-destroy mt-sm-4 mx-sm-4">
                <?php   echo Session::get('error');  ?>
            </div>
    @endif

    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>Update Box Design</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        @foreach ($edit_boxes as $edit_item)


            <form class="form px-sm-4" method="post" action="{{ url('/update-boxdesign'."/".$edit_item->id ) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText1" type="text" name="box_name"  value="{{  $edit_item->box_name }}" class="form-control bg-light smalll" readonly />
                            <label for="inputText1" class="col-form-label"> Box Name </label>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <textarea class="form-control" id="editor1"  readonly name="box_desc" > {{ $edit_item->box_desc }} </textarea>
                            <label for="editor1" class="col-form-label">Description</label>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText2" type="text" name="box_link" value="{{  $edit_item->box_link }}" class="form-control bg-light smalll"  readonly  />
                            <label for="inputText2" class="col-form-label"> Box Link </label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
    
                            <label for="inputText4" class="col-form-label"> Image</label>
                            <img src="{{asset('images/'.$edit_item->box_image )}}"  alt=""  class="img-fluid"/>
                            <input  type="hidden" name="oldimage" value="{{  $edit_item->box_image }}" />
                        </div>
                    </div>
                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <select name="box_position" id="box_position" class="form-control px-sm-4"  readonly disabled>
                                <option value="0" selected=""> -Select a Appearance</option>

                                @if( $edit_item->box_position == 1)
                                    <option value="1" selected>Appearance 1</option>
                                    @elseif( $edit_item->box_position == 2)
                                    <option value="2" selected>Appearance 2 </option>
                                    @elseif( $edit_item->box_position == 3)
                                    <option value="3" selected>Appearance 3 </option>
                                    @elseif( $edit_item->box_position == 4)
                                    <option value="4" selected>Appearance 4 </option>
                                    @elseif ($edit_item->box_position == 5)
                                        <option value="5" selected>Appearance 5 </option>
                                    @else
                                       
                                @endif

                               
                               
                                <option value="3">Appearance 3 </option>
                                <option value="4">Appearance  4 </option>
                                <option value="5">Appearance  5</option>
                            </select>
                            <label for="box_position" class="" style=" top: -29px; ">Boxes positions</label>
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



