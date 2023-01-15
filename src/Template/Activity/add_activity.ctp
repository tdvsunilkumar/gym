<?php
echo $this->Html->css('bootstrap-multiselect');
echo $this->Html->script('bootstrap-multiselect');
?>
<script>
$(document).ready(function(){
	// $(".validateForm").validationEngine();
	$('.membership_list').multiselect({
		includeSelectAllOption: true	
	});
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-bicycle"></i>
				<?php echo $title;?>
				<small><?php echo __("Activity");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("Activity","activityList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Activity List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
		<?php 
			echo $this->Form->create("addactivity",["class"=>"validateForm form-horizontal","role"=>"form"]);
		?>			
		<div class='form-group'>
			<label class="control-label col-md-3" for="email"><?php echo __("Select Category");?><span class="text-danger"> *</span></label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->select("cat_id",$categories,["default"=>($edit)?array($data['cat_id']):"","empty"=>__("Select Category"),"class"=>"validate[required] cat_list form-control"]);
				?>
			</div>
			<div class="col-md-2">
			<button class="form-control add_category btn btn-default btn-flat" type="button" data-url="<?php echo $this->Gym->createurl("GymAjax","addCategory"); ?>"><?php echo __("Add Category");?></button>
			</div>
		</div>
		<div class='form-group'>
			<label class="control-label col-md-3" for="email"><?php echo __("Activity Title");?><span class="text-danger"> *</span></label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input("",["label"=>false,"name"=>"title","class"=>"validate[required] form-control","value"=>(($edit)?$data['title']:"")]);
				?>
			</div>	
		</div>
		<div class='form-group'>
			<label class="control-label col-md-3" for="email"><?php echo __("Assign to Staff Member");?><span class="text-danger"> *</span></label>
			
			<div class="col-md-6">
				<?php 
					echo $this->Form->select("assigned_to",$staff,["default"=>($edit)?array($data['assigned_to']):"","empty"=>__("Select Staff Member"),"class"=>"validate[required] form-control"]);
				?>
			</div>
			
			<?php if($role == 'administrator'){ ?>
			<div class="col-md-3">
				<a href="<?php echo $this->request->base;?>/StaffMembers/addStaff" class="btn btn-flat btn-default"><?php echo __("Add Staff Member");?></a>
			</div>
			<?php } ?>
		</div>
		<div class='form-group'>
			<label class="control-label col-md-3" for="email"><?php echo __("Select Membership");?><span class="text-danger"> *</span></label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->select("membership_id",$membership,["default"=>($edit)?$data['membership_ids']:"","multiple"=>"multiple","class"=>"validate[required] form-control membership_list"]);
				?>
			</div>
			<div class="col-md-3">
				<a href="<?php echo $this->request->base;?>/Membership/add" class="btn btn-flat btn-default"><?php echo __("Add Membership");?></a>
			</div>			
		</div>
		<?php 
		echo $this->Form->button(__("Save Activity"),['class'=>"col-md-offset-3 btn btn-flat btn-success","name"=>"add_activity"]);
					
		echo $this->Form->end();?>
		<br><br>
		</div>
	</div>
</section>