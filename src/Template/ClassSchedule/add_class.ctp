<?php 
echo $this->Html->css('bootstrap-multiselect');
echo $this->Html->script('bootstrap-multiselect');
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.day_list').multiselect({
		includeSelectAllOption: true	
	});
	// $(".dob").datepicker({format: '<?php echo $this->Gym->getSettings("date_format"); ?>'});
	$(".dob").datepicker({format: '<?php echo $this->Gym->getSettings("date_format"); ?>'});
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-plus"></i>
				<?php echo $title;?>
				<small><?php echo __("Class Schedule");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("ClassSchedule","classList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Class List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
		<?php
			echo $this->Form->create("addClass",["type"=>"file","class"=>"validateForm form-horizontal","role"=>"form"]);
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Class Name").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"class_name","class"=>"form-control validate[required]","value"=>(($edit)?$data['class_name']:'')]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Select Staff Member").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';			
			echo @$this->Form->select("assign_staff_mem",$staff,["default"=>$data['assign_staff_mem'],"empty"=>__("Select Staff Member"),"class"=>"form-control validate[required]"]);
			echo "</div>";	
			
			if($this->request->session()->read("User.role_name") == "Administrator")
			{
				echo '<div class="col-md-2">';
				echo "<a href='{$this->request->base}/StaffMembers/addStaff' class='btn btn-flat btn-primary'>".__("Add")."</a>";
				echo "</div>";	
				
			}
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Select Assistant Staff Member").'</label>';
			echo '<div class="col-md-6">';			
			echo @$this->Form->select("assistant_staff_member",$assistant_staff,["default"=>$data['assistant_staff_member'],"empty"=>__("Select Staff Member"),"class"=>"form-control"]);
			echo "</div>";	
			
			if($this->request->session()->read("User.role_name") == "Administrator")
			{
				echo '<div class="col-md-2">';
				echo "<a href='{$this->request->base}/StaffMembers/addStaff' class='btn btn-flat btn-primary'>".__("Add")."</a>";
				echo "</div>";	
			}
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Location").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"location","class"=>"form-control","value"=>(($edit)?$data['location']:'')]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Select Days").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			$days = ["Sunday"=>__("Sunday"),"Monday"=>__("Monday"),"Tuesday"=>__("Tuesday"),"Wednesday"=>__("Wednesday"),"Thursday"=>__("Thursday"),"Friday"=>__("Friday"),"Saturday"=>__("Saturday")];
			echo @$this->Form->select("days",$days,["default"=>json_decode($data['days']),"multiple"=>"multiple","class"=>"form-control validate[required] day_list"]);
			echo "</div>";				
			echo "</div>";	
			
			$hrs = ["0","1","2","3","4","5","6","7","8","9","10","11","12"];
			$min = ["00"=>"00","15"=>"15","30"=>"30","45"=>"45"];
			$ampm = ["AM"=>"AM","PM"=>"PM"];
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Start Time").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_hrs",$hrs,["default"=>$data['start_hrs'],"empty"=>__("Select Time"),"class"=>"start_hrs form-control validate[required]"]);
			echo "</div>";	
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_min",$min,["default"=>$data['start_min'],"class"=>"start_min form-control"]);
			echo "</div>";
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_ampm",$ampm,["default"=>$data['start_ampm'],"class"=>"start_ampm form-control"]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("End Time").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_hrs",$hrs,["default"=>$data['end_hrs'],"empty"=>__("Select Time"),"class"=>"end_hrs form-control validate[required]"]);
			echo "</div>";	
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_min",$min,["default"=>$data['end_min'],"class"=>"end_min form-control"]);
			echo "</div>";
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_ampm",$ampm,["default"=>$data['end_ampm'],"class"=>"end_ampm form-control"]);
			echo "</div>";
			echo "</div>";
			echo $this->Form->button(__("Add Time"),['type'=>'button','id'=>'add_time','class'=>"btn btn-flat btn-success col-md-offset-2","name"=>"add_class"]);
			echo "<br><br>";
			echo "<div class='time_list col-md-10 col-md-offset-2'>";?>
			<table class="table">
				<tr><th><?php echo __("Days");?></th><th><?php echo __("Start Time");?></th><th><?php echo __("End Time");?></th><th><?php echo __("Action");?></th></tr>
				<tbody class="time_table">
					<?php
					if($edit)
					{
						foreach($schedule_list as $schedule)
						{?>
							<tr>
								<td><?php echo implode(",",json_decode($schedule["days"]));?></td>
								<td><?php echo $schedule["start_time"];?></td>
								<td><?php echo $schedule["end_time"];?>
								<input type="hidden" name="time_list[]" value='[<?php echo $schedule["days"].",&quot;".$schedule["start_time"]."&quot;,&quot;".$schedule["end_time"] ."&quot;"; ?>]'>								
								</td>								
								<td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-danger class_sch_del_row"><i class="fa fa-times-circle"></i></span></td>
							</tr>							
					<?php }
					}?>
				</tbody>
			</table>
			<?php
			echo "</div>";			
			
			echo "<hr>";
			echo "<br>";
			echo "<br>";
			echo $this->Form->button(__("Save Class"),['class'=>"btn btn-flat btn-success col-md-offset-2","name"=>"add_class"]);
			echo $this->Form->end();
		?>
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>
<?php 
if(!$edit)
{?>
	<script>
		$(".time_list").css("display","none");
	</script>
<?php }
?>

<script>

$("#add_time").click(function(){	
	var time_list = [];
	var days = $(".day_list").val();
	if(days == null || $(".start_hrs").val() == "" || $(".end_hrs").val() == "")
	{
		alert("Please select days,start time and end time");
		return false;
	}
	$(".time_list").css("display","block");
	var json_days =  JSON.stringify(days);	
	var start_time = $(".start_hrs").val() + ":" +  $(".start_min").val() + ":" +  $(".start_ampm").val();	
	var end_time = $(".end_hrs").val() + ":" +  $(".end_min").val() + ":" +  $(".end_ampm").val();	
	time_list[0] = days;
	time_list[1] = start_time;
	time_list[2] = end_time;
	var val = JSON.stringify(time_list);	
	
	/* $(".time_list").append("<input type='text' name='time_list[]' class='ssd' value='"+val+"'>"); */
	
	$(".time_table").append('<tr><td>'+days+'</td><td>'+start_time+'</td><td>'+end_time+'<input type="hidden" name="time_list[]" value='+val+'></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-danger class_sch_del_row"><i class="fa fa-times-circle"></i></span></td></tr>');
	
});

$(document).ready(function(){
	$("body").on("click",".class_sch_del_row",function(){		
		$(this).parents("tr").remove();
	});	
});


</script>