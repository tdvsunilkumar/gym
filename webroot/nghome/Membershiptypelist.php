<?php
include'connection.php';
$get_record="SELECT membership.gmgt_membershipimage,membership.membership_label,membership.membership_length,
installment_plan.duration,installment_plan.number,membership.signup_fee FROM `membership`
INNER JOIN installment_plan ON installment_plan.id=membership.install_plan_id";
$select_query=$conn->query($get_record);
$result=array();
if(mysqli_num_rows($select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($select_query)){
		$get_data['gmgt_membershipimage']=$image_path.$get_data['gmgt_membershipimage'];
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