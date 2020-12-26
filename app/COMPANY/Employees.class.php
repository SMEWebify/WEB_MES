<?php

namespace App\COMPANY;
use \App\SQL;

class Employees Extends SQL  {

    Public $EmployeeList;

    public function GETEmployeesList(){

        $query='SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
			'. TABLE_ERP_EMPLOYEES .'.NOM,
			'. TABLE_ERP_EMPLOYEES .'.PRENOM,
			'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
		FROM `'. TABLE_ERP_EMPLOYEES .'`
		LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`';
        foreach ($this->GetQuery($query) as $data){
            $this->EmployeeList .=  '<option value="'. $data->idUSER .'">'. $data->NOM .' '. $data->PRENOM .' - '. $data->RIGHT_NAME .'</option>';
        }
        return  $this->EmployeeList;
    }
}
