<?php

namespace App\Quality;
use \App\SQL;

class QL_Action Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;
    Public $DATE;
    Public $CREATEUR_ID;
    Public $TYPE;
    Public $ETAT;
    Public $RESP_ID;
    Public $PB_DESCP;
    Public $CAUSE;
    Public $ACTION;
    Public $COLOR;
    Public $NFC_ID;
    Public $NOM;
    Public $PRENOM;

    Public $QL_ACTIONList;

    public function NewQL_Action($CODE, $IDuser){

        $Action = $this->GetInsert("INSERT INTO ". TABLE_ERP_QL_ACTION ." VALUE ('0',
                                                                                        '". $CODE ."',
                                                                                        '',
                                                                                        NOW(),
                                                                                        '". $IDuser ."',
                                                                                        '1',
                                                                                        '1',
                                                                                        '0',
                                                                                        '',
                                                                                        '',
                                                                                        '',
                                                                                        '',
                                                                                        '0')");
        return $Action;
    }

    public function GETQL_Action($id_GET){

        $Action = $this->GetQuery('SELECT '. TABLE_ERP_QL_ACTION .'.id,
                                                '. TABLE_ERP_QL_ACTION .'.CODE,
                                                '. TABLE_ERP_QL_ACTION .'.LABEL,
                                                '. TABLE_ERP_QL_ACTION .'.DATE,
                                                '. TABLE_ERP_QL_ACTION .'.CREATEUR_ID,
                                                '. TABLE_ERP_QL_ACTION .'.TYPE,
                                                '. TABLE_ERP_QL_ACTION .'.ETAT,
                                                '. TABLE_ERP_QL_ACTION .'.RESP_ID,
                                                '. TABLE_ERP_QL_ACTION .'.PB_DESCP,
                                                '. TABLE_ERP_QL_ACTION .'.CAUSE,
                                                '. TABLE_ERP_QL_ACTION .'.ACTION,
                                                '. TABLE_ERP_QL_ACTION .'.COLOR,
                                                '. TABLE_ERP_QL_ACTION .'.NFC_ID,
                                                '. TABLE_ERP_EMPLOYEES .'.NOM,
                                                '. TABLE_ERP_EMPLOYEES .'.PRENOM
                                            FROM `'. TABLE_ERP_QL_ACTION .'`
                                                LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_QL_ACTION .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUser` 
								            WHERE id=\''. $id_GET .'\'', true, 'App\Quality\QL_Action');
        return $Action;
    }

    public function GETQL_ActionList($IdData=0,  $Select = true){

        $this->QL_ACTIONList ='';
        $query='SELECT id, CODE, LABEL, ETAT   FROM '. TABLE_ERP_QL_ACTION .' ORDER BY CODE';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->QL_ACTIONList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
        
          return  $this->QL_ACTIONList;
        }else {

            return  $this->GetQuery($query);
        }  
    }
}
