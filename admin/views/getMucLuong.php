<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<?php
if ( isset( $_GET[ 'bangcapid' ] ) ) {
	$rsGetHeSo = mysqli_fetch_assoc( mysqli_query( $dbc,
		"select max(heso) as 'heso' from bangcap where bang_cap_id in ({$_GET['bangcapid']})" ) );
	$hesonNew = $rsGetHeSo[ 'heso' ];
	echo $hesonNew;
}
if ( isset( $_GET[ 'yearid' ] ) ) {
	$textResult = '<option value="0">Tháng</option>';
	if ( $_GET[ 'yearid' ] != 0 ) {
		$query = "SELECT id,thang FROM quanlyluong where nam = {$_GET[ 'yearid' ]} order by thang";
		$result = mysqli_query( $dbc, $query );

		foreach ( $result as $item ) {
			$textResult .= '<option value="' . $item[ "id" ] . '">' . $item[ "thang" ] . '</option>';
		}
	}
	echo $textResult;
}
?>