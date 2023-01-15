<script type="text/javascript">
$(document).ready(function() {
	$('#member_form').validationEngine();
	$('#birth_date').datepicker({
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
                    
                }); 
} );
</script>
   
		
<div class="panel-body">
	<div class="member_view_row1">
	<div class="col-md-8 col-sm-12 membr_left">
		<div class="col-md-6 col-sm-12 left_side">
		
		</div>
		<div class="col-md-6 col-sm-12 right_side">
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-user"></i> 
				Name
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color">
				
				</span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-envelope"></i> 
				
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color">
				email
				</span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td"><i class="fa fa-phone"></i> 
			mobile
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color">
					<span class="txt_color"> </span>
				</span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-calendar"></i> Date Of Birth
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color"></span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-mars"></i>Gender
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color"></span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-graduation-cap"></i> Class
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color"></span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-user"></i> User Name
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color">
				</span>
			</div>
		</div>
		
		</div>
	</div>
	<div class="col-md-4 col-sm-12 member_right">	
			<span class="report_title">
				<span class="fa-stack cutomcircle">
					<i class="fa fa-align-left fa-stack-1x"></i>
				</span> 
				<span class="shiptitle">More Info
				</span>		
			</span>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-user"></i>	
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color">staff id</span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-heart"></i>Interest Area
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"></span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-users"></i>Member Ship
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"></span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-power-off"></i> Status
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"> </span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-map-marker"></i>Address
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"></span>
				</div>
			</div>
			
	</div>
	</div>
	</div><div class="panel-body">
	
	<div class="clear"></div>
	<div class="col-md-6  col-sm-6  col-xs-12 border">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle">Weight</span>	
			<a href="admin.php?page=gmgt_workout&tab=addmeasurement&user_id=1&result_measurment=Weight" 
			class="btn btn-danger right"> Add Weight</a>	
		</span>
		
		<?php 
		// $weight_data = $obj_gyme->get_weight_report('Weight',$_REQUEST['member_id']);
		// $option =  $obj_gyme->report_option('Weight');
		// require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
		// $GoogleCharts = new GoogleCharts;		
		// $wait_chart = $GoogleCharts->load( 'LineChart' , 'weight_report' )->get( $weight_data , $option );		
		?>
		<div id="weight_report" style="width: 100%; height: 250px;">
		<?php 
		// if(empty($weight_data) || count($weight_data) == 1)
		// _e('There is not enough data to generate report','gym_mgt')?>
		</div>   
		<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
  		<script type="text/javascript">
			<?php 
			// if(!empty($weight_data) && count($weight_data) > 1)
			// echo $wait_chart;?>
		</script>
	</div>	
</div>