<?php
include'connection.php';
$get_record="SELECT `image`,`first_name`,`last_name`,`mobile`,`email` FROM 
`gym_member` WHERE `role_name`='accountant'";
$select_query=$conn->query($get_record);
$result=array();
if(mysqli_num_rows($select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($select_query)){
	   $get_data['image']=$image_path.$get_data['image'];
     	$result['result'][]=$get_data;
	}
}else
{
	$result['status']='0';
	$result['error']='Record Not Found';
	$result['result']=array();
}
echo json_encode($result);

?>