<?php
require_once('config.php');

$id = $_GET['id'];
$id = mysqli_real_escape_string($conexiune, $id);

$cerereSQL = 'SELECT * FROM `produse` WHERE `id`="' . $id . '"';
$rezultat = mysqli_query($conexiune, $cerereSQL);

while ($rand = mysqli_fetch_assoc($rezultat)) {
	$title = '<img src="imagine.php?text=' . $rand['nume'] . '" alt="' . $rand['descriere'] . '" border="0" />';
}

include('header.php');

if (isset($_POST['nume'])) {
	$nume = $_POST['nume'];
	$pret = $_POST['pret'];
	$cantitate = $_POST['cantitate'];
	$culoare = $_POST['culoare'];
	$marime = $_POST['marime'];
	$gat = $_POST['gat'];
	$bust = $_POST['bust'];
	$sub_bust = $_POST['sub_bust'];
	$talie = $_POST['talie'];
	$solduri = $_POST['solduri'];
	$umar = $_POST['umar'];
	$maneca = $_POST['maneca'];
	$coapsa = $_POST['coapsa'];
	$terminatie = $_POST['terminatie'];
	$interior = $_POST['interior'];
	$lungime = $_POST['lungime'];

	$nume = mysqli_real_escape_string($conexiune, $nume);
	$pret = mysqli_real_escape_string($conexiune, $pret);
	$cantitate = mysqli_real_escape_string($conexiune, $cantitate);
	$culoare = mysqli_real_escape_string($conexiune, $culoare);
	$marime = mysqli_real_escape_string($conexiune, $marime);
	$gat = mysqli_real_escape_string($conexiune, $gat);
	$bust = mysqli_real_escape_string($conexiune, $bust);
	$sub_bust = mysqli_real_escape_string($conexiune, $sub_bust);
	$talie = mysqli_real_escape_string($conexiune, $talie);
	$solduri = mysqli_real_escape_string($conexiune, $solduri);
	$umar = mysqli_real_escape_string($conexiune, $umar);
	$maneca = mysqli_real_escape_string($conexiune, $maneca);
	$coapsa = mysqli_real_escape_string($conexiune, $coapsa);
	$terminatie = mysqli_real_escape_string($conexiune, $terminatie);
	$interior = mysqli_real_escape_string($conexiune, $interior);
	$lungime = mysqli_real_escape_string($conexiune, $lungime);

	$_SESSION['nume'] = $nume;
	$_SESSION['pret'] = $pret;
	$_SESSION['cantitate'] = $cantitate;
	$_SESSION['culoare'] = $culoare;
	$_SESSION['marime'] = $marime;
	$_SESSION['gat'] = $gat;
	$_SESSION['bust'] = $bust;
	$_SESSION['sub_bust'] = $sub_bust;
	$_SESSION['talie'] = $talie;
	$_SESSION['solduri'] = $solduri;
	$_SESSION['umar'] = $umar;
	$_SESSION['maneca'] = $maneca;
	$_SESSION['coapsa'] = $coapsa;
	$_SESSION['terminatie'] = $terminatie;
	$_SESSION['interior'] = $interior;
	$_SESSION['lungime'] = $lungime;

	if (($_SESSION['cantitate'] == '') || ($_SESSION['nume'] == '') || ($_SESSION['pret'] == '') || ($_SESSION['culoare'] == '') || (!is_numeric($_SESSION['cantitate']))) {
		echo '<table width="250" align="center" cellspacing="5" cellpading="5">
					<tr>
						<td class="error" align="center">
							<b>ERROR !</b>
						</td>
					</tr>';
		if (($_SESSION['cantitate'] == '') || (!is_numeric($_SESSION['cantitate']))) {
			echo '  <tr>
							<td class="error" align="center">
								Introduceti cantitatea care doriti sa o comandati !
							</td>
						</tr>';
		}
		if ($_SESSION['nume'] == '') {
			echo '';
		}
		if ($_SESSION['pret'] == '') {
			echo '';
		}
		if ($_SESSION['culoare'] == '') {
			echo '';
		}
		echo '</table>';
	} else {
		$table = getUserIpAddr();
		$table = str_replace('.', '_', $table);

		$pret = $_SESSION['pret'];
		$nr_produse = $_SESSION['cantitate'];
		$pret2 = $pret * $nr_produse;

		$adaugaSQL1 = 'CREATE TABLE IF NOT EXISTS `' . $table . '` (
								`id` int(11) auto_increment,
								`nume` char(60),
								`pret` char(11),
								`cantitate` char(11),
								`culoare` char(20),
								`marime` char(20),
								`gat` char(11),
								`bust` char(11),
								`sub_bust` char(11),
								`talie` char(11),
								`solduri` char(11),
								`umar` char(11),
								`maneca` char(11),
								`coapsa` char(11),
								`terminatie` char(11),
								`interior` char(11),
								`lungime` char(11),
								PRIMARY KEY  (`id`));';
		mysqli_query($conexiune, $adaugaSQL1);

		$adaugaSQL2 = 'INSERT INTO `' . $table . '` (`nume`, `pret`, `cantitate`, `culoare`, `marime`, `gat`, `bust`, `sub_bust`, `talie`, `solduri`, `umar`, `maneca`, `coapsa`, `terminatie`, `interior`, `lungime`) 
                   			   VALUES ( 
							   "' . $_SESSION['nume'] . '",
							   "' . $pret2 . '",
							   "' . $_SESSION['cantitate'] . '",
							   "' . $_SESSION['culoare'] . '",
							   "' . $_SESSION['marime'] . '",
							   "' . $_SESSION['gat'] . '",
							   "' . $_SESSION['bust'] . '",
							   "' . $_SESSION['sub_bust'] . '",
							   "' . $_SESSION['talie'] . '",
							   "' . $_SESSION['solduri'] . '",
							   "' . $_SESSION['umar'] . '",
							   "' . $_SESSION['maneca'] . '",
							   "' . $_SESSION['coapsa'] . '",
							   "' . $_SESSION['terminatie'] . '",
							   "' . $_SESSION['interior'] . '",
							   "' . $_SESSION['lungime'] . '"
							   );';
		mysqli_query($conexiune, $adaugaSQL2);

		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=vezi_cos.php">';

		$_SESSION['nume'] = '';
		$_SESSION['pret'] = '';
		$_SESSION['cantitate'] = '';
		$_SESSION['culoare'] = '';
		$_SESSION['marime'] = '';
		$_SESSION['gat'] = '';
		$_SESSION['bust'] = '';
		$_SESSION['sub_bust'] = '';
		$_SESSION['talie'] = '';
		$_SESSION['solduri'] = '';
		$_SESSION['umar'] = '';
		$_SESSION['maneca'] = '';
		$_SESSION['coapsa'] = '';
		$_SESSION['terminatie'] = '';
		$_SESSION['interior'] = '';
		$_SESSION['lungime'] = '';
	}
} else {
	echo '<br>';
}

