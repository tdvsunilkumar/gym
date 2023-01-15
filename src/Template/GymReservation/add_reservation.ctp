<script type="text/javascript">
$(document).ready(function() {
	//alert('<?php echo $this->Gym->dateformat_PHP_to_jQueryUI($this->Gym->getSettings("date_format")); ?>');
	 //$(".date").datepicker( {format: '<?php echo $this->Gym->dateformat_PHP_to_jQueryUI($this->Gym->getSettings("date_format")); ?>'} );
	//$(".date").datepicker( {format: 'yyyy-mm-dd'} );
	$(".date").datepicker( "option", "dateFormat", "<?php echo $this->Gym->dateformat_PHP_to_jQueryUI($this->Gym->getSettings("date_format")); ?>" );
	<?php
	if($edit)
	{?>
	$( ".date" ).datepicker( "setDate", new Date("<?php echo date($this->Gym->getSettings("date_format"),strtotime($data['event_date'])); ?>" ));
	<?php } ?>
	// $('.date').datepicker({
     // format: {
    // toDisplay: 'dd-mm-yyyy',
    // toValue: 'yyyy-mm-dd'
      // }
	// });
	// $(".date").datepicker( {format: '<?php echo $this->Gym->dateformat_PHP_to_jQueryUI($this->Gym->getSettings("date_format")); ?>'} );
	  //$(".date").datepicker({
		// format: '<?php echo $this->Gym->getSettings("date_format"); ?>',
         // onSelect: function(dateText) {
               // var selectdate = $(this).datepicker('getDate');
			   // console.log(selectdate);
			   // console.log(dateText);
			  // $(this).datepicker( "setDate", new Date("<?php echo date($this->Gym->getSettings("date_format"), strtotime('selectdate')); ?>" ));
         // }
      //});
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-bars"></i>
				<?php echo __("Add Reservation");?>
				<small><?php echo __("Schedule");?></small>
			  </h1>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("GymReservation","reservationList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Reservation List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
		<?php
			echo $this->Form->create("reseravtion_Add",["class"=>"validateForm form-horizontal","role"=>"form"]);
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Event Name").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"event_name","class"=>"form-control validate[required]","value"=>(($edit)?$data['event_name']:'')]);
			echo "</div>";	
			echo "</div>";

			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Event Date").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"event_date","class"=>"form-control validate[required] date"]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Event Place").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';			
			echo @$this->Form->select("place_id",$event_places,["default"=>$data['place_id'],"empty"=>__("Select Event Places"),"class"=>"form-control events_place_list validate[required]"]);
			echo "</div>";	
			echo '<div class="col-md-2">';
			echo "<a href='javascript:void(0)' data-url='{$this->request->base}/GymAjax/EventPlaceList' id='eventplace_list' class='btn btn-flat btn-default'>".__("Add or Remove")."</a>";
			echo "</div>";	
			echo "</div>";			
			
			$hrs = ["0","1","2","3","4","5","6","7","8","9","10","11","12"];
			$min = ["00"=>"00","15"=>"15","30"=>"30","45"=>"45"];
			$ampm = ["AM"=>"AM","PM"=>"PM"];
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Start Time").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_hrs",$hrs,["default"=>$data['start_hrs'],"empty"=>__("Select Time"),"class"=>"form-control validate[required]"]);
			echo "</div>";	
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_min",$min,["default"=>$data['start_min'],"class"=>"form-control"]);
			echo "</div>";
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_ampm",$ampm,["default"=>$data['start_ampm'],"class"=>"form-control"]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("End Time").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_hrs",$hrs,["default"=>$data['end_hrs'],"empty"=>__("Select Time"),"class"=>"form-control validate[required]"]);
			echo "</div>";	
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_min",$min,["default"=>$data['end_min'],"class"=>"form-control"]);
			echo "</div>";
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_ampm",$ampm,["default"=>$data['end_ampm'],"class"=>"form-control"]);
			echo "</div>";
			echo "</div>";
			
			echo "<br>";
			echo $this->Form->button(__("Save Class"),['class'=>"btn btn-flat btn-success col-md-offset-2","name"=>"add_class"]);
			echo $this->Form->end();
		?>
		
		<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>