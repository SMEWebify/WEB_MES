<?php

namespace App\COMPANY;
use \App\SQL;

class Employees Extends SQL  {

    Public $idUSER;
    Public $CODE;
    Public $NOM;
    Public $PRENOM;
    Public $DATE_NAISSANCE;
    Public $MAIL;
    Public $NUMERO_PERSO;
    Public $NUMERO_INTERNE;
    Public $IMAGE_PROFIL;
    Public $STATU;
    Public $CONNEXION;
    Public $NAME;
    Public $PASSWORD;
    Public $FONCTION;
    Public $SECTION_ID;
    Public $LANGUAGE;
    Public $LABEL_SECTION;

    Public $EmployeeList;

    public function GETEmployeesList($IdData=0, $Select = true){
        $this->EmployeeList = '';
        $query='SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER AS id,
                        '. TABLE_ERP_EMPLOYEES .'.CODE,
                        '. TABLE_ERP_EMPLOYEES .'.NOM,
                        '. TABLE_ERP_EMPLOYEES .'.PRENOM,
                        '. TABLE_ERP_EMPLOYEES .'.CODE,
                        '. TABLE_ERP_EMPLOYEES .'.STATU,
                        '. TABLE_ERP_EMPLOYEES .'.CONNEXION,
                        '. TABLE_ERP_EMPLOYEES .'.NAME,
                        '. TABLE_ERP_EMPLOYEES .'.FONCTION,
                        '. TABLE_ERP_EMPLOYEES .'.SECTION_ID,
                        '. TABLE_ERP_RIGHTS .'.RIGHT_NAME,
                        '. TABLE_ERP_SECTION .'.LABEL AS LABEL_SECTION,
                        CONCAT( '. TABLE_ERP_EMPLOYEES .'.NOM , \' \', '. TABLE_ERP_EMPLOYEES .'.PRENOM , \' \','. TABLE_ERP_SECTION .'.LABEL) AS LABEL
                        FROM `'. TABLE_ERP_EMPLOYEES .'`
                        LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`
                        LEFT JOIN `'. TABLE_ERP_SECTION .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`SECTION_ID` = `'. TABLE_ERP_SECTION .'`.`id`';
         if($Select){
            foreach ($this->GetQuery($query) as $data){
                $this->EmployeeList .=  '<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->NOM .' '. $data->PRENOM .' - '. $data->RIGHT_NAME .'</option>';
            }
            return  $this->EmployeeList;
        }else {
            
            return  $this->GetQuery($query);
            
        }
    }
}
