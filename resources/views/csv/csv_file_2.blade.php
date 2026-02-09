
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CSV Upload</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container py-5">
        <form id="basic-form" method="post" action="{{ url('upload_csv') }}" enctype="multipart/form-data">
            {{-- {{ url('upload_csv') }} --}}
                {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
                        <div class="form-example-int">
                                <input type="file" name="file" required >
                        </div>
                        {{-- <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" name="file" id="inputGroupFile01"
                                aria-describedby="inputGroupFileAddon01" required>
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                          </div> --}}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-center my-5">
                    <div class="form-example-int">
                        <button type="submit" style="width:170px;" class="btn btn-success notika-btn-success px-sm-4">Save</button>
                    </div>
                </div>
        </form>
    </div>
</body>
</html>
