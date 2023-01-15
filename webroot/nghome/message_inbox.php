<?php
include("connection.php");
if(isset($_REQUEST['id'])){$id=intval(mysqli_real_escape_string($conn,$_REQUEST['id']));}
$sql="SELECT * FROM `gym_message` WHERE `receiver`= '$id' ORDER BY `date` DESC";
$result1=$conn->query($sql);
$result=array();
if ($result1->num_rows > 0) {
	$result['status']='1';
	$result['error']='';
    while($row = $result1->fetch_assoc()) 
	{
		
		$query="SELECT `image`,`first_name`,`last_name` FROM `gym_member` WHERE `id`='".$row['sender']."'";
		$result2=$conn->query($query);
		if ($result2->num_rows > 0)
		{
			$r1=$result2->fetch_assoc();
			$row['sender']=$r1['first_name']." ".$r1['last_name'];
			$row['image']=$image_path.$r1['image'];
			$date = new DateTime($row['date']);
			$new_date = $date->format('h:i a');
			$row['time']=$new_date;
			$row['date'] = $date->format('d-M-Y h:i a');
			$result['result']['messageInbox'][]=$row;
		}
		
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