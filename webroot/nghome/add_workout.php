<?php
include('connection.php');
$member_id=intval(mysqli_real_escape_string($conn,$_REQUEST['member_id']));
$record_date=$_REQUEST['date'];
$created_by=mysqli_real_escape_string($conn,$_REQUEST['created_by']);
$level=mysqli_real_escape_string($conn,$_REQUEST['level']);
$sets=$_REQUEST['sets'];
$sets=explode(",",$sets);
$reps=$_REQUEST['reps'];
$reps=explode(",",$reps);
$time=$_REQUEST['time'];;
$time=explode(",",$time);
$workout_name=$_REQUEST['activity'];
$workout_name=explode(",",$workout_name);
$kg=$_REQUEST['kg'];
$kg=explode(",",$kg);
$result['status']='1';
$result['error']="";

$sql="INSERT INTO `gym_assign_workout`(`user_id`, `start_date`, `end_date`, `level_id`, `description`, `direct_assign`, `created_date`, `created_by`) 
VALUES ('$member_id','$record_date','$record_date',$level,'',1,CURRENT_DATE,$created_by)";
if(!$conn->query($sql))
{
	$result['status']='0';
	$result['error']="gym_assign_workout!";
}
else
{
	 $workout_id=$conn->insert_id;

	$sql="INSERT INTO `gym_daily_workout`(`member_id`,`record_date`,`created_date`,`created_by`)
	VALUES ($member_id,'$record_date',CURRENT_DATE,$created_by)";;
	if($conn->query($sql))
	{
		$result['status']='1';
		$result['error']="";
		$sql="SELECT `id` FROM `gym_daily_workout` WHERE `record_date`='$record_date'";
		$res=$conn->query($sql);
		$user_workout_id=$res->fetch_assoc()['id'];
		for($i=0;$i<sizeof($kg);$i++)
		{
			$sql="INSERT INTO `gym_user_workout`(`user_workout_id`, `workout_name`, `sets`, `reps`, `kg`, `rest_time`) 
			VALUES ($user_workout_id,$workout_name[$i],$sets[$i],$reps[$i],$kg[$i],$time[$i])";
			if(!$conn->query($sql))
			{
				$result['status']='0';
				$result['error']="gym_user_workout!";
			}
			$day=date('l');
			$sql="INSERT INTO `gym_workout_data`(`day_name`, `workout_name`, `sets`, `reps`, `kg`, `time`, `workout_id`, `created_date`, `created_by`)
			VALUES ('$day',$workout_name[$i],$sets[$i],$reps[$i],$kg[$i],$time[$i],$workout_id,CURRENT_DATE,$created_by)";
			if(!$conn->query($sql))
			{
				$result['status']='0';
				$result['error']="gym_workout_data!";
			}
		}	
	}
	else
	{
		echo "no";
		$result['status']='0';
		$result['error']="Something getting wrong!";
	}
}
echo json_encode($result);
die();
?>