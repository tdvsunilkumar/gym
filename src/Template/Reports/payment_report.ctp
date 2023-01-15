<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-bar-chart"></i>
				<?php echo __("Membership report");?>
				<small><?php echo __("Reports");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("Reports","attendanceReport");?>" class="btn btn-flat btn-custom"><i class="fa fa-bar-chart"></i> <?php echo __("Attendance Report");?></a>
				&nbsp;
				<a href="<?php echo $this->Gym->createurl("Reports","attendanceReport");?>" class="btn btn-flat btn-custom"><i class="fa fa-pie-chart"></i> <?php echo __("Membership Status Report");?></a>
				&nbsp;
				<a href="<?php echo $this->Gym->createurl("Reports","paymentReport");?>" class="btn btn-flat btn-custom"><i class="fa fa-bar-chart"></i> <?php echo __("Payment Report");?></a>
			</ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
		<?php 
		$options = Array(
			'title' => __('Fee Payment Report By Month','gym_mgt'),
			'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
			'legend' =>Array('position' => 'right',
						'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
			
			
			//'bar'  => Array('groupWidth' => '70%'),
			//'lagend' => Array('position' => 'none'),
			'hAxis' => Array(
				'title' => __('Month','gym_mgt'),
				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
				'textStyle' => Array('color' => '#66707e','fontSize' => 11),
				'maxAlternation' => 2
				
				//'annotations' =>Array('textStyle'=>Array('fontSize'=>5))
				),
			'vAxis' => Array(
				'title' => __('Fee Payment','gym_mgt'),
				 'minValue' => 0,
				'maxValue' => 5,
				 'format' => '#',
				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
				'textStyle' => Array('color' => '#66707e','fontSize' => 12)
				),
 		'colors' => array('#22BAA0') 		
		);
		
		$GoogleCharts = new GoogleCharts;
		$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );
		
		?>
    	<?php 
		 if(isset($result) && empty($result)) {?>
		  
		  <div class="clear col-md-12">
		  <i>
		  <?php echo __("There is not enough data to generate report.");?>
		  </i>
		  </div>
  <?php } ?>
    
		<div id="chart_div" style="width: 100%; height: 500px;"></div>
  
		<!-- Javascript --> 
		<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
		<script type="text/javascript">
				<?php if(!empty($result))
						{echo $chart;}?>
		</script>
 
		
		<!-- END -->
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>