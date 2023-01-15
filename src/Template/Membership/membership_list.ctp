<?php $session = $this->request->session()->read("User");?>
<script>
$(document).ready(function(){		
	$(".mydataTable").DataTable({
		"responsive": true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true,"sWidth":"1%"},
	                  {"bSortable": true,"sWidth":"1%"},
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
				<?php echo __("Membership List");?>
				<small><?php echo __("Membership");?></small>
			  </h1>
			  <?php
			if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member")
			{ ?>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("Membership","add");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Membership");?></a>
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
						<th><?php echo __("Membership Name");?></th>						
						<th><?php echo __("Membership Period");?></th>
						<th><?php echo __("Instalment Plan");?></th>
						<th><?php echo __("SignUp Fee");?></th>
						<th><?php echo __("Action");?></th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach($membership_data as $membership)
					{
						$duration = $this->Gym->get_plan_duration($membership->install_plan_id);					
						if(empty($duration))
						{
							$duration["number"] = "";
							$duration["duration"] = "";
						}
						$image = ($membership->gmgt_membershipimage !="") ? $membership->gmgt_membershipimage : "logo.png";
						echo "
						<tr id='row-{$membership->id}'>
						<td><image src='".$this->request->base ."/upload/{$image}' class='membership-img img-circle'></td>
						<td>{$membership->membership_label}</td>						
						<td>{$membership->membership_length}</td>
						<td>{$duration['number']} {$duration['duration']}</td>
						<td>". $this->Gym->get_currency_symbol() ."{$membership->signup_fee}</td>
						<td>";
						echo " <a href='{$this->Gym->createurl("Membership","editMembership")}/{$membership->id}' title='Edit' class='btn btn-flat btn-primary' ><i class='fa fa-edit'></i></a>
						<a title='Delete' did='{$membership->id}' class='del-membership btn btn-flat btn-danger' data-url='".$this->Gym->createurl("GymAjax","deleteMembership")."'><i class='fa fa-trash-o'></i></a>";
						if($session["role_name"] == "administrator")
						{ 
						echo " <a href='{$this->Gym->createurl("Membership","viewActivity")}/{$membership->id}' class='btn btn-flat btn-info'>".__("Activities")."</a>";	
						}
						echo "</td>
						</tr>
						";
					}
				?>
				</tbody>
				<tfoot>
					<tr>
						<th><?php echo __("Photo");?></th>
						<th><?php echo __("Membership Name");?></th>
						<th><?php echo __("Membership Period");?></th>
						<th><?php echo __("Instalment Plan");?></th>
						<th><?php echo __("SignUp Fee");?></th>
						<th><?php echo __("Action");?></th>
					</tr>
				</tfoot>
			</table>			
		</div>
			<div class="overlay gym-overlay">
				<i class="fa fa-refresh fa-spin"></i>
			</div>		
		</div>		
	</div>
</section>
