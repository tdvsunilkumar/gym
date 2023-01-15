<?php
include('connection.php');
$id=intval(mysqli_real_escape_string($conn,$_REQUEST['id']));
$sql="DELETE FROM `gym_measurement` WHERE `id`=$id"; 
$result=array();
if ($conn->query($sql)) {
	$result['status']='1';
	$result['error']='';
} 
else
{
	$result['status']='0';
	$result['error']='Something getting wrong!!';
}
echo json_encode($result);
$conn->close();
?>