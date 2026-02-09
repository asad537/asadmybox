@extends('layouts/admin')



@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>


    @if (Session::has('message'))
            <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
                <?php echo Session::get('message'); ?>
            </div>
    @endif


    @if (Session::has('error'))
        <div class="alert alert-danger session-destroy mt-sm-4 mx-sm-4">
            <?php echo Session::get('error'); ?>
        </div>
    @endif

    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3> Update Page</h3>
            </div>
        </div>
        <div class="clearfix"></div>



        @foreach ($edit_products as $edit_prod_item)
     
   


        <form class="form px-sm-4" method="post" action="{{ url('update_ppc_page'.'/'. $edit_prod_item->id).'/'}}" enctype="multipart/form-data">

            @csrf

            <div class="row">
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText1" type="text" name="productname" class="form-control" value="{{$edit_prod_item->prod_name}}" />
                        <label for="inputText1" class="col-form-label">Product Name</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText2" type="text" name="producturl" class="form-control"  value="{{$edit_prod_item->prod_url}}" />
                        <label for="inputText2" class="col-form-label">Product URL</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="metatitle" class="form-control"  value="{{$edit_prod_item->meta_title}}"/>
                        <label for="inputText3" class="col-form-label">Meta Title</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="metadescription" class="form-control" value="{{$edit_prod_item->meta_description}}" />
                        <label for="inputText4" class="col-form-label">Meta Description</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="metatags" class="form-control" value="{{$edit_prod_item->meta_tags}}" />
                        <label for="inputText5" class="col-form-label">Meta Tags</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor1" name="shortdescription">{{$edit_prod_item->prod_short_desc}}</textarea>
                        <label for="editor1" class="col-form-label">Short Description</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="image" class="form-control"  />
                        <label for="categoryimage" class="col-form-label">Main  Image </label>

                        <img src="{{ url('images/'. $edit_prod_item->prod_image) }}"  name="image" alt=""  class=" mx-auto" style="object-fit: fill"  width="90px" height="70px" > 
                        <input  type="hidden" name="prod_image" value="{{ $edit_prod_item->prod_image }}"  />
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="main_altname" id="altname" class="form-control bg-light smalll" value="{{$edit_prod_item->main_altname}}" />
                        <label for="prod_altname" class="col-form-label">Main Image Altname</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor2"  name="content_1" >{{$edit_prod_item->content_1}}</textarea>
                        <label for="editor2" class="col-form-label">Content 1</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="image1" class="form-control" />
                        <label for="categoryimage" class="col-form-label">Content 1- Image </label>

                        <img src="{{ url('images/'. $edit_prod_item->content_image_1) }}" alt=""  class=" mx-auto" style="object-fit: fill"  width="90px" height="70px" > 
                        <input  type="hidden" name="content_image_1" value="{{ $edit_prod_item->content_image_1 }}"  />

                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="content_1_altname" id="altname" class="form-control bg-light smalll" value="{{$edit_prod_item->content_1_altname}}" />
                        <label for="prod_altname" class="col-form-label">Content 1 Image Altname</label>

                    
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor11"  name="content_2">{{$edit_prod_item->content_2}}</textarea>
                        <label for="editor2" class="col-form-label">Content 2</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="image2" class="form-control" />
                        <label for="categoryimage" class="col-form-label">Content 2- Image </label>
                        <img src="{{ url('images/'. $edit_prod_item->content_image_2) }}" alt=""  class=" mx-auto" style="object-fit: fill"  width="90px" height="70px" > 
                        <input  type="hidden" name="content_image_2" value="{{ $edit_prod_item->content_image_2 }}"  />

                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="content_2_altname" id="altname" class="form-control bg-light smalll"  value="{{$edit_prod_item->content_2_altname}}"/>
                        <label for="prod_altname" class="col-form-label">Content 2 Image Altname</label>
                    </div>
                </div>

              
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="sample_image" class="form-control"  />
                        <label for="categoryimage" class="col-form-label">Sample Image </label>

                        <img src="{{ url('images/'. $edit_prod_item->sample_image) }}"  name="sample_image" alt=""  class=" mx-auto" style="object-fit: fill"  width="90px" height="70px" > 
                        <input  type="hidden" name="sample_image" value="{{ $edit_prod_item->sample_image }}"  />
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="sample_alt_name" id="altname" class="form-control bg-light smalll" value="{{$edit_prod_item->sample_alt_name}}" />
                        <label for="prod_altname" class="col-form-label">Sample Image Altname</label>
                    </div>
                </div>


                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelect" class=""  style=" top: -29px; " > Related Product </label>

                        <select id="multipleSelect" name="relatedProd[]" class="js-states form-control px-sm-4" multiple>
                            <option value="0" > -- select a other Product --</option>
                            <?php
                                $relatedProd = json_decode($edit_prod_item->related_prod);
                                if(!empty($all_otherproducts)){

                                    foreach ($all_otherproducts as $single_otherprod) { ?>
                                     <option value={{ $single_otherprod->id }}

                                      @if(!empty($relatedProd))  @foreach ($relatedProd as $perItem) {{  $single_otherprod->id == $perItem  ? "selected" : "" }}  @endforeach @endif>

                                         {{ $single_otherprod->prod_name }}
                                      </option>

                            <?php  } }  ?>
                      </select>

                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <button type="submit" class="btn btn-submit-view px-sm-5">Save</button>
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
