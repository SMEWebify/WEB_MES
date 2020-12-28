<?php

namespace App\Quality;
use \App\SQL;

class QL_Devices Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;
    Public $RESSOURCE_ID;
    Public $USER_ID;
    Public $SERIAL_NUMBER;
    Public $DATE;
    Public $LABEL_RESSOURCE;
    Public $NOM_USER;
    Public $PRENOM_USER;
    Public $PICTURE_DEVICES;

    Public $QL_DevicesList;

    public function GETQL_Devices($id_GET){

        $Device = $this->GetQuery('SELECT '. TABLE_ERP_QL_APP_MESURE .'.id,
                                                '. TABLE_ERP_QL_APP_MESURE .'.CODE,
                                                '. TABLE_ERP_QL_APP_MESURE .'.LABEL,
                                                '. TABLE_ERP_QL_APP_MESURE .'.RESSOURCE_ID,
                                                '. TABLE_ERP_QL_APP_MESURE .'.USER_ID,
                                                '. TABLE_ERP_QL_APP_MESURE .'.SERIAL_NUMBER,
                                                '. TABLE_ERP_QL_APP_MESURE .'.DATE,
                                                '. TABLE_ERP_QL_APP_MESURE .'.PICTURE_DEVICES,
                                                '. TABLE_ERP_RESSOURCE .'.LABEL AS LABEL_RESSOURCE,
                                                '. TABLE_ERP_EMPLOYEES .'.NOM AS NOM_USER,
                                                '. TABLE_ERP_EMPLOYEES .'.PRENOM AS PRENOM_USER
                                                FROM `'. TABLE_ERP_QL_APP_MESURE .'`
                                                LEFT JOIN `'. TABLE_ERP_RESSOURCE .'` ON `'. TABLE_ERP_QL_APP_MESURE .'`.`RESSOURCE_ID` = `'. TABLE_ERP_RESSOURCE .'`.`id`
                                                LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_QL_APP_MESURE .'`.`USER_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUser`
                                              WHERE '. TABLE_ERP_QL_APP_MESURE .'.id=\''. $id_GET .'\'', true, 'App\Quality\QL_Devices');
        return $Device;
    }

    public function GETQL_DevicesList($IdData=0){

        $this->QL_DevicesList ='<option value="0">Aucune</option>';
        $query='SELECT Id, CODE, LABEL   FROM '. TABLE_ERP_QL_APP_MESURE .'';
		foreach ($this->GetQuery($query) as $data){
           
			$this->QL_DevicesList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->QL_DevicesList;
    }
}
