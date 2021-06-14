<?php

namespace App\Quality;
use \App\SQL;

class QL_Derogation Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;
    Public $DATE;
    Public $CREATEUR_ID;
    Public $TYPE;
    Public $ETAT;
    Public $RESP_ID;
    Public $PB_DESCP;
    Public $PROPOSAL;
    Public $REPLY;
    Public $COMMENT;
    Public $NFC_ID;
    Public $DECISION;
    Public $NOM;
    Public $PRENOM;

    Public $QL_DerogationList;

    public function NewQL_Derogation($CODE, $IDuser){

        $Derogation = $this->GetInsert("INSERT INTO ". TABLE_ERP_DEROGATION ." VALUE ('0',
                                                                                        '". $CODE ."',
                                                                                        '',
                                                                                        NOW(),
                                                                                        '". $IDuser ."',
                                                                                        '1',
                                                                                        '1',
                                                                                        '0',
                                                                                        '',
                                                                                        '',
                                                                                        '1',
                                                                                        '',
                                                                                        '0',
                                                                                        '')");
        return $Derogation;
    }

    public function GETQL_Derogation($id_GET){

        $Derogation = $this->GetQuery('SELECT '. TABLE_ERP_DEROGATION .'.id,
                                                '. TABLE_ERP_DEROGATION .'.CODE,
                                                '. TABLE_ERP_DEROGATION .'.LABEL,
                                                '. TABLE_ERP_DEROGATION .'.DATE,
                                                '. TABLE_ERP_DEROGATION .'.CREATEUR_ID,
                                                '. TABLE_ERP_DEROGATION .'.TYPE,
                                                '. TABLE_ERP_DEROGATION .'.ETAT,
                                                '. TABLE_ERP_DEROGATION .'.RESP_ID,
                                                '. TABLE_ERP_DEROGATION .'.PB_DESCP,
                                                '. TABLE_ERP_DEROGATION .'.PROPOSAL,
                                                '. TABLE_ERP_DEROGATION .'.REPLY,
                                                '. TABLE_ERP_DEROGATION .'.COMMENT,
                                                '. TABLE_ERP_DEROGATION .'.NFC_ID,
                                                '. TABLE_ERP_DEROGATION .'.DECISION,
                                                '. TABLE_ERP_EMPLOYEES .'.NOM,
                                                '. TABLE_ERP_EMPLOYEES .'.PRENOM
                                            FROM `'. TABLE_ERP_DEROGATION .'`
                                                LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_DEROGATION .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUser` 
								            WHERE '. TABLE_ERP_DEROGATION .'.id=\''. $id_GET .'\'', true, 'App\Quality\QL_Derogation');
        return $Derogation;
    }

    public function GETQL_DerogationListList($IdData=0, $Select = true){

        $this->QL_DerogationList ='';
        $query='SELECT id, CODE, LABEL, ETAT   FROM '. TABLE_ERP_DEROGATION .' ORDER BY CODE';
		if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->QL_DerogationList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
        
            return  $this->QL_DerogationList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}
