<script>
$(document).ready(function(){	
	
	var box_height = $(".box").height();
	var box_height = box_height + 300 ;
	$(".content-wrapper").css("height",box_height+"px");
	$(".content-wrapper").css("min-height","500px");
});		
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-object-group"></i>
				<?php echo $title;?>
				<small><?php echo __("Group");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymGroup","GroupList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Group List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
			<div class="col-md-6">
			<?php
			
			echo $this->Form->create("addgroup",["type"=>"file","class"=>"validateForm"]);
			
			echo "<div class='form-group'>";							
			echo $this->Form->input(__("Group Name"),["name"=>"name","class"=>"form-control validate[required]","value"=>(($edit)?$data['name']:'')]);
			echo "</div>";	
			
			echo "<div class='form-group'>";		
			echo $this->Form->label(__("Group Image"));
			echo $this->Form->file("image",["class"=>"form-control"]);
			echo "</div>";				
			
			$url =  (isset($data['image']) && $data['image'] != "") ? $this->request->webroot ."/upload/" . $data['image'] : $this->request->webroot ."/upload/logo.png";
			echo "<img src='{$url}' class='membership-img'>";
			echo "<br><br>";
			
			echo $this->Form->button(__("Save Group"),['class'=>"btn btn-flat btn-primary","name"=>"add_group"]);
			echo $this->Form->end();
			?>
			</div>	
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>