<?php
include'connection.php';
if(isset($_REQUEST['username'])){$uname=mysqli_real_escape_string($conn,$_REQUEST['username']);}
if(isset($_REQUEST['password'])){$password=mysqli_real_escape_string($conn,$_REQUEST['password']);}
$get_record="SELECT * FROM `gym_member` WHERE `username` = '$uname'" ;
$Select_query=$conn->query($get_record);
$result=array();
if(mysqli_num_rows($Select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($Select_query))
	{
		$get_data['Image']=$image_path.$get_data['image'];
		$result['result'][]=$get_data;
	}
}else
{
	$result['status']='0';
	$result['error']='Username or password are wrong!';
	$result['result']=array();
}
echo json_encode($result);
?>