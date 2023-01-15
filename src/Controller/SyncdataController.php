<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use GoogleCharts;
use Cake\Collection\Collection;

class SyncdataController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		//$this->loadComponent("GYMFunction");
		$this->Auth->allow(['syncUserData']);	
	}

    public function getLastSyncDate(    )
    {
        
    }

    public function syncUserData()
    {
        $data = $_POST['userData'];
        if($data != ""){
            $rawData = json_decode($data);
            $newData = (array)$rawData->Row;
            $collection = new Collection($newData);
            print_r($collection);exit;
        }else{
            echo "No data found to sync";exit;
        }
       
    }

}