<?php
$link = mysqli_connect("fp432115.mysql.tools", "fp432115_velokvartal", "mc7-*X97Zn", "fp432115_velokvartal");
mysqli_set_charset($link, "utf8");
$items=simplexml_load_file('https://portal.veloplaneta.com.ua/upload/offers/bc0449df-1322-11e3-8487-a949c35f59f2_4e2817b9-1323-11e3-8487-a949c35f59f2.xml', null, LIBXML_NOCDATA);
foreach($items->shop->offers[0] as $prod)
{
	$prod = (array) $prod;


	

	$sql="SELECT `product_id` FROM `oc_product` WHERE `model`='".$prod['vendorCode']."'";
	$result = mysqli_query($link, $sql);
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if(count($rows)>0)
	{
		echo count($rows);
		print_r($rows[0]['product_id']);
		echo "__";
		print_r($prod['vendorCode']);


		



		if(isset($prod['picture']))
		{
			if(is_array($prod['picture']))
			{
				$im=implode(",",$prod['picture']);
			}else{
				$im=$prod['picture'];
			}
		}else{
			$im='';
		}
		$sql2="INSERT INTO oc_temptable set `product_id`='".$rows[0]['product_id']."', `description`='".$prod['description']."', `photos`='".$im."'";
		mysqli_query($link, $sql2);
		echo "<br>";
	}

}
?>