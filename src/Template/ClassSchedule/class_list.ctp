<?php $session = $this->request->session()->read("User");?>
<script>
$(document).ready(function(){		
	$(".mydataTable").DataTable({
		"responsive": true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},	                 
	                  {"bSortable": true},	                           
	                  {"bSortable": true},	                           
	                  {"bSortable": false,"visible":false}],
	"language" : {<?php echo $this->Gym->data_table_lang();?>}	
					  
					  
	});
});		
</script>
<?php
if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member")
{ ?>
<script>

$(document).ready(function(){
	var table = $(".mydataTable").DataTable();
	table.column(5).visible( true );
});
</script>
<?php } ?>

<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-bars"></i>
				<?php echo __("Class List");?>
				<small><?php echo __("Class Schedule");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<?php
				if($session["role_name"] == "administrator" || $session["role_name"] == "member" || $session["role_name"] == "staff_member")
				{ ?>
				<a href="<?php echo $this->Gym->createurl("ClassSchedule","viewSchedule");?>" class="btn btn-flat btn-custom"><i class="fa fa-calendar"></i> <?php echo __("Class Schedules");?></a>
		   <?php }
				if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member")
				{ ?>
				&nbsp;
				<a href="<?php echo $this->Gym->createurl("ClassSchedule","addClass");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Class Schedule");?></a>
				<?php } ?>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
			<table class="mydataTable table table-striped">
			<thead>
				<tr>
					<th><?php echo __("Class Name");?></th>
					<th><?php echo __("Staff Name");?></th>
					<th><?php echo __("Starting Time");?></th>					
					<th><?php echo __("Ending Time");?></th>
					<th><?php echo __("Location");?></th>
					<th><?php echo __("Action");?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
				echo "<tr>
						<td>{$row['class_name']}</td>
						<td>{$row['gym_member']['first_name']} {$row['gym_member']['last_name']}</td>						
						<td>{$row['start_time']}</td>
						<td>{$row['end_time']}</td>
						<td>{$row['location']}</td>
						<td>
							<a href='{$this->request->base}/ClassSchedule/editClass/{$row['id']}' title='Edit' class='btn btn-flat btn-primary'><i class='fa fa-edit'></i></a>
							<a href='{$this->request->base}/ClassSchedule/deleteClass/{$row['id']}' title='Delete' class='btn btn-flat btn-danger' onClick=\"return confirm('Are you sure,You want to delete this record?');\"><i class='fa fa-trash-o'></i></a>
						</td>
					</tr>";
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php echo __("Class Name");?></th>
					<th><?php echo __("Staff Name");?></th>
					<th><?php echo __("Starting Time");?></th>					
					<th><?php echo __("Ending Time");?></th>
					<th><?php echo __("Location");?></th>
					<th><?php echo __("Action");?></th>
				</tr>
			</tfoot>
		</table>
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>