	<?php

if (isset($_GET['roll'])) {
	$rol = stripcslashes($_GET['roll']);
	$rol = htmlspecialchars($rol);
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.gseb.org/4102noitulover/sci/".substr($rol,0,3)."/".substr($rol,3,2)."/".$rol.".html");
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt ($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_close($ch);

$value = curl_exec($ch);
$regexp_marks='/\<td align\=\'center\'\>(.*?)\<\/td\>/';
$regexp_name = '/\<\/b\>(.*?)\<\/span\>/';
$regexp_sub = '/\<tr\>\<td align\=\'left\'\>(.*?)\<\/td\>/'; 
preg_match_all($regexp_name,$value,$matches_name);
preg_match_all($regexp_marks, $value,$matches);
preg_match_all($regexp_sub, $value,$matches_sub);

$arr = array();

foreach($matches[1] as $key => $mat)
{
		if($key%3==0)
		{
			//echo $mat."<br
		array_push($arr, $mat);
		}
}

preg_match_all('!\d+!',implode($matches_sub[1]),$arr4);

$counter = count($matches_sub[1]);
$arr2 = array_slice($arr,0,$counter);
$arr3 = array_combine($arr4[0],$arr2);
$arr3['rollno'] = $matches_name[1][0];
$arr3['name'] = $matches_name[1][1];
$arr3['sci'] = $matches_name[1][3];
$arr3['per'] = $matches_name[1][4];
$arr3['total'] = $matches[1][count($matches[1])-2];

echo json_encode($arr3);
	
?>
