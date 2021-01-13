<?php

namespace App\Companies;
use \App\SQL;


class Address Extends SQL  {

    Public  $AddressList;

    public function GETAddressList($IdData=0, $Select = true, $ID_COMPANY, $Clause='' ){

        $this->AddressList ='';
        $query='SELECT '. TABLE_ERP_ADRESSE .'.id,
                        '. TABLE_ERP_ADRESSE .'.ID_COMPANY,
                        '. TABLE_ERP_ADRESSE .'.ORDRE,
                        '. TABLE_ERP_ADRESSE .'.LABEL,
                        '. TABLE_ERP_ADRESSE .'.ADRESSE,
                        '. TABLE_ERP_ADRESSE .'.ZIPCODE,
                        '. TABLE_ERP_ADRESSE .'.CITY,
                        '. TABLE_ERP_ADRESSE .'.COUNTRY,
                        '. TABLE_ERP_ADRESSE .'.NUMBER,
                        '. TABLE_ERP_ADRESSE .'.MAIL,
                        '. TABLE_ERP_ADRESSE .'.ADRESS_LIV,
                        '. TABLE_ERP_ADRESSE .'.ADRESS_FAC
                        FROM `'. TABLE_ERP_ADRESSE .'`
                        WHERE ID_COMPANY=\''. $ID_COMPANY .'\' '. $Clause .'
                        ORDER BY ORDRE';
                        
        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->AddressList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CITY .' - '. $data->LABEL .'</option>';
            }
    
            return  $this->AddressList;
        }else {
            
            return  $this->GetQuery($query);
            
        } 
    }
}