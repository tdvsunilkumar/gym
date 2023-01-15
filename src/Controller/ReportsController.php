<?php
namespace App\Controller;
use Cake\App\Controller;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use GoogleCharts;

class ReportsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		require_once(ROOT . DS .'vendor' . DS  . 'chart' . DS . 'GoogleCharts.class.php');		
	}
	
	public function membershipReport()
	{
		$membership_tbl = TableRegistry::get("Membership");		
		$member_ship_array = array();
		$chart_array = array();
		$chart_array[] = array('Membership','Number Of Member');

		$data = $membership_tbl->find("all")->select(["Membership.membership_label"]);
		$data = $data->leftjoin(["GymMember"=>"gym_member"],["GymMember.selected_membership = Membership.id"])->select(["count"=>$data->func()->count("GymMember.id")])->group("Membership.id")->hydrate(false)->toArray();
		if(!empty($data))
		{
			foreach($data as $result)
			{
				$chart_array[]=[$result["membership_label"],$result["count"]];
			}
		}
		$this->set("data",$data); 
		$this->set("chart_array",$chart_array); 
	}
	
	public function attendanceReport()
    {
		if($this->request->is("post"))
		{
			$att_tbl = TableRegistry::get("gym_attendance");	
			$cls_tbl = TableRegistry::get("class_schedule");
			
			$sdate = date('Y-m-d',strtotime($this->request->data['sdate']));
			$edate = date('Y-m-d',strtotime($this->request->data['edate']));
			//$sdate = '2015-09-01';
			//$edate = '2015-09-10';
			$conn = ConnectionManager::get('default');	
			
			$report_2 = "SELECT  at.class_id,cl.class_name, 
				SUM(case when `status` ='Present' then 1 else 0 end) as Present, 
				SUM(case when `status` ='Absent' then 1 else 0 end) as Absent 
				from `gym_attendance` as at,`class_schedule` as cl where `attendance_date` BETWEEN '{$sdate}' AND '{$edate}' AND at.class_id = cl.id AND at.role_name = 'member' GROUP BY at.class_id";
			
			$report_2 = $conn->execute($report_2);
			$report_2 = $report_2->fetchAll('assoc');			
			$report_2 = $report_2;
			$chart_array[] = array(__('Class'),__('Present'),__('Absent'));
			if(!empty($report_2))
			{
				foreach($report_2 as $result)
				{			
					$cls = $result['class_name'];					
					$chart_array[] = [$result['class_name'],(int)$result["Present"],(int)$result["Absent"]];
				}
			}
			$this->set("report_2",$report_2); 
			$this->set("chart_array",$chart_array); 
		}
    }
	
	public function membershipStatusReport()
	{
		$mem_tbl = TableRegistry::get("GymMember");
		$chart_array = array();
		$chart_array[] = array('Membership','Number Of Member');

		// $data = $mem_tbl->find("all")->where(["membership_status"=>"Expired"])->orWhere(["membership_status"=>"Continue"])->orWhere(["membership_status"=>"Dropped"]);
		$data = $mem_tbl->find("all")->where(["role_name"=>"member","OR"=>[["membership_status"=>"Expired"],["membership_status"=>"Continue"],["membership_status"=>"Dropped"]]]);
		$data = $data->select(["membership_status","count"=>$data->func()->count('membership_status')])->group("membership_status")->hydrate(false)->toArray();
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$chart_array[]=array( $row['membership_status'],$row['count']);
			}
		}		
		$this->set("data",$data); 
		$this->set("chart_array",$chart_array); 
	}
	
	public function paymentReport()
	{			
		$conn = ConnectionManager::get('default');
		$table_name = TableRegistry::get("membership_payment");
		
		$month =array('1'=>"January",'2'=>"February",'3'=>"March",'4'=>"April",
		'5'=>"May",'6'=>"June",'7'=>"July",'8'=>"August",
		'9'=>"September",'10'=>"Octomber",'11'=>"November",'12'=>"December",);
		$year = date('Y');
		
		$q="SELECT EXTRACT(MONTH FROM created_date) as date,sum(paid_amount) as count FROM `membership_payment` WHERE YEAR(created_date) =".$year." group by month(created_date) ORDER BY created_date ASC";
				
		$result = $conn->execute($q);
		$result = $result->fetchAll('assoc');		
		$chart_array = array();
		$chart_array[] = array('Month','Fee 	Payment');
		if(!empty($result))
		{
			foreach($result as $r)
			{

				$chart_array[]=array( $month[$r["date"]],(int)$r["count"]);
			}
		}
		$this->set("result",$result); 		
		$this->set("chart_array",$chart_array); 		
	}
}