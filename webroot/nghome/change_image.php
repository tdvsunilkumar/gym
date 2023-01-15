<?php 

require_once 'connection.php';
define('PROJECT_ROOT', dirname(dirname(__FILE__)));
$new_name = "";
$image = $_REQUEST["image"];
$name = $_REQUEST["name"];
$path=.$name;
//$path = "D:/xampp/htdocs/gym_master/webroot/upload/".$name;
$file=file_put_contents($path,base64_decode($image));
if($file)
{
	$result['status']="1";
	$result['imageName']=$name;
	$result['error']="";
	
}
else
{
	$result['status']="0";
	$result['imageName']="";
	$result['error']="Image is empty/not accessible";
}
echo json_encode($result);
?>