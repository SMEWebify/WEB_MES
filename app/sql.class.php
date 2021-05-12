<?php
namespace App;
use \PDO;
use \PDOException;

class SQL extends PDO{

	private static $pdo;
	
	public $GetErrorMysql = '';

	public $CloseMysqlAuto = false;

	public $AfficherMessException = true;

	public $DernierID = false;

    public function __construct ()
	{}
	
    public static function getPDO (){

        if(self::$pdo === null){
            try{
                $pdo = new PDO('mysql:host='. SQL_HOST .';dbname='. DB_NAME .';charset=utf8', DB_USER , '');
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				self::$pdo = $pdo;
            }
 			catch (PDOException $e){
				echo'
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
							<head>
								<title>Ops ...!</title>
								<link rel="stylesheet" media="screen" type="text/css" title="deco" href="css/stylesheet.css" />
								<link rel="stylesheet" media="print" type="text/css"  href="css/print.css" />
								<link rel="stylesheet" media="screen" type="text/css" title="deco" href="css/tableaux.css" />
								<link rel="stylesheet" media="screen" type="text/css" title="deco" href="css/forms.css" />
								<meta http-equiv="content-type" content="text/html; charset=utf-8" />
								<link rel="icon" type="images/ico" href="images/favicon.ico" />
							</head>
							<body style="background-color: #34495e; color:#555;  text-align:left; padding-top:50px;">
								<div style="background-color: white; width:100%; padding-left:200px; padding-top:20px;>
									<p "> 
										Erreur de connexion à la base de données.<br/>
										<br/>
										'. $e -> getmessage() .'
										Cela peut prendre quelques minutes à plusieures heures, veuillez nous excuser pour le dérangement occasionné.<br/>
										Nous travaillons pour rétablir le site au plus vite.<br/>
										<br/>
										<br/>
									</p>
									<pre >            /////</pre>
									<pre >         (o)-(o)</pre>
									<p >
										-----ooO---(_)---Ooo--------------------------<br/>
										<br/>
										<br/>
										<a href="index.php">Ne pas attendre</a>
									</p>
								</div>
							</body>
						</html>	';
            }
		}

        return self::$pdo;
	}

	public function GetCount($table, $compter='*', $clauses='')
    {
        $datas = 0;
        try {   
			if(empty($compter)) $compter='*';
			$statement = "SELECT COUNT(".$compter.") FROM `".$table."`". $clauses;
            $req = $this->getPDO()->query($statement);
			$datas = $req->fetch(PDO::FETCH_NUM);
            
        } catch (PDOException $exc) {
			$this->GestionException($exc->getMessage(), $statement);
        }
        return $datas[0];
    }   
	
	public function GetQuery($statement, $one = false, $class_name  = false, $debug  = false){
		try{
			$req = $this->getPDO()->query($statement);
			if($class_name){
				$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
			}else{
				$req->setFetchMode(PDO::FETCH_OBJ);
			}
			
			if($one){
				$datas = $req->fetch();
			}else{
				$datas = $req->fetchAll();
			}
		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage(), $statement);
			
		}
		if($debug){
			var_dump($datas);
		}
		
