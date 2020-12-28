<?php

namespace App\Quality;
use \App\SQL;

class QL_NFC Extends SQL  {

    Public $ID;
    Public $CODE;
    Public $LABEL;
    Public $ETAT;
    Public $DATE;
    Public $TYPE;
    Public $CREATEUR_ID;
    Public $CAUSED_BY_ID;
    Public $SECTION_ID;
    Public $RESSOURCE_ID;
    Public $DEFAUT_ID;
    Public $DEFAUT_COMMENT;
    Public $CAUSE_ID;
    Public $CAUSE_COMMENT;
    Public $CORRECTION_ID;
    Public $CORRECTION_COMMENT;
    Public $COMMENT;
    Public $NOM;
    Public $PRENOM;

    Public $QL_NFC;

    public function NewQL_FNC($CODE, $IDuser){

        $FNC = $this->GetInsert("INSERT INTO ". TABLE_ERP_NFC ."  VALUE ('0',
                                                                        '". $CODE ."',
                                                                        '',
                                                                        '1',
                                                                        NOW(),
                                                                        '1',
                                                                        '". $IDuser ."',
                                                                        '0',
                                                                        '0',
                                                                        '0',
                                                                        '0',
                                                                        '',
                                                                        '0',
                                                                        '',
                                                                        '0',
                                                                        '',
                                                                        '')");
        return $FNC;
    }

    public function GETQL_FNC($id_GET){

        $FNC = $this->GetQuery('SELECT '. TABLE_ERP_NFC .'.id,
                                                '. TABLE_ERP_NFC .'.CODE,
                                                '. TABLE_ERP_NFC .'.LABEL,
                                                '. TABLE_ERP_NFC .'.ETAT,
                                                '. TABLE_ERP_NFC .'.DATE,
                                                '. TABLE_ERP_NFC .'.TYPE,
                                                '. TABLE_ERP_NFC .'.CREATEUR_ID,
                                                '. TABLE_ERP_NFC .'.CAUSED_BY_ID,
                                                '. TABLE_ERP_NFC .'.SECTION_ID,
                                                '. TABLE_ERP_NFC .'.RESSOURCE_ID,
                                                '. TABLE_ERP_NFC .'.DEFAUT_ID,
                                                '. TABLE_ERP_NFC .'.DEFAUT_COMMENT,
                                                '. TABLE_ERP_NFC .'.CAUSE_ID,
                                                '. TABLE_ERP_NFC .'.CAUSE_COMMENT,
                                                '. TABLE_ERP_NFC .'.CORRECTION_ID,
                                                '. TABLE_ERP_NFC .'.CORRECTION_COMMENT,
                                                '. TABLE_ERP_NFC .'.COMMENT,
                                                '. TABLE_ERP_EMPLOYEES .'.NOM,
                                                '. TABLE_ERP_EMPLOYEES .'.PRENOM
                                            FROM `'. TABLE_ERP_NFC .'`
                                                LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_NFC .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUser` 
								            WHERE '. TABLE_ERP_NFC .'.id=\''. $id_GET .'\'', true, 'App\Quality\QL_NFC');
        return $FNC;
    }

    public function GETQL_NFCList($IdData=0){

        $this->QL_NFC ='<option value="0">Aucune</option>';
        $query='SELECT Id, CODE, LABEL   FROM '. TABLE_ERP_NFC .'';
		foreach ($this->GetQuery($query) as $data){
           
			$this->QL_NFC .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->CODE .'</option>';
		}
        
        return  $this->QL_NFC;
    }
}
