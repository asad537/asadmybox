
@extends('layouts/admin')






@section('content')


<div class="right_col" role="main">
    <div class="">
        <div class="page-title mx-sm-3">
            <div class="title_left w-100">
                <h3>Our Customers</h3>
            </div>
        </div>


        <div class="clearfix"></div>

        @if (Session::has('message'))

                <div class="alert alert-success session-destroy mt-sm-4 mx-sm-3">
                    <?php
                             echo Session::get('message');
                           //    Session::flush();
                           //    Session::forget('message') ;
                   ?>
             </div>
        @endif

        <div class="clearfix"></div>
        <div class="card-box table-responsive">
            <table id="example1" class="table table-bordered table-striped"  width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($get_all_customers as $single_customer)
                        <tr>
                            <td> <?php  echo $i++ ; ?> </td>
                            <td>  <img src="{{ url('images/'. $single_customer->customer_image) }}" alt=""  class="img-fluid mx-auto"  width="70px" height="70px" > </td>
                            <td>
                                <a  data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ url('edit-customer'). '/'.$single_customer->customer_id }}" class="text-decoration-none">
                                    <button class="btn btn-submit-view btn-crud edit_btn btn-warning  px-sm-2  mx-auto"  data-src="{{ url('edit-customer'). '/'.$single_customer->customer_id }}"  >
                                         <i class="fa fa-edit"></i>
                                    </button>
                                 </a>
                            </td>
                            <td>
                                <a  data-toggle="tooltip" data-placement="bottom" title="Delete" href="{{ url('delete-customer'). '/'.$single_customer->customer_id }}" class="text-decoration-none">
                                   <button class="btn btn-submit-view btn-crud delete_btn btn-danger  px-sm-2  mx-auto"  data-src="{{ url('delete-customer'). '/'.$single_customer->customer_id }}"  >
                                        <i class="fa fa-trash "></i>
                                   </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
  $(document).ready(function () {
    $(".viewBlog_btn").click(function (e) {
        e.preventDefault();

        $edit_id_src = $(this).attr("data-src");

        //    alert( $edit_id_src );

        swal(
            {
                title: "Are you sure? ",
                text: "you want to view this Customer!",
                type: "info",
                showCancelButton: true,
                confirmButtonClass: "btn-info",
                confirmButtonText: "Next",
                closeOnConfirm: false,
            },
            function () {
                window.location = $edit_id_src;
            }
        );
    });
    $(".edit_btn").click(function (e) {
        e.preventDefault();

        $edit_id_src = $(this).attr("data-src");

        //    alert( $edit_id_src );

        swal(
            {
                title: "Are you sure? ",
                text: "you want to edit this Customer!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Next",
                closeOnConfirm: false,
            },
            function () {
                window.location = $edit_id_src;
            }
        );
    });

    $(".delete_btn").click(function (e) {
        e.preventDefault();
        $delete_id_src = $(this).attr("data-src");
        // alert($delete_id);

        swal(
            {
                title: "Are you sure?",
                text: "you want to Delete the Customer !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, ok!",
                cancelButtonText: "No, cancel !",
                closeOnConfirm: false,
                closeOnCancel: false,
            },

            function (isConfirm) {
                if (isConfirm) {
                    window.location = $delete_id_src;
                    swal("Deleted!", "Your Customer file has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your Customer file is safe :)", "error");
                }
            }
        );

    });
});



    $(function () {
      $("#example1").DataTable();
    //   $('#example2').DataTable({
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": false,
    //   });
    });
  </script>

@endsection

