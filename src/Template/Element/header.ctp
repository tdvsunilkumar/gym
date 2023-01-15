<head>
   <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>
	<?php 
		echo $this->Html->css('bootstrap.min');
		
		$session = $this->request->session();
		if($session->read("User.is_rtl") == "1")
		{
			echo $this->Html->css('bootstrap-rtl.min');
			echo $this->Html->css('AdminLTE-rtl.min');
			echo "<style>
					div.success,div.error{
						right : 15px;
					}
				  </style>";
		}
		else
		{
			echo $this->Html->css('AdminLTE.min');
		}
		// echo $this->Html->css('adminlte.min');
		// echo $this->Html->css('skins/_all-skins.min');
		
		// echo $this->Html->css('skins/skin-black');
		echo $this->Html->css('skins/skin-green.min');
		// echo $this->Html->css('plugins/iCheck/flat/blue');
		
		echo $this->Html->css('plugins/morris/morris');
		echo $this->Html->css('plugins/jvectormap/jquery-jvectormap-1.2.2');
		echo $this->Html->css('plugins/datepicker/datepicker3');
		echo $this->Html->css('plugins/daterangepicker/daterangepicker-bs3');
		echo $this->Html->css('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min');
		echo $this->Html->css('validationEngine/validationEngine.jquery');
		// echo $this->Html->css('plugins/datatables/dataTables.bootstrap');	
		echo $this->Html->css('dataTables.css');	
		echo $this->Html->css('jquery-ui.css');	
		echo $this->Html->css('bootstrap-datepaginator');
		echo $this->Html->meta('icon') ;
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('gym_custom');
		echo $this->Html->css('gym_responsive');
		/* echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') */ 
		echo $this->Html->css('ionicons.min.css');
		
   
		
		echo $this->Html->script('raphael-min');
		echo $this->Html->script('moment.min') ;
		$dtp_lang = $session->read("User.dtp_lang");
		if($this->request->action == "addWorkout")
		{ ?> 
		<script>moment.locale('<?php echo $dtp_lang;?>');</script>
		<?php } 
		echo $this->Html->script('jQuery/jQuery-2.1.4.min.js');
		echo $this->Html->script('bootstrap/js/bootstrap.min.js') ;
		echo $this->Html->script('jquery-ui.min') ;
		echo $this->Html->script('morris/morris.js');
		echo $this->Html->script('morris/morris.min.js');
		// echo $this->Html->script('sparkline/jquery.sparkline.min.js');
		echo $this->Html->script('jvectormap/jquery-jvectormap-1.2.2.min.js') ;
		echo $this->Html->script('jvectormap/jquery-jvectormap-world-mill-en.js') ;
		echo $this->Html->script('knob/jquery.knob.js') ;
		echo $this->Html->script('daterangepicker/daterangepicker.js');
		
		echo $this->Html->script('bootstrap-datepaginator');
		// echo $this->Html->script('datepicker/bootstrap-datepicker.js');		
		
		// echo $this->Html->script("datepicker/locales/bootstrap-datepicker.{$dtp_lang}");
		
		echo $this->Html->script('datatables/jquery.dataTables.min.js'); 
		echo $this->Html->script('bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
		echo $this->Html->script('slimScroll/jquery.slimscroll.min.js');
		echo $this->Html->script('fastclick/fastclick.min.js');
		
		?>
		<script>
  var AdminLTEOptions = {
    //Enable sidebar expand on hover effect for sidebar mini
    //This option is forced to true if both the fixed layout and sidebar mini
    //are used together
    sidebarExpandOnHover: false,
    //BoxRefresh Plugin
    enableBoxRefresh: true,
    //Bootstrap.js tooltip
    enableBSToppltip: false
	 // BSTooltipSelector: "[data-toggle='tooltip']"
  };
</script>
		<?php
		echo $this->Html->script('app.min.js');
		// echo $this->Html->script('app.js');
		echo $this->Html->script('validationEngine/languages/jquery.validationEngine-en');
		echo $this->Html->script('validationEngine/jquery.validationEngine'); 
		echo $this->Html->script('gym_ajax'); 
		//echo $this->Html->script('pages/dashboard2.js');  //JQ Validation Engine not working with this JS.
		// echo $this->Html->script('demo.js');
	

		echo $this->fetch('meta'); 
		echo $this->fetch('css');
		echo $this->fetch('script');
		 //echo $this->CKEditor->loadJs();
	?>
	
	<script>
		$(document).ready(function(){
			$(".validateForm").validationEngine(); /* {binded:false} */
			$('.textarea').wysihtml5();
			$(".dataTable").dataTable({
				/* "language": {
                "url": "dataTables.german.lang"
				} */			
            });
			$(".dob").datepicker({ maxDate: new Date()});
			$(".hasDatepicker,.datepick,.date,.mem_valid_from,.sell-date,.dob,.hasdatepicker,.datepicker-days").datepicker({ language: "<?php echo $dtp_lang;?>"});	
		
		});		
	</script>
</head>