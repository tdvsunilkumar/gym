<?php
namespace App\View\Helper;
use Cake\ORM\TableRegistry; 
use Cake\View\Helper;
use  Cake\Utility\Xml; 
// use Cake\Datasource\ConnectionManager;


Class GymHelper extends Helper
{
	var $helpers = array('Url'); //Loading Url Helper
	
	public function createurl($controller,$action)
	{
		return $this->Url->build(["controller" => $controller,"action" => $action]);		
	}
	
	public function get_plan_duration($id)
	{		
		$plan_table = TableRegistry::get("Installment_Plan");		
		$plan_duration = $plan_table->find()->where(["id"=>$id])->hydrate(false);		
		$plan_duration = $plan_duration->toArray();
		if(!empty($plan_duration))
		{	
			return $plan_duration[0];		
		}
	}
	
	public function get_activity_name($id)
	{
		$activity_table = TableRegistry::get("Activity");
		$title = $activity_table->find()->where(["id"=>$id])->select(['title'])->hydrate(false);
		$title = $title->toArray();
		if(!empty($title))
		{
			return $title[0]['title'];
		}		
	}
	
	public function getSettings($key)
	{
		$settings = TableRegistry::get("GeneralSetting");
		$row = $settings->find()->all();
		$row = $row->first()->toArray();	
		$value = "";
		switch($key)
		{
			CASE "name";
				$value =  $row[$key];
			break;
			CASE "gym_logo";
				$value = $row[$key];
			break;
			CASE "date_format";
				$value = $row[$key];
			break;
			CASE "country";
				$value = $row[$key];
			break;
			CASE "member_can_view_other";
				$value = $row[$key];
			break;
			CASE "enable_message";
				$value = $row[$key];
			break;
			CASE "currency";
				$value = $row[$key];
			break;
			CASE "left_header";
				$value = $row[$key];
			break;
			CASE "footer";
				$value = $row[$key];
			break;			
			CASE "enable_rtl";
				$value = $row[$key];
			break;
			CASE "datepicker_lang";
				$value = $row[$key];
			break;
			CASE "sys_language";
				$value = $row[$key];
			break;
			CASE "weight";
				$value = $row[$key];
			break;
			CASE "height";
				$value = $row[$key];
			break;
			CASE "chest";
				$value = $row[$key];
			break;
			CASE "waist";
				$value = $row[$key];
			break;
			CASE "thing";
				$value = $row[$key];
			break;
			CASE "arms";
				$value = $row[$key];
			break;
			CASE "fat";
				$value = $row[$key];
			break;
		}
		return $value;
	}
	
	public function getCountryCode($country)
	{
		$xml = Xml::build('../vendor/xml/countrylist.xml');
		foreach($xml as $x)
		{
			if($x->code == $country)
			{
				return $x->phoneCode;
			}
		}
		
	}
	
	function get_js_dateformat($php_format)
{
    $SYMBOLS_MATCHING = array(
        // Day
        'd' => 'dd',
        'D' => 'D',
        'j' => 'd',
        'l' => 'DD',
        'N' => '',
        'S' => '',
        'w' => '',
        'z' => 'o',
        // Week
        'W' => '',
        // Month
        'F' => 'MM',
        'm' => 'mm',
        'M' => 'M',
        'n' => 'm',
        't' => '',
        // Year
        'L' => '',
        'o' => '',
        'Y' => 'yyyy',
        'y' => 'y',
        // Time
        'a' => '',
        'A' => '',
        'B' => '',
        'g' => '',
        'G' => '',
        'h' => '',
        'H' => '',
        'i' => '',
        's' => '',
        'u' => ''
    );
    $jqueryui_format = "";
    $escaping = false;
    for($i = 0; $i < strlen($php_format); $i++)
    {
        $char = $php_format[$i];
        if($char === '\\') // PHP date format escaping character
        {
            $i++;
            if($escaping) $jqueryui_format .= $php_format[$i];
            else $jqueryui_format .= '\'' . $php_format[$i];
            $escaping = true;
        }
        else
        {
            if($escaping) { $jqueryui_format .= "'"; $escaping = false; }
            if(isset($SYMBOLS_MATCHING[$char]))
                $jqueryui_format .= $SYMBOLS_MATCHING[$char];
            else
                $jqueryui_format .= $char;
        }
    }
    return $jqueryui_format;
}

public function get_category_name($id)
{
	$category_table = TableRegistry::get("Category");
	$name = $category_table->find()->where(["id"=>$id])->select(['name'])->hydrate(false);
	$name = $name->toArray();
	if(!empty($name))
	{
		return $name[0]['name'];
	}	
}
public function get_staff_name($id)
{
	$mem_table = TableRegistry::get("GymMember");
	$staff = $mem_table->find()->where(["id"=>$id,["role_name"=>"staff_member"]])->select(['first_name','last_name'])->hydrate(false);
	$staff = $staff->toArray();	
	if(!empty($staff))
	{
		return $staff[0]["first_name"]." ".$staff[0]["last_name"];
	}else{
		return "None";
	}
}

public function days_array()
{
	return $week=array('Sunday'=>'Sunday','Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday');
}

public function minute_array()
{
	return $minute=array('00'=>'00','15'=>'15','30'=>'30','45'=>'45');
}

public function measurement_array()
{
	return $measurment=array('Height'=>'Height',
	'Weight'=>'Weight','Chest'=>'Chest','Waist'=>'Waist','Thigh'=>'Thigh','Arms'=>'Arms','Fat'=>'Fat');
}

public function get_activity_by_category($id)
{
	$activity_table = TableRegistry::get("Activity");
	$activities = $activity_table->find("all")->where(["cat_id"=>$id])->hydrate(false)->toArray();	
	return $activities;
}

public function get_activity_by_id($id)
{
	$activity_table = TableRegistry::get("Activity");
	$activity = $activity_table->get($id)->toArray();
	return $activity["title"];
}

public function get_interest_by_id($id)
{
	$interest_table = TableRegistry::get("gymInterestArea");
	// $row = $interest_table->get($id)->toArray();	 // generates record not found error.
	$row = $interest_table->find("all")->where(["id"=>$id])->toArray();	
	return (!empty($row))?$row[0]["interest"]:"---";
}

public function get_attendance_status($id,$date)
{
	$date = date("Y-m-d",strtotime($date));
	$att_table = TableRegistry::get("GymAttendance");
	$row = $att_table->find()->where(["user_id"=>$id,"attendance_date"=>"{$date}"])->hydrate(false)->toArray();
	if(!empty($row))
	{
		return $row[0]["status"];	
	}
	else{
		return __("Not Taken");
	}
}

public function get_class_by_id($id)
{
	$class_table = TableRegistry::get("ClassSchedule");
	$row = $class_table->get($id)->toArray();	
	return $row["class_name"];
}

public function get_member_list_for_message()
{
	$mem_table = TableRegistry::get("GymMember");
	$staff = $mem_table->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"]);
	$staff = $staff->select(["id","name"=>$staff->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();
	
	$accountant = $mem_table->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"accountant"]);
	$accountant = $accountant->select(["id","name"=>$accountant->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();
	
	$member = $mem_table->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"member"]);
	$member = $member->select(["id","name"=>$member->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();
	
	$session = $this->request->session()->read("User");
	if($session["role_name"] == "administrator")
	{
		$roles = ["member"=>__("Members"),"staff_member"=>__("Staff Members"),"accountant"=>__("Accountants")];
	}else{
		$roles = ["member"=>__("Members"),"staff_member"=>__("Staff Members"),"accountant"=>__("Accountants"),"administrator"=>__("Administrator")];
	}
	$options = ["To"=>$roles,"Members"=>$member,"Staff"=>$staff,"Accountant"=>$accountant];
	// var_dump($options);die;
	return $options;
}

public function get_membership_paymentstatus($mp_id)
{
	$membership_payment_tbl = TableRegistry::get('MembershipPayment');	
	$result = $membership_payment_tbl->get($mp_id)->toArray();
	if($result['paid_amount'] >= $result['membership_amount'])
		return 'Fully Paid';		
	elseif($result['paid_amount'] == 0 )
		return 'Not Paid';
	else
		return 'Partially Paid';
	
	/*	
	$mem_table = TableRegistry::get('Membership');	
	$signup_fee = $mem_table->get($result['membership_id'])->toArray();
	$signup_fee = $signup_fee["signup_fee"];
	// var_dump($result);
	if($result['paid_amount'] >= $result['membership_amount'] + $signup_fee)
		return 'Fully Paid';		
	elseif($result['paid_amount'] == 0 )
		return 'Not Paid';
	else
		return 'Partially Paid';
	*/
}

public function get_total_group_members($gid)
{
	$mem_table = TableRegistry::get("GymMember");
	$data = $mem_table->find("all")->where(["role_name"=>"member","assign_group LIKE"=> '%"'.$gid.'"%'])->select(["id"]);
	return $data->count();
}


	function get_currency_symbol( $currency = '' )
	{			
		$currency = $this->getSettings("currency");
			switch ( $currency ) {
			case 'AED' :
			$currency_symbol = 'د.إ';
			break;
			case 'AUD' :
			case 'CAD' :
			case 'CLP' :
			case 'COP' :
			case 'HKD' :
			case 'MXN' :
			case 'NZD' :
			case 'SGD' :
			case 'USD' :
			$currency_symbol = '&#36;';
			break;
			case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
			case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
			case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
			case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
			case 'CNY' :
			case 'JPY' :
			case 'RMB' :
			$currency_symbol = '&yen;';
			break;
			case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
			case 'DKK' :
			$currency_symbol = 'kr.';
			break;
			case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
			case 'EGP' :
			$currency_symbol = 'EGP';
			break;
			case 'EUR' :
			$currency_symbol = '&euro;';
			break;
			case 'GBP' :
			$currency_symbol = '&pound;';
			break;
			case 'HRK' :
			$currency_symbol = 'Kn';
			break;
			case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
			case 'IDR' :
			$currency_symbol = 'Rp';
			break;
			case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
			case 'INR' :
			$currency_symbol = 'Rs.';
			break;
			case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
			case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
			case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
			case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
			case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
			case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
			case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
			case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
			case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
			case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
			case 'RON' :
			$currency_symbol = 'lei';
			break;
			case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
			case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
			case 'THB' :
			$currency_symbol = '&#3647;';
			break;
			case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
			case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
			case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
			case 'VND' :
			$currency_symbol = '&#8363;';
			break;
			case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
			default :
			$currency_symbol = $currency;
			break;
		}
		return $currency_symbol;

	}
	
	public function get_class_by_member($mid)
	{
		$class_table = TableRegistry::get("GymMemberClass");
		$class_sche_table = TableRegistry::get("ClassSchedule");
		$row = $class_table->find()->where(["member_id"=>$mid])->select(["assign_class"]);
		$row = $row->leftjoin(["ClassSchedule"=>"class_schedule"],
							["GymMemberClass.assign_class = ClassSchedule.id"])->select(["ClassSchedule.class_name"])->hydrate(false)->toArray();
		$class = "None";
		if(!empty($row))
		{	$class = "";
			foreach($row  as $data)
			{
				$class .= $data["ClassSchedule"]["class_name"] .",";
			}
		}
		return trim($class,",");
	}
	
	public function get_group_by_member($mid)
	{
		$mem_table = TableRegistry::get("GymMember");
		$grp_table = TableRegistry::get("GymGroup");
		$row = $mem_table->get($mid)->toArray();
		$assign_groups = json_decode($row["assign_group"]);
		$data = "";
		if(!empty($assign_groups))
		{
			foreach($assign_groups as $group)
			{
				$grp_name = $grp_table->get($group)->toArray();
				$data .= $grp_name["name"].",";
			}
			$data = trim($data,",");
			return $data;
			
		}else{
			return "None";
		}
	}
	
	public function data_table_lang()
	{
		$parameters =  '"sEmptyTable":     "'. __('No data available in table').'",
						"sInfo":           "'.__("Showing _START_ to _END_ of _TOTAL_ entries").'",
						"sInfoEmpty":      "'.__("Showing 0 to 0 of 0 entries").'",
						"sInfoFiltered":   "'.__("(filtered from _MAX_ total entries)").'",
						"sInfoPostFix":    "",
						"sInfoThousands":  ",",
						"sLengthMenu":     "'.__("Show _MENU_ entries").'",
						"sLoadingRecords": "'.__("Loading...").'",
						"sProcessing":     "'.__("Processing...").'",
						"sSearch":         "'. __("Search").':",
						"sZeroRecords":    "'.__("No matching records found").'",
						"oPaginate": {
							"sFirst":    "'.__("First").'",
							"sLast":     "'.__("Last").'",
							"sNext":     "'.__("Next").'",
							"sPrevious": "'.__("Previous").'"
						},
						"oAria": {
							"sSortAscending":  ": '.__("activate to sort column ascending").'",
							"sSortDescending": ": '.__("activate to sort column descending").'"
						}';
		return $parameters;
	}
	
	function dateformat_PHP_to_jQueryUI($php_format)
	{
		$SYMBOLS_MATCHING = array(
			// Day
			'd' => 'dd',
			'D' => 'D',
			'j' => 'd',
			'l' => 'DD',
			'N' => '',
			'S' => '',
			'w' => '',
			'z' => 'o',
			// Week
			'W' => '',
			// Month
			'F' => 'MM',
			'm' => 'mm',
			'M' => 'M',
			'n' => 'm',
			't' => '',
			// Year
			'L' => '',
			'o' => '',
			'Y' => 'yy',
			'y' => 'y',
			// Time
			'a' => '',
			'A' => '',
			'B' => '',
			'g' => '',
			'G' => '',
			'h' => '',
			'H' => '',
			'i' => '',
			's' => '',
			'u' => ''
		);
		$jqueryui_format = "";
		$escaping = false;
		for($i = 0; $i < strlen($php_format); $i++)
		{
			$char = $php_format[$i];
			if($char === '\\') // PHP date format escaping character
			{
				$i++;
				if($escaping) $jqueryui_format .= $php_format[$i];
				else $jqueryui_format .= '\'' . $php_format[$i];
				$escaping = true;
			}
			else
			{
				if($escaping) { $jqueryui_format .= "'"; $escaping = false; }
				if(isset($SYMBOLS_MATCHING[$char]))
					$jqueryui_format .= $SYMBOLS_MATCHING[$char];
				else
					$jqueryui_format .= $char;
			}
		}
		return $jqueryui_format;
	}
}