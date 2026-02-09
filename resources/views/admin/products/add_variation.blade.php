
@extends('layouts/admin')
@section('content')
<style type="text/css">
tr:nth-child(even) {background: #FFF}
tr:nth-child(odd) {background: #CCC}  
.font-24 {
    font-size: 24px;
}
.bold-6 {
    font-weight: 600;
}
.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #fe4328;
    font-weight: 500;
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #495057;
    background-color: #fff;
    border-color: #ff4328 #dee2e6 #fff;
}
.back-btn{
    position: absolute;
    float: right;
    letter-spacing: 0.5px;
    right: 23px;
}
</style>
<div class="right_col" role="main">
    <div class="clearfix"></div>


    @if (Session::has('delete_var'))
            <div class="alert alert-danger session-destroy mt-sm-4 mx-sm-4">
                <?php echo Session::get('delete_var'); ?>
            </div>
    @endif


    @if (Session::has('success'))
            <div class="alert alert-success session-destroy mt-sm-4 mx-sm-4">
                <?php echo Session::get('success'); ?>
            </div>
    @endif


    
    

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
                <h3> Variations</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="page-title px-sm-4">
            <div class="title_left mb-sm-4 w-100">
                <a href="{{url('delete-all-variations/'.Request::segment(4))}}" onsubmit="return confirm('Do you really want to delete all variations? if yes, press OK..');" class="btn btn-danger">Delete All Variations</a>
            </div>
        </div>
        <div class="clearfix"></div>


       

        <div class="main">
 
 <div class="page-wrapper">
     <div class="container"> 
         <div class="row">
             <div class="col-12">
                 <div class="card">
                     <div class="card-body p-b-0">
                         <ul class="nav nav-tabs customtab" role="tablist">
                             <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2" role="tab">
                              <span class="hidden-sm-up"><i class="ti-pencil"></i></span> <span  class="hidden-xs-down">Manage</span>
                            </a>
                          </li>
                             <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#csv" role="tab"><span class="hidden-sm-up"><i class="ti-pencil"></i></span> <span  class="hidden-xs-down">Csv</span></a></li>
                              <li style="position: initial;" class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2" role="tab">
                              <span class="hidden-sm-up"><i class="ti-plus"></i></span> <span  class="hidden-xs-down">Add</span>
                            </a> 
                          </li>
                             <li style="position: initial;" class="nav-item back-btn"> <a class="nav-link"  href="{{url('addproduct')}}" role="tab">Back</a> </li>
                         </ul>
     <div class="tab-content">
         <div class="tab-pane active" id="home2" role="tabpanel">
             <div class="p-20">
                         
                         <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                         <div class="table-responsive">
                               <div id="buttons"></div>
                                <form class="deleteall_form" action="#" role="form" method="post"  onsubmit="return confirm('Do you really want to delete all variations? if yes, press OK..');">
                               <input type="hidden" value="<?php echo $product[0]->id; ?>" name="product_id">
                               
                               </form>
                               <span id="product_id" class="product_id" data-id="<?php echo $product[0]->id; ?>"></span>
                               <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                   <thead>
                                     <tr>
                                         <!-- <th width="5%" style="background-color: #00ba8b;"><button type="button" name="delete_mul" id="delete_mul" class="btn btn-danger btn-xs"><i class="icon-trash"></i></button></th> -->
                                         <th style="background:rgb(199 51 51) ;"><b  style="font-size: 19px; font-family: cursive; color:#fff;">Sr.</b></th>
                                         <th style="background:rgb(199 51 51);"><b  style="font-size: 19px; font-family: cursive; color:#fff;"><?php echo ($variations_name[0]->one != '') ? $variations_name[0]->one : 'First field'; ?></b></th>
                                         <th style="background:rgb(199 51 51);"><b  style="font-size: 19px; font-family: cursive; color:#fff;"><?php echo ($variations_name[0]->two != '') ? $variations_name[0]->two : 'Second field'; ?></b></th>
                                         <th style="background:rgb(199 51 51);"><b  style="font-size: 19px; font-family: cursive; color:#fff;"><?php echo ($variations_name[0]->three != '') ? $variations_name[0]->three : 'Third field'; ?></b></th>
                                         <th style="background:rgb(199 51 51);"><b   style="font-size: 19px; font-family: cursive; color:#fff;">Price</b></th>
                                         <th style="background:rgb(199 51 51);"><b   style="font-size: 19px; font-family: cursive; color:#fff;">Action</b></th>
                                        
                                     </tr>
                                 </thead>  
                                 
                                 
                                   <?php
           $sr=0;
           foreach($all_data as $i) { 
           $sr++;
           ?>
             <tr>
                 <td scope="row"><?php echo $sr; ?></td>
                 <td><?php echo $i->one; ?></td>
                 <td><?php echo $i->two; ?></td>
                 <td><?php echo $i->three; ?></td>
                 <td><?php echo $i->price; ?></td>
                 <td>
                     <a  data-toggle="tooltip" data-placement="bottom" title="Edit" class="text-decoration-none" href="<?php echo url('admin/edit-variation'.'/'.$i->id.'/'.$i->product_id); ?>">
                             Edit
                     </a>
                     <a  data-toggle="tooltip" data-placement="bottom" title="Delete" class="text-decoration-none" href="<?php echo url('admin/delete-variation'.'/'.$i->id); ?>">
                                Delete
                        </a>
                
                    </td>
                             
                 
               
             </tr>
             
             <?php } ?>
                             </table>
                         </div>
             </div> 
         </div>
        
         <div class="tab-pane  p-20" id="csv" role="tabpanel">
             <form name="formName" class="form-horizontal" method="post" id="import_csv" enctype="multipart/form-data" action="{{url('reseller/variation/csv_import_data')}}">
                  @csrf
                 <div class="variations-add">
                    <div class="control-group">
                     <label>Select CSV File</label>
                     <input type="file" id="csv_file" name='file' required>
                     <input type="hidden" value="{{ Request::segment(4) }}" name="product_id">
                    </div>
                    
                    <br />
                    
                    <input type="submit" class="btn btn-info" name='submit' value='Import'>
                    
                </div>
             </form>
         </div>
         <div class="tab-pane  p-20" id="profile2" role="tabpanel">
 
             <form name="formName" id="quoteform" class="form-horizontal" action="{{url('admin/newaddvariation')}}" method="post">
                   @csrf
                 <input type="hidden" value="{{ Request::segment(4) }}" name="product_id">
                 <div class="">
 
                  <div class="">
                      <div class="row justify-content-center">
                          <div   class="col-md-8" >
                              
                                 <h2  class="bold-7 font-28 my-4" >New variation add here</h2>
                                <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->one != '') ? '<a>'.$variations_name[0]->one.'</a>' : 'First field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="one" id="one" type="text" <?php echo ($variations_name[0]->one == '') ? 'readonly' : ''; ?> required />
                                 </div>
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->two != '') ? '<a>'.$variations_name[0]->two.'</a>' : 'Second field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="two" id="two" type="text" <?php echo ($variations_name[0]->two == '') ? 'readonly' : ''; ?>/>
                                 </div>
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->three != '') ? '<a>'.$variations_name[0]->three.'</a>' : 'Third field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="three" id="three" type="text" <?php echo ($variations_name[0]->three == '') ? 'readonly' : ''; ?>/>
                                 </div>
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->four != '') ? '<a>'.$variations_name[0]->four.'</a>' : 'Four field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="four" id="four" type="text" <?php echo ($variations_name[0]->four == '') ? 'readonly' : ''; ?>/>
                                 </div>
             
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->five != '') ? '<a>'.$variations_name[0]->five.'</a>' : 'Five field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="five" id="five" type="text" <?php echo ($variations_name[0]->five == '') ? 'readonly' : ''; ?>/>
                                 </div>
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->six != '') ? '<a>'.$variations_name[0]->six.'</a>' : 'Six field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="six" id="six" type="text" <?php echo ($variations_name[0]->six == '') ? 'readonly' : ''; ?>/>
                                 </div>
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->seven != '') ? '<a>'.$variations_name[0]->seven.'</a>' : 'Seven field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="seven" id="seven" type="text" <?php echo ($variations_name[0]->seven == '') ? 'readonly' : ''; ?>/>
                                 </div>
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->eight != '') ? '<a>'.$variations_name[0]->eight.'</a>' : 'Eight field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="eight" id="eight" type="text" <?php echo ($variations_name[0]->eight == '') ? 'readonly' : ''; ?>/>
                                 </div>
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->nine != '') ? '<a>'.$variations_name[0]->nine.'</a>' : 'Nine field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="nine" id="nine" type="text" <?php echo ($variations_name[0]->nine == '') ? 'readonly' : ''; ?>/>
                                 </div>
                                 <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->ten != '') ? '<a>'.$variations_name[0]->ten.'</a>' : 'Ten field data'; ?></label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="ten" id="ten" type="text" <?php echo ($variations_name[0]->ten == '') ? 'readonly' : ''; ?>/>
                                 </div>
                                 <label class="my-2" for="textarea2" style="color: red;">Price</label>
                                 <div class="controls">
                                    <input class="form-control form-control-2" value="" name="price" id="price" type="text" required />
                                 </div>
                                 <div class="col-md-6 form-group align-self-center mt-3">
                                             <!-- <center> -->
                                             
                                                 <div class="g-recaptcha" id="recapchaheader" required></div>
                                                     
                                                  
                                             <!-- </center> -->
                                         </div>
                                 <div class="my-4">
                                     <button type="submit" class="save btn btn-submit-view px-sm-5" >Save </button>
                                 </div>
                          </div>
                      </div>
                   
                 </div>
               
             </form>
       </div>
     </div>
   </div>
 </div>
 </div>
 </div>
 </div>
 </div>
        






    </div>
