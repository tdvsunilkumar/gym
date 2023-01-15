<?php
include("connection.php");
$sql="SELECT `id`,`class_name` FROM `class_schedule`";
$res=$conn->query($sql);
$result=array();
if ($res->num_rows > 0) 
{
	$result['status']='1';
	$result['error']='';
	while($row = $res->fetch_assoc())
	{
		$result['result']['classes'][]=$row;
	}

}
else
{
	$result['status']='0';
	$result['error']='No records!';
	$result['result']=array();
	
}
echo json_encode($result);
$conn->close();
?>