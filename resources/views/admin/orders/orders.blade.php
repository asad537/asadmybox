
@extends('layouts/admin')






@section('content')


<div class="right_col" role="main">
    <div class="">
        <div class="page-title mx-sm-3">
            <div class="title_left w-100">
                <h3>Orders</h3>
            </div>
        </div>


        <div class="clearfix"></div>

        @if (Session::has('message'))
                <div class="alert alert-success session-destroy mt-sm-4 mx-sm-3">
                    <?php
                             echo Session::get('message');
                   ?>
             </div>
        @endif

        <div class="clearfix"></div>
        <div class="card-box table-responsive">

            <table id="example1" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Date</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                     <?php $i = 1; foreach($get_all_orders as $key=>$value){ ?>
                    <tr>
                        <td><?php echo $value->firstname." ".$value->lastname; ?></td>
                        <td><?php echo date("d-m-Y", $value->order_time); ?></td>
                        <td><?php echo $value->email; ?></td>
                        <td>
                            <?php if($value->order_status==0){ ?>
                                <span class="btn btn-danger btn-sm">Payment Pending</span>
                            <?php }elseif($value->order_status==1){ ?>
                                <span class="btn btn-warning btn-sm">Process</span>
                            <?php }elseif($value->order_status==2){ ?>
                                <span class="btn btn-success btn-sm">Delivered</span>
                            <?php } ?>
                        </td>       
                        <td>
                            <a href="{{url('admin-view-order/'.$value->order_id)}}" onclick="return confirm('Are you sure you want to view this product')" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                    <?php $i++; } ?>
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
                text: "you want to view this  product!",
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
                text: "you want to edit this  product!",
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
                text: "you want to Delete the  product !",
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
                    swal("Deleted!", "Your product file has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your  product file is safe :)", "error");
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

