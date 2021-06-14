<?php

namespace App\Quality;
use \App\SQL;

class QL_NFC Extends SQL  {

    Public $ID;
    Public $CODE;
    Public $LABEL;
    Public $ETAT;
    Public $CREATED;
    Public $MODIFIED;
    Public $TYPE;
    Public $CREATOR_ID;
    Public $MODIFIED_ID;
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
    Public $COMPANY_ID;
    Public $NOM_CREATOR;
    Public $PRENOM_CREATOR;
    Public $NOM_MODIFIED;
    Public $PRENOM_MODIFIED;

    Public $QL_NFC;

    public function NewQL_FNC($CODE, $IDuser, $COMPANY_ID){

        $FNC = $this->GetInsert("INSERT INTO ". TABLE_ERP_NFC ."  VALUE ('0',
                                                                        '". $CODE ."',
                                                                        '',
                                                                        '1',
                                                                        NOW(),
                                                                        NOW(),
                                                                        '1',
                                                                        '". $IDuser ."',
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
                                                                        '',
                                                                        '". $COMPANY_ID ."' )");
        return $FNC;
    }

    public function GETQL_FNC($id_GET){

        $FNC = $this->GetQuery('SELECT '. TABLE_ERP_NFC .'.id,
                                                '. TABLE_ERP_NFC .'.CODE,
                                                '. TABLE_ERP_NFC .'.LABEL,
                                                '. TABLE_ERP_NFC .'.ETAT,
                                                '. TABLE_ERP_NFC .'.CREATED,
                                                '. TABLE_ERP_NFC .'.MODIFIED,
                                                '. TABLE_ERP_NFC .'.TYPE,
                                                '. TABLE_ERP_NFC .'.CREATOR_ID,
                                                '. TABLE_ERP_NFC .'.MODIFIED_ID,
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
                                                '. TABLE_ERP_NFC .'.COMPANY_ID,
                                                '. TABLE_ERP_EMPLOYEES .'.NOM AS NOM_CREATOR,
                                                '. TABLE_ERP_EMPLOYEES .'.PRENOM AS PRENOM_CREATOR,
                                                TABLE_MODIFIED.NOM AS NOM_MODIFIED,
                                                TABLE_MODIFIED.PRENOM AS PRENOM_MODIFIED
                                            FROM `'. TABLE_ERP_NFC .'`
                                                LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_NFC .'`.`CREATOR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUser` 
                                                LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS TABLE_MODIFIED ON `'. TABLE_ERP_NFC .'`.`MODIFIED_ID` = TABLE_MODIFIED.`idUser` 
								            WHERE '. TABLE_ERP_NFC .'.id=\''. $id_GET .'\'', true, 'App\Quality\QL_NFC');
        return $FNC;
    }

    public function GETQNFCCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $QuoteCount =  $this->GetCount(TABLE_ERP_NFC,'id', $Clause);
        return $QuoteCount;
    }

    public function GETQL_NFCList($IdData=0,  $Select = true){

        $this->QL_NFC ='<option value="0">Aucune</option>';
        $query='SELECT id, CODE, LABEL, ETAT   FROM '. TABLE_ERP_NFC .'';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->QL_NFC .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }
            
            return  $this->QL_NFC;

        }else {

            return  $this->GetQuery($query);
        }
        
    }
}
