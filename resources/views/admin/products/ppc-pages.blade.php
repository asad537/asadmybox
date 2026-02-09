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
                <h3>Add New Page For The PPC</h3>
            </div>
        </div>
        <div class="clearfix"></div>




        <form class="form px-sm-4" method="post" action="{{ url('create_ppc_page').'/'}}" enctype="multipart/form-data">

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
                        <input id="inputText2" type="text" name="producturl" class="form-control"  />
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
                        <input id="categoryimage" type="file" name="image" class="form-control"  />
                        <label for="categoryimage" class="col-form-label">Main  Image </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="main_altname" id="altname" class="form-control bg-light smalll" />
                        <label for="prod_altname" class="col-form-label">Main Image Altname</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor2" required="required" name="content_1"></textarea>
                        <label for="editor2" class="col-form-label">Content 1</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="image1" class="form-control"  />
                        <label for="categoryimage" class="col-form-label">Content 1- Image </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="content_1_altname" id="altname" class="form-control bg-light smalll" />
                        <label for="prod_altname" class="col-form-label">Content 1 Image Altname</label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <textarea class="form-control" id="editor11" required="required" name="content_2"></textarea>
                        <label for="editor2" class="col-form-label">Content 2</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="image2" class="form-control"  />
                        <label for="categoryimage" class="col-form-label">Content 2- Image </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="content_2_altname" id="altname" class="form-control bg-light smalll" />
                        <label for="prod_altname" class="col-form-label">Content 2 Image Altname</label>
                    </div>
                </div>

              
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="categoryimage" type="file" name="sample_image" class="form-control"  />
                        <label for="categoryimage" class="col-form-label">Sample Image </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input type="text" name="sample_alt_name" id="altname" class="form-control bg-light smalll" />
                        <label for="prod_altname" class="col-form-label">Sample Image Altname</label>
                    </div>
                </div>


                <div class="col-md-12 mb-sm-4 mt-sm-3 mb-sm-4 ">
                    <div class="form-group material-style">
                        <label for="multipleSelect" class=""  style=" top: -29px; " > Related Product </label>

                        <select id="multipleSelect" name="relatedProd[]" class="js-states form-control px-sm-4" multiple>


                            <option value="0" > -- Select a other related product --</option>
                            @foreach ($all_products as $item)
                                        <option value="{{ $item->id }}"  > {{ $item->prod_name }} </option>
                            @endforeach

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
    </div>
</div>

@endsection

@section('scripts')
 @endsection
