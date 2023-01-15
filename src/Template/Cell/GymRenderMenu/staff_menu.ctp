<?php $session = $this->request->session(); ?>
  <br>
  <!-- <div class="user-panel">
	<div class="pull-left image">
	  <?php //echo $this->Html->image('user2-160x160.jpg',array("class"=>"img-circle","alt"=>"User Image")); ?>
	</div>
	<div class="pull-left info">
	  <p><?php //echo $session->read("User.display_name");?></p>
	  <a href="#"><i class="fa fa-circle text-success"></i> <?php //echo __("Online");?></a>
	</div>
  </div> -->
  <br>
  <ul class="sidebar-menu">
	<li class= "treeview <?php echo ($this->request->controller == "Dashboard") ? "active" : "";?>">
	  <a href="<?php echo $this->Gym->createurl("Dashboard","index");?>">
		<i class="icone"><img src="<?php echo $this->request->base ."/webroot/img/icon/dashboard.png";?>"></i>
		<span>&nbsp;<?php echo __('Dashboard');?></span>
	  </a>             
	</li>
	<?php 
	$img_path = $this->request->base ."/webroot/img/icon/";
	foreach($menus as $menu)
	{?>
		<li class= "treeview <?php echo ($this->request->controller == $menu["controller"]) ? "active" : "";?>">
			<a href="<?php echo $menu["page_link"]; ?>">
				<i class="icone"><img src="<?php echo $img_path.$menu["menu_icon"];?>"></i>
				<span>&nbsp;<?php echo __($menu["menu_title"]);?></span> 
			</a>             
		</li>
		
<?php } ?>	
  </ul>

