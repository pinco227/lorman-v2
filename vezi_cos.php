<?php
require_once('config.php');
$title = '<img src="images/cos_tl.gif" width="589" height="44" alt="">';
include('header.php');


$table = getUserIpAddr();
$table = str_replace('.', '_', $table);
$cerere = mysqli_query($conexiune, 'SELECT `id` FROM `' . $table . '`');

if ($cerere) {
	$intrari_totale = mysqli_num_rows($cerere);

	if ($intrari_totale == 0) {
		echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs adaugat in cos !</b></font></center>';
	} else {
		echo '<center><font color="darkred"><b>Pentru a nu se supraincarca baza de date , va rugam stergeti produsele din cos daca nu doriti sa le comandati !</b></font></center><table><tr><td></td></tr></table>';

		echo '<table width="100%" border="0" cellspacing="5" cellpadding="3" align="center" class="cos2">
				<tr>
					<td align="center" bgcolor="#FFFFFF"><b>Nume</b></td>
					<td align="center" bgcolor="#FFFFFF"><b>Cantitate</b></td>
					<td align="center" bgcolor="#FFFFFF"><b>Culoare</b></td>
					<td align="center" bgcolor="#FFFFFF"><b>Marime</b></td>
					<td align="center" bgcolor="#FFFFFF"><b>Pret</b></td>
					<td align="center" bgcolor="#FFFFFF"><b>Sterge</b></td>
				</tr>';

		$cerereSQL = 'SELECT * FROM `' . $table . '` ORDER BY `id`';
		$rezultat = mysqli_query($conexiune, $cerereSQL);

		while ($rand = mysqli_fetch_assoc($rezultat)) {
			if ($rand['marime'] == '') $mar = 'Optional';
			else $mar = $rand['marime'];
			$euro = round($rand['pret'] / 3);
			if ($intrari_totale == 1) {
				$all = '&all=da';
			} else {
				$all = '';
			}
			echo '
				<tr>
					<td align="center" bgcolor="#FFFFFF">' . $rand['nume'] . '</td>
					<td align="center" bgcolor="#FFFFFF">' . $rand['cantitate'] . '</td>
					<td align="center" bgcolor="#FFFFFF">' . $rand['culoare'] . '</td>
					<td align="center" bgcolor="#FFFFFF">' . $mar . '</td>
					<td align="center" bgcolor="#FFFFFF">' . $rand['pret'] . 'ron/' . $euro . '&euro;</td>
					<td align="center" bgcolor="#FFFFFF"><a href="sterge.php?id=' . $rand['id'] . '' . $all . '" style="color:red;">[x]</a></td>
				</tr>';
		}
		$cerereSUM = 'SELECT SUM(`pret`) FROM `' . $table . '`';
		$pret_total = mysqli_num_rows(mysqli_query($conexiune, $cerereSUM));
		$euro2 = round($pret_total / 3);
		echo '
				<tr>
					<td align="center" colspan="4" bgcolor="#FFFFFF"><b>TOTAL</b></td>
					<td align="center" bgcolor="#FFFFFF"><font color="red"><b>' . $pret_total . 'ron/' . $euro2 . '&euro;</b></font></td>
					<td bgcolor="#FFFFFF">&nbsp;</td>
				</tr>';
		echo '</table><br>';
		echo '<center><b><a href="trimite.php"><img src="images/trimite.gif" width="150" height="40"></a></b></center>
			<table><tr><td></td></tr></table>
			<center><b><a href="index.php"><img src="images/alte_prod.gif" width="150" height="40"></a></b></center>';
	}
} else {
	echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs adaugat in cos !</b></font></center>';
}

include('footer.php');
