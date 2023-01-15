<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\DatabaseSession;

class ActivityController extends AppController
{
	public function activityList()
	{
		$session = $this->request->session()->read("User");
		$data = array();
		if($session["role_name"]=="member")
		{
			$mem_id = $this->Activity->GymMember->find()->where(["id"=>$session["id"]])->select(["selected_membership"])->hydrate(false)->toArray();
			$assigned_activity = $this->Activity->MembershipActivity->find()->where(["membership_id"=>$mem_id[0]["selected_membership"]])->select(["activity_id"])->hydrate(false)->toArray();
			
			if(!empty($assigned_activity))
			{
				foreach($assigned_activity as $activity)
				{
					$acivities_list[] = $activity["activity_id"];
				}				
				$data = $this->Activity->find()->where(["Activity.id IN"=>$acivities_list]);
				$data = $data->contain(["GymMember","Category"])->select($this->Activity)->select(["GymMember.first_name","GymMember.last_name","Category.name"])->hydrate(false)->toArray();
			}
		}
		else{
			$data = $this->Activity->find("all")->contain(["GymMember","Category"])->select($this->Activity)->select(["GymMember.first_name","GymMember.last_name","Category.name"])->hydrate(false)->toArray();
		}
		$this->set("data",$data);		
	}
	
	public function addActivity()
	{		
		$session = $this->request->session()->read("User");
		$this->set("edit",false);
		$this->set("title",__("Add Activity"));
		
		$categories = $this->Activity->Category->find("list",["keyField"=>"id","valueField"=>"name"])->toArray();
		$this->set("categories",$categories);
		
		$staff = $this->Activity->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"]);
		$staff = $staff->select(["id",'name' => $staff->func()->concat(['first_name'=>'literal', ' ', 'last_name'=>'literal'])])->toArray();
		$this->set("staff",$staff);
		
		$membership = $this->Activity->Membership->find("list",["keyField"=>"id","valueField"=>"membership_label"]);
		$this->set("membership",$membership);
		
		$role = $session["role_name"];
		$this->set("role",$role);
		
		if($this->request->is("post"))
		{			
			$this->request->data["created_by"] = $session["id"];
			$this->request->data["created_date"] = date("Y-m-d");
			$activity = $this->Activity->newEntity();
			$activity = $this->Activity->patchEntity($activity,$this->request->data);
			if($this->Activity->save($activity))
			{
				$id = $activity->id;
				foreach($this->request->data["membership_id"] as $mid)
				{
					$ma[] = ["activity_id"=>$id,"membership_id"=>$mid,"created_by"=>$session["id"],"created_date"=>date("Y-m-d")];
				}
				$membership_activity = $this->Activity->MembershipActivity->newEntities($ma);		
				foreach($membership_activity as $row)
				{
					$this->Activity->MembershipActivity->save($row);
				}
				
				$this->Flash->success(__("Success! Record Saved Successfully."));
				return $this->redirect(["action"=>"activityList"]);
			}
		}		
	}
	
	public function deleteActivity($did)
	{
		$row = $this->Activity->get($did);
		if($this->Activity->delete($row))
		{
			$this->Flash->success(__("Success! Record Deleted Successfully"));
			return $this->redirect($this->referer());
		}
	}
	
	public function editActivity($id)
	{
		$this->set("edit",true);
		$this->set("title",__("Edit Activity"));
		
		$categories = $this->Activity->Category->find("list",["keyField"=>"id","valueField"=>"name"])->toArray();
		$this->set("categories",$categories);
		
		$staff = $this->Activity->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"]);
		$staff = $staff->select(["id",'name' => $staff->func()->concat(['first_name'=>'literal', ' ', 'last_name'=>'literal'])])->toArray();
		$this->set("staff",$staff);
		
		$membership = $this->Activity->Membership->find("list",["keyField"=>"id","valueField"=>"membership_label"]);
		$this->set("membership",$membership);
		
		$session = $this->request->session()->read("User");
		$role = $session["role_name"];
		$this->set("role",$role);
		
		$data = $this->Activity->find()->where(["Activity.id"=>$id])->contain(["Category","GymMember"])->select($this->Activity);
		$data = $data->select(["GymMember.first_name","GymMember.last_name","Category.name"])->hydrate(false)->toArray();
		$data = $this->Activity->find()->where(["Activity.id"=>$id])->hydrate(false)->toArray();
		
		$ma_table = TableRegistry::get("MembershipActivity");
		$membership_id = $ma_table->find()->select(["membership_id"])->where(["activity_id"=>$id])->hydrate(false)->toArray();
		$membership_id = array_column($membership_id,"membership_id");
		
		$data[0]["membership_ids"] = $membership_id;
		$this->set("data",$data[0]);
		$this->render("addActivity");
		
		if($this->request->is("post"))
		{
			$row = $this->Activity->get($id);
			$row = $this->Activity->patchEntity($row,$this->request->data);
			if($this->Activity->save($row))
			{
				foreach($this->request->data["membership_id"] as $mid)
				{
					$ma[] = ["activity_id"=>$id,"membership_id"=>$mid];
					$delete_ma[] = $id;
				}
				$membership_activity = $this->Activity->MembershipActivity->deleteAll(["MembershipActivity.activity_id IN"=> $delete_ma]);
				$membership_activity = $this->Activity->MembershipActivity->newEntities($ma);		
				foreach($membership_activity as $row)
				{
					$this->Activity->MembershipActivity->save($row);
				}				
				
				$this->Flash->success(__("Success! Record Updated Successfully."));
				return $this->redirect(["action"=>"activityList"]);
			}
		}
	}
	
	public function isAuthorized($user)
	{
		$role_name = $user["role_name"];
		$curr_action = $this->request->action;
		$members_actions = ["activityList"];
		$staff_acc_actions = ["activityList","editActivity","deleteActivity","addActivity"];
		switch($role_name)
		{			
			CASE "member":
				if(in_array($curr_action,$members_actions))
				{return true;}else{return false;}
			break;
			
			CASE "staff_member":
				if(in_array($curr_action,$staff_acc_actions))
				{return true;}else{ return false;}
			break;
			
			CASE "accountant":
				if(in_array($curr_action,$staff_acc_actions))
				{return true;}else{return false;}
			break;
		}
		return parent::isAuthorized($user);
	}
}
?>