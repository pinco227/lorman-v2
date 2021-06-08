<?php
require_once('config.php');


$id = $_GET['id'];
$id = mysqli_real_escape_string($conexiune, $id);

if ((!is_numeric($id)) || (substr_count($id, " ") > 0)) {
	echo '<br><center><font color="darkred"><b>Eroare ! ID-ul nu este numeric !</b></font></center>';
} else {
	$table = getUserIpAddr();
	$table = str_replace('.', '_', $table);

	$cerereSQL = "DELETE FROM `" . $table . "` WHERE `id`='" . htmlentities($id, ENT_QUOTES) . "'";
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=vezi_cos.php">';
}

if (isset($_GET['all'])) {
	if ($_GET['all'] == 'da') {
		$table = getUserIpAddr();
		$table = str_replace('.', '_', $table);
		$stergeSQL = 'DROP TABLE `' . $table . '`;';
		mysqli_query($conexiune, $stergeSQL);
	} else {
		echo '';
	}
} else {
	echo '';
}