		return $datas;
	}

	public function GetPrepare($statement, $attributes = null){
		$req = $this->getPDO()->prepare($statement);
		$req->execute($attributes);
		$datas = $req->fetchAll(PDO::FETCH_OBJ);
		return $datas;
	}

	public function GetUpdate($statement){
		try{
			$req = $this->getPDO()->exec($statement);
		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage(), $statement);
		}
		return true;
	}

	public function GetUpdatePOST($table, $mise_a_jour, $clauses=''){
		try{
			
			$maj = array();
            foreach ($mise_a_jour as $cle => $valeur) {                
                $maj[] = "`".$cle."`"."='". $this->ProtectVal($valeur)."'";                
			}    

			$statement="UPDATE `".$table."` SET ".implode(',',$maj)."  ". $clauses;
		
			$req = $this->getPDO()->exec($statement);
		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage(), $statement);
		}
		return true;
	}

	       
	public function GetInsert($statement){
		try{
			$req = $this->getPDO()->exec($statement);
			$DernierID = $this->getPDO()->lastInsertId();
		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage(), $statement);
		}
		return $DernierID;
		
	}

	public function GetInsertPOST($table,$POST){
		try{
			$add = array();
			foreach ($POST as $cle => $valeur) {                
				$add[] = "'". $this->ProtectVal($valeur)."'";                
			}    

			$statement="INSERT INTO `".$table."` VALUE ('0',".  implode(',',$add) ." )";

			$req = $this->getPDO()->exec($statement);

		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage(), $statement);
		}
		return true;
	}

	public function GetDelete($statement){
		try{
			$req = $this->getPDO()->exec($statement);
		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage(), $statement);
		}
		return true;
	}

	private function GestionException($message, $statement = false){        
		$this->GetErrorMysql = $message;            
		
        if($this->AfficherMessException) echo '<p><br/><br/><br/><br/><br/><br/>'.$message.'</p><p>'.$statement.'</p>';
        // on ferme la connexion si $CloseMysqlAuto est TRUE
        if ($this->CloseMysqlAuto) {
            if(self::$pdo){
				self::$pdo = NULL;
			}
		}
        return false;
	}  

	public function  dump_MySQL($mode)
    {
    
		$FileName =  DB_NAME .'_BackUp_'. date("d-M-Y_H-i-s")	 .'.sql';
		$entete  = "-- ----------------------\n";
		$entete .= "-- dump de la base ". DB_NAME ." au ".date("d-M-Y")."\n";
		$entete .= "-- ----------------------\n\n\n";
		$creations = "";
		$insertions = "\n\n";
		
		$listeTables = $this->getPDO()->query("show tables");
		while($table = $listeTables->fetch())
		{
			// structure ou la totalité de la BDD
			if($mode == 1 || $mode == 2 || $mode == 3)
			{

				$creations .= "-- \n";
				$creations .= "-- Structure de la table ".$table[0]."\n";
				$creations .= "-- \n";

				if($mode == 3){
					$creations .="DROP TABLE IF EXISTS `". $table[0] ."`;\n";
				}

				$listeCreationsTables = $req = $this->getPDO()->query("show create table ".$table[0]);

				while($creationTable = $listeCreationsTables->fetch())
				{
				$creations .= $creationTable[1].";\n\n";
				}
			}
			// données ou la totalité
			if($mode > 1)
			{
				$donnees = $this->getPDO()->query("SELECT * FROM ".$table[0]);
				$creations .= "-- \n";
				$creations .= "-- Contenu de la table ".$table[0]."\n";
				$creations .= "-- \n";
				while($nuplet = $donnees->fetch())
				{
					$creations .= "INSERT INTO ".$table[0]." VALUES(";
					for($i=0; $i < $donnees->columnCount(); $i++)
					{
					if($i != 0)
						$creations .=  ", ";
					if($donnees->getColumnMeta($i) == "string" || $donnees->getColumnMeta($i) == "blob")
						$creations .=  "'";
					$creations .= addslashes($nuplet[$i]);
					if($donnees->getColumnMeta($i) == "string" || $donnees->getColumnMeta($i) == "blob")
						$creations .=  "'";
					}
					$creations .=  ");\n";
				}
				$creations .= "\n";
			}
		}
	
		$fichierDump = fopen("../app/Company/DatabaseBackUp/". $FileName, "wb");

		fwrite($fichierDump, $entete);
		fwrite($fichierDump, $creations);

		fclose($fichierDump);
 
		Return $FileName;

    }

	Public function DeleteBackup($string){
		$filename ="../app/Company/DatabaseBackUp/". $string;
		if (file_exists($filename)) {
			unlink ($filename);
		}
	}
	
	private function ProtectVal($chaine){
		$chaine = trim($chaine);
		$chaine = stripslashes($chaine);
		$chaine = addslashes($chaine);    
		return $chaine;    
	}	
}
?>
