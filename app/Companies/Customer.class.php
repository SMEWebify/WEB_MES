<?php

namespace App\Methods;
use \App\SQL;


class Customer Extends SQL  {

    Public $id;
    Public $CODE;
    Public $NAME;
    Public $WEBSITE;  
    Public $FBSITE;  
    Public $TWITTERITE; 
    Public $LKDSITE;   
    Public $SIREN;
    Public $APE;
    Public $TVA_INTRA;
    Public $TVA_ID;
    Public $LOGO;
    Public $STATU_CLIENT;
    Public $COND_REG_CLIENT_ID;
    Public $MODE_REG_CLIENT_ID;
    Public $REMISE;
    Public $RESP_COM_ID;
    Public $RESP_TECH_ID;
    Public $COMPTE_GEN_CLIENT;
    Public $COMPTE_AUX_CLIENT;
    Public $STATU_FOUR;
    Public $COND_REG_FOUR_ID;
    Public $MODE_REG_FOUR_ID;
    Public $COMPTE_GEN_FOUR;
    Public $COMPTE_AUX_FOUR;
    Public $CONTROLE_FOUR;
    Public $DATE_CREA;
    Public $COMMENT;

    Public $CustomerList;

    public function GETPrestation($id_GET_CUSTOMER){

        $Customer = $this->GetQuery('SELECT * FROM '. TABLE_ERP_CLIENT_FOUR .' WHERE id = \''. $id_GET_CUSTOMER .'\'');
        return $this->$Customer;
    }

    public function GetCustomerList(array $IdData){
        $IdData = explode(",", $IdData);
        $query='SELECT id, NAME   FROM '. TABLE_ERP_CLIENT_FOUR .' WHERE STATU_CLIENT=1 ';

		foreach ($this->GetQuery($query) as $data){
            if(in_array($data->id,$IdData)){
                $checked = 'checked';
            }
            else{
                $checked = '';
            }

			$this->CustomerList .='<option value="'. $data->id .'" '. $checked .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->CustomerList;
    }
}
