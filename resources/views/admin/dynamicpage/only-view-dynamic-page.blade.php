@extends('layouts/admin')

@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="">
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <h3>View Static Pages</h3>
            </div>
        </div>
        <div class="clearfix"></div>

         @foreach ($all_pages  as $singlePage)
            <form class="form px-sm-4" method="post" action="" enctype="multipart/form-data">
                @csrf
                <div class="row">
               <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText1" type="text" name="page_name" value="{{ $singlePage->page_name  }}" class="form-control bg-light smalll" readonly />
                            <label for="inputText1" class="col-form-label"> Page Name </label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <input id="inputText2" type="text" name="page_url" value="{{ $singlePage->page_url  }}" class="form-control bg-light smalll"  readonly />
                            <label for="inputText2" class="col-form-label"> Page URL</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText3" type="text" name="m_des" value="{{ $singlePage->m_des  }}" class="form-control bg-light smalll"  readonly />
                        <label for="inputText3" class="col-form-label">Meta  Description</label>
                    </div>
                </div>
                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText4" type="text" name="m_title" value="{{ $singlePage->m_title  }}" class="form-control bg-light smalll"  readonly />
                        <label for="inputText4" class="col-form-label"> Meta Title </label>
                    </div>
                </div>

                <div class="col-md-12 mb-sm-4">
                    <div class="form-group material-style">
                        <input id="inputText5" type="text" name="m_tags"value="{{ $singlePage->m_tags  }}"  class="form-control bg-light smalll"  readonly />
                        <label for="inputText5" class="col-form-label"> Meta tags</label>
                    </div>
                </div>

                    <div class="col-md-12 mb-sm-4">
                        <div class="form-group material-style">
                            <textarea class="form-control" id="editor2"  name="page_desc"  readonly> {{ $singlePage->page_desc }}</textarea>
                            <label for="editor2" class="col-form-label">Page  Description</label>
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
