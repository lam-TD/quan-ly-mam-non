<?php
function show_news($parent_id="0",$insert_text="-")
{
	global $dbc;
	$query_dq="SELECT * FROM loaitin WHERE the_loai_cha=".$parent_id." ORDER BY the_loai_cha DESC";
	$news=mysqli_query($dbc,$query_dq);
	while($new=mysqli_fetch_array($news,MYSQLI_ASSOC))
	{
		echo("<option value='".$new["id"]."'>".$insert_text.$new['ten']."</option>");
		show_news($new["id"],$insert_text."-");
	}
	return true;
}
function selectCtrl()
{
	global $dbc;
	show_news();
	echo "</select>";
}
//thể loại Tin tức sửa
function show_news_e($uid,$parent_id1="0",$insert_text1="-")
{
	global $dbc;
	$query_dq1="SELECT DISTINCT * FROM loaitin where the_loai_cha=".$parent_id1."";	
	$news=mysqli_query($dbc,$query_dq1);
	while($new=mysqli_fetch_array($news,MYSQLI_ASSOC))
	{				
		if($uid==$new["id"])
		{			
			echo("<option selected='selected' value='".$new["id"]."'>".$insert_text1.$new['ten']."</option>");
		}
		else
		{
			echo("<option value='".$new["id"]."'>".$insert_text1.$new['ten']."</option>");
		}
		show_news_e($uid,$new["id"],$insert_text1."-");
	}
	return true;
}
function selectCtrl_e($uid)
{
	global $dbc;
	show_news_e($uid);
	echo "</select>";
}
function formatCurrencyCustom( $text ) {
	if ( strlen( $text ) > 3 ) {
		for ( $i = strlen( $text ) - 3; $i > 0; $i -= 3 ) {
			$text = substr( $text, 0, $i ) . "." . substr( $text, $i );
		}
	}
	return $text;
}

function randomDigitsLame($numDigits) {
    $digits = '';

    for ($i = 0; $i < $numDigits; ++$i) {
        $digits .= mt_rand(0, 9);
    }

    return $digits;
}
function getAge($birthDate){
	$birthDate = explode("-", $birthDate);
  	$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
		? ((date("Y") - $birthDate[0]) - 1)
		: (date("Y") - $birthDate[0]));
	if($age<=0)
		$age = 1;
	else if($age>=1)
		$age = $age +1;
	return $age;
}
?>