
@extends('layouts/admin')






@section('content')


<div class="right_col" role="main">
    <div class="">
        <div class="page-title mx-sm-3">
            <div class="title_left w-100">
                <h3>Our Blogs</h3>
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

            <table id="example1" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Meta Title</th>
                        <th>Meta Descrription</th>
                        <th>Meta Tags</th>
                        <th>Blog Tilte</th>
                        <th>Author name</th>
                        <th>Image</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($all_blogs as $singleitem)
                        <tr>
                            <td> <?php  echo $i++ ; ?> </td>
                            <td> <?php echo $singleitem->tag ;?> </td>
                            <td> <?php echo $singleitem->metadesc ;?> </td>
                            <td> <?php echo $singleitem->keywords ;?> </td>
                            <td> <?php echo $singleitem->t_title ;?> </td>
                            <td> <?php echo $singleitem->t_author ;?> </td>
                            <td>  <img src="{{ url('images/blog/'. $singleitem->t_featured_image) }}" alt=""  class="img-fluid mx-auto"  width="70px" height="70px" > </td>
                            <td>
                                <a  data-toggle="tooltip" data-placement="bottom" title="only View" href="{{ url('only-view-blog'). '/'.$singleitem->t_id }}" class="text-decoration-none">
                                    <button class="btn btn-submit-view btn-crud  viewBlog_btn btn-info  px-sm-2  mx-auto"  data-src="{{ url('only-view-blog'). '/'.$singleitem->t_id }}"  >
                                         <i class="fa fa-eye"></i>
                                    </button>
                                 </a>
                            </td>
                            <td>
                                <a  data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ url('editblog'). '/'.$singleitem->t_id }}" class="text-decoration-none">
                                    <button class="btn btn-submit-view btn-crud edit_btn btn-warning  px-sm-2  mx-auto"  data-src="{{ url('editblog'). '/'.$singleitem->t_id }}"  >
                                         <i class="fa fa-edit"></i>
                                    </button>
                                 </a>
                            </td>
                            <td>
                                <a  data-toggle="tooltip" data-placement="bottom" title="Delete" href="{{ url('deleteblog'). '/'.$singleitem->t_id }}" class="text-decoration-none">
                                   <button class="btn btn-submit-view btn-crud delete_btn btn-danger  px-sm-2  mx-auto"  data-src="{{ url('deleteblog'). '/'.$singleitem->t_id }}"  >
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
                text: "you want to view this  Blog!",
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
                text: "you want to edit this  Blog!",
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
                text: "you want to Delete the Blog !",
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
                    swal("Deleted!", "Your blog file has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your blog file is safe :)", "error");
                }
            }
        );

        //     swal(
        //     {
        //         title: "Are you sure?",
        //         text: "you want to Delete the Blog !",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonClass: "btn-danger",
        //         confirmButtonText: "Yes, Ok",
        //         closeOnConfirm: false,
        //     },
        //     function () {
        //         window.location =  $delete_id_src;
        //         swal("Deleted!", "Your blog has been deleted.", "success");
        //     }
        // );
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

