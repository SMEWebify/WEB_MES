<?php
namespace App;
use \PDO;
use \PDOException;

class SQL extends PDO{

	private static $pdo;
	
	public $GetErrorMysql = '';

	public $CloseMysqlAuto = false;

	public $AfficherMessException = true;

	public $DernierID = 0;

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
	
	public function GetQuery($statement, $one = false, $class_name  = false){
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

		return $datas;
	}

	public function GetPrepare($statement, $attributes){
		$req = $this->getPDO()->prepare($statement);
		$req->execute($attributes);
		$datas = $req->fetchAll(PDO::FETCH_OBJ);
		return $datas;
	}

	public function GetUpdate($statement){
		try{
			$req = $this->getPDO()->exec($statement);
		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage());
		}
		return true;
	}

	public function GetInsert($statement){
		try{
			$req = $this->getPDO()->exec($statement);
		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage());
		}
		return true;
		$this->DernierID = 0;
	}

	public function GetDelete($statement){
		try{
			$req = $this->getPDO()->exec($statement);
		} catch (PDOException $exc) {
			$this->GestionException($exc->getMessage());
		}
		return true;
	}

	private function GestionException($message){        
        $this->GetErrorMysql = $message;            
        if($this->AfficherMessException) echo '<p>'.$message.'</p>';
        // on ferme la connexion si $CloseMysqlAuto est TRUE
        if ($this->CloseMysqlAuto) {
            if(self::$pdo){
				self::$pdo = NULL;
			}
		}
        return false;
    }  
}
?>
