<script>
$(document).ready(function(){	

	var box_height = $(".box").height();
	var box_height = box_height + 200 ;
	$(".content-wrapper").css("height",box_height+"px");
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<?php echo __("General Settings");?>
				<small><?php echo __("Settings");?></small>
			  </h1>			
			</section>
		</div>
		<hr>
		<div class="box-body">
		<?php
		
			echo $this->Form->create("settings",["type"=>"file","class"=>"validateForm form-horizontal"]);
			
			echo "<fieldset>";
			echo "<legend>".__('System Settings')."</legend>";
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Gym Name")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";			
			echo $this->Form->input("",["name"=>"name","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['name'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Starting Year")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";	
			echo $this->Form->input("",["label"=>false,"name"=>"start_year","class"=>"form-control validate[required]","value"=> (($edit) ? $data['start_year'] : "")]);
			echo "</div>";					
			echo "</div>";					
			
			echo "<div class='form-group'>";	
			echo "<label class='control-label col-md-2'>".__("Gym Address")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";	
			echo $this->Form->input("",["label"=>false,"name"=>"address","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['address'] : "")]);
			echo "</div>";
			echo "</div>";
				
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Office Phone Number")."<span class='text-danger'>*</span></label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"office_number","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['office_number'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Country")."</label>";
			echo "<div class='col-md-8'>";
			// echo $this->Form->input("",["name"=>"country","class"=>"form-control validate[required,custom[email]]","label"=>false]);
			?>
			
			<select id="country" class="form-control" name="country">
				<?php 
				foreach($xml as $country)
				{ ?>
					<option value="<?php echo $country->code;?>" <?php echo ($edit && $data['country'] == $country->code) ? "selected" : ""; ?>><?php echo $country->name;?></option>
		  <?php } ?>	
				</select>
			<?php
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>". __("System Language")."</label>";
			echo "<div class='col-md-8'>";
			$sys_language = $this->Gym->getSettings("sys_language");
			
			?>
				<?php echo "<input type='hidden' id='s_lang' value='{$sys_language}'>";?>
				<select id="sys_language" class="form-control" name="sys_language">
					<option value="en">English/en</option>
					<option value="ar">Arabic/ar</option>
					<option value="zh_CH">Chinese/zh-CH</option>
					<option value="cs">Czech/cs</option>
					<option value="fr">French/fr</option>
					<option value="de">German/de</option>
					<option value="el">Greek/el</option>					
					<option value="it">Italian/it</option>	
					<option value="ja">Japan/ja</option>
					<option value="pl">Polish/pl</option>
					<option value="pt_BR">Portuguese-BR/pt-BR</option>
					<option value="pt_PT">Portuguese-PT/pt-PT</option>						
					<option value="fa">Persian</option>
					<option value="ru">Russian/ru</option>
					<option value="es">Spanish/es</option>											
					<option value="th">Thai/th</option>
					<option value="tr">Turkish/tr</option>
				</select>
				<script>
					var sys_lang = $("#s_lang").val();
					$("#sys_language option[value="+sys_lang+"]").prop("selected",true);
				</script>
			<?php
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Set Language to RTL")."</label>";
			echo "<div class='col-md-8 checkbox'><label class=''>";
			echo $this->Form->checkbox("enable_rtl",["value"=>"1","checked"=>(($edit && $data['enable_rtl'] == true)? true : false)])." ".__("Enable");
			echo "</label></div>";
			echo "</div>";	
			
			echo "<div class='form-group'>";			
			echo "<label class='control-label col-md-2'>".__("Date Picker Language")."</label>";
			echo "<div class='col-md-8'>";	
			$datepicker_lang = ($edit && !empty($data['datepicker_lang'])) ? $data['datepicker_lang'] : "en-CA";
			?>
				<input type="hidden" value="<?php echo $datepicker_lang;?>" id="datepicker_lang">
				<select id="datepicker-lang-selector" name="datepicker_lang" class="form-control">
					<option value="en-CA">en</option>
					<option value="ar">ar</option>
					<option value="az">az</option>
					<option value="bg">bg</option>
					<option value="ca">ca</option>
					<option value="cs">cs</option>
					<option value="cy">cy</option>
					<option value="da">da</option>
					<option value="de">de</option>
					<option value="el">el</option>
					<option value="es">es</option>
					<option value="fa">fa</option>
					<option value="fr">fr</option>
					<option value="gl">gl</option>
					<option value="he">he</option>
					<option value="hr">hr</option>
					<option value="hu">hu</option>
					<option value="it">it</option>
					<option value="ja">ja</option>
					<option value="ro">ro</option>
					<option value="sv">sv</option>
					<option value="sw">sw</option>
					<option value="th">th</option>
					<option value="tr">tr</option>
					<option value="ua">ua</option>
					<option value="vi">vi</option>
					<option value="zh-CN">zh-CN</option>
					<option value="zh-TW">zh-TW</option>
				</select>
				<script>
					var lang = $("#datepicker_lang").val();
					$("#datepicker-lang-selector option[value="+lang+"]").prop("selected",true);
				</script>
			<?php
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Email")."<span class='text-danger'>*</span></label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"email","class"=>"form-control validate[required,custom[email]]","label"=>false,"value"=> (($edit) ? $data['email'] : "")]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Date Formate")."</label>";
			echo "<div class='col-md-8'>";				
			// $format = ["yy/mm/dd"=>"yy/mm/dd","dd/mm/yy"=>"dd/mm/yy","mm/dd/yy"=>"mm/dd/yy","yyyy/mm/dd"=>"yyyy/mm/dd","mm/dd/yyyy"=>"mm/dd/yyyy"];
			// $format = ["Y-m-d"=>"yyyy-m-d","d-m-Y"=>"d-m-yyyy","m-d-y"=>"m-d-yyyy"];
			// $format = ["F j, Y"=>date("F j, Y"),"Y-m-d"=>date("Y-m-d"),"m/d/Y"=>date("m/d/Y"),"d/m/Y"=>date("d/m/Y")]; 18-11-2017
			$format = ["F j, Y"=>date("F j, Y"),"Y-m-d"=>date("Y-m-d"),"m/d/Y"=>date("m/d/Y")];
			
			$default = ($edit && !empty($data['date_format'])) ? [$data['date_format']] : ['yy/mm/dd'];
			echo $this->Form->select("date_format",$format,["default"=>$default,"class"=>"form-control plan_list validate[required]"]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";			
			echo "<label class='control-label col-md-2'>".__("Calendar Language")."</label>";
			echo "<div class='col-md-8'>";	
			$lang = ($edit && !empty($data['calendar_lang'])) ? $data['calendar_lang'] : "en";
			?>
				<input type="hidden" value="<?php echo $lang;?>" id="dashboard_lang">
				<select id="lang-selector" name="calendar_lang" class="form-control">
					<option value="en">en</option>
					<option value="ar-ma">ar-ma</option>
					<option value="ar-sa">ar-sa</option>
					<option value="ar-tn">ar-tn</option>
					<option value="ar">ar</option>
					<option value="bg">bg</option>
					<option value="ca">ca</option>
					<option value="cs">cs</option>
					<option value="da">da</option>
					<option value="de-at">de-at</option>
					<option value="de">de</option>
					<option value="el">el</option>
					<option value="en-au">en-au</option>
					<option value="en-ca">en-ca</option>
					<option value="en-gb">en-gb</option>
					<option value="en-ie">en-ie</option>
					<option value="en-nz">en-nz</option>
					<option value="es">es</option>
					<option value="eu">eu</option>
					<option value="fa">fa</option>
					<option value="fi">fi</option>
					<option value="fr-ca">fr-ca</option>
					<option value="fr-ch">fr-ch</option>
					<option value="fr">fr</option>
					<option value="gl">gl</option>
					<option value="he">he</option>
					<option value="hi">hi</option>
					<option value="hr">hr</option>
					<option value="hu">hu</option>
					<option value="id">id</option>
					<option value="is">is</option>
					<option value="it">it</option>
					<option value="ja">ja</option>
					<option value="ko">ko</option>
					<option value="lb">lb</option>
					<option value="lt">lt</option>
					<option value="lv">lv</option>
					<option value="nb">nb</option>
					<option value="nl">nl</option>
					<option value="nn">nn</option>
					<option value="pl">pl</option>
					<option value="pt-br">pt-br</option>
					<option value="pt">pt</option>
					<option value="ro">ro</option>
					<option value="ru">ru</option>
					<option value="sk">sk</option>
					<option value="sl">sl</option>
					<option value="sr-cyrl">sr-cyrl</option>
					<option value="sr">sr</option>
					<option value="sv">sv</option>
					<option value="th">th</option>
					<option value="tr">tr</option>
					<option value="uk">uk</option>
					<option value="vi">vi</option>
					<option value="zh-cn">zh-cn</option>
					<option value="zh-tw">zh-tw</option>
				</select>
				
				<script>
					var lang = $("#dashboard_lang").val();
					$("#lang-selector option[value="+lang+"]").prop("selected",true);
				</script>
			<?php
			echo "</div>";
			echo "</div>";	

			#########################################################################
			echo "<div class='form-group'>";			
			echo "<label class='control-label col-md-2'>".__("Time Zone")."</label>";
			echo "<div class='col-md-8'>";	
			$time_zone = ($edit && !empty($data['time_zone'])) ? $data['time_zone'] : date_default_timezone_get();
			?>
				<input type="hidden" value="<?php echo $time_zone;?>" id="timezone_val">
				<select id="timezone-selector" name="time_zone" class="form-control">
					<?php
						// foreach($timezone as $key=>$value)
						// {
							// $selected = ($value == $data['time_zone'])?'selected':'';
							// echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
						// }
						foreach(timezone_abbreviations_list() as $abbr => $timezone){
								foreach($timezone as $val)
								{
										if(isset($val['timezone_id']))
										{
												// var_dump($abbr,$val['timezone_id']);
											$selected = ($val['timezone_id'] == $data['time_zone'])?'selected':'';
											echo '<option value="'.$val['timezone_id'].'" '.$selected.'>'.$val['timezone_id'].'</option>';
										}
								}
						}
					?>
				</select>
			<?php
			echo "</div>";
			echo "</div>";	
			
			echo "<div class='form-group'>";			
			echo "<label class='control-label col-md-2'>".__("Gym Logo")."</label>";
			echo "<div class='col-md-6'>";			
			echo $this->Form->file("",["name"=>"gym_logo","class"=>"form-control"]);
			echo "</div>";
			echo "<div class='col-md-2'>";	
			echo "(Max. height 50px.)";
			echo "</div>";		
			
			echo "</div>";		
			
			$src = ($edit && !empty($data['gym_logo'])) ? $data['gym_logo'] : "logo.png" ; 
			echo "<div class='col-md-offset-2'>";
			echo $this->Form->input("",["type" => "hidden","name"=>"old_gym_logo","class"=>"form-control","value"=>$src]);
			echo "<img src='{$this->request->webroot}webroot/upload/{$src}'><br><br><br>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Cover Image")."</label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->file("",["name"=>"cover_image","class"=>"form-control"]);
			echo "</div>";
			echo "</div>";
			
			$src = ($edit && !empty($data['cover_image'])) ? $data['cover_image'] : "cover-image.png" ;
			echo $this->Form->input("",["type" => "hidden","name"=>"old_cover_image","class"=>"form-control","value"=>$src]);
			echo "<img src='{$this->request->webroot}webroot/upload/{$src}'>";			
			echo "</fieldset><br><br>";
			
			echo "<fieldset>";
			echo "<legend>".__('Measurement Units')."</legend>";
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Weight")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";			
			echo $this->Form->input("",["label"=>false,"name"=>"weight","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['weight'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Height")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";			
			echo $this->Form->input("",["label"=>false,"name"=>"height","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['height'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Chest")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";				
			echo $this->Form->input("",["label"=>false,"name"=>"chest","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['chest'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Waist")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"waist","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['waist'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Thing")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"thing","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['thing'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Arms")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"arms","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['arms'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Fat")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";			
			echo $this->Form->input("",["label"=>false,"name"=>"fat","class"=>"form-control validate[required]","label"=>false,"value"=> (($edit) ? $data['fat'] : "")]);
			echo "</div>";
			echo "</div>";
			echo "</fieldset><br><br>";
			
			echo "<fieldset>";
			echo "<legend>".__('Member Privacy Setting')."</legend>";
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Member can view other member's details")."</label>";
			echo "<div class='col-md-8 checkbox'><label class='radio-inline'>";	
			echo $this->Form->checkbox("member_can_view_other",["value"=>"1","checked"=>(($edit && $data['member_can_view_other'] == true)? true : false)]);
			echo " ". __("Enable");
			echo "</label></div></div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Staff Member can view own trainee member's details")."</label>";
			echo "<div class='col-md-8 checkbox'><label class='radio-inline'>";	
			echo $this->Form->checkbox("staff_can_view_own_member",["value"=>"1","checked"=>(($edit && $data['staff_can_view_own_member'] == true)? true : false)]);
			echo " ". __("Enable");
			echo "</label></div></div>";
			
			echo "</fieldset><br><br>";			
			
			echo "<fieldset>";
			echo "<legend>".__('Paypal Setting')."</legend>";
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Enable Sandbox")."</label>";
			echo "<div class='col-md-8 checkbox'><label class='radio-inline'>";			
			echo $this->Form->checkbox("enable_sandbox",["value"=>"1","checked"=>(($edit && $data['enable_sandbox'] == true)? true : false)])." ".__("Enable");
			echo "</label></div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Paypal Email Id")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";	
			echo $this->Form->input("",["label"=>false,"name"=>"paypal_email","class"=>"form-control validate[required]","label"=>false,"value"=>(($edit) ? $data['paypal_email'] : "")]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Select Currency")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";
			// echo $this->Form->input("",["name"=>"paypal_email","class"=>"form-control validate[required]","label"=>false]);
			echo "<select class='form-control' name='currency'>";
			foreach($currency_xml as $curr)
			{?>
				<option value='<?php echo $curr['@code'];?>' <?php echo($edit && $data['currency'] == $curr['@code']) ? "selected" : "";?>><?php echo $curr["@"];?></option>				
	<?php	}			
			echo "</select>";
			echo "</div>";
			echo "</div>";
			echo "</fieldset><br><br>";	
			
			echo "<fieldset>";
			echo "<legend>".__('Membership Alert Message Setting')."</legend>";
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Enable Alert Mail")."</label>";
			echo "<div class='col-md-8 checkbox'><label class='radio-inline'>";
			echo $this->Form->checkbox("enable_alert",["value"=>"1","checked"=>(($edit && $data['enable_alert'] == true)? true : false)])." ".__("Enable");
			echo "</label></div>";
			echo "</div>";			
			
			echo "<div class='form-group'>";			
			echo "<label class='control-label col-md-2'>".__("Reminder Before Days")."</label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"reminder_days","class"=>"form-control","value"=>(($edit) ? $data['reminder_days'] : "")]);
			echo "</div>";
			echo "</div>";			
			
			
			echo "<div class='form-group'>";						
			echo "<label class='control-label col-md-2'>".__("Reminder Message")."</label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->textarea("",["name"=>"reminder_message","class"=>"form-control","value"=>(($edit) ? $data['reminder_message'] : "")]);
			echo "</div>";			
			echo "</div>";
	
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("ShortCodes For Notification Mail Message")."</label>";
			echo "<div class='col-md-8 checkbox'><label class='radio-inline'>";
			echo  "<p>". __("Member Name")." -> GYM_MEMBERNAME<p>";
			echo  "<p>". __("Membership Name")." -> GYM_MEMBERSHIP  <p>";
			echo  "<p>". __("Membership Start Date")." -> GYM_STARTDATE <p>";
			echo  "<p>". __("Membership End Date")." -> GYM_ENDDATE<p>";
			echo "</label></div>";
			echo "</div>";
			
			echo "</fieldset><br><br>";	
			
			echo "<fieldset>";
			echo "<legend>".__('Message Setting')."</legend>";
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-2'>".__("Member can Message To other's")."</label>";
			echo "<div class='col-md-8 checkbox'><label class='radio-inline'>";			
			echo $this->Form->checkbox("enable_message",["value"=>"1","checked"=>(($edit && $data['enable_message'] == true)? true : false)])." ".__("Enable");
			echo "</label></div></div>";
			echo "</fieldset><br><br>";	
			
			echo "<fieldset>";
			echo "<legend>".__('Header & Footer Text')."</legend>";
			echo "<div class='form-group'>";			
			echo "<label class='control-label col-md-2'>".__("Left Header Text")."</label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"left_header","class"=>"form-control","value"=>(($edit) ? $data['left_header'] : "")]);
			echo "</div>";
			echo "</div>";	
			
			echo "<div class='form-group'>";			
			echo "<label class='control-label col-md-2'>".__("Footer Text")."</label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"footer","class"=>"form-control","value"=>(($edit) ? $data['footer'] : "")]);
			echo "</div>";
			echo "</div>";				
			echo "</fieldset><br><br>";	
			
			
			echo $this->Form->button(__("Save Settings"),['class'=>"btn btn-flat btn-success","name"=>"save_setting"]);
			echo $this->Form->end();
			// echo "<br><br><br>";
		?>	
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>