<?php
include'connection.php';
$id=intval(mysqli_real_escape_string($conn,$_REQUEST['id']));
$get_record="SELECT `first_name`,`last_name`,`birth_date`,`address`, `city`, `state`,`mobile`,`phone`,`email`,`username`,`password`, `image` FROM `gym_member` WHERE `id`='$id'";
$select_query=$conn->query($get_record);
$result=array();
if(mysqli_num_rows($select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($select_query)){
		$get_data['imageName']=$get_data['image'];
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