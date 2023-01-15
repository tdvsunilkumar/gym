<?php 
echo $this->Html->css('bootstrap-multiselect');
echo $this->Html->script('bootstrap-multiselect');
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#activity').multiselect({
		includeSelectAllOption: true,
		buttonWidth: '400px'
	});
	$(".mydataTable").DataTable({
	"responsive": true,
	"order": [[ 1, "asc" ]],
	"aoColumns":[
				  {"bSortable": true},
				  {"bSortable": true},				 
				  {"bSortable": true},	               
				  {"bSortable": false}],
	"language" : {<?php echo $this->Gym->data_table_lang();?>}	
	});
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<?php echo __("Membership");?>
				<small><?php echo __("View Activity");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("Membership","membershipList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Membership List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
			<div class="row">
			<?php		
			echo $this->Form->create("activity",["class"=>"validateForm"]);
			echo $this->Form->input("membership_id",["type"=>"hidden","value"=>$this->request->params['pass'][0]]);
			echo "<div class='col-md-2 text-right'>";
			echo $this->Form->label(__("Select Activity"))."&nbsp;";
			echo "</div>";
			echo "<div class='col-md-5'>";
			echo $this->Form->select('field', $activities, ['name'=>'activity_id','id'=>'activity','multiple' => 'multiple','default'=>$selected_activities]);
			echo "</div>";
			echo "<div class='col-md-4'>";
			echo $this->Form->input(__("Add Activity"),["type"=>"submit","class"=>"btn btn-flat btn-success"]);
			echo "</div>";
			echo $this->Form->end();		
			?>			
			</div>
			<hr>
			<div class="row">
			<table class="mydataTable table table-striped">
				<thead>
					<tr>
						<th><?php echo __("Activity Name");?></th>
						<th><?php echo __("Activity Category");?></th>
						<th><?php echo __("Activity Trainer");?></th>						
						<th><?php echo __("Action");?></th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach($assigned_activities as $activity)
					{
						$title = $this->Gym->get_activity_name($activity['activity_id']);				
						$category = $this->Gym->get_category_name($activity['activity']['cat_id']);				
						$staff = $this->Gym->get_staff_name($activity['activity']['assigned_to']);				
						echo "<tr>
							<td>{$title}</td>
							<td>{$category}</td>
							<td>{$staff}</td>
							<td><a href='".$this->Gym->createurl('Membership','deleteActivity')."/{$activity['id']}' class='btn btn-flat btn-danger'>Delete</a></td>
							</tr>";
					}
				?>
				</tbody>
				<tfoot>
					<tr>
						<th><?php echo __("Activity Name");?></th>
						<th><?php echo __("Activity Category");?></th>
						<th><?php echo __("Activity Trainer");?></th>						
						<th><?php echo __("Action");?></th>
					</tr>
				</tfoot>
				<tbody>
			</table>
			</div>
		</div>		
	</div>
</section>