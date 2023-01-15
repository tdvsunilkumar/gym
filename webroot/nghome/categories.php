<?php
include('connection.php');
$sql="SELECT `id`, `name` FROM `category`";
$res=$conn->query($sql);
if ($res->num_rows > 0) {
	$result['status']='1';
	$result['error']='';
    while($row = $res->fetch_assoc()) 
	{
		$row['name']=trim($row['name']);
		$result['result']['category'][]=$row;
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