
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>



<div class="container">
    <div class="">
        <br />
        <h3 align="center">Laravel 5.8 - Import Export Data in CSV File</h3>
        <br />
        {{-- <div class="panel panel-default">
            <div class="panel-heading">
            <h3 class="panel-title">Laravel 5.8 - Import Export Data in CSV File</h3>
            </div>
            <div class="panel-body">
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".csv">
                    <br>
                    <button class="btn btn-success">Import User Data</button>
                    <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>
            </form>
                @yield('csv_data')
            </div>
        </div> --}}

        <div class="card">
            <h5 class="card-header">Featured</h5>
            <div class="card-body">
              {{-- <h5 class="card-title">Laravel 5.8 - Import Export Data in CSV File</h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".csv">
                        <br>
                        <button class="btn btn-success">Import User Data</button>
                        <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>
                </form>

                 @yield('csv_data')
            </div>
          </div>
    </div>
</div>

</body>
</html>
