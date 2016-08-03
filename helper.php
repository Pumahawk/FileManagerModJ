<?php
	class mod_filemanager
	{
		public $errore;
		public $registroerrori;
		public function apricartella($patch)
		{
			$cartella = dir($patch);
			while($f = $cartella->read())
			{
				if (is_file($patch.'/'.$f))
					$files[] = $f;
				else if(is_dir($patch.'/'.$f))
					$cartelle[] = $f;
			}
			if(isset($files) or isset($cartelle))
			{
				$contenuto['files'] = $files;
				$contenuto['cartelle'] = $cartelle;
				return $contenuto;
			}
			else
				return false;
		}
		
		public function cancellacartella($patch)
		{
			return rmdir($patch);
		}
		
		public function creacartella($patch, $nome)
		{
            $co = 0;
            $patch = $patch.'/'.$nome;
            $basename = basename($patch);
            $basepatch = dirname($patch);
            $tempname =  rand();
            while(file_exists($basepatch."/".$tempname.$co))
                $co++;
            mkdir($basepatch."/".$tempname.$co);
            rename($basepatch."/".$tempname.$co, $basepatch."/".$basename);
		}
		
		public function cancellafile($patch)
		{
			return unlink($patch);
		}
		public function cancellafiles($patch)
		{
			foreach($patch as $file)
				unlink($file);
		}
		
		public function caricafiles($patch, $files)
		{
			foreach($files['name'] as $k => $val)
				if(is_uploaded_file($files['tmp_name'][$k]))
					if(!file_exists($patch."/".$files["name"][$k]))
						move_uploaded_file($files['tmp_name'][$k], $patch."/".$files["name"][$k]);
		}
		public function caricafile($patch, $file)
		{
			if(is_uploaded_file($file['tmp_name']))
				if(!file_exists($patch."/".$file["name"]))
				{
					if(move_uploaded_file($file['tmp_name'], $patch."/".$file["name"]))
						return true;
					else
					{
						$this -> errore = "Errore spostamento file";
						return false;
					}
				}
				else
				{
					$this -> errore = "Errore: file già presente";
					return false;
				}
		}
		
		
		public function copiafile($patch1, $patch2)
		{
			if(!file_exists($patch))
				return copy($patch1, $patch2);
		}
		
		public function rinominafile($patch, $nome)
		{
		}
		public function estensionefile($nome)
		{
			$nome = explode(".", $nome);
			return $nome[count($nome)-1];
		}
		
		public function correggiurl($patch)
		{
			$arrayurl = explode("/", $patch);
			while(in_array("..", $arrayurl) or in_array("", $arrayurl) or in_array(".", $arrayurl))
			{
				if(in_array("", $arrayurl))
				{
					$k = array_search("", $arrayurl);
					unset($arrayurl[$k]);
					$arrayurl = implode("/", $arrayurl);
					$arrayurl = explode("/", $arrayurl);
				}
				else if(in_array(".", $arrayurl))
				{
					$k = array_search(".", $arrayurl);
					unset($arrayurl[$k]);
					$arrayurl = implode("/", $arrayurl);
					$arrayurl = explode("/", $arrayurl);
				}
				else if(in_array("..", $arrayurl))
				{
					$k = array_search("..", $arrayurl);
					unset($arrayurl[$k]);
					if($k != 0)
						unset($arrayurl[$k-1]);
					if(count($arrayurl) == 0)
						return ".";
					$arrayurl = implode("/", $arrayurl);
					$arrayurl = explode("/", $arrayurl);
				}
			}
			if(count($arrayurl) != 0 or count($arrayurl) != "")
				$urlris = implode("/", $arrayurl);
			else
				$urlris = ".";
			return $urlris;
		}
		public function controllobaseurl($patchpartenza, $patch)
		{
			$arpatchpartenza = explode("/", $patchpartenza);
			if($arpatchpartenza[0] == ".")
				$patch = "./".$patch;
			$arpatch = explode("/", $patch);
			
			foreach($arpatchpartenza as $k => $val)
				if($arpatchpartenza[$k] != $arpatch[$k])
					return false;
			return true;
		}
		public function ridimensionajpeg($patchfoto, $dimensionemax)
		{
			if(is_file($patchfoto) == false or !in_array(strtolower(mod_filemanager::estensionefile(basename($patchfoto))), array("jpgx", "jpegx")) == false)
				return false;
			list($width, $height) = getimagesize($patchfoto);
			if($width > $height)
			{
				$nwidth = $dimensionemax;
				$nheight = $nwidth*$height/$width;
			}
			else
			{
				$nheight = $dimensionemax;
				$nwidth = $nheight*$width/$height;
			}
			$dest = imagecreatetruecolor($nwidth, $nheight);
			$img = imagecreatefromjpeg($patchfoto);
			imagecopyresized($dest, $img, 0,0,0,0,$nwidth,$nheight,$width,$height);
			imagejpeg($dest, $patchfoto);
			return true;
		}
		public function ridimensionapiujpeg($patchfoto, $dimensionemax)
		{
			$bool = false;
			foreach($patchfoto as $patch)
				if(mod_filemanager::ridimensionajpeg($patch, $dimensionemax))
					$bool = true;
			return $bool;
		}
	}
	
	
?>