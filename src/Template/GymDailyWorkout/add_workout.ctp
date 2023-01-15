<?php
echo $this->Html->css('select2.css');
echo $this->Html->script('select2.min');
?>
<script>
$(document).ready(function(){
	// moment.locale('he');
	
	var options = {
		language: "de",
		injectStyle:false,
		squareEdges : true,
		itemWidth : 50,
		showStartOfWeek: true,
		offDays : '',
		onSelectedDateChanged: function(event, date) {			
			var assigned_dates = $("#date_range").val();
			var dates = assigned_dates.split(",");	
			var sel_date = $.datepicker.formatDate('yy-mm-dd', new Date(date));			
			$("#record_date").val(sel_date);
			
		/*	for(var i=0;i<dates.length;i++)
			{				
				$("[data-moment=2016-07-13]").addClass(" tcolor");						
			} */
	/*	// var formattedDate = new Date(date);
		
			// var sel_date = date._i;
			// var sel_date = $(".dp-selected").attr("data-moment");
			// var sel_date="";
			// $("body").on("click",".dp-item",function(){
				// sel_date = $(this).attr("data-moment");		
					// alert(sel_date);
			// });
			// console.log(formattedDate);	
			// alert(formattedDate);
			*/
			
			var uid = $("#mem_list").val();			
			var ajaxurl = $("#paginator").attr("data-url");		
			var curr_data = {sel_date:sel_date,uid:uid};
			if(uid != "")
			{
				$(".workout_area").html("<div class='work_out_datalist'><strong>Fetching data.... please wait</strong></div>");
				$.ajax({
						url:ajaxurl,
						type : "POST",
						data : curr_data,
						success:function(response){
									$(".workout_area").html(response);
									$("#note_area").show();
									for(var i=0;i<dates.length;i++)
									{			
										if(dates != "")
										{
											$("[data-moment="+dates[i]+"]").addClass(" sel_date");
										}										
									}
									$(".dp-selected").removeClass("sel_date");
								},
						error : function(e){
							alert("There was an error deleting record,Please try again later.");
							console.log(e.responseText);
						}
				});
			}else{
				alert("Please Select Member!");
			}
		}		
	};
	$('#paginator').datepaginator(options);

$(".mem_list").select2();

$("a.dp-selected").click(function(e){	
    e.preventDefault();
});

var role = $("#s_role").val();
if(role == "member")
{
	var user_id = $("#user_id").val()
	$("#mem_list").val(user_id).change();
}

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
				<small><?php echo __("Workout Daily");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymDailyWorkout","workoutList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Workout List");?></a>
				&nbsp;
				<a href="<?php echo $this->Gym->createurl("GymDailyWorkout","addMeasurment");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Measurement");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">	
		<?php
			$session = $this->request->session()->read("User");
			echo $this->Form->create("addWorkout",["class"=>"validateForm form-horizontal","role"=>"form"]);
		?>
		<div class='form-group'>
			<input type="hidden" id="s_role" value="<?php echo $session["role_name"];?>">
			<input type="hidden" id="user_id" value="<?php echo $session["id"];?>">
			<label class="control-label col-md-2" for="email"><?php echo __("Select Member");?><span class="text-danger"> *</span></label>
			<div class="col-md-8">
				<?php 
					echo $this->Form->select("member_id",$members,["default"=>($edit)?$this->request->params["pass"]:"","empty"=>__("Select Member"),"class"=>"mem_list","required"=>"true","id"=>"mem_list","data-url"=>$this->request->base ."/GymAjax/getWorkoutDates"]);
				?>
			</div>
			<div class="col-md-2">
				<a href="<?php echo $this->request->base;?>/GymMember/addMember" class="btn btn-default btn-flat"><?php echo __("Add Member");?></a>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2" for="email"><?php echo __("Select Date");?><span class="text-danger"> *</span></label>
			<div class="col-md-8" id="paginator" data-url=<?php echo $this->request->base ."/GymAjax/gymWorkoutData";?>>
				
			</div>
		</div>
	<!--	<div class='form-group'>
			<label class="control-label col-md-2" for="email"><?php echo __("Start Date");?><span class="text-danger"> *</span></label>
			<div class="col-md-8">
				<?php 
					//echo $this->Form->input("",["label"=>false,"name"=>"record_date","class"=>"date validate[required] form-control","id"=>"record_date"]);
				?>
			</div>	
		</div> -->
		<input type="hidden" name="record_date" id='record_date'>
		<div class='form-group'>
			<label class="control-label col-md-2" for="email"><?php echo __("Workout");?><span class="text-danger"> *</span></label>
			<div class="col-md-8 workout_area">
				<div class="work_out_datalist">
					<?php echo __("Select Record Date For Today Workout"); ?>
				</div>
			</div>
		</div>
		<div class="form-group" id="note_area" style="display:none">
			<label class="col-md-2 control-label" for="note"><?php echo __("Note"); ?></label>
			<div class="col-sm-6">
				<textarea id="note" class="form-control" name="note"> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-md-8">
        	<input type="submit" value="<?php echo __("Save");?>" name="save_workout" class="btn btn-flat btn-success">
        </div>
		<input type="hidden" id="date_range" disabled>
		<?php 
		$this->Form->end();
		?>
		
	<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
	
<script>

function changeColor(){		
		var assigned_dates = $("#date_range").val();		
		var dates = assigned_dates.split(",");
		for(var i=0;i<dates.length;i++)
		{				
			$("[data-moment="+dates[i]+"]").addClass(" sel_date");						
		} 
	}
</script>