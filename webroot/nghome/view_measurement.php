<?php
include('connection.php');
if(isset($_REQUEST['id'])){$id=intval(mysqli_real_escape_string($conn,$_REQUEST['id']));}
$query="SELECT `id`,`result_measurment`,`result`,`result_date`,`image` FROM `gym_measurement` WHERE `user_id`=$id";
$res=$conn->query($query);
if ($res->num_rows > 0) {
	$result['status']='1';
	$result['error']='';
    while($row = $res->fetch_assoc()) 
	{
		$row['image']=$image_path.$row['image'];
		$result['result']['measurement'][]=$row;
	}
} 
else
{
	$result['status']='0';
	$result['error']='No records!';
	$result['result']=array();
	
}
echo json_encode($result);
$conn->close();
?>