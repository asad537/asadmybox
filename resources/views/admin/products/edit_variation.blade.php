@extends('layouts/admin')



@section('content')


 
<div class="main">
    <div class="main-inner">
   
 <div>
<style type="text/css">
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
</style>
 
 <div class="container py-4">
     <div class="row">
           <div class="col-12">
                <div class="card">
                    <div class="card-body p-b-0">
                        <div class="">
                         
                            <form method="post"   action="{{url('admin/update-variation').'/'}}" enctype="multipart/form-data">
                              @csrf
                            <input type="hidden" value="<?php echo $product[0]->id; ?>" name="product_id">
                            <input type="hidden" value="<?php echo $value[0]->id; ?>" name="id">
                            <div class="">
                             
                             <div class="">
                                 
                                  <div class="row justify-content-center">
                                     <div   class="col-md-8" >
                                         <h2  class="bold-7 font-28 my-4" >New variations update here</h2>
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->one != '') ? '<a>'.$variations_name[0]->one.'</a>' : 'First field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->one != '') ? $value[0]->one : ''); ?>" name="one" id="one" type="text" <?php echo ($variations_name[0]->one == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->two != '') ? '<a>'.$variations_name[0]->two.'</a>' : 'Second field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->two != '') ? $value[0]->two : ''); ?>" name="two" id="two" type="text" <?php echo ($variations_name[0]->two == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->three != '') ? '<a>'.$variations_name[0]->three.'</a>' : 'Third field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->three != '') ? $value[0]->three : ''); ?>" name="three" id="three" type="text" <?php echo ($variations_name[0]->three == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->four != '') ? '<a>'.$variations_name[0]->four.'</a>' : 'Four field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->four != '') ? $value[0]->four : ''); ?>" name="four" id="four" type="text" <?php echo ($variations_name[0]->four == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                    
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->five != '') ? '<a>'.$variations_name[0]->five.'</a>' : 'Five field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->five != '') ? $value[0]->five : ''); ?>" name="five" id="five" type="text" <?php echo ($variations_name[0]->five == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="" for="textarea2"><?php echo ($variations_name[0]->six != '') ? '<a>'.$variations_name[0]->six.'</a>' : 'Six field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->six != '') ? $value[0]->six : ''); ?>" name="six" id="six" type="text" <?php echo ($variations_name[0]->six == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->seven != '') ? '<a>'.$variations_name[0]->seven.'</a>' : 'Seven field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->seven != '') ? $value[0]->seven : ''); ?>" name="seven" id="seven" type="text" <?php echo ($variations_name[0]->seven == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->eight != '') ? '<a>'.$variations_name[0]->eight.'</a>' : 'Eight field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->eight != '') ? $value[0]->eight : ''); ?>" name="eight" id="eight" type="text" <?php echo ($variations_name[0]->eight == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->nine != '') ? '<a>'.$variations_name[0]->nine.'</a>' : 'Nine field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->nine != '') ? $value[0]->nine : ''); ?>" name="nine" id="nine" type="text" <?php echo ($variations_name[0]->nine == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="my-2" for="textarea2"><?php echo ($variations_name[0]->ten != '') ? '<a>'.$variations_name[0]->ten.'</a>' : 'Ten field data'; ?></label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo htmlentities(($value[0]->ten != '') ? $value[0]->ten : ''); ?>" name="ten" id="ten" type="text" <?php echo ($variations_name[0]->ten == '') ? 'readonly' : ''; ?>/>
                                            </div>
                                            <label class="my-2" for="textarea2" style="color: red;">Price</label>
                                            <div class="controls">
                                               <input class="form-control form-control-2" value="<?php echo $value[0]->price; ?>" name="price" id="price" type="text" required />
                                            </div>
                                            
                                             <div class="my-4">
                                             <button type="submit" name="btnsubmit" class="btn btn-submit-view px-sm-5">update</button>
                                             </div>
                                         
                                     </div>
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
 @endsection