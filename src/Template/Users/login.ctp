<div class="container-gym">
  <div class="info">
    <h1><?php echo $this->Gym->getSettings("name");?></h1>
  </div>
</div>
<?php 
$logo =$this->Gym->getSettings("gym_logo");
$logo = (!empty($logo)) ? $this->request->base ."/webroot/upload/" . $logo : $this->request->base ."/webroot/img/Thumbnail-img2.png";
?>
<div class="form">
  <div class="logo"><img src="<?php echo $logo;?>"/></div>
 <!-- <form class="register-form">
    <input type="text" placeholder="name"/>
    <input type="password" placeholder="password"/>
    <input type="text" placeholder="email address"/>
    <button>create</button>
    <p class="message">Already registered? <a href="#">Sign In</a></p>
  </form> -->
  <form class="register-form">
	 <div class="logging"><?php echo __("Logging you in"); ?>
   <i class="fa-li fa fa-spinner fa-spin"></i>
	</div>
  </form>
  <form class="login-form" method="post"> 
  <?php //echo $this->Form->create(["class"=>"login-form","method"=>"post","action"=>"GymLogin/index"]);?>
    <input type="text" placeholder="<?php echo __("Username");?>" name="username" />
    <input type="password" placeholder="<?php echo __("Password");?>" name="password"/>
    <button id="btn_login"><?php echo __("Login");?></button>
   <p class="message"><a href="<?php echo $this->request->base;?>/MemberRegistration/"><?php echo __("Member Registration");?></a>
   <!--&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#">View Plan</a></p> -->
  </form>
   <?php //echo $this->Form->end();?>
</div>


<?php echo $this->Html->script('jQuery/jQuery-2.1.4.min.js');?>
<script>
$("#btn_login").click(function(){
	$('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

$(document).load(function(){
	/* $("div.message").hide(); */
});
$('.message a').click(function(){
	/* $('form').animate({height: "toggle", opacity: "toggle"}, "slow"); */
});
$("div.message").click(function(){
	/* $(this).slideUp("slow"); */
});
</script> 

