
<link href = "<?php echo _DIRFILES_MOD_FILEMANAGER; ?>/media/css/stile.css" rel = "stylesheet" type = "text/css">
<div class="mod_filemanager">
<?
				//var_dump($file);
				?>
<div class="banner" style="display:none">
	<div class="sfondo"></div>
	<div class="contenuto">
		<div class = "testo"></div>
		<div class="bottoni">
			<input type="button" value="Conferma" id="conferma">
			<input type="button" value="Chiudi" id="chiudi">
		</div>
	</div>
</div>
<div class="sottotitolo">Carica file:</div>
<div class="elencofile">
	<form class="inviofile" enctype="multipart/form-data" action="<? echo _URLCORRENTE; ?>" id="uploadfile" method = "POST">
		<input type = "hidden" name = "azione" value = "caricafile">
		<input type="file" name="file[]" multiple = "multiple">
		<input type = "hidden" name = "patch" value = "<? echo $dirpresente ?>">
		<input type="button" value = "Carica" data-patch = "<? echo $dirpresente?>" data-azione="caricafile" >
		<span>Comprimi JPEG <input type = "checkbox" value = "on" name = "ridimensionajpeg"></span>
		<span class="loading" hidden>
			<img src ="<? echo _DIRFILES_MOD_FILEMANAGER."/media/immagini/load.gif"; ?>">
		</span>
		<br>
		<span class="progress">
			
		</span>
	</form>
	<? 
		if(isset($errore))
			echo "<div class='errore'>$errore</div>";
	?>
</div>
<div class="sottotitolo">Cartelle:<span class="percorso"><?php echo $dirpresente; ?></span>
	<div class="barracartelle">Azioni: 
		<img class = "button" src = "<?php echo _DIRFILES_MOD_FILEMANAGER; ?>/media/immagini/newfolder.png" data-patch = "<? echo $dirpresente?>" data-azione = "nuovacartella" value="Nuova cartella">
	</div>
</div>
		<div class="elencofile">
			<table cellspacing = 0>
				<?php
					foreach($contenutocartella['cartelle'] as $cartella)
						if(($cartella != '..' or $dirpresente != $dirpartenza) and $cartella != '.')
						{
							if($cartella!='..')
								$indimmagine = _DIRFILES_MOD_FILEMANAGER."/media/immagini/folder.png";
							else
								$indimmagine = _DIRFILES_MOD_FILEMANAGER."/media/immagini/backfolder.png";
							echo "<tr class = 'cartella' ><td><img src = '$indimmagine'><td>$cartella<td><input type = 'button' class = 'azioni' value='Apri' data-azione='apricartella' data-patch=\"$dirpresente/$cartella\">";
							if($cartella != "..")
								echo "<input type = 'button' value='Elimina' class = 'azioni' data-azione='eliminacartella' data-patch=\"$dirpresente\" data-patchcartella=\"$dirpresente/$cartella\">";
						}
				?>
			</table>
		</div>
	<div class="sottotitolo" <? if(!isset($contenutocartella['files'])) echo "hidden"; ?>>File:
		<div class="barrafile">Azioni: 
			<img class = "button" data-azione = "eliminafiles" src = "<?php echo _DIRFILES_MOD_FILEMANAGER; ?>/media/immagini/delete.png" data-patch = "<? echo $dirpresente?>" data-azione = "eliminafiles" value="Nuova cartella">
		</div>
	</div>
	<form class="azionifile" action="<? echo _URLCORRENTE; ?>" id = "gestionefile" method = "POST">
		<input type = "hidden" name = "azione" value="" class="azioneform">
		<input type = "hidden" name = "patch" value="<? echo $dirpresente?>">
		<div class="elencofile" <? if(!isset($contenutocartella['files'])) echo "hidden"; ?>>
			<table cellspacing = 0>
				<tr class = "primariga"><td><input type="checkbox" class="checkall"><td><td>Nome file<td>
				<?php
					foreach($contenutocartella['files'] as $file)
					{
						switch(strtolower(mod_filemanager::estensionefile($file)))
						{
							case "pdf":
								$imgfile = _DIRFILES_MOD_FILEMANAGER."/media/immagini/pdf.png";
								break;
							case "doc":
								$imgfile = _DIRFILES_MOD_FILEMANAGER."/media/immagini/documento.png";
								break;
							case "png":
							case "jpg":
							case "jpeg":
							case "gif":
								$imgfile = _DIRFILES_MOD_FILEMANAGER."/media/immagini/img.png";
								break;
							default:
								$imgfile = _DIRFILES_MOD_FILEMANAGER."/media/immagini/sconosciuto.png";
								break;
						}
						echo "<tr class = 'file'><td style=\"width:5%;\"><input type=\"checkbox\" class = \"checkbox\" name=\"files[]\" value=\"$dirpresente/$file\"><td style=\"width:5%;\"><img src='$imgfile'><td style=\"wordwrap:break-word;\">$file<td style=\"width:40%;\"><a href=\"$dirpresente/$file\" download><input type = 'button' value='Scarica'></a><input type = 'button' value='Elimina' class = 'azioni' data-azione='eliminafile' data-patch=\"$dirpresente\" data-patchfile=\"$dirpresente/$file\">";
					}
				?>
			</table>
		</div>
	</form>
</div>
<script src = "<?php echo _DIRFILES_MOD_FILEMANAGER; ?>/media/js/jquery.js"></script>
<script src = "<?php echo _DIRFILES_MOD_FILEMANAGER; ?>/media/js/jquery.form.js"></script>
<script src = "<?php echo _DIRFILES_MOD_FILEMANAGER; ?>/media/js/funzioni.js"></script>