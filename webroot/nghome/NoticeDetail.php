<?php
include'connection.php';
$id=intval(mysqli_real_escape_string($conn,$_REQUEST['id']));
$get_record="SELECT `notice_title`,`comment`,`notice_for`,`start_date`,`end_date`,
class_schedule.class_name FROM `gym_notice` 
INNER JOIN class_schedule ON class_schedule.id=gym_notice.class_id WHERE gym_notice.class_id IN
(SELECT `assign_class` FROM `gym_member_class` WHERE `member_id`=$id)";
$select_query=$conn->query($get_record);
$result=array();
$result['status']='0';
$result['error']='Record Not Found';
$result['result']=array();
if(mysqli_num_rows($select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($select_query)){
		$result['result'][]=$get_data;
	}
}
$sql="SELECT `notice_title`,`notice_for`,`class_id`,`start_date`,`end_date`,`comment` FROM `gym_notice` WHERE `notice_for` in
((SELECT `role_name` FROM `gym_member` WHERE `id`=$id),'all')"; 
$query=$conn->query($sql);
if(mysqli_num_rows($query) > 0){
	$result['status']='1';
	$result['error']='';
	while($r=mysqli_fetch_assoc($query)){
		$r['class_name']=classname($r['class_id']);
		unset($r['class_id']);
		$result['result'][]=$r;
	}
}
echo json_encode($result);
function classname($id)
{
	if($id==0)
	{
		return "none";
	}
	else
	{
	global $conn;
	$sql="SELECT `class_name` FROM `class_schedule` WHERE `id`=$id";
	return mysqli_fetch_assoc($conn->query($sql))['class_name'];
	}
}
?>