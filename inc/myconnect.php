<?php
$dbc=mysqli_connect('localhost','root','','qlmamnon') or die(mysqli_error());
//Nếu kết nối không thành công thì in ra lỗi
if (!$dbc)
{
	echo "Kết nối không thành công";
}
else 
{
	mysqli_set_charset($dbc,'UTF8');
}
?>