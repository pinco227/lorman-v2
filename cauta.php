<?php
require_once('config.php');
$title = '<img src="images/cauta_tl.gif" width="589" height="44" alt="">';
include('header.php');

if (isset($_POST['de_cautat'])) {
	$de_cautat = $_POST['de_cautat'];
	$de_cautat = mysqli_real_escape_string($conexiune, $de_cautat);

	$cererecauta = 'SELECT * FROM `produse` WHERE `cat`="' . $_POST['in'] . '" AND (`nume` LIKE "%' . addentities($de_cautat) . '%" OR `descriere` LIKE "%' . addentities($de_cautat) . '%")';
	$rezultatcauta = mysqli_query($conexiune, $cererecauta);

	if (mysqli_num_rows($rezultatcauta) > 0) {
		$nr = 0;
		echo '<table width="100%" cellspacing="10" cellpadding="0" border="0"><tr>';
		while ($rand = mysqli_fetch_assoc($rezultatcauta)) {
			$nr++;
			$euro = round($rand['pret'] / 3);
			if (!file_exists('images/thumb_' . $rand['poza'] . '')) $imgsrc = 'images/' . $rand['poza'] . '';
			else $imgsrc = 'images/thumb_' . $rand['poza'] . '';
			echo '<td align="center" width="50%" bgcolor="#FFFFFF"><table border="0" cellspacing="0"><tr><td width="100" align="center" valign="middle"><a href="vezi_produs.php?id=' . $rand['id'] . '"><img src="' . $imgsrc . '" width="100" alt=""></a></td>
								<td align="left" width="170" class="prod"><a href="vezi_produs.php?id=' . $rand['id'] . '"><u>' . $rand['nume'] . '</u></a><br><br>
								<b>Culori disponibile :</b> ' . $rand['culoare'] . '<br><br>
								<font color="darkred"><b>' . $rand['pret'] . ' RON / ' . $euro . ' &euro;</b></font><br><br>
								<a href="vezi_produs.php?id=' . $rand['id'] . '"><font color="darkgreen">[mai multe detalii ...]</font></a>
								</td></tr></table></td>';
			if ($nr % 2 == 0) echo '</tr><tr>';;
		}
		echo '</tr></table>';
	} else {
		echo '<br><center><font color="darkred"><b>Nu s-a gasit nici un rezultat pentru cautarea d-voastra !</b></font></center>';
	}
} else {
	echo '<br>';
}

echo '<br><center><form action="' . $_SERVER['PHP_SELF'] . '" method="post" name="cauta" class="search">
Cauta :
<input type="text" name="de_cautat" value="">
in :
<select name="in" class="select">
	<option value="">------ Alege ------</option>
	<option value="Femei">Dama</option>
	<option value="Barbati">Barbati</option>
	<option value="Bussines">Bussines</option>
</select>
<input name="cauta" type="image" src="images/cauta.gif" align="absmiddle" style="width:80; height:26;"></form></center><br>';

include('footer.php');
