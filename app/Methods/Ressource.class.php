<?php

namespace App\Methods;
use \App\SQL;

class Ressource Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;
    Public $IMAGE;
    Public $MASK_TIME;
    Public $ORDRE;
    Public $CAPACITY;
    Public $SECTION_ID;
    Public $COLOR;
    Public $LABEL_SECTOR;
    Public $PRESTATION_ID;
    Public $COMMENT;

    Public $RessourcesList;

    public function GETRessource($id_GET_RESOURCE){

        $Ressource = $this->GetQuery('SELECT '. TABLE_ERP_RESSOURCE .'.id,
                                            '. TABLE_ERP_RESSOURCE .'.CODE,
                                            '. TABLE_ERP_RESSOURCE .'.LABEL,
                                            '. TABLE_ERP_RESSOURCE .'.IMAGE,
                                            '. TABLE_ERP_RESSOURCE .'.MASK_TIME,
                                            '. TABLE_ERP_RESSOURCE .'.ORDRE,
                                            '. TABLE_ERP_RESSOURCE .'.CAPACITY,
                                            '. TABLE_ERP_RESSOURCE .'.SECTION_ID,
                                            '. TABLE_ERP_RESSOURCE .'.COLOR,
                                            '. TABLE_ERP_RESSOURCE .'.PRESTATION_ID,
                                            '. TABLE_ERP_RESSOURCE .'. COMMENT,
                                            '. TABLE_ERP_SECTION .'.LABEL AS LABEL_SECTOR
                                         FROM `'. TABLE_ERP_RESSOURCE .'`
                                             LEFT JOIN `'. TABLE_ERP_SECTION .'` ON `'. TABLE_ERP_RESSOURCE .'`.`SECTION_ID` = `'. TABLE_ERP_SECTION .'`.`id`
								         WHERE '. TABLE_ERP_RESSOURCE .'.id=\''. $id_GET_RESOURCE .'\'', true, 'App\Methods\Ressource');
        return $Ressource;
    }

    public function GETRessourcesList($IdData=0){

        $this->RessourcesList ='<option value="0">Aucune</option>';
        $query='SELECT Id, LABEL   FROM '. TABLE_ERP_RESSOURCE .'';
        foreach ( $this->GetQuery($query) as $data){
            $this->RessourcesList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
        }
        
        return  $this->RessourcesList;
    }
}
