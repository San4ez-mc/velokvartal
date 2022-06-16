<?php
$link = mysqli_connect("fp432115.mysql.tools", "fp432115_velokvartal", "mc7-*X97Zn", "fp432115_velokvartal");
mysqli_set_charset($link, "utf8");
$sql="SELECT * FROM `oc_temptable` LIMIT 1";
$result = mysqli_query($link, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
if($rows[0]['photos']!='')
{
	$ph=explode(",", $rows[0]['photos']);
	$name=explode("/",$ph[0]);
	echo $name[count($name)-1];
	$name=$name[count($name)-1];
	$url = $ph[0];
	echo $_SERVER['DOCUMENT_ROOT'];
    $path = $_SERVER['DOCUMENT_ROOT'] . 'image/upl/'.$name;
    file_put_contents($path, file_get_contents($url));
    $sql2="UPDATE `oc_product` set `image`='upl/".$name."' WHERE `product_id`='".$rows[0]['product_id']."'";
	mysqli_query($link, $sql2);
}
$sql2="UPDATE `oc_product_description` set `description`='".$rows[0]['description']."' WHERE `product_id`='".$rows[0]['product_id']."'";
mysqli_query($link, $sql2);
echo $rows[0]['product_id'];

$sql3="DELETE FROM `oc_temptable` WHERE `product_id`='".$rows[0]['product_id']."'";
mysqli_query($link, $sql3);
?>
<script>
 document.location=document.location;
</script>