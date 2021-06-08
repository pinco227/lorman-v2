<?php
require_once('config.php');

$title = '<img src="images/trimite_tl.gif" width="589" height="44" alt="">';

include('header.php');


if ((isset($_POST['comanda'])) || ($_POST['nume'] != '')) {
	if (($_POST['nume'] == '') || ($_POST['prenume'] == '') || ($_POST['tel'] == '') || (!is_numeric($_POST['tel'])) || ($_POST['adresa'] == '')) {
		echo '
			<table align="center" width="300" cellspacing="5" cellpadding="5">
				<tr>
					<td class="error" align="center">
						<b>ERROR !</b>
					</td>
				</tr>';
		if ($_POST['nume'] == '') echo '<tr><td class="error" align="center">Introduceti va rog numele d-voastra !</td></tr>';
		else echo '';
		if ($_POST['prenume'] == '') echo '<tr><td class="error" align="center">Introduceti va rog prenumele d-voastra !</td></tr>';
		else echo '';
		if ($_POST['tel'] == '') echo '<tr><td class="error" align="center">Introduceti va rog numarul d-voastra de telefon !</td></tr>';
		else echo '';
		if (!is_numeric($_POST['tel'])) echo '<tr><td class="error" align="center">Numarul de telefon nu este valid !</td></tr>';
		else echo '';
		if ($_POST['adresa'] == '') echo '<tr><td class="error" align="center">Introduceti va rog adresa d-voastra !</td></tr>';
		else echo '';
		echo '</table>';
	} else {
		$table = getUserIpAddr();
		$table = str_replace('.', '_', $table);

		$catre = 'dilymanu@yahoo.com, birou@lorman.ro';
		$data_trimitere = date('d-m-Y H:i:s');
		$subiect = 'Comanda ' . $data_trimitere . '';

		$cerereSQL = 'SELECT * FROM `' . $table . '` ORDER BY `id`';
		$rezultat = mysqli_query($conexiune, $cerereSQL);

		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$afis .= '
				<tr bgcolor="#E4E4E4">
					<td align="center">' . $rand['nume'] . '</td>
					<td align="center">' . $rand['cantitate'] . '</td>
					<td align="center">' . $rand['culoare'] . '</td>
					<td align="center">' . $rand['marime'] . '</td>
					<td align="center">' . $rand['gat'] . '</td>
					<td align="center">' . $rand['bust'] . '</td>
					<td align="center">' . $rand['sub_bust'] . '</td>
					<td align="center">' . $rand['talie'] . '</td>
					<td align="center">' . $rand['solduri'] . '</td>
					<td align="center">' . $rand['umar'] . '</td>
					<td align="center">' . $rand['maneca'] . '</td>
					<td align="center">' . $rand['coapsa'] . '</td>
					<td align="center">' . $rand['terminatie'] . '</td>
					<td align="center">' . $rand['interior'] . '</td>
					<td align="center">' . $rand['lungime'] . '</td>
					<td align="center">' . $rand['pret'] . '</td>
				</tr>';
		}
		$cerereSUM = 'SELECT SUM(`pret`) FROM `' . $table . '`';
		$pret_total = mysqli_num_rows(mysqli_query($conexiune, $cerereSUM));
		$mesaj = '
		<html>
		<head>
		<title>Comanda noua !</title>
		</head>
		<body>
		Data trimiterii : ' . $data_trimitere . ' <br>
		Nume : <b>' . $_POST['nume'] . '</b> <br>
		Prenume : <b>' . $_POST['prenume'] . '</b><br>
		Tel : <b>' . $_POST['tel'] . '</b><br>
		Adresa : <b>' . $_POST['adresa'] . '</b><br>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" border="1" bordercolor="#FFFFFF" align="center">
			<tr bgcolor="#CCCCCC">
				<td align="center">Nume</td>
				<td align="center">Cantitate</td>
				<td align="center">Culoare</td>
				<td align="center">Marime</td>
				<td align="center">Gat</td>
				<td align="center">Bust</td>
				<td align="center">Sub bust</td>
				<td align="center">Talie</td>
				<td align="center">Solduri</td>
				<td align="center">Umar</td>
				<td align="center">Maneca</td>
				<td align="center">Coapsa</td>
				<td align="center">Terminatie</td>
				<td align="center">Interior</td>
				<td align="center">Lungime</td>
				<td align="center">Pret</td>
			</tr>
			' . $afis . '
			<tr bgcolor="#E4E4E4">
				<td align="center" colspan="15"><b>TOTAL</b></td>
				<td align="center"><font color="red"><b>' . $pret_total . '</b></font></td>
			</tr>
		</table>
		</body></html>';
		$headere = "MIME-Version: 1.0\r\n";
		$headere .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headere .= "From: " . $_POST['nume'] . " " . $_POST['prenume'] . " <LorMan di Mano>\r\n";

		mail($catre, $subiect, $mesaj, $headere);

		echo '<center><br><br><b><font color="green">Comanda a fost efectuata cu succes !<br>Veti fi contactat telefonic in maxim 24 de ore pentru confirmare !</font></b><br><br></center>';

		$table = getUserIpAddr();
		$table = str_replace('.', '_', $table);
		$stergeSQL = 'DROP TABLE `' . $table . '`;';
		mysqli_query($conexiune, $stergeSQL);
	}
}

$table = getUserIpAddr();
$table = str_replace('.', '_', $table);

$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT `id` FROM `' . $table . '`'));

if ($intrari_totale == 0) {
	echo '<br><center><font color="darkred"><b>Nu ai nici un produs in cos !</b></font></center>';
} else {
	echo '<br>
	<form name="comanda" method="post" action="trimite.php">
	<table border="0" cellspacing="5" cellpadding="5" width="300" align="center">
		<tr>
			<td align="right" class="admin">Nume :</td>
			<td class="admin" align="left"><input type="text" name="nume" size="25"></td>
		</tr>
		<tr>
			<td class="admin" align="right">Prenume :</td>
			<td class="admin" align="left"><input type="text" name="prenume" size="25"></td>
		</tr>
		<tr>
			<td class="admin" align="right">Nr. de telefon</td>
			<td class="admin" align="left"><input type="text" name="tel" size="25"></td>
		</tr>
		<tr>
			<td class="admin" align="right">Adresa :</td>
			<td class="admin" align="left"><textarea name="adresa" cols="19" rows="3"></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="image" src="images/trimite.gif" name="comanda" value="Comanda!" style="width: 150px; height: 40px;"></td>
		</tr>
	</table>
	</form>';
}

include('footer.php');