if ((!is_numeric($id)) || (substr_count($id, " ") > 0)) {
	echo '<br><center><font color="darkred"><b>Eroare ! ID-ul nu este numeric !</b></font></center>';
} else {
	$cerereSQL = 'SELECT * FROM `produse` WHERE `id`="' . $id . '"';
	$rezultat = mysqli_query($conexiune, $cerereSQL);

	while ($rand = mysqli_fetch_assoc($rezultat)) {
		$poza = 'images/' . $rand['poza'];
		list($width, $height) = getimagesize($poza);
		$maxwidth = '530';

		if ($width > $maxwidth) {
			$picwidth = $maxwidth;
			$picheight = round($height / ($width / $maxwidth));
		} else {
			$picwidth = $width;
			$picheight = $height;
		}

		$_SESSION['pret'] = $rand['pret'];

		$string = $rand['culoare'];
		$exploded = explode(",", $string);

		$start = 0;
		$finish = count($exploded);
		$euro = round($rand['pret'] / 3);
		echo '<form action="vezi_produs.php?id=' . $_GET['id'] . '" method="post" name="adauga_cos">
							<table border="0" cellpadding="0" cellspacing="10" align="center" width="100%">
										<tr>
											<td width="100%" align="center" valign="middle" bgcolor="white" colspan="2">
												<input type="hidden" name="nume" value="' . $rand['nume'] . '"><br>
												<img src="images/' . $rand['poza'] . '" border="0" width="' . $picwidth . '" height="' . $picheight . '"><br><br>
												' . $rand['descriere'] . '<br><br>
												<font color="red">' . $rand['pret'] . ' RON / ' . $euro . ' &euro;</font>
											</td>
										</tr>
										<tr bgcolor="white">
											<td align="right" bgcolor="white">
												Culori disponibile :<br>
												Cantitate :<br>
												Marime :
											</td>
											<td bgcolor="white">
												<select name="culoare">';
		while ($start < $finish) {
			echo '<option value="' . $exploded[$start] . '">' . $exploded[$start] . '</option>';
			$start = $start + 1;
		}
		echo '</select><br>';
		if ($rand['subcat'] == 'Pantaloni') {
			echo '<input type="text" name="cantitate" size="5" value="1"><br>
												<select name="marime" size="1">
													<option selected="selected" value=""></option>
													<option value="28">28</option>
													<option value="30">30</option>
													<option value="32">32</option>
													<option value="34">34</option>
													<option value="36">36</option>
													<option value="38">38</option>
													<option value="40">40</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												SAU TRECE-TI DIMENSIUNILE TALE
											</td>
										</tr>';
			echo '<tr bgcolor="white">
											<td bgcolor="white">
												<table>
													<tr><td>Lungime :</td>
														<td><input type="text" name="lungime" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Talie :</td>
														<td><input type="text" name="talie" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Solduri :</td>
														<td><input type="text" name="solduri" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Coapsa :</td>
														<td><input type="text" name="coapsa" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Terminatie :</td>
														<td>
															<select name="terminatie">
																<option value="-">-</option>
																<option value="evazat">Evazat</option>
																<option value="drept">Drept</option>
																<option value="pana">Pana</option>
															</select>										</td>
													</tr>
													<tr><td>Interior :</td>
														<td><input type="text" name="interior" size="10" value="-" maxlength="4"> cm</td>
													</tr>
												</table>
											</td>
											<td bgcolor="white">
												<img src="images/pantalon.jpg">
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												<input type="hidden" name="pret" value="' . $rand['pret'] . '">
												<input type="hidden" name="maneca" value="-">
												<input type="hidden" name="umar" value="-">
												<input type="hidden" name="gat" value="-">
												<input type="hidden" name="bust" value="-">
												<input type="hidden" name="sub_bust" value="-">
												<input type="image" src="images/adauga.gif" name="adauga_cos" value="Adauga in cos !" style="width: 150px; height: 40px;">							
											</td>
										</tr>';
		} elseif ($rand['subcat'] == 'Corsete') {
			echo '<input type="text" name="cantitate" size="5" value="1"><br>
												<select name="marime" size="1">
													<option selected="selected" value=""></option>
													<option value="XS">XS</option>
													<option value="S">S</option>
													<option value="M">M</option>
													<option value="L">L</option>
													<option value="XL">XL</option>
													<option value="XXL">XXL</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												SAU TRECE-TI DIMENSIUNILE TALE
											</td>
										</tr>';
			echo '<tr bgcolor="white">
											<td bgcolor="white">
												<table>
													<tr><td>Lungime :</td>
														<td><input type="text" name="lungime" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Gat :</td>
														<td><input type="text" name="gat" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Bust :</td>
														<td><input type="text" name="bust" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Sub bust :</td>
														<td><input type="text" name="sub_bust" size="10" value="-" maxlength="4"> cm</td>
													</tr>
												</table>							</td>
											<td bgcolor="white">
												<img src="images/corset.jpg">							</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												<input type="hidden" name="pret" value="' . $rand['pret'] . '">
												<input type="hidden" name="maneca" value="-">
												<input type="hidden" name="umar" value="-">
												<input type="hidden" name="talie" value="-">
												<input type="hidden" name="coapsa" value="-">
												<input type="hidden" name="terminatie" value="-">
												<input type="hidden" name="interior" value="-">
												<input type="hidden" name="solduri" value="-">
												<input type="image" src="images/adauga.gif" name="adauga_cos" value="Adauga in cos !" style="width: 150px; height: 40px;">							
											</td>
										</tr>';
		} elseif ($rand['subcat'] == 'Pantaloni scurti') {
			echo '<input type="text" name="cantitate" size="5" value="1"><br>
												<select name="marime" size="1">
													<option selected="selected" value=""></option>
													<option value="0">0</option>
													<option value="2">2</option>
													<option value="4">4</option>
													<option value="6">6</option>
													<option value="8">8</option>
													<option value="10">10</option>
													<option value="12">12</option>
													<option value="14">14</option>
													<option value="16">16</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												SAU TRECE-TI DIMENSIUNILE TALE
											</td>
										</tr>';
			echo '<tr bgcolor="white">
											<td bgcolor="white">
												<table>
													<tr><td>Lungime :</td>
														<td><input type="text" name="lungime" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Talie :</td>
														<td><input type="text" name="talie" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Solduri :</td>
														<td><input type="text" name="solduri" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Coapsa :</td>
														<td><input type="text" name="coapsa" size="10" value="-" maxlength="4"> cm</td>
													</tr>
												</table>							</td>
											<td bgcolor="white">
												<img src="images/sort.jpg">							</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												<input type="hidden" name="pret" value="' . $rand['pret'] . '">
												<input type="hidden" name="maneca" value="-">
												<input type="hidden" name="umar" value="-">
												<input type="hidden" name="bust" value="-">
												<input type="hidden" name="sub_bust" value="-">
												<input type="hidden" name="terminatie" value="-">
												<input type="hidden" name="interior" value="-">
												<input type="hidden" name="gat" value="-">
												<input type="image" src="images/adauga.gif" name="adauga_cos" value="Adauga in cos !" style="width: 150px; height: 40px;">							
											</td>
										</tr>';
		} elseif ($rand['subcat'] == 'Fuste') {
			echo '<input type="text" name="cantitate" size="5" value="1"><br>
												<select name="marime" size="1">
													<option selected="selected" value=""></option>
													<option value="36">36</option>
													<option value="38">38</option>
													<option value="40">40</option>
													<option value="42">42</option>
													<option value="44">44</option>
													<option value="46">46</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												SAU TRECE-TI DIMENSIUNILE TALE
											</td>
										</tr>';
			echo '<tr bgcolor="white">
											<td bgcolor="white">
												<table>
													<tr><td>Lungime :</td>
														<td><input type="text" name="lungime" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Talie :</td>
														<td><input type="text" name="talie" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Solduri :</td>
														<td><input type="text" name="solduri" size="10" value="-" maxlength="4"> cm</td>
													</tr>
												</table>							</td>
											<td bgcolor="white">
												&nbsp;							</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												<input type="hidden" name="pret" value="' . $rand['pret'] . '">
												<input type="hidden" name="maneca" value="-">
												<input type="hidden" name="umar" value="-">
												<input type="hidden" name="coapsa" value="-">
												<input type="hidden" name="terminatie" value="-">
												<input type="hidden" name="interior" value="-">
												<input type="hidden" name="gat" value="-">
												<input type="hidden" name="bust" value="-">
												<input type="hidden" name="sub_bust" value="-">
												<input type="image" src="images/adauga.gif" name="adauga_cos" value="Adauga in cos !" style="width: 150px; height: 40px;">							
											</td>
										</tr>';
		} else {
			echo '<input type="text" name="cantitate" size="5" value="1"><br>
												<select name="marime" size="1">
													<option selected="selected" value=""></option>
													<option value="XS">XS</option>
													<option value="S">S</option>
													<option value="M">M</option>
													<option value="L">L</option>
													<option value="XL">XL</option>
													<option value="XXL">XXL</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												SAU TRECE-TI DIMENSIUNILE TALE
											</td>
										</tr>';
			echo '<tr bgcolor="white">
											<td bgcolor="white">
												<table>
													<tr><td>Lungime :</td>
														<td><input type="text" name="lungime" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Umar :</td>
														<td><input type="text" name="umar" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Gat :</td>
														<td><input type="text" name="gat" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Bust :</td>
														<td><input type="text" name="bust" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Talie :</td>
														<td><input type="text" name="talie" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Solduri :</td>
														<td><input type="text" name="solduri" size="10" value="-" maxlength="4"> cm</td>
													</tr>
													<tr><td>Maneca :</td>
														<td><input type="text" name="maneca" size="10" value="-" maxlength="4"> cm</td>
													</tr>
												</table>							</td>
											<td bgcolor="white">
												<img src="images/geaca.jpg">							</td>
										</tr>
										<tr>
											<td colspan="2" align="center" bgcolor="white">
												<input type="hidden" name="pret" value="' . $rand['pret'] . '">
												<input type="hidden" name="coapsa" value="-">
												<input type="hidden" name="terminatie" value="-">
												<input type="hidden" name="interior" value="-">
												<input type="hidden" name="sub_bust" value="-">
												<input type="image" src="images/adauga.gif" name="adauga_cos" value="Adauga in cos !" style="width: 150px; height: 40px;">							
											</td>
										</tr>';
		}
		echo '</table>
						</form>';
	}
}

require('footer.php');
