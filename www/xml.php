<?php
$link = mysqli_connect("fp432115.mysql.tools", "fp432115_velokvartal", "mc7-*X97Zn", "fp432115_velokvartal");
mysqli_set_charset($link, "utf8");
$items=simplexml_load_file('http://s.aerofit.com.ua/prices/cddfb7d1-7d55-11e9-9eec-50e549ec0b41.xml');
foreach($items->product as $prod)
{
	$prod = (array) $prod;
	$sql="SELECT product_id FROM oc_product WHERE model='".$prod['sku']."'";
	$result = mysqli_query($link, $sql);
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if(count($rows)>0)
	{
		echo count($rows);
		print_r($rows[0]['product_id']);
		echo "__";
		print_r($prod['sku']);
		$images=Array();
		for($i=0;$i<20;$i++)
		{
			if(isset($prod['image'.$i]))
			{
				$images[]=$prod['image'.$i];
			}	
		}
		echo implode(",", $images);
		$sql2="INSERT INTO oc_temptable set `product_id`='".$rows[0]['product_id']."', `description`='".$prod['description']."', `photos`='".implode(",", $images)."'";
		mysqli_query($link, $sql2);
		echo "<br>";
	}
}
?>