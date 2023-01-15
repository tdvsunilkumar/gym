<!DOCTYPE html>
<html >
  <head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= $this->Html->charset() ?>    
    <title>      
      <?php echo $this->Gym->getSettings("name");
	  ?>
	  
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
   

    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
	<link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Montserrat:400,700'>
	    
	<?php 
		echo $this->Html->css('login/css/reset');
		echo $this->Html->css('login/css/style');
		echo $this->Html->css('font-awesome.min');		   
	?>    
	 <?= $this->fetch('script') ?>
	 <?= $this->fetch('meta'); ?>
	 <style>
	 html { height:auto;}
	 </style>
  </head>
<body>   
<?= $this->Flash->render() ?>
<?= __($this->Flash->render('auth')) ?> 
<?= $this->fetch('content') ?>

<footer style="color:#fff;">

</footer>

</body>
</html>
