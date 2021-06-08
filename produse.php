<?php
require_once('config.php');

if ($_GET['cat'] == 'Femei') $title = '<img src="images/produse_f.gif" width="589" height="44" alt="">';
elseif ($_GET['cat'] == 'Barbati') $title = '<img src="images/produse_b.gif" width="589" height="44" alt="">';
elseif ($_GET['cat'] == 'Bussines') $title = '<img src="images/produse_bs.gif" width="589" height="44" alt="">';
else $title = '';

include('header.php');

$cat = $_GET['cat'];
$subcat = $_GET['subcat'];
$cat = mysqli_real_escape_string($conexiune, $cat);
$subcat = mysqli_real_escape_string($conexiune, $subcat);
$rezultate_maxime = 10;
$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT `id` FROM `produse` WHERE `cat`="' . $cat . '" AND `subcat`="' . $subcat . '"'));

if ($intrari_totale == 0) {
	echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs in baza de date !</b></font></center>';
} else {
	if (!isset($_GET['page'])) $pagina = 1;
	else $pagina = $_GET['page'];
	$nr = 0;
	$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
	$cerereSQL = 'SELECT * FROM `produse` WHERE `cat`="' . $cat . '" AND `subcat`="' . $subcat . '" ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	$pagini_totale = ceil($intrari_totale / $rezultate_maxime);

	if ($pagina > $pagini_totale) echo 'Pagina nu exista !';
	else {
		if ($pagini_totale > 0) {
			echo '<table width="100%" cellspacing="10" cellpadding="0" border="0"><tr>';

			while ($rand = mysqli_fetch_assoc($rezultat)) {
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
				if ($nr % 2 == 0) echo '</tr><tr>';
			}
			echo '</tr></table>';

			if ($pagini_totale == 1) echo '<div align=left> </div>';
			else {

				echo '<div align="center">';

				for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
					if (($pagina) == $pagini) echo '<b><font color="#B98D26" style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
					else echo '<a href="produse.php?cat=' . $_GET['cat'] . '&subcat=' . $_GET['subcat'] . '&page=' . $pagini . '">' . $pagini . '</a>&nbsp;';
				}
				echo '</div>';
				echo '<table width="100%"><tr>
							<td align="left">';
				if ($pagina > 1) {
					$inapoi = ($pagina - 1);
					echo '<a href="produse.php?cat=' . $_GET['cat'] . '&subcat=' . $_GET['subcat'] . '&page=' . $inapoi . '"><img src="images/anterioara.gif" width="130" height="33"></a>';
				}
				echo '</td>
							<td align="right">';
				if ($pagina < $pagini_totale) {
					$inainte = ($pagina + 1);
					echo '<a href="produse.php?cat=' . $_GET['cat'] . '&subcat=' . $_GET['subcat'] . '&page=' . $inainte . '"><img src="images/urmatoare.gif" width="130" height="33"></a>';
				}
				echo '</td>
						  </tr></table>';
			}
		}
	}
}
include('footer.php');
