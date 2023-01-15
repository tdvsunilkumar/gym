<?php
include("connection.php");
$role=mysqli_real_escape_string($conn,$_REQUEST['role']);
if($role=='0'){$role="member";}
elseif($role=='1'){$role="staff_member";}
elseif($role=='2'){$role="accountant";}
elseif($role=='3'){$role="administrator";} 
else{$role="member";}
$query="SELECT `id`,`first_name`,`last_name` FROM `gym_member` WHERE `role_name`='$role'";
$res=$conn->query($query);
$result=array();
if ($res->num_rows > 0) 
{
	$result['status']='1';
	$result['error']='';
	while($row = $res->fetch_assoc())
	{
		$r['name']=$row['first_name']." ".$row['last_name'];
		if($role=='administrator'){$r['name']='Administrator';}
		$r['id']=$row['id'];
		$result['result']['members'][]=$r;
	}
}
echo json_encode($result);
?>