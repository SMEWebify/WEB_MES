<?php

namespace App\Companies;
use \App\SQL;


class Contact Extends SQL  {

    Public $id;
    Public $ID_COMPANY;
    Public $ORDRE;
    Public $CIVILITE;
    Public $PRENOM;
    Public $NOM;
    Public $FONCTION;
    Public $ADRESSE_ID;
    Public $NUMBER;
    Public $MOBILE;
    Public $MAIL;
    Public $LABEL;

    Public  $ContactList;

    public function GETContact($id_GET){

        $Contact = $this->GetQuery('SELECT '. TABLE_ERP_CONTACT .'.id,
                                            '. TABLE_ERP_CONTACT .'.ID_COMPANY,
                                            '. TABLE_ERP_CONTACT .'.ORDRE,
                                            '. TABLE_ERP_CONTACT .'.CIVILITE,
                                            '. TABLE_ERP_CONTACT .'.PRENOM,
                                            '. TABLE_ERP_CONTACT .'.NOM,
                                            '. TABLE_ERP_CONTACT .'.FONCTION,
                                            '. TABLE_ERP_CONTACT .'.ADRESSE_ID,
                                            '. TABLE_ERP_CONTACT .'.NUMBER,
                                            '. TABLE_ERP_CONTACT .'.MOBILE,
                                            '. TABLE_ERP_CONTACT .'.MAIL,
                                            '. TABLE_ERP_ADRESSE .'.LABEL
                                            FROM `'. TABLE_ERP_CONTACT .'`
                                                LEFT JOIN `'. TABLE_ERP_ADRESSE .'` ON `'. TABLE_ERP_CONTACT .'`.`ADRESSE_ID` = `'. TABLE_ERP_ADRESSE .'`.`id`
                                            WHERE '. TABLE_ERP_CONTACT .'.ID_COMPANY=\''. $id_GET .'\'
                                            ORDER BY ORDRE', true, 'App\Companies\Contact');
        return $Contact;
    }

    public function GETContactList($IdData=0, $Select = true, $ID_COMPANY ){

        $this->ContactList ='';
        $query='SELECT '. TABLE_ERP_CONTACT .'.id,
                        '. TABLE_ERP_CONTACT .'.ID_COMPANY,
                        '. TABLE_ERP_CONTACT .'.ORDRE,
                        '. TABLE_ERP_CONTACT .'.CIVILITE,
                        '. TABLE_ERP_CONTACT .'.PRENOM,
                        '. TABLE_ERP_CONTACT .'.NOM,
                        '. TABLE_ERP_CONTACT .'.FONCTION,
                        '. TABLE_ERP_CONTACT .'.ADRESSE_ID,
                        '. TABLE_ERP_CONTACT .'.NUMBER,
                        '. TABLE_ERP_CONTACT .'.MOBILE,
                        '. TABLE_ERP_CONTACT .'.MAIL,
                        '. TABLE_ERP_ADRESSE .'.LABEL
                        FROM `'. TABLE_ERP_CONTACT .'`
                            LEFT JOIN `'. TABLE_ERP_ADRESSE .'` ON `'. TABLE_ERP_CONTACT .'`.`ADRESSE_ID` = `'. TABLE_ERP_ADRESSE .'`.`id`
                        WHERE '. TABLE_ERP_CONTACT .'.ID_COMPANY=\''. $ID_COMPANY .'\'
                        ORDER BY ORDRE';

        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->ContactList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->PRENOM .' - '. $data->NOM .'</option>';
            }
    
            return  $this->ContactList;
        }else {
            
            return  $this->GetQuery($query);
            
        } 
    }
}