<?php $session = $this->request->session()->read("User");?>
<script>
$( function() {
    $( document ).tooltip();
  } );
  </script>
<script>
$(document).ready(function(){
	$(".mydataTable").DataTable({
		"responsive": true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[	                 
	                  {"bSortable": true},
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
if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member" || $session["role_name"] == "accountant")
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
				<?php echo __("Reservation List");?>
				<small><?php echo __("Reservation");?></small>
			  </h1>
			   <?php
			if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member" || $session["role_name"] == "accountant")
			{ ?>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("GymReservation","addReservation");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Reservation");?></a>
			  </ol>
			<?php } ?>
			</section>
		</div>
		<hr>
		<div class="box-body">
			<table class="mydataTable table table-striped">
			<thead>
				<tr>
					<th><?php echo __("Event Name");?></th>
					<th><?php echo __("Event Date");?></th>
					<th><?php echo __("Place");?></th>
					<th><?php echo __("Start Time");?></th>
					<th><?php echo __("Ending Time");?></th>
					<th><?php echo __("Action");?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
				echo "<tr>
					<td>{$row['event_name']}</td>
					<td>".date($this->Gym->getSettings("date_format"),strtotime($row["event_date"]))."</td>
					<td>{$row['gym_event_place']['place']}</td>
					<td>{$row['start_time']}</td>
					<td>{$row['end_time']}</td>
					<td>
						<a href='".$this->request->base ."/GymReservation/editReservation/{$row['id']}' class='btn btn-primary btn-flat' title='Edit'><i class='fa fa-edit'></i> </a>
						<a href='".$this->request->base ."/GymReservation/deleteReservation/{$row['id']}' class='btn btn-danger btn-flat' title='Delete' onclick=\"return confirm('Are you sure you want to delete this record?')\"><i class='fa fa-trash'></i></a>
					</td>
				</tr>";
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php echo __("Event Name");?></th>
					<th><?php echo __("Event Date");?></th>
					<th><?php echo __("Place");?></th>
					<th><?php echo __("Start Time");?></th>
					<th><?php echo __("Ending Time");?></th>
					<th><?php echo __("Action");?></th>
				</tr>
			</tfoot>
			</table>
			<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
