<?php
$link = mysqli_connect("fp432115.mysql.tools", "fp432115_velokvartal", "mc7-*X97Zn", "fp432115_velokvartal");
mysqli_set_charset($link, "utf8");
$items=simplexml_load_file('https://velotrade.com.ua/prom-ua.xml?utm_source=eSputnik-', null, LIBXML_NOCDATA);
foreach($items->items[0] as $prod)
{
	$prod = (array) $prod;
	$sql="SELECT product_id FROM oc_product WHERE model='".$prod['vendorCode']."'";
	$result = mysqli_query($link, $sql);
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if(count($rows)>0)
	{
		echo count($rows);
		print_r($rows[0]['product_id']);
		echo "__";
		print_r($prod['vendorCode']);
		if(isset($prod['image']))
		{
			$im=$prod['image'];
		}else{
			$im='';
		}
		$sql2="INSERT INTO oc_temptable set `product_id`='".$rows[0]['product_id']."', `description`='".$prod['description']."', `photos`='".$im."'";
		mysqli_query($link, $sql2);
		echo "<br>";

	}
}
?>