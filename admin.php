<?php
require_once('config.php');
$title = '<img src="images/admin_tl.gif" width="589" height="44" alt="">';
include('header.php');
if (!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';

if ($_SESSION['logat'] == 'Da') {

	echo '<br><br><center><a href="admin.php?action=add">Adauga Produse</a> | <a href="admin.php?action=lista">Lista Produse</a> | <a href="admin.php?action=add2">Adauga Anunturi</a> | <a href="admin.php?action=lista2">Lista Anunturi</a> <br> <a href="admin.php?action=add3">Adauga Admini</a> | <a href="admin.php?action=lista3">Lista Admini</a> | <a href="admin.php?action=logoff">Iesire [' . $_SESSION['username'] . ']</a><br><br></center>';

	///////////////////////////////////////////////////////////////////////////////
	//  ADAUGA PRODUS   ///////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	if ($_GET['action'] == 'add') {
		if (isset($_POST['add'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['descriere'] = $_POST['descriere'];
			$_SESSION['culori'] = $_POST['culori'];
			$_SESSION['pret'] = $_POST['pret'];
			$_SESSION['cat'] = $_POST['cat'];
			$_SESSION['subcat'] = $_POST['subcat'];
			$_SESSION['imp'] = $_POST['imp'];

			if (($_SESSION['nume'] == '') || ($_SESSION['descriere'] == '') || ($_SESSION['culori'] == '') || ($_SESSION['pret'] == '') || ($_SESSION['cat'] == '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td class="error" align="center"><b>ERROR !</b></td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td class="error" align="center">Introdu te rog numele produsului !</td></tr>';
				if ($_SESSION['descriere'] == '') echo '<tr><td class="error" align="center">Introdu te rog descrierea produsului !</td></tr>';
				if ($_SESSION['culori'] == '') echo '<tr><td class="error" align="center">Introdu te rog culorile disponibile acestui produs !</td></tr>';
				if ($_SESSION['pret'] == '') echo '<tr><td class="error" align="center">Introdu te rog pretul produsului !</td></tr>';
				if ($_SESSION['cat'] == '') echo '<tr><td class="error" align="center">Alege te rog colectia din care face parte produsul !</td></tr>';
				echo '</table>';
			} else {

				$uploadpath = "images/";
				$file = $_SESSION['nume'] . '.jpg';
				$uploadpath = $uploadpath . basename($file);
				if (!move_uploaded_file($_FILES["poza"]["tmp_name"], $uploadpath))
					die("There was an error uploading the file, please try again!");

				$image_name = "images/" . $_FILES["poza"]["name"];
				$nume_nou = $_SESSION['nume'] . ".jpg";
				list($width, $height) = getimagesize($image_name);
				$new_image_name = "images/thumb_" . $_SESSION['nume'] . ".jpg";
				$ratio = ($width / 100);
				$new_width = 100;
				$new_height = ($height / $ratio);
				$image_p = imagecreatetruecolor($new_width, $new_height);
				$image = imagecreatefromjpeg($image_name);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagejpeg($image_p, $new_image_name, 100);


				$cerereSQL = "INSERT INTO `produse` ( `nume`, `descriere`, `culoare`, `pret`, `poza`, `cat`, `subcat`, `imp`) 
											VALUES ( '" . htmlentities($_SESSION['nume'], ENT_QUOTES) . "', 
													 '" . htmlentities($_SESSION['descriere'], ENT_QUOTES) . "', 
													 '" . htmlentities($_SESSION['culori'], ENT_QUOTES) . "', 
													 '" . htmlentities($_SESSION['pret'], ENT_QUOTES) . "',
													 '" . htmlentities($nume_nou, ENT_QUOTES) . "',
													 '" . htmlentities($_SESSION['cat'], ENT_QUOTES) . "',
													 '" . htmlentities($_SESSION['subcat'], ENT_QUOTES) . "',
													 '" . htmlentities($_SESSION['imp'], ENT_QUOTES) . "')";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Produsul s-a adaugat cu succes !</b></center></font><br>';
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=admin.php?action=lista">';
			}

			$_SESSION['nume'] = '';
			$_SESSION['descriere'] = '';
			$_SESSION['culori'] = '';
			$_SESSION['pret'] = '';
			$_SESSION['cat'] = '';
			$_SESSION['subcat'] = '';
			$_SESSION['imp'] = '';
		} else {
			echo '';
		}

		echo '<form name="add" action="admin.php?action=add" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="right" class="admin"><b>Nume:</b></td>
							<td class="admin" align="left"><input type="text" size="30" name="nume"></td>   
						</tr>
						<tr>
							<td align="right" class="admin"><b>Descriere:</b></td>
							<td align="left" class="admin"><textarea cols="23" rows="3" name="descriere"></textarea></td>   
						</tr>
						<tr>
							<td align="right" class="admin"><b>Culori:</b></td>
							<td align="left" class="admin"><input type="text" size="30" name="culori"></td>   
						</tr>
						<tr>
							<td align="right" class="admin"><b>Pret:</b></td>
							<td align="left" class="admin"><input type="text" size="30" name="pret"> RON</td>   
						</tr>
						<tr>
							<td align="right" class="admin"><b>Colectii:</b></td>
							<td align="left" class="admin">
							<select name="cat" size="1" onChange="redirect(this.options.selectedIndex)">
								<option value="">--Alege1--</option>
								<option value="Femei">Femei</option>
								<option value="Barbati">Barbati</option>
								<option value="Bussines">Bussines</option>
							</select>
							<select name="subcat" size="1">
								<option value="">--Alege2--</option>
							</select>
							<script>
							
								var groups=document.add.cat.options.length
								var group=new Array(groups)
								for (i=0; i<groups; i++)
								group[i]=new Array()
							
								group[0][0]=new Option("","--Alege2--")
								
								group[1][0]=new Option("Sacouri","Sacouri")
								group[1][1]=new Option("Scurte","Scurte")
								group[1][2]=new Option("Haine lungi","Haine lungi")
								group[1][3]=new Option("Jackete","Jackete")
								group[1][4]=new Option("Veste","Veste")
								group[1][5]=new Option("Biker","Biker")
								group[1][6]=new Option("Pantaloni","Pantaloni")
								group[1][7]=new Option("Rochii","Rochii")
								group[1][8]=new Option("Fuste","Fuste")
								group[1][9]=new Option("Pantaloni scurti","Pantaloni scurti")
								group[1][10]=new Option("Corsete","Corsete")
								
								group[2][0]=new Option("Sacouri","Sacouri")
								group[2][1]=new Option("Scurte","Scurte")
								group[2][2]=new Option("Haine lungi","Haine lungi")
								group[2][3]=new Option("Jackete","Jackete")
								group[2][4]=new Option("Veste","Veste")
								group[2][5]=new Option("Biker","Biker")
								group[2][6]=new Option("House","House")
								group[2][7]=new Option("Pantaloni","Pantaloni")
								
								group[3][0]=new Option("Masculin","Masculin")
								group[3][1]=new Option("Dama","Dama")
				
								var temp=document.add.subcat
				
								function redirect(x){
								for (m=temp.options.length-1;m>0;m--)
								temp.options[m]=null
								for (i=0;i<group[x].length;i++){
								temp.options[i]=new Option(group[x][i].text,group[x][i].value)
								}
								temp.options[0].selected=true
								}
				
							</script>
							</td>   
						</tr>
						<tr>
							<td align="right" class="admin"><b>Importanta:</b></td>
							<td align="left" class="admin">
								<select name="imp">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right" class="admin"><b>Imagine:</b></td>
							<td align="left" class="admin"><input name="poza" id="poza" size="17" type="file"></td>
						</tr>
						<tr>
							<td align="center" colspan="2" class="admin"><input name="add" type="submit" value="Adauga" id="add"></td>
						</tr>
					</table>
				  </form>';
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  ADAUGA ANUNT   ////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'add2') {
		if (isset($_POST['add2'])) {
			$_SESSION['text'] = $_POST['text'];

			if ($_SESSION['text'] == '') {
				echo '<table width="250" cellspacing="5" cellpading="5" align="center">
							<tr>
								<td class="error" align="center">
									<b>ERROR !</b>
								</td>
							</tr>
							<tr>
								<td class="error" align="center">
									Adauga textul anuntului !
								</td>
							</tr>
						  </table>';
			} else {
				$cerereSQL = "INSERT INTO `anunturi` ( `text` ) 
											VALUES ( '" . htmlentities($_SESSION['text'], ENT_QUOTES) . "' )";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Anuntul s-a adaugat cu succes !</b></center></font><br>';
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=admin.php?action=lista2">';
			}
			$_SESSION['text'] = '';
		} else {
			echo '<br>';
		}

		echo '<form name="add2" action="admin.php?action=add2" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="250" cellspacing="5" cellpadding="5">
						<tr>
							<td align="right" width="200" class="admin"><b>Text:</b></td>
							<td align="left" class="admin"><textarea cols="23" rows="3" name="text"></textarea></td>   
						</tr>
						<tr>
							<td align="center" colspan="2" class="admin"><input name="add2" type="submit" value="Adauga" id="add"></td>
						</tr>
					</table>
				  </form>';
	}
	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  ADAUGA ADMIN   ////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'add3') {
		if (isset($_POST['add3'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['parola'] = $_POST['parola'];

			if (($_SESSION['nume'] == '') || ($_SESSION['parola'] == '')) {
				echo '<table width="250" cellspacing="5" cellpading="5" align="center">
							<tr>
								<td class="error" align="center">
									<b>ERROR !</b>
								</td>
							</tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td class="error" align="center">Introduceti numele !</td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td class="error" align="center">Introduceti parola !</td></tr>';
				echo '</table>';
			} else {
				$cerereSQL = "INSERT INTO `admin` ( `nume`, `parola` ) 
											VALUES ( '" . htmlentities($_SESSION['nume'], ENT_QUOTES) . "', '" . md5($_SESSION['parola']) . "' )";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Adminul a fost adaugat cu succes !</b></center></font><br>';
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=admin.php?action=lista3">';
			}
			$_SESSION['nume'] = '';
			$_SESSION['parola'] = '';
		} else {
			echo '<br>';
		}
		echo '<form name="add2" action="admin.php?action=add3" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="250" cellspacing="5" cellpadding="5">
						<tr>
							<td align="right" class="admin"><b>Nume:</b></td>
							<td align="center" class="admin"><input type="text" name="nume"></td>   
						</tr>
						<tr>
							<td align="right" class="admin"><b>Parola:</b></td>
							<td align="center" class="admin"><input type="text" name="parola"></td>   
						</tr>
						<tr>
							<td align="center" colspan="2" class="admin"><input name="add3" type="submit" value="Adauga" id="add"></td>
						</tr>
					</table>
				  </form>';
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  LISTA ANUNTURI   //////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'lista2') {
		echo '<table width="400" border="0" cellspacing="5" cellpadding="5" align="center">
					<tr>
						<td class="admin">
							<b>Anunt</b>
						</td>
						<td class="admin" width="40">
							<b>Sterge</b>
						</td>
					</tr>';

		$cerereSQL = 'SELECT * FROM `anunturi` ORDER BY `id`';
		$rezultat = mysqli_query($conexiune, $cerereSQL);

		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo '
					<tr>
						<td class="admin">
							' . $rand['text'] . '
						</td>
						<td class="admin" align="center">
							<a href="admin.php?action=delete2&id=' . $rand['id'] . '"><font color="red">[x]</font></a>
						</td>
					</tr>';
		}
		echo '</table>';
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  LISTA PRODUSE   ///////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'lista') {
		echo '<br><center><form action="admin.php?action=lista" method="post" name="cauta" class="search">
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

		if (isset($_POST['de_cautat'])) {
			$cererecauta = 'SELECT * FROM `produse` WHERE `cat`="' . $_POST['in'] . '" AND (`nume` LIKE "%' . addentities($_POST['de_cautat']) . '%" OR `descriere` LIKE "%' . addentities($_POST['de_cautat']) . '%" OR `cat` LIKE "%' . addentities($_POST['de_cautat']) . '%" OR `subcat` LIKE "%' . addentities($_POST['de_cautat']) . '%")';
			$rezultatcauta = mysqli_query($conexiune, $cererecauta);

			if (mysqli_num_rows($rezultatcauta) > 0) {
				$nr = 0;
				echo '<table width="100%" cellspacing="10" cellpadding="0" border="0"><tr>';

				while ($rand = mysqli_fetch_assoc($rezultatcauta)) {
					$nr++;
					$euro = round($rand['pret'] / 3);
					if (!file_exists('images/thumb_' . $rand['poza'] . '')) $imgsrc = 'images/' . $rand['poza'] . '';
					else $imgsrc = 'images/thumb_' . $rand['poza'] . '';
					echo '<td align="center" width="50%" bgcolor="#FFFFFF">
												<table border="0" cellspacing="0">
													<tr>
														<td width="100" align="center" valign="middle">
															<img src="' . $imgsrc . '" width="100" border="1">
														</td>
														<td align="left" width="170" class="prod">
															<b><font color="#003366">' . $rand['nume'] . '</font></b><br>
															' . $rand['descriere'] . '<br>
															<div align="right"><font color="#0066CC"><a href="admin.php?action=edit&id=' . $rand['id'] . '">EDITEAZA</a> | <a href="admin.php?action=delete&id=' . $rand['id'] . '">STERGE</a></font></div><br>
															Culori disponibile : <b>' . $rand['culoare'] . '</b><br>
															<font color="red"><b>' . $rand['pret'] . ' RON / ' . $euro . ' &euro;</b></font><br>
															Colectia : <b>' . $rand['cat'] . ' - ' . $rand['subcat'] . '</b>
														</td>
													</tr>
												</table>
											  </td>';
					if ($nr % 2 == 0) echo '</tr><tr>';
				}
				echo '</tr></table>';
			}
		} else {
			$rezultate_maxime = 20;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT `id` FROM `produse`'));
			if (!isset($_GET['page'])) $pagina = 1;
			else $pagina = $_GET['page'];
			$nr = 0;
			$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
			$cerereSQL = 'SELECT * FROM `produse` ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
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
						echo '<td align="center" width="50%" bgcolor="#FFFFFF">
												<table border="0" cellspacing="0">
													<tr>
														<td width="100" align="center" valign="middle">
															<img src="' . $imgsrc . '" width="100" border="1">
														</td>
														<td align="left" width="170" class="prod">
															<b><font color="#003366">' . $rand['nume'] . '</font></b><br>
															' . $rand['descriere'] . '<br>
															<div align="right"><font color="#0066CC"><a href="admin.php?action=edit&id=' . $rand['id'] . '">EDITEAZA</a> | <a href="admin.php?action=delete&id=' . $rand['id'] . '">STERGE</a></font></div><br>
															Culori disponibile : <b>' . $rand['culoare'] . '</b><br>
															<font color="red"><b>' . $rand['pret'] . ' RON / ' . $euro . ' &euro;</b></font><br>
															Colectia : <b>' . $rand['cat'] . ' - ' . $rand['subcat'] . '</b>
														</td>
													</tr>
												</table>
											  </td>';
						if ($nr % 2 == 0) echo '</tr><tr>';
					}
					echo '</tr></table>';
					echo '<br><br><br>';

					if ($pagini_totale == 1) echo '<div align=left> </div>';
					else {

						echo '<div align="center">';

						for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
							if (($pagina) == $pagini) echo '<b><font color="#B98D26" style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
							else echo '<a href="admin.php?action=lista&page=' . $pagini . '">' . $pagini . '</a>&nbsp;';
						}
						echo '</div>';
						echo '<table width="100%">
									<tr>
										<td align="left">';
						if ($pagina > 1) {
							$inapoi = ($pagina - 1);
							echo '<a href="admin.php?action=lista&page=' . $inapoi . '"><img src="images/anterioara.gif" width="130" height="33"></a>';
						}
						echo '</td>
										<td align="right">';
						if ($pagina < $pagini_totale) {
							$inainte = ($pagina + 1);
							echo '<a href="admin.php?action=lista&page=' . $inainte . '"><img src="images/urmatoare.gif" width="130" height="33"></a>';
						}
						echo '</td>
								  	</tr>
								  </table>';
					}
				}
			}
		}
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  LISTA ADMINI   ////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'lista3') {
		$cerereSQL = 'SELECT * FROM `admin` ORDER BY `id`';
		$rezultat = mysqli_query($conexiune, $cerereSQL);

		echo '<table border="0" align="center" width="200" cellspacing="5" cellpadding="5">
					<tr>
						<td class="admin"><b>Nume</b></td>
						<td align="center" class="admin" width="40"><b>Sterge</b></td>
					</tr>';

		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo '<tr>';
			if ($rand['nume'] == '' . $_SESSION['username'] . '') {
				echo '<td class="admin">' . $_SESSION['username'] . '</td>
										  <td align="center" class="admin"><a href=""><font color="lightgrey">[x]</font></a></td>';
			} else {
				echo '<td class="admin">' . $rand['nume'] . '</td>
										  <td align="center" class="admin"><a href="admin.php?action=delete3&id=' . $rand['id'] . '"><font color="red">[x]</font></a></td>';
			}
			echo '</tr>';
		}
		echo '</table>';
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  EDITEAZA PRODUS   /////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'edit') {
		if (isset($_POST['edit'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['descriere'] = $_POST['descriere'];
			$_SESSION['culori'] = $_POST['culori'];
			$_SESSION['pret'] = $_POST['pret'];
			$_SESSION['cat'] = $_POST['cat'];
			$_SESSION['subcat'] = $_POST['subcat'];

			if (($_SESSION['nume'] == '') || ($_SESSION['descriere'] == '') || ($_SESSION['culori'] == '') || ($_SESSION['pret'] == '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center">
							<tr>
								<td class="error" align="center">
									<b>ERROR !</b>
								</td>
							</tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td class="error" align="center">Introdu te rog numele produsului !</td></tr>';
				if ($_SESSION['descriere'] == '') echo '<tr><td class="error" align="center">Introdu te rog descrierea produsului !</td></tr>';
				if ($_SESSION['culori'] == '') echo '<tr><td class="error" align="center">Introdu te rog culorile disponibile acestui produs !</td></tr>';
				if ($_SESSION['pret'] == '') echo '<tr><td class="error" align="center">Introdu te rog pretul produsului !</td></tr>';
				echo '</table>';
			} else {
				echo '<br><br><br><center><font color="darkgreen"><b>Produsul a fost modificat cu succes !</b></font></center><br><br>';

				$cerereSQL = "UPDATE `produse` SET `nume`='" . $_SESSION['nume'] . "', `descriere`='" . $_SESSION['descriere'] . "', `culoare`='" . $_SESSION['culori'] . "', `pret`='" . $_SESSION['pret'] . "', `cat`='" . $_SESSION['cat'] . "', `subcat`='" . $_SESSION['subcat'] . "' WHERE `id`='" . $_GET['id'] . "'";
				mysqli_query($conexiune, $cerereSQL);

				$_SESSION['nume'] = '';
				$_SESSION['descriere'] = '';
				$_SESSION['culori'] = '';
				$_SESSION['pret'] = '';
				$_SESSION['cat'] = '';
				$_SESSION['subcat'] = '';

				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=admin.php?action=lista">';
			}
		} else {
			echo '';
		}

		$cerereSQL = "SELECT * FROM `produse` WHERE `id`='" . $_GET['id'] . "'";
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo '<form name="edit" action="admin.php?action=edit&id=' . $_GET['id'] . '" method="post">
						<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
							<tr>
								<td align="right" class="admin">
									<b>Nume:</b>
								</td>
								<td class="admin">
									<input type="text" size="30" name="nume" value="' . $rand['nume'] . '">
								</td>   
							</tr>
							<tr>
								<td align="right" class="admin">
									<b>Descriere:</b>
								</td>
								<td class="admin">
									<textarea cols="23" rows="3" name="descriere">' . $rand['descriere'] . '</textarea>
								</td>   
							</tr>
							<tr>
								<td align="right" class="admin">
									<b>Culori:</b>
								</td>
								<td class="admin">
									<input type="text" size="30" name="culori" value="' . $rand['culoare'] . '">
								</td>   
							</tr>
							<tr>
								<td align="right" class="admin">
									<b>Pret:</b>
								</td>
								<td class="admin">
									<input type="text" size="30" name="pret" value="' . $rand['pret'] . '"> RON<br>
									<input type="hidden" name="cat2" value="' . $rand['cat'] . '"><input type="hidden" name="subcat2" value="' . $rand['subcat'] . '">
								</td>   
							</tr>
							<tr>
								<td align="right" class="admin">
									<b>Colectii:</b>
								</td>
								<td class="admin">
									<select name="cat" size="1" onChange="redirect(this.options.selectedIndex)">
										<option value="' . $rand['cat'] . '">' . $rand['cat'] . '</option>
										<option value="Femei">Femei</option>
										<option value="Barbati">Barbati</option>
										<option value="Bussines">Bussines</option>
									</select>
									<select name="subcat" size="1">
										<option value="' . $rand['subcat'] . '">' . $rand['subcat'] . '</option>
									</select>
									<script>
									
										var groups=document.edit.cat.options.length
										var group=new Array(groups)
										for (i=0; i<groups; i++)
										group[i]=new Array()
									
										group[0][0]=new Option("' . $rand['subcat'] . '","' . $rand['subcat'] . '")
										
										group[1][0]=new Option("Sacouri","Sacouri")
										group[1][1]=new Option("Scurte","Scurte")
										group[1][2]=new Option("Haine lungi","Haine lungi")
										group[1][3]=new Option("Jackete","Jackete")
										group[1][4]=new Option("Veste","Veste")
										group[1][5]=new Option("Biker","Biker")
										group[1][6]=new Option("Pantaloni","Pantaloni")
										group[1][7]=new Option("Rochii","Rochii")
										group[1][8]=new Option("Fuste","Fuste")
										group[1][9]=new Option("Pantaloni scurti","Pantaloni scurti")
										group[1][10]=new Option("Corsete","Corsete")
										
										group[2][0]=new Option("Sacouri","Sacouri")
										group[2][1]=new Option("Scurte","Scurte")
										group[2][2]=new Option("Haine lungi","Haine lungi")
										group[2][3]=new Option("Jackete","Jackete")
										group[2][4]=new Option("Veste","Veste")
										group[2][5]=new Option("Biker","Biker")
										group[2][6]=new Option("House","House")
										group[2][7]=new Option("Pantaloni","Pantaloni")
										
										group[3][0]=new Option("Masculin","Masculin")
										group[3][1]=new Option("Dama","Dama")
						
										var temp=document.edit.subcat
						
										function redirect(x){
										for (m=temp.options.length-1;m>0;m--)
										temp.options[m]=null
										for (i=0;i<group[x].length;i++){
										temp.options[i]=new Option(group[x][i].text,group[x][i].value)
										}
										temp.options[0].selected=true
										}
						
									</script>
								</td>   
							</tr>
							<tr>
								<td align="center" colspan="2" class="admin">
									<input name="edit" type="submit" value="Editeaza" id="edit">
								</td>
							</tr>
						</table></form><br><br>';
		}
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  STERGE PRODUS   ///////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'delete') {

		$cerereDel = "SELECT * FROM `produse` WHERE `id`='" . htmlentities($_GET['id'], ENT_QUOTES) . "'";
		$rezultatDel = mysqli_query($conexiune, $cerereDel);
		while ($rand = mysqli_fetch_assoc($rezultatDel)) {
			if (file_exists("images/" . $rand['poza'] . "")) {

				@unlink("images/" . $rand['poza'] . "");
			} elseif (file_exists("images/thumb_" . $rand['poza'] . "")) {

				@unlink("images/thumb_" . $rand['poza'] . "");
			}
		}
		$cerereSQL = "DELETE FROM `produse` WHERE `id`='" . htmlentities($_GET['id'], ENT_QUOTES) . "'";
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		echo '<br><br><br><center><font color="red"><b>Produsul a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=admin.php?action=lista">';
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  STERGE ANUNT   ////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'delete2') {

		$cerereSQL = "DELETE FROM `anunturi` WHERE `id`='" . htmlentities($_GET['id'], ENT_QUOTES) . "'";
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		echo '<br><br><br><center><font color="red"><b>Anuntul a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=admin.php?action=lista2">';
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  STERGE ANUNT   ////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'delete3') {

		$cerereSQL = "DELETE FROM `admin` WHERE `id`='" . htmlentities($_GET['id'], ENT_QUOTES) . "'";
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		echo '<br><br><br><center><font color="red"><b>Adminul a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=admin.php?action=lista3">';
	}

	//  END  //////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////
	//  LOGOUT   //////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////

	elseif ($_GET['action'] == 'logoff') {
		$_SESSION['logat'] = 'Nu';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=admin.php">';
	}

	//  END  //////////////////////////////////////////////////////////////////////

	else {
		echo '';
	}
} else {
	if (isset($_POST['login'])) {
		if (md5($_POST['captcha']) == $_SESSION['captcha_code']) {
			$admin = $_POST['admin'];
			$pass = $_POST['pass'];

			$admin = mysqli_real_escape_string($conexiune, $admin);
			$pass = mysqli_real_escape_string($conexiune, $pass);

			$_SESSION['username'] = $admin;

			$cerereSQL = "SELECT * FROM `admin` WHERE `nume`='" . htmlentities($admin) . "' AND `parola`='" . md5($pass) . "'";
			$rezultat = mysqli_query($conexiune, $cerereSQL);
			if (mysqli_num_rows($rezultat) == 1) {
				while ($rand = mysqli_fetch_assoc($rezultat)) {
					$_SESSION['logat'] = 'Da';
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=' . $_SERVER['PHP_SELF'] . '">';
				}
			} else {
				echo '<br><center><font color="red"><b>Userul si parola nu corespund ! Incercati din nou !</b></font></center>';
			}
		} else {
			echo '<br><center><font color="red"><b>Codul de verificare nu corespunde cu imaginea ! Incercati din nou !</b></font></center>';
		}
	} else {

		echo '<br><form action="' . $_SERVER['PHP_SELF'] . '" method="post">
					<table width="200" cellspacing="5" cellpading="5" align="center">
							<tr>
								<td class="admin" align="right">
									Nume:
								</td>
								<td class="admin" align="center">
									<input type="text" name="admin" value="" size="18">
								</td>
							</tr>
							<tr>
								<td class="admin" align="right">
									Parola:
								</td>
								<td class="admin" align="center">
									<input type="password" name="pass" value="" size="18">
								</td>
							</tr>
							<tr>
								<td class="admin" align="right">
									<img src="verificare.php">
								</td>
								<td class="admin" align="center">
									<input type="text" name="captcha" value="" size="18">
								</td>
							</tr>
							<tr>
								<td colspan="2" class="admin" align="center">
									<input type="submit" name="login" value="Login" class="button">
								</td>
							</tr>
					</table>
			  </form>';
	}
}
include('footer.php');
