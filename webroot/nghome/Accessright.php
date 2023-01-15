<?php
include('connection.php');
$sql="SELECT `menu` FROM `gym_accessright` where member=1";
$res=$conn->query($sql);
if ($res->num_rows > 0) {
	$result['status']='1';
	$result['error']='';
    while($row = $res->fetch_assoc()) 
	{
		$row['menu']=trim($row['menu']);
		$result['result']['accessright'][]=$row;
	}
}
else
{
	$result['status']='1';
	$result['error']='';
	$result['result']=array();
}
echo json_encode($result);
?>