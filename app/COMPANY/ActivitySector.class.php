<?php

namespace App\Company;
use \App\SQL;

class ActivitySector Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;

    Public $ActivitySectorList;
    Public $ActivitySectorCheckedList;

    public function NewActivitySector($AddCODESector, $AddLABELSector){
        $NewActivitySector = $this->GetInsert("INSERT INTO ". TABLE_ERP_ACTIVITY_SECTOR ." VALUE ('0',
                                                                                        '". addslashes($AddCODESector) ."',
                                                                                        '". addslashes($AddLABELSector) ."')");
                                                                                    
        return $NewActivitySector;
    }

    public function GETActivitySector($id_GET){

        $ActivitySector = $this->GetQuery('SELECT '. TABLE_ERP_ACTIVITY_SECTOR .'.Id,
                                        '. TABLE_ERP_ACTIVITY_SECTOR .'.CODE,
                                        '. TABLE_ERP_ACTIVITY_SECTOR .'.LABEL
                                        FROM `'. TABLE_ERP_ACTIVITY_SECTOR .'`
                                        WHERE '. TABLE_ERP_RESSOURCE .'.id=\''. $id_GET .'\'', true, 'App\Company\ActivitySector');
        return $ActivitySector;
    }

    public function GETActivitySectorList($IdData=0, $Select = true){

        $this->ActivitySectorList ='';
        $query='SELECT id, CODE, LABEL   FROM '. TABLE_ERP_ACTIVITY_SECTOR .'';
        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->ActivitySectorList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
            }
            
            return  $this->ActivitySectorList;
        }else {
            
            return  $this->GetQuery($query);
        }  
    }

    public function GETActivitySectorCheckedList($IdData){
        $IdData = explode(",", $IdData);
        $this->ActivitySectorCheckedList = '';
        $query='SELECT id, CODE, LABEL   FROM '. TABLE_ERP_ACTIVITY_SECTOR .' ';

		foreach ($this->GetQuery($query) as $data){
            if(in_array($data->id,$IdData)){
                $checked = 'checked';
            }
            else{
                $checked = '';
            }

            $this->ActivitySectorCheckedList .='<tr><td><input type="checkbox" '. $checked .' value="'. $data->id .'" name="SECTOR_ID[]" /><label for="SECTOR_ID">'. $data->CODE .' - '. $data->LABEL .'</label></td></tr>';
		}
        
        return  $this->ActivitySectorCheckedList;
    }
}
