<?php
include('connection.php');
$id=intval(mysqli_real_escape_string($conn,$_REQUEST['id']));
$sql="SELECT `id`, `title` FROM `activity` WHERE `cat_id`=$id";
$res=$conn->query($sql);
if ($res->num_rows > 0) {
	$result['status']='1';
	$result['error']='';
    while($row = $res->fetch_assoc()) 
	{
		$row['title']=trim($row['title']);
		$result['result']['activity'][]=$row;
	}
}
else
{
	$result['status']='0';
	$result['error']='No Activity Found!';
	$result['result']=array();
}
echo json_encode($result);
?>