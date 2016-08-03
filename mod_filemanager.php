<?php 
	// no direct access
	defined('_JEXEC') or die ("Restricted access");
	//include helper.php with function and class
	require_once(dirname(__FILE__)."/helper.php");
	//<------ START PROGRAM
	$mod_filemanager = new mod_filemanager;
	$dirpartenza = mod_filemanager::correggiurl($params -> get('dirpartenza'));
	
	if(!is_dir($dirpartenza))
		$dirpartenza = ".";
	
	if(isset($_POST['azione'], $_POST['patch']))
	{
		$_POST['patch'] = mod_filemanager::correggiurl(urldecode($_POST['patch']));
		if(!mod_filemanager::controllobaseurl($dirpartenza, $_POST['patch']))
			$_POST['patch'] = $dirpartenza;
		if($_POST['azione'] == 'caricafile')
		{
			if(!$mod_filemanager -> caricafiles($_POST['patch'], $_FILES['file']))
				$errori = $mod_filemanager -> registroerrori;
			if(isset($_POST['ridimensionajpeg']) and $_POST['ridimensionajpeg'] == "on")
			{
				foreach($_FILES['file']['name'] as $val)
					$file[] = $_POST['patch']."/".$val;
					mod_filemanager::ridimensionapiujpeg($file, 600);
					unset($file);
			}
				
		}
		if($_POST['azione'] == 'eliminafile' and isset($_POST['patchfile']))
			mod_filemanager::cancellafile($_POST['patchfile']);
		if($_POST['azione'] == 'eliminafiles' and isset($_POST['files']))
			mod_filemanager::cancellafiles($_POST['files']);
		else if($_POST['azione'] == 'eliminacartella' and isset($_POST['patchcartella']))
			mod_filemanager::cancellacartella($_POST['patchcartella']);
		else if($_POST['azione'] == 'nuovacartella' and isset($_POST['nomecartella']))
			mod_filemanager::creacartella($_POST['patch'], $_POST['nomecartella']);			
		else if($_POST['azione'] == 'apricartella')
		{
			$cartelle = explode("/",$_POST['patch']);
			if($cartelle[count($cartelle)-1] == '..')
			{
				unset($cartelle[count($cartelle)-1]);
				unset($cartelle[count($cartelle)-1]);
				$_POST['patch'] = implode("/", $cartelle);
			}
		}
			$dirpresente = $_POST['patch'];
	}
	else
		$dirpresente = $dirpartenza;
		
		$contenutocartella = mod_filemanager::apricartella($dirpresente);
		
		sort($contenutocartella['files']);
		sort($contenutocartella['cartelle']);
		
		define("_DIRFILES_MOD_FILEMANAGER", JURI::base()."modules/mod_filemanager");
		define("_URLCORRENTE", $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	//<------ END PROGRAM
	
	//output of program
	require_once(dirname(__FILE__)."/tmpl/default.php");
	
?>