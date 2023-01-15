<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class GymSubscriptionHistoryController extends AppController
{
	public function index()
	{
		$session = $this->request->session()->read("User");
		$pay_tbl = TableRegistry::get("MembershipPayment");
		$membership_tbl = TableRegistry::get("Membership");
		$data = $pay_tbl->find("all")->where(["member_id"=>$session["id"]])->select($pay_tbl);
		$data = $data->leftjoin(["Membership" => "membership"],
								["MembershipPayment.membership_id = Membership.id"])->select($membership_tbl)->hydrate(false)->toArray();
		$this->set("data",$data);		
	}
	
	public function isAuthorized($user)
	{
		$role_name = $user["role_name"];
		$curr_action = $this->request->action;
		$members_actions = ["index"];
		$staff__acc_actions = [];
		switch($role_name)
		{			
			CASE "member":
				if(in_array($curr_action,$members_actions))
				{return true;}else{return false;}
			break;			
			CASE "staff_member":
				if(in_array($curr_action,$staff__acc_actions))
				{return true;}else{ return false;}
			break;
			
			CASE "accountant":
				if(in_array($curr_action,$staff__acc_actions))
				{return true;}else{return false;}
			break;
		}		
		return parent::isAuthorized($user);
	}
}
