<?php $session = $this->request->session()->read("User");?>
<script>
$(document).ready(function(){
	$(".date").datepicker( "option", "dateFormat", "<?php echo $this->Gym->dateformat_PHP_to_jQueryUI($this->Gym->getSettings("date_format")); ?>" );
	// $(".date").datepicker(/* { language: "th"} */);
	<?php
	if(isset($_POST['curr_date']))
	{?>
	$( ".date" ).datepicker( "setDate", new Date("<?php echo date($this->Gym->getSettings("date_format"),strtotime($_POST['curr_date'])); ?>" ));
	<?php } ?>
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-plus"></i>
				<?php echo __("Member Attendance");?>
				<small><?php echo __("Attendance");?></small>
			  </h1>
			   <?php
				if($session["role_name"] == "administrator")
				{ ?>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymAttendance","staffAttendance");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Staff Attendance");?></a>
			 </ol>
			 <?php } ?>
			</section>
		</div>
		<hr>
		<div class="box-body">	
		<form method="post" class="validateForm">  
			  <input type="hidden" name="class_id" value="0">
			  <div class="form-group col-md-3">
				<label class="control-label" for="curr_date"><?php echo __("Date");?></label>				
					<input id="curr_date" class="form-control validate[required] date" type="text" value="<?php echo (isset($_POST['curr_date'])) ? date($this->Gym->getSettings("date_format"),strtotime($_POST["curr_date"])):"";?>" name="curr_date">
			 </div>
			<div class="form-group col-md-3">
				<label for="class_id"><?php echo __("Select Class");?></label>			
								 
				<?php echo $this->Form->select("class_id",$classes,["empty"=>__("Select Class"),"class"=>"validation[required] form-control",'required'=>'true']);?>
				
			</div>
			<div class="form-group col-md-3 button-possition">
				<label for="subject_id">&nbsp;</label>
				<input type="submit" value="<?php echo __("Take/View Attendance");?>" name="attendence" class="btn btn-flat btn-success">
			</div>       
        </form>
		<div class="clearfix"> </div>
		<hr>
		<!-- ###################################################################### -->	
	<?php	
	if($view_attendance)
	{ 
		// if(!empty($data))
		// {
	?>
			<div class="clearfix"> </div>
			<div class="panel-body">  
				<form method="post" class="form-horizontal">  
			  <input type="hidden" name="class_id" value="<?php echo $class_id;?>">
			  <input type="hidden" name="attendance_date" value="<?php echo $attendance_date;?>">
			 <div class="panel-heading">
				<h4 class="panel-title">
				<?php echo __("Class");?> : <?php echo $this->Gym->get_class_by_id($class_id);?> , 
				<?php echo __("Date");?> : <?php echo (isset($_POST['curr_date'])) ? date($this->Gym->getSettings("date_format"),strtotime($_POST["curr_date"])):"";?></h4>
			 </div>
			 <br><br>
				<div class="clearfix"> </div>
			  <div class="form-group">
				  <label class="radio-inline">
				  <input type="radio" name="status" value="Present" checked="checked"><?php echo __("Present"); ?></label>
				  <label class="radio-inline">
				  <input type="radio" name="status" value="Absent"><?php echo __("Absent"); ?><br>
				  </label>
			  </div>
			<div class="col-md-12">
			<table class="table">
				<thead>
			   <tr>
					<th width="70px"><?php echo __("Status");?></th>
					<th><?php echo __("Photo");?></th>
					<th width="250px"><?php echo __("Member Name");?></th>				
					<th><?php echo __("Status");?></th>			
				</tr>
				</thead>
				<tbody>
				
				<?php foreach($data as $row)
				{ ?>
				<tr> 
					<td class="checkbox_field"><span><input type="checkbox" class="checkbox1" name="attendance[]" value="<?php echo $row["gym_member"]["id"];?>"></span></td>
					<td><img src="<?php echo $this->request->base ."/webroot/upload/".$row["gym_member"]['image']; ?>" class='membership-img img-circle'></td>
					<td><span><?php echo $row["gym_member"]['first_name']." ".$row["gym_member"]['last_name']."(".$row["gym_member"]['member_id'].")"; ?></span></td>
					<td><?php
						$att_status = $this->Gym->get_attendance_status($row["gym_member"]["id"],$_POST["curr_date"]);
						echo __($att_status); ?>
					</td>
				</tr>
		  <?php } ?>
				</tbody>
			</table>
			  </div>
			<div class="col-sm-12"> 
								
				<input type="submit" value="<?php echo __("Save Attendance");?>" name="save_attendance" class="btn btn-flat btn-success">
						</div>
			</form>	
			</div>
	<?php
		// }else
		// {	
			// echo "<i>".__('No record found.')."</i>";
		// }
	} ?>	
		
		<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
