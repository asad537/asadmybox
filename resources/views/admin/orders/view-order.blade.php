@extends('layouts/admin')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title mx-sm-3">
            <div class="title_left w-100">
                <h3>Order Details</h3>
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
	        <table class="table table-bordered">
	          <tr>
	            <th>Name:</th>
	            <td><?php echo $get_order_details_by_id[0]->firstname." ".$get_order_details_by_id[0]->lastname; ?></td>
	          </tr>
	          <tr>
	            <th>Company Name:</th>
	            <td><?php echo $get_order_details_by_id[0]->companyname; ?></td>
	          </tr>
	          <tr>
	            <th>Country:</th>
	            <td><?php echo $get_order_details_by_id[0]->country; ?></td>
	          </tr>
	          <tr>
	            <th>Address:</th>
	            <td><?php echo $get_order_details_by_id[0]->address; ?></td>
	          </tr>
	          <tr>
	            <th>Address2:</th>
	            <td><?php echo $get_order_details_by_id[0]->address2; ?></td>
	          </tr>
	          <tr>
	            <th>City:</th>
	            <td><?php echo $get_order_details_by_id[0]->city; ?></td>
	          </tr>
	          <tr>
	            <th>State:</th>
	            <td><?php echo $get_order_details_by_id[0]->state; ?></td>
	          </tr>
	          <tr>
	            <th>Zipcode:</th>
	            <td><?php echo $get_order_details_by_id[0]->zipcode; ?></td>
	          </tr>
	          <tr>
	            <th>Phone:</th>
	            <td><?php echo $get_order_details_by_id[0]->phone; ?></td>
	          </tr>
	          <tr>
	            <th>Email:</th>
	            <td><?php echo $get_order_details_by_id[0]->email; ?></td>
	          </tr>
	          <tr>
	            <th>Message:</th>
	            <td><?php echo $get_order_details_by_id[0]->message; ?></td>
	          </tr>
	        </table>
        </div>
        <div class="page-title mx-sm-3">
            <div class="title_left w-100">
                <h3>Product List</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="card-box table-responsive">
	        <table class="table table-bordered">
	          <tr>
	          	<th>Name</th>
	          	<th>Price</th>
	          	<th>QTY</th>
	          	<th>Variations</th>
	          </tr>
               <?php foreach(json_decode($get_order_details_by_id[0]->order_data) as $key=>$value){ ?>
	          <tr>
	          	<td><?php echo $value->name; ?></td>
	          	<td><?php echo $value->price; ?></td>
	          	<td><?php echo $value->quantity; ?></td>
	          	<td>
	          		<?php foreach(unserialize($value->conditions) as $key1=>$value1){
	          			echo "<b>".$key1.":</b> ".$value1."<br>";
	          		} ?>
	          	</td>
	          </tr>
	      	<?php } ?>
	        </table>
        </div>
        <div class="card-box">
        	<form action="{{url('update-admin-order-status').'/'}}" method="post" class="form-inline">
        		@csrf
        		<div class="row">
        			<div class="col-lg-12 form-group">
        				<label for="" class="control-label">Order Status</label>
        				<select name="order_status" class="form-control">
        					<option <?php if($get_order_details_by_id[0]->order_status==0){echo "selected";} ?> value="0">Pending Payment</option>
        					<option <?php if($get_order_details_by_id[0]->order_status==1){echo "selected";} ?> value="1">Process</option>
        					<option <?php if($get_order_details_by_id[0]->order_status==2){echo "selected";} ?> value="2">Delivered</option>
        				</select>
        			</div>
        			<div class="col-lg-12">
        				<input type="hidden" value="<?php echo $get_order_details_by_id[0]->order_id; ?>" name="order_id">
        				<input type="submit" value="Update" class="btn btn-primary">
        			</div>
        		</div>
        	</form>
        </div>
    </div>
</div>
@endsection