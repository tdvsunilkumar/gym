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
	                  {"bSortable": true},
	                  {"bSortable": true},	                           
	                  {"bSortable": false,"visible":false},
	                  {"bSortable": false,"visible":false}],
		"language" : {<?php echo $this->Gym->data_table_lang();?>}
	});
});		
</script>
<?php
if($session["role_name"] == "administrator" || $session["role_name"] == "member" || $session["role_name"] == "staff_member")
{ ?>
<script>
$(document).ready(function(){
	var table = $(".mydataTable").DataTable();
	table.column(7).visible( true );
});
</script>
<?php } 

if($session["role_name"] == "administrator")
{?>
<script>
$(document).ready(function(){
	var table = $(".mydataTable").DataTable();
	table.column(8).visible( true );
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
				<?php echo __("Members List");?>
				<small><?php echo __("Member");?></small>
			  </h1>
			   <?php
				if($session["role_name"] == "administrator")
				{ ?>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymMember","addMember");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Member");?></a>
			  </ol>
			   <?php } ?>
			</section>
		</div>
		<hr>
		<div class="box-body">
		<table class="mydataTable table table-striped">
			<thead>
				<tr>
					<th><?php echo __("Photo");?></th>
					<th><?php echo __("Member Name");?></th>
					<th><?php echo __("Member ID");?></th>					
					<th><?php echo __("Joining Date");?></th>					
					<th><?php echo __("Expire Date");?></th>					
					<th><?php echo __("Member Type");?></th>					
					<th><?php echo __("Membership Status");?></th>					
					<th><?php echo __("Action");?></th>
					<th><?php echo __("Status");?></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($data as $row)
				{
					echo "<tr>
					<td><img src='{$this->request->base}/webroot/upload/{$row['image']}' class='membership-img img-circle'></td>
					<td>{$row['first_name']} {$row['last_name']}</td>
					<td>{$row['member_id']}</td>
					<td>".(($row['membership_valid_from'] != '')?date($this->Gym->getSettings("date_format"),strtotime($row['membership_valid_from'])):'Null')."</td>
					<td>".(($row['membership_valid_to'] != '')?date($this->Gym->getSettings("date_format"),strtotime($row['membership_valid_to'])):'Null')."</td>
					<td>{$row['member_type']}</td>
					<td>{$row['membership_status']}</td>
					<td>
					
						<a href='{$this->request->base}/GymMember/viewMember/{$row['id']}' title='View' class='btn btn-flat btn-info'><i class='fa fa-eye'></i></a>";
					if($session["role_name"] == "administrator")
					{	
					echo " <a href='{$this->request->base}/GymMember/editMember/{$row['id']}' title='Edit' class='btn btn-flat btn-primary'><i class='fa fa-edit'></i></a>
						<a href='{$this->request->base}/GymMember/deleteMember/{$row['id']}' title='Delete' class='btn btn-flat btn-danger' onClick=\"return confirm('Are you sure,You want to delete this record?');\"><i class='fa fa-trash-o'></i></a>";
					}
					echo " <a href='{$this->request->base}/GymMember/viewAttendance/{$row['id']}' title='Attendance' class='btn btn-flat btn-default'><i class='fa fa-eye'></i> Attendance</a>";
					
					echo "</td>
						  <td>";
						if($row["activated"] == 0)
						{
							echo "<a class='btn btn-success btn-flat' onclick=\"return confirm('Are you sure,you want to activate this account?');\" href='".$this->request->base ."/GymMember/activateMember/{$row['id']}'>".__('Activate')."</a>";
						}else{
							echo "<span class='btn btn-flat btn-default'>".__('Activated')."</span>";
						}
					echo "</td>
					</tr>";
				}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php echo __("Photo");?></th>
					<th><?php echo __("Member Name");?></th>
					<th><?php echo __("Member ID");?></th>					
					<th><?php echo __("Joining Date");?></th>					
					<th><?php echo __("Expire Date");?></th>					
					<th><?php echo __("Member Type");?></th>					
					<th><?php echo __("Membership Status");?></th>					
					<th><?php echo __("Action");?></th>
					<th><?php echo __("Status");?></th>
				</tr>
			</tfoot>
		</table>
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>
