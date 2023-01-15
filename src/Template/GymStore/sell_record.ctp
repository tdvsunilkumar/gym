<script>
$(document).ready(function(){		
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
				<i class="fa fa-bars"></i>
				<?php echo __("Sell Records");?>
				<small><?php echo __("Store");?></small>
			  </h1>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("GymStore","sellProduct");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Sell Product");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
			<table class="mydataTable table table-striped">
			<thead>
				<tr>
					<th><?php echo __("Product Name");?></th>
					<th><?php echo __("Member Name");?></th>
					<th><?php echo __("Product Quantity");?></th>
					<th><?php echo __("Action");?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
				echo "<tr>";
				echo "<td>{$row['gym_product']['product_name']}</td>
					  <td>{$row['gym_member']['first_name']} {$row['gym_member']['last_name']}</td>
					  <td>{$row['quantity']}</td>
					  <td>
						<a href='".$this->request->base ."/GymStore/editRecord/{$row['id']}' class='btn btn-flat btn-primary' title='".__('Edit')."'><i class='fa fa-edit'></i></a>";
				if($role == 'administrator')
				{		
				echo "<a href='{$this->request->base}/GymStore/deleteRecord/{$row['id']}' class='btn btn-flat btn-danger' title='".__('Delete')."' onclick=\"return confirm('Are you sure you want to delete this product?')\"><i class='fa fa-trash'></i></a>";
				}
				echo "</td>";
				echo "</tr>";
			}
			?>
			<tfoot>
				<tr>
					<th><?php echo __("Product Name");?></th>
					<th><?php echo __("Member Name");?></th>
					<th><?php echo __("Product Quantity");?></th>
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
