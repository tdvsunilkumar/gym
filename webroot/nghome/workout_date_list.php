<?php
include('connection.php');
if(isset($_REQUEST['id'])){$id=intval(mysqli_real_escape_string($conn,$_REQUEST['id']));}
$query="SELECT DISTINCT `record_date` FROM `gym_daily_workout` WHERE `member_id`=$id ORDER BY `record_date` DESC";
$res=$conn->query($query);
if ($res->num_rows > 0) {
	$result['status']='1';
	$result['error']='';

    while($row = $res->fetch_assoc()) 
	{
		$result['months'][]=$row['record_date'];
	}
} 
else
{
	$result['status']='0';
	$result['error']='No records!';
	$result['result']=array();
	
}
//echo $result['2016 August'][0];

echo json_encode($result);
$conn->close();
?>