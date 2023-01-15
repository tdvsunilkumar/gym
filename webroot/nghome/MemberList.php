<?php
include'connection.php';
$id=intval(mysqli_real_escape_string($conn,$_REQUEST['id']));
$get_record="SELECT `first_name`,`last_name`,`member_id`,`member_type`,`image`,
`membership_status`,`membership_valid_from`, `membership_valid_to` FROM `gym_member` WHERE `id`='$id'";
$select_query=$conn->query($get_record);
$result=array();
if(mysqli_num_rows($select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($select_query)){
		//$Name=$get_data['username'];
		$get_data['image']=$server_path.$image_pa.$get_data['image'];
		$result['result'][]=$get_data;
	}
}else
{
	$result['status']='0';
	$result['error']='Record not found';
	$result['result']=array();
}
echo json_encode($result);
?>