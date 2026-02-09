
@extends('layouts/admin')






@section('content')


<div class="right_col" role="main">
    <div class="">
        <div class="page-title mx-sm-3">
            <div class="title_left w-100">
                <h3>Show Home Slider</h3>
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

            <table id="datatable" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($all_slides as $singleitem)


                        <tr>
                            <td> <?php  echo $i++ ; ?> </td>
                            <td> {{ $singleitem->main_title }}</td>
                            <td>  <img src="{{ url('images/'. $singleitem->slider_image) }}" alt=""  class=" mx-auto" style="object-fit: fill"  width="90px" height="70px" > </td>
                            <td>
                                <a  data-toggle="tooltip" data-placement="bottom" title="only View" href="{{ url('only-view-testimonial'). '/'.$singleitem->id }}" class="text-decoration-none">
                                    <button class="btn btn-submit-view btn-crud  view_btn btn-info  px-sm-2  mx-auto"  data-src="{{ url('only-view-testimonial'). '/'.$singleitem->id }}"  >
                                         <i class="fa fa-eye"></i>
                                    </button>
                                 </a>
                            </td>
                            <td>
                                <a  data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ url('edit-testimonial'). '/'.$singleitem->id }}" class="text-decoration-none">
                                    <button class="btn btn-submit-view btn-crud edit_btn btn-warning  px-sm-2  mx-auto"  data-src="{{ url('edit-testimonial'). '/'.$singleitem->id }}"  >
                                         <i class="fa fa-edit"></i>
                                    </button>
                                 </a>
                            </td>
                            <td>
                                <a  data-toggle="tooltip" data-placement="bottom" title="Delete" href="{{ url('delete-testimonial'). '/'.$singleitem->id }}" class="text-decoration-none">
                                   <button class="btn btn-submit-view btn-crud delete_btn btn-danger  px-sm-2  mx-auto"  data-src="{{ url('delete-testimonial'). '/'.$singleitem->id }}"  >
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
    $(".view_btn").click(function (e) {
        e.preventDefault();

        $edit_id_src = $(this).attr("data-src");

        //    alert( $edit_id_src );

        swal(
            {
                title: "Are you sure? ",
                text: "you want to view this  this slider!",
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
                text: "you want to edit this slider!",
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
                text: "you want to Delete the  this slider !",
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
                    swal("Deleted!", "Your this slider file has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your  this slider file is safe :)", "error");
                }
            }
        );

    });
});


   </script>

@endsection