</div>

<style>
.paginate_button:hover{
  background: #ff4328 !important;
  border: 1px solid #ff4328 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
  border: 1px solid #1e9fde;
  background: #9ddefe !important;
}
.dataTables_processing{
  background: #a8e1d2 !important;
  -moz-box-shadow:    10px 8px 25px 20px #a8e1d2;
  box-shadow:         10px 8px 25px 20px #a8e1d2;
}
.removeRow{
  background-color: #FF6347 !important;
}
.table.dataTable thead .sorting_asc:first-child::after{
  display: none;
}
table.dataTable thead .sorting_desc:first-child::after{
  display: none;
}
.variations-add-box{
    margin:10px 10% !important;
}
.variations-add h2{
font-weight: 500;
font-size: 22px;
line-height: 22px;color: #21a9ec ;
}
.variations-add .control-group{
background: #ffffff none repeat scroll 0 0 !important;
margin: 15px 0 !important;
padding: 20px !important;
border: 0 solid #e7e7e7 !important;
border-radius: 5px !important;
box-shadow: 0 5px 30px rgba(0, 0, 0, 0.4) !important;
}
.variations-add .control-group .control-label{
width: 30% !important; text-align: right !important;
}
     .card {
  margin-bottom: 30px;
}
.card .card-subtitle {
  color: #99abb4;
  font-weight: 300;
  margin-bottom: 15px;
}
.card-inverse .card-bodyquote .blockquote-footer {
  color: rgba(255, 255, 255, 0.65);
}
.card-inverse .card-link {
  color: rgba(255, 255, 255, 0.65);
}
.card-inverse .card-subtitle {
  color: rgba(255, 255, 255, 0.65);
}
.card-inverse .card-text {
  color: rgba(255, 255, 255, 0.65);
}
.card-success {
  background: #26dad2 none repeat scroll 0 0;
  border-color: #26dad2;
}
.card-danger {
  background: #ef5350 none repeat scroll 0 0;
  border-color: #ef5350;
}
.card-warning {
  background: #ffb22b none repeat scroll 0 0;
  border-color: #ffb22b;
}
.card-info {
  background: #8b9931 none repeat scroll 0 0;
  border-color: #8b9931;
}
.card-primary {
  background: #8b9931 none repeat scroll 0 0;
  border-color: #8b9931;
}
.card-dark {
  background: #2f3d4a none repeat scroll 0 0;
  border-color: #2f3d4a;
}
.card-megna {
  background: #00897b none repeat scroll 0 0;
  border-color: #00897b;
}
.card-actions {
  float: right;
}
.card-actions a {
  color: #67757c;
  cursor: pointer;
  font-size: 13px;
  opacity: 0.7;
  padding-left: 7px;
}
.card-actions a:hover {
  opacity: 1;
}
.card-columns .card {
  margin-bottom: 20px;
}
.collapsing {
  transition: height 0.08s ease 0s;
}
.card-outline-info {
  border-color: #8b9931;
}
.card-outline-info .card-header {
  background: #8b9931 none repeat scroll 0 0;
  border-color: #8b9931;
}
.card-outline-inverse {
  border-color: #2f3d4a;
}
.card-outline-inverse .card-header {
  background: #2f3d4a none repeat scroll 0 0;
  border-color: #2f3d4a;
}
.card-outline-warning {
  border-color: #ffb22b;
}
.card-outline-warning .card-header {
  background: #ffb22b none repeat scroll 0 0;
  border-color: #ffb22b;
}
.card-outline-success {
  border-color: #26dad2;
}
.card-outline-success .card-header {
  background: #26dad2 none repeat scroll 0 0;
  border-color: #26dad2;
}
.card-outline-danger {
  border-color: #ef5350;
}
.card-outline-danger .card-header {
  background: #ef5350 none repeat scroll 0 0;
  border-color: #ef5350;
}
.card-outline-primary {
  border-color: #5c4ac7;
}
.card-outline-primary .card-header {
  background: #5c4ac7 none repeat scroll 0 0;
  border-color: #5c4ac7;
}
.card-body {
  padding: 0;
}
.card {
  background: #ffffff none repeat scroll 0 0;
  margin: 15px 0;
  padding: 20px;
  border: 0 solid #e7e7e7;
  border-radius: 5px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
}
.card-subtitle {
  font-size: 12px;
  margin: 10px 0;
}
.card-title {
  font-weight: 500;
  font-size: 18px;
  line-height: 22px;
}
.card-title h4 {
  display: inline-block;
  font-weight: 500;
  font-size: 18px;
  line-height: 22px;
}
.card-title p {
  font-family: 'Poppins', sans-serif;
  margin-bottom: 12px;
}
.vtabs {
  display: table;
}
.vtabs .tabs-vertical {
  border-bottom: 0 none;
  border-right: 1px solid rgba(120, 130, 140, 0.13);
  display: table-cell;
  vertical-align: top;
  width: 150px;
}
.vtabs .tabs-vertical li .nav-link {
  border: 0 none;
  border-radius: 4px 0 0 4px;
  color: #455a64 !important;
  margin-bottom: 10px;
}
.vtabs .tab-content {
  display: table-cell;
  padding: 20px;
  color: #455a64 !important;
  vertical-align: top;
}
.tabs-vertical li .nav-link.active,
.tabs-vertical li .nav-link.active:focus,
.tabs-vertical li .nav-link:hover {
  background: #8b9931 none repeat scroll 0 0;
  border: 0 none;
  color: #ffffff;
}
.customvtab .tabs-vertical li .nav-link.active,
.customvtab .tabs-vertical li .nav-link:focus,
.customvtab .tabs-vertical li .nav-link:hover {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  background: #ffffff none repeat scroll 0 0;
  border-color: currentcolor #8b9931 currentcolor currentcolor;
  border-image: none;
  border-style: none solid none none;
  border-width: 0 2px 0 0;
  color: #fff;
  margin-right: -1px;
}
.tabcontent-border {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  border-color: currentcolor #ddd #ddd;
  border-image: none;
  border-style: none solid solid;
  border-width: 0 1px 1px;
}
.customtab2 li a.nav-link {
  border: 0 none;
  color: #fff;
  margin-right: 3px;
}
.customtab2 li a.nav-link.active {
  background: #8b9931 none repeat scroll 0 0;
  color: #ffffff;
}
.customtab2 li a.nav-link:hover {
  background: #8b9931 none repeat scroll 0 0;
  color: #ffffff;
}
.modal-dialog {
  margin: 30px auto;
  position: relative;
  top: 50%;
  transform: translateY(-50%) !important;
  width: 70%;
}
.modal-header .close {
  font-size: 14px;
  margin-right: 15px;
  margin-top: 5px;
}
.modal-content {
  border-radius: 3px;
}
.timeline {
  list-style: none;
  padding: 0 0 8px;
  position: relative;
}
.timeline:before {
  top: 7px;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 3px;
  background-color: #e7e7e7;
  left: 25px;
  margin-right: -1.5px;
}
.timeline-title {
  margin: 5px 0 !important;
  font-size: 16px;
}
.timeline > li {
  margin-bottom: 20px;
  position: relative;
}
.timeline > li:after,
.timeline > li:before {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li > .timeline-panel {
  width: calc(100% - 70px);
  float: right;
  border-radius: 2px;
  padding: 5px 20px;
  position: relative;
}
.timeline > li > .timeline-panel:before {
  position: absolute;
  top: 26px;
  left: -15px;
  display: inline-block;
  border-top: 0 solid transparent;
  border-right: 0 solid #e7e7e7;
  border-left: 0 solid #e7e7e7;
  border-bottom: 15px solid transparent;
  content: " ";
}
.timeline > li > .timeline-panel:after {
  position: absolute;
  top: 27px;
  left: -14px;
  display: inline-block;
  border-top: 14px solid transparent;
  border-right: 14px solid #ffffff;
  border-left: 0 solid #ffffff;
  border-bottom: 14px solid transparent;
  content: " ";
}
.timeline > li > .timeline-badge {
  color: #ffffff;
  width: 35px;
  height: 35px;
  line-height: 35px;
  font-size: 1.4em;
  text-align: center;
  position: absolute;
  top: 10px;
  left: 8px;
  margin-right: -25px;
  background-color: #e6a1f2;
  z-index: 100;
  border-top-right-radius: 50%;
  border-top-left-radius: 50%;
  border-bottom-right-radius: 50%;
  border-bottom-left-radius: 50%;
}
.timeline-body > p {
  font-size: 12px;
  margin-bottom: 10px;
}
.timeline-badge.primary {
  background-color: #4680ff !important;
}
.timeline-badge.success {
  background-color: #26dad2 !important;
}
.timeline-badge.warning {
  background-color: #ffb64d !important;
}
.timeline-badge.danger {
  background-color: #fc6180 !important;
}
.timeline-badge.info {
  background-color: #62d1f3 !important;
}
.dataTables_wrapper {
  padding-top: 10px;
}
.dt-buttons {
  display: inline-block;
  margin-bottom: 15px;
  padding-top: 5px;
}
.dt-buttons .dt-button {
  background: #00ba8b none repeat scroll 0 0;
  border-radius: 4px;
  color: #ffffff;
  margin-right: 3px;
  padding: 5px 15px;
  cursor: pointer !important;
  text-decoration:none !important;
}
.dt-buttons .dt-button:hover {
  background: #2f3d4a none repeat scroll 0 0;
}
     .swal2-styled.swal2-confirm{
         background-color: #2a247a !important;
     }
     .swal2-title{
         color: #ff4328 !important;
         font-size: 27px;
     }

 </style>
 


@endsection

@section('scripts')





<script type="text/javascript">
  var table =$('#example23').DataTable( {
    
          
          

    });
  var buttons = new $.fn.dataTable.Buttons(table, {
      "buttons": [
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
                columns: [1,2,3]
            }
       }        
    ]  
}).container().appendTo($('#buttons'));
</script> 

 
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
                text: "you want to edit this  Variation!",
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
                text: "you want to Delete this Variation !",
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
</script>
@endsection