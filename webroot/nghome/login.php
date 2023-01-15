<?php
include'connection.php';
if(isset($_REQUEST['username'])){$uname=mysqli_real_escape_string($conn,$_REQUEST['username']);}
if(isset($_REQUEST['password'])){$password=mysqli_real_escape_string($conn,$_REQUEST['password']);}
$get_record="SELECT * FROM `gym_member` WHERE `username` = '$uname'" ;
$Select_query=$conn->query($get_record);
$error = 1;	
$result=array();
if(mysqli_num_rows($Select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($Select_query))
	{
		$hash = $get_data['password'];
		$get_data['Image']=$image_path.$get_data['image'];
		$result['result'][]=$get_data;
		
		if(password_verify($password,$hash))
		{
			$hash = $get_data['password'];
			$get_data['Image']=$image_path.$get_data['image'];
			$result['result'][]=$get_data;	
			$error = 0;
			if($get_data['activated']==0)
			{
				$result['status']='0';
				$result['error']='Your account not activated yet!';
				$result['result']=array();
				$error=2;
			}
		}
	}
	
}

if($error == 1 )
{	
	$result['status']='0';
	$result['error']='Username or password are wrong!';
	$result['result']=array();
}
echo json_encode($result);
?>