<?php
include'connection.php';
$get_record="SELECT gym_reservation.event_name,gym_reservation.event_date,
gym_event_place.place,gym_reservation.start_time,gym_reservation.end_time FROM `gym_reservation` 
LEFT JOIN gym_event_place ON gym_event_place.id=gym_reservation.place_id";
$select_query=$conn->query($get_record);
$result=array();
if(mysqli_num_rows($select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($select_query)){
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