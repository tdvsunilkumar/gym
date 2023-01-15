<?php
namespace App\Controller;
// use App\Controller\AppController;

class GymReservationController extends AppController
{
	public function reservationList()
    {
		$data = $this->GymReservation->find("all")->contain(["GymEventPlace"])->select($this->GymReservation)->select(["GymEventPlace.place"])->hydrate(false)->toArray();
		$this->set("data",$data);
    }
	
	public function addReservation()
    {
		$session = $this->request->session()->read("User");
		$this->set("edit",false);
		$event_places = $this->GymReservation->GymEventPlace->find("list",["keyField"=>"id","valueField"=>"place"])->hydrate(false);
		$this->set("event_places",$event_places);
		
		if($this->request->is("post"))
		{
			$row = $this->GymReservation->newEntity();
			$this->request->data["created_by"] = $session["id"];
			$this->request->data["created_date"] = date("Y-m-d");
			$this->request->data["event_date"] = date("Y-m-d",strtotime($this->request->data["event_date"]));
			$this->request->data['start_time'] = $this->request->data['start_hrs'].":".$this->request->data['start_min'].":".$this->request->data['start_ampm'];
			$this->request->data['end_time'] = $this->request->data['end_hrs'].":".$this->request->data['end_min'].":".$this->request->data['end_ampm'];
			$row = $this->GymReservation->patchEntity($row,$this->request->data);		
			if($this->GymReservation->save($row))
			{
				$this->Flash->success(__("Success! Record Saved Successfully"));
				return $this->redirect(["action"=>"reservationList"]);
			}
		}
    }
	 public function editReservation($id)
    {
		$this->set("edit",true);
		$row = $this->GymReservation->get($id);	
		
		$row['start_hrs'] =  explode(":",$row['start_time'])[0];
		@$row['start_min'] =  explode(":",$row['start_time'])[1];
		@$row['start_ampm'] =  explode(":",$row['start_time'])[2];		
		$row['end_hrs'] =  explode(":",$row['end_time'])[0];
		$row['end_min'] =  explode(":",$row['end_time'])[1];
		$row['end_ampm'] =  explode(":",$row['end_time'])[2];
		
		$this->set("data",$row->toArray());
		$event_places = $this->GymReservation->GymEventPlace->find("list",["keyField"=>"id","valueField"=>"place"])->hydrate(false);
		$this->set("event_places",$event_places);
		$this->render("addReservation");
		$row = "";
		if($this->request->is("post"))
		{
			$row = $this->GymReservation->get($id);			
			$this->request->data["event_date"] = date("Y-m-d",strtotime($this->request->data["event_date"]));
			$this->request->data['start_time'] = $this->request->data['start_hrs'].":".$this->request->data['start_min'].":".$this->request->data['start_ampm'];
			$this->request->data['end_time'] = $this->request->data['end_hrs'].":".$this->request->data['end_min'].":".$this->request->data['end_ampm'];
			
			$row = $this->GymReservation->patchEntity($row,$this->request->data);
			if($this->GymReservation->save($row))
			{
				$this->Flash->success(__("Success! Record Saved Successfully"));
				return $this->redirect(["action"=>"reservationList"]);
			}
			
		}
    }
	
	public function deleteReservation($did)
    {
		$drow = $this->GymReservation->get($did);
		if($this->GymReservation->delete($drow))
		{
			$this->Flash->success(__("Success! Record Deleted Successfully"));
			return $this->redirect(["action"=>"reservationList"]);
		}
    }
	
	
	public function isAuthorized($user)
	{
		$role_name = $user["role_name"];
		$curr_action = $this->request->action;
		$members_actions = ["reservationList"];
		// $staff__acc_actions = ["productList","addProduct","editProduct"];
		switch($role_name)
		{			
			CASE "member":
				if(in_array($curr_action,$members_actions))
				{return true;}else{return false;}
			break;
			
			// CASE "staff_member":
				// if(in_array($curr_action,$staff__acc_actions))
				// {return true;}else{ return false;}
			// break;
			
			// CASE "accountant":
				// if(in_array($curr_action,$staff__acc_actions))
				// {return true;}else{return false;}
			// break;
		}		
		return parent::isAuthorized($user);
	}
}
